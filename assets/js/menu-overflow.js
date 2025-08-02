/**
 * Menu Overflow Handler
 * Automatically moves menu items to "More" dropdown when they don't fit
 */

(function() {
    'use strict';

    class MenuOverflowHandler {
        constructor() {
            this.mainMenu = document.querySelector('.main-menu');
            this.moreDropdown = document.querySelector('.more-menu-dropdown');
            this.moreMenuItems = document.querySelector('.more-menu-items');
            this.navbarNavWrapper = document.querySelector('.navbar-nav-wrapper');
            this.searchForm = document.querySelector('.navbar-collapse .d-flex');
            
            this.init();
        }

        init() {
            if (!this.mainMenu || !this.moreDropdown) {
                return;
            }

            // Initial check
            this.checkOverflow();

            // Check on window resize
            window.addEventListener('resize', this.debounce(() => {
                this.checkOverflow();
            }, 250));

            // Initialize Bootstrap dropdown
            this.initBootstrapDropdown();
        }

        initBootstrapDropdown() {
            const moreBtn = document.querySelector('.more-menu-btn');
            if (moreBtn && typeof bootstrap !== 'undefined') {
                // Initialize Bootstrap dropdown
                new bootstrap.Dropdown(moreBtn, {
                    boundary: 'viewport',
                    display: 'dynamic'
                });
            }
        }

        checkOverflow() {
            if (!this.mainMenu || !this.moreDropdown) {
                return;
            }

            // Reset menu items
            this.resetMenuItems();

            // Get all menu items
            const menuItems = Array.from(this.mainMenu.querySelectorAll('.nav-item'));
            
            if (menuItems.length === 0) {
                return;
            }

            // Calculate available space
            const availableWidth = this.getAvailableWidth();
            let currentWidth = 0;
            const visibleItems = [];
            const hiddenItems = [];

            // Check each menu item
            menuItems.forEach((item, index) => {
                const itemWidth = item.offsetWidth;
                
                if (currentWidth + itemWidth <= availableWidth) {
                    visibleItems.push(item);
                    currentWidth += itemWidth;
                } else {
                    hiddenItems.push(item);
                }
            });

            // If we have hidden items, show the more dropdown
            if (hiddenItems.length > 0) {
                this.showMoreDropdown(hiddenItems);
            } else {
                this.hideMoreDropdown();
            }
        }

        getAvailableWidth() {
            if (!this.navbarNavWrapper || !this.searchForm) {
                return 0;
            }

            const wrapperWidth = this.navbarNavWrapper.offsetWidth;
            const searchWidth = this.searchForm.offsetWidth;
            const moreDropdownWidth = this.moreDropdown.offsetWidth || 50; // Approximate width for more button
            
            return wrapperWidth - searchWidth - moreDropdownWidth - 20; // 20px for padding/margins
        }

        showMoreDropdown(hiddenItems) {
            if (!this.moreDropdown || !this.moreMenuItems) {
                return;
            }

            // Show the more dropdown
            this.moreDropdown.style.display = 'block';

            // Clear existing items
            this.moreMenuItems.innerHTML = '';

            // Add hidden items to dropdown
            hiddenItems.forEach(item => {
                const link = item.querySelector('.nav-link');
                if (link) {
                    const dropdownItem = document.createElement('li');
                    dropdownItem.className = 'dropdown-item';
                    
                    const linkClone = link.cloneNode(true);
                    linkClone.classList.remove('nav-link');
                    linkClone.classList.add('dropdown-link');
                    
                    dropdownItem.appendChild(linkClone);
                    this.moreMenuItems.appendChild(dropdownItem);
                }
            });
        }

        hideMoreDropdown() {
            if (this.moreDropdown) {
                this.moreDropdown.style.display = 'none';
            }
        }

        resetMenuItems() {
            if (!this.mainMenu || !this.moreMenuItems) {
                return;
            }

            // Move all items back to main menu
            const dropdownItems = Array.from(this.moreMenuItems.querySelectorAll('.dropdown-item'));
            dropdownItems.forEach(dropdownItem => {
                const link = dropdownItem.querySelector('.dropdown-link');
                if (link) {
                    // Find the original menu item and restore it
                    const originalItem = this.mainMenu.querySelector(`[href="${link.getAttribute('href')}"]`);
                    if (originalItem && originalItem.closest('.nav-item')) {
                        originalItem.closest('.nav-item').style.display = '';
                    }
                }
            });

            // Clear dropdown
            this.moreMenuItems.innerHTML = '';
        }

        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            new MenuOverflowHandler();
        });
    } else {
        new MenuOverflowHandler();
    }

})(); 
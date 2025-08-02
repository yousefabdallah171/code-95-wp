/**
 * ========================================
 * MAIN JAVASCRIPT FILE
 * ========================================
 * 
 * This file contains the main JavaScript functionality for the Code95 theme.
 * It includes the EGY News Slider with infinite loop, touch support,
 * and auto-play functionality with customizable settings.
 * 
 * @package Code95
 * @version 1.0.0
 * 
 * ========================================
 */

jQuery(document).ready(function($) {
    // ========================================
    // EGY NEWS SLIDER OBJECT
    // ========================================
    /**
     * EGY News Slider with True Infinite Loop and Touch Support
     * 
     * This slider provides:
     * - Infinite loop scrolling
     * - Touch/swipe support for mobile devices
     * - Mouse drag support for desktop
     * - Auto-play functionality with pause on hover
     * - Responsive design with dynamic width calculation
     * - Intersection Observer for performance optimization
     */
    const egySlider = {
        // ========================================
        // SLIDER PROPERTIES
        // ========================================
        track: $('#egyNewsSlider'),           // Main slider track element
        wrapper: $('.egy-news-wrapper'),      // Slider wrapper container
        items: $('.egy-news-item'),          // Individual slider items
        currentIndex: 3,                      // Current slide index (starts after 3 cloned items)
        itemWidth: 270,                       // Width of each item including margin
        isDragging: false,                    // Flag for drag state
        startX: 0,                           // Starting X position for drag
        currentX: 0,                         // Current X position during drag
        autoPlayInterval: null,               // Auto-play timer reference
        autoPlaySpeed: 3000,                 // Auto-play speed in milliseconds
        isAutoPlaying: false,                // Auto-play state flag
        isHovered: false,                    // Hover state flag
        resizeTimeout: null,                  // Resize debounce timer
        
        // ========================================
        // INITIALIZATION
        // ========================================
        /**
         * Initialize the slider
         * Sets up the slider, binds events, and starts auto-play
         */
        init: function() {
            // Check if slider exists on page
            if (this.track.length === 0) return;
            
            // Initialize slider components
            this.calculateItemWidth();        // Calculate item dimensions
            this.bindEvents();                // Bind all event listeners
            this.updateButtons();             // Update navigation buttons
            this.setupIntersectionObserver(); // Setup visibility observer
            
            // Set initial position to show first real item (after 3 cloned items)
            this.updateSlider(false);
            
            // Start auto-play after a short delay
            setTimeout(() => {
                this.startAutoPlay();
            }, 1000);
        },
        
        // ========================================
        // DIMENSION CALCULATIONS
        // ========================================
        /**
         * Calculate the actual width of slider items
         * This ensures accurate positioning across different screen sizes
         */
        calculateItemWidth: function() {
            if (this.items.length > 0) {
                const firstItem = this.items.first();
                this.itemWidth = firstItem.outerWidth(true); // Include margins
                console.log('Item width calculated:', this.itemWidth, 'Total items:', this.items.length);
            }
        },
        
        // ========================================
        // EVENT BINDING
        // ========================================
        /**
         * Bind all event listeners for the slider
         * Includes navigation, drag, touch, hover, and resize events
         */
        bindEvents: function() {
            const self = this;
            
            // ========================================
            // NAVIGATION BUTTONS
            // ========================================
            $('.egy-news-section .slider-prev').on('click', function() {
                self.slidePrev();
            });
            
            $('.egy-news-section .slider-next').on('click', function() {
                self.slideNext();
            });
            
            // ========================================
            // MOUSE DRAG EVENTS (DESKTOP)
            // ========================================
            this.track.on('mousedown', function(e) {
                self.startDrag(e.clientX);
            });
            
            $(document).on('mousemove', function(e) {
                if (self.isDragging) {
                    self.drag(e.clientX);
                }
            });
            
            $(document).on('mouseup', function() {
                if (self.isDragging) {
                    self.endDrag();
                }
            });
            
            // ========================================
            // TOUCH EVENTS (MOBILE)
            // ========================================
            this.track.on('touchstart', function(e) {
                e.preventDefault();
                const touch = e.originalEvent.touches[0];
                self.startDrag(touch.clientX);
            });
            
            this.track.on('touchmove', function(e) {
                e.preventDefault();
                if (self.isDragging) {
                    const touch = e.originalEvent.touches[0];
                    self.drag(touch.clientX);
                }
            });
            
            this.track.on('touchend', function(e) {
                e.preventDefault();
                if (self.isDragging) {
                    self.endDrag();
                }
            });
            
            // ========================================
            // HOVER EVENTS FOR AUTO-PLAY
            // ========================================
            $('.egy-news-section').on('mouseenter', function() {
                self.isHovered = true;
                if (self.isAutoPlaying && self.shouldPauseOnHover()) {
                    self.stopAutoPlay();
                }
            }).on('mouseleave', function() {
                self.isHovered = false;
                if (!self.isAutoPlaying && self.shouldAutoPlay()) {
                    self.startAutoPlay();
                }
            });
            
            // ========================================
            // RESIZE HANDLING (DEBOUNCED)
            // ========================================
            $(window).on('resize', function() {
                clearTimeout(self.resizeTimeout);
                self.resizeTimeout = setTimeout(function() {
                    self.handleResize();
                }, 250); // 250ms debounce
            });
        },
        
        // ========================================
        // DRAG FUNCTIONALITY
        // ========================================
        /**
         * Start drag operation
         * @param {number} clientX - Starting X position
         */
        startDrag: function(clientX) {
            this.isDragging = true;
            this.startX = clientX;
            this.currentX = clientX;
            this.track.addClass('dragging');
            this.stopAutoPlay(); // Pause auto-play during drag
        },
        
        /**
         * Handle drag movement
         * @param {number} clientX - Current X position
         */
        drag: function(clientX) {
            this.currentX = clientX;
            const diffX = this.currentX - this.startX;
            const translateX = -this.currentIndex * this.itemWidth + diffX;
            this.track.css('transform', `translate3d(${translateX}px, 0, 0)`);
        },
        
        /**
         * End drag operation and snap to nearest slide
         */
        endDrag: function() {
            this.isDragging = false;
            this.track.removeClass('dragging');
            
            const diffX = this.currentX - this.startX;
            const threshold = this.itemWidth / 3; // 1/3 of item width as threshold
            
            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    this.slidePrev();
                } else {
                    this.slideNext();
                }
            } else {
                // Return to original position if drag wasn't sufficient
                this.updateSlider(false);
            }
            
            // Resume auto-play if enabled
            if (this.shouldAutoPlay()) {
                this.startAutoPlay();
            }
        },
        
        // ========================================
        // SLIDE NAVIGATION
        // ========================================
        /**
         * Slide to previous item
         */
        slidePrev: function() {
            this.currentIndex--;
            this.updateSlider();
            this.checkInfiniteLoop();
        },
        
        /**
         * Slide to next item
         */
        slideNext: function() {
            this.currentIndex++;
            this.updateSlider();
            this.checkInfiniteLoop();
        },
        
        /**
         * Update slider position
         * @param {boolean} animate - Whether to animate the transition
         */
        updateSlider: function(animate = true) {
            const translateX = -this.currentIndex * this.itemWidth;
            
            if (animate) {
                this.track.css('transform', `translate3d(${translateX}px, 0, 0)`);
            } else {
                this.track.css('transform', `translate3d(${translateX}px, 0, 0)`);
            }
            
            this.updateButtons();
        },
        
        /**
         * Check and handle infinite loop transitions
         * Jumps to cloned items when reaching boundaries
         */
        checkInfiniteLoop: function() {
            const totalItems = this.items.length;
            
            // If we're at the cloned last items (last 3 positions), jump to real last items
            if (this.currentIndex >= totalItems - 3) {
                setTimeout(() => {
                    this.currentIndex = 3;
                    this.updateSlider(false);
                }, 300);
            }
            
            // If we're at the cloned first items (first 3 positions), jump to real first items
            if (this.currentIndex <= 2) {
                setTimeout(() => {
                    this.currentIndex = totalItems - 3;
                    this.updateSlider(false);
                }, 300);
            }
        },
        
        /**
         * Update navigation button states
         */
        updateButtons: function() {
            // Remove button limitations for infinite sliding
            $('.egy-news-section .slider-prev').prop('disabled', false);
            $('.egy-news-section .slider-next').prop('disabled', false);
        },
        
        // ========================================
        // AUTO-PLAY FUNCTIONALITY
        // ========================================
        /**
         * Start auto-play functionality
         */
        startAutoPlay: function() {
            if (!this.shouldAutoPlay()) return;
            
            this.stopAutoPlay(); // Clear any existing interval
            
            // Get speed from settings or use default
            const speed = window.code95SliderSettings ? window.code95SliderSettings.autoPlaySpeed : 3000;
            this.autoPlaySpeed = speed;
            
            this.autoPlayInterval = setInterval(() => {
                if (!this.isHovered || !this.shouldPauseOnHover()) {
                    this.slideNext();
                }
            }, this.autoPlaySpeed);
            
            this.isAutoPlaying = true;
            console.log('Auto-play started with speed:', this.autoPlaySpeed);
        },
        
        /**
         * Stop auto-play functionality
         */
        stopAutoPlay: function() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
            this.isAutoPlaying = false;
            console.log('Auto-play stopped');
        },
        
        /**
         * Check if auto-play should be enabled
         * @returns {boolean} Whether auto-play should be active
         */
        shouldAutoPlay: function() {
            const autoPlay = window.code95SliderSettings ? window.code95SliderSettings.autoPlay : true;
            console.log('Should auto-play:', autoPlay);
            return autoPlay;
        },
        
        /**
         * Check if auto-play should pause on hover
         * @returns {boolean} Whether to pause on hover
         */
        shouldPauseOnHover: function() {
            return window.code95SliderSettings ? window.code95SliderSettings.pauseOnHover : true;
        },
        
        // ========================================
        // PERFORMANCE OPTIMIZATION
        // ========================================
        /**
         * Setup Intersection Observer for performance
         * Pauses auto-play when slider is not visible
         */
        setupIntersectionObserver: function() {
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting && this.isAutoPlaying) {
                            this.stopAutoPlay();
                        } else if (entry.isIntersecting && !this.isAutoPlaying && this.shouldAutoPlay()) {
                            this.startAutoPlay();
                        }
                    });
                }, { threshold: 0.1 });
                
                observer.observe(this.track[0]);
            }
        },
        
        /**
         * Handle window resize events
         * Recalculates dimensions and updates slider
         */
        handleResize: function() {
            this.calculateItemWidth();
            this.updateButtons();
        }
    };
    
    // ========================================
    // INITIALIZE SLIDER
    // ========================================
    egySlider.init();
    
    // ========================================
    // GLOBAL ACCESS
    // ========================================
    // Make slider accessible globally for customizer settings
    window.egySlider = egySlider;
}); 
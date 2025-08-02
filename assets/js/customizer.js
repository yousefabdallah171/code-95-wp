/**
 * Customizer JavaScript for Code95 Theme
 * Handles live preview updates for slider settings
 */

(function($) {
    'use strict';
    
    // Initialize slider settings object
    window.code95SliderSettings = {
        autoPlay: true,
        pauseOnHover: true,
        autoPlaySpeed: 3000
    };
    
    // Update slider settings when customizer changes
    wp.customize('code95_egy_news_auto_play', function(value) {
        value.bind(function(newValue) {
            window.code95SliderSettings.autoPlay = newValue;
            
            // Update slider if it exists
            if (window.egySlider) {
                if (newValue) {
                    window.egySlider.startAutoPlay();
                } else {
                    window.egySlider.stopAutoPlay();
                }
            }
        });
    });
    
    wp.customize('code95_egy_news_pause_on_hover', function(value) {
        value.bind(function(newValue) {
            window.code95SliderSettings.pauseOnHover = newValue;
            
            // Update slider if it exists
            if (window.egySlider) {
                // Force re-evaluation of hover state
                if (window.egySlider.isHovered && newValue) {
                    window.egySlider.stopAutoPlay();
                } else if (!window.egySlider.isHovered && window.egySlider.shouldAutoPlay()) {
                    window.egySlider.startAutoPlay();
                }
            }
        });
    });
    
    wp.customize('code95_egy_news_auto_play_speed', function(value) {
        value.bind(function(newValue) {
            window.code95SliderSettings.autoPlaySpeed = newValue * 1000; // Convert to milliseconds
            
            // Update slider speed if it exists
            if (window.egySlider) {
                window.egySlider.autoPlaySpeed = window.code95SliderSettings.autoPlaySpeed;
                if (window.egySlider.isAutoPlaying) {
                    window.egySlider.stopAutoPlay();
                    window.egySlider.startAutoPlay();
                }
            }
        });
    });
    
    // Handle category dropdowns
    $(document).ready(function() {
        // Ensure category dropdowns are properly initialized
        $('select[name*="category"]').each(function() {
            if ($(this).find('option').length <= 1) {
                // If dropdown is empty, try to reload categories
                console.log('Category dropdown empty, attempting to reload...');
            }
        });
    });
    
    // Handle footer text updates
    wp.customize('code95_footer_text', function(value) {
        value.bind(function(newValue) {
            $('#footer-text').html(newValue);
        });
    });
    
    // Handle top stories line color updates
    wp.customize('code95_top_stories_line_color', function(value) {
        value.bind(function(newValue) {
            $('.top-stories-line').css('background-color', newValue);
        });
    });
    
    // Handle main news blue badge color updates
    wp.customize('code95_main_news_blue_badge_color', function(value) {
        value.bind(function(newValue) {
            $('.main-news-blue-badge').css('background-color', newValue);
        });
    });
    
    // Handle main news separator color updates
    wp.customize('code95_main_news_separator_color', function(value) {
        value.bind(function(newValue) {
            $('.main-news-separator').css('background-color', newValue);
            // Update CSS variable for consistency
            document.documentElement.style.setProperty('--code95-main-news-separator-color', newValue);
        });
    });
    
    // Handle EGY news divider color updates
    wp.customize('code95_egy_news_divider_color', function(value) {
        value.bind(function(newValue) {
            $('.egy-news-divider .line').css('background-color', newValue);
            // Update CSS variable for consistency
            document.documentElement.style.setProperty('--code95-egy-news-divider-color', newValue);
        });
    });
    
    // Initialize colors on page load
    $(document).ready(function() {
        // Set initial colors from customizer
        var mainNewsSeparatorColor = wp.customize('code95_main_news_separator_color').get();
        var egyNewsDividerColor = wp.customize('code95_egy_news_divider_color').get();
        
        if (mainNewsSeparatorColor) {
            $('.main-news-separator').css('background-color', mainNewsSeparatorColor);
            document.documentElement.style.setProperty('--code95-main-news-separator-color', mainNewsSeparatorColor);
        }
        
        if (egyNewsDividerColor) {
            $('.egy-news-divider .line').css('background-color', egyNewsDividerColor);
            document.documentElement.style.setProperty('--code95-egy-news-divider-color', egyNewsDividerColor);
        }
    });
    
})(jQuery); 
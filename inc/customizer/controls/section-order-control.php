<?php
/**
 * Custom section order control for the customizer
 *
 * @package Code95
 */

if (class_exists('WP_Customize_Control')) {
    
    class Code95_Section_Order_Control extends WP_Customize_Control {
        
        public $type = 'section_order';
        
        public function enqueue() {
            wp_enqueue_script(
                'code95-section-order-control',
                CODE95_URI . '/assets/js/section-order-control.js',
                array('jquery', 'jquery-ui-sortable'),
                CODE95_VERSION,
                true
            );
            
            wp_enqueue_style(
                'code95-section-order-control',
                CODE95_URI . '/assets/css/section-order-control.css',
                array(),
                CODE95_VERSION
            );
        }
        
        public function render_content() {
            ?>
            <label>
                <?php if (!empty($this->label)) : ?>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php endif; ?>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
                <?php endif; ?>
            </label>
            
            <div class="code95-sortable-sections">
                <?php
                $sections = array(
                    'main-news' => __('Main News', 'code95'),
                    'egy-news' => __('EGY News', 'code95'),
                    'features' => __('Features', 'code95'),
                );
                
                $saved_order = $this->value();
                $ordered_sections = !empty($saved_order) ? explode(',', $saved_order) : array_keys($sections);
                
                foreach ($ordered_sections as $section_id) {
                    if (isset($sections[$section_id])) {
                        ?>
                        <div class="sortable-item" data-section="<?php echo esc_attr($section_id); ?>">
                            <span class="dashicons dashicons-menu"></span>
                            <?php echo esc_html($sections[$section_id]); ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            
            <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
            <?php
        }
    }
} 
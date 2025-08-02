jQuery(document).ready(function($) {
    // Section order control
    $('.code95-sortable-sections').sortable({
        items: '.sortable-item',
        cursor: 'move',
        axis: 'y',
        handle: '.dashicons-menu',
        scrollSensitivity: 40,
        
        update: function(event, ui) {
            const $this = $(this);
            const $input = $this.siblings('input[type="hidden"]');
            const order = [];
            
            $this.find('.sortable-item').each(function() {
                order.push($(this).data('section'));
            });
            
            $input.val(order.join(',')).trigger('change');
        }
    });
}); 
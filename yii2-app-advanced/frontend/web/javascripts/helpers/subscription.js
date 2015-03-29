/**
 * Created by vitaly on 3/29/15.
 */
jQuery(document).ready(
    jQuery('#subscription').on('beforeSubmit', function (event, jqXHR, settings) {
        var form = jQuery(this);
        if (form.find('.has-error').length) {
            return false;
        }

        jQuery.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function (data) {
                form.find('input[type="email"]').val('');
            }
        });
        return false;
    })
);
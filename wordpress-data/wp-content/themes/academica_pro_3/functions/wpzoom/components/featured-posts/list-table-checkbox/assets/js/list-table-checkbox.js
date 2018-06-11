(function ($) {
    $(document).ready(function () {

        var checkboxCallback = function () {

            var $checkbox = $(this).closest('.list-table-checkbox-wrapper').find(':checkbox');

            if ($checkbox.is(":checked")) {
                $(this).removeClass('dashicons-star-filled').addClass('dashicons-star-empty active');
            } else {
                $(this).removeClass('dashicons-star-empty').addClass('dashicons-star-filled active');
            }

            $checkbox.prop('checked', !$checkbox.is(":checked"));
            $checkbox.trigger('change');
        };

        $(".list-table-checkbox").on('change', function (e) {
            e.preventDefault();

            var inputs = {};

            $(this).closest('.list-table-checkbox-wrapper').find(':input').each(function () {

                if ($(this).is(':checkbox')) {
                    inputs[$(this).attr('name')] = $(this).is(':checkbox:checked') ? 1 : 0;
                } else {
                    inputs[$(this).attr('name')] = $(this).val();
                }
            });

            wp.ajax.post(
                'checkbox_list_table',
                inputs
            );
        });

        $('.list-table-checkbox-wrapper .dashicons').on('hover', function (e) {
            $(this).removeClass('active');
        });

        $('.list-table-checkbox-wrapper .dashicons').on('click', function () {
            checkboxCallback.apply(this);
        });
    });
})(jQuery);

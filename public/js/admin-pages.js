/**
 * Created by metallix on 16.23.10.
 */
(function($){
    $(function(){

        CKEDITOR.replace('page-description');

        $('.add-page-modal').on('click', function(e){
            e.preventDefault();

            $('#add-page-modal').openModal({
                    dismissible: true,
                    opacity: .7,
                    complete: function() {

                        // TODO : Reset form
                    }
                }
            );

        });


    });
})(jQuery);
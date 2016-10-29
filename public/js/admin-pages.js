/**
 * Created by metallix on 16.23.10.
 */
(function($){
    $(function(){

        initCkEditor();

        $('.delete-page-btn').on('click', function(e){
            e.preventDefault();

            var pageId = $(this).attr('id');

            $.ajax({
                url : '/admin/pages/delete',
                method : 'POST',
                data : {'pageId' : pageId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Страница успешно удалена', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });

        });


        function initCkEditor()
        {
            var href = location.href;

            if(href.indexOf('add') != -1 || href.indexOf('edit') != -1) {
                CKEDITOR.replace('page-description',{
                    language: 'ru',
                    filebrowserImageUploadUrl: '/uploads/uploadPageImage'
                });
            }

        }

    });
})(jQuery);
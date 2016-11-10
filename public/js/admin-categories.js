/**
 * Created by metallix on 16.23.10.
 */
(function($){
    $(function(){

        initCkEditor();

        $('.delete-category-btn').on('click', function(e){
            e.preventDefault();

            var categoryId = $(this).attr('id');

            $.ajax({
                url : '/admin/categories/delete',
                method : 'POST',
                data : {'categoryId' : categoryId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Категория успешно удалена', 4000, 'top');
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
                CKEDITOR.replace('category-description',{
                    language: 'ru',
                    filebrowserImageUploadUrl: '/uploads/uploadCategoryImage'
                });
            }

        }

    });
})(jQuery);
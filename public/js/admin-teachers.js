(function($){
    $(function(){

        initCkEditor();

        initUpload();

        function initUpload()
        {
            var href = location.href;

            if(href.indexOf('add') != -1 || href.indexOf('edit') != -1) {
                var uploader = new ss.SimpleUpload({
                    button: $('#teacher-photo'), // file upload button
                    url: '/lv/uploads/uploadTeacherPhoto', // server side handler
                    name: 'uploadfile', // upload parameter name
                    responseType: 'json',
                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
                    maxSize: 4096,
                    hoverClass: 'ui-state-hover',
                    focusClass: 'ui-state-focus',
                    disabledClass: 'ui-state-disabled',
                    onSubmit: function(filename, extension) {
                        //   this.setFileSizeBox(sizeBox); // designate this element as file size container
                        // this.setProgressBar(progress); // designate as progress bar
                    },
                    onComplete: function(filename, response) {

                        if (response.filepath !== false)
                        {
                            $('.article-image').attr('src', response.filepath);
                            $('#teacher-photo-path').val(response.filepath);
                        } else {
                            Materialize.toast('Ошибка при добавлении изображения', 4000, 'top');
                        }
                    }
                });
            }
        }


        function initCkEditor()
        {
            var href = location.href;

            if(href.indexOf('add') != -1 || href.indexOf('edit') != -1) {
                CKEDITOR.replace('about',{
                    language: 'ru',
                });
            }
        }


        $('.delete-teacher-btn').on('click', function (e) {
            e.preventDefault();

            var teacherId = $(this).attr('id');

            $.ajax({
                url : '/admin/instructors/delete',
                method : 'POST',
                data : {'teacherId' : teacherId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Успешно удалено', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });
        })
    });
})(jQuery);
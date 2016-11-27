(function($){
    $(function(){

        $('.add-language-modal').on('click', function(e){
            e.preventDefault();

            $('#add-language-modal').openModal({
                    dismissible: true,
                    opacity: .7,
                    complete: function() {
                        var languageAddForm = $('#language-add-form')[0];
                        languageAddForm.reset();
                    }
                }
            );

        });

        $('.submit-language-add').on('click', function(e){
            e.preventDefault();

            var newLanguage = $('#language-add-form').serializeArray();

            $.ajax({
                url : '/admin/languages/addOrEdit',
                method : 'POST',
                data : {'language' : JSON.stringify(newLanguage)},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Новый язык успешно добавлен', 4000, 'top');
                        $('#add-language-modal').closeModal();
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    }
                }
            });

        });

        $('.delete-language-btn').on('click', function(e){
            e.preventDefault();

            var languageId = $(this).attr('id');

            $.ajax({
                url : '/admin/languages/delete',
                method : 'POST',
                data : {'languageId' : languageId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        location.href = location;
                    }
                }
            });
        });

        $('.edit-language-btn').on('click', function(e){
            e.preventDefault();

            var languageId = $(this).attr('id');

            var tr = $(this).parent().parent();

            console.log(tr);

            var id = $(this).attr('id');
            var name =  $(tr).find('td#name')[0].innerText;
            var code =  $(tr).find('td#code')[0].innerText;
            var visible = $(tr).find('td#visible')[0].innerText;

            $('.add-language-modal').click();

            $('#language_name').val(name);
            $('#language_code').val(code);
            $('#language_visible').val(visible);

            $('#lstat').val(id);

            $('select').material_select();

        });


    });
})(jQuery);
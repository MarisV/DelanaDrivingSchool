(function($){
    $(function(){

        // Init CKEditor on new full description field
        CKEDITOR.replace( 'news-full-description' );


        //---------- ADMIN NEWS ---------- //
        $('.add-news-modal').on('click', function(e){
            e.preventDefault();

            openNewsModal();

        });

        // Add new btn handler
        $('.submit-news').on('click', function (e) {
            e.preventDefault();

            var formData = colletcNewsFormData();

            $.ajax({
                url : '/news/add',
                method : 'POST',
                data : {'new' : formData},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Новость успешно добавлена', 4000, 'top');
                        $('#add-news-modal').closeModal();
                        location.href = location;
                    }
                }
            });

        });

        // Delete new btn handler
        $('.delete-new-btn').on('click', function(e){
            e.preventDefault();

            var newId = $(this).attr('id');

            $.ajax({
                url : '/news/delete',
                method : 'POST',
                data : {'newId' : newId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        location.href = location;
                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });
        });



        //Edit new btn handler
        $('.edit-new-btn').on('click', function(e){

            e.preventDefault();

            var newId = $(this).attr('id');

            var encodedNew = '';

            $('#nstat').val(newId);

            $.ajax({
                url : '/news/get',
                method : 'POST',
                data : {id : newId},
                cache: false,
                success : function(response){
                    result = JSON.parse(response);
                    encodedNew = result.newresult;

                    if(encodedNew !== false) {

                        $('#add-news-modal').openModal({
                                dismissible: true,
                                opacity: .7,
                                complete: function() {
                                    var newsForm = $('.add-news-form')[0];
                                    newsForm.reset();
                                }
                            }
                        );

                        if(encodedNew.published === 'on'){
                            $('#published').prop('checked', true);
                        } else {
                            $('#published').prop('checked', false);
                        }

                        $('#title').val(encodedNew.title);
                        $('#news-short-description').val(encodedNew.shortDescription);
                        CKEDITOR.instances['news-full-description'].setData(encodedNew.fullDescription);
                        $('#language-id').val(encodedNew.languageId);
                        $('#news-seo-title').val(encodedNew.seoTitle);
                        $('#news-seo-keywords').val(encodedNew.seoKeywords);
                        $('#news-seo-description').val(encodedNew.seoDescription);

                        $('select').material_select();

                    }
                }
            });

        });


        function openNewsModal()
        {
            $('#add-news-modal').openModal({
                    dismissible: true,
                    opacity: .7,
                    complete: function() {
                        var newsForm = $('.add-news-form')[0];
                        newsForm.reset();
                    }
                }
            );
        }

        function getNewsForm()
        {
            return $('.add-news-form');
        }

        function colletcNewsFormData()
        {
            var newToSave = {
                nstat : $('#nstat').val(),
                title : $('#title').val(),
                shortDescription : $('#news-short-description').val(),
                fullDescription  : CKEDITOR.instances['news-full-description'].getData(),
                languageId       : $('#language-id').val(),
                seoTitle         : $('#news-seo-title').val(),
                seoDescription   : $('#news-seo-description').val(),
                seoKeywords      : $('#news-seo-keywords').val(),
                published        : $('#published').prop('checked'),
                image            : $('.news-image input').val()
            };

            return newToSave;
        }


    });
})(jQuery);
(function($){
  $(function(){

        $('.button-collapse').sideNav();
        $(".classy-editor").ClassyEdit();
        $('select').material_select();
        $('.dropdown-button').dropdown({
              hover: true,
              alignment: 'left'
            }
        );

        $('.add-news-modal').on('click', function(e){
        e.preventDefault();

          $('#add-news-modal').openModal({
                  dismissible: true,
                  opacity: .7,
                  complete: function() {
                      var newsForm = $('.add-news-form')[0];
                      newsForm.reset();
                  }
              }
          );

        });

        // Add new btn handler
        $('.submit-news').on('click', function (e) {
            e.preventDefault();

            var form = $('.add-news-form');
            var formData = form.serializeArray();

            $.ajax({
              url : '/news/add',
              method : 'POST',
              data : {'new' : JSON.stringify(formData)},
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
        })

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
              url : '/languages/addOrEdit',
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
              url : '/languages/delete',
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

            var tr = $(this).parent().parent().parent();

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
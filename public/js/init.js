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
                      location.reload();
                  } else {
                      Materialize.toast(response.result, 4000, 'top');
                  }
              }
          });
        })

  });
})(jQuery);
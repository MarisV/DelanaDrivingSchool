(function($){
  $(function(){

        $('.button-collapse').sideNav();

        $('.dropdown-button').dropdown({
              hover: true,
              alignment: 'left'
            }
        );

      $('.add-news-modal').on('click', function(e){
        e.preventDefault();

        $('#add-news-modal').openModal();

      });

      $(document).ready(function() {
          $('select').material_select();
      });

      $(".classy-editor").ClassyEdit();

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
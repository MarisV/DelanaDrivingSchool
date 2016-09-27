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

      $(".classy-editor").ClassyEdit();

      $('.submit-news').on('click', function (e) {
         e.preventDefault();

          var form = $('.add-news-form');

          var formData = $('.add-news-form').serialize();

          $.ajax({
              url : '/news/add',
              method : 'POST',
              data : {'new' : formData},
              success : function(data){
                  console.log(data);
              }
          });

      });

  });
})(jQuery);
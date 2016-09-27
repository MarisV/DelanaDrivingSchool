(function($){
  $(function(){

    $('.button-collapse').sideNav();

    $('.dropdown-button').dropdown({
          hover: true,
          alignment: 'left'
        }
    );

      $('.add-news-modal').on('click', function(){
         $('#add-news-modal').openModal();
      });

  });
})(jQuery);
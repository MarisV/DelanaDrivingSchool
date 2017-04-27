(function($){
  $(function(){

      //---------- COMMON ---------- //
        $('.button-collapse').sideNav({
            menuWidth: 230,
            edge: 'left',
            draggable: true
        });

        $('.materialboxed').materialbox();

        $('select').material_select();

        $('.dropdown-button').dropdown({
                hover: true,
                alignment: 'left',
                belowOrigin: true
            }
        );

        var answerId = '', pollId = '';

        $('.poll-answer').on('click', function (e) {
            e.preventDefault();

            $(this).find('input:radio').prop('checked', 'true');

             answerId = $(this).find('input:radio').attr('id');

             pollId = $('.poll-container').data('poll-id');
        });
      
      $('.poll-answer-btn').on('click', function (e) {
          e.preventDefault();

          $.ajax({
              url : '/lv/polls/vote',
              method : 'POST',
              data : {'answerId' : answerId, 'pollId' : pollId},
              dataType: "json",
              success : function(response){
                  if(response.result == true){
                      Materialize.toast('Спасибо за голос', 4000, 'top');
                      setTimeout(function(){
                          location.href = location;
                      }, 1000);

                  } else {
                      Materialize.toast('Произошла ошибка при голосовании. Попробуйте еще раз', 7000, 'top');
                  }
              }
          });



      });



  });
})(jQuery);
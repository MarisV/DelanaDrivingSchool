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

        $('.poll-answer').on('click', function (e) {
            e.preventDefault();

            $(this).find('input:radio').prop('checked', 'true');

        })

  });
})(jQuery);
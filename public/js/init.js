(function($){
  $(function(){

      //---------- COMMON ---------- //
        $('.button-collapse').sideNav({
            menuWidth: 240,
            edge: 'left',
//            closeOnClick: true,
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
  });
})(jQuery);
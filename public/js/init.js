(function($){
  $(function(){


      //---------- COMMON ---------- //
        $('.button-collapse').sideNav();
        $('.materialboxed').materialbox();
        $('select').material_select();
        $('.dropdown-button').dropdown({
              hover: true,
              alignment: 'left'
            }
        );
  });
})(jQuery);
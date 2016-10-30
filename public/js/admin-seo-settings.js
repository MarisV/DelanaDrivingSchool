(function($){
    $(function(){

        $('.save-default-site-language').on('click', function(e){
            e.preventDefault();

            var newDefaultSiteLanguageId = $('#site-language-id').val();

            $.ajax({
                url : '/admin/seo/edit_site_language',
                method : 'POST',
                data : {'langId' : newDefaultSiteLanguageId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Язык сайта по умолчанию успешно изменён', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });

        })

    });
})(jQuery);
(function($){
    $(function(){

        $('.delete-application-btn').on('click', function (e) {
            e.preventDefault();

            var applicationId = $(this).attr('id');

            $.ajax({
                url : '/admin/courses/deleteApplication',
                method : 'POST',
                data : {'applicationId' : applicationId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Успешно удалено', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);
                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });

        });

    });
})(jQuery);
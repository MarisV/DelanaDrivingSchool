(function($){
    $(function(){

        $('.delete-feedback-btn').on('click', function (e) {
            e.preventDefault();

            var supportMessageId = $(this).attr('id');

            $.ajax({
                url : '/admin/support/delete',
                method : 'POST',
                data : {'messageId' : supportMessageId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Сообщение успешно удалено', 4000, 'top');
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
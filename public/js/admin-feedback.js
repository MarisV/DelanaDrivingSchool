(function($){
    $(function(){

        $('.delete-feedback-btn').on('click', function (e) {
            e.preventDefault();

            var feedbackId = $(this).attr('id');

            $.ajax({
                url : '/admin/feedback/delete',
                method : 'POST',
                data : {'feedbackId' : feedbackId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Отзыв успешно удалён', 4000, 'top');
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
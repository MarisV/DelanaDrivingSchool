(function($){
    $(function(){

        $('.add-answer').on('click', function (e) {
            var count = $('#answers-container > .row').length;
            e.preventDefault();

            count = count+1;
            var answerInput =
                    '<div class="row">'+
                        '<div class="input-field col s9 m9 l9">'+
                            '<input id="answers" name="answers[]" type="text" class="answers validate">'+
                            '<label for="answers">Ответ - '+count+'</label>'+
                        '</div>'+
                        '<div class="col s3 m3 l3 left-align">'+
                            '<a class="btn-floating btn-medium waves-effect waves-light red delete-answer" href="#"><i class="material-icons">delete</i></a>'+
                        '</div>'+
                    '</div>';
            $(answerInput).hide().appendTo('#answers-container').fadeIn('3000');

            $('.delete-answer').on('click', function (e) {
                e.preventDefault();

                $(this).parent().parent().remove();
            });
        });

        $('.delete-poll-btn').on('click', function (e) {
            e.preventDefault();

            var pollId = $(this).attr('id');

            $.ajax({
                url : '/admin/polls/delete',
                method : 'POST',
                data : {'pollId' : pollId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Опрос успешно удален', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });
        });

        $('.delete-answer').on('click', function (e) {
            e.preventDefault();

            $(this).parent().parent().remove();
        });

    });
})(jQuery);
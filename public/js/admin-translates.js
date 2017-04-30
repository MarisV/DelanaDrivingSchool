(function($){
    $(function() {

        $('td').keypress(function(evt){
            if(evt.which == 13){
                event.preventDefault();
                var cellindex = $(this).index();
                // get next row, then select same cell index
                var rowindex = $(this).parents('tr').index() + 1;
                $(this).parents('table').find('tr:eq('+rowindex+') td:eq('+cellindex+')').focus();

                var keywordId = $(this).data('keyword-id');
                var languageId = $(this).data('language-id');
                var newTranslate = $(this).text().trim();

                $.ajax({
                    url : '/admin/translate/updateTranslate',
                    method : 'POST',
                    data : {'keywordId' : keywordId, 'languageId' : languageId, 'translate' : newTranslate},
                    dataType: "json",
                    success : function(response){
                        if (response.result == true){
                            Materialize.toast('Успешно обновлено', 4000, 'top');
                        } else {
                            Materialize.toast('Ошибка', 4000, 'top');
                        }
                    }
                });
                $(this).blur();
            }
        });
    });
})(jQuery);
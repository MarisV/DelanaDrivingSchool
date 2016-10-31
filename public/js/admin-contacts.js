(function($){
    $(function(){

        $('.add-contact-modal').on('click', function(e){

            e.preventDefault();

            openModal();
        });

        function openModal()
        {
            $('#add-contact-modal').openModal({
                    dismissible: true,
                    opacity: .7,
                    complete: function() {
                        $('#contactValue').val('');
                    }
                }
            );
        }


        $('.submit-contact-add').on('click', function(e){
            e.preventDefault();

            var contactType = $('#contactType').val(); // Selected contact type value
            var contactValue = $('#contactValue').val();

            $.ajax({
                url : '/admin/contacts/add',
                method : 'POST',
                data : {'contactType' : contactType, 'contactValue' : contactValue},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Контактная информация успешно обновлена', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast('Произошла ошибка при добавлении контактной информации. Попробуйте еще раз', 7000, 'top');
                    }
                }
            });
        });


        $('.delete-contact-btn').on('click', function (e) {

            e.preventDefault();

            var contactId = $(this).attr('id');

            $.ajax({
                url : '/admin/contacts/delete',
                method : 'POST',
                data : {'contactId' : contactId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Удалено', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast('Произошла ошибка при удалении. Попробуйте еще раз', 7000, 'top');
                    }
                }
            });


        });




    });
})(jQuery);
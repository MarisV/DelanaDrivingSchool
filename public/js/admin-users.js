(function($){
    $(function(){

//---------- ADMIN USERS---------- //


        $('.add-user-modal').on('click', function(e){

            e.preventDefault();

            $('.password-row').show()
            ;
            openModal();
        });

        $('.submit-user-add').on('click', function(e){

            e.preventDefault();

            var newUser = collectUserFormData();

            $.ajax({
                url : '/users/addOrEdit',
                method : 'POST',
                data : {'user' : newUser},
                dataType: "json",
                success : function(response){

                    if(response.result == true){
                        Materialize.toast('Новый пользователь успешно добавлен', 4000, 'top');
                        $('#add-user-modal').closeModal();
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        setValidationErrors(response.errors);
                    }
                }
            });

        });

        function setValidationErrors(errors)
        {
            $('.validation-errors ul').html('');
            for(var i = 0; i < errors.length; i++)
            {

                $('.validation-errors ul').append('<li>' +capitalizeFirstLetter(errors[i].msg) + '</li>');
            }
        }

        $('.delete-user-btn').on('click', function(e){

            e.preventDefault();

            var userId = $(this).attr('id');

            $.ajax({
                url : '/users/delete',
                method : 'POST',
                data : {'userId' : userId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Пользователь успешно удален', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });
        });

        $('.edit-user-btn').on('click', function(e) {

            e.preventDefault();

            var userId = $(this).attr('id');

            var user = '';

            $.ajax({
                url : '/users/getUser',
                method : 'POST',
                data : {'userId' : userId},
                dataType: "json",
                success : function(response){

                    user = response.result;

                    if (user !== false) {

                        openModal();

                        $('.password-row').hide();

                        $('#ustat').val(user.id);
                        $('#username-add').val(user.username);
                        $('#firstname-add').val(user.firstname);
                        $('#lastname-add').val(user.lastname);
                        $('#email-add').val(user.email);
                        $('#password-add').val(user.password)
                    }

                }
            });


        });


        function openModal()
        {
            $('#add-user-modal').openModal({
                    dismissible: true,
                    opacity: .7,
                    complete: function() {
                        var userAddForm = $('#user-add-form')[0];
                        $('#ustat').val('');
                        userAddForm.reset();
                        $('.validation-errors ul').html('');
                    }
                }
            );
        }

        function collectUserFormData()
        {
            var user = {
                ustat     : $('#ustat').val(),
                username  : $('#username-add').val(),
                firstname : $('#firstname-add').val(),
                lastname  : $('#lastname-add').val(),
                email     : $('#email-add').val(),
                password  : $('#password-add').val()
            };

            return user;
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

    });
})(jQuery);
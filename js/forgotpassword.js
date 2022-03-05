
$(document).ready(function(){
    forgotPasswordButton();
    function forgotPasswordButton(){
        // Restricts input for each element in the set of matched elements to the given inputFilter.
        $("input.user-forgot-password").on("click",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-forgot-password");
            let userForgotEmail = $form.find("input.user-forgot-email").val();
            $.ajax({
                url: "./actions/forgotpassword.php",
                method: "post",
                data:{
                    userForgotPassword:1,
                    userForgotEmail,
                },
                success:function(data){
                    if(data == "user email"){
                        $.ajax({
                            url: "./actions/forgotpassword.php",
                            method: "post",
                            data:{
                                userEmailField:1,
                                email:userForgotEmail,
                            },
                            success:function(data){
                                $("div.container-user-forgot-password").html(data);
                            }
                        });
                    }

                    else{
                        $("body").css("overflow-y","hidden");
                        $.confirm({
                            title: "<p class='text-warning'>Alert</p>",
                            type: "red",
                            content: "no account found linked to the given email",
                            buttons: {
                                ok: function () {
                                    $("body").css("overflow-y","scroll");
                                }
                            }
                        });
                    }
                }
            });
        });
    }

});


$(document).ready(function(){

    const urlPage = $("input#url-page").val();
    userLoginButton();
    function userLoginButton(){
        $("form.user-sign-in").on("submit",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-sign-in");
            let userEmail = $form.find("input.user-email").val();
            let userPassword = $form.find("input.user-password").val();
            let rememberMeCheckBox = $form.find("input#rememberMeCheckBox").is(":checked");
            if(rememberMeCheckBox){

                $.ajax({
                    url: "./actions/signin.php",
                    method: "post",
                    data:{
                        userLogin:1,
                        userEmail,
                        userPassword,
                        rememberMeCheckBox:1,
                    },
                    success:function(data){
                        if(data == "wrong user or password"){ 
                            $.alert({
                                title: "Alert!",
                                type: "red",
                                content: data,
                            });
                        }

                        //when login is successful
                        else if(data == "active"){
                            if(urlPage != ""){
                                window.location.href = urlPage;
                            }
                            else{
                                window.location.href = "./index.php";
                            }
                        }
                    }
                });
            }
            else{
                $.ajax({
                    url: "./actions/signin.php",
                    method: "post",
                    data:{
                        userLogin:1,
                        userEmail,
                        userPassword,
                    },
                    success:function(data){
                        if(data == "wrong user or password"){ 
                            $.alert({
                                title: "Alert!",
                                type: "red",
                                content: data,
                            });
                        }

                        //when login is successful
                        else if(data == "active"){
                            if(urlPage != ""){
                                window.location.href = urlPage;
                            }
                            else{
                                window.location.href = "./index.php";
                            }
                        }
                    }
                });
            }
        });
    }
});

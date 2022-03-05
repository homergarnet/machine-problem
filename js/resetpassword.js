$(document).ready(function(){
    let passwordTextError = 1;
    let retypePasswordTextError = 1;
    resetPasswordChecker();
    function resetPasswordChecker(){
        let userId2 = $("input#user-id-2").val();
        
        let token = $("input#token").val();
        $.ajax({
            url: "./actions/resetpassword.php",
            method: "post",
            data:{
                resetPasswordChecker: 1,
                userId: userId2,
                token,
            },
            success:function(data){
                userId2 = data;
                if(userId2 != 0){
                    $.ajax({
                        url: "./actions/resetpassword.php",
                        method: "post",
                        data:{
                            userResetPasswordField: 1,
                            userId: userId2,
                        },
                        success:function(data){
                            $("div.container-user-reset-password-field").html(data);
                            //userPasswordKeyPress();
                            retypePasswordKeyPress();
                            newUserPasswordKeyPress();
                            resetUserPasswordButton(userId2);
                        }
                    });
                }
                else{
                    //window.location.href="./signin.php";
                }
            }
        });
    }

    function newUserPasswordKeyPress(){
        $("input.user-reset-password").on("input",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-reset-password");
            let userPassword = $form.find("input.user-reset-password").val();
            let userConfirmPassword = $form.find("input.user-reset-confirm-password").val();
            //validate the length
            if ( userPassword.length < 8 ) {
                $("#length").removeClass("valid").addClass("invalid");
            } else {
                $("#length").removeClass("invalid").addClass("valid");
            }
            //validate letter
            if ( userPassword.match(/[A-z]/) ) {
                $("#letter").removeClass("invalid").addClass("valid");
            } else {
                $("#letter").removeClass("valid").addClass("invalid");
            }

            //validate capital letter
            if ( userPassword.match(/[A-Z]/) ) {
                $("#capital").removeClass("invalid").addClass("valid");
            } else {
                $("#capital").removeClass("valid").addClass("invalid");
            }

            //validate number
            if ( userPassword.match(/\d/) ) {
                $("#number").removeClass("invalid").addClass("valid");
            } else {
                $("#number").removeClass("valid").addClass("invalid");
            }
            if(userPassword.match(/[ `!@#$%^&*()_+\-=\[\]{};":"\\|,.<>\/?~]/)){
                $("#special").removeClass("invalid").addClass("valid");
            }
            else{
                $("#special").removeClass("valid").addClass("invalid");
            }
            //if valid password
            if((!userPassword.length < 8 ) &&(userPassword.match(/[A-z]/)) && 
            (userPassword.match(/[A-Z]/)) && (userPassword.match(/\d/)) && 
            (userPassword.match(/[ `!@#$%^&*()_+\-=\[\]{};":"\\|,.<>\/?~]/))){
                passwordTextError = 0;
                $("input.user-reset-password").css("border", "1px solid green");
            }
            else{
                passwordTextError = 1;
                $("input.user-reset-password").css("border", "1px solid red");
            }
            if(userConfirmPassword != userPassword){
                retypePasswordTextError = 1;
                $("input.user-reset-confirm-password").css("border", "1px solid red");
                $("p.confirm-password-error").text("confirm password did not match");
               
            }
            else{
                retypePasswordTextError = 0;
                $("input.user-reset-confirm-password").css("border", "1px solid green");
                $("p.confirm-password-error").text("");
            }
        });
        $("input.user-reset-password").on("focusin",function(e){
            e.preventDefault();
            $("div#user_pswd_info").show();
        });
        $("input.user-reset-password").on("focusout",function(e){
            e.preventDefault();
            $("div#user_pswd_info").hide();
        });
    }
    function retypePasswordKeyPress(){
        $("input.user-reset-confirm-password").on("keyup",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-reset-password");
            let userPassword = $form.find("input.user-reset-password").val();
            let userConfirmPassword = $form.find("input.user-reset-confirm-password").val();
            if(userPassword != userConfirmPassword){
                retypePasswordTextError = 1;
                $("input.user-reset-confirm-password").css("border", "1px solid red");
                $("p.confirm-password-error").text("confirm password did not match");
            }
            else{
                retypePasswordTextError = 0;
                $("input.user-reset-confirm-password").css("border", "1px solid green");
                $("p.confirm-password-error").text("");
            }
        });
    }
    function resetUserPasswordButton(userId2){
        $("input.user-reset-password-button").on("click",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-reset-password");
            let userPassword = $form.find("input.user-reset-password").val();
            if((passwordTextError === 1) || (retypePasswordTextError === 1)){
                $.alert({
                    title: "Alert!",
                    type: "red",
                    content: "fill it up properly",
                });
            }
            else{
                $.ajax({
                    url: "./actions/resetpassword.php",
                    method: "post",
                    data:{
                        resetPasswordUserAccount:1,
                        userPassword,
                        userId: userId2,
                    },
                    success:function(data){
                       
                        $.confirm({
                            title: "Confirm",
                            type: "green",
                            content: "successfully updated account</br>",
                            buttons: {
                                confirm: function () {
                                    window.location.href= "./home.php";
                                }
                            }
                        });  
                    }
                });
            }
        });
    }
});

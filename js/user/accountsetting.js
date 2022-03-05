
$(document).ready(function(){
    const userId = $("input#user-id").val();
    let containerNotification = "";
    let emailTextError = "";
    let passwordTextError = 1;
    let confirmPasswordTextError = 1;
    getUserNotificationCount();// all file
    userPusherJs();//all file
    userNotificationButton();//all file
    userCarretButton();//all file
    getUserAccountSettingField();
    function userPusherJs(){
        // Enable pusher logging - don't include this in production
        //Pusher.logToConsole = true;
        let pusher = new Pusher('d2e24ff059b1db0ad84f', {
        cluster: 'ap1'
        });
        let channel = pusher.subscribe('my-user-notification');
        channel.bind('my-user-notification-event', function(data) {
            getUserNotificationCount();
        });
                // Enable pusher logging - don't include this in production
        //Pusher.logToConsole = true;
        let pusher2 = new Pusher('d2e24ff059b1db0ad84f', {
            cluster: 'ap1'
        });
        let channel2 = pusher2.subscribe('my-user-notification-container');
        channel2.bind('my-user-notification-container-event', function(data) {
            getContainerNotification();
        });
    }
    function getUserNotificationCount(){
        $.ajax({
            url: "../actions/index.php",
            method: "post",
            data:{
                getUserNotificationCount:1,
                userId
            },
            success:function(data){
                if(data != null){
                    $("div.notification-number").html(data);
                }
                else{
                    $("div.notification-number").html("");
                }
            }
        });
    }
    function userNotificationButton(){
        $("button.user-notification-button").on("click",function(e){
            e.preventDefault();
            if(containerNotification == "" || containerNotification == "notification"){
                if(containerNotification == "notification"){
                    containerNotification = "";
                }
                $("div.container-notification").toggleClass("display-none");
            }
            $.ajax({
                url: "../actions/index.php",
                method: "post",
                data:{
                    updateUserNotify:1,
                    userId,
                },
                success:function(data){
                    getUserNotificationCount();
                    if($("div.container-notification").hasClass("display-none")){
                        containerNotification = "";
                    }
                    else{
                        containerNotification = "notification";
                    }
                    $("div.container-notification").html(data);
                    scrollUserNotification();
                }
            });
        });
      }
      function scrollUserNotification(){
        let start = 0;
        let limit = 10;
        let action = "inactive";
        
        function loadUserNotification(start,limit){
            $.ajax({
                url: "../actions/index.php",
                method: "post",
                data:{
                    scrollUserNotification:1,
                    start,
                    limit,
                    userId,
                    isInsideUser:1,
                },
                success:function(data){
                    
                    $("div.user-notification-message").append(data);
    
                    if(data == ""){
                        $("div.load-see-more-button").html("<h2 class = 'text-center'>no results...</h2>");
                        action = "active";
                    }
                    else{
                        //calculate your div size use this to see 
                        //alert($("div.container-notification").height());
                        
                        if($("div.container-notification").height() < 381){
                            $("div.load-see-more-button").html("<h2 class = 'text-center'>no results...</h2>");
                        }
                        else{
                            $("div.load-see-more-button").html("<div class='container'>"+
                              "<div class='row'>"+
                                  "<div class='col text-center'>"+
                                      "<div class='spinner-border' role='status'>"+
                                          "<span class='visually-hidden'>Loading...</span>"+
                                      "</div>"+
                                  "</div>"+
                              "</div>"+
                            "</div>");
                        }
                        action = "inactive";
                    }
                }
            });
        }
        if(action == "inactive"){
            action = "active";
            loadUserNotification(start,limit);
        }
        $("div.container-notification").scroll(function(){
            if($(this).scrollTop() + $(this).height() > $(".load-see-more-button").height() && action == "inactive"){
                action = "active";
                start = start + limit;
                setTimeout(function(){
                    loadUserNotification(start,limit);
                }, 1000);
            }
        });
    }
    function getContainerNotification(){
        $.ajax({
            url: "../actions/index.php",
            method: "post",
            data:{
                getContainerNotification:1,
                userId,
                isInsideUser:1,
            },
            success:function(data){
                $("div.user-notification-message").prepend(data);
            }
        });
    }
    function userCarretButton() {
        $("button.carret-arrow").on("click", function (e) {
          e.preventDefault();
          if (containerNotification == "" || containerNotification == "carret") {
            if (containerNotification == "carret") {
              containerNotification = "";
            }
            $("div.container-notification").toggleClass("display-none");
          }
          $.ajax({
            url: "../actions/user/index.php",
            method: "post",
            data: {
              userCarretField: 1,
            },
            success: function (data) {
              if ($("div.container-notification").hasClass("display-none")) {
                containerNotification = "";
              } else {
                containerNotification = "carret";
              }
              $("div.container-notification").html(data);
            },
          });
        });
    }
    function getUserAccountSettingField(){
        $.ajax({
            url: "../actions/user/accountsetting.php",
            method: "post",
            data:{
                getUserAccountSettingField:1,
                userId,
            },
            success:function(data){
                $("div.container-account-setting").html(data);
                changeEmailButton();
                changePasswordButton();
            }
        });
    }
    function changeEmailButton(){
        $("a.change-email-button").on("click",function(e){
            e.preventDefault();
            $("h5.modal-title").text("Update Email");
            $.ajax({
                url: "../actions/user/accountsetting.php",
                method: "post",
                data:{
                    getChangeEmailField:1,
                    userId,
                },
                success:function(data){
                    $("div.modal-body").html(data);
                    emailTextKeyPress();
                    updateUserEmailButton();
                }
            });  
        });
    }
    function changePasswordButton(){
        $("a.change-password-button").on("click",function(e){
            e.preventDefault();
            $("h5.modal-title").text("Update Password");
            
            $.ajax({
                url: "../actions/user/accountsetting.php",
                method: "post",
                data:{
                    getChangePasswordField:1,
                },
                success:function(data){
                    $("div.modal-body").html(data);
                    userPasswordKeyPress();
                    updateUserPasswordButton();
                }
            });  
        });
    }
    function userPasswordKeyPress(){
        $("input.update-user-new-password").on("input",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.update-user-password");
            let userNewPassword = $form.find("input.update-user-new-password").val();
            let userRetypeNewPassword = $form.find("input.update-user-retype-new-password").val();
            //validate the length
            if ( userNewPassword.length < 8 ) {
                $("#length").removeClass("valid").addClass("invalid");
            } else {
                $("#length").removeClass("invalid").addClass("valid");
            }
            //validate letter
            if ( userNewPassword.match(/[A-z]/) ) {
                $("#letter").removeClass("invalid").addClass("valid");
            } else {
                $("#letter").removeClass("valid").addClass("invalid");
            }

            //validate capital letter
            if ( userNewPassword.match(/[A-Z]/) ) {
                $("#capital").removeClass("invalid").addClass("valid");
            } else {
                $("#capital").removeClass("valid").addClass("invalid");
            }

            //validate number
            if ( userNewPassword.match(/\d/) ) {
                $("#number").removeClass("invalid").addClass("valid");
            } else {
                $("#number").removeClass("valid").addClass("invalid");
            }
            if(userNewPassword.match(/[ `!@#$%^&*()_+\-=\[\]{};":"\\|,.<>\/?~]/)){
                $("#special").removeClass("invalid").addClass("valid");
            }
            else{
                $("#special").removeClass("valid").addClass("invalid");
            }
            //if valid password
            if((!userNewPassword.length < 8 ) &&(userNewPassword.match(/[A-z]/)) && 
            (userNewPassword.match(/[A-Z]/)) && (userNewPassword.match(/\d/)) && 
            (userNewPassword.match(/[ `!@#$%^&*()_+\-=\[\]{};":"\\|,.<>\/?~]/))){
                passwordTextError = 0;
                $("input.update-user-new-password").css("border", "1px solid green");
            }
            else{
                passwordTextError = 1;
                $("input.update-user-new-password").css("border", "1px solid red");
            }
            if(userNewPassword > 16){
                $("input.update-user-new-password").val(userNewPassword.substring(0,16));
            }
            if(userNewPassword > 16){
                $("input.update-user-new-password").val(userNewPassword.substring(0,16));
            }
            
            if(userRetypeNewPassword.length > 16){
                $("input.update-user-retype-new-password").val(userRetypeNewPassword.substring(0,16));
            }
            if(userRetypeNewPassword != userNewPassword){
                confirmPasswordTextError = 1;
                $("input.update-user-retype-new-password").css("border", "1px solid red");
                $("p.confirm-password-error").text("password did not match");
                
            }
            else{
                confirmPasswordTextError = 0;
                $("input.update-user-retype-new-password").css("border", "1px solid green");
                $("p.confirm-password-error").text("");
            }
        });
        $("input.update-user-retype-new-password").on("input",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.update-user-password");
            let userNewPassword = $form.find("input.update-user-new-password").val();
            let userRetypeNewPassword = $form.find("input.update-user-retype-new-password").val();
            //validate the length
            if ( userRetypeNewPassword.length < 8 ) {
                $("#length").removeClass("valid").addClass("invalid");
            } else {
                $("#length").removeClass("invalid").addClass("valid");
            }
            //validate letter
            if ( userRetypeNewPassword.match(/[A-z]/) ) {
                $("#letter").removeClass("invalid").addClass("valid");
            } else {
                $("#letter").removeClass("valid").addClass("invalid");
            }

            //validate capital letter
            if ( userRetypeNewPassword.match(/[A-Z]/) ) {
                $("#capital").removeClass("invalid").addClass("valid");
            } else {
                $("#capital").removeClass("valid").addClass("invalid");
            }

            //validate number
            if ( userRetypeNewPassword.match(/\d/) ) {
                $("#number").removeClass("invalid").addClass("valid");
            } else {
                $("#number").removeClass("valid").addClass("invalid");
            }
            if(userRetypeNewPassword.match(/[ `!@#$%^&*()_+\-=\[\]{};":"\\|,.<>\/?~]/)){
                $("#special").removeClass("invalid").addClass("valid");
            }
            else{
                $("#special").removeClass("valid").addClass("invalid");
            }
            if(userRetypeNewPassword.length > 16){
                $("input.update-user-retype-new-password").val(userRetypeNewPassword.substring(0,16));
            }
            if(userRetypeNewPassword != userNewPassword){
                confirmPasswordTextError = 1;
                $("input.update-user-retype-new-password").css("border", "1px solid red");
                $("p.confirm-password-error").text("password did not match");
                
            }
            else{
                confirmPasswordTextError = 0;
                $("input.update-user-retype-new-password").css("border", "1px solid green");
                $("p.confirm-password-error").text("");
                
            }
        });
        $("input.update-user-new-password").on("focusin",function(e){
            e.preventDefault();
            $("div#user_update_pswd_info").show();
        });
        $("input.update-user-new-password").on("focusout",function(e){
            e.preventDefault();
            $("div#user_update_pswd_info").hide();
        });
    }
    function updateUserPasswordButton(){
        $("input.update-user-password-button").on("click",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.update-user-password");
            let userOldPassword = $form.find("input.update-user-old-password").val();
            let userNewPassword = $form.find("input.update-user-new-password").val();

            if((passwordTextError != 1) &&(confirmPasswordTextError != 1)){
                $.confirm({
                    title: "Confirm update",
                    type: "orange",
                    content: "Are you sure you want to update password? click confirm to proceed",
                    buttons: {
                        confirm: {
                            text: "Confirm",
                            btnClass: "btn-success",
                            columnClass: "col-md-4",
                            action: function(){
                                $.ajax({
                                    url: "../actions/user/accountsetting.php",
                                    method: "post",
                                    data:{
                                        confirmUpdatePassword:1,
                                        userOldPassword,
                                        userNewPassword,
                                        userId,
                                    },
                                    success:function(data){
                                        
                                        if(data == "1"){
                                            $.alert({
                                                title: "Success!",
                                                content: "Successfully updated",
                                                type: "green",
                                                typeAnimated: true,
                                                buttons: {
                                                    confirm: {
                                                        btnClass: "btn-success",
                                                        columnClass: "col-md-4",
                                                        action: function(){
                                                            window.location.href="./accountsetting.php";
                                                        }
                                                     }
                                                }
                                            });
                                        }
                                        else{
                                            $.alert({
                                                title: "Encountered an error!",
                                                content: data,
                                                type: "red",
                                                typeAnimated: true,
                                                buttons: {
                                                    close: {
                                                        btnClass: "btn-default",
                                                        columnClass: "col-md-4",
                                                        action: function(){
                                                            
                                                        }
                                                     }
                                                }
                                            });
                                        }

                                    }
                                }); 
                            }
                        },
                        cancel: {
                            text: "Cancel",
                            btnClass: "btn-danger",
                            columnClass: "col-md-4",
                            action: function () {

                            }
                        }
                    }
                });
            }
            else{
                $.alert({
                    title: "Encountered an error!",
                    content: "fill the fields properly",
                    type: "red",
                    typeAnimated: true,
                    buttons: {
                        close: {
                            btnClass: "btn-default",
                            columnClass: "col-md-4",
                            action: function(){
                                
                            }
                         }
                    }
                });
            }
        });
    }
    function emailTextKeyPress(){
        $("input.update-user-email").on("keyup",function(e){
            e.preventDefault();
            let userEmail = $("input.update-user-email").val();
            let emailValidationExpression = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            $.ajax({
                url: "../actions/user/accountsetting.php",
                method: "post",
                data:{
                    getExistingEmail:1,
                    userId,
                    userEmail,
                },
                success:function(data){
                    
                    if(data === "1"){
                        $("p.email-error").text("this email is already taken");
                        
                    }
                    else if(userEmail.match(emailValidationExpression)){
                        $("p.email-error").text("");
                        
                    }
        
                    else{
                        $("p.email-error").text("invalid email");
                    }
                    //if exist and short not valid email
                    if((data === "1") || (!userEmail.match(emailValidationExpression))){
                        emailTextError = 1;
                        $("input.update-user-email").css("border", "1px solid red");
                    }
                    else{
                        emailTextError = 0;
                        $("input.update-user-email").css("border", "1px solid green");
                    }
                }
            });
        });
    }
    function updateUserEmailButton(){
        $("input.update-user-email-button").on("click",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.edit-user-email");
            let userEmail = $form.find("input.update-user-email").val();
            if(emailTextError != 1){
                $.confirm({
                    title: "Confirm update",
                    type: "orange",
                    content: "Are you sure you want to update email? click confirm to proceed",
                    buttons: {
                        confirm: {
                            text: "Confirm",
                            btnClass: "btn-success",
                            columnClass: "col-md-4",
                            action: function(){
                                $.ajax({
                                    url: "../actions/user/accountsetting.php",
                                    method: "post",
                                    data:{
                                        confirmUpdateEmail:1,
                                        userId,
                                        userEmail,
                                    },
                                    success:function(data){
                                        if(data == "1"){
                                            $.alert({
                                                title: "Success!",
                                                content: "Successfully updated",
                                                type: "green",
                                                typeAnimated: true,
                                                buttons: {
                                                    confirm: {
                                                        btnClass: "btn-success",
                                                        columnClass: "col-md-4",
                                                        action: function(){
                                                            //to hide modal
                                                            $(".open-close-modal").click();
                                                            window.location.href="./accountsetting.php";
                                                        }
                                                     }
                                                }
                                            });
                                        }
                                        else{
                                            $.alert({
                                                title: "Encountered an error!",
                                                content: data,
                                                type: "red",
                                                typeAnimated: true,
                                                buttons: {
                                                    close: {
                                                        btnClass: "btn-default",
                                                        columnClass: "col-md-4",
                                                        action: function(){
                                                            
                                                        }
                                                    }
                                                }
                                            });
                                        }

                                    }
                                }); 
                            }
                        },
                        cancel: {
                            text: "Cancel",
                            btnClass: "btn-danger",
                            columnClass: "col-md-4",
                            action: function () {

                            }
                        }
                    }
                });
            }
            else{
                $.alert({
                    title: "Encountered an error!",
                    content: "fill the fields properly",
                    type: "red",
                    typeAnimated: true,
                    buttons: {
                        close: {
                            btnClass: "btn-default",
                            columnClass: "col-md-4",
                            action: function(){
                                
                            }
                         }
                    }
                });
            }
        });
    }
});
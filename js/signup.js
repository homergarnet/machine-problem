
$(document).ready(function(){

    let imageTextError = 1;
    let emailTextError = 1;
    let displayNameTextError = 1;
    let dateTextError = 1;
    let phoneTextError = 1;
    let passwordTextError = 1;
    let confirmPasswordTextError = 1;
    headerRightButton();
    headerCloseButton();
    userImageChange();
    emailTextKeyPress();
    displayNameKeyPress();
    datePickerCustom();
    dateKeyPress();
    phoneNumberKeyPress();
    userPasswordKeyPress();
    signUpButton();

    function headerRightButton(){
        $("button.header-right").on("click",function(e){
            e.preventDefault();
            $("div.header-mobile").css("transform", "translateX(0)");
           
        });
    }
    function headerCloseButton(){
        $("button.header-close").on("click",function(e){
            e.preventDefault();
            $("div.header-mobile").css("transform", "translate(-100%)");
        });
        $("a.home-mobile").on("click",function(){
    
            $("div.header-mobile").css("transform", "translate(-100%)");
        });
        $("a.plans-and-pricing-mobile").on("click",function(){

            $("div.header-mobile").css("transform", "translate(-100%)");
        });
        $("a.about-mobile").on("click",function(){
   
            $("div.header-mobile").css("transform", "translate(-100%)");
        });
        $("a.contact-us-mobile").on("click",function(){
      
            $("div.header-mobile").css("transform", "translate(-100%)");
        });
    }
    function userImageChange(){
        $("input#files").on("change",function(){
            let file = this.files[0];
            let fileType = file["type"];
            let validImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                imageTextError = 1;
                $("img#myImage").attr("src","./images/system/default-profile.png");
                $("p.user-image-error").text("please select a proper image");
            }
            else if($("input#files").get(0).files.length === 0 ){
                imageTextError = 1;
                $("p.user-image-error").text("please select an image");
            }
            else{
                imageTextError = 0;
                $("p.user-image-error").text("");
            }
        });
    }
    function emailTextKeyPress(){
        $("input.user-email").on("keyup",function(e){
            e.preventDefault();
            let userEmail = $("input.user-email").val();
            let emailValidationExpression = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            $.ajax({
                url: "./actions/signup.php",
                method: "post",
                data:{
                    getExistingEmail:1,
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
                        $("input.user-email").css("border", "1px solid red");
                    }
                    else{
                        emailTextError = 0;
                        $("input.user-email").css("border", "1px solid green");
                    }
                }
            });
        });
    }
    function displayNameKeyPress(){
        $("input.user-display-name").on("keyup",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-sign-up");
            let userDisplayName = $form.find("input.user-display-name").val();
            
            if(userDisplayName == "" || userDisplayName.length < 3){
                displayNameTextError = 1;
                $("input.user-display-name").css("border", "1px solid red");
            }
            else{
                displayNameTextError = 0;
                $("input.user-display-name").css("border", "1px solid green");
            }
        });
    }

    function datePickerCustom(){
        $("#datepicker").datepicker({
            format: "mm/dd/yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            startDate: '-120y',
            endDate: '-18y',
            orientation: "button"
        });
    }
    function dateKeyPress(){
        let dateInput = "";
        $("input.date-input").on("focusin",function(e){
            e.preventDefault();
            dateInput = $("input.date-input").val();
            if(dateInput != ""){
                $("p.date-error").text("");
            }
            else{
                $("p.date-error").text("Select your birth date");
                $("input.date-input").text("0");
            }
            
        });
        $("input.date-input").on("focusout",function(){
            dateInput = $("input.date-input").val();
            if(dateInput != ""){
                $("p.date-error").text("");
                
            }
            else{
                $("p.date-error").text("Select your birth date");
               
            }
        });
        $("input.date-input").on("input",function(e){
            e.preventDefault();
            if(dateInput != ""){
                $("p.date-error").text("");
            }
            else{
                $("p.date-error").text("Select your birth date");
            }
            $(this).val(dateInput);
        });
        $("input.date-input").on("change",function(){
            
            dateInput = $("input.date-input").val();
            if(dateInput != ""){

                $.ajax({
                    url: "./actions/signup.php",
                    method: "post",
                    data:{
                        checkIfDateInputIsGreaterThanToday:1,
                        dateInput,
                    },
                    success:function(data){ 
                        if(data == "1"){
                            dateTextError = 1;
                            $("p.date-error").text("Please input a valid date");
                            $("input.date-input").css("border","1px solid red");
                            
                        }
                        else{
                            dateTextError = 0;
                            $("p.date-error").text("");
                            $("input.date-input").css("border","1px solid green");
                        }
                    }
                });

            }
            else{
                dateTextError = 1;
                $("input.date-input").css("border","1px solid red");
                $("p.date-error").text("Select your birth date");
            }
        });
    }
    function phoneNumberKeyPress(){
        // Restricts input for each element in the set of matched elements to the given inputFilter.
        $("input.user-phone").on("input",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-sign-up");
            let userPhone = $form.find("input.user-phone").val();
            if(userPhone.indexOf(".") !== -1){
                $form.find("input.user-phone").val("");
            }
            this.value = this.value.replace(/[^0-9\.]/g,"");
            if(userPhone.length < 12){
                $.ajax({
                    url: "./actions/signup.php",
                    method: "post",
                    data:{
                        getExistingPhone:1,
                        userPhone,
                    },
                    success:function(data){    
                        if(data === "1"){
                            phoneTextError = 1;
                            $("p.phone-error").text("this phone is already taken");
                            if(userPhone.length > 11){
                                $("input.user-phone").val(userPhone.substring(0,11));
                            }
                            if(userPhone < 0){
                                $("input.user-phone").val("");
                            }
                            if ( userPhone.length <= 10 ) {
                                phoneTextError = 1;
                                $("input.user-phone").css("border", "1px solid red");
                                $("p.phone-error").text("invalid phone");
                        
                            } 
                        }
                        else if(data === "0"){
                            phoneTextError = 0;
                            $("p.phone-error").text("");
                            if(userPhone.length > 11){
                                $("input.user-phone").val(userPhone.substring(0,11));
                            }
                            if(userPhone < 0){
                                $("input.user-phone").val("");
                            }
                            if ( userPhone.length <= 10 ) {
                                phoneTextError = 1;
                                $("input.user-phone").css("border", "1px solid red");
                                $("p.phone-error").text("invalid phone");
                        
                            } else {
                                phoneTextError = 0;
                                $("input.user-phone").css("border", "1px solid green");
                                $("p.phone-error").text("");
                            }
                        }
                    }
                });
            }
            else{
                $("input.user-phone").val(userPhone.substring(0,11));
            }
        });
    }
    function userPasswordKeyPress(){
        $("input.user-password").on("keyup",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-sign-up");
            let userPassword = $form.find("input.user-password").val();
            let userConfirmPassword = $form.find("input.user-confirm-password").val();
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
                $("input.user-password").css("border", "1px solid green");
            }
            else{
                passwordTextError = 1;
                $("input.user-password").css("border", "1px solid red");
            }
            if(userPassword > 16){
                $("input.user-password").val(userPassword.substring(0,16));
            }
            if(userPassword > 16){
                $("input.user-password").val(userPassword.substring(0,16));
            }
            
            if(userConfirmPassword.length > 16){
                $("input.user-confirm-password").val(userConfirmPassword.substring(0,16));
            }
            if(userConfirmPassword != userPassword){
                confirmPasswordTextError = 1;
                $("input.user-confirm-password").css("border", "1px solid red");
                $("p.confirm-password-error").text("password did not match");
               
            }
            else{
                confirmPasswordTextError = 0;
                $("input.user-confirm-password").css("border", "1px solid green");
                $("p.confirm-password-error").text("");
            }
        });
        $("input.user-confirm-password").on("keyup",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-sign-up");
            let userPassword = $form.find("input.user-password").val();
            let userConfirmPassword = $form.find("input.user-confirm-password").val();
            if(userConfirmPassword.length > 16){
                $("input.user-confirm-password").val(userConfirmPassword.substring(0,16));
            }
            if(userConfirmPassword != userPassword){
                confirmPasswordTextError = 1;
                $("input.user-confirm-password").css("border", "1px solid red");
                $("p.confirm-password-error").text("password did not match");
               
            }
            else{
                confirmPasswordTextError = 0;
                $("input.user-confirm-password").css("border", "1px solid green");
                $("p.confirm-password-error").text("");
               
            }
        });
        $("input.user-password").on("focusin",function(e){
            e.preventDefault();
            $("div#pswd_info").show();
        });
        $("input.user-password").on("focusout",function(e){
            e.preventDefault();
            $("div#pswd_info").hide();
        });

    }
    function userSignUpValidation(){
        if(imageTextError === 1){
 
            $("p.user-image-error").text("please select an image");
        }
        else{
            $("p.user-image-error").text("");
        }
        if(emailTextError === 1){
            $("input.user-email").css("border", "1px solid red");
        }
        else{
            $("input.user-email").css("border", "1px solid green");
        }
        if(displayNameTextError === 1){
            $("input.user-display-name").css("border", "1px solid red");
        }
        else{
            $("input.user-display-name").css("border", "1px solid green");
        }

        if(dateTextError === 1){
            $("input.date-input").css("border", "1px solid red");
        }
        else{
            $("input.date-input").css("border", "1px solid green");
        }
        if(phoneTextError === 1){
            $("input.user-phone").css("border", "1px solid red");
        }
        else{
            $("input.user-phone").css("border", "1px solid green");
        }
        if(passwordTextError === 1){
            $("input.user-password").css("border", "1px solid red");
        }
        else{
            $("input.user-password").css("border", "1px solid green");
        }
        if(confirmPasswordTextError === 1){
            $("input.user-confirm-password").css("border", "1px solid red");
        }
        else{
            $("input.user-confirm-password").css("border", "1px solid green");
        }
    }
    function signUpButton(){
        $("form.user-sign-up").on("submit",function(e){
            e.preventDefault();
            let $form = $(this).closest("form.user-sign-up");
            $form.find("input.user-sign-up-hidden").val("true");
            let fd = new FormData(this);
            /* to append in FormData here is the syntax:
                fd.append("name",name);
            */
            userSignUpValidation();
            //e.stopImmediatePropagation();
            if((emailTextError === 1) || (displayNameTextError === 1) ||
            (dateTextError === 1) ||
            (phoneTextError === 1) || (passwordTextError === 1) || (confirmPasswordTextError === 1) || 
            (imageTextError === 1)){ 
                $.alert({
                    title: "Alert!",
                    content: "fill it up properly",
                    type: "red",
                });
            }
            else{

                $.ajax({
                    url: "./actions/signup.php",
                    method: "post",
                    data:fd,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $.confirm({
                            title: "Confirm",
                            type: "green",
                            content: "successfully created account",
                            buttons: {
                                confirm: function () {
                                    window.location.href= "./signin.php";
                                }
                            }
                        });
                    }
                });
            }
        });
    }
});
function showImage(){
    if(this.files && this.files[0]){
        let obj = new FileReader();
        const file = this.files[0];
        const  fileType = file['type'];
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {
            
        }
        else{
            obj.onload = function(data){
                var image = document.getElementById("myImage");
                image.src = data.target.result;
            }
            obj.readAsDataURL(this.files[0]);
        }

    }
}
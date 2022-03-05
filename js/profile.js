
$(document).ready(function(){
    const userId = $("input#user-id").val();
    const profileId = $("input#profile-id").val();
    let displayNameTextError = 0;
    let dateTextError = 0;
    let phoneTextError = 0;
    let containerNotification = "";
    getUserNotificationCount();// all file
    userPusherJs();//all file
    userNotificationButton();//all file
    userCarretButton();//all file
    getProfileById();

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
      let pusher3 = new Pusher('d2e24ff059b1db0ad84f', {
        cluster: 'ap1'
      });
      let channel3 = pusher3.subscribe('comment-box-id-number');
      channel3.bind('comment-box-id-number-event', function(data) {
          commentBoxContainerUpdate(data.user_post_id,data.comment_box_id_number);
      });
    }
    function getUserNotificationCount(){
      $.ajax({
          url: "./actions/index.php",
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
    function getContainerNotification(){
      $.ajax({
          url: "./actions/index.php",
          method: "post",
          data:{
              getContainerNotification:1,
              userId,
          },
          success:function(data){
              $("div.user-notification-message").prepend(data);
          }
      });
    }
    function commentBoxContainerUpdate(userPostId,boxContainer){
        $.ajax({
          url: "./actions/index.php",
          method: "post",
          data:{
              getPostCommentById:1,
              userPostId,
              userId,
          },
          success:function(data){

              $("div#h"+boxContainer).html(data);
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
              url: "./actions/index.php",
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
              url: "./actions/index.php",
              method: "post",
              data:{
                  scrollUserNotification:1,
                  start,
                  limit,
                  userId,
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
            url: "./actions/index.php",
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
    function getProfileById(){
      $.ajax({
        url: "./actions/profile.php",
        method: "post",
        data: {
          getProfileById: 1,
          userId,
          profileId,
        },
        success: function (data) {
          $("div.profile-container").html(data);
          
          editProfileButton();
          displayAllStoryByIdScroll();
        },
      });
    }
    function editProfileButton(){
      $("button.edit-profile").on("click", function (e) {
        e.preventDefault();
        $("h5.modal-title-2").text("Edit Profile");
        $.ajax({
          url: "./actions/profile.php",
          method: "post",
          data: {
            editProfileById: 1,
            userId,
            profileId,
          },
          success: function (data) {
            $("div.modal-body-2").html(data);
            datePickerCustom();
            dateKeyPress();
            displayNameKeyPress();
            phoneNumberKeyPress();
            updateProfileButton();
          },
        });
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
                  url: "./actions/profile.php",
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
    function displayNameKeyPress(){
      $("input.user-display-name").on("keyup",function(e){
          e.preventDefault();
          let $form = $(this).closest("form.edit-profile");
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
    function phoneNumberKeyPress(){
      // Restricts input for each element in the set of matched elements to the given inputFilter.
      $("input.user-phone").on("input",function(e){
          e.preventDefault();
          let $form = $(this).closest("form.edit-profile");
          let userPhone = $form.find("input.user-phone").val();
          if(userPhone.indexOf(".") !== -1){
              $form.find("input.user-phone").val("");
          }
          this.value = this.value.replace(/[^0-9\.]/g,"");
          if(userPhone.length < 12){
                $.ajax({
                  url: "./actions/profile.php",
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
    function editProfileValidation(){
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
    }
    function updateProfileButton(){
      $("form.edit-profile").on("submit",function(e){
        e.preventDefault();
        let $form = $(this).closest("form.edit-profile");
        $form.find("input.edit-profile-hidden").val("true");
        let fd = new FormData(this);
        fd.append("userId", userId);
        editProfileValidation();
        /* 
          to append in FormData here is the syntax:
          fd.append("name",name);
        */
        if((displayNameTextError === 1) ||
        (dateTextError === 1) ||
        (phoneTextError === 1)){
          $.alert({
              title: "Alert!",
              content: "fill it up properly",
              type: "red",
          });
        }
        else{
            $.ajax({
                url: "./actions/profile.php",
                method: "post",
                data: fd,
                contentType: false,
                processData: false,
                success: function (data) {
                    $.confirm({
                    title: "Confirm",
                    type: "green",
                    content: "Successfully inserted",
                    buttons: {
                        confirm: function () {
                        window.location.href = "./profile.php?profile_id="+userId;
                        },
                    },
                    });
                },
            });
        }
      });
    }
    function displayAllStoryByIdScroll() {
        let start = 0;
        let limit = 2;
        let action = "inactive";
        function displayAllStory(start, limit) {
          $.ajax({
            url: "./actions/profile.php",
            method: "post",
            data: {
              displayAllStoryByIdScroll: 1,
              userId,
              profileId,
              start,
              limit,
            },
            success: function (data) {
              $("div.profile-container").append(data);
              removePostButton();
              viewMoreCommentButton();
              removeCommentButton();
              postCommentOnEnter();
              if (data == "") {
                action = "active";
                $("div.spinner-border-window").addClass("display-none");
              } else {
                action = "inactive";
                $("div.spinner-border-window").removeClass("display-none");
              }
            },
          });
        }
        if (action == "inactive") {
          action = "active";
          displayAllStory(start, limit);
        }
        $(window).scroll(function () {
          //alert($(document).height());
          if(
            $(this).scrollTop() >= ($(document).height() - $(window).height()-100) &&
            action == "inactive"
          ){
            action = "active";
            start = start + limit;
            setTimeout(function () {
              displayAllStory(start, limit);
            }, 1000);
          }
        });
    }
    function removePostButton(){
        $("a.remove-post").on('click', function (e) {
            e.preventDefault();
            let userPostId = $(this).attr("id");
            $.confirm({
              title: "Confirmation",
              type: "orange",
              content: "Are you sure you want to remove this post? click confirm to proceed",
              buttons: {
                  confirm: {
                      text: "Confirm",
                      btnClass: "btn-success",
                      columnClass: "col-md-4",
                      action: function(){
                        $.ajax({
                          url: "./actions/profile.php",
                          method: "post",
                          data: {
                            removePostById: 1,
                            userPostId,
                            userId,
                          },
                          success: function (data) {
                              $("div#userPostContainer"+userPostId).remove();
                              $("div#commentCard"+userPostId).remove();
                              $("div#h"+userPostId).remove();
                              $("div#commentTextArea"+userPostId).remove();
                          },
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
        });
    }
    function viewMoreCommentButton(){
      let action = "inactive";
      let start = 5;
      let limit = 5;
      $("a.view-more-comment").on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        let $form = $(this).closest("form.view-more-comment");
        let userPostId = $form.find("input.user-post-id").val();
        if(action == "inactive"){
          $.ajax({
            url: "./actions/profile.php",
            method: "post",
            data: {
              viewMoreCommentById: 1,
              userPostId,
              start,
              limit,
              userId,
            },
            success: function (data) {
              if(data == ""){
                action == "active";
                $form.find("div.view-more-comment-container").remove();
              }
              else{
                $("div#h"+userPostId).append(data);
                start+= 5;
                action == "inactive";
              }
            },
          });
        }
        else{
          //do nothing
        }
      });
    }
    function removeCommentButton(){
      $("a.remove-comment").on('click', function (e) {
          e.preventDefault();
          e.stopPropagation();
          e.stopImmediatePropagation();
          let $form = $(this).closest("form.remove-comment");
          let userCommentId = $form.find("input.user-comment-id").val();
          $.confirm({
            title: "Confirmation",
            type: "orange",
            content: "Are you sure you want to remove this comment? click confirm to proceed",
            buttons: {
                confirm: {
                    text: "Confirm",
                    btnClass: "btn-success",
                    columnClass: "col-md-4",
                    action: function(){
                      $.ajax({
                        url: "./actions/profile.php",
                        method: "post",
                        data: {
                          removeCommentById: 1,
                          userCommentId,
                        },
                        success: function (data) {
                            $("div#userCommentId"+userCommentId).remove();
                        },
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

      });
    }
    function postCommentOnEnter(){
        $("textarea.post-comment").on('keyup', function (e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          let $form = $(this).closest("form.post-comment");
          $form.find("input.post-comment-hidden-hidden").val("true");
          let userPostId = $form.find("input.user-post-id").val();
          let postComment = $form.find("textarea.post-comment").val();
          let commentBoxId = $form.find("input.comment-box-id").val();
          //when user click enter without shift key
          if (e.keyCode === 13 &&  !e.shiftKey && postComment != "" && postComment.replace(/\s/g, '').length) {
            
            $.ajax({
              url: "./actions/profile.php",
              method: "post",
              data: {
                insertPostComment: 1,
                userId,
                userPostId,
                postComment,
       
              },
              success: function (data) {
                $form.find("textarea.post-comment").val("");
                $.ajax({
                  url: "./actions/profile.php",
                  method: "post",
                  data: {
                    getPostCommentById: 1,
                    userPostId,
                    userId,
                  },
                  success: function (data) {
                    $("div#h"+commentBoxId).html(data);
                    removeCommentButton();
                  },
                });
              },
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

$(document).ready(function(){
    const userId = $("input#user-id").val();
    const notificationId = $("input#notification-id").val();
    const postId = $("input#post-id").val();
    let containerNotification = "";
    getUserNotificationCount();// all file
    userPusherJs();//all file
    userNotificationButton();//all file
    userCarretButton();//all file
    updateSeenNotificationById();
    getUserPostById();
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
    function userCarretButton(){
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
    function updateSeenNotificationById(){
        $.ajax({
            url: "./actions/userpost.php",
            method: "post",
            data: {
                updateSeenNotificationById: 1,
                notificationId
            },
            success: function (data) {
              
            },
        });
    }
    function getUserPostById(){
        $.ajax({
            url: "./actions/userpost.php",
            method: "post",
            data: {
                getUserPostById: 1,
                postId,
                userId
            },
            success: function (data) {
              $("div.user-post-container").html(data);
              removePostButton();
              viewMoreCommentButton();
              removeCommentButton();
              postCommentOnEnter();
            },
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
                            url: "./actions/userpost.php",
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
            url: "./actions/userpost.php",
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
                          url: "./actions/userpost.php",
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
              url: "./actions/userpost.php",
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
                  url: "./actions/userpost.php",
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

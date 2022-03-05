
$(document).ready(function(){
    const userId = $("input#user-id").val();
    const profileSearch = $("input#profile-search").val();
    let containerNotification = "";
    headerRightButton();
    headerCloseButton();
    searchProfile();
    getProfileBySearch();//all file
    getUserNotificationCount();// all file
    userPusherJs();//all file
    userNotificationButton();//all file
    userCarretButton();//all file
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
    function searchProfile(){
        $("input.search-profile").on('keyup', function (e) {
          e.preventDefault();
          let searchProfile = $(this).val();
          
          setTimeout(function(){
            if (e.keyCode === 13 ) {
              window.location.href="profilesearch.php?profile_search="+searchProfile;
            }
        }, 200);
        });
    }
    function getProfileBySearch(){

      $.ajax({
        url: "./actions/profilesearch.php",
        method: "post",
        data:{
            getProfileBySearch:1,
            profileSearch,
            userId,
        },
        success:function(data){
            if(data != null){
                $("div.main-content").html(data);
            }
            else{
                $("div.main-content").html("");
            }
        }
      });
    }
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

    function scrollUserNotification(){
      let start = 0;
      let limit = 10;
      let action = "inactive";
      let loadingVisible = false;
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
                      $("div.spinner-border").addClass("display-none");
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
                                    "<div class='spinner-border display-none' role='status'>"+
                                        "<span class='visually-hidden'>Loading...</span>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                          "</div>");
                      }
                      action = "inactive";
                      if(loadingVisible == true){
                        $("div.spinner-border").removeClass("display-none");
                      }
                      loadingVisible = true;
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
  });
  
<?php
  // include "update_dir_GA_IMD.php";
  // if($conn){
  //   ftp_login($conn,$ftp_user,$ftp_pass);
  //   remove_dir($date);
  // }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Askbootstrap">
  <meta name="author" content="Askbootstrap">
  <title>Food Slide<?php echo $_GET['code'] ?></title>
  <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="img/favicon.png">
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 100%;
    height: 100%;
  }
  </style>

</head>
<body>
<!-- <body onload="funcAlert();"> -->
<input id="code" type="hidden" value="<?php echo $_GET['code'] ?>">
<div id="demo" class="carousel slide" data-ride="carousel" data-interval="5000">

  <!-- Indicators -->
  <div id="slide-click"></div>

  </ul>


  <!-- The slideshow -->
  <div class="carousel-inner">
    <div id="slide-img"></div>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

<script>

// var wscript = new ActiveXObject("WScript.Shell");

$('.carousel').carousel({
    pause: "false"
});

$(function(){
 // wscript.SendKeys("{F11}");

  var code= $('#code').val()
  setInterval(function(){
    console.log("<= counter");
  },1000)

if(code == 'STTB_1' || code == 'STTC_1' || code == 'STTC_2')
    load_img(code)
a = 0
$.get('load_image.php?code='+ code, function(data) {
    var result = $.parseJSON(data)

    setInterval(function(){
      ++a
    load_img(code)
    console.log("timing => "+a)
    // wscript.SendKeys("{F11}")
    }, 5000*result.timing-5000)
    var fill_list = '<ul class="carousel-indicators">'
              + '<li data-target="#demo" data-slide-to="0" class="active"></li>'
              for ( var i = 0; i < result.timing; i++ ) {
                fill_list += '<li data-target="#demo" data-slide-to="'+(i+1)+'"></li>'
              }
              fill_list += '</ul>'
    //$('#slide-click').html('')
    $('#slide-click').append(fill_list)

  })

  

  function makeid(length) {
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < length; i++ ) {
          result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result;
  }

  function load_img(code){
            var fill_div = ""
            var i = 0
                    $.get("load_image.php?code=" + code , function(data) {
                        var result = $.parseJSON(data);
                        var fill_li = '<a href="food_slide.php?code='+code+'" target="_blank"><ul>'
                        if(result.status_cuernt_dir == 0 && result.status_server_dir == 0) { 
                            $.each(result.default_images_files,function(key, img) {
                                if(img != "." && img != ".."){
                                  if(i == 0){
                                  fill_div += '<div class="carousel-item active">'
                                  fill_div += '<img src='+result.defualt_dir+'/'+img+ '?img=' + makeid(5) + ' alt="Los Angeles" width="1100" height="500">'
                                  fill_div += '</div>'
                                  i=1
                                }else{
                                  fill_div += '<div class="carousel-item">'
                                  fill_div += '<img src='+result.defualt_dir+'/'+img+ '?img=' + makeid(5) + ' alt="Los Angeles" width="1100" height="500">'
                                  fill_div += '</div>'
                                }
                              }
                            })  
                        }else{
                            $.each(result.images_files,function(key, img) {
                                if(img != "." && img != ".."){
                                  if(i == 0){
                                  fill_div += '<div class="carousel-item active">'
                                  fill_div += '<img src='+result.current_dir+'/'+img+ '?img=' + makeid(5) + ' alt="Los Angeles" width="1100" height="500">'
                                  fill_div += '</div>'
                                  i=1
                                }else{
                                  fill_div += '<div class="carousel-item">'
                                  fill_div += '<img src='+result.current_dir+'/'+img+ '?img=' + makeid(5) + ' alt="Los Angeles" width="1100" height="500">'
                                  fill_div += '</div>'
                                }
                                }
                            })

                        }
                        $('#slide-img').html('')
                        $('#slide-img').append(fill_div)
                    })
        }
})


    //   document.addEventListener("keypress", function(e) {
    //     if (e.keyCode) {
    //       toggleFullScreen();
    //       console.log("clicked");
    //     }
    //   }, false)

    //   function funcAlert() {
    //     alert("Page is loaded");
    //   }

    //   function toggleFullScreen() {
    //     if (!document.fullscreenElement) {
    //         document.documentElement.requestFullscreen();
    //     } else {
    //       if (document.exitFullscreen) {
    //         document.exitFullscreen(); 
    //       }
    //     }
    //   }

    // var mybrowser=navigator.userAgent;
    // if(mybrowser.indexOf('Chrome')>0){
    //   // toggleFullScreen();
    // }else{
      
    //   if (wscript !== null) {
    //       wscript.SendKeys("{F11}");
    //   }
    // }  
    
</script>

</body>
</html>

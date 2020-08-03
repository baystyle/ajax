<?php 
include_once "body/head_and _left.php"; 
?>
<style>
#slider, #slider2, #slider3 {
  position: relative;
  overflow: hidden;
  margin: 20px auto 0 auto;
  border-radius: 4px;
  width: 100% !important;
  height: 300px !important;
}

#slider ul, #slider2 ul, #slider3 ul {
    position: relative;
    margin: 0;
    padding: 0;
    height: 260px;
    list-style: none;
    margin-left: 0 !important;
    width: 100% !important;
}

#slider ul li, #slider2 ul li, #slider3 ul li {
    position: relative;
    display: block;
    float: left;
    margin: 0;
    padding: 0;
    width: 100%;
    height: auto;
    background: #494949;
    text-align: center;
    line-height: 250px;
}

a.control_prev, a.control_next, a.control_prev2, a.control_next2, a.control_prev3, a.control_next3 {
  position: absolute;
  top: 40%;
  z-index: 999;
  display: block;
  padding: 4% 3%;
  width: auto;
  height: auto;
  background: #2a2a2a;
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  opacity: 0.8;
  cursor: pointer;
}

a.control_prev:hover, a.control_next:hover, a.control_prev2:hover, a.control_next2:hover, a.control_prev3:hover, a.control_next3:hover {
  opacity: 1;
  -webkit-transition: all 0.2s ease;
}

a.control_prev, a.control_prev2, a.control_prev3 {
  border-radius: 0 2px 2px 0;
}

a.control_next, a.control_next2, a.control_next3 {
  right: 0;
  border-radius: 2px 0 0 2px;
}

.slider_option {
  position: relative;
  margin: 10px auto;
  width: 160px;
  font-size: 18px;
}
@media (max-width: 1600px){
    #slider, #slider2, #slider3 {
        height: 250px !important;
    }
}

</style>

    <div id="content-wrapper">
    <div class="container-fluid pb-0" style="min-height: 1500px;">
        <div class="video-block section-padding">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-title">
                        <h6>Food</h6>               
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <h2>Chonburi Canteen I</h2>
                    <div id="slider">
                        <a href="#" class="control_next">></a>
                        <a href="#" class="control_prev"><</a>
                        <div id="STTC_1"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <h2>Chonburi Canteen II</h2>
                    <div id="slider2">
                        <a href="#" class="control_next2">></a>
                        <a href="#" class="control_prev2"><</a>
                        <div id="STTC_2"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <h2>Bangkadi Canteen I</h2>
                    <div id="slider3">
                        <a href="#" class="control_next3">></a>
                        <a href="#" class="control_prev3"><</a>
                        <div id="STTB_1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include_once "body/footer.php"; ?>

<script>

    $(function(){

        function update_page(){
            load_img('STTB_1')
            load_img('STTC_1')
            load_img('STTC_2')
        }
        update_page()
    
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
            
            $.get("load_image.php?code=" + code , function(data) {

                var result = $.parseJSON(data);
                var fill_li = '<a href="food_slide.php?code='+code+'" target="_blank"><ul>'
                if(result.status_cuernt_dir == 0 && result.status_server_dir == 0) { 
                    $.each(result.default_images_files,function(key, img) {
                        if(img != "." && img != "..")
                        fill_li += '<li><img src='+result.defualt_dir+'/'+img+ '?img=' + makeid(5) + ' style="width: 100%;"></li>'
                    })     
                    

                }else{
                   
                    $.each(result.images_files,function(key, img) {
                        if(img != "." && img != "..")
                        fill_li += '<li><img src='+result.current_dir+'/'+img+ '?img=' + makeid(5) + ' style="width: 100%;"></li>'
                    })                                     

                }

                fill_li +='</ul></a>'
                $("#"+code).append(fill_li);

                
            })

        }

    })

    jQuery(document).ready(function ($) {

        setTimeout(function(){
        window.location.reload(1);
        }, 1800000);

        

        setInterval(function () {moveRight();}, 3000);
        setInterval(function () {moveRight2();}, 3000);
        setInterval(function () {moveRight3();}, 3000);

        var slideCount = $('#slider ul li').length;
        var slideWidth = $('#slider ul li').width();
        var slideHeight = $('#slider ul li').height();
        var sliderUlWidth = slideCount * slideWidth;

        var slideCount2 = $('#slider2 ul li').length;
        var slideWidth2 = $('#slider2 ul li').width();
        var slideHeight2 = $('#slider2 ul li').height();
        var sliderUlWidth2 = slideCount2 * slideWidth2;

        var slideCount3 = $('#slider3 ul li').length;
        var slideWidth3 = $('#slider3 ul li').width();
        var slideHeight3 = $('#slider3 ul li').height();
        var sliderUlWidth3 = slideCount3 * slideWidth3;
        
        $('#slider').css({ width: slideWidth, height: slideHeight });
        
        $('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
        
        $('#slider ul li:last-child').prependTo('#slider ul');

        $('#slider2').css({ width: slideWidth2, height: slideHeight2 });
        
        $('#slider2 ul').css({ width: sliderUlWidth2, marginLeft: - slideWidth2 });
        
        $('#slider2 ul li:last-child').prependTo('#slider2 ul');

        $('#slider3').css({ width: slideWidth2, height: slideHeight2 });
        
        $('#slider3 ul').css({ width: sliderUlWidth2, marginLeft: - slideWidth2 });
        
        $('#slider3 ul li:last-child').prependTo('#slider3 ul');

        $('a.control_prev').click(function () {
            moveLeft();
        });

        $('a.control_next').click(function () {
            moveRight();
        });

        $('a.control_prev2').click(function () {
            moveLeft2();
        });

        $('a.control_next2').click(function () {
            moveRight2();
        });

        $('a.control_prev3').click(function () {
            moveLeft3();
        });

        $('a.control_next3').click(function () {
            moveRight3();
        });

        function moveLeft() {
            $('#slider ul').animate({
                left: + slideWidth
            }, 200, function () {
                $('#slider ul li:last-child').prependTo('#slider ul');
                $('#slider ul').css('left', '');
            });
        };

        function moveRight() {
            $('#slider ul').animate({
                left: - slideWidth
            }, 200, function () {
                $('#slider ul li:first-child').appendTo('#slider ul');
                $('#slider ul').css('left', '');
            });
        };

        function moveLeft2() {
            $('#slider2 ul').animate({
                left: + slideWidth
            }, 200, function () {
                $('#slider2 ul li:last-child').prependTo('#slider2 ul');
                $('#slider2 ul').css('left', '');
            });
        };

        function moveRight2() {
            $('#slider2 ul').animate({
                left: - slideWidth
            }, 200, function () {
                $('#slider2 ul li:first-child').appendTo('#slider2 ul');
                $('#slider2 ul').css('left', '');
            });
        };

        function moveLeft3() {
            $('#slider3 ul').animate({
                left: + slideWidth
            }, 200, function () {
                $('#slider3 ul li:last-child').prependTo('#slider3 ul');
                $('#slider3 ul').css('left', '');
            });
        };

        function moveRight3() {
            $('#slider3 ul').animate({
                left: - slideWidth
            }, 200, function () {
                $('#slider3 ul li:first-child').appendTo('#slider3 ul');
                $('#slider3 ul').css('left', '');
            });
        };
        
    });

</script>
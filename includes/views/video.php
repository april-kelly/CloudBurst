<style>
    article, aside, figure, footer, header, hgroup,
    menu, nav, section { display: block; }
</style>

<style type="text/css">
    .container {
        width: 80%;
        margin: 0px auto;
    }
    video {
        max-width: 100%;
        height: auto;
    }
</style>
<div id="container">

    <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none"
           data-setup="{}">
        <source src="../videos/mlp.mp4" type='video/mp4' />
    </video>

</div>
<script>


    // Once the video is ready
    _V_("example_video_1").ready(function(){

        // Store the video object
        var myPlayer = this;
        // Make up an aspect ratio
        var aspectRatio = 1080/1920;

        function resizeVideoJS(){
            var width = document.getElementById(myPlayer.id).parentElement.offsetWidth;
            myPlayer.width(width).height( width * aspectRatio );

        }

        // Initialize resizeVideoJS()
        resizeVideoJS();
        // Then on resize call resizeVideoJS()
        window.onresize = resizeVideoJS;

        //myPlayer.play();
        //myPlayer.currentTime(200);

    });

</script>
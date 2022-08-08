var submitBtn = document.getElementById("submitBtn");
submitBtn.style.display = "none";
Webcam.set({
        width: 250,
        height: 187.5
        // image_format: 'png',
        // jpeg_quality: 90
    });
    Webcam.attach( '#web_cam' );
    function take_snapshot() {
        Webcam.snap( function(web_cam_data) {
            $(".image-tag").val(web_cam_data);
            document.getElementById('response').innerHTML = '<img src="'+web_cam_data+'"/>';
            submitBtn.style.display = "block";
        } );
    }


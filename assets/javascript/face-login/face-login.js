 const video = document.getElementById('videoInput')
 var username = document.getElementById('username').value
 var baseURL = document.getElementById('baseURL').value
 // const assetsURL = '../../assets'
 const assetsURL= window.location.origin+'/codeIgniter/assets'

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri(assetsURL+'/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri(assetsURL+'/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri(assetsURL+'/models') //heavier/accurate version of tiny face detector
]).then(start).catch(document.getElementById('message').innerHTML = "Loading" )


function start() 
{
    // navigator.getUserMedia(
    //     { video:{} },
    //     stream => video.srcObject = stream,
    //     err => console.error(err)
    // )

    navigator.mediaDevices.getUserMedia({ audio: false, video: true }).then(function(stream) {
      if ("srcObject" in video) {
        video.srcObject = stream;
      } else {
        // Avoid using this in new browsers, as it is going away.
        video.src = window.URL.createObjectURL(stream);
      }
      video.onloadedmetadata = function(e) {
        video.play();
      };
    })
    .catch(function(err) {
      console.log(err.name + ": " + err.message);
    });



    video.addEventListener('play', async () => {
        
        const displaySize = { width: video.width, height: video.height }
        var failedChecking = 0;
        setInterval(async () => 
        {
            document.getElementById('message').innerHTML = failedChecking;
            
            const detections = await faceapi.detectAllFaces(video).withFaceLandmarks().withFaceDescriptors()
            var available_users = detections.length
            console.log(available_users)
            if (available_users>0) 
            {
                const resizedDetections = faceapi.resizeResults(detections, displaySize)
                const labeledDescriptors = await loadLabeledImages()
                const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.4)
                const result  = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
                let izina = result[0]['label']
                if (izina == username)
                 {
                   $.ajax(
                    {
                        url:baseURL+'eexam/EexamController/face_recognition_C/',
                        type:'POST',
                        data:
                        {
                            sent_user: username
                        },
                        success: function(data)
                        {
                            window.location.href = "http://localhost/codeIgniter/eexam/eexamController/login_C"
                        }
                    });
                 }
                 else
                 {
                   if (failedChecking<4) 
                   {
                    failedChecking += 1;
                   }
                   else
                   {
                    window.location.href = "http://localhost/codeIgniter/eexam/eexamController/login_C"
                   }
                 }
            }
            else
            {
                 document.getElementById('message').innerHTML = 'No face detected ';
            }
        }, 1000)
    })
}


function loadLabeledImages() {
    const labels = [username] // for WebCam
    return Promise.all(
        labels.map(async (label)=>{
            const descriptions = []
            for(let i=1; i<=4; i++) {
                const img = await faceapi.fetchImage(assetsURL+`/images/users/${label}/${i}.jpg`).catch( ()=>{
                    document.getElementById('secondMessage').innerHTML = "No Image registered for this user"
                    document.getElementById('message').style.visibility = 'hidden'
                    video.pause()
                })

                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                descriptions.push(detections.descriptor)
            }
            return new faceapi.LabeledFaceDescriptors(label, descriptions)
        })
    )
}
	
var submitBtn = document.getElementById('submitBtn');
submitBtn.style.display = 'none';
const image_input = document.getElementById('image-input');

var username = document.getElementById('username').value
var baseURL = document.getElementById('baseURL').value
const assetsURL= window.location.origin+'/ci/assets'

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri(assetsURL+'/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri(assetsURL+'/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri(assetsURL+'/models') //heavier/accurate version of tiny face detector
]).then(start).catch(document.getElementById('message').innerHTML = "Wait" )

function start() 
{
  document.getElementById('message').innerHTML = ' Yoou can upload now ';
}

image_input.addEventListener("change", function() 
{
  const reader = new FileReader();
  reader.addEventListener("load", () => {
    const uploaded_image = reader.result;
     document.getElementById("display-image").style.backgroundImage = `url(${uploaded_image})`;
  });
  reader.readAsDataURL(this.files[0]);

  submitBtn.style.display = "block";
});


async function recognize_face()
{
    const image = await faceapi.bufferToImage(image_input.files[0])
    const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
    var available_users = detections.length
    console.log(available_users)
    if (available_users>0) 
    {
        const resizedDetections = faceapi.resizeResults(detections, image)
        const labeledDescriptors = await loadLabeledImages()
        const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.4)
        const result  = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
        let izina = result[0]['label']
        if (izina == username)
         {
           document.getElementById('message').innerHTML = 'Criminal detected ';
         }
         else
         {
            document.getElementById('message').innerHTML = 'Not in the list we have ';
         }
    }
    else
    {
         document.getElementById('message').innerHTML = 'No face detected ';
    }
}

function loadLabeledImages() {
    const labels = [username] // for WebCam
    return Promise.all(
        labels.map(async (label)=>{
            const descriptions = []
            for(let i=1; i<=4; i++) {
                const img = await faceapi.fetchImage(assetsURL+`/images/users/superAdmin/${i}.jpg`).catch( ()=>{
                    document.getElementById('secondMessage').innerHTML = "No Image registered for this user"
                    document.getElementById('message').style.visibility = 'hidden'
                })

                const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                descriptions.push(detections.descriptor)
            }
            return new faceapi.LabeledFaceDescriptors(label, descriptions)
        })
    )
}
	



// const imageUpload = document.getElementById('imageUpload')
// const imageBoxView = document.getElementById('imageBoxView')
// function start() 
// {
//   document.getElementById('message').innerHTML = ' Yoou can upload now ';
//     imageUpload.addEventListener('change', async () => {
//         const image = await faceapi.bufferToImage(imageUpload.files[0])
//         const displaySize = { width: image.width, height: image.height }
//         image.height='360'
//         image.width='380'
//         imageBoxView.append(image)
//         // document.getElementById('message').innerHTML = failedChecking;
//         const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
//         var available_users = detections.length
//         console.log(available_users)
//         if (available_users>0) 
//         {
//             const resizedDetections = faceapi.resizeResults(detections, displaySize)
//             const labeledDescriptors = await loadLabeledImages()
//             const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.4)
//             const result  = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
//             let izina = result[0]['label']
//             if (izina == username)
//              {
//                document.getElementById('message').innerHTML = 'Criminal detected ';
//              }
//              else
//              {
//                 document.getElementById('message').innerHTML = 'Not in the list we have ';
//              }
//         }
//         else
//         {
//              document.getElementById('message').innerHTML = 'No face detected ';
//         }
//     })
// }

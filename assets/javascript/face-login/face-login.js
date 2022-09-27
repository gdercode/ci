
var user = [] 
const username = [] 

let b =""

for(let i=0; i<3; i++)
{
    b=i
    username[i]= document.getElementById(b).value
}

console.log(username)
var submitBtn = document.getElementById('submitBtn');
const submitBtn_label = document.getElementById('submitBtn-label');
const image_input = document.getElementById('image-input');
const image_input_label = document.getElementById('image-input-label');

submitBtn.style.display = 'none';
submitBtn_label.style.display = 'none';
image_input.style.display = 'none';
image_input_label.style.display = 'none';

const assetsURL= window.location.origin+'/ci/assets'

var available_users = 0;
let izina='';

// let username = ['lidivine','13']

Promise.all([
    faceapi.nets.faceRecognitionNet.loadFromUri(assetsURL+'/models'),
    faceapi.nets.faceLandmark68Net.loadFromUri(assetsURL+'/models'),
    faceapi.nets.ssdMobilenetv1.loadFromUri(assetsURL+'/models') //heavier/accurate version of tiny face detector
]).then(start).catch(document.getElementById('message').innerHTML = "Wait" )

function start() 
{
  document.getElementById('message').innerHTML = ' You can upload now ';
  image_input_label.style.display = 'block';
}

function loadLabeledImages() {
    const labels = username
    return Promise.all(
        labels.map(async (label)=>{
            const descriptions = []
            for(let i=1; i<=4; i++) {
                    const img = await faceapi.fetchImage(assetsURL+`/images/users/${label}/${i}.jpg`).catch( ()=>{
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

async function recognize_face()
{    
    document.getElementById('message').innerHTML = 'Identifing ... ';

    const image = await faceapi.bufferToImage(image_input.files[0])
    const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
    available_users = detections.length
    console.log(available_users)
    if (available_users>0) 
    {
        const resizedDetections = faceapi.resizeResults(detections, image)
        const labeledDescriptors = await loadLabeledImages()
        const faceMatcher = new faceapi.FaceMatcher(labeledDescriptors, 0.4)
        const result  = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
        izina = result[0]['label']

        if (izina == 'unknown') 
         {
            document.getElementById('message').innerHTML = 'Not in the list we have ';
            image_input_label.style.display = "none";
         }
         else
         {
            document.getElementById('detected').value=izina;
            console.log(izina)
            document.getElementById('message').innerHTML = 'Criminal detected ';
            image_input_label.style.display = "none";
            submitBtn_label.style.display = "block";
         }
    }
    else
    {
        document.getElementById('message').innerHTML = 'No face detected ';
        image_input_label.style.display = "none";
    }
}


image_input.addEventListener("change", function() 
{
    document.getElementById('message').innerHTML = 'uploading ... ';
   
    const reader = new FileReader();
    reader.addEventListener("load", () => {
    const uploaded_image = reader.result;
     document.getElementById("display-image").style.backgroundImage = `url(${uploaded_image})`;
    });

    reader.readAsDataURL(this.files[0]);
    recognize_face();
});



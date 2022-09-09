var submitBtn = document.getElementById("submitBtn");
submitBtn.style.display = "none";
const image_input = document.getElementById("image-input");


image_input.addEventListener("change", function() {
  const reader = new FileReader();
  reader.addEventListener("load", () => {
    const uploaded_image = reader.result;
    document.getElementById("display-image").style.backgroundImage = `url(${uploaded_image})`;
  });
  reader.readAsDataURL(this.files[0]);

  submitBtn.style.display = "block";
});
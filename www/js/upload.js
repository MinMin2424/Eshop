const dropArea = document.getElementById("drop-area");
const inputFile = document.getElementById("obrazky");
const imageView = document.getElementById("img-view");

inputFile.addEventListener("change", uploadImage);

function uploadImage() {
    let imgLink = URL.createObjectURL(inputFile.files[0]);
    imageView.style.backgroundImage = `url(${imgLink})`;
    imageView.style.backgroundRepeat = "no-repeat";
    imageView.style.backgroundPosition = "center";
    imageView.textContent = "";
    imageView.style.border = "none";
    imageView.style.backgroundColor = "white";
}

dropArea.addEventListener("dragover", function(e) {
    e.preventDefault();
});

dropArea.addEventListener("drop", function(e) {
    e.preventDefault();
    inputFile.files = e.dataTransfer.files;
    uploadImage();
});
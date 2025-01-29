document.querySelectorAll(".heart-before, .heart-after").forEach(item => {
    item.addEventListener('click', event => {
		// get the unique id from the above
		// zjistim si id teto polozky
			let par = event.currentTarget.parentElement.id;
			if (par != "") {
				let heart_before = document.querySelector("#"+par+" img.heart-before"); 
				let heart_after = document.querySelector("#"+par+" img.heart-after"); 
				toggleImages(heart_before, heart_after);
		}
        //item.style.display = "none";
        //document.querySelector(".heart-after").style.display = "flex";
    })
})

function toggleImages(img1, img2) {
	if (img1.style.display == "none") {
		img1.style.display = "flex";
		img2.style.display = "none";
	} else {
		img1.style.display = "none";
		img2.style.display = "flex";
	}
}
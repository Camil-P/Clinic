const myFunction = () => {
	document.getElementById("myDropdown").classList.toggle("show");
};

window.onclick = function (event) {
	if (!event.target.matches(".dropbtn")) {
		var dropdowns = document.getElementsByClassName("dropdown-content");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
			var openDropdown = dropdowns[i];
			if (openDropdown.classList.contains("show")) {
				openDropdown.classList.remove("show");
			}
		}
	}
};
const onSelectChange = () => {
	let patient = document.getElementById("patient-list");
	d = document.getElementById("select_id").value;
	showSelectedContent(d);
	if (d === "patients") {
		patient.classList.add("random_test");
	}
};

const showSelectedContent = (activeContent) => {
	const container = document.getElementById("container-content");
	console.log(container.children, "childnodes");
	for (content of container.children) {
		console.log("content.id", content);
		if (content.id === activeContent) {
			content.style.display = "block";
		} else {
			content.style.display = "none";
		}
	}
};

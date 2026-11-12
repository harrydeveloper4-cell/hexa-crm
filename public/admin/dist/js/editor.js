editor.document.designMode = "On";

function transform(option, argument) {
  editor.document.execCommand(option, false, argument);
}

function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "show"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "less"; 
    moreText.style.display = "inline";
  }
}

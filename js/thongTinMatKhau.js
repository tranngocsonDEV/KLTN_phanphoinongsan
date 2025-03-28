$(document).ready(function changeTypePass() {
  var x = document.getElementById("matKhau");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
});

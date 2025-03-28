$(document).ready(function () {
  var toastEl = document.getElementById("myToast");
  var toast = new bootstrap.Toast(toastEl);
  toast.show();
});
$(document).ready(function () {
  const duLieuTitleDiv = document.getElementById("du-lieu-title");

  // Kiểm tra xem div nào đang được hiển thị và cập nhật title tương ứng
  if (duLieuTitleDiv.style.display !== "none") {
    document.title = `${duLieuTitleDiv.dataset.title} | Fresh`;
  }
});

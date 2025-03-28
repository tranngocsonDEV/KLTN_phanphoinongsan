$(document).ready(function () {
  $("#inputGroupSelect01")
    .change(function () {
      var status = $(this).val();
      $.ajax({
        url: "../php/quanLyDonHang_HienThi.php",
        method: "POST",
        data: {
          status: status
        },
        success: function (data) {
          $("#data").html(data);
        }
      });
    })
    .change(); // Thêm dòng này để tự động kích hoạt sự kiện change khi trang tải
});

$(document).ready(function () {
  var toastEl = document.getElementById("myToast");
  var toast = new bootstrap.Toast(toastEl);
  toast.show();
});
$(document).ready(function () {
  if ($.fn.DataTable.isDataTable("#dataTable")) {
    $("#dataTable").DataTable().destroy();
  }

  // Khởi tạo DataTable
  var table = $("#dataTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "../php/phanPhoiDonHang_HienThi_XuLy.php", // Đường dẫn file PHP
      type: "POST",
      data: function (d) {
        // Gửi trạng thái đã chọn đến server
        d.status = $("#inputGroupSelect01").val();
      },
      dataSrc: function (json) {
        // Sử dụng dữ liệu trả về từ PHP để cập nhật bảng
        return json.data;
      }
    },
    language: {
      emptyTable: "Không có dữ liệu trong bảng", // Thay đổi thông báo không có dữ liệu
      infoEmpty: "Không có bản ghi nào", // Thay đổi thông báo không có bản ghi
      infoFiltered: "(Đã lọc từ _MAX_ tổng số bản ghi)", // Thay đổi thông báo lọc dữ liệu
      lengthMenu: "Hiển thị _MENU_ bản ghi", // Thay đổi thông báo lựa chọn số lượng bản ghi hiển thị
      loadingRecords: "Đang tải...", // Thay đổi thông báo đang tải
      search: "Tìm kiếm:", // Thay đổi thông báo tìm kiếm
      zeroRecords: "Không tìm thấy kết quả" // Thay đổi thông báo không tìm thấy kết quả
    },
    columns: [
      { data: "MaPhieuXuat" },
      { data: "TenPhieu" },
      { data: "TenNguoiLapPhieu" },
      { data: "NgayGiaoHang" },
      { data: "TongSoLoaiSanPham" },
      { data: "action" } // Cột hành động không sắp xếp hoặc tìm kiếm
    ]
  });

  // Lắng nghe sự kiện thay đổi của dropdown "Loại phiếu"
  $("#inputGroupSelect01").on("change", function () {
    // Khi giá trị dropdown thay đổi, reload lại DataTable
    table.ajax.reload();
  });
});

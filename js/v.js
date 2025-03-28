$(document).ready(function () {
  if ($.fn.DataTable.isDataTable("#dataTable")) {
    $("#dataTable").DataTable().destroy();
  }

  var table = $("#dataTable").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "../php/phanPhoiDonHang_HienThi.php", // Đường dẫn file PHP
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
      decimal: "", // Dấu thập phân (có thể để trống nếu không sử dụng)
      emptyTable: "Không có dữ liệu trong bảng", // Thông báo khi bảng không có dữ liệu
      info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ bản ghi", // Thông báo khi hiển thị thông tin bảng
      infoEmpty: "Hiển thị 0 đến 0 trong tổng số 0 bản ghi", // Thông báo khi không có bản ghi nào
      infoFiltered: "(đã lọc từ _MAX_ tổng số bản ghi)", // Thông báo khi có dữ liệu lọc
      infoPostFix: "", // Thêm hậu tố vào thông báo info (có thể để trống)
      thousands: ",", // Dấu phân cách hàng nghìn
      lengthMenu: "Hiển thị _MENU_ bản ghi", // Thông báo chọn số lượng bản ghi hiển thị
      loadingRecords: "Đang tải...", // Thông báo khi đang tải dữ liệu
      processing: "", // Thông báo khi đang xử lý (có thể để trống)
      search: "Tìm kiếm:", // Thông báo tìm kiếm
      zeroRecords: "Không tìm thấy kết quả", // Thông báo khi không tìm thấy kết quả

      aria: {
        orderable: "Sắp xếp theo cột này", // Thông báo sắp xếp cột
        orderableReverse: "Sắp xếp ngược lại cột này" // Thông báo sắp xếp ngược cột
      }
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
});

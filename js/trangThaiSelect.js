$(document).ready(function () {
  // Kiểm tra và xóa DataTable nếu đã tồn tại
  if ($.fn.DataTable.isDataTable("#example")) {
    $("#example").DataTable().destroy();
  }

  // Khởi tạo DataTable với AJAX động
  var table = $("#example").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "../php/trangThaiPhieuSelect.php",
      type: "POST",
      data: function (d) {
        d.action = "searchByStatus"; // Đặt action là searchByStatus
        d.status = $("#trangThaiSelect").val(); // Lấy trạng thái từ dropdown
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
      { data: "MaPhieuNhapKho" },
      { data: "Ten" },
      { data: "NhanVienKho" },
      { data: "NgayLapPhieu" },
      { data: "NgayDatHang" },
      { data: "NgayNhanHang" },
      { data: "TongSoLoaiSanPham" },
      {
        data: null,
        render: function (data, type, row) {
          return `<a href='./nvphieuYeuCau_Nhap_ChiTiet.php?MaPhieuNhapKho=${row.MaPhieuNhapKho}' class='btn btn-primary btn-md'>Xem</a>`;
        }
      }
    ]
  });

  // Reload lại bảng khi thay đổi trạng thái
  $("#trangThaiSelect").on("change", function () {
    table.ajax.reload();
  });
});

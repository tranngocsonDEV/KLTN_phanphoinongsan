$(document).ready(function () {
  if ($.fn.DataTable.isDataTable("#example")) {
    $("#example").DataTable().destroy();
  }

  var table = $("#example").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "../php/phieuYeuCau_HienThi.php",
      type: "POST",
      data: function (d) {
        d.action = "fetchData";
        d.status = $("#trangThaiSelect").val() || 4; // Mặc định "Đã duyệt" nếu chưa chọn trạng thái
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
          let actionBtns = `<a href='./phieuYeuCau_ChiTietNhap_HienThi.php?MaPhieuNhapKho=${row.MaPhieuNhapKho}' class='btn btn-primary btn-md h-100 fs-6'>Xem</a>`;

          if ($("#trangThaiSelect").val() == 3) {
            // Trạng thái "Chờ duyệt"
            actionBtns = `
              <a href='./phieuYeuCau_ChiTietNhap_DuyetPhieu.php?MaPhieuNhapKho=${row.MaPhieuNhapKho}' class='btn btn-warning btn-md h-100 fs-6 mt-1' style="padding-right: 1rem; ">Xem</a>`;
          }
          return actionBtns;
        }
      }
    ]
  });

  // Reload lại dữ liệu khi thay đổi trạng thái
  $("#trangThaiSelect").on("change", function () {
    table.ajax.reload();
  });
});

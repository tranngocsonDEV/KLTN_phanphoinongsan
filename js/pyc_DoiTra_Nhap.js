$(document).ready(function () {
  // Khởi tạo DataTable
  if ($.fn.DataTable.isDataTable("#example")) {
    $("#example").DataTable().destroy();
  }

  var table = $("#example").DataTable({
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
    processing: true,
    serverSide: true,
    ajax: {
      url: "../php/pyc_DoiTra_HienThi_Nhap.php",
      type: "POST",
      data: function (d) {
        d.action = "fetchData";
        d.status = $("#trangThaiSelect").val() || 1; // Mặc định "Đã duyệt" nếu chưa chọn trạng thái
      }
    },

    columns: [
      { data: "MaYeuCauDoiTra" },
      { data: "Ten" },
      { data: "NhanVienKho" },
      { data: "NgayLapPhieu" },
      {
        data: null,
        render: function (data, type, row) {
          let actionBtns = `<a href='./pyc_DoiTra_ChiTiet_Nhap.php?MaYeuCauDoiTra=${row.MaYeuCauDoiTra}' class='btn btn-primary btn-md h-100 fs-6'>Xem</a>`;

          return actionBtns;
        }
      }
    ]
  });

  // Reload lại dữ liệu khi thay đổi trạng thái
  $("#trangThaiSelect").on("change", function () {
    table.ajax.reload();
  });

  // Hiển thị modal khi nhấn nút xóa
  let MaYeuCauDoiTra; // Lưu trữ mã phiếu nhập để xóa

  $(document).on("click", ".btn_xoa_phieu_nhap", function (e) {
    e.preventDefault();
    MaYeuCauDoiTra = $(this).data("maphieu"); // Lấy mã phiếu nhập từ data-maphieu
    $("#deleteConfirmModal").modal("show"); // Hiển thị modal
  });

  // Xử lý khi người dùng xác nhận xóa trong modal
  $("#confirmDeleteBtn").on("click", function () {
    $.ajax({
      url: "../view/nvPYC_DoiTra_ChiTiet_Xoa.php",
      type: "POST",
      data: { MaYeuCauDoiTra: MaYeuCauDoiTra },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          window.location.href = "nvYeuCauDoiTra.php";
          $("#deleteConfirmModal").modal("hide");
          table.ajax.reload();
        } else {
          alert("Có lỗi: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        alert("Có lỗi xảy ra khi xóa phiếu nhập.");
      }
    });
  });
});

<?php
include("../php/header_heThong.php");
?>

<?php
include("../php/sidebar_heThong.php");
?>

<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Thông tin kho">Thông tin kho</div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Bảng dữ liệu</div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered table-responsive data-table"
                style="width: 100%">
                <thead>
                  <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Tổng số lượng</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include("../config/init.php");
                  include("../php/thongBao.php");
                  ?>

                  <?php

                  $sql = "SELECT *  FROM tbl_sanpham";
                  // -- WHERE MaSanPham = '$MaSanPham' ";
                  $result = $conn->query($sql);

                  while ($row = $result->fetch_assoc()) {

                    echo "<tr >";
                    echo "<td class='MaSanPham_id'>" . $row['MaSanPham'] . "</td>";
                    echo "<td>" . $row['Ten'] . "</td>";
                    echo "<td>" . $row['DonVi'] . "</td>";
                    echo "<td >" . $row['SoLuongTon'] . "</td>";
                    echo "<td>
                                                <button class='btn btn-primary btn-md detail_product_btn' data-masanpham='" . $row['MaSanPham'] . "' >
                                                    Chi tiết
                                                </button>
                                                   
                                               </td>";
                    echo "</tr>";
                  }

                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!-- chiTietThongTinSanPhamTrongKhoModal -->
<div class="modal fade" id="chiTietThongTinSanPhamTrongKhoModal" tabindex="-1"
  aria-labelledby="chiTietThongTinSanPhamTrongKhoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chiTietThongTinSanPhamTrongKhoModalLabel">Chi tiết sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive-xl">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th scope="col">Thời điểm</th>
                <th scope="col">Loại</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Đơn giá</th>
                <th scope="col">Ghi chú</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $(".detail_product_btn").click(function (e) {
      e.preventDefault();

      // Lấy mã sản phẩm từ nút
      var MaSanPham = $(this).data('masanpham');

      $.ajax({
        type: "POST",
        url: "../view/xemThongTinKho_XuLy.php",
        data: { MaSanPham: MaSanPham },
        success: function (response) {
          // Xử lý dữ liệu trả về
          var data = JSON.parse(response);

          // Xóa các hàng cũ trong bảng modal
          $("#chiTietThongTinSanPhamTrongKhoModal tbody").empty();

          // Thêm dữ liệu mới vào bảng
          data.forEach(function (item) {
            $("#chiTietThongTinSanPhamTrongKhoModal tbody").append(`
                        <tr>
                            <td>${item.ThoiDiem}</td>
                            <td>${item.Loai}</td>
                            <td>${item.SoLuong}</td>
                            <td>${item.DonGia}</td>
                            <td>${item.GhiChu}</td>
                        </tr>
                    `);
          });

          // Hiển thị modal
          $("#chiTietThongTinSanPhamTrongKhoModal").modal("show");
        },
        error: function () {
          alert("Không thể tải thông tin sản phẩm.");
        },
      });
    });
  });

</script>
</body>

</html>
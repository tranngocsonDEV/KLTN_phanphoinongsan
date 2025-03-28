<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<?php
include("../config/init.php"); // Khởi tạo session và các cài đặt ban đầu
include("../php/connect.php"); // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ThongTinDangNhap']) || !isset($_SESSION['MaVaiTro'])) {
    $_SESSION['errorMessages'] = "Bạn phải đăng nhập để truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Kiểm tra quyền truy cập: chỉ nhân viên kho (MaVaiTro = 2) mới được truy cập
if ($_SESSION['MaVaiTro'] != '2') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Nếu vượt qua kiểm tra quyền truy cập, hiển thị trang thống kê
?>
<?php
include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");

include("../php/thongBao.php");
include("../config/init.php");

?>


<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Thông tin kho">Thông tin kho</div>
    </div>
    <div class="row">
      <div class="message_show">

      </div>
    </div>

    <div class="col-md-4 mb-2">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
        Thêm
      </button>
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

                  $sql = "SELECT * FROM tbl_sanpham
                  ORDER BY MaSanPham ASC";
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
                                                 <button class='btn btn-warning btn-md insert_detail_product_btn'  data-masanpham='" . $row['MaSanPham'] . "' >
                                                    Thanh lý
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
<!-- ThemSPModal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSupplierModalLabel">Thêm mới sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="error_message">

        </div>
        <div class="mb-2">
          <label for="MaSP" class="form-label">Mã Sản phấm:</label>
          <input type="text" name="MaSP" placeholder="Mã của sản phẩm sẽ được tạo tự động " class="form-control MaSP"
            readonly>
        </div>
        <div class="mb-2">
          <label for="TenSP" class="form-label">Tên sản phẩm:</label>
          <input type="text" name="TenSP" placeholder="Nhập tên của sản phẩm" class="form-control TenSP" required>
        </div>
        <div class="mb-2">
          <label for="DonVi" class="form-label">Đơn vị:</label>
          <input type="text" name="DonVi" placeholder="Nhập đơn vị của sản phẩm" class="form-control DonVi" required>
        </div>


        <div class="mb-2">
          <label for="LoaiSP" class="form-label">Loại sản phẩm:</label>
          <select class="form-select LoaiSP" name="LoaiSP" aria-label="Loại sản phẩm">
            <option selected>Chọn loại</option>
            <option value="Trái cây">Trái cây</option>
            <option value="Rau củ">Rau củ</option>
            <option value="hạt">Các loại hạt</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-primary them_thongtin_ncc">Lưu</button>
      </div>
      <!-- </form> -->
    </div>
  </div>
</div>
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
<!-- dieuChinSoLuonghChiTietThongTinSanPhamTrongKhoModal -->
<div class="modal fade" data-bs-backdrop="static" id="dieuChinSoLuonghChiTietThongTinSanPhamTrongKhoModal" tabindex="-1"
  aria-labelledby="dieuChinSoLuonghChiTietThongTinSanPhamTrongKhoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dieuChinSoLuonghChiTietThongTinSanPhamTrongKhoModalLabel">
          Thanh lý sản phẩm
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="../view/nvQuanLyKho_Sua.php" method="POST">

        <div class="modal-body ">
          <div class="table-responsive-xl">
            <div class="form-group mb-3">

              <label for="thoiDiemThanhLySoLuongSanPham">Thời điểm</label>
              <input type="datetime-local" class="form-control" name="thoiDiemThanhLySoLuongSanPham"
                id="thoiDiemThanhLySoLuongSanPham" required>
            </div>
            <div class="form-group mb-3">
              <label for="loaiThanhLySoLuongSanPham">Loại thanh lý</label>
              <select class="form-control" name="loaiThanhLySoLuongSanPham" id="loaiThanhLySoLuongSanPham" required>
                <option disabled selected>Loại thanh lý</option>
                <option value="Hư hỏng">Hư hỏng</option>
              </select>
            </div>
            <div class="form-group  mb-3">
              <label for="soLuongThanhLySoLuongSanPham">Số lượng thanh lý</label>
              <input type="number" class="form-control" name="soLuongThanhLySoLuongSanPham"
                id="soLuongThanhLySoLuongSanPham" placeholder="Nhập số lượng thanh lý" required>
            </div>
            <div class="form-group mb-3">
              <label for="ghiChuThanhLySoLuongSanPham">Ghi chú</label>
              <textarea name="ghiChuThanhLySoLuongSanPham" id="ghiChuThanhLySoLuongSanPham" class="form-control"
                placeholder="Nhập ghi chú thanh lý"></textarea>
            </div>
            <input type="hidden" name="IDNhanVien" value="<?php echo $_SESSION['ThongTinDangNhap']['User_id']; ?>">
            <input type="hidden" name="MaSanPham_text" id="thanhly_id">

          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="btn_request_liquidation">
            Gửi đề xuất
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Đóng
          </button>

        </div>
      </form>
    </div>
  </div>
</div>
<!-- Thêm thông tin sản phẩm -->
<script>
  $(document).ready(function () {
    $(".them_thongtin_ncc").click(function (e) {
      e.preventDefault();

      var MaSP = $('.MaSP').val();
      var TenSP = $('.TenSP').val();
      var DonVi = $('.DonVi').val();
      var LoaiSP = $('.LoaiSP').val();

      if (TenSP != '' && DonVi != '' && LoaiSP != '') {
        $.ajax({
          type: "POST",
          url: "../php/themSP_XuLy.php",
          data: {
            'checking_add': true,
            'TenSP': TenSP,
            'DonVi': DonVi,
            'LoaiSP': LoaiSP,
          },
          dataType: 'json', // Thêm dòng này để jQuery tự động parse JSON
          success: function (response) {
            if (response.status === 'success') {

              // Close modal and remove backdrop
              $('#addSupplierModal').modal('hide');
              $('.modal-backdrop').remove();
              // Lưu thông báo vào sessionStorage
              sessionStorage.setItem('message', JSON.stringify({
                type: 'success',
                message: response.message
              }));
              location.reload();



            } else {
              sessionStorage.setItem('message', JSON.stringify({
                type: 'danger',
                message: response.message
              }));

            }
          },
          error: function (xhr, status, error) {
            console.error('Ajax error:', error);
            $('.error_message').append(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Lỗi!</strong> Không thể thêm sản phẩm.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
          }
        });
      } else {
        $('.error_message').append(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Lưu ý!</strong> Điền đầy đủ thông tin.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
      }
    });
  });
  $(document).ready(function () {
    // Kiểm tra xem có thông báo lưu trong sessionStorage không
    var message = sessionStorage.getItem('message');

    if (message) {
      // Chuyển chuỗi JSON thành đối tượng
      var msg = JSON.parse(message);

      // Hiển thị thông báo lên giao diện
      $('.message_show').append(`
      <div class="alert alert-${msg.type} alert-dismissible fade show" role="alert">
        <strong>Lưu ý!</strong> ${msg.message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `);

      // Xóa thông báo khỏi sessionStorage sau khi đã hiển thị
      sessionStorage.removeItem('message');
    }
  });

</script>

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
<script>
  $(document).ready(function () {
    // Thanh lý sản phẩm button click
    $(".insert_detail_product_btn").click(function (e) {
      e.preventDefault();
      var MaSanPham_id = $(this).closest("tr").find(".MaSanPham_id").text();
      $('#thanhly_id').val(MaSanPham_id);
      $("#dieuChinSoLuonghChiTietThongTinSanPhamTrongKhoModal").modal("show");
    });

  });
</script>
</body>

</html>
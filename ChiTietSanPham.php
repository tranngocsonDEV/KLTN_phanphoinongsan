<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/logo32.png" type="image/x-icon">
  <title>Văn Khánh Store</title>
  <!-- Link bootstrap -->
  <link rel="stylesheet" href="../css/bootstrap.min.css" />
  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="../css/style-ChiTietSanPham.css" />
</head>

<body>
  <script type="text/javascript" src="../js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../js/thongTinMatKhau.js"></script>
  <header>
    <!-- Navbar -->
    <a class="logo" href="../view/homePage.php">Văn Khánh Store</a>
    <!-- Menu Icon -->
    <div class="bx bx-menu" id="menu-icon"><i class="bi bi-list"></i></div>
    <!-- Nav List -->
    <ul class="navbar">
      <li><a href="#home" class="home-active">Trang chủ</a></li>
      <li><a href="#categories">Danh mục</a></li>
      <li><a href="#products">Sản phẩm</a></li>
      <li><a href="#about">Giới thiệu</a></li>
      <li><a href="#customer">Khách hàng</a></li>
    </ul>
    <!-- Search Form -->
    <div class="input-group search-form">
      <div class="position-relative w-100">
        <input type="text" name="SearchFormText" id="SearchFormText" class="form-control rounded pl-4"
          placeholder="Tìm kiếm" aria-label="Search" aria-describedby="search-addon" />
        <i class="bi bi-search search-icon" title="Tìm kiếm"></i>
      </div>
      <div id="ket-qua-tim-kiem"></div>
    </div>

    <script>
      $(document).ready(function () {
        $("#SearchFormText").on('keyup', function () {
          var SearchFormText = $(this).val();

          if (SearchFormText.length >= 1) {
            $("#ket-qua-tim-kiem").html('<div class="p-2">Đang tìm kiếm...</div>');
            $.ajax({
              url: "../php/timKiem.php",
              method: "POST",
              data: {
                SearchFormText: SearchFormText
              },
              success: function (data) {
                $("#ket-qua-tim-kiem").html(data);
                $("#ket-qua-tim-kiem").show();
              }
            });
          } else {
            $("#ket-qua-tim-kiem").html("");
            $("#ket-qua-tim-kiem").hide();
          }
        });

        // Thêm sự kiện click cho các kết quả tìm kiếm
        $(document).on('click', '#ket-qua-tim-kiem a', function (e) {
          e.preventDefault();
          var url = $(this).attr('href');
          window.location.href = url;
        });
      });
    </script>
    <!-- Profile -->
    <div class="profile">

      <a href="../view/login.php" class="btn">Đăng nhập</a>
    </div>
  </header>



  <section class="detail-product detail-info-product" id="detail-product" style="margin-top: 25px;">
    <div class="container info-full">
      <?php
      include("../php/vproduct.php");
      $p = new VSanPham();

      if (isset($_REQUEST["MaBaiViet"])) {
        $p->xemctbaiviet($_REQUEST["MaBaiViet"]);
      } else {
        echo '<div class="text-center text-danger">Không tìm thấy bài viết.</div>';
      }
      ?>
    </div>
  </section>

  <!-- Products -->

  <!-- Footer -->
  <section class="footer bg-primary text-white mt-5" id="footer">
    <div class="footer-box user">
      <a class="navbar-brand fw-bold me-auto" href="#">Nhóm 42</a>
      <p><i class="bi bi-person"></i>Trần Ngọc Sơn</p>
      <p><i class="bi bi-envelope"></i>tnson9102@gmail.com</p>
      <p><i class="bi bi-person"></i>Mai Thị Huỳnh Như</p>
      <p><i class="bi bi-envelope"></i>maithihuynhnhu@gmail.com</p>
      <div class="social">
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-twitter"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-youtube"></i></a>
      </div>
    </div>
    <div class="footer-box">
      <h2>Danh mục</h2>
      <a href="#products">Trái cây</a>
      <a href="#products">Rau củ</a>
      <a href="#products">Các loại hạt</a>
    </div>
    <div class="footer-box">
      <h2>Chính sách</h2>
      <a href="#">Điều khoản</a>
      <a href="#">Giới thiệu công ty</a>
      <a href="#">Hỏi đáp</a>
    </div>
  </section>
  <!-- Copyright -->
  <div class="copyright bg-dark text-white py-2">
    <p>&#169; Bản quyền thuộc về <a class="text-secondary fw-bold __web-inspector-hide-shortcut__"
        href="https://www.facebook.com/sontran02" target="_blank">Nhóm
        77</a></p>

  </div>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Link  TO JS -->
  <script type="text/javascript" src="../js/homePage.js"></script>


</body>

</html>
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
      <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
      <link rel="stylesheet" href="../css/style-homepage.css"/>
  </head>
  <body>
  <script type="text/javascript" src="../js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../js/thongTinMatKhau.js"></script>
    <header>
      <!-- Navbar -->
      <a class="logo"  href="../view/homePage.php">Văn Khánh Store</a>
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
            <input type="text" name="SearchFormText" id="SearchFormText" class="form-control rounded pl-4" placeholder="Tìm kiếm" aria-label="Search" aria-describedby="search-addon" />
            <i class="bi bi-search search-icon" title="Tìm kiếm"></i>
        </div>
        <div id="ket-qua-tim-kiem"></div>
    </div>

    <script>
        $(document).ready(function() {
            $("#SearchFormText").on('keyup', function() {
                var SearchFormText = $(this).val();
                
                if(SearchFormText.length >= 1) {
                    $("#ket-qua-tim-kiem").html('<div class="p-2">Đang tìm kiếm...</div>');
                    $.ajax({
                        url: "../php/timKiem.php",
                        method: "POST",
                        data: {
                            SearchFormText: SearchFormText
                        },
                        success: function(data) {
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
            $(document).on('click', '#ket-qua-tim-kiem a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                window.location.href = url;
            });
        });
    </script>
      <!-- Profile -->
      <div class="profile">
        <!-- <img src="/img/1_asian.jpg.crdownload" alt="" />
        <span>Trần Ngọc Sơn</span>
        <i class="bi bi-caret-down-fill"></i> -->
        <a href="../view/login.php" class="btn">Đăng nhập</a>
      </div>
    </header>
 
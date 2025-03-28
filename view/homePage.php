<!-- ChatBot --><?php
include("../php/header_homePage.php")
  ?>

<!-- Home -->
<section class="home swiper" id="home">
  <?php
  include("../config/init.php");

  ob_start();
  include("../php/thongBao.php");
  ?>
  <div class="swiper-wrapper">
    <!-- Slide 1 -->
    <div class="swiper-slide">
      <div class="container">
        <div class="home-text">
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>Chất lượng</h3>
          </div>
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>An toàn</h3>
          </div>
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>Uy tín</h3>
          </div>
          <a href="#" class="btn">Liên hệ ngay<i class="bi bi-arrow-right-short"></i></a>
        </div>
        <img src="../img/peach.png" loading="lazy" alt="" class="slide-image" />
      </div>
    </div>
    <!-- Slide 2 -->
    <div class="swiper-slide">
      <div class="container">
        <div class="home-text">
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>Chất lượng</h3>
          </div>
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>An toàn</h3>
          </div>
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>Uy tín</h3>
          </div>
          <a href="#" class="btn">Liên hệ ngay<i class="bi bi-arrow-right-short"></i></a>
        </div>
        <img src="../img/apple.png" loading="lazy" alt="" class="slide-image" />
      </div>
    </div>
    <!-- Slide 3 -->
    <div class="swiper-slide">
      <div class="container">
        <div class="home-text">
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>Chất lượng</h3>
          </div>
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>An toàn</h3>
          </div>
          <div class="home-text-child">
            <img src="../img/9079505.png" loading="lazy" alt="" />
            <h3>Uy tín</h3>
          </div>
          <a href="#" class="btn">Liên hệ ngay<i class="bi bi-arrow-right-short"></i></a>
        </div>
        <img src="../img/grape.png" alt="" loading="lazy" class="slide-image" />
      </div>
    </div>
  </div>
  <div class="swiper-button-next"></div>
  <div class="swiper-button-prev"></div>
</section>
<!-- ChatBot -->
<!--<div class="chat-button" title="Chatbot" onclick="toggleChat()">-->
<!--  <span class="icon__chat">-->
<!--    <i class="bi bi-chat"></i>-->
<!--  </span>-->
<!--</div>-->

<!-- Registration Form -->
<div id="registrationForm" class="chat-box">
  <div class="card">
    <div class="card-header d-flex justify-content-end align-items-center">
      <button type="button" class="btn-close" onclick="toggleChat()"></button>
    </div>
    <div class="card-body">
      <div class="header-body d-flex">
        <div class="logo-placeholder mb-3">
          <img height="48" width="48" src="../img/logo32.png" alt="icon">
        </div>
        <h6 class="mb-0" style="font-style: italic">Văn Khánh Store sẵn sàng hỗ trợ quý khách</h6>
      </div>
      <form onsubmit="event.preventDefault(); startChat();">
        <div class="mb-3">
          <label for="title" class="form-label">Quý khách muốn xưng hô là: *</label>
          <select class="form-select form-select-sm" id="title" required>
            <option value="">Chọn cách xưng hô với quý khách</option>
            <option value="anh">Anh</option>
            <option value="chi">Chị</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="name" class="form-label">Tên của quý khách là: *</label>
          <input type="text" class="form-control form-control-sm" id="name" placeholder="Nhập tên của quý khách"
            required>
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Số điện thoại của quý khách là: *</label>
          <input type="tel" class="form-control form-control-sm" id="phone"
            placeholder="Nhập số điện thoại của quý khách" required>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="terms" required>
          <label class="form-check-label small" for="terms">
            Bằng việc chọn Bắt đầu chat, quý khách đã đồng ý với các <a href="#" target="_blank">Điều khoản công ty</a>

          </label>
        </div>
        <button type="submit" class="btn btn-sm w-100">Bắt đầu chat</button>
      </form>
    </div>
  </div>
</div>

<!-- Chat Window -->
<div id="chatWindow" class="chat-box">
  <div class="card">
    <div class="card-header d-flex justify-content-end align-items-center">
      <button type="button" class="btn-close" onclick="toggleChat()"></button>
    </div>
    <div class="card-body chat-body">
      <!-- Messages Area -->
      <div class="messages-container" id="messagesBlock">
        <div class="chat-messages">
          <span class="usr-tit op-tit">
            <i title="Hỗ trợ trực tuyến" class="bi bi-person-fill"></i>
            <span class="op-nick-title ">Hỗ trợ trực tuyến</span>
          </span>
          <div class="bot-message">
            <p>Chào <span id="customerName"></span>, để được hỗ trợ</p>
            <p>
              Chị có thể sử dụng các lựa chọn tư vấn nhanh bên dưới để tìm câu trả lời cho thắc mắc của mình một cách
              nhanh chóng.
            </p>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
          <button class="quick-action-btn">Đơn hàng gần đây</button>
          <button class="quick-action-btn">Hỗ trợ đổi trả</button>
          <button class="quick-action-btn">Trạng thái đơn hàng</button>
        </div>

      </div>

      <!-- Input Area -->
      <div class="chat-input-area">
        <div class="input-wrapper">
          <button class="chat-option-btn">
            <i class="bi bi-gear-fill"></i>
          </button>
          <div class="area">
            <textarea id="CSChatMessage" class="chat-input" placeholder="Nhập và bấm enter để gửi !" rows="1"
              maxlength="499"
              class="pl-0 no-outline form-control rounded-0 form-control border-left-0 border-right-0 border-0 msg-one-line"></textarea>
          </div>
          <button class="chat-send-btn">
            <i class="bi bi-send-fill"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <div class="divider">
  <img src="../img/divider.png" alt="divider" />
</div> -->


<!-- categories -->
<section class="categories" id="categories">
  <div class="heading">
    <h1>
      Hàng đầu <br />
      <span>Danh mục</span>
    </h1>
    <a href="#" class="btn">Tất cả<i class="bi bi-arrow-right-short"></i></a>
  </div>
  <!-- Container Content -->
  <div class="categories-container">
    <!-- Box 1 -->
    <div class="box box1">
      <img src="../img/frutts.png" loading="lazy" alt="" />
      <h2>Trái cây</h2>
      <span> <?php
      $sanPham = "SELECT * FROM `tbl_sanpham` RIGHT JOIN tbl_baivietcuasanpham ON tbl_sanpham.MaSanPham = tbl_baivietcuasanpham.MaSanPham WHERE Loai LIKE 'Trái%cây'";
      $tongSoSanPham_Chay = mysqli_query($conn, $sanPham);
      if ($tongSoSanPham = mysqli_num_rows($tongSoSanPham_Chay)) {
        echo '<h6 class="mb-0">' . $tongSoSanPham . ' loại</h6>';
      } else {
        echo '<h6 class="mb-0">Không có dữ liệu</h6>';
      }
      ?></span>
      <i class="bi bi-arrow-right-short"></i>
    </div>
    <!-- Box 2 -->
    <div class="box box2">
      <img src="../img/vegetables.png" loading="lazy" alt="" />
      <h2>Rau củ</h2>
      <span> <?php
      $sanPham = "SELECT * FROM `tbl_sanpham` RIGHT JOIN tbl_baivietcuasanpham ON tbl_sanpham.MaSanPham = tbl_baivietcuasanpham.MaSanPham WHERE Loai LIKE 'Rau%củ'";
      $tongSoSanPham_Chay = mysqli_query($conn, $sanPham);
      if ($tongSoSanPham = mysqli_num_rows($tongSoSanPham_Chay)) {
        echo '<h6 class="mb-0">' . $tongSoSanPham . ' loại</h6>';
      } else {
        echo '<h6 class="mb-0">Không có dữ liệu</h6>';
      }
      ?></span>
      <i class="bi bi-arrow-right-short"></i>
    </div>
    <!-- Box 3 -->
    <div class="box box3">
      <img src="../img/nuts.png" loading="lazy" alt="" />
      <h2>Các loại hạt</h2>
      <span> <?php
      $sanPham = "SELECT * FROM `tbl_sanpham` RIGHT JOIN tbl_baivietcuasanpham ON tbl_sanpham.MaSanPham = tbl_baivietcuasanpham.MaSanPham WHERE Loai LIKE '%hạt'";
      $tongSoSanPham_Chay = mysqli_query($conn, $sanPham);
      if ($tongSoSanPham = mysqli_num_rows($tongSoSanPham_Chay)) {
        echo '<h6 class="mb-0">' . $tongSoSanPham . ' loại</h6>';
      } else {
        echo '<h6 class="mb-0">Không có dữ liệu</h6>';
      }
      ?></span>
      <i class="bi bi-arrow-right-short"></i>
    </div>
  </div>
</section>
<!-- Products -->
<section class="products" id="products">
  <div class="heading">
    <h1>
      Phổ biến <br />
      <span>Sản phẩm</span>
    </h1>
    <a href="#" class="btn">Tất cả<i class="bi bi-arrow-right-short"></i></a>
  </div>
  <!-- Product Content -->
  <div class="products-container">
    <!-- Box1 -->
    <?php
    include("../php/vproduct.php");
    $p = new vSanPham();
    $p->vdsbaiviet();
    ?>



  </div>
</section>

<!-- About -->
<section class="about" id="about">
  <div class="mb-5 mb-lg-0 img-container-about">
    <div class="d-flex h-100 pt-4">
      <img src="../img/Heart Vegetables .png" loading="lazy" alt="" />

    </div>

  </div>
  <div class="about-text">
    <span>Về chúng tôi</span>
    <p>
      Với nhiều năm kinh nghiệm phân phối nông sản sạch cùng với đó là sự hỗ
      trợ quý giá từ đội ngũ nhân viên, <strong>Văn Khánh Store</strong> đã khẳng
      định được vị thế của mình trên thị trường trong và ngoài nước. Đồng
      thời nhận được rất nhiều sự ủng hộ cũng như đánh giá cao từ khách hàng
      và đối tác.
    </p>
    <a href="#" class="btn" style="width=130px;">Chi tiết<i class="bi bi-arrow-right-short"></i></a>
  </div>
</section>
<!-- Customer -->
<section class="customer" id="customer">
  <h2>Khách hàng của chúng tôi</h2>
  <div class="customer-container">
    <!-- Review 1 -->
    <div class="box">
      <div class="review-profile">
        <img src="../img/gogi.png" loading="lazy" alt="" />
      </div>
    </div>
    <!-- Review 2 -->
    <div class="box">
      <div class="review-profile">
        <img src="../img/haidilao logo.png" loading="lazy" alt="" />
      </div>
    </div>
    <!-- Review 3 -->
    <div class="box">
      <div class="review-profile">
        <img src="../img/hakifood.png" loading="lazy" alt="" />
      </div>
    </div>
  </div>
</section>
<!-- Scroll To Top -->
<div class="scrollTop" onclick="scrollToTop()">
  <i class="bi-arrow-up"></i>
</div>
<script>
  $(document).ready(function () {
    var toastEl = document.getElementById("myToast");
    var toast = new bootstrap.Toast(toastEl);
    toast.show();
  });
</script>
<script>
  function toggleChat() {
    const registrationForm = document.getElementById('registrationForm');
    const chatWindow = document.getElementById('chatWindow');

    if (registrationForm.classList.contains('active') || chatWindow.classList.contains('active')) {
      registrationForm.classList.remove('active');
      chatWindow.classList.remove('active');
    } else {
      registrationForm.classList.add('active');
    }
  }

  function startChat() {
    const name = document.getElementById('name').value;
    document.getElementById('customerName').textContent = name;

    document.getElementById('registrationForm').classList.remove('active');
    document.getElementById('chatWindow').classList.add('active');
  }
</script>
<?php
include("../php/footer_homePage.php");
?>
<?php

// Thông báo thành công
if (isset($_SESSION["message"])) {
  ?>
  <div class='toast alert-success' id="myToast" style='
          display: flex;
          align-items: center;

          background-color: #fff;
          border-radius: 2px;
          min-width: 400px;
          max-width: 450px;
          min-height: 70px;
          max-height: 80px;
          padding: 20px 0;
          border-left: 4px solid #47d864;
          box-shadow: 0 5px 8px rgba(0, 0, 0, 0.08);
          position: fixed; top: 60px; right: 10px; z-index: 10000
        ' role='alert' aria-live='assertive' aria-atomic='true'>
    <div class="icon" style="padding: 0 16px; font-size: 24px; color: #47d864">
      <i class="bi bi-check-circle-fill"></i>
    </div>
    <div class="body" style="flex-grow: 1">
      <h3 class="title" style="font-size: 16px; font-weight: 600px; color: #47d864;padding-top: 0.25rem;">
        <strong>Thành công</strong>
      </h3>
      <p class="msg" style="
              font-size: 14px;
              color: #888;
              margin-top: 4px;
              line-height: 1.4;
            ">
        <?php echo $_SESSION["message"]; ?>
      </p>
    </div>
    <div class="close" width="50" style="padding: 0 16px">
      <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
    </div>
  </div>
  <?php
  unset($_SESSION["message"]);
}
?>
<style>
  .toast.hide {
    opacity: 0;
    transition: opacity 0.5s ease;
  }
</style>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Listen for toast close event
    document.querySelectorAll(".btn-close").forEach((closeBtn) => {
      closeBtn.addEventListener("click", function () {
        const toast = closeBtn.closest(".toast");
        if (toast) {
          toast.addEventListener("transitionend", function () {
            toast.remove();
          });
          toast.classList.add("hide"); // Add a hide class or animation
        }
      });
    });
  });

</script>

<?php

// Thông báo không thành công
if (isset($_SESSION["errorMessages"])) {
  ?>
  <div class='toast alert-error' id="myToast" style='
          display: flex;
          align-items: center;

          background-color: #fff;
          border-radius: 2px;
          min-width: 400px;
          max-width: 450px;
          min-height: 70px;
          max-height: 85px; 
          padding: 20px 0;
          border-left: 4px solid #ff0101;
          box-shadow: 0 5px 8px rgba(0, 0, 0, 0.08);
          position: fixed; top: 60px; right: 10px; z-index: 10001' role='alert' aria-live='assertive'
    aria-atomic='true'>
    <div class="icon" style="padding: 0 16px; font-size: 24px; color: #ff0101">
      <i class='bi bi-exclamation-triangle-fill'></i>
    </div>
    <div class="body" style="flex-grow: 1">
      <h3 class="title" style="font-size: 16px; font-weight: 600px; color: #ff0101;padding-top: 0.25rem;">
        <strong>Lỗi</strong>
      </h3>
      <p class="msg" style="
              font-size: 14px;
              color: #888;
              margin-top: 4px;
              line-height: 1.4;
            ">
        <?php
        if (is_array($_SESSION['errorMessages'])) {
          foreach ($_SESSION['errorMessages'] as $error) {
            echo $error . "<br>";
          }
        } else {
          echo $_SESSION["errorMessages"];
        }
        ?>
      </p>
    </div>
    <div class="close" width="50" style="padding: 0 16px">
      <button type='button' class='btn-close me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
    </div>
  </div>
  <?php
  unset($_SESSION["errorMessages"]);
}
?>
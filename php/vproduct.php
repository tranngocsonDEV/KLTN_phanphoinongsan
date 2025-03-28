<?php
class vSanPham
{

  // trang baiVietTruyXuatNG.php
  function viewdsbaiviet()
  {
    include("../modal/product.php");
    $p = new ModalSanPham();
    $tbl = $p->xemdsbaiviet();
    if (!$tbl) {
      return false;
    } else {
      while ($row = mysqli_fetch_assoc($tbl)) {
        $MaBaiViet = $row["MaBaiViet"];
        $TieuDe = $row["TieuDe"];
        $NoiDung = $row["NoiDung"];
        $NguonGoc = $row["NguonGoc"];
        $QRCodePath = $row["QR_IMG"];

        echo '     
                  <tr>
                      <td>' . $MaBaiViet . '</td>
                      <td>' . $TieuDe . '</td>
                      <td>' . $NoiDung . '</td>
                      <td>' . $NguonGoc . '</td>
                      <td>';
        if (!empty($QRCodePath)) {
          echo '<img src="' . $QRCodePath . '" alt="QR Code" class="img-thumbnail" style="width: 120px;" onclick="openQRCodePopup(\'' . $QRCodePath . '\')">';
        } else {
          echo 'Chưa có QR';
        }
        echo '</td>
                      <td>
                          <a href="./nvBaiVietTruyXuatNG_Xem.php?MaBaiViet=' . $MaBaiViet . '" class="btn btn-primary btn-md mb-1 w-100">Xem</a>
                          <a href="./nvBaiVietTruyXuatNG_Sua.php?MaBaiViet=' . $MaBaiViet . '" class="btn btn-warning btn-md mb-1 w-100">Sửa</a>
                          <button type="button" class="btn btn-danger btn-md mb-1 w-100" data-bs-toggle="modal" data-bs-target="#deleteModal" data-mabv="' . $MaBaiViet . '" data-tieude="' . $TieuDe . '">Xóa</button>
                      </td>
                  </tr>';
      }
    }
  }

  // này của trang homePage.php
  function vdsbaiviet()
  {
    include("../modal/product.php");
    $p = new ModalSanPham();
    $tbl = $p->dsbaiviet();
    if (!$tbl) {
      return false;

    } else {

      while ($row = mysqli_fetch_assoc($tbl)) {

        $MaBaiViet = $row["MaBaiViet"];
        $TieuDe = $row["TieuDe"];
        $HinhAnh = $row["HinhAnh"];




        echo '     
            <div class="box"  >
            <a href="ChiTietSanPham.php?MaBaiViet=' . $MaBaiViet . '"><img src="../img/' . $HinhAnh . '" alt="" />
            <span>Trái cây</span>
            <h2>' . $TieuDe . ' <br /></h2>
            <i class="bi bi-cart3"></i>
            <i class="bi bi-suit-heart"></i>
            </a>
          </div>
       ';


      }
    }
  }

  // này của trang ChiTietSanPham.php
  function xemctbaiviet($MaBaiViet)
  {
    include("../modal/product.php");
    $p = new ModalSanPham();
    $tbl = $p->xemBaiViet($MaBaiViet);

    if (!$tbl) {
      echo '<div class="text-center text-danger">Bài viết không tồn tại hoặc đã bị xóa.</div>';
      return false;
    }

    while ($row = mysqli_fetch_assoc($tbl)) {
      $MaBaiViet = $row["MaBaiViet"];
      $TieuDe = $row["TieuDe"];
      $NguonGoc = $row["NguonGoc"];
      $NoiDung = nl2br($row["NoiDung"]);
      $HinhAnh = $row["HinhAnh"];

      echo '
          <div class="row mb-4">
              <div class="col-md-12 text-center">
                  <h1 class="fw-bold fs-3 text-primary" id="du-lieu-title">' . $TieuDe . '</h1>
              </div>
          </div>
  
          <div class="row align-items-center">
              <!-- Hình ảnh -->
              <div class="col-lg-6 mb-4 text-center">
                  <img
                      src="../img/' . $HinhAnh . '"
                      class="img-fluid rounded shadow"
                      alt="' . $TieuDe . '"
                      style="max-width: 100%; height: auto;"
                  />
              </div>
  
              <!-- Thông tin sản phẩm -->
              <div class="col-lg-6">
                  <h2 class="fw-bold text-success mb-3">' . $TieuDe . '</h2>
                  <p class="price text-danger fs-5 mb-4">
                      <strong>Giá bán:</strong> <span>Liên hệ</span>
                  </p>
                  <div class="text-nguon-goc mb-4">
                      <p class="text-muted">' . $NguonGoc . '</p>
                  </div>
                  <div class="nut">
                      <button class="btn btn-primary btn-lg px-4 py-2">
                          Liên hệ ngay: 0398481308
                      </button>
                  </div>
              </div>
          </div>
  
          <!-- Chi tiết sản phẩm -->
          <div class="row mt-5">
              <div class="col-12">
                  <div
                      class="py-2 px-3 mb-3"
                      style="
                          border-bottom: 2px solid #ddd;
                          background: #f9f9f9;
                          font-weight: 600;
                          color: #3399ff;
                          text-transform: uppercase;
                      "
                  >
                      Chi tiết sản phẩm
                  </div>
                  <div class="noidungsanpham px-3">
                      <h3 class="text-center text-secondary mb-4">
                          <strong>' . $TieuDe . '</strong>
                      </h3>
                      <p class="text-justify text-dark" style="line-height: 1.8;">
                          ' . $NoiDung . '
                      </p>
                  </div>
              </div>
          </div>
          ';
    }
  }

}
?>
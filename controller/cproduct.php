<?php
include("../modal/product.php");
class ControllerSanPham
{


    function modalinsertBB8($MaBaiViet, $TieuDe, $NoiDung, $HinhAnh, $NguonGoc, $MaSanPham)
    {
        $p = new ModalSanPham();
        $tbl = $p->modalinsertBB8($MaBaiViet, $TieuDe, $NoiDung, $HinhAnh, $NguonGoc, $MaSanPham);
        if (!$tbl) {
            echo "<script>alert('Tạo bài viết không thành công');</script>";
            echo '<script>window.location="taoBaiVietTruyXuatNG.php";</script>';

            return false;

        } else {

            echo "<script>alert('Tạo bài viết thành công');</script>";
            // echo '<script>window.location="phieuBienBan.php";</script>';
            echo '<script>window.location="nvBaiVietTruyXuatNG.php";</script>';
            return true;
        }

    }
}

?>
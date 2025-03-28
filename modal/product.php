<?php
include("connect.php");
class ModalSanPham
{




    function xemdsbaiviet()
    {

        $p = new KetNoiDB();
        if ($p->moKetNoi($conn)) {
            $query = "SELECT b.MaBaiViet, b.TieuDe, b.NoiDung, b.NguonGoc, QR_IMG
        FROM tbl_baivietcuasanpham AS b";

            $tbl = mysqli_query($conn, $query);
            return $tbl;
        } else {
            return false;
        }
    }
    //insert vào database tbl_baivietcuasanpham ở phần tạo bài viết
    function modalinsertBB8($MaBaiViet, $TieuDe, $NoiDung, $HinhAnh, $NguonGoc, $MaSanPham)
    {

        $p = new KetNoiDB();
        if ($p->moKetNoi($conn)) {
            $query = "INSERT INTO tbl_baivietcuasanpham (MaBaiViet, MaSanPham, TieuDe, NoiDung, HinhAnh, NguonGoc, QR_IMG )
        VALUES ('$MaBaiViet', '$TieuDe', '$NoiDung', '$HinhAnh', '$NguonGoc', '$MaSanPham')";

            $tbl = mysqli_query($conn, $query);
            return $tbl;
        } else {
            return false;
        }
    }
    // Xem chi tiết bài viết này là trang ChiTietSanPham.php
    public function xemBaiViet($MaBaiViet)
    {
        $p = new KetNoiDB();
        if ($p->moKetNoi($conn)) {
            $query = "SELECT * FROM tbl_baivietcuasanpham WHERE MaBaiViet = '$MaBaiViet'";
            return mysqli_query($conn, $query);
        }
    }
    // Xem danh sách sản phẩm ở trang homePage.php
    public function dsbaiviet()
    {
        $p = new KetNoiDB();
        if ($p->moKetNoi($conn)) {
            $query = "SELECT * FROM tbl_baivietcuasanpham";
            return mysqli_query($conn, $query);
        }
    }




}


?>
<?php

include("../config/init.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    try {
        $MaPhieuNhap = $_POST['maphieu'];
        $NgayNhanHang = $_POST['NgayNhapKho'];
        $products = isset($_POST['productData']) ? json_decode($_POST['productData'], true) : [];
        $MaPhieuNhapDoiTra = $_POST['MaPhieuNhap'];
        $type = $_POST['type'];

        if ($type === 'phieu_nhap') {
            $MaTrangThaiPhieu = '7';
            $stmtPhieuNhap = $conn->prepare("UPDATE tbl_phieunhap SET  MaTrangThaiPhieu =?, NgayNhanHang=? WHERE MaPhieuNhap=?");
            $stmtPhieuNhap->bind_param("sss", $MaTrangThaiPhieu, $NgayNhanHang, $MaPhieuNhap);
            if (!$stmtPhieuNhap->execute()) {
                throw new Exception("Không thể cập nhật vào tbl_phieunhap: " . $stmtPhieuNhap->error);
            }
            foreach ($products as $product) {
                $MaSanPham = $product['MaSanPham'];
                $SoLuong = $product['SoLuong'];

                $stmtSanPham = $conn->prepare("UPDATE tbl_sanpham SET  SoLuongTon= SoLuongTon + ? WHERE MaSanPham=?");
                $stmtSanPham->bind_param("ss", $SoLuong, $MaSanPham);
                if (!$stmtSanPham->execute()) {
                    throw new Exception("Không thể cập nhật vào tbl_sanpham: " . $stmtSanPham->error);
                }
            }

        } elseif ($type === 'doi_tra') {
            $MaTrangThaiPhieu = '7';
            $stmtDoiTra = $conn->prepare("UPDATE tbl_phieunhap SET  MaTrangThaiPhieu =?, NgayNhanHang=? WHERE MaPhieuNhap = ?");
            $stmtDoiTra->bind_param("sss", $MaTrangThaiPhieu, $NgayNhanHang, $MaPhieuNhapDoiTra);
            if (!$stmtDoiTra->execute()) {
                echo "Failed to update tbl_phieunhap: " . $stmtDoiTra->error . "<br>";
                throw new Exception("Transaction rolled back.");
            }
            foreach ($products as $product) {
                $MaSanPham = $product['MaSanPham'];
                $SoLuong = intval($product['SoLuong']);

                $stmtSanPham = $conn->prepare("UPDATE tbl_sanpham SET  SoLuongTon= SoLuongTon + ? WHERE MaSanPham=?");
                $stmtSanPham->bind_param("ss", $SoLuong, $MaSanPham);
                if (!$stmtSanPham->execute()) {
                    throw new Exception("Không thể cập nhật vào tbl_sanpham: " . $stmtSanPham->error);
                }
            }
        }

        $conn->commit();
        $_SESSION['message'] = "Xác nhận nhập kho thành công!";
        header("Location: ../view/nvCapNhatSoLuongNhap.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['errorMessages'] = "Lỗi khi xử lý yêu cầu!" . $e->getMessage();
        header("Location: ../view/nvCapNhatSoLuongNhap.php");
        exit;
    } finally {
        $conn->close();
    }

}

?>
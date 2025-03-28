<?php

include("../config/init.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->begin_transaction();
    try {
        $type = $_POST['type']; // Loại phiếu (phieu_xuat hoặc doi_tra)
        $MaPhieu = $_POST['maphieu'];
        $NgayXuatHang = $_POST['NgayXuatKho'];
        $products = isset($_POST['productData']) ? json_decode($_POST['productData'], true) : [];

        if ($type === 'phieu_xuat') {
            // Xử lý Phiếu Xuất
            $MaTrangThaiPhieu = '16';

            // Cập nhật trạng thái phiếu xuất
            $stmtPhieuXuat = $conn->prepare("UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = ?, NgayXuatHang = ? WHERE MaPhieuXuat = ?");
            $stmtPhieuXuat->bind_param("sss", $MaTrangThaiPhieu, $NgayXuatHang, $MaPhieu);
            if (!$stmtPhieuXuat->execute()) {
                throw new Exception("Không thể cập nhật vào tbl_phieuxuat: " . $stmtPhieuXuat->error);
            }

            // Cập nhật số lượng sản phẩm
            foreach ($products as $product) {
                $MaSanPham = $product['MaSanPham'];
                $SoLuong = $product['SoLuong'];

                $stmtSanPham = $conn->prepare("UPDATE tbl_sanpham SET SoLuongTon = SoLuongTon - ? WHERE MaSanPham = ?");
                $stmtSanPham->bind_param("is", $SoLuong, $MaSanPham);
                if (!$stmtSanPham->execute()) {
                    throw new Exception("Không thể cập nhật vào tbl_sanpham: " . $stmtSanPham->error);
                }
            }
        } elseif ($type === 'doi_tra') {
            $MaTrangThaiPhieu = '16'; // Trạng thái xử lý yêu cầu đổi trả

            // Cập nhật trạng thái yêu cầu đổi trả
            $stmtDoiTra = $conn->prepare("UPDATE tbl_yeucaudoitra SET MaTrangThaiPhieu = ?, NgayXuatDoiTra = ? WHERE MaYeuCauDoiTra = ?");
            $stmtDoiTra->bind_param("sss", $MaTrangThaiPhieu, $NgayXuatHang, $MaPhieu);
            if (!$stmtDoiTra->execute()) {
                throw new Exception("Không thể cập nhật vào tbl_yeucaudoitra: " . $stmtDoiTra->error);
            }

            // Xử lý chi tiết đổi trả
            foreach ($products as $product) {
                $MaSanPham = $product['MaSanPham'];
                $SoLuong = $product['SoLuong'];

                // Ví dụ: Cập nhật bảng khác nếu cần xử lý đổi trả
                $stmtSanPham = $conn->prepare("UPDATE tbl_sanpham SET SoLuongTon = SoLuongTon - ? WHERE MaSanPham = ?");
                $stmtSanPham->bind_param("is", $SoLuong, $MaSanPham);
                if (!$stmtSanPham->execute()) {
                    throw new Exception("Không thể cập nhật vào tbl_sanpham: " . $stmtSanPham->error);
                }
            }
        }

        $conn->commit();
        $_SESSION['message'] = "Xác nhận xử lý thành công!";
        header("Location: ../view/nvCapNhatSoLuongXuat.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['errorMessages'] = "Lỗi khi xử lý yêu cầu!" . $e->getMessage();
        header("Location: ../view/nvCapNhatSoLuongXuat.php");
        exit;
    } finally {
        $conn->close();
    }
}

?>
<?php
include("../config/init.php");
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra action
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Nhận dữ liệu từ yêu cầu AJAX
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $maPhieuXuat = isset($_POST['maPhieuXuat']) ? $_POST['maPhieuXuat'] : null;

    if ($status && $maPhieuXuat) {
        $currentTime = date('Y-m-d H:i:s');

        if ($action == 'delivery_confirm') {
            // Cập nhật trạng thái thành "Đang giao hàng"
            $updateQuery = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = ?, ThoiGianXacNhan = ? WHERE MaPhieuXuat = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("isi", $status, $currentTime, $maPhieuXuat);
            $stmt->execute();

            // Truy vấn trạng thái mới
            $selectQuery = "SELECT Ten FROM tbl_a_trangthaiphieuyeucau WHERE MaTrangThaiPhieu = ?";
            $stmt3 = $conn->prepare($selectQuery);
            $stmt3->bind_param("i", $status);
            $stmt3->execute();
            $result = $stmt3->get_result();
            $row = $result->fetch_assoc();

            // Trả về phản hồi
            $response = [
                'type' => 'success',
                'message' => "Trạng thái cập nhật: " . $row['Ten'] . " - vào thời gian: " . $currentTime,
                'button' => '<button type="submit" name="pickup_confirm" id="pickup_confirm" class="btn btn-primary btn-lg pickup_confirm" data-status="11">Đã lấy hàng</button>'
            ];
            echo json_encode($response);
        }

        if ($action == 'pickup_confirm') {
            $updateQuery = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = ?, ThoiGianDangGiao = ? WHERE MaPhieuXuat = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("isi", $status, $currentTime, $maPhieuXuat);
            $stmt->execute();


            // Lấy thêm dữ liệu
            $selectQuery = "
                    SELECT u2.IDNhanVien AS IDNhanVienGiaoHang, u2.Ten AS TenNhanVienGiaoHang, ctpx.TongTien
                    FROM tbl_chitietphieuxuat ctpx
                    JOIN tbl_phieuxuat px ON px.MaPhieuXuat = ctpx.MaPhieuXuat
                    JOIN tbl_shipper ship ON ctpx.MaShipper = ship.MaShipper
                    JOIN tbl_user u2 ON u2.IDNhanVien = ship.MaShipper
                    WHERE px.MaPhieuXuat =  ?";
            $stmt2 = $conn->prepare($selectQuery);
            $stmt2->bind_param("s", $maPhieuXuat);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $row2 = $result2->fetch_assoc();

            $response = [
                'type' => 'success',

                'message' => "Đã chuyển sang trạng thái 'Đã giao hàng' - vào thời gian " . $currentTime,
                'button' => '<button type="submit" name="complete_delivery" 
                                  id="complete_delivery" 
                                  class="btn btn-success btn-lg complete_delivery" 
                                  data-status="13" 
                                  data-nhanviengiaohang="' . htmlspecialchars($row2['IDNhanVienGiaoHang']) . '" 
                                  data-tongtien="' . htmlspecialchars($row2['TongTien']) . '">Đã giao hàng</button>'
            ];
            echo json_encode($response);
        }
        if ($action == 'complete_delivery') {
            $conn->begin_transaction();
            $TinhTrang = 'Rảnh';
            $TrangThaiThanhToan = 'Đã thanh toán';
            $MaShipper = isset($_POST['MaShipper']) ? $_POST['MaShipper'] : null;
            $TongTien = isset($_POST['TongTien']) ? $_POST['TongTien'] : null;

            $updateQuery = "UPDATE tbl_phieuxuat SET MaTrangThaiPhieu = ?, ThoiGianDaGiao = ? WHERE MaPhieuXuat = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("isi", $status, $currentTime, $maPhieuXuat);
            if (!$stmt->execute()) {
                throw new Exception("Không thể chèn vào tbl_phieuxuat: " . $stmtPhieuNhap->error);
            }


            $updateQuery_User = "UPDATE tbl_shipper SET TinhTrang = ? WHERE MaShipper = ?";
            $stmt = $conn->prepare($updateQuery_User);
            $stmt->bind_param("si", $TinhTrang, $MaShipper);
            if (!$stmt->execute()) {
                throw new Exception("Không thể chèn vào tbl_shipper: " . $stmtPhieuNhap->error);
            }
            $updateQuery_TT = "UPDATE tbl_thanhtoan SET MaPhieuXuat = ?, SoTienThanhToan = ? , TrangThaiThanhToan = ? WHERE MaPhieuXuat = ?";
            $stmt = $conn->prepare($updateQuery_TT);
            $stmt->bind_param("iisi", $maPhieuXuat, $TongTien, $TrangThaiThanhToan, $maPhieuXuat);
            if (!$stmt->execute()) {
                throw new Exception("Không thể chèn vào tbl_thanhtoan: " . $stmtPhieuNhap->error);
            }
            $conn->commit();
            $_SESSION['message'] = "Đã giao hàng thành công!";
            echo json_encode([
                'success' => true,
                'message' => 'Trạng thái đã cập nhật thành công!'
            ]);
        }
    } else {
        echo json_encode(['error' => 'Dữ liệu không hợp lệ.']);
    }
}
?>
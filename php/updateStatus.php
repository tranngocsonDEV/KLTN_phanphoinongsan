<?php
require "../php/connect.php";
$data = json_decode(file_get_contents("php://input"), true);
$idNhanVien = $data['IDNhanVien'];
$trangThaiLamViec = $data['TrangThaiLamViec'];

$sql = "UPDATE tbl_user SET TrangThaiLamViec = ? WHERE IDNhanVien = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $trangThaiLamViec, $idNhanVien);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
$stmt->close();
$conn->close();
?>
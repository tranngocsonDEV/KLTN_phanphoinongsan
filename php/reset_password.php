<?php
require __DIR__ . '/../vendor/autoload.php';
require "../php/connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$data = $_POST;
$idNhanVien = isset($data['IDNhanVien']) ? $data['IDNhanVien'] : null;
$email = isset($data['Email']) ? $data['Email'] : null;

// Kiểm tra nếu IDNhanVien và Email không phải null
if ($idNhanVien && $email) {
    // Tạo mật khẩu tạm thời
    $tempPassword = bin2hex(random_bytes(5)); // Mật khẩu ngẫu nhiên 10 ký tự
    $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT); // Hash mật khẩu

    // Cập nhật mật khẩu trong cơ sở dữ liệu
    $sql = "UPDATE tbl_user SET Password = ? WHERE IDNhanVien = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $idNhanVien);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Đổi thành SMTP của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'cristran919@gmail.com'; // Email của bạn
            $mail->Password = 'qzkhxypiuyusvkyn'; // Mật khẩu email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('cristran919@gmail.com', 'Admin');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = "Mật khẩu tạm thời của bạn là: <strong>$tempPassword</strong>";

            $mail->send();

            echo json_encode(["status" => "success", "message" => "Mật khẩu đã được gửi tới email."]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Không thể gửi email: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Cập nhật mật khẩu thất bại!"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ."]);
}
?>
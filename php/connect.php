<?php


$conn = new mysqli("vankhanhstore.id.vn", "prgwzkun_son_kltn", "R@fqDeFv26XJWcs", "prgwzkun_phanphoinongsan");

mysqli_set_charset($conn, "utf8mb4");

if ($conn->connect_error) {
  echo "Lỗi kết nối MYSQLLi" . $conn->connect_error;
  exit();
}
?>
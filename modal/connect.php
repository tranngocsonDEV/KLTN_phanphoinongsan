<?php
class KetNoiDB
{
    function moKetnoi(&$conn)
    {
$conn = new mysqli("vankhanhstore.id.vn", "prgwzkun_son_kltn", "R@fqDeFv26XJWcs", "prgwzkun_phanphoinongsan");
        if ($conn) {
            mysqli_set_charset($conn, "utf8");
            return $conn;
        } else {
            return false;
        }
    }

    function dongKetNoi($conn)
    {
        mysqli_close($conn);
    }
}
?>
<?php
include("../php/connect.php");

if (isset($_POST["SearchFormText"])) {
    $SearchFormText = mysqli_real_escape_string($conn, $_POST["SearchFormText"]);

    $sql = "SELECT MaBaiViet, HinhAnh, TieuDe FROM `tbl_baivietcuasanpham` WHERE TieuDe LIKE '%" . $SearchFormText . "%' ORDER BY TieuDe DESC LIMIT 5";
    $query_run = mysqli_query($conn, $sql);

    $output = '';

    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $hinhAnh = '../img/' . $row['HinhAnh'];
            $url = '../view/ChiTietSanPham.php?MaBaiViet=' . $row['MaBaiViet'];
            $output .= '
                <div class="search-result-item">
                    <a href="' . $url . '" class="d-flex align-items-start">
                        <div class="img-container">
                            <img src="' . $hinhAnh . '" alt="' . $row['TieuDe'] . '">
                        </div>
                        <div class="text-container">
                            <h5>' . $row['TieuDe'] . '</h5>
                        </div>
                    </a>
                </div>
            ';
        }
    } else {
        $output .= '<div class="p-2">Không tìm thấy kết quả</div>';
    }

    echo $output;
}

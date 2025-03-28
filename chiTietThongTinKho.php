<?php
include("../php/connect.php");
?>

<?php
if (isset($_GET["MaSanPham"])) {
    $MaSanPham = $_GET["MaSanPham"];
}
?>

<?php


$sql = "SELECT * FROM `tbl_sanpham` WHERE MaSanPham = '$MaSanPham'";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
?>

<?php

if (isset($_POST['suaSanPham'])) {
    $MaSanPham = $_POST['MaSanPham'];
    $TenSanPham = $_POST['TenSanPham'];
    $SoLuongTon = $_POST['SoLuongTon'];
    $DonVi = $_POST['DonVi'];
    $errors = []; 

    $checkSoluong = "SELECT SoLuongTon FROM tbl_sanpham WHERE SoLuongTon = '".$SoLuongTon."'";
    $checkSoluong_run = mysqli_query($conn, $checkSoluong);

    
    if ($MaSanPham == "") {
        $errors[] = "Vui lòng nhập mã sản phẩm!";
    }
    if ($TenSanPham == "") {
        $errors[] = "Vui lòng nhập vào tên sản phẩm!";
    }
    if ($SoLuongTon == "") {
        $errors[] = "Vui lòng nhập vào số lượng tồn!";
    }
    if ($SoLuongTon == 0) {
        $errors[] = "Vui lòng nhập vào số lượng tồn!";
    }
   
    if ($DonVi == "") {
        $errors[] = "Vui lòng nhập vào đơn vị!";
    }
    if (!empty($errors)) {
        $_SESSION['errorMessages'] = $errors; 
        header("Location: nvQuanLyKho.php");
        exit;
    }
    if(mysqli_num_rows($checkSoluong_run) > 0){
        $_SESSION['errorMessages'] = "Vui lòng thay đổi số lượng tồn!" ;
        header("Location: nvQuanLyKho.php");
        exit;
    }else{
        $sql = "UPDATE `tbl_sanpham` SET `TenSanPham`='$TenSanPham',`SoLuongTon`='$SoLuongTon',`DonVi`='$DonVi'
        WHERE MaSanPham = $MaSanPham";  
        $query_run = mysqli_query($conn, $sql);
    
        if ($query_run) {
        $_SESSION['message'] = "Sửa thành công!";
        header("Location: nvQuanLyKho.php");
        exit;
        } else {
        $_SESSION['errorMessages'] = "Có lỗi xảy ra! " ;
        header("Location: nvQuanLyKho.php");
        exit;
        }
    }

  

}    mysqli_close($conn);

?>



<?php 
include("../php/header_heThong.php");
?>


<?php 
include("../php/sidebar_heThong.php");
?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Chi tiết sản phẩm">Chi tiết sản phẩm</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Chi tiết</div>
                        <form class="form" action="" method="POST">
                       <div class="card-body">
                            <label for="maSanPham" class="form-label">Mã sản phẩm</label>
                            <input type="text" id="MaSanPham" class="form-control" name="MaSanPham" value="<?php echo $row['MaSanPham']; ?>">
                            <label for="tenSanPham" class="form-label">Tên sản phẩm</label>
                            <input type="text" id="TenSanPham" class="form-control" name="TenSanPham" value="<?php echo $row['TenSanPham']; ?>">
                            <label for="soLuongTon" class="form-label">Số lượng tồn</label>
                            <input type="text" id="soLuongTon" class="form-control" name="SoLuongTon" value="<?php echo $row['SoLuongTon']; ?>">
                            <label for="donVi" class="form-label">Đơn vị</label>
                            <input type="text" id="donVi" class="form-control" name="DonVi" value="<?php echo $row['DonVi']; ?>">
                            <br />
                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">
                                <a href="./xemThongTinKho.php" class="btn btn-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">Quay lại</a>
                                </div>
                            </div>
                        </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>
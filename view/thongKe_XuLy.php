<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Tạo file thongKe_XuLy.php
if (
    isset($_GET['MaLoai']) && $_GET['MaLoai'] != '' &&
    isset($_GET['NgayLap']) && $_GET['NgayLap'] != '' &&
    isset($_GET['NgayGiaoHang']) && $_GET['NgayGiaoHang'] != ''
) {

    $MaLoai = htmlspecialchars($_GET['MaLoai'], ENT_QUOTES, 'UTF-8');
    $NgayLap = htmlspecialchars($_GET['NgayLap'], ENT_QUOTES, 'UTF-8');
    $NgayGiaoHang = htmlspecialchars($_GET['NgayGiaoHang'], ENT_QUOTES, 'UTF-8');

    // Tính tổng số sản phẩm theo thời gian
    $query_sanpham = "SELECT SUM(SoLuong) as TongSoSanPham 
                     FROM tbl_phieuyeucau 
                     WHERE MaLoai = '$MaLoai' 
                     AND NgayLap = '$NgayLap'
                     AND NgayGiaoHang = '$NgayGiaoHang'
                     AND TrangThai = 'Đã giao hàng'";

    // Tính tổng số đơn hàng theo thời gian
    $query_donhang = "SELECT COUNT(*) as SoDonHang 
                      FROM tbl_phieuyeucau 
                      WHERE MaLoai = '$MaLoai' 
                      AND NgayLap = '$NgayLap'
                      AND NgayGiaoHang = '$NgayGiaoHang'
                      AND TrangThai = 'Đã giao hàng'";

    // Tính tổng doanh thu theo thời gian
    $query_doanhthu = "SELECT SUM(TongTien) as TongDoanhThu 
                       FROM tbl_phieuyeucau 
                       WHERE MaLoai = '$MaLoai' 
                       AND NgayLap = '$NgayLap'
                       AND NgayGiaoHang = '$NgayGiaoHang'
                       AND TrangThai = 'Đã giao hàng'";

    $result_sanpham = mysqli_query($conn, $query_sanpham);
    $result_donhang = mysqli_query($conn, $query_donhang);
    $result_doanhthu = mysqli_query($conn, $query_doanhthu);

    $data = array(
        'TongSoSanPham' => mysqli_fetch_assoc($result_sanpham)['TongSoSanPham'] ?? 0,
        'SoDonHang' => mysqli_fetch_assoc($result_donhang)['SoDonHang'] ?? 0,
        'TongDoanhThu' => mysqli_fetch_assoc($result_doanhthu)['TongDoanhThu'] ?? 0
    );

    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
?>
<script>
        // Thêm đoạn JavaScript này vào cuối file của bạn
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const queryString = new URLSearchParams(formData).toString();
        
        // Gọi AJAX để lấy dữ liệu thống kê mới
        fetch(`thongKe_XuLy.php?${queryString}`)
            .then(response => response.json())
            .then(data => {
                // Cập nhật các thẻ hiển thị thống kê
                document.querySelector('.bg-success .card-body h4').textContent = data.TongSoSanPham;
                document.querySelector('.bg-primary .card-body h4').textContent = data.SoDonHang;
                document.querySelector('.bg-danger .card-body h4').textContent = data.TongDoanhThu;
                
                // Cập nhật bảng và biểu đồ
                updateTableData();
            })
            .catch(error => console.error('Error:', error));
    });

    function updateTableData() {
        // Lấy form data
        const formData = new FormData(document.querySelector('form'));
        const queryString = new URLSearchParams(formData).toString();
        
        // Refresh bảng DataTable
        $('#example').DataTable().ajax.reload();
        
        // Cập nhật biểu đồ
        updateCharts();
    }

    function updateCharts() {
        const barData = extractTableDateAndSplit();
        
        // Cập nhật dữ liệu cho biểu đồ cột
        myChart.data.labels = barData.NgayGHTC;
        myChart.data.datasets[0].data = barData.TongTien;
        myChart.update();
        
        // Cập nhật dữ liệu cho biểu đồ đường
        myChart1.data.labels = barData.NgayGHTC;
        myChart1.data.datasets[0].data = barData.TongTien;
        myChart1.update();
    }
</script>
</body>
</html>
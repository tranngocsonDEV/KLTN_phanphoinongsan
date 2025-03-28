<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>

<?php
include("../config/init.php");
include("../php/thongBao.php");

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['ThongTinDangNhap']) || !isset($_SESSION['MaVaiTro'])) {
    $_SESSION['errorMessages'] = "Bạn phải đăng nhập để truy cập trang này!";
    header("Location: login.php");
    exit;
}

// Kiểm tra quyền truy cập: chỉ nhân viên kiểm kêkê (MaVaiTro = 3) mới được truy cập
if ($_SESSION['MaVaiTro'] != '3') {
    $_SESSION['errorMessages'] = "Bạn không có quyền truy cập trang này!";
    header("Location: login.php");
    exit;
}

?>
<?php include("../php/header_heThong.php"); ?>

<?php include("../php/sidebar_heThong.php"); ?>
<?php include("../php/connect.php"); ?>
<?php
session_start();
ob_start();
include("../php/thongBao.php");
?>

<main class="pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" s="du-lieu-title" data-title="Danh sách phiếu">Danh sách phiếu</div>
        </div>

        <!-- Loại phiếu -->
        <div class="row">
            <!-- Phân loại phiếu -->
            <div class="phanLoaiPhieu d-flex">

                <!-- Trạng thái phiếu nhập đổi trả -->
                <div class="row mb-2">
                    <div class="col">
                        <select class="form-select form-select-md" id="trangThaiSelect">
                            <option selected disabled>Trạng thái</option>
                            <option value="22">Chờ kiểm tra</option>
                            <option value="3">Đã kiểm tra</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-responsive data-table"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Mã phiếu đổi trả</th>
                                        <th>Mã phiếu nhập</th>
                                        <th>Người lập phiếu</th>
                                        <th>Ngày lập phiếu</th>
                                        <th>Lý do</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

    $(document).ready(function () {
        // Kiểm tra nếu DataTable đã được khởi tạo, xóa và khởi tạo lại
        if ($.fn.DataTable.isDataTable("#example")) {
            $("#example").DataTable().destroy();
        }

        // Khởi tạo DataTable
        const table = $("#example").DataTable({
            language: {
                decimal: "", // Dấu thập phân (có thể để trống nếu không sử dụng)
                emptyTable: "Không có dữ liệu trong bảng", // Thông báo khi bảng không có dữ liệu
                info: "Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ bản ghi", // Thông báo khi hiển thị thông tin bảng
                infoEmpty: "Hiển thị 0 đến 0 trong tổng số 0 bản ghi", // Thông báo khi không có bản ghi nào
                infoFiltered: "(đã lọc từ _MAX_ tổng số bản ghi)", // Thông báo khi có dữ liệu lọc
                infoPostFix: "", // Thêm hậu tố vào thông báo info (có thể để trống)
                thousands: ",", // Dấu phân cách hàng nghìn
                lengthMenu: "Hiển thị _MENU_ bản ghi", // Thông báo chọn số lượng bản ghi hiển thị
                loadingRecords: "Đang tải...", // Thông báo khi đang tải dữ liệu
                processing: "", // Thông báo khi đang xử lý (có thể để trống)
                search: "Tìm kiếm:", // Thông báo tìm kiếm
                zeroRecords: "Không tìm thấy kết quả", // Thông báo khi không tìm thấy kết quả

                aria: {
                    orderable: "Sắp xếp theo cột này", // Thông báo sắp xếp cột
                    orderableReverse: "Sắp xếp ngược lại cột này" // Thông báo sắp xếp ngược cột
                }
            },
            columns: [
                { data: "MaYeuCauDoiTra" },
                { data: "MaPhieuNhap" },
                { data: "TenNhanVienTaoPhieu" },
                { data: "NgayLapBienBan" },
                { data: "GhiChu" },
                {
                    data: null,
                    render: function (data, type, row) {
                        if (row.MaPhieuNhap === "Không có dữ liệu") {
                            return "";  // Không hiển thị nút "Xem" cho dòng "Không có dữ liệu"
                        }

                        let actionBtns = ` 
                            <a href="./nvkkXuLyDonHang_HienThi.php?MaPhieuNhap=${row.MaPhieuNhap}&MaBienBan=${row.MaBienBan}" 
                               class="btn btn-primary btn-md h-100 fs-6">Xem</a>`;
                        if (row.Type == 22) {
                            actionBtns = `
                            <a href="./nvkkXuLyDonHang_Nhap_HienThi.php?MaPhieuNhap=${row.MaPhieuNhap}" 
                               class="btn btn-warning btn-md h-100 fs-6">Kiểm kê</a>`;
                        }
                        return actionBtns;
                    },
                },
            ],
        });

        // Hàm tải dữ liệu phiếu và cập nhật DataTable
        function loadRequests(type) {
            $.ajax({
                url: "../php/nvkkXuLyDonHang_HienThi.php",
                method: "POST",
                data: { type: type },
                success: function (response) {
                    const requests = JSON.parse(response);
                    // console.log(response); // Kiểm tra dữ liệu trả về

                    // Kiểm tra dữ liệu rỗng
                    if (requests.length === 0) {
                        table.clear().draw(); // Xóa dữ liệu nếu không có dữ liệu mới
                        // Hiển thị thông báo "Không có dữ liệu"
                    } else {
                        // Cập nhật dữ liệu mới vào DataTable
                        table.clear().rows.add(requests).draw();
                    }
                },
                error: function () {
                    alert("Có lỗi xảy ra khi tải dữ liệu!");
                },
            });
        }

        // Mặc định tải dữ liệu phiếu nhập khi load trang
        loadRequests(22); // Loại phiếu nhập (type = 22)

        // Xử lý sự kiện nút ÁP DỤNG
        $("#trangThaiSelect").change(function () {
            const selectedType = $(this).val(); // Lấy giá trị trạng thái được chọn từ dropdown
            if (selectedType) {
                loadRequests(selectedType); // Gọi hàm tải dữ liệu dựa trên trạng thái được chọn
            }
        });
    });

</script>

</body>

</html>
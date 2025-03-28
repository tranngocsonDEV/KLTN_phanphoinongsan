<?php
include("../php/header_heThong.php");

include("../php/sidebar_heThong.php");
include("../config/init.php");
include("../php/thongBao.php");

?>
<!-- data-title -->
<div class="row">
    <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Phân phối">Phân phối</div>
</div>

<main class="mt-5 pt-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Mã Shipper</th>
                                        <th>Tên Nhân Viên</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="phanPhoiNhanVienModal" tabindex="-1" aria-labelledby="phanPhoiNhanVienLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="phanPhoiNhanVienLabel">Phân Phối Nhân Viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <p>Bạn có chắc chắn phân phối đơn hàng mã là <strong id="titleMaPhieuInput"></strong> cho nhân
                            viên
                            giao hàng
                            với mã là <strong id="titleMaShipperInput">
                            </strong> không?
                        </p>
                        <input type="hidden" id="maphieuInput" class="form-control" value="" readonly>
                        <input type="hidden" id="mashipperInput" class="form-control" value="" readonly>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary xacNhanPhanPhoi" name="xacNhanPhanPhoi">Xác
                        nhận</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

</main>
<script>
    $(document).ready(function () {
        // Lấy giá trị MaPhieuXuat từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const MaYeuCauDoiTra = urlParams.get('MaYeuCauDoiTra');
        const MaPhieuXuat = urlParams.get('MaPhieuXuat');

        // Khởi tạo DataTable
        const table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "phanPhoiDonHang_DuLieu.php", // Đường dẫn đến server xử lý dữ liệu
                type: "POST"
            },
            columns: [
                { data: "MaShipper", title: "Mã Shipper" },
                { data: "TenNhanVien", title: "Tên Nhân Viên" },
                {
                    data: null,
                    title: "Hành động",
                    render: function (data, type, row) {
                        return `
                        <button class="btn btn-primary ranh_btn" 
                                data-mayeucaudoitra="${MaYeuCauDoiTra}"
                                data-maphieuxuat="${MaPhieuXuat}" 
 
                                data-mashipper="${row.MaShipper}">
                            Phân phối
                        </button>`;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
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
            }
        });

        // Xử lý sự kiện click nút "Phân phối"
        $('#dataTable').on('click', '.ranh_btn', function (e) {
            e.preventDefault();

            // Lấy thông tin từ nút được nhấn
            const MaShipper = $(this).data('mashipper');
            const MaPhieu = $(this).data('mayeucaudoitra');
            const MaPhieuXuat = $(this).data('maphieuxuat');

            // Gán giá trị vào các trường input trong modal
            $('#maphieuInput').val(MaPhieu);
            $('#mashipperInput').val(MaShipper);

            // Hiển thị modal
            $('#phanPhoiNhanVienModal').modal('show');
        });
        $('.xacNhanPhanPhoi').on('click', function (e) {
            e.preventDefault();

            const MaShipper = $('#mashipperInput').val();
            const MaPhieu = $('#maphieuInput').val();

            // Gửi yêu cầu Ajax
            $.ajax({
                type: "POST",
                url: "phanPhoiDonHang_XacNhan_DoiTra.php",
                data: {
                    'xacNhanPhanPhoi': true,
                    'mashipperInput': MaShipper,
                    'maphieuxuatInput': MaPhieuXuat,
                    'maphieuInput': MaPhieu
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === "success") {
                        // Chuyển hướng đến URL được chỉ định trong phản hồi
                        window.location.href = response.redirect;
                    } else if (response.status === "error") {
                        // Nếu có lỗi, hiển thị thông báo lỗi và không chuyển hướng
                        alert("Lỗi: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Trạng thái: " + status);
                    console.error("Lỗi: " + error);
                    console.error("Phản hồi từ server: " + xhr.responseText);
                    alert("Đã xảy ra lỗi khi xử lý yêu cầu!");
                }
            });
        });


    });

</script>
<script>
    // Hàm để cập nhật giá trị vào titleMaPhieuInput và titleMaShipperInput
    function updateTitleInputs() {
        const maphieuValue = document.getElementById('maphieuInput').value;
        const mashipperValue = document.getElementById('mashipperInput').value;


        titleMaPhieuInput.textContent = maphieuValue;
        titleMaShipperInput.textContent = mashipperValue;


    }

    // Lắng nghe sự kiện khi modal được mở
    document.getElementById('phanPhoiNhanVienModal').addEventListener('shown.bs.modal', function () {
        updateTitleInputs();
    });
</script>


</body>

</html>
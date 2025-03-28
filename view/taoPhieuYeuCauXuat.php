<?php include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");
?>


<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Chi tiết">Chi tiết</div>
        </div>
        <div class="row">
            <div class="message_show">

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Phiếu yêu cầu xuất kho</h3>
                    </div>
                    <form action="../view/taoPhieuYeuCauXuat.php" method="POST" id="formXuatKho" autocomplete="on">
                        <div class="card-body">
                            <?php
                            include("../php/thongBao.php");
                            ?>


                            <dl class="row">
                                <div class="col-6">
                                    <dt class="col-sm-3">Mã phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieu" placeholder="" class="form-control"
                                                readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Tên phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="TenPhieu" placeholder="Phiếu xuất kho"
                                                class="form-control" readonly>
                                        </div>
                                    </dd>

                                    <dt class="col-sm-3">Người lập:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" value="<?= $_SESSION['ThongTinDangNhap']['Ten']; ?>"
                                                placeholder="Lấy session của người tạo" class="form-control" disabled>

                                            <input type="hidden" name="NguoiLap"
                                                value="<?= $_SESSION['ThongTinDangNhap']['User_id']; ?>" required>
                                        </div>
                                    </dd>

                                    <dt class="col-sm-3">Tình trạng thanh toán:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <select class="form-select" id="TinhTrangThanhToan"
                                                name="TinhTrangThanhToan" aria-label="Tình trạng thanh toán">
                                                <option value="" selected>Chọn tình trạng thanh toán</option>
                                                <option value="Đã thanh toán">Đã thanh toán</option>
                                                <option value="Chưa thanh toán">Chưa thanh toán</option>
                                            </select>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ghi chú:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <textarea class="form-control" name="NoiDung" rows="6"
                                                placeholder="Nhập nội dung chi tiết"></textarea>
                                        </div>
                                    </dd>
                                </div>
                                <div class="col-6">
                                    <dt class="col-sm-3">Ngày lập phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayLapPhieu" id="NgayLapPhieu"
                                                class="form-control" required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ngày xuất hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayXuatHang" id="NgayXuatHang"
                                                class="form-control" required>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Ngày giao hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayGiaoHang" id="NgayGiaoHang"
                                                class="form-control" required>
                                        </div>
                                    </dd>
                                    <dd class="col-sm-12 d-flex">
                                        <div class="col-sm-9 ">
                                            <div class="input-group mb-3">
                                                <select id="supplierSelect" class="form-select col-sm-9 supplierSelect"
                                                    aria-label="supplierSelect" required>
                                                    <option value="" selected disabled>Chọn khách hàng</option>
                                                    <?php
                                                    include("../php/connect.php");

                                                    $query = "SELECT * FROM `tbl_khachhang` ";

                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    if (mysqli_num_rows(result: $result) > 0) {
                                                        while ($row = mysqli_fetch_assoc(result: $result)) {
                                                            ?>
                                                            <option value="<?php echo $row['MaKhachHang'] ?>"
                                                                data-makh="<?php echo $row['MaKhachHang'] ?>"
                                                                data-tenkh="<?php echo $row['Ten'] ?>"
                                                                data-diachi="<?php echo $row['DiaChi'] ?>"
                                                                data-sodienthoai="<?php echo $row['SoDienThoai'] ?>"
                                                                data-email="<?php echo $row['Email'] ?>"
                                                                data-nganhnghekinhdoanh="<?php echo $row['NganhNgheKinhDoanh'] ?>">
                                                                <?php echo "<p><strong>Mã KH:</strong> " . $row['MaKhachHang'] . "; <strong>Tên hách hàng:</strong> " . $row['Ten'] . "</p>"; ?>

                                                            </option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 mx-2">
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#addSupplierModal">
                                                Thêm
                                            </button>
                                        </div>
                                    </dd>
                                    <div class="ThongTinNCC" style="display: none;">
                                        <dt class="col-sm-3">Mã KH:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="MaKH" placeholder="Mã của khách hàng"
                                                    class="form-control" readonly>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Tên khách hàng:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="TenKH" placeholder="Nhập tên khách hàng"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Địa chỉ :</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="DiaChi" placeholder="Nhập địa chỉ khách hàng"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Số điện thoại:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="number" name="SoDienThoai"
                                                    placeholder="Nhập số diện thoại khách hàng" class="form-control"
                                                    minlength="9" maxlength="11" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Email:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="email" name="Email" placeholder="Nhập email khách hàng"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>

                                        <dt class="col-sm-3">Ngành nghề kinh doanh:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="NganhNgheKinhDoanh"
                                                    placeholder="Nhập ngành nghề kinh doanh" class="form-control"
                                                    disabled>
                                            </div>
                                        </dd>
                                    </div>
                                </div>


                                <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                            </dl>
                            <button id="themspnhap" type="button" class="btn btn-primary" onclick="addProductRow()"
                                style=" margin-bottom: 10px">Thêm sản phẩm</button>
                            <table class="table table-striped ">
                                <tbody class="themhanghoa">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng yêu cầu</th>
                                        <th>Đơn vị</th>
                                        <th>Đơn giá bán</th>
                                        <th>Thành tiền</th>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Tổng tiền:</strong>
                                        </td>
                                        <td> <span id="total_amount"><input type="number" name="TongTien"
                                                    class="form-control" id="TongTien" value="" readonly>
                                            </span></td>
                                    </tr>
                                </tfoot>
                            </table>


                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">
                                    <input type="hidden" name="btntaomoiphieuyc" value="true">

                                    <button type="submit" class="btn btn-success btn-lg">Tạo
                                        Mới</button>
                                    <a href="nvPhieuYeuCau_Xuat.php"> <button type="button"
                                            class="btn btn-secondary btn-lg ">Quay lại</button></a>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
<!-- Xuất kho rules -->
<script>
    // Quy tắc kiểm tra xuất kho
    const xuatKhoRules = [
        {
            fieldId: "NgayLapPhieu",
            condition: () => {
                const ngayLapInput = document.getElementById("NgayLapPhieu").value;
                return ngayLapInput.trim() === "";

            },
            message: "Ngày lập phiếu không được bỏ trống."
        },
        {
            fieldId: "NgayXuatHang",
            condition: () => {
                const ngayXuatInput = document.getElementById("NgayXuatHang").value;
                return ngayXuatInput.trim() === "";
            },
            message: "Ngày xuất hàng không được bỏ trống."
        },
        {
            fieldId: "TinhTrangThanhToan",
            condition: () => {
                const tinhTrangThanhToanInput = document.getElementById("TinhTrangThanhToan");
                return tinhTrangThanhToanInput.value === "Chọn tình trạng thanh toán" || tinhTrangThanhToanInput.value === "";

            },
            message: "Tình trạng thanh toán không được bỏ trống."
        },
        {
            fieldId: "supplierSelect",
            condition: () => {
                const supplierSelect = document.getElementById("supplierSelect");
                return supplierSelect.value === "Chọn khách hàng" || supplierSelect.value === "";
            },
            message: "Vui lòng chọn khách hàng."
        },
        {
            fieldId: "NgayGiaoHang",
            condition: () => {
                const NgayGiaoHang = document.getElementById("NgayGiaoHang").value;
                return NgayGiaoHang.trim() === "";

            },
            message: "Ngày giao hàng không được bỏ trống."
        },
        {
            fieldId: "NgayLapPhieu",
            condition: () => {
                const ngayLapInput = new Date(document.getElementById("NgayLapPhieu").value);
                const ngayXuatInput = new Date(document.getElementById("NgayXuatHang").value);
                return ngayLapInput > ngayXuatInput; // Ngày lập phiếu không được lớn hơn ngày đặt hàng
            },
            message: "Ngày lập phiếu không được lớn hơn ngày xuất hàng."
        },

        {
            fieldId: "NgayXuatHang",
            condition: () => {
                const ngayXuatInput = new Date(document.getElementById("NgayXuatHang").value);
                const ngayGiaoInput = new Date(document.getElementById("NgayGiaoHang").value);
                return ngayXuatInput > ngayGiaoInput; // Ngày xuất hàng không được lớn hơn ngày giao hàng
            },
            message: "Ngày xuất hàng không được lớn hơn ngày giao hàng."
        }
        // {
        //     fieldId: null, // Không cần ID cố định cho bảng sản phẩm
        //     condition: () => {
        //         let hasError = false;
        //         const rows = document.querySelectorAll(".themhanghoa tr"); // Lấy tất cả các hàng sản phẩm

        //         // Kiểm tra nếu không có sản phẩm nào
        //         if (rows.length === 0) {
        //             Validator.showError(null, "Vui lòng thêm ít nhất một sản phẩm.");
        //             hasError = true;
        //         } else {
        //             rows.forEach((row, index) => {
        //                 const maSP = row.querySelector('[name*="[MaSP]"]');
        //                 const soLuong = row.querySelector('[name*="[SoLuong]"]');
        //                 const donGia = row.querySelector('[name*="[DonGia]"]');

        //                 // Kiểm tra Mã Sản Phẩm
        //                 if (!maSP || !maSP.value || maSP.value === "Chọn sản phẩm") {
        //                     Validator.showError(maSP ? maSP.id : "MaSP", `Sản phẩm ở dòng ${index} chưa được chọn.`);
        //                     hasError = true;
        //                 } else {
        //                     // Nếu mã sản phẩm hợp lệ, xóa lỗi cũ
        //                     Validator.clearError(maSP ? maSP.id : "MaSP");
        //                 }

        //                 // Kiểm tra Số Lượng
        //                 if (!soLuong || !soLuong.value || soLuong.value <= 0 || isNaN(soLuong.value)) {
        //                     Validator.showError(soLuong ? soLuong.id : "SoLuong", `Số lượng ở dòng ${index} không hợp lệ.`);
        //                     hasError = true;
        //                 } else {
        //                     // Nếu số lượng hợp lệ, xóa lỗi cũ
        //                     Validator.clearError(soLuong ? soLuong.id : "SoLuong");
        //                 }

        //                 // Kiểm tra Đơn Giá
        //                 if (!donGia || !donGia.value || donGia.value <= 0 || isNaN(donGia.value)) {
        //                     Validator.showError(donGia ? donGia.id : "DonGia", `Đơn giá ở dòng ${index} không hợp lệ.`);
        //                     hasError = true;
        //                 } else {
        //                     // Nếu đơn giá hợp lệ, xóa lỗi cũ
        //                     Validator.clearError(donGia ? donGia.id : "DonGia");
        //                 }
        //             });
        //         }

        //         return !hasError;
        //     },
        //     message: null
        // }
    ];

    // Hàm validateForm() để kiểm tra toàn bộ form
    function validateForm() {
        let isValid = true;

        // Duyệt qua từng quy tắc trong xuatKhoRules để kiểm tra hợp lệ
        xuatKhoRules.forEach(rule => {
            if (rule.condition()) {
                // Nếu có lỗi, hiển thị thông báo và đánh dấu là không hợp lệ
                Validator.showError(rule.fieldId, rule.message);
                isValid = false;
            } else {
                // Nếu không có lỗi, xóa lỗi cũ
                Validator.clearError(rule.fieldId);
            }
        });

        return isValid;
    }

    // Sự kiện submit
    const form = document.getElementById("formXuatKho");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Chặn submit mặc định

        if (validateForm()) {
            console.log("Thông tin hợp lệ, đang gửi form...");
            form.submit(); // Gửi form nếu tất cả đều hợp lệ
        } else {
            console.log("Thông tin không hợp lệ.");
        }
    });


</script>
<script>
    let productIndex = 0;

    function addProductRow() {
        const tbody = document.querySelector('.themhanghoa');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td>
            <select name="products[${productIndex}][MaSP]" id="MaSP${productIndex}"  class="form-select ProductSelect" required onchange="updateProductInfo(this)">
                <option selected disabled>Chọn sản phẩm</option>
                <?php
                include("../php/connect.php");

                $query = "SELECT * FROM `tbl_sanpham` ";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['MaSanPham'] . '" data-donvi="' . $row['DonVi'] . '" data-tensanpham="' . $row['Ten'] . '">' . $row['Ten'] . '</option>';
                    }
                }
                ?>
            </select>
        </td>
        <td><input type="number" id="SoLuong${productIndex}" name="products[${productIndex}][SoLuong]" class="form-control"  min="1" required></td>
        <td><input type="text"  id="DonVi${productIndex}" name="products[${productIndex}][DonVi]" class="form-control" readonly></td>
        <td><input type="number" id="DonGia${productIndex}"  name="products[${productIndex}][DonGia]" class="form-control"  min="1" max="50000000" step="1"  required></td>
        <td><input type="number" id="ThanhTien${productIndex}"  name="products[${productIndex}][ThanhTien]" class="form-control" readonly></td>
        <td><button type="button" class="btn btn-danger" onclick="removeProductRow(this)">Xóa</button></td>
    `;
        tbody.appendChild(newRow);

        productIndex++; // Increment index for the next product
    }

    // Update product information when a product is selected
    function updateProductInfo(selectElement) {
        const row = selectElement.closest('tr');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const donVi = selectedOption.getAttribute('data-donvi');

        // Update the corresponding 'DonVi' input field
        row.querySelector('input[name*="[DonVi]"]').value = donVi;

        // Optionally, clear 'ThanhTien' if needed when the product is changed
        row.querySelector('input[name*="[ThanhTien]"]').value = '';
    }

    // Function to remove product row
    function removeProductRow(button) {
        const row = button.closest('tr');
        row.remove();

        // Update total after removing the product row
        updateTotalAmount();
    }

    // Script to calculate 'ThanhTien' and 'TongTien' in real-time
    document.addEventListener('input', function (event) {
        if (event.target.matches('[name^="products"][name*="[SoLuong]"], [name^="products"][name*="[DonGia]"]')) {
            const row = event.target.closest('tr');
            const soLuong = row.querySelector('[name*="[SoLuong]"]').value;
            const donGia = row.querySelector('[name*="[DonGia]"]').value;
            const thanhTien = row.querySelector('[name*="[ThanhTien]"]');

            // Calculate 'ThanhTien'
            thanhTien.value = soLuong * donGia;

            // Update total amount
            updateTotalAmount();
        }
    });

    // Function to calculate and update the total amount
    function updateTotalAmount() {
        let totalAmount = 0;
        document.querySelectorAll('[name*="[ThanhTien]"]').forEach(function (input) {
            totalAmount += parseFloat(input.value) || 0;
        });
        document.getElementById('TongTien').value = totalAmount;
    }
</script>


<!-- Chọn khách hàng -->
<script>
    document.getElementById('supplierSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        const supplierData = {
            maKH: selectedOption.getAttribute('data-makh'),
            tenKH: selectedOption.getAttribute('data-tenkh'),
            diaChi: selectedOption.getAttribute('data-diachi'),
            soDienThoai: selectedOption.getAttribute('data-sodienthoai'),
            email: selectedOption.getAttribute('data-email'),
            nganhNgheKinhDoanh: selectedOption.getAttribute('data-nganhnghekinhdoanh')
        };


        // Hiển thị thông tin trong ThongTinNCC
        const thongTinNCC = document.querySelector('.ThongTinNCC');
        thongTinNCC.style.display = 'block';

        // Cập nhật các trường input
        thongTinNCC.querySelector('input[name="MaKH"]').value = supplierData.maKH;
        thongTinNCC.querySelector('input[name="TenKH"]').value = supplierData.tenKH;
        thongTinNCC.querySelector('input[name="DiaChi"]').value = supplierData.diaChi;
        thongTinNCC.querySelector('input[name="SoDienThoai"]').value = supplierData.soDienThoai;
        thongTinNCC.querySelector('input[name="Email"]').value = supplierData.email;
        thongTinNCC.querySelector('input[name="NganhNgheKinhDoanh"]').value = supplierData.nganhNgheKinhDoanh;
    });

</script>



<!-- ThemNCCModal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">s
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Thêm mới khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error_message">

                </div>
                <div class="mb-2">
                    <label for="MaKH" class="form-label">Mã KH:</label>
                    <input type="text" name="MaKH" placeholder="Mã của khách hàng" class="form-control MaKH" readonly>
                </div>
                <div class="mb-2">
                    <label for="TenKH" class="form-label">Tên khách hàng:</label>
                    <input type="text" name="TenKH" placeholder="Nhập tên khách hàng" class="form-control TenKH"
                        required>
                </div>
                <div class="mb-2">
                    <label for="DiaChi" class="form-label">Địa chỉ:</label>
                    <input type="text" name="DiaChi" placeholder="Nhập địa chỉ khách hàng" class="form-control DiaChi"
                        required>
                </div>
                <div class="mb-2">
                    <label for="SoDienThoai" class="form-label">Số điện thoại:</label>
                    <input type="number" name="SoDienThoai" placeholder="Nhập số diện thoại khách hàng"
                        class="form-control SoDienThoai" minlength="9" maxlength="11" required>
                </div>
                <div class="mb-2">
                    <label for="Email" class="form-label">Email:</label>
                    <input type="email" name="Email" placeholder="Nhập email khách hàng" class="form-control Email"
                        required>
                </div>

                <div class="mb-2">
                    <label for="NganhNgheKinhDoanh" class="form-label">Ngành nghề kinh doanh:</label>
                    <input type="text" name="NganhNgheKinhDoanh" placeholder="Nhập ngành nghề kinh doanh"
                        class="form-control NganhNgheKinhDoanh" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary them_thongtin_ncc">Lưu</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        $(".them_thongtin_ncc").click(function (e) {
            e.preventDefault();

            var MaKH = $('.MaKH').val();
            var TenKH = $('.TenKH').val();
            var DiaChi = $('.DiaChi').val();
            var SoDienThoai = $('.SoDienThoai').val();
            var Email = $('.Email').val();
            var NganhNgheKinhDoanh = $('.NganhNgheKinhDoanh').val();

            if (TenKH != '' && DiaChi != '' && SoDienThoai != '' && Email != '' && NganhNgheKinhDoanh != '') {
                $.ajax({
                    type: "POST",
                    url: "../php/themKH_XuLy.php",
                    data: {
                        'checking_add': true,
                        'TenKH': TenKH,
                        'DiaChi': DiaChi,
                        'SoDienThoai': SoDienThoai,
                        'Email': Email,
                        'NganhNgheKinhDoanh': NganhNgheKinhDoanh,
                    },
                    dataType: 'json', // Thêm dòng này để jQuery tự động parse JSON
                    success: function (response) {
                        if (response.status === 'success') {
                            // Add new option to select
                            let newOptionHtml = `<option value="${response.MaKhachHang}" 
                                data-makh="${response.MaKhachHang}"
                                data-tenkh="${TenKH}"
                                data-diachi="${DiaChi}"
                                data-sodienthoai="${SoDienThoai}"
                                data-email="${Email}"
                                data-nganhnghekinhdoanh="${NganhNgheKinhDoanh}"
                            >
                                <p><strong>Mã KH:</strong> ${response.MaKhachHang}; <strong>Tên khách hàng:</strong> ${TenKH}</p>
                            </option>`;

                            $('#supplierSelect').append(newOptionHtml); // 

                            // Close modal and remove backdrop
                            $('#addSupplierModal').modal('hide');
                            $('.modal-backdrop').remove();

                            // Show success message
                            $('.message_show').append(`
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Lưu ý!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);


                        } else {
                            $('.error_message').append(`
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Lỗi!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Ajax error:', error);
                        $('.error_message').append(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Lỗi!</strong> Không thể thêm khách hàng.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                });
            } else {
                $('.error_message').append(`
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Lưu ý!</strong> Điền đầy đủ thông tin.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        });
    });
</script>

<?php
ob_start();

include("../php/connect.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['btntaomoiphieuyc'])) {

    // Begin transaction
    $conn->begin_transaction();
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    try {
        $MaLoaiPhieu = '3'; // Phiếu Xuất Kho
        $MaTrangThaiPhieu = '1';
        $MaKhachHang = $_POST['MaKH'];
        $NgayLapPhieu = $_POST['NgayLapPhieu'];
        $NgayXuatHang = $_POST['NgayXuatHang'];
        $NgayGiaoHang = $_POST['NgayGiaoHang'];
        $GhiChu = $_POST['NoiDung'];
        $IDNhanVien = $_POST['NguoiLap'];
        $SoTienThanhToan = 0;
        $TongTien = $_POST['TongTien'];
        $TinhTrangThanhToan = $_POST['TinhTrangThanhToan']; // Lấy trạng thái thanh toán từ form


        if ($TinhTrangThanhToan === 'Đã thanh toán') {
            $SoTienThanhToan = $TongTien; // Nếu đã thanh toán, số tiền bằng tổng tiền
        } else {
            $SoTienThanhToan = 0; // Nếu chưa thanh toán, số tiền bằng 0
        }


        // Calculate TongSoLoaiSanPham (unique product count)
        $products = $_POST['products']; // Array of products from the form
        $TongSoLoaiSanPham = count(array_unique(array_column($products, 'MaSP')));
        if (!isset($products) || empty($products)) {
            $_SESSION['errorMessages'] = "Vui lòng chọn sản phẩm!";
            echo "<script>
                    window.location.href = 'taoPhieuYeuCauXuat.php';
                    </script>";
            exit;
        }
        // Chèn vào bảng tbl_phieuxuat
        $stmtPhieuXuat = $conn->prepare("INSERT INTO tbl_phieuxuat (MaLoaiPhieu, MaTrangThaiPhieu, MaKhachHang, NgayLapPhieu, NgayXuatHang, NgayGiaoHang, TongSoLoaiSanPham, GhiChu) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtPhieuXuat->bind_param("ssssssis", $MaLoaiPhieu, $MaTrangThaiPhieu, $MaKhachHang, $NgayLapPhieu, $NgayXuatHang, $NgayGiaoHang, $TongSoLoaiSanPham, $GhiChu);
        if (!$stmtPhieuXuat->execute()) {
            throw new Exception("Không thể chèn vào tbl_phieuxuat: " . $stmtPhieuXuat->error);
        }

        // Lấy MaPhieuXuat vừa chèn
        $MaPhieuXuat = $conn->insert_id;


        // Chèn vào bảng tbl_thanhtoan với SoTienThanhToan đã xử lý
        $stmtThanhToan = $conn->prepare("INSERT INTO tbl_thanhtoan (MaThanhToan, MaPhieuXuat, SoTienThanhToan, TrangThaiThanhToan) VALUES (?, ?, ?, ?)");
        $MaThanhToan = NULL;
        $stmtThanhToan->bind_param("ssis", $MaThanhToan, $MaPhieuXuat, $SoTienThanhToan, $TinhTrangThanhToan);
        if (!$stmtThanhToan->execute()) {
            throw new Exception("Không thể chèn vào tbl_thanhtoan: " . $stmtThanhToan->error);
        }

        // Chèn từng sản phẩm vào tbl_chitietphieuxuat
        $stmtChiTietPhieuXuat = $conn->prepare("INSERT INTO tbl_chitietphieuxuat (MaChiTietPhieuXuat, MaPhieuXuat, MaSanPham, MaShipper, SoLuong, DonGiaBan, ThanhTien, TongTien) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $checkedProducts = [];
        foreach ($products as $product) {
            $MaChiTietPhieuXuat = NULL;
            $MaSanPham = $product['MaSP'];
            $SoLuong = $product['SoLuong'];
            $DonGiaBan = $product['DonGia'];
            $ThanhTien = $product['ThanhTien'];
            $TongTien = $_POST['TongTien'];
            $MaShipper = NULL;


            // Kiểm tra sản phẩm đã tồn tại trong mảng tạm chưa
            if (isset($checkedProducts[$MaSanPham])) {
                $_SESSION['errorMessages'] = "Danh sách sản phẩm chứa mã sản phẩm trùng lặp: $MaSanPham!";
                echo "<script>
                window.location.href = 'taoPhieuYeuCauXuat.php';
              </script>";
                exit;
            }

            // Nếu chưa tồn tại, thêm vào mảng tạm
            $checkedProducts[$MaSanPham] = true;

            if (!isset($MaSanPham) || empty($MaSanPham)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauXuat.php';
                        </script>";
                exit;
            }
            if (!isset($SoLuong) || empty($SoLuong)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauXuat.php';
                        </script>";
                exit;
            }

            if (!isset($DonGiaBan) || empty($DonGiaBan)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauXuat.php';
                        </script>";
                exit;
            }
            if (!isset($ThanhTien) || empty($ThanhTien)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauXuat.php';
                        </script>";
                exit;
            }
            if (!isset($TongTien) || empty($TongTien)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauXuat.php  ';
                        </script>";
                exit;
            }



            // Truy vấn TongSoLuong từ bảng tbl_sanpham
            $sql = "SELECT SoLuongTon, Ten FROM tbl_sanpham WHERE MaSanPham = ?";
            $stmt = $conn->prepare($sql); // Sử dụng prepared statement để bảo mật
            $stmt->bind_param("s", $MaSanPham); // Gắn tham số (nếu MaSanPham là chuỗi)
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Lấy giá trị SoLuongTon từ kết quả
                $row = $result->fetch_assoc();
                $SoLuongTon = intval($row['SoLuongTon']);
                $TenSP = $row['Ten'];

                // Kiểm tra soLuongThanhLy có lớn hơn TongSoLuong hay không
                if ($SoLuong > $SoLuongTon) {
                    $_SESSION['errorMessages'] = "Số lượng xuất của $TenSP không được vượt quá tổng số lượng hiện có ($SoLuongTon)!";
                    echo "<script>
                            window.location.href = 'taoPhieuYeuCauXuat.php';
                          </script>";
                    exit;
                }
            } else {
                $_SESSION['errorMessages'] = "Không tìm thấy sản phẩm với mã $MaSanPham!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauXuat.php';
                      </script>";
                exit;
            }



            // Bind and execute insert for each product
            $stmtChiTietPhieuXuat->bind_param("sssiiidd", $MaChiTietPhieuXuat, $MaPhieuXuat, $MaSanPham, $MaShipper, $SoLuong, $DonGiaBan, $ThanhTien, $TongTien);
            if (!$stmtChiTietPhieuXuat->execute()) {
                throw new Exception("Không thể chèn vào tbl_chitietphieuxuat: " . $stmtChiTietPhieuXuat->error);
            }
        }

        // Insert into tbl_nhanvienkho_tao_phieu_xuat
        $stmtNhanVien = $conn->prepare("INSERT INTO tbl_nhanvienkho_taophieu_xuat (IDNhanVien, MaPhieuXuat) VALUES (?, ?)");
        $stmtNhanVien->bind_param("is", $IDNhanVien, $MaPhieuXuat);
        if (!$stmtNhanVien->execute()) {
            throw new Exception("Không thể chèn vào tbl_nhanvienkho_taophieu_xuat: " . $stmtNhanVien->error);
        }

        $conn->commit();
        $_SESSION['message'] = "Phiếu xuất kho đã được tạo thành công!";
        echo "<script>
            window.location.href = 'nvPhieuYeuCau_Xuat.php';
            </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi khi tạo phiếu xuất kho: " . $e->getMessage();
    } finally {
        // Close prepared statements
        $stmtPhieuXuat->close();
        $stmtChiTietPhieuXuat->close();
        $stmtNhanVien->close();
        $conn->close();
    }
}
ob_end_flush();
?>




<script type="text/javascript" src="../js/phanPhoiDonHang_Ship.js"></script>
</body>

</html>
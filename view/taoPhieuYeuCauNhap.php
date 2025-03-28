<?php include("../php/header_heThong.php");
?>
<?php
include("../php/sidebar_heThong.php");
?>


<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Tạo phiếu">Tạo phiếu</div>
        </div>
        <div class="row">
            <div class="message_show">

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Phiếu yêu cầu nhập kho</h3>
                    </div>
                    <form action="../view/taoPhieuYeuCauNhap.php" method="POST" id="formNhapKho" autocomplete="on">
                        <div class="card-body">
                            <?php
                            include("../php/thongBao.php");
                            ?>
                            <dl class="row">
                                <div class="col-6">
                                    <dt class="col-sm-3">Mã phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="MaPhieu" placeholder="Mã phiếu được tạo tự động"
                                                class="form-control" readonly>
                                        </div>
                                    </dd>
                                    <dt class="col-sm-3">Tên phiếu:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="text" name="TenPhieu" placeholder="Phiếu nhập kho"
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
                                    <dt class="col-sm-3">Ngày đặt hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayDatHang" id="NgayDatHang" class="form-control"
                                                required>
                                        </div>

                                    </dd>
                                    <dt class="col-sm-3">Ngày nhận hàng:</dt>
                                    <dd class="col-sm-9">
                                        <div class="input-group mb-3">
                                            <input type="date" name="NgayNhanHang" id="NgayNhanHang"
                                                class="form-control" required>
                                        </div>

                                    </dd>
                                    <dd class="col-sm-12 d-flex">
                                        <div class="col-sm-9 ">
                                            <div class="input-group mb-3">
                                                <select id="supplierSelect" class="form-select col-sm-9 supplierSelect"
                                                    aria-label="supplierSelect">
                                                    <option value="" selected disabled>Chọn nhà cung cấp</option>
                                                    <?php
                                                    include("../php/connect.php");

                                                    $query = "SELECT * FROM `tbl_nhacungcap` ";

                                                    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                                                    if (mysqli_num_rows(result: $result) > 0) {
                                                        while ($row = mysqli_fetch_assoc(result: $result)) {
                                                            ?>
                                                            <option value="<?php echo $row['MaNhaCungCap'] ?>"
                                                                data-mancc="<?php echo $row['MaNhaCungCap'] ?>"
                                                                data-tenncc="<?php echo $row['Ten'] ?>"
                                                                data-diachi="<?php echo $row['DiaChi'] ?>"
                                                                data-sodienthoai="<?php echo $row['SoDienThoai'] ?>"
                                                                data-email="<?php echo $row['Email'] ?>"
                                                                data-nganhhangcungcap="<?php echo $row['NganhHangCungCap'] ?>"
                                                                data-sanphamcungcap="<?php echo $row['SanPhamCungCap'] ?>">
                                                                <?php echo "<p ><span style='font-weight: bold;'>Mã NCC:</span> " . $row['MaNhaCungCap'] . "; <strong>Nhà cung cấp:</strong> " . $row['Ten'] . "</p>"; ?>

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
                                        <dt class="col-sm-3">Mã NCC:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="MaNCC" placeholder="Mã của nhà cung cấp"
                                                    class="form-control" readonly>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Nhà cung cấp:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="TenNCC" placeholder="Nhập tên nhà cung cấp"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Địa chỉ :</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="DiaChi" placeholder="Nhập địa chỉ nhà cung cấp"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Số điện thoại:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="number" name="SoDienThoai"
                                                    placeholder="Nhập số diện thoại nhà cung cấp" class="form-control"
                                                    minlength="9" maxlength="11" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-3">Email:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="email" name="Email" placeholder="Nhập email nhà cung cấp"
                                                    class="form-control" disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-4">Ngành hàng cung cấp:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="NganhHangCungCap"
                                                    placeholder="Nhập ngành hàng cung cấp" class="form-control"
                                                    disabled>
                                            </div>
                                        </dd>
                                        <dt class="col-sm-4">Sản phẩm cung cấp:</dt>
                                        <dd class="col-sm-9">
                                            <div class="input-group mb-3">
                                                <input type="text" name="SanPhamCungCap"
                                                    placeholder="Nhập sản phẩm cung cấp" class="form-control" disabled>
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
                                        <th>Đơn giá nhập</th>
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
                                        <td><input type="number" name="TongTien" class="form-control" id="TongTien"
                                                value="" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>


                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">
                                    <input type="hidden" name="btntaomoiphieuyc" value="true">

                                    <button type="submit" class="btn btn-success btn-lg">Tạo
                                        Mới</button>
                                    <a href="nvPhieuYeuCau.php"><button type="button"
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
<!-- ThemNCCModal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Thêm mới nhà cung cấp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="error_message">

                </div>
                <div class="mb-2">
                    <label for="MaNCC" class="form-label">Mã NCC:</label>
                    <input type="text" name="MaNCC" placeholder="Mã của nhà cung cấp" class="form-control MaNCC"
                        readonly>
                </div>
                <div class="mb-2">
                    <label for="TenNCC" class="form-label">Nhà cung cấp:</label>
                    <input type="text" name="TenNCC" placeholder="Nhập tên nhà cung cấp" class="form-control TenNCC"
                        required>
                </div>
                <div class="mb-2">
                    <label for="DiaChi" class="form-label">Địa chỉ:</label>
                    <input type="text" name="DiaChi" placeholder="Nhập địa chỉ nhà cung cấp" class="form-control DiaChi"
                        required>
                </div>
                <div class="mb-2">
                    <label for="SoDienThoai" class="form-label">Số điện thoại:</label>
                    <input type="number" name="SoDienThoai" placeholder="Nhập số diện thoại nhà cung cấp"
                        class="form-control SoDienThoai" minlength="9" maxlength="11" required>
                </div>
                <div class="mb-2">
                    <label for="Email" class="form-label">Email:</label>
                    <input type="email" name="Email" placeholder="Nhập email nhà cung cấp" class="form-control Email"
                        required>
                </div>
                <div class="mb-2">
                    <label for="NganhHangCungCap" class="form-label">Ngành hàng cung cấp:</label>
                    <input type="text" name="NganhHangCungCap" placeholder="Nhập ngành hàng cung cấp"
                        class="form-control NganhHangCungCap" required>
                </div>
                <div class="mb-2">
                    <label for="SanPhamCungCap" class="form-label">Sản phẩm cung cấp:</label>
                    <input type="text" name="SanPhamCungCap" placeholder="Nhập sản phẩm cung cấp"
                        class="form-control SanPhamCungCap" required>
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
<!-- Nhập kho rules -->
<script>
    // Quy tắc kiểm tra nhập kho
    const nhapKhoRules = [
        {
            fieldId: "NgayLapPhieu",
            condition: () => {
                const ngayLapInput = document.getElementById("NgayLapPhieu").value;
                return ngayLapInput.trim() === ""; // Nếu ngày xuất trống

            },
            message: "Ngày lập phiếu không được bỏ trống."
        },
        {
            fieldId: "NgayDatHang",
            condition: () => {
                const NgayDatHang = document.getElementById("NgayDatHang").value;
                return NgayDatHang.trim() === ""; // Nếu ngày xuất trống

            },
            message: "Ngày đặt hàng không được bỏ trống."
        },
        {
            fieldId: "NgayNhanHang",
            condition: () => {
                const NgayNhanHang = document.getElementById("NgayNhanHang").value;
                return NgayNhanHang.trim() === ""; // Nếu ngày xuất trống

            },
            message: "Ngày nhận hàng không được bỏ trống."
        },
        {
            fieldId: "NgayLapPhieu",
            condition: () => {
                const ngayLapInput = new Date(document.getElementById("NgayLapPhieu").value);
                const ngayDatInput = new Date(document.getElementById("NgayDatHang").value);
                return ngayLapInput < ngayDatInput; // Ngày lập phiếu không được nhỏ hơn ngày đặt hàng
            },
            message: "Ngày lập phiếu không được nhỏ hơn ngày đặt hàng."
        },
        {
            fieldId: "supplierSelect",
            condition: () => {
                const supplierSelect = document.getElementById("supplierSelect");
                return supplierSelect.value === "Chọn nhà cung cấp" || supplierSelect.value === "";
            },
            message: "Vui lòng chọn nhà cung cấp."
        },
        {
            fieldId: "NgayDatHang",
            condition: () => {
                const ngayDatInput = new Date(document.getElementById("NgayDatHang").value);
                const ngayNhanInput = new Date(document.getElementById("NgayNhanHang").value);
                return ngayDatInput > ngayNhanInput; // Ngày đặt hàng không được lớn hơn ngày nhận hàng
            },
            message: "Ngày đặt hàng không được lớn hơn ngày nhận hàng."
        },
        {
            fieldId: null, // Không cần ID cố định cho bảng sản phẩm
            condition: () => {
                let hasError = false;
                const rows = document.querySelectorAll(".themhanghoa tr"); // Lấy tất cả các hàng sản phẩm

                // Kiểm tra nếu không có sản phẩm nào
                if (rows.length === 0) {
                    Validator.showError(null, "Vui lòng thêm ít nhất một sản phẩm.");
                    hasError = true;
                } else {
                    rows.forEach((row, index) => {
                        const maSP = row.querySelector('[name*="[MaSP]"]');
                        const soLuong = row.querySelector('[name*="[SoLuong]"]');
                        const donGia = row.querySelector('[name*="[DonGia]"]');

                        // Kiểm tra Mã Sản Phẩm
                        if (!maSP || !maSP.value || maSP.value === "Chọn sản phẩm") {
                            Validator.showError(maSP ? maSP.id : "MaSP", `Sản phẩm ở dòng ${index} chưa được chọn.`);
                            hasError = true;
                        } else {
                            // Nếu mã sản phẩm hợp lệ, xóa lỗi cũ
                            Validator.clearError(maSP ? maSP.id : "MaSP");
                        }

                        // Kiểm tra Số Lượng
                        if (!soLuong || !soLuong.value || soLuong.value <= 0 || isNaN(soLuong.value)) {
                            Validator.showError(soLuong ? soLuong.id : "SoLuong", `Số lượng ở dòng ${index} không hợp lệ.`);
                            hasError = true;
                        } else {
                            // Nếu số lượng hợp lệ, xóa lỗi cũ
                            Validator.clearError(soLuong ? soLuong.id : "SoLuong");
                        }

                        // Kiểm tra Đơn Giá
                        if (!donGia || !donGia.value || donGia.value <= 0 || isNaN(donGia.value)) {
                            Validator.showError(donGia ? donGia.id : "DonGia", `Đơn giá ở dòng ${index} không hợp lệ.`);
                            hasError = true;
                        } else {
                            // Nếu đơn giá hợp lệ, xóa lỗi cũ
                            Validator.clearError(donGia ? donGia.id : "DonGia");
                        }
                    });
                }

                return !hasError;
            },
            message: null
        }
    ];

    // Hàm validateForm() để kiểm tra toàn bộ form
    function validateForm() {
        let isValid = true;

        // Duyệt qua từng quy tắc trong nhapKhoRules để kiểm tra hợp lệ
        nhapKhoRules.forEach(rule => {
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
    const form = document.getElementById("formNhapKho");

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



<!-- Thêm sản phẩm -->
<script>
    let productIndex = 0;

    function addProductRow() {

        const tbody = document.querySelector('.themhanghoa');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td>
            <select name="products[${productIndex}][MaSP]" id="MaSP${productIndex}" class="form-select ProductSelect" required onchange="updateProductInfo(this)">
                <option selected disabled>Chọn sản phẩm</option>
                <?php
                include("../php/connect.php");

                $query = "SELECT * FROM `tbl_sanpham` ";
                $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['MaSanPham'] . '" data-donvi="' . $row['DonVi'] . '">' . $row['Ten'] . '</option>';
                    }
                }
                ?>
            </select>
        </td>
        <td><input type="number"  id="SoLuong${productIndex}" name="products[${productIndex}][SoLuong]" class="form-control"   min="1"  max="999" step="1"  ></td>
        <td><input type="text" id="DonVi${productIndex}" name="products[${productIndex}][DonVi]" class="form-control" readonly></td>
        <td><input type="number" id="DonGia${productIndex}" name="products[${productIndex}][DonGia]" class="form-control" min="1" max="50000000" step="1"  ></td>
        <td><input type="number" id="ThanhTien${productIndex}" name="products[${productIndex}][ThanhTien]" class="form-control" readonly></td>
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


<!-- Chọn nhà cung cấp -->
<script>
    document.getElementById('supplierSelect').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];

        // Lấy dữ liệu bằng getAttribute
        const supplierData = {
            maNCC: selectedOption.getAttribute('data-mancc'),
            tenNCC: selectedOption.getAttribute('data-tenncc'),
            diaChi: selectedOption.getAttribute('data-diachi'),
            soDienThoai: selectedOption.getAttribute('data-sodienthoai'),
            email: selectedOption.getAttribute('data-email'),
            nganhhangcungcap: selectedOption.getAttribute('data-nganhhangcungcap'),
            sanPhamCungCap: selectedOption.getAttribute('data-sanphamcungcap')
        };


        // Hiển thị thông tin trong ThongTinNCC
        const thongTinNCC = document.querySelector('.ThongTinNCC');
        thongTinNCC.style.display = 'block';

        // Cập nhật các trường input
        thongTinNCC.querySelector('input[name="MaNCC"]').value = supplierData.maNCC;
        thongTinNCC.querySelector('input[name="TenNCC"]').value = supplierData.tenNCC;
        thongTinNCC.querySelector('input[name="DiaChi"]').value = supplierData.diaChi;
        thongTinNCC.querySelector('input[name="SoDienThoai"]').value = supplierData.soDienThoai;
        thongTinNCC.querySelector('input[name="Email"]').value = supplierData.email;
        thongTinNCC.querySelector('input[name="NganhHangCungCap"]').value = supplierData.nganhhangcungcap;
        thongTinNCC.querySelector('input[name="SanPhamCungCap"]').value = supplierData.sanPhamCungCap;
    });

</script>
<!-- Thêm thông tin nhà cung cấp -->
<script>
    $(document).ready(function () {
        $(".them_thongtin_ncc").click(function (e) {
            e.preventDefault();

            var MaNCC = $('.MaNCC').val();
            var TenNCC = $('.TenNCC').val();
            var DiaChi = $('.DiaChi').val();
            var SoDienThoai = $('.SoDienThoai').val();
            var Email = $('.Email').val();
            var NganhHangCungCap = $('.NganhHangCungCap').val();
            var SanPhamCungCap = $('.SanPhamCungCap').val();

            if (TenNCC != '' && DiaChi != '' && SoDienThoai != '' && Email != '' && NganhHangCungCap != '' && SanPhamCungCap != '') {
                $.ajax({
                    type: "POST",
                    url: "../php/themNCC_XuLy.php",
                    data: {
                        'checking_add': true,
                        'TenNCC': TenNCC,
                        'DiaChi': DiaChi,
                        'SoDienThoai': SoDienThoai,
                        'Email': Email,
                        'NganhHangCungCap': NganhHangCungCap,
                        'SanPhamCungCap': SanPhamCungCap,
                    },
                    dataType: 'json', // Thêm dòng này để jQuery tự động parse JSON
                    success: function (response) {
                        if (response.status === 'success') {
                            // Add new option to select
                            let newOptionHtml = `<option value="${response.MaNhaCungCap}" 
                                data-mancc="${response.MaNhaCungCap}"
                                data-tenncc="${TenNCC}"
                                data-diachi="${DiaChi}"
                                data-sodienthoai="${SoDienThoai}"
                                data-email="${Email}"
                                data-nganhhangcungcap="${NganhHangCungCap}"
                                data-sanphamcungcap="${SanPhamCungCap}"
                            >
                                <p><strong>Mã NCC:</strong> ${response.MaNhaCungCap}; <strong>Nhà cung cấp:</strong> ${TenNCC}</p>
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
                                <strong>Lỗi!</strong> Không thể thêm nhà cung cấp.
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
include("../config/init.php");
if (isset($_POST['btntaomoiphieuyc'])) {

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Retrieve form data
        $MaLoaiPhieu = '2'; // Example fixed value for Phiếu Nhập Kho
        $MaTrangThaiPhieu = '1'; // Example status value, adjust as needed
        $MaNhaCungCap = $_POST['MaNCC'];
        $NgayLapPhieu = $_POST['NgayLapPhieu'];
        $NgayDatHang = $_POST['NgayDatHang'];
        $NgayNhanHang = $_POST['NgayNhanHang'];
        $GhiChu = $_POST['NoiDung'];
        $IDNhanVien = $_POST['NguoiLap'];

        if (!isset($NgayLapPhieu) || empty($NgayLapPhieu)) {
            $_SESSION['errorMessages'] = "Vui lòng chọn ngày lập phiếu!";
            echo "<script>
                    window.location.href = 'taoPhieuYeuCauNhap.php';
                    </script>";
            exit;
        }
        if (!isset($NgayDatHang) || empty($NgayDatHang)) {
            $_SESSION['errorMessages'] = "Vui lòng chọn ngày đặt hàng!";
            echo "<script>
                    window.location.href = 'taoPhieuYeuCauNhap.php';
                    </script>";
            exit;
        }
        if (!isset($NgayNhanHang) || empty($NgayNhanHang)) {
            $_SESSION['errorMessages'] = "Vui lòng chọn ngày nhận hàng!";
            echo "<script>
                    window.location.href = 'taoPhieuYeuCauNhap.php';
                    </script>";
            exit;
        }
        if (!isset($_POST['products']) || empty($_POST['products'])) {
            $_SESSION['errorMessages'] = "Vui lòng chọn sản phẩm!";
            echo "<script>
                    window.location.href = 'taoPhieuYeuCauNhap.php';
                    </script>";
            exit;
        }
        $products = $_POST['products'];
        $TongSoLoaiSanPham = count(array_unique(array: array_column(array: $products, column_key: 'MaSP')));
        if (!is_array($products)) {
            throw new Exception("Dữ liệu sản phẩm không hợp lệ.");
        }

        // Kiểm tra xem MaSP có được chọn không
        if (!isset($products) || empty($products)) {
            $_SESSION['errorMessages'] = "Vui lòng chọn sản phẩm!";
            echo "<script>
                    window.location.href = 'taoPhieuYeuCauNhap.php';
                    </script>";
            exit;
        }
        // Chèn vào bảng tbl_phieunhap
        $stmtPhieuNhap = $conn->prepare("INSERT INTO tbl_phieunhap (MaLoaiPhieu, MaTrangThaiPhieu, MaNhaCungCap, NgayLapPhieu, NgayDatHang, NgayNhanHang, TongSoLoaiSanPham, GhiChu) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtPhieuNhap->bind_param("ssssssis", $MaLoaiPhieu, $MaTrangThaiPhieu, $MaNhaCungCap, $NgayLapPhieu, $NgayDatHang, $NgayNhanHang, $TongSoLoaiSanPham, $GhiChu);
        if (!$stmtPhieuNhap->execute()) {
            throw new Exception("Không thể chèn vào tbl_phieunhap: " . $stmtPhieuNhap->error);
        }

        // Lấy MaPhieuNhap vừa chèn
        $MaPhieuNhap = $conn->insert_id;

        // Chèn từng sản phẩm vào tbl_chitietphieunhap
        $stmtChiTietPhieuNhap = $conn->prepare("INSERT INTO tbl_chitietphieunhap (MaChiTietPhieuNhap, MaPhieuNhap, MaSanPham, SoLuong, DonGiaNhap, ThanhTien, TongTien) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $checkedProducts = [];

        foreach ($products as $product) {
            $MaChiTietPhieuNhap = NULL;
            $MaSanPham = $product['MaSP'];
            $SoLuong = $product['SoLuong'];
            $DonGiaNhap = $product['DonGia'];
            $ThanhTien = $product['ThanhTien'];
            $TongTien = $_POST['TongTien'];

            // Kiểm tra sản phẩm đã tồn tại trong mảng tạm chưa
            if (isset($checkedProducts[$MaSanPham])) {
                $_SESSION['errorMessages'] = "Danh sách sản phẩm chứa mã sản phẩm trùng lặp: $MaSanPham!";
                echo "<script>
                window.location.href = 'taoPhieuYeuCauNhap.php';
              </script>";
                exit;
            }

            // Nếu chưa tồn tại, thêm vào mảng tạm
            $checkedProducts[$MaSanPham] = true;
            if (!isset($MaSanPham) || empty($MaSanPham)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauNhap.php';
                        </script>";
                exit;
            }
            if (!isset($SoLuong) || empty($SoLuong)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauNhap.php';
                        </script>";
                exit;
            }
            if (!isset($DonGiaNhap) || empty($DonGiaNhap)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauNhap.php';
                        </script>";
                exit;
            }
            if (!isset($DonGiaNhap) || empty($ThanhTien)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauNhap.php';
                        </script>";
                exit;
            }
            if (!isset($DonGiaNhap) || empty($TongTien)) {
                $_SESSION['errorMessages'] = "Vui lòng nhập đầy đủ thông tin sản phẩm!";
                echo "<script>
                        window.location.href = 'taoPhieuYeuCauNhap.php';
                        </script>";
                exit;
            }
            // Bind and execute insert for each product
            $stmtChiTietPhieuNhap->bind_param("sssiidd", $MaChiTietPhieuNhap, $MaPhieuNhap, $MaSanPham, $SoLuong, $DonGiaNhap, $ThanhTien, $TongTien);
            if (!$stmtChiTietPhieuNhap->execute()) {
                throw new Exception("Không thể chèn vào tbl_chitietphieunhap: " . $stmtChiTietPhieuNhap->error);
            }
        }

        // Insert into tbl_nhanvienkho_tao_phieu_nhap
        $stmtNhanVien = $conn->prepare("INSERT INTO tbl_nhanvienkho_taophieu_nhap (MaPhieuNhap, IDNhanVien) VALUES (?, ?)");
        $stmtNhanVien->bind_param("si", $MaPhieuNhap, $IDNhanVien);
        if (!$stmtNhanVien->execute()) {
            throw new Exception("Không thể chèn vào tbl_nhanvienkho_tao_phieu_nhap: " . $stmtNhanVien->error);
        }
        $conn->commit();
        $_SESSION['message'] = "Phiếu nhập kho đã được tạo thành công!";
        echo "<script>
                window.location.href = 'nvPhieuYeuCau.php';
                </script>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['errorMessages'] = "Lỗi: " . $e->getMessage();
    }
}
ob_end_flush();

?>



<script type="text/javascript" src="../js/phanPhoiDonHang_Ship.js"></script>
</body>

</html>
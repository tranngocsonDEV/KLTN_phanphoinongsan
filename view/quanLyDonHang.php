<?php
include("../php/header_heThong.php");

?>
<?php
include("../php/sidebar_heThong.php");

?>
<?php
include("../php/thongBao.php");
include("../config/init.php");

?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Đơn hàng">Đơn hàng</div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Loại phiếu</label>
                    <select class="form-select" id="inputGroupSelect01">
                        <option selected value="11">Đang giao hàng</option>
                        <option value="8">Đã phân phối</option>
                        <option value="9">Đã xác nhận</option>
                        <option value="13">Đã giao hàng</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered table-responsive "
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Mã phiếu</th>
                                    <th>Tên phiếu</th>
                                    <th>Người lập</th>
                                    <th>Ngày đặt hàng</th>
                                    <th>Số lượng sản phẩm</th>
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
</main>
<script type="text/javascript" src="../js/phanPhoiDonHang_HienThi.js"></script>
</body>

</html>
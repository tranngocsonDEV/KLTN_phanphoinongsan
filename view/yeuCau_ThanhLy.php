<?php
include("../config/init.php");
include("../php/thongBao.php");
include("../php/header_heThong.php");
include("../php/sidebar_heThong.php");

?>
<main class="mt-5 pt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 fw-bold fs-3" id="du-lieu-title" data-title="Yêu cầu thanh lý">Yêu cầu thanh lý</div>

            <!-- Phân phoại phiếu -->
            <div class="phanLoaiPhieu d-flex">
                <!-- Trạng thái yêu cầu thanh lý -->
                <div class="row mb-2">
                    <div class="col">
                        <select class="form-select form-select-md" id="trangThaiSelect">
                            <option selected disabled>Trạng thái</option>
                            <option value="17">Chờ duyệt</option>
                            <option value="4">Đã duyệt</option>
                            <option value="5">Đã hủy</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Yêu cầu thanh lý</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example"
                                    class="table table-striped table-bordered table-responsive data-table "
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Mã yêu cầu</th>
                                            <th>Người tạo</th>
                                            <th>Thời gian</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</main>



</body>
<script type="text/javascript" src="../js/yeuCauThanhLy.js"></script>

</html>
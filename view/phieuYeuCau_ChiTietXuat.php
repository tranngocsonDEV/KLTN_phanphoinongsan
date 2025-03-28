<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/datatables.min.css" />
    <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="../css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <script type="text/javascript" src="../js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
    <script type="script" src="../js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript" src="../js/script.js"></script>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- offcanvas trigger -->

            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                <span class="navbar-toggler-icon" data-bs-target="#offcanvasScrolling"></span>
            </button>

            <!-- offcanvas trigger-->
            <a class="navbar-brand fw-bold me-auto" href="#">CNMOi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <ul class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="./thongTin_Xem.php">Thông tin</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="./thongTin_ChinhSua.php">Cài đặt</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Đăng xuất</a>
                            </li>
                        </ul>
                    </ul>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar -->

    <!-- offcanvas -->

    <div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            TRANG CHỦ
                        </div>
                    </li>
                    <li>
                        <a href="../index.php" class="nav-link px-3 active">
                            <span><i class="bi bi-speedometer2"></i></span>
                            <span>Thống kê</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider" />
                    </li>

                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            YÊU CẦU
                        </div>
                    </li>
                    <li>
                        <a href="./phieuYeuCau.php" class="nav-link px-3">
                            <span><i class="bi bi-card-text"></i></span>
                            <span>Phiếu yêu cầu</span>
                        </a>
                    </li>
                    <li>
                        <a href="./phieuBienBan.php" class="nav-link px-3">
                            <span><i class="bi bi-exclamation-triangle-fill"></i></span>
                            <span>Biên bản</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            QUẢN LÝ
                        </div>
                    </li>
                    <li>
                        <a href="./quanLyKho.php" class="nav-link px-3">
                            <span><i class="bi bi-database"></i></span>
                            <span>Sản phẩm</span>
                        </a>
                    </li>
                    <li>
                        <a href="./phanPhoiDonHang.php" class="nav-link px-3">
                            <span><i class="bi bi-box-seam"></i></span>
                            <span>Phân phối</span>
                        </a>
                    </li>
                    <li>
                        <a href="./quanLyDonHang.php" class="nav-link px-3">
                            <span><i class="bi bi-basket"></i></span>
                            <span>Đơn hàng</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            TÀI KHOẢN
                        </div>
                    </li>
                    <li>
                        <a href="./capTaiKhoan.php" class="nav-link px-3">
                            <span><i class="bi bi-person-add"></i></span>
                            <span>Cấp tài khoản</span>
                        </a>
                    </li>
                    <li class="my-4">
                        <hr class="dropdown-divider" />
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- offcanvas -->

    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 fw-bold fs-3">Chi tiết</div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Phiếu yêu cầu xuất kho</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <div class="col-6">
                                    <dt class="col-sm-3">Mã phiếu:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Tên phiếu:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Người lập:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Trạng thái:</dt>
                                    <dd class="col-sm-9">Chờ duyệt</dd>
                                    <dt class="col-sm-3">Ghi chú:</dt>
                                    <dd class="col-sm-9">Caosaofjfsa</dd>
                                </div>
                                <div class="col-6">
                                    <dt class="col-sm-3">Ngày đặt hàng:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Tên khách hàng:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Địa chỉ :</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Số điện thoại:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                    <dt class="col-sm-3">Thời gian giao hàng:</dt>
                                    <dd class="col-sm-9">01XVNS</dd>
                                </div>

                                <dt class="col-sm-3">Danh sách yêu cầu:</dt>
                            </dl>
                            <table class="table table-striped table-bordered table-responsive">
                                <tbody>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng yêu cầu</th>
                                        <th>Đơn vị</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                    <tr>
                                        <td>Táo</td>
                                        <td>20</td>
                                        <td>KG</td>
                                        <td>40000</td>
                                        <td>800000</td>
                                    </tr>
                                    <tr>
                                        <td>Ổi</td>
                                        <td>20</td>
                                        <td>KG</td>
                                        <td>40000</td>
                                        <td>800000</td>
                                    </tr>
                                    <tr>
                                        <td>Lê</td>
                                        <td>20</td>
                                        <td>KG</td>
                                        <td>40000</td>
                                        <td>800000</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="buttons">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="../html/phieuYeuCau.html" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">Duyệt phiếu</a>

                                    <a href="../html/phieuYeuCau.html" class="btn btn-danger btn-lg" tabindex="-1" role="button" aria-disabled="true">Hủy phiếu</a>
                                    <a href="../html/phieuYeuCau.html" class="btn btn-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">Quay lại</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
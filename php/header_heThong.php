<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../img/logo32.png" type="image/x-icon">

    <title>Phân phối nông sản</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <script type="text/javascript" src="../js/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>

    <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/dataTableLink.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="../js/Validator.js"></script>
    <script type="text/javascript" src="../js/quanLyDonHang.js"></script>
    <script type="text/javascript" src="../js/thongTinMatKhau.js"></script>
    <script type="text/javascript" src="../js/phanPhoiDonHang_Ship.js"></script>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <!-- offcanvas trigger -->
            <?php
            ob_start();
            include("../config/init.php");
            include("../php/thongBao.php");

            ob_end_flush();
            ?>
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                <span class="navbar-toggler-icon" data-bs-target="#offcanvasScrolling"></span>
            </button>

            <!-- offcanvas trigger-->
            <a class="navbar-brand fw-bold me-auto" href=""><img src="../img/logo32.png" height="28" width="28"
                    alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php

                    if (isset($_SESSION["ThongTinDangNhap"])):
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $_SESSION['ThongTinDangNhap']['Ten']; ?>
                                <i class="bi bi-person-circle"></i>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="../view/thongTin_Xem.php">Thông tin</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../view/thongTin_ChinhSua.php">Cài đặt</a>
                                </li>
                                <li>
                                    <form action="dangXuat.php" method="post">
                                        <button type="submit" name="logout_btn" class="dropdown-item">Đăng xuất</button>
                                        <!-- <a class="dropdown-item" href="../view/dangXuat.php">Đăng xuất</a> -->
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </nav>
<?php
// session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
require_once '../db_connect.php';
include "../ham.php";

if (!isset($_SESSION['username'])) {
    header("location: ../dang_nhap");
}
// $id_user = $_SESSION['id_user'];
// print_r($id_user);
$id_phong = $_GET['id_phong'];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng chờ</title>

    <!-- Thêm Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-vB4yY4qR2vX2uQETzjGGgbg5nFgxFNchctN2xt4r/NZT+a2hpIbi5zLNl0mjJxg0" crossorigin="anonymous">
    <!-- Thêm CSS Animate.css cho hiệu ứng chuyển động -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Thêm Font Awesome cho các biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS tùy chỉnh -->
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #FFEB3B;
            /* Vàng tươi sáng */
            color: #333;
            padding: 30px;
        }

        .container {
            max-width: 100%;
            padding: 40px;
            border-radius: 20px;
            background-color: #FFF8DC;
            /* Màu kem */
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.5s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #FF5733;
            font-size: 4rem;
            animation: bounceInDown 1s ease-out;
            font-family: 'Baloo', sans-serif;
        }

        .btn-primary {
            background-color: #FF85D1;
            border-color: #FF85D1;
            font-size: 1.5rem;
            padding: 15px;
            border-radius: 12px;
            transition: all 0.3s;
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: #FF4D9B;
            border-color: #FF4D9B;
            transform: scale(1.1);
        }

        /* Cải tiến bảng */
        .rank-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .rank-table th,
        .rank-table td {
            padding: 12px;
            text-align: center;
            font-size: 1.1rem;
            color: #333;
            border: 2px solid #FF85D1;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .rank-table th {
            background-color: #FF85D1;
            color: #FFF;
            font-size: 1.2rem;
            font-weight: bold;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .rank-table td {
            background-color: #FFF0F5;
            font-size: 1.1rem;
        }

        /* Hiệu ứng cho bảng xếp hạng */
        .rank-table tr:nth-child(odd) {
            background-color: #FFEBF0;
        }

        .rank-table tr:hover {
            background-color: #FFCCF9;
            transform: scale(1.05);
            cursor: pointer;
        }

        .rank-table .top1 {
            background-color: #FFD700;
            color: #FFF;
            font-weight: bold;
            font-size: 1.5rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .rank-table .top2 {
            background-color: #C0C0C0;
            color: #FFF;
            font-weight: bold;
            font-size: 1.3rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .rank-table .top3 {
            background-color: #CD7F32;
            color: #FFF;
            font-weight: bold;
            font-size: 1.3rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        }

        /* Biểu tượng cho top 3 */
        .rank-table .top1 i {
            color: #FFD700;
            font-size: 1.5rem;
        }

        .rank-table .top2 i {
            color: #C0C0C0;
            font-size: 1.3rem;
        }

        .rank-table .top3 i {
            color: #CD7F32;
            font-size: 1.3rem;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes bounceInDown {
            from {
                opacity: 0;
                transform: translateY(-2000px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* CSS cho nút Bắt đầu */
        .btn-primary {
            background-color: #FF85D1;
            /* Màu hồng tươi */
            border-color: #FF85D1;
            font-size: 1.5rem;
            padding: 15px 30px;
            border-radius: 12px;
            text-align: center;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        /* Khi hover (di chuột vào) */
        .btn-primary:hover {
            background-color: #FF4D9B;
            /* Màu hồng đậm khi hover */
            border-color: #FF4D9B;
            transform: scale(1.1);
            /* Phóng to một chút */
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
            /* Thêm bóng đổ khi hover */
        }

        /* Hiệu ứng nhấn (active) */
        .btn-primary:active {
            transform: scale(0.98);
            /* Thu nhỏ khi nhấn */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Hiệu ứng focus khi nút được chọn */
        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 2px #FF85D1;
            /* Thêm viền màu khi focus */
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <a href="../trang_chu/">Trở về</a>
        <input type="hidden" name="id_phong" value="<?php echo $id_phong; ?>">
        <!-- Nút Bắt Đầu -->
        <input type="submit" name="btn_bat_dau" class="btn btn-primary" value="Bắt đầu">
    </form>
    <?php
    if (isset($_POST['btn_bat_dau'])) {
        echo "oke";
        $id_phong = $_POST['id_phong'];
        $id_user = $_SESSION['id_user'];
        echo "id_phong:" . $id_phong;
        echo "id_user: " . $_SESSION['id_user'];
        $tg_bat_dau = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `luyen_tap`( `id_phong`, `id_user`, `thoi_gian_bat_dau`) VALUES ('$id_phong','$id_user','$tg_bat_dau')";
        mysqli_query($conn, $sql);
        $last_id = mysqli_insert_id($conn);
        echo "id_vừa_chèn" . $last_id;
        $ds_id_bai_tap = get_bt_theo_phong($id_phong);
        foreach ($ds_id_bai_tap as $key => $value) {
            $sql = "INSERT INTO `de_luyen_tap`( `id_luyen_tap`, `id_bai_tap`) VALUES ('$last_id','$value')";
            mysqli_query($conn, $sql);
        }
        header("location: vao_phong_v2.php?id_phong=$id_phong&id_luyen_tap=$last_id");
    }
    ?>
    <div class="container">
        <h2 class="animate__animated animate__bounceInDown">Phòng Chờ Luyện Tập</h2>

        <!-- Bảng Xếp Hạng -->
        <h3 class="text-center mt-5 animate__animated animate__fadeInUp">Bảng Xếp Hạng</h3>
        <table class="table table-bordered rank-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên Người Chơi</th>
                    <th>Điểm</th>
                    <th>Thời Gian Làm Bài</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $sql = "SELECT * FROM `nguoi_choi_tung_phong` WHERE `id_phong` = '$id_phong'";
                // $kq = mysqli_query($conn, $sql);
                // if (mysqli_num_rows($kq) > 0) {
                //     $rank = 1;
                //     while ($row = mysqli_fetch_array($kq)) {
                //         // Xác định vị trí của người chơi
                //         $rowClass = "";
                //         if ($rank == 1) {
                //             $rowClass = "top1";
                //         } elseif ($rank == 2) {
                //             $rowClass = "top2";
                //         } elseif ($rank == 3) {
                //             $rowClass = "top3";
                //         }

                //         // Thêm biểu tượng cho các vị trí top 3
                //         $icon = "";
                //         if ($rank == 1) {
                //             $icon = "<i class='fas fa-trophy'></i>"; // Biểu tượng cúp cho Top 1
                //         } elseif ($rank == 2) {
                //             $icon = "<i class='fas fa-medal'></i>"; // Biểu tượng huy chương cho Top 2
                //         } elseif ($rank == 3) {
                //             $icon = "<i class='fas fa-certificate'></i>"; // Biểu tượng chứng nhận cho Top 3
                //         }

                //         echo "<tr class='$rowClass'>
                //             <td>$rank $icon</td>
                //             <td>{$row['ten_user']}</td>
                //             <td>{$row['diem']}</td>
                //             <td>{$row['thoi_gian_lam_bai']}</td>
                //           </tr>";
                //         $rank++;
                //     }
                // } else {
                //     echo "<tr></tr>";
                // }

                ?>
            </tbody>
        </table>
    </div>

    <!-- Thêm Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-7/q4pI8YxkpF37E5P3W3lKpv4KMQybs8hTf00xxnP2pzjOYyx7gqbE7+V1oGAW5o" crossorigin="anonymous"></script>

</body>

</html>
<?php require_once '../db_connect.php'; // Đảm bảo đường dẫn đúng 
include "../ham.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính số lượng câu dựa trên tỷ lệ %</title>
    <link rel="stylesheet" href="b1.css"> <!-- Liên kết đến tệp CSS -->
    <style>
        .content {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Nhập giải giá trị tsố</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kiểm tra nếu người dùng đã chọn ít nhất một checkbox
            if (isset($_POST['bai_hoc'])) {
                $selected_bai_hoc = $_POST['bai_hoc']; // Mảng chứa các id bài học đã chọn
                $ten_phong  = $_POST['ten_phong'];
        ?>
                <form action="" method="post">
                    <input type="hidden" name="loai_phong" value="<?php echo $_POST['loai_phong']; ?>">
                    <input type="hidden" name="ten_phong" value="<?php echo $_POST['ten_phong']; ?>">
                    <?php
                    // $ten_phong  = $_POST['ten_phong'];
                    echo "<br>Các chủ đề vừa chọn:<br>";
                    foreach ($selected_bai_hoc as $index => $bai_hoc_id) {

                        echo "<div class='lesson-container'>";
                        echo "Bài học: " . get_ten_bai_hoc($bai_hoc_id) . "<br>";
                        echo "<input type='hidden' name='id_bai_hoc[]' value='$bai_hoc_id'>";
                        // Nút để mở rộng/thu gọn
                        echo "<span class='toggle-button' onclick='toggleContent($index)'>Mở rộng</span>";
                        echo "<div id='content-$index' class='content'>"; // ID cho nội dung mở rộng
                        echo " <script>
        var content = document.getElementById('content-' + $index);
        content.style.display = 'none';
    </script>";
                        // Ô nhập cho các giá trị cần nhập và tính toán
                        echo "<label for='question_count_$index'>Số lượng câu hỏi:</label>";
                        echo "<input type='number' value='5' min='1' max ='20' name='question_count[]' id='question_count_$index' required><br>";

                        echo "<label for='min_value_$index'>Số nhỏ nhất:</label>";
                        echo "<input type='number' value ='1' min='1' max ='10' name='min_value[]' id='min_value_$index' required><br>";

                        echo "<label for='max_value_$index'>Số lớn nhất:</label>";
                        echo "<input type='number'  value ='10' min='1' max ='10' name='max_value[]' id='max_value_$index' required><br>";

                        echo "<label for='sl_cot_$index'>Số lượng cột:</label>";
                        echo "<input type='number'  value ='3' min='1' max ='10' name='sl_cot[]' id='sl_cot_$index' required><br>";

                        echo "<label for='sl_hang_$index'>Số lượng hàng:</label>";
                        echo "<input type='number'  value ='3' min='1' max ='10' name='sl_hang[]' id='sl_hang_$index' required><br>";

                        echo "<label for='selected_value_$index'>Số cần chọn:</label>";
                        echo "<input type='number'  value ='3' min='1' max ='10' name='selected_value[]' id='selected_value_$index' required><br>";

                        echo "<label for='sum_value_$index'>Tổng:</label>";
                        echo "<input type='number'  value ='3' min='1' max ='10' name='sum_value[]' id='sum_value_$index' required><br>";

                        echo "<label for='difference_value_$index'>Hiệu:</label>";
                        echo "<input type='number'  value ='3' min='1' max ='10' name='difference_value[]' id='difference_value_$index' required><br>";

                        echo "<label for='sl_coc$index'>Số lượng cốc:</label>";
                        echo "<input type='number'  value ='3' min='1' max ='10'  name='sl_coc' id='sl_coc_value_$index' required><br>";

                        echo "</div>"; // Kết thúc nội dung mở rộng
                        echo "</div>"; // Kết thúc lesson-container
                    }
                    ?>
                    <input type="submit" name="btn_xac_nhan" value="Xác nhận" class="btn-confirm">
                </form>
        <?php
            } else if (isset($_POST['btn_xac_nhan'])) {
                // Xử lý khi người dùng nhấn nút xác nhận
                $id_bai_hoc = $_POST['id_bai_hoc'];
                print_r($id_bai_hoc);
                // Lấy tổng số lượng câu hỏi
                // $totalQuestions = $_POST['totalQuestions'];

                // Lấy dữ liệu từ các trường nhập
                $ten_phong = $_POST['ten_phong'];
                $questionCount = $_POST['question_count'];
                $minValue = $_POST['min_value'];
                $maxValue = $_POST['max_value'];
                $selectedValue = $_POST['selected_value'];
                $sumValue = $_POST['sum_value'];
                $differenceValue = $_POST['difference_value'];
                $sl_cot = $_POST['sl_cot'];
                $sl_hang = $_POST['sl_hang'];
                $sl_coc = $_POST['sl_coc'];
                // $loai_cau = [1, 2, 3];
                $loai_phong = $_POST['loai_phong'];
                // print_r($questionCount);
                // echo "Tên phòng" . $ten_phong;
                // Hiển thị dữ liệu người dùng nhập
                // echo "Tổng số lượng câu hỏi: $totalQuestions <br><br>";
                $sql = "INSERT INTO `phong`(`ten_phong`,`loai_phong`) VALUES ('$ten_phong','$loai_phong')";
                mysqli_query($conn, $sql);
                $last_id = mysqli_insert_id($conn);
                foreach ($questionCount as $index => $value) {
                    echo "Bài học $index: <br>";;
                    echo $id_bai_hoc[$index];
                    $loai_cau = get_bt_theo_chu_de($id_bai_hoc[$index]);
                    echo "loại câu";

                    $so_chon = $selectedValue[$index];
                    $tong = $sumValue[$index];
                    $hieu = $differenceValue[$index];
                    for ($i = 0; $i < $value; $i++) {

                        $resultArray = create2DArray($sl_hang[$index], $sl_cot[$index], $minValue[$index], $maxValue[$index]);
                        $taoMang_coc = json_encode(taoMang($sl_coc, $minValue[$index], $maxValue[$index]));
                        $resultArrayJson = json_encode($resultArray);
                        $random_key = array_rand($loai_cau);  // Lấy chỉ mục ngẫu nhiên
                        $random_value = $loai_cau[$random_key];

                        if ($random_value == 1) {
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$resultArrayJson','$so_chon','$tong','$hieu','1','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 2) {
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$resultArrayJson','$so_chon','$tong','$hieu','2','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 3) {
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$taoMang_coc','$so_chon','$tong','$hieu','3','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 4) {
                            $a = json_encode(generate2DArray($minValue[$index], $maxValue[$index], 10));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','4','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 5) {
                            $a = json_encode(hieu($minValue[$index], $maxValue[$index], 10));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','5','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 6) {
                            $a = json_encode(tạo_mang_1_chieu($minValue[$index], $maxValue[$index], rand(1, 10)));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','6','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        } elseif ($random_value == 7) {
                            $a = json_encode(tạo_mang_1_chieu($minValue[$index], $maxValue[$index], rand(1, 10)));
                            $sql = "INSERT INTO `bai_tap`(`id_bai_tap`,`ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `id_loai_bt`, `id_phong`) VALUES (null,'Chọn số','$a','$so_chon','$tong','$hieu','7','$last_id')";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Lỗi chèn dữ liệu: " . mysqli_error($conn) . "<br>";
                            }
                        }
                    }


                    header("location: ../trang_chu");
                    echo "Số lượng câu hỏi: $value <br>";
                    echo "Số nhỏ nhất: {$minValue[$index]} <br>";
                    echo "Số lớn nhất: {$maxValue[$index]} <br>";
                    echo "Số lượng cột: {$sl_cot[$index]} <br>";
                    echo "Số lượng hàng: {$sl_hang[$index]} <br>";
                    echo "Số cần chọn: {$selectedValue[$index]} <br>";
                    echo "Tổng: {$sumValue[$index]} <br>";
                    echo "Hiệu: {$differenceValue[$index]} <br><br>";
                }
            }
        }
        ?>
    </div>
    <?php

    function create2DArray($rows, $cols, $minValue, $maxValue)
    {
        $array = [];

        for ($i = 0; $i < $rows; $i++) {
            $array[$i] = []; // Tạo một hàng mới
            for ($j = 0; $j < $cols; $j++) {
                // Tạo một giá trị ngẫu nhiên trong khoảng từ minValue đến maxValue
                $array[$i][$j] = rand($minValue, $maxValue);
            }
        }

        return $array;
    }
    function taoMang($so_luong_phan_tu, $so_nho_nhat, $so_lon_nhat)
    {
        $mang = [];

        if ($so_luong_phan_tu > 0 && $so_nho_nhat <= $so_lon_nhat) {
            for ($i = 0; $i < $so_luong_phan_tu; $i++) {
                $mang[] = rand($so_nho_nhat, $so_lon_nhat);
            }
        }

        return $mang;
    }
    ?>
    <script>
        function toggleContent(index) {
            var content = document.getElementById('content-' + index);
            var button = content.previousElementSibling; // Lấy nút mở rộng

            if (content.style.display === "none") {
                content.style.display = "block"; // Hiển thị nội dung
                button.textContent = "Thu gọn"; // Thay đổi nội dung nút
            } else {
                content.style.display = "none"; // Ẩn nội dung
                button.textContent = "Mở rộng"; // Thay đổi nội dung nút
            }
        }
    </script>

</body>

</html>
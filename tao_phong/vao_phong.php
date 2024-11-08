<?php
require_once '../db_connect.php';

$id_phong = $_GET['id_phong'];
$current = isset($_GET['current']) ? (int)$_GET['current'] : 1; // Default to 1 if not set

// Get the total number of questions for this room
$sql_total = "SELECT COUNT(*) as total FROM `bai_tap` WHERE `id_phong`='$id_phong'";
$result_total = mysqli_query($conn, $sql_total);
$total = mysqli_fetch_assoc($result_total)['total'];

// Fetch the current question based on the `$current` position
$sql = "SELECT * FROM `bai_tap` WHERE `id_phong`='$id_phong' LIMIT 1 OFFSET " . ($current - 1);
$kq = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="../trang_chu/">Trở về</a>

    <div id="question-content">
        <?php
        // Display the question if there are any results
        if (mysqli_num_rows($kq) > 0) {
            while ($row = mysqli_fetch_array($kq)) {
                $matrix = json_decode($row['ma_tran'], true);
                $so_can_chon = $row['so_can_chon'];
                $tong = $row['tong'];

                // Display different links based on the question type
                if ($row['id_loai_bt'] == 1) {
                    echo "<a href='../game/nhan_biet.php'>Go to Nhận Biết Game</a>";
                } elseif ($row['id_loai_bt'] == 2) {
                    echo "<a href='../game/chon_cap.php'>Go to Chọn Cặp Game</a>";
                } elseif ($row['id_loai_bt'] == 3) {
                    echo "<a href='../game/Pour_Water/nhanbiet/nhanbiet.php'>Go to Pour Water - Nhận Biết Game</a>";
                }
            }
        } else {
            echo "Không có bản ghi nào";
        }
        ?>

        <!-- Navigation buttons for switching between questions -->
        <div>
            <?php if ($current > 1): ?>
                <a href="?id_phong=<?= $id_phong ?>&current=<?= $current - 1 ?>">Previous</a>
            <?php endif; ?>
            <?php if ($current < $total): ?>
                <a href="?id_phong=<?= $id_phong ?>&current=<?= $current + 1 ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <button onclick="nop_bai()" id="nop_bai">Nộp bài</button>
</body>

<script>
    function nop_bai() {
        console.log("Nộp bài");
    }
</script>

</html>
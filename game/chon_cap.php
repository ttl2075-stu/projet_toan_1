<?php
include "../ham.php";
$id_bai_tap = $_GET['id_bai_tap'];
$id_luyen_tap = $_GET['id_luyen_tap'];
$da_hoan_thanh = (kt_hoan_thanh_bai_tap($id_bai_tap, $id_luyen_tap) != 0);
$sql = "SELECT `id_phong` FROM `luyen_tap` WHERE `id_luyen_tap`='$id_luyen_tap'";
$kq = mysqli_query($conn, $sql);
$id_phong  = mysqli_fetch_array($kq);
$a = $_SESSION['ds_id_bai_tap'];
$current_index = array_search($id_bai_tap, $a);
$previous_id = ($current_index > 0) ? $a[$current_index - 1] : null;
$next_id = ($current_index < count($a) - 1) ? $a[$current_index + 1] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài game ma trận</title>
    <style>
        body {
            font-family: "montserrat", sans-serif;
            font-size: 100%;
        }

        #box {
            margin: 5% 10%;
            /*        width : 100%;*/
            border: 2px solid whitesmoke;
            /*        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px inset, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px inset;*/
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            border-radius: 7px;
        }

        .noidung {
            padding: 15px;
            text-align: center;
            font-size: 30px;
        }

        .head {
            background: #6793B1;
            min-height: 40px;
        }

        .tieude {
            padding: 5px 15px;
            font-size: 25px;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .input {
            margin-top: 10px;
        }

        input {
            height: 50px;
            width: 150px;
            border-radius: 10px;
            border: none;
        }

        .form {
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-around;

        }

        .item {
            display: inline-block;
            margin: 5px 10px;
        }

        .option {
            font-size: 22px;
            color: darkcyan;
            border: 1px solid darkcyan;
        }

        input.option {
            font-weight: bold;
            border: 1px solid darkcyan;
        }

        .result {
            margin: 10px auto;
        }

        .title-table {
            background: darkcyan;
            color: whitesmoke;
            border-radius: 10px;
            border: 1px solid whitesmoke;
            --shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;
        }

        .title-table:hover {

            box-shadow: 0 0 0 2px rgba(218, 102, 123, 1), 8px 8px 0 0 rgba(218, 102, 123, 1);
        }

        td {
            min-width: 40px;
            height: 40px;
        }

        /* button {
            width: 100%;
            height: 100%;
        } */

        .matrix-table {
            border-collapse: collapse;
            /* background: darkcyan; */
            color: whitesmoke;
            border-radius: 10px;

            border: 1px solid whitesmoke;
            --shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;
        }

        .matrix-button {
            width: 100%;
            height: 40px;
            font-size: 34px;
            /* background-color: #e0e0e0; */
            background: darkcyan;
            border: 1px solid whitesmoke;
            border-collapse: collapse;
            border-radius: 10px;
            color: whitesmoke;
            --shadow: rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;

            /* border: none; */
            cursor: pointer;
        }

        .matrix-button.clicked {
            /* background-color: #ffffff; */
            background-color: darkorange;
        }

        .matrix-button:hover {
            /* border: 1px solid lightcoral; */
            box-shadow: 0 0 0 2px rgba(218, 102, 123, 1), 8px 8px 0 0 rgba(218, 102, 123, 1);
        }

        .matrix-button.hidden {
            /* visibility: hidden; */


            opacity: 0.1;
            background-color: black !important;
        }



        .ket_qua {
            text-align: left;
            font-size: 34px;
            padding-left: 100px;
            display: none;
        }

        .gio_hang {
            width: 100%;
            height: auto;
            border: 1px lightcoral solid;
            text-align: center;
            font-size: 34px;
            /* display: none; */
        }

        .matrix-button.hidden:hover {
            /* background-color: red; */
            cursor: no-drop;
        }
    </style>
</head>

<body>
    <!-- Begin Phần thưởng -->
    <?php
    $phanThuong = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    ?>

    <div id="wheelContainer">
        <canvas id="wheel"></canvas>
        <div id="pointer"></div> <!-- Mũi tên chỉ định vị trí -->
        <button id="spinButton">Quay</button>
    </div>

    <!-- Thêm thẻ audio để chèn nhạc -->
    <audio id="spinSound">
        <source src="2.mp3" type="audio/mpeg"> <!-- Thay '2.mp3' bằng đường dẫn đến file nhạc của bạn -->
        Trình duyệt của bạn không hỗ trợ âm thanh.
    </audio>

    <!-- <div id="congratulations">Chúc mừng bạn đã trúng thưởng!</div> -->

    <script>
        const canvas = document.getElementById('wheel');
        const ctx = canvas.getContext('2d');
        const values = <?php echo json_encode($phanThuong); ?>;
        const ma_mau = ['#FFD700', '#FFA500', '#32CD32', '#FF4500', '#00CED1', '#9400D3', '#FF1493', '#1E90FF', '#FFDAB9', '#8A2BE2'];

        const colors = [];
        let k = 0;
        for (let index = 0; index < values.length; index++) {
            colors.push(ma_mau[k]);
            if (k % 9 == 0) {
                k = 0;
            }
            k++;
        }

        const numSegments = values.length;
        const anglePerSegment = 360 / numSegments;
        let spinAngle = 0;

        // Biến theo dõi số lượt quay tối đa
        const maxSpins = 1; // Số lượt quay tối đa
        let remainingSpins = maxSpins; // Lượt quay còn lại

        // Hàm để thiết lập kích thước vòng quay
        function drawWheel(size) {
            const radius = size / 2;
            canvas.width = size;
            canvas.height = size;

            for (let i = 0; i < numSegments; i++) {
                const angle = i * (2 * Math.PI / numSegments);
                ctx.beginPath();
                ctx.moveTo(radius, radius);
                ctx.arc(radius, radius, radius, angle, angle + (2 * Math.PI / numSegments));
                ctx.fillStyle = colors[i];
                ctx.fill();
                ctx.stroke();

                // Vẽ số trong mỗi phần
                ctx.save();
                ctx.translate(radius, radius);
                ctx.rotate(angle + (Math.PI / numSegments));
                ctx.textAlign = "center";
                ctx.fillStyle = "black";
                ctx.font = `${size * 0.06}px Arial`; // Tự động điều chỉnh kích thước font
                ctx.fillText(values[i], radius * 0.75, 10); // Đặt số ở vị trí cách trung tâm
                ctx.restore();
            }
        }

        // Xử lý quay vòng
        function spinWheel() {
            // Kiểm tra số lượt quay còn lại
            if (remainingSpins <= 0) {
                alert("Bạn đã hết lượt quay. Vui lòng quay lại sau.");
                return; // Dừng lại nếu hết lượt quay
            }

            let finalSegment = '';
            const randomSpin = Math.floor(Math.random() * 360 + 360 * 5); // Quay ít nhất 5 vòng
            const finalSpinAngle = spinAngle + randomSpin; // Lưu trữ góc quay cuối cùng
            const spinTime = 3000; // Thời gian quay là 3 giây
            const spinSound = document.getElementById('spinSound');

            // Phát nhạc khi bắt đầu quay
            spinSound.play();

            // Thêm hiệu ứng quay
            canvas.style.transition = `transform ${spinTime / 1000}s ease-out`;
            canvas.style.transform = `rotate(${finalSpinAngle}deg)`;

            // Lắng nghe sự kiện kết thúc hiệu ứng CSS (vòng quay dừng lại)
            canvas.addEventListener('transitionend', function() {
                // Dừng nhạc khi vòng quay kết thúc
                spinSound.pause();
                spinSound.currentTime = 0;

                const normalizedAngle = finalSpinAngle % 360;
                const selectedSegmentIndex = Math.floor((numSegments - (normalizedAngle / anglePerSegment)) % numSegments);
                finalSegment = values[selectedSegmentIndex];
                console.log(finalSegment);

                // Hiển thị kết quả sau khi quay và nhạc kết thúc
                let id_user = <?php echo $_SESSION['id_user']; ?>;
                let id_phong = <?php echo $id_phong['id_phong']; ?>;
                alert(`Bạn trúng: ${finalSegment}`);

                // Log kiểm tra các giá trị cần gửi
                console.log(`id_user: ${id_user}, id_phong: ${id_phong}, score: ${finalSegment}`);

                // Gửi dữ liệu qua fetch
                fetch('cap_nhap_diem.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id_user=${id_user}&id_phong=${id_phong}&score=${finalSegment}`
                })
                location.reload();

                // Cập nhật spinAngle cho vòng quay tiếp theo
                spinAngle = finalSpinAngle;

                // Giảm lượt quay còn lại
                remainingSpins--;
            });
        }


        // Gọi hàm để vẽ vòng quay với kích thước truyền vào
        const wheelSize = 500;
        drawWheel(wheelSize);

        // Gán sự kiện khi nhấn nút "Quay"
        document.getElementById('spinButton').addEventListener('click', spinWheel);
    </script>
    <!-- end phần thưởng -->

    <?php if ($da_hoan_thanh): ?>
        <div class="overlay">
            <div class="overlay-content">
                <h2>Đã hoàn thành</h2>
                <p>Bạn đã hoàn thành bài tập này, không cần phải làm lại.</p>
            </div>
        </div>
    <?php endif; ?>
    <?php
    $de_bai = get_de_bai($id_bai_tap);
    // print_r($de_bai);

    $matrix = json_decode($de_bai['ma_tran']);
    $tong = $de_bai['tong'];

    ?>
    <div id="box">
        <div class="head">
            <div class="tieude" align="center">Chọn các cặp có tổng bằng <?php echo $tong; ?></div>
        </div>

        <div class="result">

            <?php

            echo "<table width='100%' cellpadding='5' cellspacing='5px' border='1' class='matrix-table'>";
            foreach ($matrix as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td><button class='matrix-button' data-value='$cell'>$cell</button></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

            ?>


        </div>
        <div class="ket_qua">

        </div>
        <div>
            <button onclick="nop_bai()">Nộp bài </button>
        </div>
        <div class="gio_hang">
            <h3>Các cặp đã chọn</h3>
        </div>
    </div>
    <div class="navigation">
        <p>Câu <?php echo $current_index + 1; ?>/<?php echo count($a); ?></p>
        <?php
        if ($current_index == count($a)) {
        ?>
            <a href="" class="bn632-hover bn26">Nộp bài tất cả</a>
        <?php
        } ?>
        <?php if ($previous_id !== null): ?>
            <?php
            $loai_hien_tai = get_loai_bt($previous_id);
            if ($loai_hien_tai == 1) {
            ?>
                <a href="<?php echo $duong_dan; ?>nhan_biet.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php
            } elseif ($loai_hien_tai == 2) {
            ?>
                <a href="<?php echo $duong_dan; ?>chon_cap.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php

            } elseif ($loai_hien_tai == 3) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/nhanbiet/nhanbiet.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php
            } elseif ($loai_hien_tai == 4) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/congtru/phepcong.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php
            } elseif ($loai_hien_tai == 5) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/congtru/pheptru.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php
            } elseif ($loai_hien_tai == 6) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/sosanh/sosanh.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php
            } elseif ($loai_hien_tai == 7) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/sosanh/sosanh.php?id_bai_tap=<?php echo $previous_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài trước</a>
            <?php
            }
            ?>
        <?php endif; ?>

        <?php if ($next_id !== null): ?>
            <?php
            $loai_hien_tai = get_loai_bt($next_id);
            // print_r($loai_hien_tai);
            if ($loai_hien_tai == 1) {
            ?>
                <a href="<?php echo $duong_dan; ?>nhan_biet.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php
            } elseif ($loai_hien_tai == 2) {
            ?>
                <a href="<?php echo $duong_dan; ?>chon_cap.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php

            } elseif ($loai_hien_tai == 3) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/nhanbiet/nhanbiet.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php
            } elseif ($loai_hien_tai == 4) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/congtru/phepcong.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php
            } elseif ($loai_hien_tai == 5) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/congtru/pheptru.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php
            } elseif ($loai_hien_tai == 6) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/sosanh/sosanh.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php
            } elseif ($loai_hien_tai == 7) {
            ?>
                <a href="<?php echo $duong_dan; ?>Pour_Water/sosanh/sosanh.php?id_bai_tap=<?php echo $next_id; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>" class="bn632-hover bn26">Bài tiếp theo</a>
            <?php
            }
            ?>

        <?php endif; ?>
    </div>

    <script>
        function nop_bai() {
            if (kiem_tra() == 0) {
                alert("Bạn đã làm đúng")
                document.getElementById("wheelContainer").style.display = "flex";
                // Gửi yêu cầu AJAX đến PHP để cập nhật cơ sở dữ liệu khi trả lời đúng
                fetch('nhan_biet_gui_dl.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'trang_thai=2&id_bai_tap=<?php echo $id_bai_tap; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>'
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message); // Hiển thị thông báo
                        if (data.success) {
                            // Tải lại trang sau khi cập nhật thành công
                            // location.reload(); // Hoặc window.location.href = window.location.href;
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi AJAX: ", error);
                    });
            } else {
                alert("Bạn làm sai")
                // Gửi yêu cầu AJAX đến PHP để cập nhật cơ sở dữ liệu khi trả lời sai
                fetch('nhan_biet_gui_dl.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'trang_thai=1&id_bai_tap=<?php echo $id_bai_tap; ?>&id_luyen_tap=<?php echo $id_luyen_tap; ?>'
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message); // Hiển thị thông báo
                        if (data.success) {
                            // Tải lại trang sau khi cập nhật thành công
                            location.reload(); // Hoặc window.location.href = window.location.href;
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi AJAX: ", error);
                    });
            }
        }

        function dem_so_lan_xuat_hien() {
            let matrixButtons = document.querySelectorAll('.matrix-button');
            let countOccurrences = {};

            // Đếm số lần xuất hiện của từng số
            matrixButtons.forEach(button => {
                let value = button.getAttribute('data-value');

                if (!button.classList.contains('clicked') && !button.classList.contains('hidden')) {
                    if (countOccurrences[value]) {
                        countOccurrences[value]++;
                    } else {
                        countOccurrences[value] = 1;
                    }
                }

            });
            return countOccurrences
        }

        function chuyen_dt_sang_mang(obj) {
            let result = [];
            // Duyệt qua các cặp key-value của đối tượng obj
            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    let value = obj[key];
                    // Thêm key vào mảng value lần
                    for (let i = 0; i < value; i++) {
                        result.push(parseInt(key)); // Chuyển key về kiểu số nếu cần
                    }
                }
            }
            return result
        }

        function thong_ke_cac_cap(arr, target) {
            let result = [];
            let map = {};

            for (let i = 0; i < arr.length; i++) {
                let complement = target - arr[i];
                if (map[complement]) {
                    result.push([complement, arr[i]]);
                }
                map[arr[i]] = true;
            }

            return result;
        }

        // hiển thị dữ liệu
        function hien_thi(a, b) {
            let occurrence = {};

            // Duyệt từng key trong đối tượng a
            for (let key in a) {
                if (a.hasOwnProperty(key)) {
                    let numKey = parseInt(key);
                    let count = a[key];

                    // Nếu key chưa tồn tại trong đối tượng occurrence, khởi tạo
                    if (!occurrence[numKey]) {
                        occurrence[numKey] = {
                            count: count,
                            pairs: []
                        };
                    }

                    // Duyệt từng mảng con trong mảng b
                    for (let i = 0; i < b.length; i++) {
                        // Kiểm tra xem numKey có trong mảng con b[i] không
                        if (b[i].includes(numKey)) {
                            // Thêm mảng con b[i] vào mảng pairs của numKey
                            occurrence[numKey].pairs.push(b[i]);
                        }
                    }
                }
            }

            // Hiển thị thông tin vào thẻ div
            let ketQuaDiv = document.querySelector('.ket_qua');
            ketQuaDiv.innerHTML = ""
            for (let key in occurrence) {
                if (occurrence.hasOwnProperty(key)) {
                    let info = `Số ${key} xuất hiện ${occurrence[key].count} lần`;
                    if (occurrence[key].count > 0) {
                        info += ` .Có ${occurrence[key].pairs.length} cặp là ${JSON.stringify(occurrence[key].pairs)}`;
                    } else {
                        info += ` không có cặp`;
                    }
                    let p = document.createElement('p');
                    p.textContent = info;
                    ketQuaDiv.appendChild(p);
                }
            }

        }

        function hien_thi_gio_hang(a) {
            let ketQuaDiv = document.querySelector('.gio_hang');

            let p = document.createElement('p');
            p.textContent = a;
            ketQuaDiv.appendChild(p);

        }
        let gio_hang = []
        let sl_chon_dung = 0; // đếm số lượng chọn đúng của người chơi
        document.addEventListener('DOMContentLoaded', function() {

            let selectedButtons = [];
            let tong = <?php echo $tong; ?>;
            let sl_xh = dem_so_lan_xuat_hien()
            let sl_xl_new = chuyen_dt_sang_mang(sl_xh)
            let sl_cac_cap = thong_ke_cac_cap(sl_xl_new, tong)
            // console.log(sl_xh);
            // console.log(sl_cac_cap);
            hien_thi(sl_xh, sl_cac_cap)
            document.querySelectorAll('.matrix-button').forEach(button => {
                button.addEventListener('click', function() {
                    if (!button.classList.contains('clicked') && !button.classList.contains('hidden')) {
                        button.classList.add('clicked');
                        selectedButtons.push(button);

                        if (selectedButtons.length === 2) {
                            let sum = 0;
                            selectedButtons.forEach(btn => {
                                sum += parseInt(btn.dataset.value);
                            });

                            if (sum === tong) {
                                let a = []
                                selectedButtons.forEach(btn => {
                                    a.push(parseInt(btn.dataset.value))
                                    btn.classList.add('hidden');
                                });
                                // gio_hang.push(a)
                                hien_thi_gio_hang(a)
                                sl_chon_dung++;
                            } else {
                                selectedButtons.forEach(btn => {
                                    btn.classList.remove('clicked');
                                });
                            }
                            console.log(sl_chon_dung);

                            selectedButtons = [];
                            sl_xh = dem_so_lan_xuat_hien()
                            sl_xl_new = chuyen_dt_sang_mang(sl_xh)
                            sl_cac_cap = thong_ke_cac_cap(sl_xl_new, tong)
                            // console.log(sl_xh);
                            // console.log(sl_cac_cap);
                            hien_thi(sl_xh, sl_cac_cap)
                            // console.log(gio_hang);
                            // hien_thi_gio_hang(gio_hang)
                        }
                    }
                });
            });

        });


        function kiem_tra() {
            const buttons = document.querySelectorAll('.matrix-button:not(.hidden)');
            const values = Array.from(buttons).map(button => parseInt(button.getAttribute('data-value')));
            const target = <?php echo $tong; ?>

            // Tạo một đối tượng để lưu trữ các giá trị đã thấy
            const seen = new Set();

            for (let value of values) {
                const complement = target - value; // Tìm giá trị cần để tạo thành cặp
                if (seen.has(complement)) {
                    // Nếu giá trị cần có trong tập đã thấy, trả về 1
                    console.log(1);
                    return 1;
                }
                seen.add(value); // Thêm giá trị vào tập đã thấy
            }

            // Nếu không tìm thấy cặp nào, trả về 0
            console.log(0);
            return 0;
        }
    </script>


    <!-- đã xử lý được chọn 2 số thì sẽ biến mất -->


</body>

</html>
<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }

    .overlay-content {
        text-align: center;
    }

    .navigation {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .bn632-hover.bn26 {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
        position: relative;
        z-index: 4;

    }

    .bn632-hover.bn26:hover {
        background-color: #0056b3;
    }
</style>
<style>
    #wheelContainer {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        display: none;
        /* Đặt z-index lớn hơn các phần tử khác */
    }

    #wheel {
        border-radius: 50%;
        position: relative;
        z-index: 1000;
        /* Đảm bảo vòng quay nằm trên cùng */
    }

    #spinButton {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1010;
        /* Nút quay nên có z-index lớn hơn vòng quay */
        background-color: #0099ff;
        border: none;
        color: white;
        padding: 15px 30px;
        font-size: 20px;
        border-radius: 50%;
        cursor: pointer;
    }

    #pointer {
        width: 0;
        height: 0;
        border-left: 20px solid transparent;
        border-right: 20px solid transparent;
        border-bottom: 40px solid red;
        position: absolute;
        left: 70%;
        transform: rotate(272deg);
        z-index: 1020;
        /* Mũi tên chỉ định vị trí phải có z-index lớn hơn cả nút quay */
        /* top: 50%; */
    }
</style>
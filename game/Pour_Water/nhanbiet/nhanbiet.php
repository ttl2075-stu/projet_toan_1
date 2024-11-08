<?php
include "../../../ham.php";
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
    <?php include '../assets/php/head.php';
    include '../assets/php/setting.php'; ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GAME: ĐỔ NƯỚC (POUR WATER)</title>
    <link rel="stylesheet" href="../<?php echo RESET_CSS_URL; ?>" />
    <link rel="stylesheet" href="../<?php echo STYLE_CSS_PATH; ?>" />
    <link rel="stylesheet" href="../<?php echo POURING_WATER_CSS_PATH; ?>" />
    <link rel="stylesheet" href="./CssNhanbiet.css">
    <script defer src="./nhanbiet.js"></script>
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

        let colors_v1 = [];
        let k = 0;
        for (let index = 0; index < values.length; index++) {
            colors_v1.push(ma_mau[k]);
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
                ctx.fillStyle = colors_v1[i];
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
                let id_user = <?php echo $_SESSION['id_user'];
                                ?>;
                let id_phong = <?php echo $id_phong['id_phong'];
                                ?>;
                alert(`Bạn trúng: ${finalSegment}`);

                // Log kiểm tra các giá trị cần gửi
                console.log(`id_user: ${id_user}, id_phong: ${id_phong}, score: ${finalSegment}`);

                // Gửi dữ liệu qua fetch
                fetch('../../cap_nhap_diem.php', {
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
    <div class="popupCheck">
        <div class="popupCheck-win">
            <img src="../media/gold-winner.gif" alt="" class="popupCheck-img popupCheck-img-win">
            <audio src="../media/win.mp3" class="audio-win" type="audio/mp3"></audio>
        </div>
        <div class="popupCheck-lose">
            <img src="../media/lose.gif" alt="" class="popupCheck-img popupCheck-img-lose">
            <audio src="../media/OhNo.mp3" class="audio-lose" type="audio/mp3"></audio>
        </div>

    </div>
    <div class="setting-groups">
        <audio id="audio" src="../media/anpan.mp3" volume="0.2"></audio>
        <button class="bn632-hover bn26" onclick="openSetting()" style="position: absolute; z-index: 10; right: 10px; top: 10px">Cài đặt</button>
        <div class="setting">
            <div class="setting-container">
                <h2>CÀI ĐẶT</h2>
                <div class="setting-container-select">
                    <h3>Màu sắc: </h3>
                    <select name="colorSetting" id="colorSetting">
                        <option value="1">Màu sắc 1</option>
                        <option value="2">Màu sắc 2</option>
                        <option value="3">Màu sắc 3</option>
                        <option value="4">Màu sắc 4</option>
                        <option value="5">Màu sắc 5</option>
                    </select>
                </div>
                <div>
                    <button class="bn632-hover bn26 cancel" id="cancelcolor" onclick="cancelcolor()">Huỷ bỏ</button>
                    <button id="muteButton" class="bn632-hover bn26" onclick="cancelcolor()">Âm thanh</button>
                    <button class="bn632-hover bn26" id="cfmcolor" onclick="cfmcolor()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <div class="yeucau">
        <h2>Em hãy đổ vào ly nước theo số lần tương ứng trên ly</h2>
    </div>

    <nav>
        <div id="canuoc">
            <img src="../media/ca-nuoc.png" alt="" />
            <div class="waterfall">
                <div class="water">
                    <div class="fall m slow light-blue"></div>
                    <div class="fall s medium teal"></div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <?php


        $de_bai = get_de_bai($id_bai_tap);
        $debai = json_decode($de_bai['ma_tran']);
        $countDebai = count($debai);
        for ($i = 1; $i <= $countDebai; $i++) {
            $randomNaply = rand(1, 8);
            echo "
                <div class=\"warpper-ly\">
                    <img src=\"../media/nap$randomNaply.png\" alt=\"\" class=\"naply\">
                    <div class=\"ly\"></div>
                    <span>{$debai[$i - 1]}</span>
                </div>
            ";
        }
        ?>
    </main>

    <div class="action">
        <!-- <button class="bn632-hover bn26 cancel" onclick="resetGame()">Chơi lại</button> -->
        <button class="bn632-hover bn26 nop_bai" onclick="checkAnswer1()">Nộp bài</button>
    </div>

    <div class="navigation">
        <p>Câu <?php echo $current_index + 1; ?>/<?php echo count($a); ?></p>
        <?php
        if ($current_index + 1 == count($a)) {
        ?>
            <a href="" class="bn632-hover bn26">Nộp bài tất cả</a>
        <?php
        }
        ?>
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
        function checkAnswer1() {
            glassElements = [...mainElement.querySelectorAll(".warpper-ly")];

            const check = glassElements.every((ele, index) => {
                return (
                    ele.querySelectorAll(".waterr").length ==
                    ele.querySelector("span").innerHTML
                );
            });
            console.log(check);
            if (check) {
                alert("Bạn đã làm đúng")
                document.getElementById("wheelContainer").style.display = "flex";
                fetch('../../nhan_biet_gui_dl.php', {
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
                fetch('../../nhan_biet_gui_dl.php', {
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
    </script>
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
        z-index: 10;
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
        z-index: 11;
    }

    .bn632-hover.bn26:hover {
        background-color: #0056b3;
    }
</style>
<script>
    const audio = document.getElementById('audio');
    audio.volume = 0.2;
    document.getElementById('muteButton').addEventListener('click', function() {
        audio.muted = !audio.muted;
    });
    document.addEventListener('click', function() {
        audio.play();
    });
    audio.addEventListener('ended', function() {
        audio.play();
    });
</script>
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

    .nop_bai {
        position: relative;
        z-index: 2 !important;
    }
</style>
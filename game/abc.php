<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vòng quay may mắn</title>

</head>

<body>
    <a id="tro_ve" href="index.php">Trở về</a>
    <!-- begin phần thưởng -->
    <?php
    $phanThuong = [1, 9, 3, 4, 5, 6, 7, 8, 9, 11];
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
            const spinTime = 10000; // Thời gian quay là 10 giây (bạn có thể điều chỉnh tùy thuộc vào độ dài âm thanh)
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

                // Hiển thị kết quả sau khi quay và nhạc kết thúc
                alert(`Bạn trúng: ${finalSegment}`);

                // Hiển thị hiệu ứng chúc mừng
                // document.getElementById('congratulations').style.display = 'block';

                // Cập nhật spinAngle cho vòng quay tiếp theo
                spinAngle = finalSpinAngle;

                // Thêm hiệu ứng confetti (ví dụ hiệu ứng chữ xuất hiện như đang chúc mừng)
                // const celebration = document.createElement('div');
                // celebration.classList.add('celebration');
                // celebration.innerHTML = '🎉 Chúc mừng 🎉';
                // document.body.appendChild(celebration);

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
    <style>
        #wheelContainer {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #wheel {
            border-radius: 50%;
            position: relative;
        }

        #spinButton {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
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
            left: 86%;
            transform: translateX(-50%);
            z-index: 100;
            transform: rotate(272deg);
        }

        canvas {
            display: block;
        }

        #tro_ve {
            position: absolute;
            top: 30px;
            left: 100px;
        }

        /* Hiệu ứng chúc mừng */
        #congratulations {
            display: none;
            font-size: 30px;
            color: #ff6347;
            font-weight: bold;
            position: absolute;
            top: 30%;
            text-align: center;
            animation: fadeIn 2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .celebration {
            animation: confetti 3s ease-out forwards;
            position: absolute;
            top: 60%;
            font-size: 24px;
            color: gold;
        }

        @keyframes confetti {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0;
            }
        }
    </style>
    <!-- end phần thưởng -->
</body>

</html>
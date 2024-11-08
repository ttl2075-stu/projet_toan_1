-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 07, 2024 lúc 09:22 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `thi_dau_v3`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_hoc`
--

CREATE TABLE `bai_hoc` (
  `id_bai_hoc` int(5) NOT NULL,
  `ten_bai_hoc` varchar(250) NOT NULL,
  `trang_thai` int(2) NOT NULL DEFAULT 1 COMMENT '1: hiển thi\r\n0: ẩn\r\n',
  `id_chu_de` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_hoc`
--

INSERT INTO `bai_hoc` (`id_bai_hoc`, `ten_bai_hoc`, `trang_thai`, `id_chu_de`) VALUES
(1, 'Các số 0,1,2,3,4,5', 1, 1),
(2, 'Các số 6,7,8,9,10', 1, 1),
(3, 'Nhiều hơn ít hơn, bằng nhau', 0, 1),
(4, 'So sánh số', 1, 1),
(5, 'Mấy và mấy', 0, 1),
(6, 'Hình vuông, hình tròn, hình tam giác, hình chữ nhật', 0, 2),
(7, 'Thực hành lắp ghép, xếp hình', 0, 2),
(8, 'Phép cộng trong phạm vi 10', 1, 3),
(9, 'Phép trừ trong phạm vi 10', 1, 3),
(10, 'Bảng cộng, bảng trừ trong phạm vi 10', 1, 3),
(11, 'Khối lập phương, khối hộp chữ nhật', 0, 4),
(12, 'Vị trí, định hướng trong không gian', 0, 4),
(13, 'Ôn tập các số trong phạm vi 10', 0, 5),
(14, 'Ôn tâp phép cộng phép trừ trong phạm vi 10', 0, 5),
(15, 'Ôn tập hình học', 0, 5),
(16, 'Số có hai chữ số', 0, 6),
(17, 'So sánh số có hai chữ số', 0, 6),
(18, 'Bảng các số từ 1 đến 100', 0, 6),
(19, 'Dài hơn, ngắn hơn', 0, 7),
(20, 'Đơn vị đo độ dài', 0, 7),
(21, 'Thực hành ước lượng và đo độ dài', 0, 7),
(22, 'Phép cộng số có hai chữ số với số có 1 chữ số', 0, 8),
(23, 'Phép cộng số có hai chữ số với số có 2 chữ số', 0, 8),
(24, 'Phép trừ số có hai chữ số với số có 1 chữ số', 0, 8),
(25, 'Phép trừ số có hai chữ số với số có 2 chữ số', 0, 8),
(26, 'Xem giờ đúng trên đồng hồ', 0, 9),
(27, 'Các ngày trong tuần', 0, 9),
(28, 'Thực hành xem lịch và giờ', 0, 9),
(29, 'Ôn tập các số phép tính trong phạm vi 10', 0, 10),
(30, 'Ôn tập số và phép tính trong phạm vi 100', 0, 10),
(31, 'Ôn tập hình học và đo lường', 0, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bai_tap`
--

CREATE TABLE `bai_tap` (
  `id_bai_tap` int(5) NOT NULL,
  `ten_bai_tap` varchar(250) NOT NULL,
  `ma_tran` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`ma_tran`)),
  `so_can_chon` int(5) NOT NULL,
  `tong` int(5) NOT NULL,
  `hieu` int(5) NOT NULL,
  `sl_coc` int(5) NOT NULL DEFAULT 0 COMMENT '0: nhỏ,\r\n1:lớn',
  `id_loai_bt` int(5) NOT NULL,
  `id_phong` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bai_tap`
--

INSERT INTO `bai_tap` (`id_bai_tap`, `ten_bai_tap`, `ma_tran`, `so_can_chon`, `tong`, `hieu`, `sl_coc`, `id_loai_bt`, `id_phong`) VALUES
(1, 'Chọn số', '[[2,1,6],[3,3,1],[5,5,4]]', 3, 3, 3, 2, 1, 4),
(2, 'Chọn số', '[[2,1,6],[3,3,1],[5,5,4]]', 3, 3, 3, 2, 2, 4),
(3, 'Chọn số', '[1,1]', 3, 3, 3, 2, 3, 4),
(4, 'Chọn số', '[[1,0]]', 3, 3, 3, 2, 4, 4),
(7, 'Chọn số', '[[4,1],[3,2]]', 3, 3, 3, 2, 5, 4),
(8, 'Chọn số', '[7,2,8,8,3,10,1,3]', 3, 3, 3, 1, 7, 4),
(9, 'Chọn số', '[9,7,1,8,5,5,10,9,1]', 3, 3, 3, 0, 6, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bt_theo_chu_de`
--

CREATE TABLE `bt_theo_chu_de` (
  `id_bt_theo_chu_de` int(5) NOT NULL,
  `id_chu_de` int(5) NOT NULL,
  `id_loai_bt` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bt_theo_chu_de`
--

INSERT INTO `bt_theo_chu_de` (`id_bt_theo_chu_de`, `id_chu_de`, `id_loai_bt`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 8, 1),
(6, 8, 2),
(7, 9, 1),
(8, 9, 2),
(9, 19, 2),
(10, 20, 2),
(11, 21, 2),
(12, 22, 2),
(13, 1, 3),
(14, 2, 3),
(15, 8, 3),
(16, 9, 3),
(17, 1, 4),
(18, 2, 4),
(19, 8, 4),
(20, 10, 4),
(21, 22, 4),
(22, 23, 4),
(23, 1, 5),
(24, 2, 5),
(25, 9, 5),
(26, 10, 5),
(27, 24, 5),
(28, 25, 5),
(29, 4, 6),
(30, 17, 6),
(31, 4, 7),
(32, 17, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chu_de`
--

CREATE TABLE `chu_de` (
  `id_chu_de` int(5) NOT NULL,
  `ten_chu_de` varchar(250) NOT NULL,
  `trang_thai` int(2) NOT NULL DEFAULT 1 COMMENT '1: Hiện, 0: ẩn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chu_de`
--

INSERT INTO `chu_de` (`id_chu_de`, `ten_chu_de`, `trang_thai`) VALUES
(1, 'Các số từ 0 đến 10', 1),
(2, 'Làm quen với một số hình phẳng', 1),
(3, 'Phép công, phép trừ trong phạm vi 10', 1),
(4, 'Làm quen với một số hình khối', 1),
(5, 'Ôn tập học kì 1', 1),
(6, 'Các số đến 100', 1),
(7, 'Độ dài và đo độ dài', 1),
(8, 'Phép cộng, phép trừ không nhớ trong phạm vi 100', 1),
(9, 'Thời gian, giờ và lịch', 1),
(10, 'Ôn tập cuối năm', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `de_luyen_tap`
--

CREATE TABLE `de_luyen_tap` (
  `id_de_luyen_tap` int(5) NOT NULL,
  `id_luyen_tap` int(5) NOT NULL,
  `id_bai_tap` int(5) NOT NULL,
  `trang_thai` int(5) NOT NULL DEFAULT 0 COMMENT '0: chưa làm\r\n1: đã làm nhưng chưa đúng\r\n2: đã làm và đúng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `de_luyen_tap`
--

INSERT INTO `de_luyen_tap` (`id_de_luyen_tap`, `id_luyen_tap`, `id_bai_tap`, `trang_thai`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 1, 7, 0),
(6, 1, 8, 0),
(7, 1, 9, 2),
(8, 2, 1, 0),
(9, 2, 2, 0),
(10, 2, 3, 0),
(11, 2, 4, 0),
(12, 2, 7, 0),
(13, 2, 8, 0),
(14, 2, 9, 2),
(15, 3, 1, 0),
(16, 3, 2, 0),
(17, 3, 3, 0),
(18, 3, 4, 0),
(19, 3, 7, 2),
(20, 3, 8, 0),
(21, 3, 9, 0),
(22, 4, 1, 0),
(23, 4, 2, 2),
(24, 4, 3, 0),
(25, 4, 4, 0),
(26, 4, 7, 0),
(27, 4, 8, 0),
(28, 4, 9, 0),
(29, 5, 1, 0),
(30, 5, 2, 0),
(31, 5, 3, 0),
(32, 5, 4, 0),
(33, 5, 7, 0),
(34, 5, 8, 0),
(35, 5, 9, 0),
(36, 6, 1, 0),
(37, 6, 2, 2),
(38, 6, 3, 0),
(39, 6, 4, 0),
(40, 6, 7, 0),
(41, 6, 8, 0),
(42, 6, 9, 0),
(43, 7, 1, 0),
(44, 7, 2, 0),
(45, 7, 3, 0),
(46, 7, 4, 0),
(47, 7, 7, 0),
(48, 7, 8, 0),
(49, 7, 9, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_bai_bt`
--

CREATE TABLE `loai_bai_bt` (
  `id_loai_bai_bt` int(5) NOT NULL,
  `ten_loai_bt` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_bai_bt`
--

INSERT INTO `loai_bai_bt` (`id_loai_bai_bt`, `ten_loai_bt`) VALUES
(1, 'Nhận biết số từ ma trận'),
(2, 'Chọn cặp từ ma trận'),
(3, 'Nhận biết cốc'),
(4, 'Phép cộng'),
(5, 'Phép trừ'),
(6, 'So sánh (chọn số lớn)'),
(7, 'So sánh (Chọn số bé)');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luyen_tap`
--

CREATE TABLE `luyen_tap` (
  `id_luyen_tap` int(11) NOT NULL,
  `id_phong` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `thoi_gian_bat_dau` datetime NOT NULL,
  `thoi_gian_ket_thuc` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `luyen_tap`
--

INSERT INTO `luyen_tap` (`id_luyen_tap`, `id_phong`, `id_user`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`) VALUES
(1, 4, 2, '2024-11-06 11:33:00', '2024-11-06 04:33:26'),
(2, 4, 1, '2024-11-06 11:33:36', '2024-11-06 04:34:05'),
(3, 4, 3, '2024-11-06 13:35:28', '2024-11-06 06:39:37'),
(4, 4, 1, '2024-11-06 13:40:17', '2024-11-06 06:40:46'),
(5, 4, 2, '2024-11-06 13:52:31', '2024-11-06 06:52:52'),
(6, 4, 2, '2024-11-06 14:10:44', NULL),
(7, 4, 3, '2024-11-06 14:19:01', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_choi_tung_phong`
--

CREATE TABLE `nguoi_choi_tung_phong` (
  `id_nguoi_choi_tung_phong` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_phong` int(5) NOT NULL,
  `tong_diem_thuong` int(100) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_choi_tung_phong`
--

INSERT INTO `nguoi_choi_tung_phong` (`id_nguoi_choi_tung_phong`, `id_user`, `id_phong`, `tong_diem_thuong`) VALUES
(12, 2, 4, 57),
(14, 1, 4, 11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phong`
--

CREATE TABLE `phong` (
  `id_phong` int(4) NOT NULL,
  `ten_phong` varchar(255) DEFAULT NULL,
  `loai_phong` int(3) NOT NULL COMMENT '1: chơi độc lập\r\n2: chơi đối kháng\r\n3: Chơi cộng tác',
  `trang_thai` int(11) DEFAULT 1 COMMENT '1: Hiện\r\n0: ẩn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phong`
--

INSERT INTO `phong` (`id_phong`, `ten_phong`, `loai_phong`, `trang_thai`) VALUES
(4, 'Phòng 1', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test`
--

CREATE TABLE `test` (
  `id` int(3) NOT NULL,
  `nd` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('gv','hs','khach') DEFAULT 'hs',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'hs2', '1', 'hs', '2024-10-07 03:16:10'),
(2, 'hs1', '1', 'hs', '2024-10-07 13:20:43'),
(3, 'gv1', '1', 'gv', '2024-10-17 15:57:19');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  ADD PRIMARY KEY (`id_bai_hoc`);

--
-- Chỉ mục cho bảng `bai_tap`
--
ALTER TABLE `bai_tap`
  ADD PRIMARY KEY (`id_bai_tap`);

--
-- Chỉ mục cho bảng `bt_theo_chu_de`
--
ALTER TABLE `bt_theo_chu_de`
  ADD PRIMARY KEY (`id_bt_theo_chu_de`);

--
-- Chỉ mục cho bảng `chu_de`
--
ALTER TABLE `chu_de`
  ADD PRIMARY KEY (`id_chu_de`);

--
-- Chỉ mục cho bảng `de_luyen_tap`
--
ALTER TABLE `de_luyen_tap`
  ADD PRIMARY KEY (`id_de_luyen_tap`);

--
-- Chỉ mục cho bảng `loai_bai_bt`
--
ALTER TABLE `loai_bai_bt`
  ADD PRIMARY KEY (`id_loai_bai_bt`);

--
-- Chỉ mục cho bảng `luyen_tap`
--
ALTER TABLE `luyen_tap`
  ADD PRIMARY KEY (`id_luyen_tap`);

--
-- Chỉ mục cho bảng `nguoi_choi_tung_phong`
--
ALTER TABLE `nguoi_choi_tung_phong`
  ADD PRIMARY KEY (`id_nguoi_choi_tung_phong`);

--
-- Chỉ mục cho bảng `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`id_phong`);

--
-- Chỉ mục cho bảng `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bai_hoc`
--
ALTER TABLE `bai_hoc`
  MODIFY `id_bai_hoc` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `bai_tap`
--
ALTER TABLE `bai_tap`
  MODIFY `id_bai_tap` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `bt_theo_chu_de`
--
ALTER TABLE `bt_theo_chu_de`
  MODIFY `id_bt_theo_chu_de` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `chu_de`
--
ALTER TABLE `chu_de`
  MODIFY `id_chu_de` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `de_luyen_tap`
--
ALTER TABLE `de_luyen_tap`
  MODIFY `id_de_luyen_tap` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `loai_bai_bt`
--
ALTER TABLE `loai_bai_bt`
  MODIFY `id_loai_bai_bt` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `luyen_tap`
--
ALTER TABLE `luyen_tap`
  MODIFY `id_luyen_tap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `nguoi_choi_tung_phong`
--
ALTER TABLE `nguoi_choi_tung_phong`
  MODIFY `id_nguoi_choi_tung_phong` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `phong`
--
ALTER TABLE `phong`
  MODIFY `id_phong` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `test`
--
ALTER TABLE `test`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

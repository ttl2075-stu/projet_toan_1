<?php
include "../db_connect.php";

// Lấy dữ liệu từ yêu cầu POST
$trang_thai = isset($_POST['trang_thai']) ? $_POST['trang_thai'] : null;
$id_bai_tap = isset($_POST['id_bai_tap']) ? $_POST['id_bai_tap'] : null;
$id_luyen_tap = isset($_POST['id_luyen_tap']) ? $_POST['id_luyen_tap'] : null;

// Kiểm tra nếu có dữ liệu
if ($trang_thai !== null && $id_bai_tap !== null && $id_luyen_tap !== null) {
    // Cập nhật cơ sở dữ liệu
    $sql = "UPDATE `de_luyen_tap` SET `trang_thai` = ? WHERE `id_bai_tap` = ? AND `id_luyen_tap` = ?";

    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $trang_thai, $id_bai_tap, $id_luyen_tap);  // Sử dụng tham số an toàn

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
}

$conn->close();

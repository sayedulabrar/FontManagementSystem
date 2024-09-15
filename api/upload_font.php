<?php
require_once '../services/font_management.php';

$fontGroup = new FontManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $fontGroup->uploadFont($_FILES['font']);
    echo json_encode($result);
}
?>

<?php
require_once '../services/font_management.php';
// $db = new PDO('mysql:host=localhost;dbname=fontdb', 'root', '');
// $fontGroup = new FontGroup($db);

$fontGroup = new FontManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $fontId = $_POST['id'];
    $result = $fontGroup->deleteFont($fontId);
    echo json_encode($result);
    
}

?>
<?php
require_once '../services/font_management.php';
// $db = new PDO('mysql:host=localhost;dbname=fontdb', 'root', '');
// $fontGroup = new FontGroup($db);

$fontGroup = new FontManager();

$fonts = $fontGroup->getFonts();
echo json_encode($fonts);
?>

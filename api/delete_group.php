<?php

require_once '../services/group_management.php';

$fontGroup = new GroupManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupId = $_POST['id'];
    $result = $fontGroup->deleteGroup($groupId);
    echo json_encode($result);
}
?>

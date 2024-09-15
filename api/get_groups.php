<?php
require_once '../services/group_management.php';
$fontGroup = new GroupManager();

$groups = $fontGroup->getGroups();
echo json_encode($groups);
?>

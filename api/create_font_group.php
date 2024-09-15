<?php

require_once '../services/group_management.php';
require_once '../services/fontGroup_association.php';

$fontGroup = new GroupManager();
$association = new FontGroupAssociation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupName = $_POST['groupName'];
    $fontNames = $_POST['fontName'];
    $fontIds = $_POST['fontSelect'];

    // Validate that at least 2 rows are submitted
    if (count($fontIds) < 2) {
        echo json_encode(['error' => 'You must add at least 2 fonts to the group.']);
        exit;
    }

    // Create a new font group
    $groupId = $fontGroup->createFontGroup($groupName);

    if ($groupId) {
        // Insert each font into the font group items table
        for ($i = 0; $i < count($fontIds); $i++) {
            $association->addFontToGroup($groupId, $fontIds[$i],$fontNames[$i]);
        }
        echo json_encode(['success' => 'Font group created successfully']);
    } else {
        echo json_encode(['error' => 'Failed to create font group']);
    }
}
?>

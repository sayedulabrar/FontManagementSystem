<?php
require_once '../services/group_management.php';
require_once '../services/fontGroup_association.php';

$fontGroup = new GroupManager();
$association = new FontGroupAssociation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupId = $_POST['group_id'];
    $groupName = $_POST['group_name'];

    $fontNames1 = $_POST['font_names'];
    $fontIds1 = $_POST['font_ids']; // Array of font IDs selected in the edit form

    // Initialize merged arrays with existing values
    $mergedFontIds = $fontIds1;
    $mergedFontNames = $fontNames1;

    // Check if new font names and IDs are set
    if (isset($_POST['fontName']) && isset($_POST['fontSelect'])) {
        $fontNames2 = $_POST['fontName'];
        $fontIds2 = $_POST['fontSelect'];

        // Merge new font names and IDs with existing ones
        $mergedFontIds = array_merge($fontIds1, $fontIds2);
        $mergedFontNames = array_merge($fontNames1, $fontNames2);
    }

    // Update group name
    $fontGroup->updateGroupName($groupId, $groupName);

    // Update fonts associated with the group
    $association->updateGroupFonts($groupId, $mergedFontIds, $mergedFontNames);

    echo json_encode(['success' => 'Group updated successfully.']);
}

?>

<?php

require_once '../services/group_management.php';
require_once '../services/fontGroup_association.php';
require_once '../services/font_management.php';

$fontGroup = new GroupManager();
$association = new FontGroupAssociation();
$fontManagement = new FontManager();

if (isset($_GET['group_id'])) {
    $groupId = $_GET['group_id'];

    // Fetch group details and fonts associated with the group
    $group = $fontGroup->getGroup($groupId);
    $fonts = $association->getFontsForGroup($groupId);
    $allFonts = $fontManagement->getFonts(); // Fetch all fonts to populate the dropdown

    echo json_encode([
        'group' => $group,
        'fonts' => $fonts,
        'all_fonts' => $allFonts
    ]);
}
?>

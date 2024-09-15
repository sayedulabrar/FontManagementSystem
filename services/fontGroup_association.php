<?php
require_once 'database_connection.php';

class FontGroupAssociation {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }


    public function addFontToGroup($groupId, $fontId,$name) {
        $stmt = $this->db->prepare("INSERT INTO fonts_group_fonts (group_id, font_id,name) VALUES (?, ?, ?)");
        return $stmt->execute([$groupId, $fontId, $name]);
    }

    // Get fonts for a specific group
    public function getFontsForGroup($groupId) {
        $stmt = $this->db->prepare("
            SELECT f.id, f.font_name, fgf.name
            FROM fonts_group_fonts fgf
            JOIN fonts f ON f.id = fgf.font_id
            WHERE fgf.group_id = ?
        ");
        $stmt->execute([$groupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Update fonts associated with a group
public function updateGroupFonts($groupId, $fontIds, $names) {
    // First, delete existing font associations
    $stmt = $this->db->prepare("DELETE FROM fonts_group_fonts WHERE group_id = ?");
    $stmt->execute([$groupId]);

    // Insert new font associations along with names
    $stmt = $this->db->prepare("INSERT INTO fonts_group_fonts (group_id, font_id, name) VALUES (?, ?, ?)");
    
    // Assuming $fontIds and $names arrays have the same length
    for ($i = 0; $i < count($fontIds); $i++) {
        $stmt->execute([$groupId, $fontIds[$i], $names[$i]]);
    }
}

}

?>
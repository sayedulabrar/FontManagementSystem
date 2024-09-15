<?php

require_once 'database_connection.php';

class GroupManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createFontGroup($groupName) {
        $stmt = $this->db->prepare("INSERT INTO fonts_group (group_name) VALUES (?)");
        if ($stmt->execute([$groupName])) {
            return $this->db->lastInsertId(); // Return the new group's ID
        }
        return false;
    }

    public function deleteGroup($groupId) {
        $stmt = $this->db->prepare("DELETE FROM fonts_group_fonts WHERE group_id = ?");
        $stmt->execute([$groupId]);

        $stmt = $this->db->prepare("DELETE FROM fonts_group WHERE id = ?");
        if ($stmt->execute([$groupId])) {
            return ['success' => 'Group deleted successfully'];
        } else {
            return ['error' => 'Failed to delete group'];
        }
    }

    public function getGroups() {
        $stmt = $this->db->query("
            SELECT fg.id, fg.group_name, COUNT(fgf.font_id) AS font_count
            FROM fonts_group fg
            JOIN fonts_group_fonts fgf ON fg.id = fgf.group_id
            GROUP BY fg.id
        ");
        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($groups as &$group) {
            $stmt = $this->db->prepare("
                SELECT f.font_name,fgf.name
                FROM fonts_group_fonts fgf
                JOIN fonts f ON fgf.font_id = f.id
                WHERE fgf.group_id = ?
            ");
            $stmt->execute([$group['id']]);
            $group['fonts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $groups;
    }


    // Update group name
    public function updateGroupName($groupId, $groupName) {
        $stmt = $this->db->prepare("UPDATE fonts_group SET group_name = ? WHERE id = ?");
        $stmt->execute([$groupName, $groupId]);
    }

    // Get group details by ID
    public function getGroup($groupId) {
        $stmt = $this->db->prepare("SELECT * FROM fonts_group WHERE id = ?");
        $stmt->execute([$groupId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}

?>
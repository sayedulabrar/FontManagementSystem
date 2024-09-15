<?php 

require_once 'database_connection.php';

class FontManager {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function uploadFont($file) {
        $allowedExtensions = ['ttf'];
        $fileName = basename($file['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
        if (!in_array($fileExt, $allowedExtensions)) {
            return ['error' => 'Invalid file type. Only TTF files are allowed.'];
        }
    
        $relativeuploadDir = '../fonts/uploaded/';
        $uploadDir = '/fonts/uploaded/';
    
        // Check if the directory exists, if not, create it
        if (!is_dir($relativeuploadDir)) {
            mkdir($relativeuploadDir, 0777, true);
        }
    
        $relativeuploadFile = $relativeuploadDir . $fileName;
        $uploadFile = $uploadDir . $fileName;
    
        if (move_uploaded_file($file['tmp_name'], $relativeuploadFile)) {
            $stmt = $this->db->prepare("INSERT INTO fonts (font_name, font_path) VALUES (?, ?)");
            $stmt->execute([$fileName, $uploadFile]);
            return ['success' => 'Font uploaded successfully'];
        } else {
            return ['error' => 'Failed to upload font.'];
        }
    }
    

    public function deleteFont($fontId) {
        try {
            $this->db->beginTransaction();
    
            // Check if deleting this font would leave any group with only one font
            $stmt = $this->db->prepare("
                SELECT fg.id, fg.group_name, COUNT(fgf.font_id) as font_count
                FROM fonts_group fg
                JOIN fonts_group_fonts fgf ON fg.id = fgf.group_id
                WHERE fg.id IN (
                    SELECT group_id 
                    FROM fonts_group_fonts 
                    WHERE font_id = ?
                )
                GROUP BY fg.id
                HAVING COUNT(fgf.font_id) = 2
            ");
            $stmt->execute([$fontId]);
            $affectedGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if (!empty($affectedGroups)) {
                $groupNames = array_column($affectedGroups, 'group_name');
                $this->db->rollBack();
                return [
                    'error' => 'Cannot delete font. It would leave the following groups with only one font: ' . 
                               implode(', ', $groupNames)
                ];
            }
    
            // If we're here, it's safe to delete the font
            $stmt = $this->db->prepare("DELETE FROM fonts_group_fonts WHERE font_id = ?");
            $stmt->execute([$fontId]);
    
            $stmt = $this->db->prepare("DELETE FROM fonts WHERE id = ?");
            $stmt->execute([$fontId]);
    
            $this->db->commit();
            return ['success' => 'Font deleted successfully'];
        } catch (PDOException $e) {
            $this->db->rollBack();
            return ['error' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Get List of Fonts
    public function getFonts() {
        $stmt = $this->db->query("SELECT * FROM fonts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
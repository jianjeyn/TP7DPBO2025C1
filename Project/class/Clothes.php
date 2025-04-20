<?php

class Clothes {
    private $db;
    private $table_name = "clothes";

    public $id;
    public $user_id;
    public $item_name;
    public $color;
    public $image_url;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Create a new clothing item
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, item_name=:item_name, color=:color, image_url=:image_url";
        $stmt = $this->db->prepare($query);

        // Sanitize inputs
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":item_name", $this->item_name);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":image_url", $this->image_url);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function readByUser($user_id, $search = null) {
        if ($search) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id AND item_name LIKE :search ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt;
    }
      

    // Update a clothing item
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET item_name=:item_name, color=:color, image_url=:image_url WHERE id=:id";
        $stmt = $this->db->prepare($query);

        // Sanitize inputs
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));

        // Bind parameters
        $stmt->bindParam(":item_name", $this->item_name);
        $stmt->bindParam(":color", $this->color);
        $stmt->bindParam(":image_url", $this->image_url);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Delete a clothing item
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}

?>

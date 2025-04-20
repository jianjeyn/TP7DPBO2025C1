<?php

class Shoes {
    private $db;
    private $table_name = "shoes";

    public $id;
    public $user_id;
    public $item_name;
    public $color;
    public $image_url;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Create a new shoe item
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

    // Read shoes by user ID
    public function readByUser($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY item_name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt;
    }

    // Update a shoe item
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

    // Delete a shoe item
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

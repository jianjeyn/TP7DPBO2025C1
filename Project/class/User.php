<?php

class User {
    private $db;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $image_url_clothes; // Updated column for clothes image URL
    public $image_url_bottoms; // Updated column for bottoms image URL
    public $image_url_shoes;  // Updated column for shoes image URL
    public $created_at;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // Create a new user
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password,
                  image_url_clothes=:image_url_clothes, image_url_bottoms=:image_url_bottoms, image_url_shoes=:image_url_shoes";

        $stmt = $this->db->prepare($query);

        // Sanitize inputs
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);  // Secure password storage
        $this->image_url_clothes = htmlspecialchars(strip_tags($this->image_url_clothes));
        $this->image_url_bottoms = htmlspecialchars(strip_tags($this->image_url_bottoms));
        $this->image_url_shoes = htmlspecialchars(strip_tags($this->image_url_shoes));

        // Bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":image_url_clothes", $this->image_url_clothes);
        $stmt->bindParam(":image_url_bottoms", $this->image_url_bottoms);
        $stmt->bindParam(":image_url_shoes", $this->image_url_shoes);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    // Update user details (including images for clothes, bottoms, and shoes)
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET username=:username, email=:email, image_url_clothes=:image_url_clothes,
                  image_url_bottoms=:image_url_bottoms, image_url_shoes=:image_url_shoes WHERE id=:id";
        $stmt = $this->db->prepare($query);

        // Sanitize inputs
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->image_url_clothes = htmlspecialchars(strip_tags($this->image_url_clothes));
        $this->image_url_bottoms = htmlspecialchars(strip_tags($this->image_url_bottoms));
        $this->image_url_shoes = htmlspecialchars(strip_tags($this->image_url_shoes));

        // Bind parameters
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":image_url_clothes", $this->image_url_clothes);
        $stmt->bindParam(":image_url_bottoms", $this->image_url_bottoms);
        $stmt->bindParam(":image_url_shoes", $this->image_url_shoes);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readAllUsersWithWardrobe() {
        $query = "
            SELECT 
                u.id, u.username,
    
                (SELECT c.item_name FROM clothes c WHERE c.user_id = u.id ORDER BY c.id DESC LIMIT 1) AS clothes_name,
                (SELECT b.item_name FROM bottoms b WHERE b.user_id = u.id ORDER BY b.id DESC LIMIT 1) AS bottoms_name,
                (SELECT s.item_name FROM shoes s WHERE s.user_id = u.id ORDER BY s.id DESC LIMIT 1) AS shoes_name
    
            FROM users u
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
}
?>

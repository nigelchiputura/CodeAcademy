<?php

declare(strict_types=1);

class UserManager {
    private object $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;        
    }

    public function getUserByEmail(string $email) 
    {
        $query = "SELECT * FROM users WHERE email=:email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getUserByUsername(string $username) 
    {
        $query = "SELECT * FROM users WHERE username=:username";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getUserByPhone(string $phone) 
    {
        $query = "SELECT * FROM users WHERE phone=:phone";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":phone", $phone);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getUserById(int $id)
    {
        $query = "SELECT * FROM users WHERE user_id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getUsersByRole(string $role) 
    {
        $query = "SELECT * FROM users WHERE role=:role";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getUsersByName(string $searchQuery) 
    {
        $query = "SELECT * FROM users WHERE full_name LIKE :searchQuery";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":searchQuery", $searchQuery);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getAllUsers() 
    {
        $query = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updatePassword(int $id, string $newPassword) 
    {
        $query = "UPDATE users SET password = :password WHERE user_id = :id";
        $stmt = $this->pdo->prepare($query);

        $options = [
            'cost' => 12
        ];
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, $options);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->execute();
    }
    
    public function deleteUser(int $id) 
    {
        $query = "DELETE FROM users WHERE user_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function deleteUsers(array $user_ids)
    {
        $placeholders = implode(',', array_fill(0, count($user_ids), '?'));

        $query = "DELETE FROM users WHERE user_id IN ($placeholders)";
        $stmt = $this->pdo->prepare($query);
        // $stmt->bindParam(":user_ids", $user_ids);
        $stmt->execute($user_ids);
    }

    public function createUser(
        string $username,
        string $password,
        string $role,
        string $phone,
        string $fullName,
        string|null $email=null
        )
    {
        $query = "INSERT INTO users (username, password, role, email, phone, full_name) 
        VALUES (:username, :password, :role, :email, :phone, :full_name)";
        $stmt = $this->pdo->prepare($query);

        $options = [
            'cost' => 12
        ];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":full_name", $fullName);
        $stmt->execute();
    }
    
    public function updateUserInfo(
        int $id,
        string $username, 
        string $role, 
        string $phone, 
        string $fullName, 
        string|null $email=null
        )
    {
        $query = "UPDATE users SET 
            username=:username, 
            role=:role, 
            email=:email, 
            phone=:phone, 
            full_name=:full_name 
        WHERE user_id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":full_name", $fullName);
        $stmt->execute();
    }

    public function updateLastLogin(int $id) 
    {
        $query = "UPDATE users SET last_login=NOW() WHERE user_id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}
<?php
/**
 * Modèle User - Gestion des utilisateurs
 */
class User {
    private $db;
    private $table = 'users';

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Nettoyage XSS des entrées
    private function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    // Validation du username avec regex
    private function validateUsername($username) {
        return preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username);
    }

    // Validation du mot de passe avec regex
    private function validatePassword($password) {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
    }

    // Vérifier si un username existe
    public function usernameExists($username) {
        $query = "SELECT id FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Créer un nouvel utilisateur
    public function create($username, $password) {
        $username = $this->sanitize($username);
        if (!$this->validateUsername($username)) {
            return [
                'success' => false,
                'message' => 'Le nom d\'utilisateur doit contenir entre 3 et 20 caractères (lettres, chiffres, _ ou -)'
            ];
        }

        if (!$this->validatePassword($password)) {
            return [
                'success' => false,
                'message' => 'Le mot de passe doit contenir au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial'
            ];
        }

        if ($this->usernameExists($username)) {
            return [
                'success' => false,
                'message' => 'Ce nom d\'utilisateur existe déjà'
            ];
        }

        // Cryptage avec Argon2id
        if (defined('PASSWORD_ARGON2ID')) {
            $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        }

        $query = "INSERT INTO {$this->table} (username, password, created_at) 
                  VALUES (:username, :password, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Compte créé avec succès'
            ];
        }
        return [
            'success' => false,
            'message' => 'Erreur lors de la création du compte'
        ];
    }

    // Authentifier un utilisateur
    public function authenticate($username, $password) {
        $username = $this->sanitize($username);

        $query = "SELECT id, username, password FROM {$this->table} 
                  WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return [
                'success' => false,
                'message' => 'Identifiant ou mot de passe incorrect'
            ];
        }

        $user = $stmt->fetch();

        // Vérification du mot de passe crypté
        if (password_verify($password, $user['password'])) {
            // Mettre à jour la date de dernière connexion
            $this->updateLastLogin($user['id']);
            return [
                'success' => true,
                'message' => 'Connexion réussie',
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username']
                ]
            ];
        }
        return [
            'success' => false,
            'message' => 'Identifiant ou mot de passe incorrect'
        ];
    }

    // Mettre à jour la date de dernière connexion
    private function updateLastLogin($userId) {
        $query = "UPDATE {$this->table} SET last_login = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Récupération d'un utilisateur par ID
    public function getById($id) {
        $query = "SELECT id, username, created_at, last_login 
                  FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch();
        }
        return null;
    }

    // Comptage du nombre d'utilisateurs dans la base de données
    public function count() {
        $query = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
}

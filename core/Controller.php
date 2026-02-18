<?php
/**
 * Classe Controller - Tous les contrôleurs héritent de cette classe
 */
class Controller {

    // Chargement d'un modèle
    protected function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    // Chargement d'une vue
    protected function view($view, $data = []) {
        extract($data);

        // Vérification si la vue existe
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            die('La vue n\'existe pas : ' . $view);
        }
    }

    protected function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit();
    }

    // Vérification si l'utilisateur est connecté
    protected function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    protected function requireAuth() {
        if (!$this->isLoggedIn() || !$this->verifyFingerprint()) {
            // Si l'empreinte ne correspond pas, on déconnecte de force
            if ($this->isLoggedIn() && !$this->verifyFingerprint()) {
                session_unset();
                session_destroy();
                session_start();
            }
            $_SESSION['error'] = 'Session invalide ou expirée. Veuillez vous reconnecter.';
            $this->redirect('auth/login');
        }
    }

    // Vérification du token CSRF
    protected function verifyCsrfToken() {
        if (!isset($_POST['csrf_token']) || 
            !isset($_SESSION['csrf_token']) || 
            !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            return false;
        }
        return true;
    }

    // Génération du token CSRF
    protected function generateCsrfToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // Génération d'une empreinte de session (Fingerprint)
    protected function generateFingerprint() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        return hash('sha256', $userAgent . $ip . 'SALT_SECRET_SECURE');
    }

    // Vérification de l'empreinte de session
    protected function verifyFingerprint() {
        if (!isset($_SESSION['fingerprint'])) {
            return false;
        }
        return hash_equals($_SESSION['fingerprint'], $this->generateFingerprint());
    }
}

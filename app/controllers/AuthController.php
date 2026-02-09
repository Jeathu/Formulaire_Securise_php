<?php
/**
 * AuthController - Gestion de l'authentification
 * Login, Register, Logout
 */
class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    // Page de connexion par défaut
    public function index() {
        $this->login();
    }

    // Affichage du formulaire de connexion
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        } else {
            $data = [
                'title' => 'Connexion',
                'csrf_token' => $this->generateCsrfToken()
            ];
            $this->view('auth/login', $data);
        }
    }

    //Traitement de la connexion
    private function processLogin() {
        // Vérification du token CSRF
        if (!$this->verifyCsrfToken()) {
            $_SESSION['error'] = 'Erreur de sécurité. Veuillez réessayer.';
            $this->redirect('auth/login');
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $result = $this->userModel->authenticate($username, $password);

        if ($result['success']) {
            // Régénérer ID de session
            session_regenerate_id(true);

            // Création de la session
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['username'] = $result['user']['username'];
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();
            $_SESSION['success'] = $result['message'];
            $this->redirect('dashboard');
        } else {
            $_SESSION['error'] = $result['message'];
            $this->redirect('auth/login');
        }
    }

    // Affichage du formulaire d'inscription
    public function showRegister() {
        if ($this->isLoggedIn()) {
            $this->redirect('dashboard');
        }

        $data = [
            'title' => 'Inscription',
            'csrf_token' => $this->generateCsrfToken()
        ];
        $this->view('auth/register', $data);
    }

    // Traitement de l'inscription
    public function register() {
        // Vérification du token CSRF
        if (!$this->verifyCsrfToken()) {
            $_SESSION['error'] = 'Erreur de sécurité. Veuillez réessayer.';
            $this->redirect('auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Création de l'utilisateur
            $result = $this->userModel->create($username, $password);
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }
        }
        $this->redirect('auth/login');
    }

    // Déconnexion
    public function logout() {
        // Détruction de la session
        session_unset();
        session_destroy();

        // Redémarrer une nouvelle session
        session_start();
        $_SESSION['success'] = 'Vous avez été déconnecté avec succès';
        $this->redirect('auth/login');
    }
}

<?php
/**
 * DashboardController - Gestion du tableau de bord
 */
class DashboardController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    // Page accueil dashboard
    public function index() {
        $this->requireAuth();

        // Informations utilisateur
        $user = $this->userModel->getById($_SESSION['user_id']);

        // Statistiques
        $stats = [
            'total_users' => $this->userModel->count(),
            'session_timeout' => SESSION_TIMEOUT / 60,
            'username' => $_SESSION['username']
        ];

        $data = [
            'title' => 'Dashboard',
            'user' => $user,
            'stats' => $stats
        ];
        $this->view('dashboard/index', $data);
    }
}

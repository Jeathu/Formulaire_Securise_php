<?php
/**
 * Classe App - Gère le routing et l'instanciation des contrôleurs
 */
class App {
    protected $controller = 'AuthController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Vérification si le contrôleur existe
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        // Chargement du contrôleur
        if (!file_exists('app/controllers/' . $this->controller . '.php')) {
            die("Erreur: Le contrôleur '{$this->controller}' n'existe pas.");
        }
        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Vérification de la méthode
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // Parse l'URL et retourne un tableau
    private function parseUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_SPECIAL_CHARS);
            return explode('/', $url);
        }
        return [];
    }
}

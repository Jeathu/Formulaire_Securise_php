<?php


require_once 'config/config.php';


$isLogo = strpos($_GET['file'] ?? '', 'logo/') === 0;

if (!$isLogo && (!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)) {
    http_response_code(403);
    header('Content-Type: text/plain');
    die('Accès interdit : Vous devez être connecté pour voir cette image.');
}

$fileParam = $_GET['file'] ?? '';

// Empêcher la remontée de répertoire 
$cleanPath = str_replace(['..', './'], '', $fileParam);
$cleanPath = ltrim($cleanPath, '/\\');

// Chemin complet vers le dossier image
$baseDir = __DIR__ . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR;
$filePath = realpath($baseDir . $cleanPath);

// Vérifier que le fichier existe et qu'il est bien à l'intérieur du dossier image
if (!$filePath || !file_exists($filePath) || is_dir($filePath) || strpos($filePath, $baseDir) !== 0) {
    http_response_code(404);
    header('Content-Type: text/plain');
    die('Image introuvable.');
}

// Déterminer le type MIME
$extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
$mimeTypes = [
    'png'  => 'image/png',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
    'svg'  => 'image/svg+xml'
];

$mime = $mimeTypes[$extension] ?? 'application/octet-stream';

// Envoyer les headers et le contenu
header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: private, max-age=86400'); 

readfile($filePath);
exit;

<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? APP_NAME; ?> - <?php echo APP_NAME; ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DaisyUI (A8 - Integrity Failures) -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet" type="text/css" crossorigin="anonymous" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <main>
        <?php echo $content; ?>
    </main>
    <footer class="footer footer-center p-4 bg-base-300 text-base-content mt-auto">
        <div>
            <p><?php echo APP_NAME; ?> -  Ce travail effectué par Jeathusan KUGATHAS (étudiant en M1 IBD à Paris 8)</p>
        </div>
    </footer>
</body>
</html>

<?php ob_start(); ?>

<!-- Navbar -->
<div class="navbar bg-base-100 shadow-lg">
    <div class="flex-1">
        <a href="<?php echo BASE_URL; ?>dashboard" class="btn btn-ghost normal-case text-xl">
            <span class="text-2xl">🔒</span>
            <?php echo APP_NAME; ?>
        </a>
    </div>
    <div class="flex-none gap-2">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                <div class="bg-primary text-primary-content rounded-full w-10">
                    <span class="text-xl"><?php echo strtoupper(substr($stats['username'], 0, 1)); ?></span>
                </div>
            </label>
            <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                <li class="menu-title">
                    <span>Connecté en tant que:</span>
                </li>
                <li><a class="font-bold"><?php echo htmlspecialchars($stats['username'], ENT_QUOTES, 'UTF-8'); ?></a></li>
                <li><a href="<?php echo BASE_URL; ?>auth/logout" class="text-error">Déconnexion</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Contenu principal -->
<div class="container mx-auto px-4 py-8">

    <!-- Messages Flash -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success shadow-lg mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="font-bold">Vous êtes connecté !</h3>
                <div class="text-sm">Bienvenue <strong><?php echo htmlspecialchars($stats['username'], ENT_QUOTES, 'UTF-8'); ?></strong>, votre session est sécurisée.</div>
            </div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Statistiques -->
    <div class="stats shadow w-full mb-8 flex flex-wrap">
        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div class="stat-title">Statut de sécurité</div>
            <div class="stat-value text-success">Protégé</div>
            <div class="stat-desc">Architecture MVC sécurisée</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
            </div>
            <div class="stat-title">Session</div>
            <div class="stat-value text-primary">Active</div>
            <div class="stat-desc">Timeout: <?php echo $stats['session_timeout']; ?> minutes</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="stat-title">Utilisateurs</div>
            <div class="stat-value text-secondary"><?php echo $stats['total_users']; ?></div>
            <div class="stat-desc">Comptes enregistrés</div>
        </div>
    </div>

    <!-- Grille d'informations -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Informations utilisateur -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">
                    <span class="text-3xl">👤</span>
                    Informations
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span class="font-semibold">Identifiant:</span>
                        <span class="badge badge-primary badge-lg"><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span class="font-semibold">ID Utilisateur:</span>
                        <span class="badge badge-secondary">#<?php echo $user['id']; ?></span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span class="font-semibold">Créé le:</span>
                        <span><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></span>
                    </div>
                    <?php if ($user['last_login']): ?>
                    <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                        <span class="font-semibold">Dernière connexion:</span>
                        <span><?php echo date('d/m/Y H:i', strtotime($user['last_login'])); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Protections actives -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">
                    <span class="text-3xl">🛡️</span>
                    Protections MVC
                </h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2 mt-1">✓</span>
                        <div>
                            <strong>Architecture MVC</strong>
                            <p class="text-sm text-gray-600">Modèle-Vue-Contrôleur avec séparation des responsabilités</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2 mt-1">✓</span>
                        <div>
                            <strong>Protection XSS</strong>
                            <p class="text-sm text-gray-600">htmlspecialchars() sur toutes les entrées</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2 mt-1">✓</span>
                        <div>
                            <strong>Protection SQL Injection</strong>
                            <p class="text-sm text-gray-600">PDO avec requêtes préparées</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2 mt-1">✓</span>
                        <div>
                            <strong>Protection CSRF</strong>
                            <p class="text-sm text-gray-600">Tokens CSRF sur tous les formulaires</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2 mt-1">✓</span>
                        <div>
                            <strong>Cryptage Argon2id</strong>
                            <p class="text-sm text-gray-600">Algorithme de hachage sécurisé</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="text-green-500 mr-2 mt-1">✓</span>
                        <div>
                            <strong>Validation Regex</strong>
                            <p class="text-sm text-gray-600">Patterns stricts username/password</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Structure MVC -->
        <div class="card bg-base-100 shadow-xl md:col-span-2">
            <div class="card-body">
                <h2 class="card-title text-2xl mb-4">
                    <span class="text-3xl">⚙️</span>
                    Architecture MVC
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="alert alert-info">
                        <div class="text-sm">
                            <strong>MODEL</strong>
                            <p class="mt-1">User.php - Logique métier et accès aux données</p>
                        </div>
                    </div>
                    <div class="alert alert-success">
                        <div class="text-sm">
                            <strong>VIEW</strong>
                            <p class="mt-1">login.php, dashboard/index.php - Présentation</p>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <div class="text-sm">
                            <strong>CONTROLLER</strong>
                            <p class="mt-1">AuthController, DashboardController - Logique</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="font-bold mb-2">CORE Framework:</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="badge badge-neutral">App.php - Router</span>
                        <span class="badge badge-neutral">Controller.php - Base</span>
                        <span class="badge badge-neutral">Database.php - PDO Singleton</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton de déconnexion -->
    <div class="text-center mt-8">
        <a href="<?php echo BASE_URL; ?>auth/logout" class="btn btn-error btn-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Se déconnecter
        </a>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>


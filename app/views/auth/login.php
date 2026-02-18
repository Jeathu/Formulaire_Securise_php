<?php ob_start(); ?>

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl">
        <div class="card-body">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="avatar">
                    <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2 overflow-hidden bg-white">
                        <img src="<?php echo BASE_URL; ?>image.php?file=logo/Logo-image.jpg" alt="Logo" class="object-cover" />
                    </div>
                </div>
            </div>

            <h2 class="card-title justify-center text-3xl font-bold mb-2">Connexion</h2>

            <!-- Messages Flash -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span><?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Formulaire de connexion -->
            <form method="POST" action="<?php echo BASE_URL; ?>auth/login">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                <!-- Identifiant -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Identifiant</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="Votre identifiant" 
                        class="input input-bordered w-full" 
                        required
                        autocomplete="username"
                        maxlength="20"
                    />
                </div>

                <!-- Mot de passe -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Mot de passe</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Votre mot de passe" 
                        class="input input-bordered w-full" 
                        autocomplete="current-password"
                    />
                </div>

                <!-- Anti-bot Honeypot -->
                <div style="display:none !important;" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <!-- Boutons -->
                <div class="form-control mb-4">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Valider
                    </button>
                </div>

                <div class="divider">OU</div>

                <div class="grid grid-cols-2 gap-2">
                    <button type="reset" class="btn btn-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </button>
                    <a href="<?php echo BASE_URL; ?>auth/showRegister" class="btn btn-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Ajout compte
                    </a>
                </div>
            </form>

            <div class="mt-6 text-xs text-gray-500 text-center">
                <p class="mb-2">🔒Protection XSS, SQL Injection, CSRF</p>
                <p>🔐 Mots de passe cryptés avec Argon2id </p>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>

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

            <h2 class="card-title justify-center text-3xl font-bold mb-2">Créer un compte</h2>
            <p class="text-center text-gray-600 mb-6">Inscription sécurisée</p>

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

            <!-- Formulaire d'inscription -->
            <form method="POST" action="<?php echo BASE_URL; ?>auth/register">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                <!-- Identifiant -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Identifiant</span>
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="3-20 caractères (a-z, 0-9, _, -)" 
                        class="input input-bordered w-full" 
                        required
                        pattern="[a-zA-Z0-9_-]{3,20}"
                        title="3-20 caractères: lettres, chiffres, _ ou -"
                        maxlength="20"
                    />
                    <label class="label">
                        <span class="label-text-alt text-gray-500">Lettres, chiffres, underscore ou tiret uniquement</span>
                    </label>
                </div>

                <!-- Mot de passe -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Mot de passe</span>
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Minimum 8 caractères sécurisés" 
                        class="input input-bordered w-full" 
                        required
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                        title="Min. 8 caractères: 1 majuscule, 1 minuscule, 1 chiffre, 1 spécial"
                    />
                    <label class="label">
                        <span class="label-text-alt text-gray-500">1 majuscule, 1 minuscule, 1 chiffre, 1 spécial (@$!%*?&)</span>
                    </label>
                </div>

                <!-- Anti-bot Honeypot -->
                <div style="display:none !important;" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <!-- Boutons -->
                <div class="form-control mb-4">
                    <button type="submit" class="btn btn-primary w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Créer le compte
                    </button>
                </div>

                <div class="divider">OU</div>

                <div class="text-center">
                    <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-outline btn-wide">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la connexion
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>

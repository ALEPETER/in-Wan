<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IN WAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        primaryLight: '#3b82f6',
                        success: '#10b981',
                        warning: '#f97316',
                        danger: '#ef4444',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-900 to-primary min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <!-- Logo -->
            <div class="text-center mb-6">
               <img src="assets/images/logo.jpg" alt="IN WAN" class="h-20 mx-auto">
            </div>
            
            <h1 class="text-2xl font-bold text-center text-primary">IN WAN</h1>
            <p class="text-center text-gray-500 mb-6">Gestion des incidents</p>
            
           <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
    <div class="bg-red-50 text-danger p-3 rounded-xl mb-4 text-sm border-l-4 border-danger">
        ❌ Email ou mot de passe incorrect
    </div>
<?php endif; ?>
            
            <form action="login.php" method="POST" autocomplete="off">
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" required autocomplete="off"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Mot de passe</label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                </div>
                
                <button type="submit" 
                        class="w-full bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primaryLight transition transform hover:-translate-y-0.5">
                    Se connecter
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="inscription.php" class="text-primary text-sm hover:underline">Créer un compte</a>
            </div>
            
            <div class="mt-6 p-3 bg-gray-50 rounded-xl text-xs text-gray-500 text-center">
                <p class="font-semibold">Comptes de test :</p>
                <p>jean@agent.inwan.cd / 123456</p>
            </div>
        </div>
    </div>
</body>
</html>
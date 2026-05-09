<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_complet = trim($_POST['nom_complet']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirm = $_POST['confirm_mot_de_passe'];
    
    if(empty($nom_complet) || empty($email) || empty($mot_de_passe)) {
        $error = "Tous les champs sont obligatoires";
    } elseif($mot_de_passe != $confirm) {
        $error = "Les mots de passe ne correspondent pas";
    } else {
        $role = '';
        if(strpos($email, '@agent.inwan.cd') !== false) $role = 'agent';
        elseif(strpos($email, '@chef.inwan.cd') !== false) $role = 'chef_equipe';
        elseif(strpos($email, '@superviseur.inwan.cd') !== false) $role = 'superviseur';
        elseif(strpos($email, '@manager.inwan.cd') !== false) $role = 'manager';
        elseif(strpos($email, '@technicien.inwan.cd') !== false) $role = 'technicien';
        else $error = "Email non valide. Utilisez @agent.inwan.cd, @chef.inwan.cd, etc.";
        
        if($role && !$error) {
            $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if($stmt->fetch()) {
                $error = "Cet email est déjà utilisé";
            } else {
                $hashed = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO utilisateurs (nom_complet, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
                if($stmt->execute([$nom_complet, $email, $hashed, $role])) {
                    $success = "Compte créé avec succès ! Vous pouvez vous connecter.";
                } else {
                    $error = "Erreur lors de la création du compte";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - IN WAN</title>
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
            <div class="text-center mb-4">
                <img src="assets/images/logo.jpg" alt="IN WAN" class="h-14 mx-auto">
            </div>
            <h1 class="text-xl font-bold text-center text-primary">IN WAN</h1>
            <p class="text-center text-gray-500 text-sm mb-5">Gestion des incidents</p>
            
            <?php if($error): ?>
                <div class="bg-red-50 text-danger p-3 rounded-xl mb-4 text-sm border-l-4 border-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="bg-green-50 text-success p-3 rounded-xl mb-4 text-sm border-l-4 border-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="block text-gray-700 font-semibold text-sm mb-1">Nom complet</label>
                    <input type="text" name="nom_complet" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary">
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 font-semibold text-sm mb-1">Email professionnel</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary">
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700 font-semibold text-sm mb-1">Mot de passe</label>
                    <input type="password" name="mot_de_passe" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold text-sm mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="confirm_mot_de_passe" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:border-primary">
                </div>
                <button type="submit" class="w-full bg-primary text-white font-semibold py-2 rounded-xl hover:bg-primaryLight transition">Créer mon compte</button>
            </form>
            
            <div class="mt-4 text-center text-sm">
                <span class="text-gray-500">Déjà un compte ?</span>
                <a href="index.php" class="text-primary font-semibold hover:underline">Se connecter</a>
            </div>
            
            <div class="mt-4 p-3 bg-gray-50 rounded-xl text-xs text-gray-500">
                <p class="font-semibold mb-1">📧 Format d'email selon votre poste :</p>
                <p>• Agent : <strong>@agent.inwan.cd</strong></p>
                <p>• Chef d'équipe : <strong>@chef.inwan.cd</strong></p>
                <p>• Superviseur : <strong>@superviseur.inwan.cd</strong></p>
                <p>• Manager : <strong>@manager.inwan.cd</strong></p>
                <p>• Technicien : <strong>@technicien.inwan.cd</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
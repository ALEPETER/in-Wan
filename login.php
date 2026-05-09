<?php
session_start();
require_once 'config/database.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    // Vérification du mot de passe
    if($user && $password == $user['mot_de_passe']) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom_complet'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        
        // Redirection selon le rôle
        switch($user['role']) {
            case 'agent':
                header('Location: agent/dashboard.php');
                break;
            case 'chef_equipe':
                header('Location: chef-equipe/dashboard.php');
                break;
            case 'superviseur':
                header('Location: superviseur/dashboard.php');
                break;
            case 'manager':
                header('Location: manager/dashboard.php');
                break;
            case 'technicien':
                header('Location: technicien/dashboard.php');
                break;
            default:
                header('Location: index.php?error=1');
        }
        exit();
    } else {
        // Connexion échouée
        header('Location: index.php?error=1');
        exit();
    }
} else {
    // Si quelqu'un essaie d'accéder directement à login.php
    header('Location: index.php');
    exit();
}
?>
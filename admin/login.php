<?php
session_start();
require_once '../database/Database.php';

$error = '';

if ($_POST) {
    $password = $_POST['password'] ?? '';
    
    if (empty($password)) {
        $error = 'Digite a senha';
    } else {
        $db = Database::getInstance();
        if ($db->verificarLogin($password)) {
            $_SESSION['admin_logged'] = true;
            header('Location: index.php');
            exit;
        } else {
            $error = 'Senha incorreta';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mivora Digital</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #09090B;
            color: #FFFFFF;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: #1A1A1A;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #27272A;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
        }
        
        .logo h1 {
            margin-top: 15px;
            background: linear-gradient(135deg, #8C52FF 0%, #A855F7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 24px;
            font-weight: 700;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #A1A1AA;
            font-weight: 500;
        }
        
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            background: #0F0F0F;
            border: 1px solid #27272A;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        input[type="password"]:focus {
            outline: none;
            border-color: #8C52FF;
            box-shadow: 0 0 0 3px rgba(140, 82, 255, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #8C52FF 0%, #A855F7 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(140, 82, 255, 0.3);
        }
        
        .error {
            background: #DC2626;
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .info {
            text-align: center;
            margin-top: 20px;
            color: #A1A1AA;
            font-size: 14px;
        }
        
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="../assets/logo.png" alt="Mivora Digital">
            <h1>Painel Admin</h1>
        </div>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="password">Senha do Administrador</label>
                <input type="password" id="password" name="password" required autofocus>
            </div>
            
            <button type="submit" class="btn-login">Entrar no Painel</button>
        </form>
        
        <div class="info">
            <p>Acesso restrito ao administrador</p>
            <p><strong>Senha padrão:</strong> admin123</p>
        </div>
    </div>
</body>
</html>

<?php
session_start();

// Verificar se está logado
if (!isset($_SESSION['admin_logged']) || !$_SESSION['admin_logged']) {
    header('Location: login.php');
    exit;
}

require_once '../database/Database.php';
$db = Database::getInstance();

$message = '';
$error = '';

// Processar ações
if ($_POST) {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'update_plano':
            $id = $_POST['id'];
            $dados = [
                'nome' => $_POST['nome'],
                'preco_original' => floatval($_POST['preco_original']),
                'preco_promocional' => floatval($_POST['preco_promocional']),
                'descricao' => $_POST['descricao'],
                'recursos' => $_POST['recursos'],
                'manutencao_preco' => floatval($_POST['manutencao_preco'])
            ];
            
            if ($db->updatePlano($id, $dados)) {
                $message = 'Plano atualizado com sucesso!';
            } else {
                $error = 'Erro ao atualizar plano.';
            }
            break;
            
        case 'update_config':
            $configs = [
                'whatsapp_url' => $_POST['whatsapp_url'],
                'instagram_url' => $_POST['instagram_url'],
                'site_title' => $_POST['site_title']
            ];
            
            foreach ($configs as $chave => $valor) {
                $db->setConfig($chave, $valor);
            }
            
            $message = 'Configurações atualizadas com sucesso!';
            break;
    }
}

// Buscar dados
$planos = $db->getPlanos();
$whatsapp_url = $db->getConfig('whatsapp_url');
$instagram_url = $db->getConfig('instagram_url');
$site_title = $db->getConfig('site_title');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Mivora Digital</title>
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
            line-height: 1.6;
        }
        
        .header {
            background: #1A1A1A;
            border-bottom: 1px solid #27272A;
            padding: 20px 0;
        }
        
        .header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }
        
        .logo h1 {
            background: linear-gradient(135deg, #8C52FF 0%, #A855F7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 20px;
            font-weight: 700;
        }
        
        .logout {
            color: #A1A1AA;
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #27272A;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .logout:hover {
            color: #FFFFFF;
            border-color: #8C52FF;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert.success {
            background: #059669;
            color: white;
        }
        
        .alert.error {
            background: #DC2626;
            color: white;
        }
        
        .section {
            background: #1A1A1A;
            border: 1px solid #27272A;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #8C52FF;
            margin-bottom: 20px;
            font-size: 24px;
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
        
        input, textarea, select {
            width: 100%;
            padding: 12px 16px;
            background: #0F0F0F;
            border: 1px solid #27272A;
            border-radius: 8px;
            color: #FFFFFF;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #8C52FF;
            box-shadow: 0 0 0 3px rgba(140, 82, 255, 0.1);
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #8C52FF 0%, #A855F7 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(140, 82, 255, 0.3);
        }
        
        .plano-card {
            background: #0F0F0F;
            border: 1px solid #27272A;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .plano-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .plano-title {
            font-size: 18px;
            font-weight: 600;
            color: #FFFFFF;
        }
        
        .plano-prices {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .price-original {
            text-decoration: line-through;
            color: #A1A1AA;
        }
        
        .price-promo {
            color: #8C52FF;
            font-weight: 600;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #1A1A1A;
            border: 1px solid #27272A;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #8C52FF;
        }
        
        .stat-label {
            color: #A1A1AA;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .header .container {
                flex-direction: column;
                gap: 15px;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            .section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="../assets/logo.png" alt="Mivora Digital">
                <h1>Painel Administrativo</h1>
            </div>
            <a href="logout.php" class="logout">Sair</a>
        </div>
    </header>
    
    <div class="container">
        <?php if ($message): ?>
            <div class="alert success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <!-- Estatísticas -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($planos) ?></div>
                <div class="stat-label">Planos Ativos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Funcionando</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Online</div>
            </div>
        </div>
        
        <!-- Configurações Gerais -->
        <div class="section">
            <h2>Configurações Gerais</h2>
            <form method="POST">
                <input type="hidden" name="action" value="update_config">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="site_title">Título do Site</label>
                        <input type="text" id="site_title" name="site_title" value="<?= htmlspecialchars($site_title) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="whatsapp_url">URL do WhatsApp</label>
                        <input type="url" id="whatsapp_url" name="whatsapp_url" value="<?= htmlspecialchars($whatsapp_url) ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="instagram_url">URL do Instagram</label>
                    <input type="url" id="instagram_url" name="instagram_url" value="<?= htmlspecialchars($instagram_url) ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar Configurações</button>
            </form>
        </div>
        
        <!-- Gerenciar Planos -->
        <div class="section">
            <h2>Gerenciar Planos</h2>
            
            <?php foreach ($planos as $plano): ?>
                <div class="plano-card">
                    <form method="POST">
                        <input type="hidden" name="action" value="update_plano">
                        <input type="hidden" name="id" value="<?= $plano['id'] ?>">
                        
                        <div class="plano-header">
                            <div class="plano-title"><?= htmlspecialchars($plano['nome']) ?></div>
                            <div class="plano-prices">
                                <span class="price-original">R$ <?= number_format($plano['preco_original'], 2, ',', '.') ?></span>
                                <span class="price-promo">R$ <?= number_format($plano['preco_promocional'], 2, ',', '.') ?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nome_<?= $plano['id'] ?>">Nome do Plano</label>
                            <input type="text" id="nome_<?= $plano['id'] ?>" name="nome" value="<?= htmlspecialchars($plano['nome']) ?>" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="preco_original_<?= $plano['id'] ?>">Preço Original (R$)</label>
                                <input type="number" step="0.01" id="preco_original_<?= $plano['id'] ?>" name="preco_original" value="<?= $plano['preco_original'] ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="preco_promocional_<?= $plano['id'] ?>">Preço Promocional (R$)</label>
                                <input type="number" step="0.01" id="preco_promocional_<?= $plano['id'] ?>" name="preco_promocional" value="<?= $plano['preco_promocional'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="descricao_<?= $plano['id'] ?>">Descrição</label>
                            <textarea id="descricao_<?= $plano['id'] ?>" name="descricao" required><?= htmlspecialchars($plano['descricao']) ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="recursos_<?= $plano['id'] ?>">Recursos (separados por |)</label>
                            <textarea id="recursos_<?= $plano['id'] ?>" name="recursos" required><?= htmlspecialchars($plano['recursos']) ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="manutencao_preco_<?= $plano['id'] ?>">Preço Manutenção (R$)</label>
                            <input type="number" step="0.01" id="manutencao_preco_<?= $plano['id'] ?>" name="manutencao_preco" value="<?= $plano['manutencao_preco'] ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Atualizar Plano</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
        // Auto-save em tempo real (opcional)
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Painel administrativo carregado com sucesso!');
            
            // Adicionar confirmação antes de sair
            window.addEventListener('beforeunload', function(e) {
                // Verificar se há mudanças não salvas
                const forms = document.querySelectorAll('form');
                let hasChanges = false;
                
                forms.forEach(form => {
                    const inputs = form.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        if (input.defaultValue !== input.value) {
                            hasChanges = true;
                        }
                    });
                });
                
                if (hasChanges) {
                    e.preventDefault();
                    e.returnValue = 'Você tem alterações não salvas. Deseja realmente sair?';
                }
            });
        });
    </script>
</body>
</html>

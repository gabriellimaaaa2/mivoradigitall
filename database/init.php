<?php
// Inicialização do banco de dados SQLite
$db_path = __DIR__ . '/mivora.db';

try {
    $pdo = new PDO("sqlite:$db_path");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Criar tabela de planos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS planos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            preco_original DECIMAL(10,2) NOT NULL,
            preco_promocional DECIMAL(10,2) NOT NULL,
            descricao TEXT NOT NULL,
            recursos TEXT NOT NULL,
            manutencao_preco DECIMAL(10,2) NOT NULL,
            ativo INTEGER DEFAULT 1,
            ordem INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Criar tabela de configurações
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS configuracoes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            chave TEXT UNIQUE NOT NULL,
            valor TEXT NOT NULL,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Criar tabela de mensagens WhatsApp
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS mensagens_whatsapp (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            plano_id INTEGER,
            mensagem TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (plano_id) REFERENCES planos (id)
        )
    ");
    
    // Inserir planos padrão se não existirem
    $count = $pdo->query("SELECT COUNT(*) FROM planos")->fetchColumn();
    
    if ($count == 0) {
        $planos_default = [
            [
                'nome' => 'Site Básico com Domínio Gratuito',
                'preco_original' => 1200.00,
                'preco_promocional' => 800.00,
                'descricao' => 'Site profissional moderno com painel administrativo simples e domínio gratuito incluso.',
                'recursos' => 'Site profissional moderno|Painel administrativo simples|Domínio gratuito incluso|Manual completo de uso|Alterações em tempo real',
                'manutencao_preco' => 150.00,
                'ordem' => 1
            ],
            [
                'nome' => 'Site + Hospedagem Profissional',
                'preco_original' => 1500.00,
                'preco_promocional' => 1100.00,
                'descricao' => 'Tudo do Plano 1 com painel administrativo avançado e hospedagem profissional.',
                'recursos' => 'Tudo do Plano 1|Painel administrativo avançado|Hospedagem profissional|Maior espaço e backup automático|SSL incluso|Alterar cores e promoções',
                'manutencao_preco' => 200.00,
                'ordem' => 2
            ],
            [
                'nome' => 'Site + Hospedagem + Instagram + E-book',
                'preco_original' => 2000.00,
                'preco_promocional' => 1500.00,
                'descricao' => 'Tudo do Plano 2 com organização do Instagram e E-books exclusivos de vendas.',
                'recursos' => 'Tudo do Plano 2|Organização do Instagram|E-books exclusivos de vendas|Estratégias de marketing|Consultoria digital',
                'manutencao_preco' => 250.00,
                'ordem' => 3
            ],
            [
                'nome' => 'Personalizado',
                'preco_original' => 0.00,
                'preco_promocional' => 0.00,
                'descricao' => 'Criação de site exclusivo e personalizado conforme necessidade do cliente.',
                'recursos' => 'Site exclusivo e personalizado|Desenvolvimento sob medida|Funcionalidades específicas|Design único|Consultoria completa',
                'manutencao_preco' => 0.00,
                'ordem' => 4
            ]
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO planos (nome, preco_original, preco_promocional, descricao, recursos, manutencao_preco, ordem)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($planos_default as $plano) {
            $stmt->execute([
                $plano['nome'],
                $plano['preco_original'],
                $plano['preco_promocional'],
                $plano['descricao'],
                $plano['recursos'],
                $plano['manutencao_preco'],
                $plano['ordem']
            ]);
        }
    }
    
    // Inserir configurações padrão
    $configs_default = [
        ['whatsapp_url', 'https://wa.link/yl761t'],
        ['instagram_url', 'https://www.instagram.com/mivoradigital/'],
        ['site_title', 'Mivora Digital - Criação de Sites Profissionais'],
        ['admin_password', password_hash('admin123', PASSWORD_DEFAULT)]
    ];
    
    $stmt = $pdo->prepare("INSERT OR REPLACE INTO configuracoes (chave, valor) VALUES (?, ?)");
    foreach ($configs_default as $config) {
        $stmt->execute($config);
    }
    
    echo "Banco de dados inicializado com sucesso!";
    
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

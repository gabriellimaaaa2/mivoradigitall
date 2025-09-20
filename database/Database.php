<?php
class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        $db_path = __DIR__ . '/mivora.db';
        
        try {
            $this->pdo = new PDO("sqlite:$db_path");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
    
    // Métodos para planos
    public function getPlanos() {
        $stmt = $this->pdo->query("SELECT * FROM planos WHERE ativo = 1 ORDER BY ordem");
        return $stmt->fetchAll();
    }
    
    public function getPlano($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM planos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function updatePlano($id, $dados) {
        $sql = "UPDATE planos SET 
                nome = ?, 
                preco_original = ?, 
                preco_promocional = ?, 
                descricao = ?, 
                recursos = ?, 
                manutencao_preco = ?,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome'],
            $dados['preco_original'],
            $dados['preco_promocional'],
            $dados['descricao'],
            $dados['recursos'],
            $dados['manutencao_preco'],
            $id
        ]);
    }
    
    public function addPlano($dados) {
        $sql = "INSERT INTO planos (nome, preco_original, preco_promocional, descricao, recursos, manutencao_preco, ordem)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome'],
            $dados['preco_original'],
            $dados['preco_promocional'],
            $dados['descricao'],
            $dados['recursos'],
            $dados['manutencao_preco'],
            $dados['ordem'] ?? 0
        ]);
    }
    
    public function deletePlano($id) {
        $stmt = $this->pdo->prepare("UPDATE planos SET ativo = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Métodos para configurações
    public function getConfig($chave) {
        $stmt = $this->pdo->prepare("SELECT valor FROM configuracoes WHERE chave = ?");
        $stmt->execute([$chave]);
        $result = $stmt->fetch();
        return $result ? $result['valor'] : null;
    }
    
    public function setConfig($chave, $valor) {
        $stmt = $this->pdo->prepare("INSERT OR REPLACE INTO configuracoes (chave, valor, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP)");
        return $stmt->execute([$chave, $valor]);
    }
    
    public function getAllConfigs() {
        $stmt = $this->pdo->query("SELECT * FROM configuracoes");
        return $stmt->fetchAll();
    }
    
    // Método para verificar login admin
    public function verificarLogin($password) {
        $hash_stored = $this->getConfig('admin_password');
        return password_verify($password, $hash_stored);
    }
}
?>

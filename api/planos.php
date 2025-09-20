<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../database/Database.php';

try {
    $db = Database::getInstance();
    $planos = $db->getPlanos();
    $whatsapp_url = $db->getConfig('whatsapp_url');
    
    // Formatar dados para o frontend
    $response = [
        'success' => true,
        'planos' => array_map(function($plano) use ($whatsapp_url) {
            return [
                'id' => $plano['id'],
                'nome' => $plano['nome'],
                'preco_original' => floatval($plano['preco_original']),
                'preco_promocional' => floatval($plano['preco_promocional']),
                'descricao' => $plano['descricao'],
                'recursos' => explode('|', $plano['recursos']),
                'manutencao_preco' => floatval($plano['manutencao_preco']),
                'whatsapp_link' => $whatsapp_url,
                'whatsapp_message' => urlencode("Olá! Tenho interesse no plano *{$plano['nome']}* por R$ " . number_format($plano['preco_promocional'], 2, ',', '.') . ". Gostaria de mais informações!")
            ];
        }, $planos),
        'whatsapp_url' => $whatsapp_url
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro interno do servidor'
    ]);
}
?>

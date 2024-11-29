<?php
include('../../database/conection.php'); // Inclua sua conexão ao banco de dados

header('Content-Type: application/json'); // Define o retorno como JSON

session_start();

$idRemetente = $_SESSION['idUsuario']; // ID do remetente (quem enviou as mensagens)
$idDestinatario = $_POST['idDestinatario']; // ID do destinatário (quem visualizou)

if (!$idRemetente || !$idDestinatario) {
    echo json_encode(["error" => "IDs inválidos."]);
    exit;
}

// Atualiza as mensagens do remetente como visualizadas
$sql = "
    UPDATE tbmensagens 
    SET msgVisualizada = 1 
    WHERE 
        ((idRemetente = $idRemetente AND idDestinatario = $idDestinatario) 
        OR (idRemetente = $idDestinatario AND idDestinatario = $idRemetente))
      AND msgVisualizada = 0
";

$result = mysqli_query($conection, $sql);

if ($result) {
    echo json_encode(["success" => "Mensagens atualizadas com sucesso."]);
} else {
    echo json_encode(["error" => "Erro ao atualizar mensagens: " . mysqli_error($conection)]);
}
exit;
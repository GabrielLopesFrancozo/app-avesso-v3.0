<?php
require_once '../../database/conection.php'; // Conexão com o banco de dados

header('Content-Type: application/json'); // Define o retorno como JSON

session_start();
$idUsuario = $_SESSION['idUsuario']; // Substitua pelo método que você usa para identificar o usuário logado

$sql = "
    SELECT 
        u.idUsuario, 
        u.nomeUsuario, 
        u.fotoPerfilUsuario, 
        COALESCE((
            SELECT COUNT(m.idMsg)
            FROM tbmensagens AS m
            WHERE m.idRemetente = u.idUsuario 
              AND m.idDestinatario = $idUsuario
              AND m.msgVisualizada = 0
        ), 0) AS naoVisualizadas
    FROM 
        tbusuarios AS u
    WHERE 
        u.idUsuario IN (
            SELECT CASE 
                     WHEN mt.idUsuario = $idUsuario THEN mt.idUsuarioMatch 
                     WHEN mt.idUsuarioMatch = $idUsuario THEN mt.idUsuario
                   END
            FROM tbmatches AS mt
            WHERE mt.idUsuario = $idUsuario 
               OR mt.idUsuarioMatch = $idUsuario
        )
    ORDER BY 
        u.nomeUsuario ASC";

$result = mysqli_query($conection, $sql);

// Verifica se houve erro na execução da query
if (!$result) {
    echo json_encode(["error" => "Erro na consulta: " . mysqli_error($conn)]);
    exit;
}

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo json_encode($users);
exit;

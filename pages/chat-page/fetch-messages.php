<?php

include("../../database/conection.php");

session_start();

// ID do usuário logado
$idUsuario = $_SESSION["idUsuario"];
$idDestinatario = $_POST["idDestinatario"];

// Verifica se os IDs foram fornecidos
if (!isset($idUsuario) || !isset($idDestinatario)) {
    echo json_encode(["error" => "IDs inválidos"]);
    exit;
}

// Busca mensagens trocadas entre o usuário logado e o destinatário
$sql = "
    SELECT * 
    FROM tbmensagens 
    WHERE 
        (idRemetente = '$idUsuario' AND idDestinatario = '$idDestinatario') 
        OR 
        (idRemetente = '$idDestinatario' AND idDestinatario = '$idUsuario')
    ORDER BY dataMsg ASC
";
$result = mysqli_query($conection, $sql);

$messages = [];

// Formata as mensagens para JSON
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = [
            "idMensagem" => $row["idMsg"],
            "idRemetente" => $row["idRemetente"],
            "idDestinatario" => $row["idDestinatario"],
            "conteudoMsg" => $row["conteudoMsg"],
            "dataEnvio" => $row["dataMsg"],
        ];
    }
}

// Retorna as mensagens em formato JSON
header("Content-Type: application/json");
echo json_encode($messages);
exit;
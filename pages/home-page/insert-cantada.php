<?php
include("../../database/conection.php");

// Verifica a conexão
if (!$conection) {
    echo json_encode(["success" => false, "error" => "Falha na conexão com o banco de dados."]);
    exit();
}

// Verifica se os parâmetros foram enviados pelo POST
if (isset($_POST['idRemetente']) && isset($_POST['idDestinatario']) && isset($_POST['conteudoCantada'])) {
    // Protege contra SQL Injection
    $idRemetente = mysqli_real_escape_string($conection, $_POST['idRemetente']);
    $idDestinatario = mysqli_real_escape_string($conection, $_POST['idDestinatario']);
    $conteudoCantada = mysqli_real_escape_string($conection, $_POST['conteudoCantada']);

    // Insere a cantada no banco de dados
    $sql = "INSERT INTO tbcantadas (idRemetente, idDestinatario, conteudoCantada) VALUES ('$idRemetente', '$idDestinatario', '$conteudoCantada')";
    if (mysqli_query($conection, $sql)) {
        echo json_encode(["success" => true, "message" => "Cantada inserida com sucesso."]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conection)]);
    }
} else {
    // Erro caso os parâmetros não sejam fornecidos
    echo json_encode(["success" => false, "error" => "Parâmetros inválidos."]);
}
?>

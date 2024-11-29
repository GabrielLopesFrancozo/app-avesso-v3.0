<?php

include("../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

// Verifica se os dados foram enviados
if (isset($_POST["message-input"]) && isset($_POST["id-destinatario"])) {
    $txtMsg = $_POST["message-input"]; // Nome do campo ajustado
    $idRemetente = $idUsuario;
    $idDestinatario = $_POST["id-destinatario"];

    // Insere a mensagem no banco de dados
    $sql = "INSERT INTO tbmensagens (idRemetente, idDestinatario, conteudoMsg) 
            VALUES ('$idRemetente', '$idDestinatario', '$txtMsg')";

    if (mysqli_query($conection, $sql)) {
        echo "Mensagem enviada com sucesso!";
    } else {
        echo "Erro ao enviar mensagem: " . mysqli_error($conection);
    }
} else {
    echo "Dados incompletos!";
}
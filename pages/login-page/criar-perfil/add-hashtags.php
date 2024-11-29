<?php

include("../../../database/conection.php");
session_start();

$idUsuario = $_SESSION["idUsuario"];

$response = [];

if (isset($_POST["tituloHashtag"]) && !empty($_POST["tituloHashtag"])) {
    $tituloHashtag = str_replace("#", "", $_POST["tituloHashtag"]);

    // Verificar se a hashtag já existe
    $sql = "SELECT idHashtag FROM tbhashtags WHERE idUsuario = $idUsuario AND tituloHashtag = '$tituloHashtag'";
    $result = mysqli_query($conection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $response["status"] = "error";
        $response["message"] = "Hashtag já existente";
    } else {
        // Inserir nova hashtag
        $sql = "INSERT INTO tbhashtags (idUsuario, tituloHashtag) VALUES ($idUsuario, '$tituloHashtag')";
        mysqli_query($conection, $sql);

        // Atualizar status do usuário
        $sql = "UPDATE tbusuarios SET statusCadUsuario = 5 WHERE idUsuario = $idUsuario";
        mysqli_query($conection, $sql);

        // Buscar hashtags atualizadas
        $sql = "SELECT tituloHashtag FROM tbhashtags WHERE idUsuario = $idUsuario";
        $result = mysqli_query($conection, $sql);
        $hashtags = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $hashtags[] = $row["tituloHashtag"];
        }

        $response["status"] = "success";
        $response["message"] = "Adicione mais hashtags";
        $response["hashtags"] = $hashtags;
    }

    // Retorna o JSON
    echo json_encode($response);
    exit;
}

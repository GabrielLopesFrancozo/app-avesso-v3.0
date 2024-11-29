<?php
include("../../database/conection.php");

// Verifica se os parâmetros foram enviados pelo POST
if (isset($_POST['idUsuario']) && isset($_POST['idUsuarioMatch'])) {
    // Protege contra SQL Injection
    $idUsuario = mysqli_real_escape_string($conection, $_POST['idUsuario']);
    $idUsuarioMatch = mysqli_real_escape_string($conection, $_POST['idUsuarioMatch']);

    // Insere o match no banco de dados
    $sql = "INSERT INTO tbmatches (idUsuario, idUsuarioMatch) VALUES ('$idUsuario', '$idUsuarioMatch')";
    if (mysqli_query($conection, $sql)) {
        echo json_encode(["success" => true, "message" => "Match inserido com sucesso."]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conection)]);
    }
} else {
    // Erro caso os parâmetros não sejam fornecidos
    echo json_encode(["success" => false, "error" => "Parâmetros inválidos."]);
}
?>

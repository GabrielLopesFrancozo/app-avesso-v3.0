<?php

session_start();

include_once('../../../../database/conection.php');

// Inicializa a resposta
$response = [
    "success" => false,
    "errors" => []
];

// Verifica se o ID do usuário está na sessão
if (!isset($_SESSION['idUsuario'])) {
    $response['errors'][] = "Erro: Usuário não autenticado.";
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$idUsuario = $_SESSION['idUsuario'];

// Verifica se o ID da foto foi enviado
if (!isset($_POST['photoId'])) {
    $response['errors'][] = "Erro: Nenhuma foto especificada para deletar.";
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$photoId = $_POST['photoId'];

// Consulta para obter o nome do arquivo a ser deletado
$sql = "SELECT nomeArquivoFoto FROM tbfotos_usuarios WHERE nomeArquivoFoto = '$photoId' AND idUsuario = '$idUsuario'";
$result = mysqli_query($conection, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $filePath = "../../../../database/users/profiles/" . $row['nomeArquivoFoto'];

    // Verifica se o arquivo existe no diretório
    if (file_exists($filePath)) {
        // Tenta deletar o arquivo
        if (unlink($filePath)) {
            // Remove o registro do banco de dados
            $sqlDelete = "DELETE FROM tbfotos_usuarios WHERE nomeArquivoFoto = '$photoId' AND idUsuario = '$idUsuario'";
            if (mysqli_query($conection, $sqlDelete)) {
                $response['success'] = true;
                $response['message'] = "Foto deletada com sucesso.";
            } else {
                $response['errors'][] = "Erro ao deletar registro da foto no banco de dados.";
            }
        } else {
            $response['errors'][] = "Erro ao deletar o arquivo do diretório.";
        }
    } else {
        $response['errors'][] = "Arquivo não encontrado no diretório.";
    }
} else {
    $response['errors'][] = "Foto não encontrada no banco de dados ou você não tem permissão para deletá-la.";
}

// Retorna a resposta em formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

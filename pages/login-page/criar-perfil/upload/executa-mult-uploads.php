<?php

session_start();

include_once('../../../../database/conection.php');

// Diretório onde as imagens serão salvas
$uploadDir = '../../../../database/users/profiles/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Cria a pasta, se não existir
}

// Inicializa a resposta
$response = [
    "success" => [],
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

// Verifica se há arquivos enviados
if (isset($_FILES['images']['tmp_name']) && !empty($_FILES['images']['tmp_name'])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['images']['name'][$key]);
        $fileNameCrypto = hash('sha1', $fileName);
        $extensao = strtolower(strrchr($fileName, '.')); // Obtem a extensão
        $tamanho_arquivo = $_FILES['images']['size'][$key];
        $nome_arquivo_novo = $idUsuario . $fileNameCrypto . $extensao;
        $filePath = $uploadDir . $nome_arquivo_novo;

        // Validações
        $extensoes_validas = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];
        $tamanho_maximo = 10 * 1024 * 1024; // 10MB

        if (!getimagesize($tmpName)) {
            $response['errors'][] = "O arquivo $fileName não é uma imagem válida.";
            continue;
        }

        if (!in_array($extensao, $extensoes_validas)) {
            $response['errors'][] = "Extensão do arquivo $fileName não é permitida.";
            continue;
        }

        if ($tamanho_arquivo > $tamanho_maximo) {
            $response['errors'][] = "O arquivo $fileName excede o tamanho máximo permitido de 10MB.";
            continue;
        }

        // Move o arquivo e salva no banco de dados
        if (move_uploaded_file($tmpName, $filePath)) {
            $sql = "INSERT INTO tbfotos_usuarios (idUsuario, nomeArquivoFoto) VALUES ('$idUsuario', '$nome_arquivo_novo')";

            if (mysqli_query($conection, $sql)) {
                $response['success'][] = [
                    "file" => $fileName,
                    "path" => $filePath
                ];
            } else {
                $response['errors'][] = "Erro ao salvar $fileName no banco de dados.";
            }
        } else {
            $response['errors'][] = "Erro ao mover o arquivo $fileName para o diretório de upload.";
        }
    }
} else {
    $response['errors'][] = "Nenhum arquivo enviado.";
}

// Retorna a resposta em formato JSON
header('Content-Type: application/json');
echo json_encode($response);

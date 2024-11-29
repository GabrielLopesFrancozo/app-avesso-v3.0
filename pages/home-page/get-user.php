<?php

function getUser($filter)
{
    include("../../database/conection.php");

    session_start();

    $idUsuarioAtual = $_SESSION["idUsuario"];

    // Inicializa a lista de IDs já exibidos na sessão
    if (!isset($_SESSION['usuarios_exibidos'])) {
        $_SESSION['usuarios_exibidos'] = [];
    }

    // Obtenha todos os IDs de usuários (exceto o usuário atual)
    $sqlTodosUsuarios = "SELECT idUsuario FROM tbusuarios WHERE idUsuario != $idUsuarioAtual and statusCadUsuario = 6 and $filter";
    $resultTodosUsuarios = mysqli_query($conection, $sqlTodosUsuarios);

    $todosUsuarios = [];
    while ($row = mysqli_fetch_assoc($resultTodosUsuarios)) {
        $todosUsuarios[] = $row['idUsuario'];
    }

    // Verifica se todos os usuários já foram exibidos
    if (count($_SESSION['usuarios_exibidos']) >= count($todosUsuarios)) {
        // Reinicia a lista de exibidos
        $_SESSION['usuarios_exibidos'] = [];
    }

    // Filtra os usuários que ainda não foram exibidos
    $usuariosRestantes = array_diff($todosUsuarios, $_SESSION['usuarios_exibidos']);

    // Escolhe um ID aleatório dos usuários restantes
    if (!empty($usuariosRestantes)) {
        $randomId = $usuariosRestantes[array_rand($usuariosRestantes)];
        $_SESSION['usuarios_exibidos'][] = $randomId; // Marca como exibido
    } else {
        echo json_encode(["error" => "Nenhum outro ID foi encontrado na tabela."]);
        exit;
    }

    // Consulta para obter os dados do usuário selecionado
    $sqlUsuario = "
        SELECT 
            tbusuarios.*,
            tbhashtags.tituloHashtag
        FROM 
            tbusuarios
        LEFT JOIN 
            tbhashtags 
        ON 
            tbusuarios.idUsuario = tbhashtags.idUsuario
        WHERE 
            tbusuarios.idUsuario = $randomId;
    ";

    $resultUsuario = mysqli_query($conection, $sqlUsuario);

    $userData = null;
    $hashtags = [];

    // Função para calcular a idade a partir da data de nascimento
    function calcularIdade($dataNascimento)
    {
        $dataNasc = new DateTime($dataNascimento);
        $hoje = new DateTime();
        $idade = $hoje->diff($dataNasc)->y;
        return $idade;
    }

    // Processa os dados do usuário e calcula a idade
    while ($row = mysqli_fetch_assoc($resultUsuario)) {
        $idadeUsuario = calcularIdade($row['dataNascUsuario']);

        if (!$userData) {
            $userData = [
                'idUsuario' => $row['idUsuario'],
                'fotoPerfilUsuario' => $row['fotoPerfilUsuario'],
                'dataNascimento' => $row['dataNascUsuario'],
                'idadeUsuario' => $idadeUsuario,
                'nomeUsuario' => $row['nomeUsuario'],
                'bioUsuario' => $row['bioUsuario']
            ];
        }

        if (!empty($row['tituloHashtag'])) {
            $hashtags[] = $row['tituloHashtag'];
        }
    }


    // Busca perguntas e respostas do usuário
    $questions = [];
    $sqlPerguntas = "SELECT idPergunta, respostaUsuario FROM tbusuario_responde_pergunta WHERE idUsuario = $randomId";
    $resultPerguntas = mysqli_query($conection, $sqlPerguntas);

    if (mysqli_num_rows($resultPerguntas) > 0) {
        while ($rowPergunta = mysqli_fetch_assoc($resultPerguntas)) {
            $idPergunta = $rowPergunta['idPergunta'];
            $respostaUsuario = $rowPergunta['respostaUsuario'];

            // Busca o título da pergunta
            $sqlTitulo = "SELECT tituloPergunta FROM tbperguntas WHERE idPergunta = $idPergunta";
            $resultTitulo = mysqli_query($conection, $sqlTitulo);
            $tituloPergunta = mysqli_fetch_assoc($resultTitulo)['tituloPergunta'];

            // Adiciona a pergunta e resposta ao array
            $questions[] = [
                'tituloPergunta' => $tituloPergunta,
                'respostaUsuario' => $respostaUsuario
            ];
        }
    }

    $userPhotos = [];

    // Busca fotos do usuário
    $sqlFotos = "SELECT idFoto, nomeArquivoFoto FROM tbfotos_usuarios WHERE idUsuario = $randomId";
    $resultFotos = mysqli_query($conection, $sqlFotos);

    if (mysqli_num_rows($resultFotos) > 0) {
        while ($rowFoto = mysqli_fetch_assoc($resultFotos)) {
            $userPhotos[] = $rowFoto;
        }
    }

    // Verifica se os dados do usuário existem
    if (!$userData) {
        echo json_encode(["error" => "Erro: Usuário não encontrado."]);
        exit;
    }

    echo json_encode([
        "user" => $userData,
        "hashtags" => $hashtags,
        "questions" => $questions,
        "photos" => $userPhotos
    ]);
}

// Verifica se a requisição foi feita com o parâmetro 'action' e 'getUser'
if (isset($_GET['action']) && $_GET['action'] === 'getUser') {
    $filter = $_GET['filter'];
    getUser($filter);
}

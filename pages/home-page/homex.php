<?php

session_start();
include("../../database/conection.php");

$idUsuarioAtual = $_SESSION["idUsuario"];

// Inicializa a lista de IDs já exibidos na sessão
if (!isset($_SESSION['usuarios_exibidos'])) {
    $_SESSION['usuarios_exibidos'] = [];
}

// Obtenha todos os IDs de usuários (exceto o usuário atual)
$sqlTodosUsuarios = "SELECT idUsuario FROM tbusuarios WHERE idUsuario != $idUsuarioAtual";
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
    echo "Nenhum outro ID foi encontrado na tabela.";
    exit;
}

// Consulta para obter os dados do usuário selecionado
$sqlUsuario = "
SELECT 
    tbusuarios.*, 
    tbhashtags.tituloHashtag, 
    tbfotos_usuarios.nomeArquivoFoto
FROM 
    tbusuarios
LEFT JOIN 
    tbhashtags ON tbusuarios.idUsuario = tbhashtags.idUsuario
LEFT JOIN 
    tbfotos_usuarios ON tbusuarios.idUsuario = tbfotos_usuarios.idUsuario
WHERE 
    tbusuarios.idUsuario = $randomId;
";

$resultUsuario = mysqli_query($conection, $sqlUsuario);

$userData = null;
$hashtags = [];

// Processa os dados do usuário e hashtags
while ($row = mysqli_fetch_assoc($resultUsuario)) {
    if (!$userData) {
        $userData = [
            'fotoPerfilUsuario' => $row['fotoPerfilUsuario'],
            'nomeUsuario' => $row['nomeUsuario'],
            'bioUsuario' => $row['bioUsuario']
        ];
    }

    if (!empty($row['tituloHashtag'])) {
        $hashtags[] = $row['tituloHashtag'];
    }
}

if (!$userData) {
    echo "Erro: Usuário não encontrado.";
    exit;
}
?>

<link rel="stylesheet" href="./pages/home-page/home.css">

<div class="home-container">

    <div class="filters-container">
        <button class="espiar"><i class="bi bi-eye"></i>Espiar</button>
        <button class="filter"><i class="bi bi-filter"></i>Filtros</button>
        <p class="hashtags">#All</p>
    </div>

    <div class="content">
        <div class="content-image">
            <img src="<?= './database/users/' . $userData['fotoPerfilUsuario'] ?>" class="img" alt="Foto usuario">
            <div class="blur-container">

                <div class="info-reduzed" style="margin-bottom: 10rem; width: 100%; padding-inline: 3rem;">
                    <div class="bio" style="color: white;">
                        <h3 class="nome"><?= $userData['nomeUsuario'] ?></h3>
                        <h4 style="color: white;">Brazil</h4>
                        <p class="bio-user" style="color: white;"><?= $userData['bioUsuario'] ?></p>
                    </div>
                    <div class="divider"></div>
                    <div class="hashtags-container">
                        <label class="hashtags" style="color: white;">
                            <?php
                            if (!empty($hashtags)) {
                                foreach ($hashtags as $hashtag) {
                                    echo " #$hashtag";
                                }
                            } else {
                                echo "Sem hashtags.";
                            }
                            ?>
                        </label>
                    </div>
                </div>

                <form id="form-options" method="post" class="options-container">
                    <input type="text" id="idUsuario" name="idUsuario" value="<?= $idUsuario ?>" hidden>
                    <button id="btn-detona" class="button" type="button"><i class="bi bi-x-lg"></i></button>
                    <button id="btn-cantada" class="button" type="button"><i class="bi bi-chat-square-heart-fill"></i></button>
                    <button id="btn-apaixona" class="button" type="button"><i class="bi bi-suit-heart-fill"></i></button>
                </form>

            </div>
        </div>

        <div class="info">
            <div class="bio">
                <h3 class="nome"><?= $userData['nomeUsuario'] ?></h3>
                <h4>Brazil</h4>
                <p class="bio-user"><?= $userData['bioUsuario'] ?></p>
            </div>
            <div class="divider"></div>
            <div class="hashtags-container">
                <label class="hashtags">
                    <?php
                    if (!empty($hashtags)) {
                        foreach ($hashtags as $hashtag) {
                            echo " #$hashtag";
                        }
                    } else {
                        echo "Sem hashtags.";
                    }
                    ?>
                </label>
            </div>
            <div class="perguntas">
                <?php
                $sql = "SELECT idPergunta, respostaUsuario FROM tbusuario_responde_pergunta WHERE idUsuario = $randomId";
                $result = mysqli_query($conection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql = "SELECT tituloPergunta FROM tbperguntas WHERE idPergunta = " . $row['idPergunta'];
                        $question = mysqli_query($conection, $sql);
                        $data = mysqli_fetch_assoc($question);
                        echo "<div class='card'><h3>" . $data["tituloPergunta"] . "</h3>";
                        echo "<p>" . $row["respostaUsuario"] . "</p></div>";
                    }
                }
                ?>
            </div>
        </div>

        <script src="./pages/home-page/home.js"></script>
    </div>
</div>
<?php

include("../../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

if (
    isset($_POST["question"]) &&
    isset($_POST["user-answer"]) &&
    !empty($_POST["question"]) &&
    !empty($_POST["user-answer"])
) {
    $question = $_POST["question"];
    $answer = $_POST["user-answer"];

    // Verificar se a combinação já existe
    $sql = "SELECT * FROM tbusuario_responde_pergunta 
            WHERE idUsuario = $idUsuario 
            AND idPergunta = '$question'";
    $result = mysqli_query($conection, $sql);

    if (mysqli_num_rows($result) === 0) {
        // Inserir somente se a combinação não existir
        $sql = "INSERT INTO tbusuario_responde_pergunta (idUsuario, idPergunta, respostaUsuario) 
                VALUES ($idUsuario, '$question', '$answer')";
        mysqli_query($conection, $sql);
    } else {
        // Atualizar se a combinação existir
        $sql = "UPDATE tbusuario_responde_pergunta 
                SET respostaUsuario = '$answer' 
                WHERE idUsuario = $idUsuario 
                AND idPergunta = '$question'";
        mysqli_query($conection, $sql);
    }

    $sql = "UPDATE tbusuarios SET statusCadUsuario = 6 WHERE idUsuario = $idUsuario";
    mysqli_query($conection, $sql);

    // Redirecionar após a verificação
    header("Location: criar-perfil-5.php");
    exit;
}

$sql = "
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
        tbusuarios.idUsuario = $idUsuario;
";

$result = mysqli_query($conection, $sql);

$userData = null;
$hashtags = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Salva os dados do usuário apenas uma vez
    if (!$userData) {
        $userData = [
            'fotoPerfilUsuario' => $row['fotoPerfilUsuario'],
            'nomeUsuario' => $row['nomeUsuario'],
            'bioUsuario' => $row['bioUsuario']
        ];
    }

    // Armazena as hashtags
    if (!empty($row['tituloHashtag'])) {
        $hashtags[] = $row['tituloHashtag'];
    }
}

if (!$userData) {
    echo "Erro: Usuário não encontrado.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Perfil | Avesso</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/svg" href="../../../assets/imgs/favicon.ico" />
    <!-- Global CSS and Components-->
    <link rel="stylesheet" href="../../../../styles/global.css">
    <link rel="stylesheet" href="../../../../styles/components/progress-bar.css">
    <link rel="stylesheet" href="../../../../styles/components/send-input.css">
    <link rel="stylesheet" href="../../../../styles/components/input.css">
    <!-- Local CSS -->
    <link rel="stylesheet" href="criar-perfil.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <script src="../../../js/vendor/jquery-3.7.1.js"></script>
    <script src="../../../js/vendor/jquery.form.js"></script>

    <main class="main">

        <!-- progress-bar -->
        <div class="progress-bar">
            <div class="progress-step first">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span class="step"><?= $userData["fotoPerfilUsuario"] == "" ? "1" : "<i class='bi bi-check' style='font-size: 1.5rem'></i>" ?></span>
                </div>
            </div>
            <div class="progress-step second">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span class="step"><?= $userData["bioUsuario"] == "" ? "2" : "<i class='bi bi-check' style='font-size: 1.5rem'></i>" ?></span>
                </div>
            </div>
            <div class="progress-step third">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span class="step"><?= $hashtags == [] ? "3" : "<i class='bi bi-check' style='font-size: 1.5rem'></i>" ?></span>
                </div>
            </div>
            <div class="progress-step fourth">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span>4</span>
                </div>
            </div>
        </div>
        <!-- /progress-bar -->

        <div class="container">

            <div class="profile-preview">
                <div class="user-photo-container">
                    <img class="user-photo" src="../../../../database/users/<?= $userData["fotoPerfilUsuario"] ?>" alt="Foto do Usuário">
                </div>
                <h4> <?= ucwords($userData["nomeUsuario"]) ?></h4>
                <p> <?= $userData["bioUsuario"] ?></p>
                <div class="hashtags">
                    <?php
                    if (!empty($hashtags)) {
                        foreach ($hashtags as $hashtag) {
                            echo "<span class='hashtag-item'>#$hashtag</span> ";
                        }
                    } else {
                        echo "<p class='no-hashtags'>Sem hashtags ainda.</p>";
                    }
                    ?>
                </div>
                <div class="questions">
                    <?php
                    $sql = "SELECT idPergunta, respostaUsuario FROM tbusuario_responde_pergunta WHERE idUsuario = $idUsuario";
                    $result = mysqli_query($conection, $sql);

                    $questionQtd = 0;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sql = "SELECT tituloPergunta FROM tbperguntas WHERE idPergunta = " . $row['idPergunta'];
                            $question = mysqli_query($conection, $sql);
                            $data = mysqli_fetch_assoc($question);
                            echo "<p class='question-title'>" . $data["tituloPergunta"] . "</p>";
                            echo "<p class='question-answer'>" . $row["respostaUsuario"] . "</p>";

                            $questionQtd++;
                        }
                    }
                    ?>
                </div>
                <div class="qtd-questions">
                    <?php
                    $qtd = isset($questionQtd) ? $questionQtd : 0;
                    echo "<p class='qtd-questions'>Perguntas respondidas: " . $qtd . " / 2</p>";
                    ?>
                </div>
            </div>

            <div class="add-info-container">
                <p style="text-align: center; color: var(--gray-700); font-weight: bold; margin-bottom: 10px;">Adicione ao menos <span style='font-weight: bold; color: var(--carmin);'>duas</span> perguntas</p>

                <form class="form add-question" id="form-question" action="" method="POST">
                    <select class="input" name="question" id="question">
                        <?php

                        $sql = "SELECT * FROM tbperguntas";
                        $result = mysqli_query($conection, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["idPergunta"] . "'>" . $row["tituloPergunta"] . "</option>";
                        }

                        ?>
                    </select>
                    <textarea type="text" name="user-answer" class="input text-area" id="user-answer" placeholder="Sua resposta" required maxlength="255" autocomplete="off"></textarea>
                    <button class="button" id="btn-send-question" type="submit">Enviar<i class="bi bi-send"></i></button>
                </form>

                <style>
                    #preview-img-container img {
                        margin: 10px;
                        border: 2px solid #ccc;
                        border-radius: 8px;
                    }
                </style>

                <!-- <form id="form-photo" enctype="multipart/form-data">
                    <label for="user-photo-1">Selecione as fotos:</label>
                    <input type="file" id="user-photo-1" name="images[]" multiple accept="image/*">
                    <button type="submit" id="btn-send-photo">Enviar Fotos</button>
                </form>

                <div id="preview-img-container"></div> -->

            </div>
        </div>

        <footer class='bottom-container'>
            <a
                <?php
                if ($qtd >= 2) {
                    echo "href='../../splash-screen/splash.php' class='link active'";
                } else {
                    echo "class='link'";
                }
                ?>>Finalizar <i class="bi bi-arrow-right"></i></a>
        </footer>

    </main>

    <script src="criar-perfil-5.js"></script>
</body>

</html>
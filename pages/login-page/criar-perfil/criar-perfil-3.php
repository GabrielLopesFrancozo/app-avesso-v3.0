<?php

include("../../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

if (isset($_POST["bioUsuario"]) && !empty($_POST["bioUsuario"])) {
    $bio = $_POST["bioUsuario"];

    $sql = "UPDATE tbusuarios SET bioUsuario = '$bio', statusCadUsuario = 4 WHERE idUsuario = $idUsuario";
    mysqli_query($conection, $sql);
}

if (strpos($_SERVER['REQUEST_URI'], 'criar-perfil-3.php') !== false) {
    $sql = "UPDATE tbusuarios SET statusCadUsuario = 2 WHERE idUsuario = $idUsuario";
    mysqli_query($conection, $sql);
}

$sql = "SELECT * FROM tbusuarios WHERE idUsuario = $idUsuario";
$result = mysqli_query($conection, $sql);
$data = mysqli_fetch_assoc($result);

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
                    <span><?= $data["fotoPerfilUsuario"] == "" ? "1" : "<i class='bi bi-check' style='font-size: 1.5rem'></i>" ?></span>
                </div>
            </div>
            <div class="progress-step second">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span><?= $data["bioUsuario"] == "" ? "2" : "<i class='bi bi-check' style='font-size: 1.5rem'></i>" ?></span>
                </div>
            </div>
            <div class="progress-step third disabled">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span>3</span>
                </div>
            </div>
            <div class="progress-step fourth disabled">
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
                    <img class="user-photo" src="../../../../database/users/<?= $data["fotoPerfilUsuario"] ?>" alt="Foto do Usuário">
                </div>
                <h4> <?= ucwords($data["nomeUsuario"]) ?></h4>
                <p id="bio-usuario" class="active"> <?= $data["bioUsuario"] ?></p>
            </div>

            <div class="add-info-container">
                <p><?= $data["bioUsuario"] == "" ? "Adicione uma pequena <span style='font-weight: bold; color: var(--carmin);'>biografia</span> sobre você" : "Escreva algo e envie para <span style='font-weight: bold; color: var(--carmin);'>editar</span> biografia..." ?></p>
                
                <p class="bio-usuario-reduzed active" id="bio-usuario"> <?= $data["bioUsuario"] ?></p>
                
                <form class="form" method="post">
                    <!-- send-input -->
                    <div class="send-messages-container">
                        <div class="messageBox">
                            <input required="" placeholder="Ex: Olá, eu gosto de..." name="bioUsuario" type="text" id="message-input" autocomplete="off" />
                            <button id="btn-send-message" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 664 663">
                                    <path
                                        fill="none"
                                        d="M646.293 331.888L17.7538 17.6187L155.245 331.888M646.293 331.888L17.753 646.157L155.245 331.888M646.293 331.888L318.735 330.228L155.245 331.888"></path>
                                    <path
                                        stroke-linejoin="round"
                                        stroke-linecap="round"
                                        stroke-width="33.67"
                                        stroke="#6c6c6c"
                                        d="M646.293 331.888L17.7538 17.6187L155.245 331.888M646.293 331.888L17.753 646.157L155.245 331.888M646.293 331.888L318.735 330.228L155.245 331.888"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- /send-input -->
                </form>
            </div>
        </div>

        <footer class='bottom-container'>
            <a id="link-bottom"
                <?php
                if ($data["bioUsuario"] != "") {
                    echo "href='criar-perfil-4.php' class='link active'";
                } else {
                    echo "class='link'";
                }
                ?>>Próximo <i class="bi bi-arrow-right"></i></a>
        </footer>
    </main>

</body>

</html>
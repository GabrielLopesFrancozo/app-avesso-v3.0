<?php

include("./database/conection.php");

session_start();

if (!isset($_SESSION["idUsuario"])) {
    session_destroy();
    header("Location: ./pages/login-page/login.php");
} else {
    $idUsuario = $_SESSION["idUsuario"];

    $sql = "SELECT * FROM tbusuarios WHERE idUsuario = $idUsuario";
    $result = mysqli_query($conection, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data["statusCadUsuario"] != 6) {
        header("Location: ./pages/login-page/criar-perfil/criar-perfil-" . $data['statusCadUsuario'] . ".php");
    } else {

        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Avesso</title>
    <link rel="shortcut icon" type="favicon" href="./assets/imgs/favicon.ico" /> <!-- Favicon -->
    <!-- Global CSS e Components -->
    <link rel="stylesheet" href="./styles/global.css">
    <link rel="stylesheet" href="./styles/components/side-bar.css"> <!-- Side bar -->
    <link rel="stylesheet" href="./styles/components/modal.css"> <!-- Modal -->
    <link rel="stylesheet" href="./styles/components/send-input.css"> <!-- Send input -->
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <!-- JQuery -->
    <script src="./js/vendor/jquery-3.7.1.js"></script>
    <script src="./js/vendor/jquery.form.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <p id="idUsuario-session" style="display: none;"><?= $_SESSION["idUsuario"] ?></p>

    <!-- Side bar -->
    <aside class="side-bar">
        <header class="side-bar-header">
            <div class="logo-container">
                <img class="logo" src="./assets/imgs/logo.svg" alt="Logo Avesso">
                <img class="logo-icon" src="./assets/imgs/logo-icon.svg" alt="Icone Avesso">
            </div>
        </header>
        <nav class="nav">
            <ul class="nav-list nav-top">
                <li class="nav-item active" id="home">
                    <i class="bi bi-house-door" data-icon="bi bi-house-door" data-icon-filled="bi bi-house-door-fill"></i>
                    <a class="nav-link">Principal</a>
                </li>
                <li class="nav-item" id="chat">
                    <i class="bi bi-chat-dots" data-icon="bi bi-chat-dots" data-icon-filled="bi bi-chat-dots-fill"></i>
                    <a class="nav-link">Conversas</a>
                </li>
                <li class="nav-item" id="notifications">
                    <i class="bi bi-bell" data-icon="bi bi-bell" data-icon-filled="bi bi-bell-fill"></i>
                    <a class="nav-link">Notificações</a>
                </li>
                <!-- <li class="nav-item" id="search">
                    <i class="bi bi-search" data-icon="bi bi-search" data-icon-filled="bi bi-search"></i>
                    <a class="nav-link">Pesquisar</a>
                </li> -->
                <li class="nav-item" id="profile">
                    <div class="profile-pic-container">
                        <img class="profile-pic" src="./database/users/<?= $data["fotoPerfilUsuario"] ?>" alt="">
                    </div>
                    <a class="nav-link">Perfil</a>
                </li>
            </ul>
            <ul class="nav-list nav-bottom">
                <!-- <li class="nav-item" id="settings">
                    <i class="bi bi-gear-fill" data-icon="bi bi-gear" data-icon-filled="bi bi-gear-fill"></i>
                    <a class="nav-link">Configurações</a>
                </li> -->
                <li class="nav-item" id="logout">
                    <i class="bi bi-arrow-right"></i>
                    <a class="nav-link">Sair</a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Bottom bar -->
    <nav class="bottom-bar" style="display: none;">
        <ul class="bottom-nav-list">
            <li class="nav-item active" id="home">
                <i class="bi bi-house-door" data-icon="bi bi-house-door" data-icon-filled="bi bi-house-door-fill"></i>
                <a class="nav-link">Principal</a>
            </li>
            <li class="nav-item" id="chat">
                <i class="bi bi-chat-dots" data-icon="bi bi-chat-dots" data-icon-filled="bi bi-chat-dots-fill"></i>
                <a class="nav-link">Conversas</a>
            </li>
            <li class="nav-item" id="notifications">
                <i class="bi bi-bell" data-icon="bi bi-bell" data-icon-filled="bi bi-bell-fill"></i>
                <a class="nav-link">Notificações</a>
            </li>
            <!-- <li class="nav-item" id="search">
                <i class="bi bi-search" data-icon="bi bi-search" data-icon-filled="bi bi-search"></i>
                <a class="nav-link">Pesquisar</a>
            </li> -->
            <li class="nav-item" id="profile">
                <div class="profile-pic-container">
                    <img class="profile-pic" src="./database/users/<?= $data["fotoPerfilUsuario"] ?>" alt="">
                </div>
                <a class="nav-link">Perfil</a>
            </li>
        </ul>
    </nav>
    <!-- /Side bar -->

    <!-- Conteúdo principal -->
    <main class="main"><!-- Dinamicamente carregado --></main>

    <!-- Logout Modal -->
    <div id="logout-modal" style="display: none;"> <!-- Envólucro modal -->
        <!-- Modal -->
        <div class="modal">
            <div class="modal-content">
                <div class="modal-text">
                    <div class="close-button"><span class="close">&times;</span></div>
                    <h2>Sair</h2>
                    <p>Realmente deseja sair?</p>
                </div>
                <form action="./pages/login-page/logout.php" class="modal-actions">
                    <button class="btn-cancel">Cancelar</button>
                    <button class="btn-confirm" type="submit">Sair</button>
                </form>
            </div>
        </div>
        <!-- /Modal -->
    </div>

    <!-- Index JS -->
    <script src="./js/index.js"></script>
</body>

</html>
<?php

// include_once("get-user.php");
// getUser("genUsuario = 'Feminino' and sexUsuario = 'Héterossexual'");

?>

<link rel="stylesheet" href="./pages/home-page/home.css">

<div class="top-bar">
    <h2>Página inicial</h2>
</div>

<div class="filters-container">
    <button class="espiar"><i class="bi bi-eye"></i>Espiar</button>
    <button class="filter"><i class="bi bi-filter"></i>Filtros</button>
    <p class="hashtags">#All</p>
</div>

<div class="home-container">

    <!-- Conteudo principal -->
    <div class="main-content">

        <img src="" alt="Foto de perfil do usuário" class="img">

        <div class="blur"></div>

        <div class="info-container-small">
            <div class="name-age">
                <span class="name-user"></span>
                <span class="age-user"></span>
            </div>
            <p class="bio"></p>
            <div class="hashtags-container"></div>
            <div class="questions"></div>
        </div>

        <div class="btn-action-container">
            <button class="btn-action" id="btn-detona"><i class="bi bi-x-lg"></i></button>
            <button class="btn-action" id="btn-cantada"><i class="bi bi-chat-square-heart-fill"></i></button>
            <button class="btn-action" id="btn-apaixona"><i class="bi bi-suit-heart-fill"></i></button>
            <button class="btn-action" id="btn-other-photo"><i class="bi bi-camera-fill"></i></button>
        </div>
    </div>

    <div class="info-container-big">
        <div class="name-age">
            <span class="name-user"></span>
            <span class="age-user"></span>
        </div>
        <p class="bio"></p>
        <div class="hashtags-container"></div>
        <div class="questions"></div>
    </div>

</div>

<!-- Match Modal -->
<div id="match-modal" style="display: none;"> <!-- Envólucro modal -->
    <!-- Modal -->
    <div class="modal">
        <div class="modal-content">
            <div class="modal-text">
                <div class="close-button"><span class="close">&times;</span></div>
                <h2 id="match-name">Você curtiu </h2>
                <p id="match-text">Uma hora ele(a) te curte também...</p>
            </div>
            <div class="modal-actions">
                <button class="btn-confirm" id="btn-close-match"><i class="bi bi-suit-heart-fill"></i> Ok</button>
            </div>
        </div>
    </div>
    <!-- /Modal -->
</div>

<!-- Cantada Modal -->
<div id="cantada-modal" style="display: none;"> <!-- Envólucro modal -->
    <!-- Modal -->
    <div class="modal">
        <div class="modal-content">
            <div class="modal-text">
                <div class="close-button"><span class="close">&times;</span></div>
                <p id="cantada-text">Escreva uma cantada</p>
                <form id="send-cantada" action="" method="post">
                    <textarea name="cantada" id="cantada" cols="25" rows="5" placeholder="Cantada" required autofocus></textarea>
                </form>
                <small style="color: var(--carmin);">Ao enviar uma cantada você automaticamente curte o usuário</small>
            </div>
            <div class="modal-actions">
                <button class="btn-cancel" id="btn-cancel-cantada">Cancelar</button>
                <button class="btn-confirm" id="btn-send-cantada"><i class="bi bi-send-fill"></i> Enviar</button>
            </div>
        </div>
    </div>
    <!-- /Modal -->
</div>

<script src="./pages/home-page/home.js"></script>
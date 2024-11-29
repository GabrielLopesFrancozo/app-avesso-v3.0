<?php

include("../../database/conection.php");

session_start();

if (!isset($_SESSION["idUsuario"])) {
    echo "Ops, algo deu errado";
} else {
    $idUsuario = $_SESSION["idUsuario"];

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

    // echo
    // "ID: " . $_SESSION["idUsuario"] . " <br>
    // Nome: " . $_SESSION["nomeUsuario"] . " <br>
    // Email: " . $_SESSION["emailUsuario"] . " <br>
    // Senha: " . $_SESSION["senhaUsuario"] . " <br>
    // Data de Nascimento: " . $_SESSION["dataNascUsuario"] . " <br>
    // Status: " . $_SESSION["statusCadUsuario"] . " <br>";
}

?>

<link rel="stylesheet" href="./pages/profile-page/profile.css">

<div class="top-bar">
    <ul class="nav-list nav-bottom nav-up">
        <!-- <li class="nav-item nav-item-up" id="settings">
            <i class="bi bi-gear-fill" data-icon="bi bi-gear" data-icon-filled="bi bi-gear-fill"></i>
            <a class="nav-link">Configurações</a>
        </li> -->
        <h2>Perfil</h2>
        <li class="nav-item nav-item-up" id="logout">
            <i class="bi bi-box-arrow-right"></i>
            <a class="nav-link">Sair</a>
        </li>
    </ul>
</div>

<div class="profile-content">

    <div class="profile-header">
        <img src="./database/users/<?= $userData["fotoPerfilUsuario"] ?>" alt="Foto de perfil" class="profile-photo">
        <div class="profile-info">
            <h2 style="width: 100%; text-align: center;"><?= $_SESSION["nomeUsuario"] ?></h2>
            <p style="width: 100%; text-align: center; "><?= $_SESSION["bioUsuario"] ?></p>
            <div class="tags">
                <?php
                if (!empty($hashtags)) {
                    foreach ($hashtags as $hashtag) {
                        echo "<small>#$hashtag </small>";
                    }
                } else {
                    echo "Sem hashtags.";
                }
                ?>
            </div>
        </div>
        <!-- <button class="edit-photo">✏️</button> -->
    </div>

    <div class="profile-details">

        <div class="swiper">
            <div class="swiper-wrapper">
                <?php
                $sql = "SELECT idPergunta, respostaUsuario FROM tbusuario_responde_pergunta WHERE idUsuario = $idUsuario";
                $result = mysqli_query($conection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql = "SELECT tituloPergunta FROM tbperguntas WHERE idPergunta = " . $row['idPergunta'];
                        $question = mysqli_query($conection, $sql);
                        $data = mysqli_fetch_assoc($question);
                        echo "<div class='swiper-slide'><p>" . $data["tituloPergunta"] . "</p>";
                        echo "<p class='answer'>" . $row["respostaUsuario"] . "</p></div>";
                    }
                }
                ?>
            </div>
            <!-- Paginação -->
            <div class="swiper-pagination swiper-pagination-clicks swiper-pagination-bullets"></div>
        </div>

    </div>

    <div class="photo-gallery">
        <div class="buttons-container">
            <button id="btn-open-photo-modal" class="add-photo"><i class="bi bi-camera-fill"></i> Adicionar foto</button>
            <!-- <button class="edit-profile"><i class="bi bi-pencil-fill"></i> Editar perfil</button> -->
        </div>
        <div class="photo-grid">
            <?php
            $sql = "SELECT * FROM tbfotos_usuarios WHERE idUsuario = " . $_SESSION["idUsuario"];

            $result = mysqli_query($conection, $sql);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='photo-wrapper'><img class='photo' id='" . $row["nomeArquivoFoto"] . "' src='./database/users/profiles/" . $row["nomeArquivoFoto"] . "'></div>";
                }
            }
            ?>
        </div>
    </div>

    <div id="add-photo-modal" style="display: none;">
        <div class="modal">
            <div class="modal-content">
                <div class="close-button"><span class="close">&times;</span></div>
                <form id="form-photo" action="" class="form">
                    <label for="input-add-photo" id="btn-add-photo">
                        <i class="add-photo-icon bi bi-plus"></i>
                        <div id="preview-img-container"></div>
                    </label>
                    <input type="file" id="input-add-photo" name="images[]" accept="image/*" style="display: none;">

                    <div class="modal-actions">
                        <button class="btn-cancel">Cancelar</button>
                        <button class="btn-confirm" id="btn-send-photo" type="submit">Adicionar <i class="bi bi-send-fill"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="view-photo-modal" style="display: none;">
        <div class="modal">
            <div class="modal-content">
                <div class="close-button"><span class="close">&times;</span></div>
                <img src="" alt="Foto do usuário" class="photo" id="photo-inside-modal">
                <div class="modal-actions">
                    <button class="btn-cancel">Cancelar</button>
                    <button class="btn-confirm" id="btn-delete-photo" type="submit">Deletar <i class="bi bi-trash-fill"></i></button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="./pages/profile-page/profile.js"></script>
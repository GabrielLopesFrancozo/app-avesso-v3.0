<?php

include("../../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

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
    <link rel="stylesheet" href="../../../../styles/components/progress-bar.css"> <!-- Progress bar -->
    <!-- Local CSS -->
    <link rel="stylesheet" href="criar-perfil.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <script src="../../../js/vendor/jquery-3.7.1.js"></script>
    <script src="../../../js/vendor/jquery.form.js"></script>

    <!-- Main -->
    <main class="main">

        <div class="tutorial">
            <div class="tutorial-content">
                <img class="img" src="../../../assets/imgs/characters.png" alt=""><br>
                <h3 class="title">Bem vindo(a) <?php echo ucfirst(explode(' ', $data["nomeUsuario"])[0]); ?></h3>
                <label class="text">Conheça novas pessoas e descubra quem está por trás da tela. <p style='margin-top: 1rem; color: var(--carmin);'> Não julgue um livro pela capa!</p></label><br>
                <a class="button" id="next-tutorial">Próximo <i class="bi bi-arrow-up-right"></i></a>
                <a class="button" id="close-tutorial">Vamos lá</a>
            </div>
        </div>

        <!-- Progress bar -->
        <div class="progress-bar">
            <div class="progress-step first">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span><?= $data["fotoPerfilUsuario"] == "" ? "1" : "<i class='bi bi-check' style='font-size: 1.5rem'></i>" ?></span>
                </div>
            </div>
            <div class="progress-step second disabled">
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
        <!-- /Progress bar -->

        <!-- Container -->
        <div class="container">

            <?php
            if ($data["fotoPerfilUsuario"] == "" || !file_exists('../../../database/users/' . $data["fotoPerfilUsuario"])) {
                $nomeFoto = "default-profile-pic.png";
            } else {
                $nomeFoto = $data["fotoPerfilUsuario"];
            }
            ?>
            <div id="editar-foto">
                <p style="text-align: center; color: var(--gray-700); font-weight: bold; margin-bottom: 10px;"><span><?= $data["fotoPerfilUsuario"] == "" ? "<span style='font-weight: bold; color: var(--carmin);'>Adicionar</span> foto" : "<span style='font-weight: bold; color: var(--carmin);'>Editar</span> foto" ?></span></p>
                <form id="form-upload-foto" method="post" action="" enctype="multipart/form-data">
                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?= $idUsuario ?>">
                    <div class="input-group">
                        <label class="picture <?php echo $data["fotoPerfilUsuario"] != "" && file_exists('../../../database/users/' . $data["fotoPerfilUsuario"]) ? "no-border" : "" ?>" for="picture__input" tabIndex="0">
                            <span class="picture__image">
                                <i class="bi bi-camera-fill"></i>
                                <i class="change-icon bi bi-upload"></i>
                                <div class="black-filter"></div>
                                <img class="picture__img" <?= $data["fotoPerfilUsuario"] != "" && file_exists('../../../database/users/' . $data["fotoPerfilUsuario"]) ? "src='../../../database/users/" . $data["fotoPerfilUsuario"] . "'" : "" ?> alt="">
                            </span>
                        </label>
                        <input type="file" name="arquivo" id="picture__input">
                        <button class="button" id="btn-enviar-foto" type="submit">Enviar <i class='bi bi-send-fill'></i></button>
                    </div>
                </form>

                <div class="message-container">
                    <div id="mensagem" class="message success">
                        <span class="message-text"><!-- Mensagem dinamicamente carregada --></span>
                    </div>
                </div>
            </div>
        </div>

        <footer class='bottom-container'>
            <a
                <?php
                if ($data["fotoPerfilUsuario"] != "" || file_exists('../../img/fotos-usuarios/' . $data["fotoPerfilUsuario"])) {
                    echo "href='criar-perfil-3.php' class='link active'";
                } else {
                    echo "class='link'";
                }
                ?>>Próximo <i class="bi bi-arrow-right"></i></a>
        </footer>
    </main>

    <script src="criar-perfil.js"></script>
</body>

</html>
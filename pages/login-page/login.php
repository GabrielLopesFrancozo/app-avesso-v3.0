<?php

include("../../database/conection.php");

session_start();
session_destroy();

if (isset($_POST["emailUsuario"]) && !empty($_POST["emailUsuario"]) && isset($_POST["senhaUsuario"]) && !empty($_POST["senhaUsuario"])) {

    $emailUsuario = $_POST["emailUsuario"];
    $senhaUsuario = hash('sha256', $_POST["senhaUsuario"]);

    $sql = "SELECT idUsuario, statusCadUsuario FROM tbusuarios WHERE emailUsuario = '$emailUsuario' AND senhaUsuario = '$senhaUsuario'";
    $result = mysqli_query($conection, $sql);

    // Verifica se o usuário existe
    if (mysqli_num_rows($result) > 0) {

        $data = mysqli_fetch_assoc($result);

        session_start();
        $_SESSION["idUsuario"] = $data["idUsuario"]; // Salva o ID do usuário na sessão

        // Verifica se o cadastro está completo
        if ($data["statusCadUsuario"] != 6) {
            // Retorna a URL para a página de criação de perfil
            echo "./criar-perfil/criar-perfil-" . $data['statusCadUsuario'] . ".php";
            exit;
        } else {
            // Retorna a URL para a splash screen
            echo "../splash-screen/splash.php";
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Login | Avesso</title>
    <link rel="shortcut icon" type="image/svg" href="../../assets/imgs/favicon.ico" />
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/components/input.css">
    <link rel="stylesheet" href="./login-signup.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Jquery -->
    <script src="../../js/vendor/jquery-3.7.1.js"></script>
    <script src="../../js/vendor/jquery.form.js"></script>

    <div class="main-container">
        <img id="phone-example" src="../../assets/imgs/mobile-example.svg" alt="App in a phone example">
        <div class="card">
            <img id="logo" src="../../assets/imgs/logo.svg" alt="Avesso - Logo do app">
            <form class="registration-form" id="form-login" action="login.php" method="post">
                <span class="text">Entrar com email e senha</span>
                <div class="area-input">
                    <div class="input-group">
                        <input class="input" name="emailUsuario" type="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <input class="input" name="senhaUsuario" type="password" placeholder="Senha" required>
                    </div>
                    <div class="error">
                        <span class="text-error" style="display: none;">Email ou senha incorretos!</span>
                    </div>
                </div>

                <input class="button" id="btn-login" type="submit" value="Entrar">
            </form>

            <span class="link-wrapper"><span>Não possui uma conta?</span><a class="link" href="signup.php"> Cadastre-se</a></span>
        </div>
    </div>

    <script src="./login.js"></script>
</body>

</html>
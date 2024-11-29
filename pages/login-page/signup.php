<?php

include("../../database/conection.php");

// Verifica se o usuário realizou o envio do formulário
if (isset($_POST["nomeUsuario"]) && isset($_POST["emailUsuario"]) && isset($_POST["senhaUsuario"]) && isset($_POST["dataNascUsuario"]) && isset($_POST["idPaisUsuario"]) && isset($_POST["cidadeUsuario"])) {

    $dataNascUsuario = $_POST["dataNascUsuario"];
    $idade = calcularIdade($dataNascUsuario);

    if ($idade >= 18) {

        $idPaisUsuario = $_POST["idPaisUsuario"];
        $cidadeUsuario = $_POST["cidadeUsuario"];

        if ($idPaisUsuario !== "-" && $cidadeUsuario !== "-") {

            $emailUsuario = $_POST["emailUsuario"];
            $senhaUsuario = hash('sha256', $_POST["senhaUsuario"]);
            $nomeUsuario = $_POST["nomeUsuario"];
            $dataNascUsuario = $_POST["dataNascUsuario"];

            // Procura se o usuário existe no banco de dados
            $sql = "SELECT emailUsuario FROM tbusuarios WHERE emailUsuario = '$emailUsuario'";
            $resultado = mysqli_query($conection, $sql);

            // Verifica se o usuário já possui cadastro
            if (mysqli_num_rows($resultado) > 0) {
                echo "
                <script src='../../js/vendor/jquery-3.7.1.js'></script>
                <script>
                    $(document).ready(function() {
                        // Mostra o aviso
                        $('#emailError').show();
                    });
                </script>
                ";
            } else {
                // Insere o usuário no banco de dados
                $sql = "INSERT INTO tbusuarios (nomeUsuario, emailUsuario, senhaUsuario, dataNascUsuario, idPaisUsuario, cidadeUsuario) VALUES ('$nomeUsuario', '$emailUsuario', '$senhaUsuario', '$dataNascUsuario', '$idPaisUsuario', '$cidadeUsuario')";
                $resultado = mysqli_query($conection, $sql);

                // Cria uma sessão para o usuário
                $sql = "SELECT idUsuario, statusCadUsuario FROM tbusuarios WHERE emailUsuario = '$emailUsuario'";
                $resultado = mysqli_query($conection, $sql);
                $dados = mysqli_fetch_assoc($resultado);

                session_start();
                $_SESSION["idUsuario"] = $dados["idUsuario"];

                if ($resultado) {
                    // Atualiza o status de cadastro para 1
                    $sql = "UPDATE tbusuarios SET statusCadUsuario = 1 WHERE idUsuario = $dados[idUsuario]";
                    $resultado = mysqli_query($conection, $sql);

                    header("Location: criar-perfil/criar-perfil-1.php");
                } else {
                    echo "Erro ao cadastrar usuário";
                }
            }
        } else {
            echo "
            <script src='../../js/vendor/jquery-3.7.1.js'></script>
            <script>
                $(document).ready(function() {
                    // Mostra o aviso
                    $('#selectError').show();
                });
            </script>
            ";
        }
    } else {
        echo "
        <script src='../../js/vendor/jquery-3.7.1.js'></script>
        <script>
            $(document).ready(function() {
                // Mostra o aviso
                $('#idadeError').show();
            });
        </script>
        ";
    }
} else {
    $_POST["emailUsuario"] = "";
    $_POST["senhaUsuario"] = "";
    $_POST["nomeUsuario"] = "";
    $_POST["dataNascUsuario"] = "";
    $_POST["idPaisUsuario"] = "";
    $_POST["cidadeUsuario"] = "";
}

function calcularIdade($dataNascUsuario)
{
    $dataNasc = new DateTime($dataNascUsuario);
    $hoje = new DateTime();
    $idade = $hoje->diff($dataNasc);
    return $idade->y;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Avesso</title>
    <link rel="shortcut icon" type="image/svg" href="../../assets/imgs/favicon.ico" />
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/components/input.css">
    <link rel="stylesheet" href="../login-page/login-signup.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="main-container">
        <div class="card" id="registration">
            <form action="signup.php" method="post" class="registration-form">
                <span class="text">Cadastrar-se</span>
                <div class="area-input">
                    <input
                        class="input"
                        id="emailUsuario"
                        name="emailUsuario"
                        type="email"
                        placeholder="Email"
                        value="<?= $_POST["emailUsuario"]; ?>"
                        required>
                    <input
                        class="input"
                        id="senhaUsuario"
                        name="senhaUsuario"
                        type="password"
                        placeholder="Senha"
                        value="<?= $_POST["senhaUsuario"]; ?>"
                        required>
                    <input
                        class="input"
                        id="nomeUsuario"
                        name="nomeUsuario"
                        type="text"
                        placeholder="Nome completo"
                        value="<?= $_POST["nomeUsuario"]; ?>"
                        required>
                    <input
                        class="input"
                        id="dataNascUsuario"
                        name="dataNascUsuario"
                        type="text"
                        placeholder="Data de nascimento"
                        value="<?= $_POST["dataNascUsuario"] ?? ''; ?>"
                        onfocus="this.type='date'"
                        onblur="this.type='text'"
                        required>
                    <select
                        class="input"
                        id="idPaisUsuario"
                        name="idPaisUsuario">
                        <option value="<?= strval($_POST["idPaisUsuario"]) != "" ? strval($_POST["idPaisUsuario"]) : "-" ?>">
                            <?php
                            if (strval($_POST["idPaisUsuario"]) != "") {
                                switch (strval($_POST["idPaisUsuario"])) {
                                    case 1:
                                        echo "Brasil";
                                        break;
                                    case 2:
                                        echo "USA";
                                        break;
                                    case 3:
                                        echo "Afeganistão";
                                        break;
                                }
                            } else {
                                echo "Pais";
                            }
                            ?>
                        </option>
                        <option value="1">Brasil</option>
                        <option value="2">USA</option>
                        <option value="3">Afeganistão</option>
                    </select>
                    <select
                        class="input"
                        id="cidadeUsuario"
                        name="cidadeUsuario">
                        <option value="<?= strval($_POST["cidadeUsuario"]) != "" ? strval($_POST["cidadeUsuario"]) : "-" ?>">
                            <?php
                            if (strval($_POST["cidadeUsuario"]) != "") {
                                echo strval($_POST["cidadeUsuario"]);
                            } else {
                                echo "Cidade";
                            }
                            ?>
                        </option>
                        <option value="Campinas">Campinas</option>
                        <option value="New York">New York</option>
                        <option value="Jalalabad">Jalalabad</option>
                    </select>

                    <div class="error" id="idadeError" style="display: none;">
                        <span>Você deve ter pelo menos 18 anos para se cadastrar!</span>
                    </div>

                    <div class="error" id="emailError" style="display: none;">
                        <span>Usuário ja cadastrado!</span>
                    </div>

                    <div class="error" id="selectError" style="display: none;">
                        <span>Preencha todos os campos!</span>
                    </div>

                </div>

                <input class="button" type="submit" value="Continuar">
            </form>

            <div class="link-container">
                <span class="link-wrapper">Já possui uma conta?<a class="link" href="login.php"> Conecte-se</a></span>
                <span class="termos">Ao continuar você concorda com nossos <a class="link" href="terms.php">Termos e condições</a></span>      
            </div>
        </div>
    </div>
</body>

</html>
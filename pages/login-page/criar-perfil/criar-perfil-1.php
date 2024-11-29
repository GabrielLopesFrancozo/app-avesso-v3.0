<?php

include("../../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

$sql = "SELECT * FROM tbusuarios WHERE idUsuario = $idUsuario";
$resultado = mysqli_query($conection, $sql);
$dados = mysqli_fetch_assoc($resultado);

if ($dados["genUsuario"] != "" && $dados["sexUsuario"] != "" && $dados["prefUsuario"] != "") {
    header("Location: criar-perfil-2.php");
} elseif (isset($_POST["sexUsuario"]) && isset($_POST["genUsuario"]) && isset($_POST["prefUsuario"])) {

    if ($_POST["sexUsuario"] != "-" && $_POST["genUsuario"] != "-" && $_POST["prefUsuario"] != "-") {

        $sexUsuario = $_POST["sexUsuario"];
        $genUsuario = $_POST["genUsuario"];
        $prefUsuario = $_POST["prefUsuario"];

        $sql = "UPDATE tbusuarios SET sexUsuario = '$sexUsuario', genUsuario = '$genUsuario', prefUsuario = '$prefUsuario', statusCadUsuario = 2 WHERE idUsuario = $idUsuario";
        $resultado = mysqli_query($conection, $sql);

        if ($resultado) {
            header("Location: criar-perfil-2.php");
        }
    } else {
        echo "
        <script src='../../../js/vendor/jquery-3.7.1.js'></script>
        <script>
            $(document).ready(function() {
                // Mostra o aviso
                $('#selectError').show();
            });
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Avesso</title>
    <link rel="shortcut icon" type="image/svg" href="../../../assets/imgs/favicon.ico" />
    <link rel="stylesheet" href="../../../styles/global.css">
    <link rel="stylesheet" href="../../../styles/components/input.css">
    <link rel="stylesheet" href="../login-signup.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="main-container">
        <div class="card" id="registration">
            <form action="criar-perfil-1.php" method="post" class="registration-form">
                <h3>Informações pessoais</h3>
                <div class="area-input">
                    <select class="input" name="sexUsuario" id="sexUsuario">
                        <option value="-">Sexualidade</option>
                        <option value="Héterossexual">Héterossexual</option>
                        <option value="Homossexual">Homossexual</option>
                        <option value="Bissexual">Bissexual</option>
                        <option value="Outro">Outro</option>
                        <option value="Prefiro não informar">Prefiro não informar</option>
                    </select>
                    <select class="input" name="genUsuario" id="genUsuario">
                        <option value="-">Genero</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Outro">Outro</option>
                        <option value="Prefiro não informar">Prefiro não informar</option>
                    </select>
                    <select class="input" name="prefUsuario" id="prefUsuario">
                        <option value="-">Preferência</option>
                        <option value="Homem">Homem</option>
                        <option value="Mulher">Mulher</option>
                        <option value="Sem preferência">Sem preferência</option>
                    </select>

                    <div class="error" id="selectError" style="display: none;">
                        <span>Preencha todos os campos!</span>
                    </div>

                </div>

                <input class="button" type="submit" value="Continuar">
            </form>
        </div>
    </div>
</body>

</html>
<?php
include("../../../database/conection.php");

session_start();
$idUsuario = $_SESSION["idUsuario"];

$response = ["status" => "error", "message" => "Erro desconhecido"];

// Caso o formulário seja enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["tituloHashtag"])) {
    $tituloHashtag = str_replace("#", "", trim($_POST["tituloHashtag"])); // Remove "#" e espaços extras

    if (!empty($tituloHashtag)) {
        // Verifica se a hashtag já existe para o usuário
        $sql = "SELECT idHashtag FROM tbhashtags WHERE idUsuario = ? AND tituloHashtag = ?";
        $stmt = $conection->prepare($sql);
        $stmt->bind_param("is", $idUsuario, $tituloHashtag);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response["message"] = "Hashtag já existente";
        } else {
            // Insere a nova hashtag
            $sql = "INSERT INTO tbhashtags (idUsuario, tituloHashtag) VALUES (?, ?)";
            $stmt = $conection->prepare($sql);
            $stmt->bind_param("is", $idUsuario, $tituloHashtag);

            if ($stmt->execute()) {
                // Atualiza o status do usuário
                $sql = "UPDATE tbusuarios SET statusCadUsuario = 5 WHERE idUsuario = ?";
                $stmt = $conection->prepare($sql);
                $stmt->bind_param("i", $idUsuario);
                $stmt->execute();

                $response["status"] = "success";
                $response["message"] = "Adicione mais hashtags";

                // Retorna todas as hashtags atualizadas
                $sql = "SELECT tituloHashtag FROM tbhashtags WHERE idUsuario = ?";
                $stmt = $conection->prepare($sql);
                $stmt->bind_param("i", $idUsuario);
                $stmt->execute();
                $result = $stmt->get_result();

                $hashtags = [];
                while ($row = $result->fetch_assoc()) {
                    $hashtags[] = $row["tituloHashtag"];
                }
                $response["hashtags"] = $hashtags;
            } else {
                $response["message"] = "Erro ao adicionar a hashtag.";
            }
        }
    } else {
        $response["message"] = "Hashtag inválida.";
    }

    // Retorna a resposta como JSON
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

// Busca inicial para exibir hashtags ao carregar a página
$sql = "SELECT tituloHashtag FROM tbhashtags WHERE idUsuario = ?";
$stmt = $conection->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

$hashtags = [];
while ($row = $result->fetch_assoc()) {
    $hashtags[] = $row["tituloHashtag"];
}

$slq = "SELECT * FROM tbusuarios WHERE idUsuario = $idUsuario";
$result = mysqli_query($conection, $slq);
$userData = mysqli_fetch_assoc($result);

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
    <link rel="stylesheet" href="../../../../styles/components/modal.css">
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
            <div class="progress-step fourth disabled">
                <div class="rectangle">
                    <div class="light"></div>
                </div>
                <div class="circle">
                    <span class="step">4</span>
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
            </div>

            <div class="add-info-container">
                <p style="text-align: center; color: var(--gray-700); font-weight: bold; margin-bottom: 10px;">Adicione algumas <span style='font-weight: bold; color: var(--carmin);'>hashtags</span> de coisas que você gosta</p>
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
                <form class="form" id="hashtag-form" method="post">
                    <div class="send-messages-container">
                        <div class="messageBox">
                            <input
                                required
                                placeholder="Ex: Viajar"
                                name="tituloHashtag"
                                type="text"
                                id="message-input"
                                autocomplete="off" />
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
                </form>
            </div>
        </div>

        <footer class='bottom-container'>
            <a
                <?php
                if (!empty($hashtags)) {
                    echo "href='criar-perfil-5.php' class='link active'> Próximo ";
                } else {
                    echo "class='link active' id='skip'> Pular ";
                }
                ?><i class="bi bi-arrow-right"></i></a>
        </footer>

        <div class="modal-conatainer">
            <div id="logoutModal" class="modal">
                <div class="modal-content">
                    <div class="modal-text">
                        <div class="close-button"><span class="close">&times;</span></div>
                        <h2>Pular etapa?</h2>
                        <p>Ao pular esta etapa você dificulta a filtragem do seu perfil para outros usuários.</p>
                    </div>
                    <form action="criar-perfil-5.php" class="modal-actions">
                        <button class="btn-cancel">Cancelar</button>
                        <button class="btn-confirm" type="submit">Pular</button>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script src="criar-perfil.js"></script>
</body>

</html>
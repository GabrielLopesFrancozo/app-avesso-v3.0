<?php

include("../../database/conection.php");

session_start();

$idUsuario = $_SESSION["idUsuario"];

// Consulta com JOIN para verificar matches bidirecionais e contar mensagens não visualizadas
$sql = "
SELECT 
    u.idUsuario, 
    u.nomeUsuario, 
    u.fotoPerfilUsuario, 
    COALESCE((
        SELECT COUNT(m.idMsg)
        FROM tbmensagens AS m
        WHERE m.idRemetente = u.idUsuario 
          AND m.idDestinatario = $idUsuario
          AND m.msgVisualizada = 0
    ), 0) AS naoVisualizadas
FROM 
    tbusuarios AS u
WHERE 
    u.idUsuario IN (
        SELECT DISTINCT mt1.idUsuarioMatch
        FROM tbmatches AS mt1
        JOIN tbmatches AS mt2 ON mt1.idUsuarioMatch = mt2.idUsuario AND mt1.idUsuario = mt2.idUsuarioMatch
        WHERE mt1.idUsuario = $idUsuario
    )
ORDER BY 
    u.nomeUsuario ASC;";


$result = mysqli_query($conection, $sql);

?>

<link rel="stylesheet" href="./pages/chat-page/chat.css">

<div class="chat-container">
    <div class="contacts-container">
        <div class="page-title">
            <h2>Contatos</h2>
        </div>
        <div class="search-input-container">
            <input class="search-input" type="text" placeholder="Buscar contatos...">
        </div>
        <div class="filter-container">
            <button class="chat-filter"><i class="bi bi-people-fill"></i> Tudo</button>
            <button class="chat-filter"><i class="bi bi-eye-slash"></i> Não lidas</button>
            <button class="chat-filter"><i class="bi bi-bookmarks"></i> Favoritas</button>
        </div>
        <div class="chats-container">
            <?php
            // Verifica se há resultados
            if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_assoc($result)) {
                    // Exibe os contatos com dados do usuário correspondente
                    $naoVisualizadas = $data["naoVisualizadas"]; // Mensagens não visualizadas
                    echo "
            <div class='chat' 
                id='" . $data["idUsuario"] . "' 
                data-nome='" . $data["nomeUsuario"] . "' 
                data-foto='../../database/users/" . $data["fotoPerfilUsuario"] . "'>

                <div class='contact-user-profile'>
                    <div class='blur-filter'>
                        <img class='user-photo' src='../../database/users/" . $data["fotoPerfilUsuario"] . "' alt='Foto do Usuário'>
                    </div>
                </div>

                <div class='contact-message-container'>
                    <span>" . $data["nomeUsuario"] . "</span>
                </div>

                ";

                    // Exibe a contagem apenas se houver mensagens não visualizadas
                    if ($naoVisualizadas > 0) {
                        echo "
                        <div class='contact-message-notification'>
                            <label>$naoVisualizadas</label>
                        </div>";
                    }
                    echo "
            </div>";
                }
            } else {
                echo "<span style='text-align: center; color: var(--gray-700); font-weight: bold; margin-top: 10px;'>Nenhum contato ainda.</span>";
            }
            ?>
        </div>
    </div>

    <div class="messages-main" style="display: none;">
        <div class="top-bar">
            <button id="btn-back"><i class="bi bi-arrow-left"></i></button>
            <div class="contact-user-profile">
                <div class='blur-filter'>
                    <img class="user-photo" id="foto-usuario-match" src="" alt="Foto do Usuário">
                </div>
            </div>
            <p id="nome-usuario-match"></p>
        </div>
        <div class="messages-container">

        </div>
        <form id="form-send-message" action="" method="post">
            <!-- Campo escondido com o ID do destinatário -->
            <input type="hidden" name="id-destinatario" id="id-destinatario">
            <input type="hidden" name="id-remetente" id="id-remetente" value="<?php echo $idUsuario ?>">

            <div class="send-messages-container">
                <div class="messageBox">
                    <!-- Campo de texto para a mensagem -->
                    <input
                        required
                        placeholder="Digite uma mensagem"
                        type="text"
                        id="message-input"
                        name="message-input"
                        autocomplete="off" />
                    <!-- Botão de enviar -->
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

<script src="./pages/chat-page/chat.js"></script>
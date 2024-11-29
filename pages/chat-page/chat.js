// Verifica se as variaveis existem
if (!idRemetente || !idUsuarioMatch || !nomeUsuarioMatch || !fotoPerfil) {
  var idRemetente = $("#id-remetente").val();
  var idUsuarioMatch;
  var nomeUsuarioMatch;
  var fotoPerfil;
}

// Esconde o chat inicialmente
$(".messages-main").hide();

// Evento de clique no contato
$(".chat").click(function () {
  // Obtém os dados do contato selecionado
  idRemetente = $("#id-remetente").val();
  idUsuarioMatch = $(this).attr("id");
  nomeUsuarioMatch = $(this).attr("data-nome");
  fotoPerfil = $(this).attr("data-foto");

  // Atualiza os campos e exibe o chat
  $("#id-destinatario").val(idUsuarioMatch); // Atualiza o ID do destinatário
  $("#foto-usuario-match").attr("src", fotoPerfil);
  $("#nome-usuario-match").html(nomeUsuarioMatch);
  $(".messages-main").show();

  // Limpa o container de mensagens
  $(".messages-container").html("");

  // Atualiza o ID do destinatário globalmente
  localStorage.setItem("idUsuarioMatch", idUsuarioMatch);

  $.ajax({
    url: "./pages/chat-page/update-msg-seen.php", // URL do arquivo PHP
    type: "POST",
    data: {
      idRemetente: idRemetente,
      idDestinatario: idUsuarioMatch,
    },
    dataType: "json",
    success: function (response) {
      if (response.success) {
        console.log("Mensagens marcadas como visualizadas.");
      } else {
        console.error("Erro ao marcar mensagens:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro ao atualizar mensagens:", xhr.responseText || error);
    },
  });

  // Reinicia a busca de mensagens
  lastMessageTimestamp = null; // Reseta o timestamp para evitar cache
  fetchMessages(localStorage.getItem("idUsuarioMatch"), idRemetente); // Chama a função de busca imediatamente
});

// Submissão do formulário com AJAX - Enviar mensagem
$("#btn-send-message").on("click", function (event) {
  event.preventDefault(); // Evita o envio padrão do formulário

  let formData = $("#form-send-message").serialize(); // Serializa os dados do formulário

  $.ajax({
    url: "./pages/chat-page/insert-msgs.php", // URL para o PHP
    type: "POST",
    data: formData, // Envia os dados serializados
    success: function (response) {
      console.log("Mensagem enviada com sucesso:", response);
      $("#message-input").val(""); // Limpa o campo de entrada

      // Atualiza as mensagens após o envio
      let idDestinatario = $("#id-destinatario").val();
      fetchMessages(idDestinatario, idRemetente);
    },
    error: function (xhr, status, error) {
      console.error("Erro ao enviar a mensagem:", error);
    },
  });
});

// Long-polling para buscar mensagens
if (!lastMessageTimestamp) {
  var lastMessageTimestamp = null; // Armazena o timestamp da última mensagem
}

function fetchMessages(idDestinatario, idRemetente) {
  // Verifica se a página atual é a página de chat
  if (localStorage.getItem("lastPage") !== "chat") {
    return; // Sai da função se a página não for o chat
  }

  if (!idDestinatario) {
    return; // Não busca mensagens se nenhum destinatário estiver selecionado
  }

  $.ajax({
    url: "./pages/chat-page/fetch-messages.php", // URL para buscar mensagens
    type: "POST",
    data: { idDestinatario: idDestinatario },
    dataType: "json",
    success: function (response) {
      if (response.error) {
        console.error(response.error);
        return;
      }

      if (response.length > 0) {
        let latestMessage = response[response.length - 1];
        let latestTimestamp = new Date(latestMessage.dataEnvio).getTime();

        // Atualiza apenas se houver novas mensagens
        if (
          lastMessageTimestamp === null ||
          latestTimestamp > lastMessageTimestamp
        ) {
          lastMessageTimestamp = latestTimestamp;

          // Insere as mensagens no container
          $(".messages-container").html(""); // Limpa mensagens antigas
          response.forEach((message) => {
            const isOwnMessage = message.idRemetente == idRemetente; // Compara IDs
            const messageClass = isOwnMessage
              ? "own-message"
              : "received-message";

            $(".messages-container").append(`
                  <div class="message ${messageClass}">
                    <span>${message.conteudoMsg}</span>
                    <small>${new Date(
                      message.dataEnvio
                    ).toLocaleTimeString()}</small>
                  </div>
                `);
          });

          // Desloca para o fim do container
          $(".messages-container").scrollTop(
            $(".messages-container")[0].scrollHeight
          );
        }
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro ao buscar mensagens:", xhr.responseText);
    },
    complete: function () {
      // Repetição do long-polling com os mesmos argumentos
      setTimeout(
        () =>
          fetchMessages(localStorage.getItem("idUsuarioMatch"), idRemetente),
        2000
      );
    },
  });
}

// Inicializa a busca de mensagens apenas se lastPage for "chat"
if (localStorage.getItem("lastPage") === "chat") {
  fetchMessages(localStorage.getItem("idUsuarioMatch"), idRemetente);
}

$("#btn-back").on("click", function () {
  $(".messages-main").hide();
});

function updateNotifications() {

  // Verifica se a página atual é a página de chat
  if (localStorage.getItem("lastPage") !== "chat") {
    return; // Sai da função se a página não for o chat
  }

  $.ajax({
    url: "./pages/chat-page/fetch-notifications.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
      if (response.error) {
        console.error("Erro do servidor:", response.error);
        return;
      }

      // Percorre os usuários retornados e atualiza o DOM
      response.forEach((user) => {
        const userId = user.idUsuario;
        const naoVisualizadas = user.naoVisualizadas;

        // Verifica se o elemento do contato já existe
        const chatElement = $(`.chat[id='${userId}']`);
        if (chatElement.length > 0) {
          // Atualiza ou insere a notificação de mensagens não visualizadas
          const notificationElement = chatElement.find(
            ".contact-message-notification"
          );

          if (naoVisualizadas > 0) {
            if (notificationElement.length > 0) {
              // Atualiza o valor da notificação
              notificationElement.find("label").text(naoVisualizadas);
            } else {
              // Cria o elemento de notificação se não existir
              chatElement.append(`
                <div class="contact-message-notification">
                  <label>${naoVisualizadas}</label>
                </div>
              `);
            }
          } else {
            // Remove a notificação se não houver mensagens não visualizadas
            notificationElement.remove();
          }
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Erro ao buscar notificações:", xhr.responseText || error);
    },
  });
}

// Atualiza as notificações a cada 5 segundos
setInterval(updateNotifications, 1000);

// Inicializa a atualização de notificações ao carregar a página
updateNotifications();

// // Função para marcar mensagens como visualizadas
// function updateMessageSeen() {
//   //Verifica se a .messages-main esta escondida ou não
//   if (!$(".messages-main").is(":hidden")) {
//     $.ajax({
//       url: "./pages/chat-page/update-msg-seen.php", // URL do arquivo PHP
//       type: "POST",
//       data: {
//         idRemetente: idRemetente,
//         idDestinatario: idUsuarioMatch,
//       },
//       dataType: "json",
//       success: function (response) {
//         if (response.success) {
//           console.log("Mensagens marcadas como visualizadas.");
//         } else {
//           console.error("Erro ao marcar mensagens:", response.error);
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error(
//           "Erro ao atualizar mensagens:",
//           xhr.responseText || error
//         );
//       },
//     });
//   }
// }

// setInterval(updateMessageSeen, 1000);

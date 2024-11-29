$("#btn-notification").on("click", function () {
  $("#notification-modal").show();
});

$("#btn-voltar").on("click", function (e) {
  e.preventDefault();

  $("#notification-modal").hide();
});

// Precisa mexer aqui --------------------------------------->

function fetchNotifications() {
  // Verifica se a página atual é a página de notifications
  if (localStorage.getItem("lastPage") !== "notifications") {
    return; // Sai da função se a página não for o notifications
  }

  $.ajax({
    url: "./pages/notifications-page/get-notifications.php",
    type: "POST",
    dataType: "json",
    success: function (response) {
      console.log(response);

      if (response.success) {
        $(".notification-container").html("");

        let notifications = response.data;

        // Verifica se não existem notificações
        if (notifications.length === 0) {
          $(".notification-container").append(
            '<div class="notification><p class="notification-text" <span style="text-align: center; color: var(--gray-700); font-weight: bold; margin-top: 10px;">Nenhuma notificação ainda.</p></div>'
          );
        } else {
          notifications.forEach((notification, index) => {
            // Formata a data para exibir apenas a parte da data
            let date = new Date(notification.dataCantada);
            let formattedDate = date.toLocaleDateString("pt-BR"); // Formato de data para Brasil

            let notificationBox = `
              <div class="notification" data-index="${index}">
                <div class="notification-content">
                  <div class="profile-photo">
                    <div class="blur">
                      <img src="./database/users/${notification.remetenteFoto}" alt="Foto de perfil">
                    </div>
                  </div> 
                  <div class="notification-text">
                    <strong>${notification.remetenteNome} <p>Enviou uma cantada para você</p></strong>
                    <p>${notification.conteudoCantada}</p>
                  </div>
                </div>
                <div class="time">${formattedDate}</div>
              </div>`;
            $(".notification-container").append(notificationBox);
          });
        }

        // Configura o evento de clique para exibir o modal com a cantada completa
        $(".notification-content").on("click", function () {
          const index = $(this).closest(".notification").data("index");
          const notification = notifications[index];

          let modalContent = `
              <div class="modal">
                <div class="modal-content">
                  <div class="modal-text">
                    <div class="close-button"><span class="close">&times;</span></div>
                    <strong id="show-cantada-text">${notification.remetenteNome} diz:</strong>
                    <p id="show-cantada-content">${notification.conteudoCantada}</p>
                  </div>
                  <div class="modal-actions">
                    <button class="btn-cancel close">Cancelar</button>
                    <button class="btn-confirm" id="btn-send-show-cantada"><i class="bi bi-suit-heart-fill"></i> Match</button>
                  </div>
                </div>
              </div>`;

          $("#show-cantada-modal").html(modalContent);
          $("#show-cantada-modal").show();

          // Configura o botão de fechar modal
          $(".close").on("click", function () {
            $("#show-cantada-modal").hide();
          });

          $("#btn-send-show-cantada").on("click", function (e) {
            e.preventDefault();

            idUsuario = $("#idUsuario-session").text();
            idUsuarioMatch = notification.remetenteId;

            console.log(idUsuario, idUsuarioMatch);

            // Envia os dados para inserir o match no banco de dados
            $.ajax({
              url: "./pages/home-page/insert-match.php",
              type: "POST",
              data: {
                idUsuario: idUsuario,
                idUsuarioMatch: idUsuarioMatch,
              },
              dataType: "json", // Espera uma resposta JSON do servidor
              success: function (response) {
                if (response.success) {
                  console.log("Match inserido com sucesso!");
                  $("#show-cantada-text").text("É um Match!");
                  $("#show-cantada-content").text(
                    "Você conseguiu um match com " + notification.remetenteNome
                  );
                  $("#btn-send-show-cantada").hide();
                } else {
                  console.error("Erro ao inserir match:", response.error);
                }
              },
              error: function (xhr, status, error) {
                console.error(
                  "Erro na requisição AJAX:",
                  xhr.responseText || error
                );
                $("#show-cantada-text").text("Ops...");
                $("#show-cantada-content").text(
                  "Você já possui um match com " + notification.remetenteNome
                );
              },
            });
          });
        });
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro ao obter notificações:", error);
    },
    complete: function () {
      // Repetição do long-polling com os mesmos argumentos
      setTimeout(() => fetchNotifications(), 10000);
    },
  });
}

fetchNotifications();

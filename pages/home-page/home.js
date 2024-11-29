idUsuario = $("#idUsuario-session").text();

// Faz requisição AJAX para obter os dados do usuário aleatório
function loadRandomUser(filter) {
  $.ajax({
    url: "./pages/home-page/get-user.php", // Caminho do arquivo PHP
    type: "GET",
    data: { action: "getUser", filter: filter },
    dataType: "json",
    success: function (response) {
      if (response.error) {
        console.error(response.error);
        return;
      }

      // Atualiza a interface com os novos dados
      const user = response.user;
      const hashtags = response.hashtags;
      const questions = response.questions;

      console.log("Resposta do PHP:", response);

      // Atualiza a imagem do usuário com a foto de perfil
      $(".img").attr("src", "./database/users/" + user.fotoPerfilUsuario);

      // Atualiza o nome, bio e hashtags
      $(".name-user").text(user.nomeUsuario);
      $(".age-user").text(user.idadeUsuario);
      $(".bio").text(user.bioUsuario);

      if (hashtags.length > 0) {
        $(".hashtags-container").html(""); // Limpa o conteúdo existente

        hashtags.forEach(function (h) {
          const span = $("<div>").addClass("hashtag").text(`#${h}`);
          $(".hashtags-container").append(span);
        });
      } else {
        $(".hashtags-container").text("Sem hashtags.");
      }

      // Atualiza as perguntas e respostas
      const perguntasContainer = $(".questions");
      perguntasContainer.empty(); // Limpa o conteúdo anterior

      if (questions.length > 0) {
        questions.forEach((question) => {
          perguntasContainer.append(`
                <div class="question-card">
                  <p>${question.tituloPergunta}</p>
                  <p class="answer">${question.respostaUsuario}</p>
                </div>
              `);
        });
      }

      window.idUsuarioMatch = user.idUsuario;
      window.nomeUsuario = user.nomeUsuario;

      // Unifica a foto de perfil com as fotos do usuário
      window.fotos = [
        response.user.fotoPerfilUsuario,
        ...response.photos.map((photo) => photo.nomeArquivoFoto),
      ];

      console.log("Fotos do usuário carregadas:", window.fotos);

      // Verifica se há apenas uma foto e desabilita o botão
      if (window.fotos.length === 1) {
        $("#btn-other-photo").attr("class", "disabled");
        $("#btn-other-photo i").attr("class", "bi bi-camera");
      } else {
        $("#btn-other-photo").attr("class", "btn-action");
        $("#btn-other-photo i").attr("class", "bi bi-camera-fill");
      }
    },
    error: function (error) {
      console.error("Erro ao carregar o próximo usuário:", error);
    },
  });
}

// Inicializa o Swiper assim que o DOM estiver pronto
$(document).ready(function () {
  loadRandomUser(1);
});

// Variável para controlar o índice da foto
i = 0;

// Evento de clique no botão para trocar a foto do usuário
$("#btn-other-photo").on("click", function () {
  // Verifica se há fotos disponíveis no array unificado
  if (window.fotos.length === 0) {
    console.log("Nenhuma foto disponível.");
    return; // Se não houver fotos, não faz nada
  }

  // Incrementa o índice e, se atingir o fim do array, recomeça do início
  i = (i + 1) % window.fotos.length;

  // Verifica se a foto atual é a foto de perfil ou uma foto adicional
  let fotoAtual = window.fotos[i];

  // Se for a foto de perfil, a pasta é "users", caso contrário, é "profiles"
  let pastaFoto = i === 0 ? "./database/users/" : "./database/users/profiles/";

  // Exibe a próxima foto do array
  $(".img").attr("src", pastaFoto + fotoAtual);
  console.log("Exibindo a foto: ", fotoAtual);
});

// Evento de clique no botão para navegar para o primeiro slide
$("#btn-detona").on("click", function () {
  loadRandomUser(1);
  $("#cantada").show();
  $("#btn-send-cantada").show();
  $(".hashtags-container, .questions").removeClass("expanded");
});

$("#btn-apaixona").on("click", function (e) {
  // Evita o comportamento padrão do link
  e.preventDefault();
  // Exibe o modal com o nome do usuário curtido
  $("#match-modal").show();
  $("#match-name").text("Você curtiu " + window.nomeUsuario);
  $("#match-text").text("Uma hora ele(a) te curte também...");
  $(".hashtags-container, .questions").removeClass("expanded");

  // Envia os dados para inserir o match no banco de dados
  $.ajax({
    url: "./pages/home-page/insert-match.php",
    type: "POST",
    data: { idUsuario: idUsuario, idUsuarioMatch: window.idUsuarioMatch },
    dataType: "json", // Espera uma resposta JSON do servidor
    success: function (response) {
      if (response.success) {
        console.log("Match inserido com sucesso!");
      } else {
        console.error("Erro ao inserir match:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro na requisição AJAX:", xhr.responseText || error);
      $("#match-name").text("Ops...");
      $("#match-text").text("Você já curtiu " + window.nomeUsuario);
    },
  });
});

$("#btn-close-match, .close").on("click", function () {
  $("#match-modal").hide();
});

$("#btn-cantada").on("click", function () {
  $("#cantada-modal").show();
});

$(".close, #btn-cancel-cantada").on("click", function () {
  $("#cantada-modal").hide();
});

$("#btn-send-cantada").on("click", function (e) {
  e.preventDefault();

  // Verifica se a cantada foi escrita
  if ($("#cantada").val() === "") {
    $("#cantada").attr("placeholder", "Por favor, digite uma cantada.");
    return;
  }

  // Envia a cantada para o banco de dados
  $.ajax({
    url: "./pages/home-page/insert-cantada.php",
    type: "POST",
    data: {
      idRemetente: idUsuario,
      idDestinatario: window.idUsuarioMatch,
      conteudoCantada: $("#cantada").val(),
    },
    dataType: "json", // Espera uma resposta JSON do servidor
    success: function (response) {
      if (response.success) {
        console.log("Cantada inserida com sucesso!");
        $("#cantada-text").text("Cantada enviada com sucesso!");
        $("#cantada").hide();
        $("#btn-send-cantada").hide();
      } else {
        console.error("Erro ao inserir cantada:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro na requisição AJAX:", xhr.responseText || error);
    },
  });

  // Faz o match
  $.ajax({
    url: "./pages/home-page/insert-match.php",
    type: "POST",
    data: {
      idUsuario: idUsuario,
      idUsuarioMatch: window.idUsuarioMatch,
    },
    dataType: "json", // Espera uma resposta JSON do servidor
    success: function (response) {
      if (response.success) {
        console.log("Match inserido com sucesso!");
      } else {
        console.error("Erro ao inserir match:", response.error);
      }
    },
    error: function (xhr, status, error) {
      console.error("Erro na requisição AJAX:", xhr.responseText || error);
    },
  });
});

$(".hashtags-container, .questions").on("click", function (e) {
  e.preventDefault();

  // Altera o tamanho do container de hashtags
  if ($(this).hasClass("expanded")) {
    $(this).removeClass("expanded");
  } else {
    $(this).addClass("expanded");
  }
});

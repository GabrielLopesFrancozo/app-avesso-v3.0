function loadNextUser() {
    $.ajax({
      url: './pages/home-page/get-user.php', // Caminho do arquivo PHP
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.error) {
          alert(response.error);
          return;
        }
  
        // Atualiza a interface com os novos dados
        const user = response.user;
        const hashtags = response.hashtags;
        const questions = response.questions;
  
        // Atualiza a foto do usuário
        $(".content-image img").attr("src", "./database/users/" + user.fotoPerfilUsuario);
  
        // Atualiza o nome, bio e hashtags
        $(".bio .nome").text(user.nomeUsuario);
        $(".bio .bio-user").text(user.bioUsuario);
  
        if (hashtags.length > 0) {
          $(".hashtags-container .hashtags").text(hashtags.map(h => `#${h}`).join(" "));
        } else {
          $(".hashtags-container .hashtags").text("Sem hashtags.");
        }
  
        // Atualiza as perguntas e respostas
        const perguntasContainer = $(".perguntas");
        perguntasContainer.empty(); // Limpa o conteúdo anterior
  
        if (questions.length > 0) {
          questions.forEach(q => {
            perguntasContainer.append(`
              <div class="card">
                <h3>${q.tituloPergunta}</h3>
                <p>${q.respostaUsuario}</p>
              </div>
            `);
          });
        } else {
          perguntasContainer.append("<p>Sem perguntas respondidas.</p>");
        }
      },
      error: function (error) {
        console.error("Erro ao carregar o próximo usuário:", error);
      },
    });
  }
  
  // Chama a função ao clicar no botão "próximo"
  $("#btn-detona").on("click", function (e) {
    e.preventDefault();
    loadNextUser();
  });
  

$("#btn-cantada").on("click", function (e) {
    e.preventDefault();

    // Solicita um input para o usuário
    const input = prompt("Digite uma cantada:");

    // Verifica se o input foi fornecido
    if (!input) {
      alert("Por favor, digite uma cantada.");
      return;
    }
});

$("#btn-apaixona").on("click", function (e) {
    e.preventDefault();

    alert("Apaixonado!");
});

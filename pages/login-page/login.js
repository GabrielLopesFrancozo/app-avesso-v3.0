$(document).ready(function () {
  $("#form-login").on("submit", function (e) {
    e.preventDefault(); // Impede o envio padrão do formulário

    $.ajax({
      url: "./login.php", // URL do backend
      type: "POST",
      data: $(this).serialize(), // Serializa os dados do formulário
      success: function (response) {
        console.log(response);
        // Se a resposta for uma URL, redireciona o usuário
        if (response.includes("./criar-perfil") || response.includes("../splash-screen/splash.php")) {
          window.location.href = response;
        } else {
          // Exibe a mensagem de erro no frontend
          $(".text-error").show();

          // Oculta a mensagem após 5 segundos
          setTimeout(function () {
            $(".text-error").fadeOut();
          }, 5000);
        }
      },
      error: function () {
        console.error("Erro no envio do formulário.");
      },
    });
  });
});

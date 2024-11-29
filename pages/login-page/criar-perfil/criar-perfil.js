// Página criar de perfil 1

// Próximo tutorial
$("#close-tutorial").hide();

$("#next-tutorial").click(function () {
  $(".title").html("Tenha conversas divertidas!");
  $(".text").html("Mas lembre-se sempre de manter o respeito com as outras pessoas! <p style='margin-top: 1rem; color: var(--carmin);'> Agora, vamos personalizar o seu perfil! </p>");
  $("#next-tutorial").hide();
  $("#close-tutorial").show();
  $(".img").attr("src", "../../../assets/imgs/conversation.png");
});
// Fechar tutorial
$("#close-tutorial").click(function () {
  $(".tutorial").css("display", "none");
});

// Mostrar foto selecionada no input
const inputFile = document.querySelector("#picture__input");
const pictureImage = document.querySelector(".picture__image");

if (inputFile) {
  inputFile.addEventListener("change", function (e) {
    const inputTarget = e.target;
    const file = inputTarget.files[0];

    if (file) {
      const reader = new FileReader();

      reader.addEventListener("load", function (e) {
        const readerTarget = e.target;

        const img = document.createElement("img");
        img.src = readerTarget.result;
        img.classList.add("picture__img");
        img.id = "foto-usuario";

        pictureImage.innerHTML = "";
        pictureImage.appendChild(img);
        $(".picture").css("border", "none");
      });

      reader.readAsDataURL(file);
    }
  });
}

// Mostrar mensagem de sucesso ou de erro
$(document).ready(function () {
  var $messageContainer = $(".message-container");
  $messageContainer.hide();

  $("#btn-enviar-foto").click(function () {
    $messageContainer.slideDown(300);
  });

  $(document).ready(function () {
    var $message = $("#mensagem");
    $message.hide();

    $("#btn-enviar-foto").on("click", function (event) {
      event.preventDefault();

      $("#form-upload-foto")
        .ajaxForm({
          url: "./upload/executa-upload.php",
          success: function (data) {
            var message = data.substring(0, data.indexOf(";"));
            var messageType = data.substring(data.indexOf(";") + 1);
            var link = $(".link");

            if (messageType === "concluido") {
              var photoPath = message;
              message = "Foto carregada com sucesso!";
              $("#foto-usuario").attr(
                "src",
                photoPath + "?timestamp=" + new Date().getTime()
              );
              $message.show().attr("class", "message success");
              $(".message-text").html(message);
              link.attr("class", "link active");
              link.attr("href", "criar-perfil-3.php");
            } else if (messageType === "aviso") {
              message = "A imagem ultrapassa o tamanho permitido.";
              $message.show().attr("class", "message warning");
              $(".message-text").html(message);
            } else {
              message = "Nenhuma foto selecionada.";
              $message.fadeIn(300).attr("class", "message error");
              $(".message-text").html(message);
            }

            $('input[type="file"]').val("");

            setTimeout(function () {
              $message.fadeOut(300);
              $messageContainer.slideUp(300);
            }, 5000);
          },
          error: function (error) {
            $(".#btn-enviar-foto").fadeIn(300);
            console.error("Upload error:", error);
          },
        })
        .submit();
    });
  });
});

// Fim da página criar de perfil 1

// -------------------------------------------------------------------------------------------------------------------->

// Página criar de perfil 3

$(".modal-conatainer").hide();

// Botão de pular
$("#skip").click(function (e) {
  e.preventDefault();

  $(".modal-conatainer").fadeIn(50);
});

// Fechar o modal de logout
$(".btn-cancel, .close-button").click(function (e) {
  e.preventDefault();

  $(".modal-conatainer").fadeOut(50);
});

// Fim da página criar de perfil 3

// -------------------------------------------------------------------------------------------------------------------->

// Página criar de perfil 4

$(document).ready(function () {
  $("#hashtag-form").on("submit", function (event) {
    event.preventDefault(); // Evita o envio padrão do formulário

    var formData = $(this).serialize(); // Serializa os dados do formulário

    $.ajax({
      url: "add-hashtags.php", // Atualize com o caminho correto
      type: "POST",
      dataType: "json", // Define que a resposta será um JSON
      data: formData,
      success: function (response) {
        if (response.status === "error") {
          // Exibe erro ao usuário
          alert(response.message);
        } else if (response.status === "success") {
          // Atualiza a lista de hashtags no frontend
          var $hashtagContainer = $(".hashtags");
          $hashtagContainer.empty(); // Limpa as hashtags antigas

          // Adiciona as hashtags atualizadas
          response.hashtags.forEach(function (hashtag) {
            $hashtagContainer.append(
              `<span class="hashtag-item">#${hashtag}</span> `
            );
          });

          // Limpa o campo de entrada
          $("#message-input").val("");
        }
      },
      error: function (error) {
        console.error("Erro no envio:", error);
        alert("Erro ao enviar o formulário. Tente novamente.");
      },
    });
  });
});





// Página criar de perfil 5

// Mostrar mensagem de sucesso ou de erro
$(document).ready(function () {
  var $messageContainer = $(".message-container");
  $messageContainer.hide();

  $(".button").click(function () {
    $messageContainer.slideDown(300);
  });

  $(document).ready(function () {
    var $message = $("#mensagem");
    $message.hide();

    $("#btn-enviar-foto").on("click", function (event) {
      event.preventDefault();

      $("#form-upload-foto")
        .ajaxForm({
          url: "./upload/executa-upload.php",
          success: function (data) {
            var message = data.substring(0, data.indexOf(";"));
            var messageType = data.substring(data.indexOf(";") + 1);
            var link = $(".link");

            if (messageType === "concluido") {
              var photoPath = message;
              message = "Foto carregada com sucesso!";
              $("#foto-usuario").attr(
                "src",
                photoPath + "?timestamp=" + new Date().getTime()
              );
              $message.show().attr("class", "message success");
              $(".message-text").html(message);
              link.attr("class", "link active");
              link.attr("href", "criar-perfil-3.php");
            } else if (messageType === "aviso") {
              message = "A imagem ultrapassa o tamanho permitido.";
              $message.show().attr("class", "message warning");
              $(".message-text").html(message);
            } else {
              message = "Nenhuma foto selecionada.";
              $message.fadeIn(300).attr("class", "message error");
              $(".message-text").html(message);
            }

            $('input[type="file"]').val("");

            setTimeout(function () {
              $message.fadeOut(300);
              $messageContainer.slideUp(300);
            }, 5000);
          },
          error: function (error) {
            console.error("Upload error:", error);
          },
        })
        .submit();
    });
  });
});

// Fim da página criar de perfil 5

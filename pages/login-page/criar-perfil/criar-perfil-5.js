// Form de perguntas
$(document).ready(function () {
  var $message = $("#mensagem");
  $message.hide();

  $("#btn-send-question").on("click", function (e) {
    e.preventDefault();

    $("#form-question")
      .ajaxForm({
        url: "criar-perfil-5.php",
        type: "POST",
        dataType: "html",
        data: $("#form-question").serialize(),
        success: function () {
          $("#user-answer").val("");
          $(".questions").load(window.location.href + " .questions");
          $(".qtd-questions").load(window.location.href + " .qtd-questions");
          $(".bottom-container").load(window.location.href + " .bottom-container");
        },
        error: function (error) {
          console.error("Upload error:", error);
        },
      })
      .submit();
  });
});

// Form de fotos
$(document).ready(function () {
  // Preview das imagens antes de enviar
  $("#user-photo-1").on("change", function () {
    $("#preview-img-container").empty(); // Limpa previews anteriores
    const files = this.files;
    Array.from(files).forEach((file) => {
      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $("<img>")
            .attr("src", e.target.result)
            .attr("width", 100);
          $("#preview-img-container").append(img);
        };
        reader.readAsDataURL(file);
      }
    });
  });

  // Submissão do formulário com AJAX
  $("#btn-send-photo").on("click", function (e) {
    e.preventDefault();

    // Envia o formulário com os arquivos
    $("#form-photo")
      .ajaxForm({
        url: "upload/executa-mult-uploads.php", // URL para o PHP
        type: "POST",
        dataType: "html",
        success: function (response) {
          console.log("Resposta do PHP:", response);
          $("#user-photo-1").val(""); // Limpa o input de arquivos
          $("#preview-img-container").empty(); // Limpa os previews
        },
        error: function (error) {
          console.error("Erro no upload:", error);
        },
      })
      .submit();
  });
});

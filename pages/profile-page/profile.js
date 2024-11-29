// Arrumar Swiper
function initSwiper() {
  const swiper = new Swiper(".swiper", {
    // Optional parameters
    direction: "horizontal",
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,

    // If we need pagination
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },

    // And if we need scrollbar
    scrollbar: {
      el: ".swiper-scrollbar",
    },
  });
  console.log("Swiper initialized");
}

initSwiper();

$("#btn-open-photo-modal").click(function (e) {
  e.preventDefault();

  $("#add-photo-modal").show();
});

$(".btn-cancel, .close-button").click(function (e) {
  e.preventDefault();

  $("#add-photo-modal").hide();
  $("#view-photo-modal").hide();
});

// Preview das imagens antes de enviar
$("#input-add-photo").on("change", function () {
  $("#preview-img-container").empty(); // Limpa previews anteriores
  const files = this.files;
  Array.from(files).forEach((file) => {
    if (file && file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = function (e) {
        const img = $("<img>")
          .attr("src", e.target.result)
          .attr("class", "preview-img")
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

  //   Envia o formulário com os arquivos
  $("#form-photo")
    .ajaxForm({
      url: "./pages/login-page/criar-perfil/upload/executa-mult-uploads.php", // URL para o PHP
      type: "POST",
      dataType: "html",
      success: function (response) {
        console.log("Resposta do servidor:", response);
        $("#add-photo-modal").hide();
        $("body").load(window.location.href);
      },
      error: function (error) {
        console.error("Erro no upload:", error);
      },
    })
    .submit();
});

$(".photo").on("click", function (e) {
  e.preventDefault();

  $("#view-photo-modal").fadeIn(10);

  photoId = $(this).attr("id");

  $("#photo-inside-modal").attr("src", "./database/users/profiles/" + photoId);

  $("#btn-delete-photo").on("click", function (e) {
    e.preventDefault();
  
    $.ajax({
      url: "./pages/login-page/criar-perfil/upload/delete-photo.php",
      type: "POST",
      data: { photoId: photoId }, // Certifique-se de definir a variável photoId corretamente
      success: function (response) {
        console.log("Resposta do servidor:", response);
        if (response.success) {
          $("body").load(window.location.href);
        } else {
          alert("Erro ao deletar a foto: " + response.errors.join(", "));
        }
      },
      error: function (error) {
        console.error("Erro ao deletar a foto:", error);
      },
    });
  });
  
  
});


// Detecta cliques nos itens de navegação
$(".nav-item").on("click", function (e) {
  if ($(this).attr("id") !== "logout") {
      e.preventDefault(); // Evita o comportamento padrão do link

      // Atualiza a URL com base no ID do item clicado
      let link = $(this).attr("id");
      localStorage.setItem("lastPage", link);

      history.pushState({}, "", `/${localStorage.getItem("lastPage")}`);

      // Carrega o conteúdo correspondente
      loadContentFromUrl();

      // Atualiza o Ícone ativo na navegação
      updateActiveIcon(localStorage.getItem("lastPage"));

      if (link === "chat") {
          $(".chats-container").load("./pages/chat-page/chat.php .chats-container");
      }
  } else {
      // Ação para logout
      $("#logout-modal").show();
  }
});

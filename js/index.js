// <----- Navigation - Navegação dinâmica entre as páginas  ----->

// Função para carregar o conteúdo com base na URL
function loadContentFromUrl() {
    let url = new URL(window.location.href); // Obtém a URL completa
    let pathname = url.pathname === "/" ? `${localStorage.getItem("lastPage")}` : url.pathname; // Define 'home' como padrão para a raiz
    let query = url.search; // Obtém a query string (ex: '?contato=joao')

    // Atualiza o item ativo na navegação
    $(".nav-item").removeClass("active"); // Remove a classe 'active' de todos os itens
    $(`.nav-item[id="${pathname.substring(1)}"]`).addClass("active"); // Adiciona 'active' ao item correspondente

    // Carrega o conteúdo correspondente (inclui a query string)
    $(".main").load(`./pages${pathname}-page${pathname}.php${query}`);
}

// Função para atualizar o Ícone ativo na navegação
function updateActiveIcon(menuId) {
    document.querySelectorAll('.nav-item').forEach(item => {
        const icon = item.querySelector('i');
        const dataMenu = item.getAttribute('id');

        if (dataMenu === menuId) {
            icon.className = icon.dataset.iconFilled; // Ícone preenchido
        } else {
            icon.className = icon.dataset.icon; // Ícone normal
        }
    });
}

// Inicializa a página ao carregar o site
history.replaceState({}, "", `${localStorage.getItem("lastPage")}`); // Define a URL padrão como '/home'
loadContentFromUrl(); // Carrega o conteúdo inicial

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

// Atualiza o conteúdo e o item ativo ao usar os botões 'Voltar' ou 'Avançar' do navegador
window.addEventListener("popstate", function () {
    loadContentFromUrl();
});

// <----- /Navigation ----->

// Fechar o modal de logout
$(".btn-cancel, .close-button").click(function(e) {
    e.preventDefault();

    $("#logout-modal").hide();
});
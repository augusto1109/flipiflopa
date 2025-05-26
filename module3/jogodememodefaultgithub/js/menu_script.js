function showDifficultyMenu() {
    document.getElementById("menu-container").classList.add("hidden");
    document.getElementById("dificuldade-menu").classList.remove("hidden");
    document.getElementById("voltar-button").classList.remove("hidden");
    document.getElementById("bemvindo-message").classList.add("hidden");
}

let selectedDifficulty = ''; // Armazena a dificuldade selecionada

function selectDifficulty(difficulty) {
    selectedDifficulty = difficulty;
    showThemeMenu(); // Exibe o menu de temas após a escolha da dificuldade
}

function showThemeMenu() {
    document.getElementById("dificuldade-menu").classList.add("hidden");
    document.getElementById("tema-menu").classList.remove("hidden");
}

function startGame(theme) {
    if (!selectedDifficulty) {
        alert("Por favor, selecione uma dificuldade primeiro!");
        return;
    }
    if (!theme) {
        alert("Por favor, selecione um tema!");
        return;
    }
    
    if (theme === "personalizado") {
        importCustomTheme();
    } else {
        redirectToGame(selectedDifficulty, theme);
    }
}

function startGameFromMenu() {
    showDifficultyMenu();
}

function importCustomTheme() {
    let input = document.createElement("input");
    input.type = "file";
    input.accept = "image/*";
    input.addEventListener("change", function (event) {
        let file = event.target.files[0];
        if (!file) {
            alert("Por favor, selecione uma imagem para o tema personalizado.");
            return;
        }
        let imageUrl = URL.createObjectURL(file);
        localStorage.setItem("customTheme", imageUrl);
        redirectToGame(selectedDifficulty, "personalizado");
    });
    input.click();
}

function redirectToGame(difficulty, theme) {
    let gamePage = "jogo_" + difficulty + ".php";
    window.location.href = `${gamePage}?tema=${theme}`;
}

console.log({
    themeMenu: themeMenu.classList.contains("hidden"),
    difficultyMenu: difficultyMenu.classList.contains("hidden"),
    menuContainer: menuContainer.classList.contains("hidden"),
    bemvindoMessage: bemvindoMessage.classList.contains("hidden")
});

function goBack() {
    function goBack() {
        const themeMenu = document.getElementById("tema-menu");
        const difficultyMenu = document.getElementById("dificuldade-menu");
        const menuContainer = document.getElementById("menu-container");
        const bemvindoMessage = document.getElementById("bemvindo-message");
        const voltarButton = document.getElementById("voltar-button");
    
        if (!themeMenu || !difficultyMenu || !menuContainer || !bemvindoMessage || !voltarButton) {
            console.error("Erro: Um ou mais elementos não foram encontrados:");
            console.log({
                themeMenu,
                difficultyMenu,
                menuContainer,
                bemvindoMessage,
                voltarButton
            });
            return; // Evita que o erro quebre o código
        }
    
        // ... (resto da lógica abaixo)
    }
    
    const themeMenu = document.getElementById("tema-menu");
    const difficultyMenu = document.getElementById("dificuldade-menu");
    const menuContainer = document.getElementById("menu-container");
    const bemvindoMessage = document.getElementById("bemvindo-message");
    const voltarButton = document.getElementById("voltar-button");

    if (!themeMenu.classList.contains("hidden")) {
        // Se está no menu de temas, volta para dificuldade
        themeMenu.classList.add("hidden");
        difficultyMenu.classList.remove("hidden");
        voltarButton.classList.remove("hidden");
    } else if (!difficultyMenu.classList.contains("hidden")) {
        // Se está no menu de dificuldade, volta para menu principal
        difficultyMenu.classList.add("hidden");
        menuContainer.classList.remove("hidden");
        bemvindoMessage.classList.remove("hidden");
        voltarButton.classList.add("hidden");
    } else {
        // Fallback de segurança
        menuContainer.classList.remove("hidden");
        bemvindoMessage.classList.remove("hidden");
        voltarButton.classList.add("hidden");
    }
}

function toggleUserDropdown() {
    var dropdown = document.getElementById("user-dropdown");

    if (dropdown) {
        dropdown.classList.toggle("hidden");
    } else {
        console.error("Dropdown não encontrado");
    }

}

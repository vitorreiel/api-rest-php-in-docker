const API_URL = "http://localhost:8000";

// Seleciona elementos do DOM
const statusMessage = document.getElementById("statusMessage");
const modal = document.getElementById("modal");
const closeModal = document.getElementById("closeModal");
const modalMessage = document.getElementById("modalMessage");

// Função para abrir o modal
function openModal(message) {
    modalMessage.textContent = message;
    modal.style.display = "block";
}

// Função para fechar o modal
closeModal.onclick = function () {
    modal.style.display = "none";
}

// Quando clicar fora do modal, ele será fechado
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

// Função para mostrar mensagens diretamente na página
function showMessage(message, type) {
    statusMessage.textContent = message;
    statusMessage.className = `status-message ${type}`; // Aplica a classe 'success' ou 'error'
    statusMessage.style.display = "block";

    // Esconde a mensagem após 3 segundos
    setTimeout(() => {
        statusMessage.style.display = "none";
    }, 3000);
}

// Evento de submissão do formulário
document.getElementById("registerForm").addEventListener("submit", async (event) => {
    event.preventDefault(); // Evita o envio padrão do formulário

    // Coleta os dados do formulário
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {
        // Envia a requisição para o backend
        const response = await fetch(`${API_URL}/register`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ name, email, password }),
        });

        // Verifica se a resposta foi bem-sucedida
        if (response.ok) {
            showMessage("Usuário registrado com sucesso!", "success");
            document.getElementById("registerForm").reset(); // Limpa o formulário
        } else {
            const errorData = await response.json();
            // Caso o e-mail já esteja registrado, exibe uma mensagem específica
            if (errorData.message === "Email already exists") {
                showMessage("Este e-mail já está registrado.", "error");
            } else {
                showMessage("Erro ao registrar usuário.", "error");
            }
        }
    } catch (error) {
        // Se houver algum erro na requisição, exibe mensagem de erro
        console.error("Erro na requisição:", error);
        showMessage("Erro ao tentar se conectar ao servidor.", "error");
    }
});

document.getElementById("loadUsers").addEventListener("click", async () => {
    const response = await fetch(`${API_URL}/users`, {
        method: "GET",
    });

    if (response.ok) {
        const users = await response.json();
        const userList = document.getElementById("userList");
        userList.innerHTML = ""; // Limpa a lista antes de atualizar

        users.forEach((user) => {
            const li = document.createElement("li");
            li.textContent = `${user.name} (${user.email})`;
            userList.appendChild(li);
        });
    } else {
        alert("Erro ao carregar usuários!");
    }
});

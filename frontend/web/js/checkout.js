
let selectedPaymentMethodId = null;

// Função para mostrar o dropdown
document.getElementById("current-payment").addEventListener("click", function () {
    const dropdown = document.getElementById("payment-dropdown").querySelector(".dropdown-select");
    dropdown.classList.toggle("visible");
});

// Função para selecionar o método de pagamento e mostrar o formulário correspondente
function selectPaymentMethod(paymentMethodId, paymentMethodName) {
    // Esconder todos os formulários de pagamento
    const paymentForms = document.querySelectorAll('.payment-form');
    paymentForms.forEach(form => {
        form.style.display = "none";
    });

    // Mostrar o formulário correspondente ao método selecionado
    const selectedForm = document.getElementById("payment-form-" + paymentMethodId);
    if (selectedForm) {
        selectedForm.style.display = "block";
    }

    selectedPaymentMethodId = paymentMethodId;

    // Atualizar o texto do botão de seleção do método de pagamento
    document.getElementById("current-payment").textContent = paymentMethodName;

    // Fechar o dropdown
    const dropdown = document.getElementById("payment-dropdown").querySelector(".dropdown-select");
    dropdown.classList.remove("visible");

    // Atualizar o botão de finalização de compra com o ID do método de pagamento
    const finalizeButton = document.getElementById("finalize-purchase-btn");
    if (finalizeButton) {
        finalizeButton.href = `finalizar-compra?metodopagamento_id=${selectedPaymentMethodId}`;
    }
}

// Configurar ouvintes de clique no dropdown
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#payment-dropdown .dropdown-select li').forEach(function (item) {
        item.addEventListener('click', function () {
            const paymentMethodId = this.getAttribute('data-method');
            const paymentMethodName = this.textContent.trim();
            selectPaymentMethod(paymentMethodId, paymentMethodName);
        });
    });
});

// Validação ao clicar no botão de finalização
document.getElementById("finalize-purchase-btn").addEventListener("click", function (event) {
    if (selectedPaymentMethodId === null) {
        alert("Por favor, selecione um método de pagamento.");
        event.preventDefault(); // Impede o envio se nenhum método for selecionado
    }
});

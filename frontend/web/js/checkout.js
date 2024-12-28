let selectedPaymentMethodId = null;

// Função para mostrar o dropdown
document.getElementById("current-payment").addEventListener("click", function() {
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
    document.getElementById("payment-form-" + paymentMethodId).style.display = "block";
    selectedPaymentMethodId = paymentMethodId;

    // Atualizar o texto do botão de seleção do método de pagamento
    document.getElementById("current-payment").textContent = paymentMethodName;

    // Fechar o dropdown
    document.getElementById("payment-dropdown").querySelector(".dropdown-select").classList.remove("visible");
}

document.addEventListener('DOMContentLoaded', function() {
    // Ouvintes de clique do dropdown
    document.querySelectorAll('#payment-dropdown .dropdown-select li').forEach(function(item) {
        item.addEventListener('click', function() {
            const paymentMethodId = this.getAttribute('data-method');
            const paymentMethodName = this.textContent.trim();
            selectPaymentMethod(paymentMethodId, paymentMethodName);
        });
    });
});


// Adicionar o ID do metodo de pagamento selecionado no input oculto e submeter o formulário
document.getElementById("finalize-purchase-btn").addEventListener("click", function(event) {
    if (selectedPaymentMethodId === null) {
        alert("Por favor, selecione um método de pagamento.");
        event.preventDefault();  // Impede o envio se nenhum metodo for selecionado
        return;
    }

    // Criar ou atualizar o campo oculto com o ID do metodo de pagamento
    const hiddenInput = document.getElementById("hidden-metodopagamento-id");
    if (!hiddenInput) {
        const newInput = document.createElement("input");
        newInput.type = "hidden";
        newInput.id = "hidden-metodopagamento-id";
        newInput.name = "metodopagamento_id";
        newInput.value = selectedPaymentMethodId;
        document.getElementById("payment-method-form").appendChild(newInput);
    } else {
        hiddenInput.value = selectedPaymentMethodId;
    }

    // Submeter o formulário
    document.getElementById("payment-method-form").submit();
});

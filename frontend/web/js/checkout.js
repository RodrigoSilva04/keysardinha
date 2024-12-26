let selectedPaymentMethodId = null;  // Variable to store selected payment method ID

// Function to show dropdown and handle selection
document.getElementById("current-payment").addEventListener("click", function() {
    const dropdown = document.getElementById("payment-dropdown").querySelector(".dropdown-select");
    dropdown.classList.toggle("visible");
});

// Function to select the payment method and show corresponding form
function selectPaymentMethod(paymentMethod) {
    // Hide all forms first
    document.getElementById("credit-card-form").style.display = "none";
    document.getElementById("mbway-form").style.display = "none";
    document.getElementById("paypal-form").style.display = "none";

    // Show the corresponding form and set the payment method ID
    if (paymentMethod === 'credit-card') {
        document.getElementById("credit-card-form").style.display = "block";
        selectedPaymentMethodId = 3;  // ID for Credit Card
    } else if (paymentMethod === 'mbway') {
        document.getElementById("mbway-form").style.display = "block";
        selectedPaymentMethodId = 2;  // ID for MBWay
    } else if (paymentMethod === 'paypal') {
        document.getElementById("paypal-form").style.display = "block";
        selectedPaymentMethodId = 1;  // ID for PayPal
    }

    // Update dropdown button text
    document.getElementById("current-payment").textContent = paymentMethod === 'credit-card' ? 'Cartão de Crédito' :
        paymentMethod === 'mbway' ? 'MBWay' :
            'PayPal';

    // Close the dropdown
    document.getElementById("payment-dropdown").querySelector(".dropdown-select").classList.remove("visible");
}

// Attach the selected payment method ID to the hidden input and submit the form
document.getElementById("finalize-purchase-btn").addEventListener("click", function(event) {
    if (selectedPaymentMethodId === null) {
        alert("Por favor, selecione um método de pagamento.");
        event.preventDefault();  // Prevent the default action if no payment method is selected
        return;
    }

    // Set the selected payment method ID in the hidden input
    document.getElementById("hidden-metodopagamento-id").value = selectedPaymentMethodId;

    // Submit the form
    document.getElementById("payment-method-form").submit();
});

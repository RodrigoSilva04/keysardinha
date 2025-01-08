document.addEventListener('DOMContentLoaded', function () {
    // Botão "Ver Faturas"
    document.getElementById('view-invoices-btn').addEventListener('click', function () {
        document.getElementById('profile-details').style.display = 'none';
        document.getElementById('coupon-details').style.display = 'none';
        document.getElementById('invoice-details').style.display = 'block';
    });

    // Botão "Ver Cupões"
    document.getElementById('view-cupoes-btn').addEventListener('click', function () {
        document.getElementById('profile-details').style.display = 'none';
        document.getElementById('invoice-details').style.display = 'none';
        document.getElementById('coupon-details').style.display = 'block';
    });

    // Botão "Voltar" (Faturas)
    document.getElementById('back-to-profile-btn-invoice').addEventListener('click', function () {
        document.getElementById('invoice-details').style.display = 'none';
        document.getElementById('profile-details').style.display = 'block';
    });

    // Botão "Voltar" (Cupões)
    document.getElementById('back-to-profile-btn-coupon').addEventListener('click', function () {
        document.getElementById('coupon-details').style.display = 'none';
        document.getElementById('profile-details').style.display = 'block';
    });
});
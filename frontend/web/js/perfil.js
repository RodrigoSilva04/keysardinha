document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('view-invoices-btn').addEventListener('click', function () {
        document.getElementById('profile-details').style.display = 'none';
        document.getElementById('invoice-details').style.display = 'block';
    });

    document.getElementById('back-to-profile-btn').addEventListener('click', function () {
        document.getElementById('invoice-details').style.display = 'none';
        document.getElementById('profile-details').style.display = 'block';
    });
});
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Evita o comportamento padrão de navegação

        // Seleciona o destino e rola até lá
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth' // Rola suavemente
        });
    });
});
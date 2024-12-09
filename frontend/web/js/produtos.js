$(document).ready(function() {
    // Filtrar produtos ao clicar em uma categoria
    $('.category-filter').click(function(e) {
        e.preventDefault(); // Impede o comportamento padrão do link

        // Obtém o filtro da categoria clicada
        var filterValue = $(this).data('filter');

        // Remove a classe 'is_active' de todos os links e adiciona no link atual
        $('.category-filter').removeClass('is_active');
        $(this).addClass('is_active');

        // Filtra os produtos com base na categoria
        if (filterValue === '*') {
            // Se for "Show All", mostra todos os produtos
            $('.trending-items').show();
        } else {
            // Caso contrário, só mostra os produtos da categoria selecionada
            $('.trending-items').each(function() {
                var productCategory = $(this).data('category');

                // Verifica se o produto corresponde à categoria
                if (filterValue == productCategory) {
                    $(this).show(); // Mostra o produto
                } else {
                    $(this).hide(); // Esconde o produto
                }
            });
        }
    });

    // Mostrar todos os produtos quando "Show All" for clicado
    $('a.is_active[data-filter="*"]').click(function(e) {
        e.preventDefault(); // Impede o comportamento padrão

        // Exibe todos os produtos
        $('.trending-items').show();

        // Marca "Show All" como ativo
        $('.category-filter').removeClass('is_active');
        $(this).addClass('is_active');
    });
});

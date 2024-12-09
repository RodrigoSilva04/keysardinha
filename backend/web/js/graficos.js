document.addEventListener('DOMContentLoaded', function () {
    var invoicesChartCanvas = document.getElementById('invoicesChart').getContext('2d');

    // Buscar os dados do backend
    fetch('invoices-data')
        .then(response => response.json())
        .then(data => {
            // Preparar os dados para o gráfico
            const labels = data.map(item => item.month); // Nomes dos meses
            const counts = data.map(item => item.count); // Quantidade de faturas

            const chartData = {
                labels: labels,
                datasets: [{
                    label: 'Faturas',
                    data: counts,
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    borderWidth: 1,
                }]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            display: true
                        }
                    }
                }
            };

            new Chart(invoicesChartCanvas, {
                type: 'bar', // Pode usar 'line' ou 'pie' dependendo da sua necessidade
                data: chartData,
                options: chartOptions
            });
        })
        .catch(error => console.error('Erro ao buscar os dados:', error));
});

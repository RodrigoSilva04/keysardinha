document.addEventListener("DOMContentLoaded", function () {
    const canvasElement = document.getElementById("myChart");

    if (!canvasElement) {
        console.error("Elemento #myChart não encontrado.");
        return;
    }

    const ctx = canvasElement.getContext("2d");

    // Obter os dados das faturas
    const datas = document.getElementById("grafico").getAttribute("data-datas");
    const vendas = document.getElementById("grafico").getAttribute("data-vendas");

    // Verifique se os dados existem antes de fazer o JSON.parse()
    if (datas && vendas) {
        try {
            const parsedDatas = JSON.parse(datas);
            const parsedVendas = JSON.parse(vendas);

            // Log para verificar os dados antes de criar o gráfico
            console.log("Datas:", parsedDatas);
            console.log("Vendas:", parsedVendas);

            // Criar o gráfico com os dados
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: parsedDatas, // As datas
                    datasets: [{
                        label: "Vendas",
                        data: parsedVendas, // O número de vendas
                        borderColor: "rgba(0,0,255,1.0)",
                        backgroundColor: "rgba(0,0,255,0.1)",
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: "Data", // Título do eixo X
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: "Vendas", // Título do eixo Y
                            },
                            beginAtZero: true, // Iniciar o eixo Y a partir de 0
                        }
                    }
                }
            });
        } catch (error) {
            console.error("Erro ao parsear os dados:", error);
        }
    } else {
        console.error("Dados não encontrados para o gráfico.");
    }
});

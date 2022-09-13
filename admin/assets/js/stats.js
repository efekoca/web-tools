let botsCtx = document.getElementById("bots").getContext("2d");

let botsLine = new Chart(botsCtx, {
    type: "line",
    data: {
        labels: getBots,
        datasets: [{
            label: "Visit count",
            data: getBotsData,
            backgroundColor: "#4aa6d3",
            borderColor: "royalblue",
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: true,
            position: "top",
            labels: {
                fontColor: "gray"
            }
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: true,
                    color: "black"
                },
                scaleLabel: {
                    display: true,
                }
            }],
            yAxes: [{
                gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                },
                scaleLabel: {
                    display: true,
                }
            }]
        }
    }
});
let popularToolsCtx = document.getElementById("popularTools").getContext("2d");
let popularDevicesCtx = document.getElementById("popularDevices").getContext("2d");
let popularBrowsersCtx = document.getElementById("popularBrowsers").getContext("2d");

let popularTools = new Chart(popularToolsCtx, {
    type: "line",
    data: {
        labels: getPopularTools,
        datasets: [{
            label: "Number of tool usage",
            data: getPopularToolsData,
            backgroundColor: "lightblue",
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
                    labelString: "Araç",
                }
            }],
            yAxes: [{
                gridLines: {
                    color: "black",
                    borderDash: [2, 5],
                },
                scaleLabel: {
                    display: true,
                    labelString: "Usage Count",
                }
            }]
        }
    }
});

let popularDevices = new Chart(popularDevicesCtx, {
    type: "bar",
    data: {
        labels: getPopularDevices,
        datasets: [{
            label: "Usage count with related device",
            data: getPopularDevicesData,
            backgroundColor: [
                "rgba(255, 159, 64, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(92, 37, 5, 0.2)",
                "rgba(9, 89, 92, 0.2)",
                "rgba(55, 241, 55, 0.2)"
            ],
            borderColor: [
                "rgba(255, 159, 64, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(92, 37, 5, 1)",
                "rgba(9, 89, 92, 1)",
                "rgba(55, 241, 55, 1)"
            ],
            borderWidth: 2
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                stacked: true,
                gridLines: {
                    display: true,
                    color: "rgba(255,99,132,0.2)"
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }
});

let popularBrowsers = new Chart(popularBrowsersCtx, {
    type: "pie",
    data: {
        labels: getPopularBrowsers,
        datasets: [{
            data: getPopularBrowsersData,
            backgroundColor: [
                "rgba(55, 47, 42, 0.2)",
                "rgba(255, 255, 100, 0.2)",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
                "rgba(55, 47, 42, 1)",
                "rgba(255, 255, 100, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 2
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                stacked: true,
                gridLines: {
                    display: true,
                    color: "rgba(255,99,132,0.2)"
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false
                }
            }]
        }
    }
});
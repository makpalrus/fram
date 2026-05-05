function runFade() {
    $("#ad-content").fadeOut(400).fadeIn(400).fadeTo("slow", 0.4).fadeTo("slow", 1);
}

function runSlide() {
    $("#ad-banner").slideUp(500).slideDown(500);
}

function runAnimate() {
    $("#ad-banner").animate({ opacity: 0.7, padding: "50px" }, 800)
                   .animate({ opacity: 1,   padding: "30px" }, 800);
}

function runToggle() {
    $("#ad-banner").hide(500).show(500);
}

function stopAll() {
    $("#ad-banner, #ad-content").stop(true, true);
    alert("Эффекты jQuery остановлены");
}

$(document).ready(function () {

    // Закрытие рекламы
    $("#close-ad").click(function () {
        $("#ad-banner").fadeOut();
    });

    // Инициализация графиков (если они есть на странице)
    if (document.getElementById("barChart")) {
        new Chart("barChart", {
            type: "bar",
            data: {
                labels: ["IT", "HR", "Sales", "Design"],
                datasets: [{
                    label: "Рейтинг",
                    backgroundColor: ["#FF6B47", "#F5A623", "#333", "#ccc"],
                    data: [95, 85, 85, 75]
                }]
            },
            options: {
                scales: { yAxes: [{ ticks: { beginAtZero: true, suggestedMax: 100 } }] }
            }
        });

        new Chart("lineChart", {
            type: "line",
            data: {
                labels: ["2023", "2024", "2025", "2026"],
                datasets: [{
                    label: "Число вакансий",
                    borderColor: "#F5A623",
                    data: [150, 400, 350, 800]
                }]
            }
        });

        new Chart("pieChart", {
            type: "pie",
            data: {
                labels: ["Удаленка", "Офис", "Гибрид"],
                datasets: [{
                    backgroundColor: ["#FF6B47", "#F5A623", "#1e1e2f"],
                    data: [55, 25, 20]
                }]
            }
        });

        new Chart("polarChart", {
            type: "polarArea",
            data: {
                labels: ["English", "Coding", "Soft Skills", "Math"],
                datasets: [{
                    backgroundColor: [
                        "rgba(255,107,71,0.7)",
                        "rgba(245,166,35,0.7)",
                        "rgba(30,30,47,0.7)",
                        "rgba(200,200,200,0.7)"
                    ],
                    data: [12, 19, 15, 10]
                }]
            }
        });
    }
});
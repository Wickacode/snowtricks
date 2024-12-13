document.addEventListener("DOMContentLoaded", function () {
    const tricks = document.querySelectorAll("div.trick");
    const loadMoreButton = document.getElementById("loadMoreTrick");
    const loadLessButton = document.getElementById("loadLessTrick");

    // Affiche les 10 premiers éléments
    for (let i = 0; i < tricks.length; i++) {
        if (i >= 10) {
            tricks[i].style.display = "none";
        }
    }

    loadMoreButton.addEventListener("click", function (e) {
        e.preventDefault();
        let hiddenTricks = Array.from(tricks).filter(trick => trick.style.display === "none");

        for (let i = 0; i < Math.min(10, hiddenTricks.length); i++) {
            hiddenTricks[i].style.display = "block";
        }

        if (Array.from(tricks).filter(trick => trick.style.display === "none").length === 0) {
            loadMoreButton.style.display = "none";
            loadLessButton.style.display = "block";
        }
    });

    loadLessButton.addEventListener("click", function (e) {
        e.preventDefault();

        for (let i = 10; i < tricks.length; i++) {
            tricks[i].style.display = "none";
        }

        loadLessButton.style.display = "none";
        loadMoreButton.style.display = "block";
    });

    // Initial state of the buttons
    loadLessButton.style.display = "none";
});

const deleteForms = document.querySelectorAll(".delete-form");

deleteForms.forEach((element) => {
    const title = element.getAttribute("data-name");

    element.addEventListener("submit", (e) => {
        e.preventDefault();
        const accept = confirm(
            `Il post intitolato "${title}" verrà eliminato. Vuoi procedere?`
        );

        if (accept) {
            e.target.submit();
        }
    });
});

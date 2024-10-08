document.addEventListener("DOMContentLoaded", () => {
    const themeToggleButton = document.getElementById("themeButton");
    const themeIconUseElement = document.getElementById("themeIcon").querySelector("use");
    const savedTheme = localStorage.getItem("theme") || "light";
    applyTheme(savedTheme);
    themeToggleButton.addEventListener("click", toggleTheme);

    function applyTheme(theme) {
        document.documentElement.setAttribute("data-bs-theme", theme);
        const iconPath = theme === "dark" 
            ? "/assets/images/svg/themes.svg#moon-stars-fill" 
            : "/assets/images/svg/themes.svg#sun-fill";
        themeIconUseElement.setAttribute("xlink:href", iconPath);
    }

    function toggleTheme() {
        themeToggleButton.setAttribute("disabled", true);
        const newTheme = document.documentElement.getAttribute("data-bs-theme") === "dark" ? "light" : "dark";
        applyTheme(newTheme);
        localStorage.setItem("theme", newTheme);
        themeToggleButton.classList.add("pulse");
        setTimeout(() => {
            themeToggleButton.classList.remove("pulse");
            themeToggleButton.removeAttribute("disabled");
        }, 1000);
    };
});

function createAlert(label, message, icon) {
    return createElement("div", "alert alert-dismissible alert-primary align-items-center d-flex stretch", `
        <svg aria-label="${label}" class="bi me-2" role="img">
            <use xlink:href="/assets/images/svg/alerts.svg#${icon}"></use>
        </svg>
        <div>${message}</div>
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"></button>
    `);
}

function createCard(header, body, footer) {
    const messageCard = createElement("div", "card stretch text-start");
    if (header) messageCard.append(createElement("div", "card-header", header));
    const bodyElement = createElement("div", "card-body");
    bodyElement.append(createElement("p", "card-text", body));
    messageCard.append(bodyElement);
    if (footer) messageCard.append(createElement("div", "card-footer text-end", footer));
    return messageCard;
};

function createElement(tag, className = "", innerHTML = "") {
    const element = document.createElement(tag);
    if (className) element.className = className;
    if (innerHTML) element.innerHTML = innerHTML;
    return element;
};

function createSpinner() {
    return createElement("div", "my-3 spinner-border text-primary", "<span class=\"visually-hidden\">загрузка...</span>");
}
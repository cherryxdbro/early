document.getElementById("addDivision").addEventListener("click", function () {
    const divisionsContainer = document.getElementById("divisionsContainer");
    const divisionDiv = document.createElement("div");
    divisionDiv.className = "stretch";
    const divisionId = `division-name-${divisionsContainer.children.length + 1}`;
    divisionDiv.innerHTML = `
        <label class="form-label" for="${divisionId}">подразделение:</label>
        <input class="form-control" id="${divisionId}" name="division_name[]" required type="text" />
    `;
    divisionsContainer.append(divisionDiv);
});

document.getElementById("removeDivision").addEventListener("click", function () {
    const divisionsContainer = document.getElementById("divisionsContainer");
    if (divisionsContainer.children.length > 0) {
        divisionsContainer.removeChild(divisionsContainer.lastElementChild);
    }
});

document.getElementById("organizationForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    const alertsContainer = document.getElementById("alertsContainer");
    const formData = new FormData(this);
    const spinner = createSpinner();
    alertsContainer.prepend(spinner);
    try {
        const response = await fetch("/early/organizations", {
            method: "POST",
            body: formData
        });
        const data = await response.json();
        if (response.ok && data.result) {
            const successAlert = createAlert("результат:", data.result, "check-circle-fill");
            spinner.replaceWith(successAlert);
        } else if (data.error) {
            const errorAlert = createAlert("ошибка:", data.error, "exclamation-triangle-fill");
            spinner.replaceWith(errorAlert);
        }
    } catch (error) {
        const errorAlert = createAlert("ошибка:", `${error.name}: ${error.message}`, "exclamation-triangle-fill");
        spinner.replaceWith(errorAlert);
    }
});

document.getElementById("clearAlerts").addEventListener("click", function () {
    document.getElementById("alertsContainer").innerHTML = "";
});

async function loadOrganizations() {
    const organizationsContainer = document.getElementById("organizationsContainer");
    organizationsContainer.innerHTML = "";
    try {
        const response = await fetch("/early/organizations", {
            method: "GET"
        });
        const data = await response.json();
        if (response.ok && data.result) {
            data.result.forEach(organization => {
                const divisions = Array.isArray(organization.divisions) ? organization.divisions.join(", ") : "нет подразделений";
                const organizationCard = createCard(`название: ${organization.name}`, `
                        <p>адрес: ${organization.address}</p>
                        <p>телефон: ${organization.phone}</p>
                        <p>подразделения: ${divisions}</p>
                    `, createFooterButtons(organization.id));
                organizationsContainer.append(organizationCard);
            });
        } else {
            const errorDiv = createElement("div", "alert alert-danger", "не удалось загрузить организации");
            organizationsContainer.append(errorDiv);
        }
    } catch (error) {
        const errorDiv = createElement("div", "alert alert-danger", `ошибка: ${error.name}: ${error.message}`);
        organizationsContainer.append(errorDiv);
    }
}

function createFooterButtons(organizationId) {
    return `
        <div class="d-flex justify-content-between">
            <button class="btn btn-warning" onclick="editOrganization(${organizationId})">редактировать</button>
            <button class="btn btn-danger" onclick="deleteOrganization(${organizationId})">удалить</button>
        </div>
    `;;
}

function editOrganization(id) {
    console.log(`Редактировать организацию с ID: ${id}`);
}

async function deleteOrganization(id) {
    const confirmation = confirm("Вы уверены, что хотите удалить эту организацию?");
    if (confirmation) {
        try {
            const response = await fetch(`/early/organizations`, {
                method: "DELETE",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `id=${encodeURIComponent(id)}`
            });
            const data = await response.json();
            if (response.ok && data.result) {
                loadOrganizations();
            } else if (data.error) {
                alert(data.error);
            }
        } catch (error) {
            alert(`ошибка: ${error.name}: ${error.message}`);
        }
    }
}

document.addEventListener("DOMContentLoaded", loadOrganizations);
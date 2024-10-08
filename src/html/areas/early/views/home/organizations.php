<div class="container container-size text-center">
    <h1 class="display-4 mb-3">добавить организацию</h1>
    <form class="align-items-center d-flex flex-column gap-3 mb-3" id="organizationForm" method="post">
        <div class="stretch">
            <label class="form-label" for="organization-name">наименование организации:</label>
            <input class="form-control" id="organization-name" name="organization_name" required type="text" />
        </div>
        <div class="stretch">
            <label class="form-label" for="organization-address">адрес организации:</label>
            <input class="form-control" id="organization-address" name="organization_address" required type="text" />
        </div>
        <div class="stretch">
            <label class="form-label" for="organization-phone">телефон организации:</label>
            <input class="form-control" id="organization-phone" name="organization_phone" required type="tel" />
        </div>
        <div class="align-items-center d-flex flex-column gap-3 stretch" id="divisionsContainer"></div>
        <div class="d-flex gap-3 stretch">
            <button class="btn btn-primary stretch" id="addDivision" type="button">добавить подразделение</button>
            <button class="btn btn-primary stretch" id="removeDivision" type="button">убрать подразделение</button>
        </div>
        <button class="btn btn-primary stretch" type="submit">добавить организацию</button>
    </form>
    <button class="btn btn-secondary mb-3 stretch" id="clearAlerts" type="button">очистить уведомления</button>
    <div class="align-items-center d-flex flex-column gap-3 mb-3 stretch" id="alertsContainer"></div>
    <h1 class="display-4 mb-3">организации</h1>
    <div class="align-items-center d-flex flex-column gap-3 stretch" id="organizationsContainer"></div>
</div>

<script src="/assets/early/home/organizations/js/script.js"></script>
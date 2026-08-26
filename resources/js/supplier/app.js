require("./bootstrap");
window.moment = require("moment");
window.Vue = require("vue").default;

Vue.directive("tooltip", {
    bind(el, binding) {
        el.setAttribute("title", binding.value);
        new bootstrap.Tooltip(el);
    },
    unbind(el) {
        const instance = bootstrap.Tooltip.getInstance(el);
        if (instance) instance.dispose();
    },
});

Vue.component(
    "supplier-dashboard-summary",
    require("../components/supplier/summary/dashboard.vue").default
);

Vue.component(
    "supplier-events-list",
    require("../components/supplier/events/list.vue").default
);

Vue.component(
    "registration-supplier-registration",
    require("../components/supplier/registration/registration.vue").default
);

Vue.component(
    "supplier-account-information",
    require("../components/supplier/account-information/view.vue").default
);

Vue.component(
    "supplier-product-list",
    require("../components/supplier/products/list.vue").default
);

Vue.component(
    "supplier-product-view",
    require("../components/supplier/products/view.vue").default
);

Vue.component(
    "supplier-product-add",
    require("../components/supplier/products/add.vue").default
);

Vue.component(
    "supplier-payment-event-list",
    require("../components/supplier/payments/events/list.vue").default
);

Vue.component(
    "supplier-event-payment-view",
    require("../components/supplier/payments/events/view.vue").default
);

Vue.component(
    "supplier-daily-sales-report-export-sales-index",
    require("../components/supplier/daily-sales-report/export-sales/index.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-export-sales-create",
    require("../components/supplier/daily-sales-report/export-sales/create.vue")
        .default
);
Vue.component(
    "supplier-daily-sales-report-export-sales-edit",
    require("../components/supplier/daily-sales-report/export-sales/edit.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-domestic-sales-index",
    require("../components/supplier/daily-sales-report/domestic-sales/index.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-domestic-sales-create",
    require("../components/supplier/daily-sales-report/domestic-sales/create.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-domestic-sales-edit",
    require("../components/supplier/daily-sales-report/domestic-sales/edit.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-retail-sales-index",
    require("../components/supplier/daily-sales-report/retail-sales/index.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-retail-sales-create",
    require("../components/supplier/daily-sales-report/retail-sales/create.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-retail-sales-edit",
    require("../components/supplier/daily-sales-report/retail-sales/edit.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-inquiry-sales-index",
    require("../components/supplier/daily-sales-report/sales-inquiries/index.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-inquiry-sales-edit",
    require("../components/supplier/daily-sales-report/sales-inquiries/edit.vue")
        .default
);

Vue.component(
    "supplier-daily-sales-report-inquiry-sales-create",
    require("../components/supplier/daily-sales-report/sales-inquiries/create.vue")
        .default
);

const app = new Vue({
    el: "#app-supplier",
});

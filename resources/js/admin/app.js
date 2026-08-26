/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
window.moment = require("moment");
window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

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
    "news-articles-list",
    require("../components/admin/articles/list.vue").default
);
Vue.component(
    "sustainable-solutions-list",
    require("../components/admin/articles/sustainable.vue").default
);
Vue.component(
    "solutions-intelligence-list",
    require("../components/admin/articles/intelligence.vue").default
);
Vue.component(
    "ondemand-resources-list",
    require("../components/admin/articles/resources.vue").default
);
Vue.component(
    "events-activities-list",
    require("../components/admin/events/list.vue").default
);
Vue.component(
    "registration-suppliers-list",
    require("../components/admin/registration/supplier/list.vue").default
);
Vue.component(
    "registration-suppliers-view",
    require("../components/admin/registration/supplier/view.vue").default
);
Vue.component(
    "registration-suppliers-add",
    require("../components/admin/registration/supplier/add.vue").default
);
Vue.component(
    "registration-buyers-list",
    require("../components/admin/registration/buyer/list.vue").default
);
Vue.component(
    "registration-conference-list",
    require("../components/admin/registration/conference/list.vue").default
);
Vue.component(
    "registration-sponsorship-list",
    require("../components/admin/registration/sponsorship/list.vue").default
);
Vue.component(
    "registration-buyers-view",
    require("../components/admin/registration/buyer/view.vue").default
);
Vue.component(
    "registration-buyers-add",
    require("../components/admin/registration/buyer/add.vue").default
);
Vue.component(
    "homepage-carousel-list",
    require("../components/admin/carousel/list.vue").default
);
Vue.component(
    "widgets-list",
    require("../components/admin/widgets/list.vue").default
);
Vue.component(
    "certifications-list",
    require("../components/admin/certifications/list.vue").default
);
Vue.component(
    "companies-list",
    require("../components/admin/enablers/companies/list.vue").default
);
Vue.component(
    "programs-offers-list",
    require("../components/admin/enablers/offers/list.vue").default
);
Vue.component(
    "meta-tags-list",
    require("../components/admin/meta/list.vue").default
);
Vue.component(
    "user-accounts-list",
    require("../components/admin/users/list.vue").default
);
Vue.component(
    "pages-list",
    require("../components/admin/pages/list.vue").default
);
Vue.component(
    "conferences-list",
    require("../components/admin/exhibitions/conference/list.vue").default
);
Vue.component(
    "conferences-videos-list",
    require("../components/admin/exhibitions/videos/list.vue").default
);
Vue.component(
    "website-settings",
    require("../components/admin/settings/cache.vue").default
);
Vue.component(
    "dashboard-summary",
    require("../components/admin/summary/dashboard.vue").default
);

Vue.component(
    "promo-codes-email-list",
    require("../components/admin/promo_codes/emails/list.vue").default
);

Vue.component(
    "supplier-payments-list",
    require("../components/admin/payments/supplier/list.vue").default
);

Vue.component(
    "supplier-payment-view",
    require("../components/admin/payments/supplier/view.vue").default
);

Vue.component(
    "supplier-export-sales-view",
    require("../components/admin/daily-sales-report/export-sales/index.vue")
        .default
);

Vue.component(
    "supplier-domestic-sales-view",
    require("../components/admin/daily-sales-report/domestic-sales/index.vue")
        .default
);

Vue.component(
    "supplier-retail-sales-view",
    require("../components/admin/daily-sales-report/retail-sales/index.vue")
        .default
);

Vue.component(
    "supplier-inquiry-sales-view",
    require("../components/admin/daily-sales-report/sales-inquiries/index.vue")
        .default
);

Vue.component(
    "supplier-sales-activity-view",
    require("../components/admin/daily-sales-report/sales-activity/index.vue")
        .default
);

Vue.component(
    "supplier-sales-management-view",
    require("../components/admin/daily-sales-report/sales-management/index.vue")
        .default
);

Vue.component(
    "supplier-sales-management-show",
    require("../components/admin/daily-sales-report/sales-management/show.vue")
        .default
);

Vue.component(
    "conference-delegate-list",
    require("../components/admin/registration/conference_delegates/list.vue")
        .default
);

Vue.component(
    "conference-delegate-view",
    require("../components/admin/registration/conference_delegates/view.vue")
        .default
);

Vue.component(
    "booth-assignment-list",
    require("../components/admin/booth-assignment/list.vue").default
);

Vue.component(
    "booth-assignment-groups",
    require("../components/admin/booth-assignment/group/list.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app-admin",
});

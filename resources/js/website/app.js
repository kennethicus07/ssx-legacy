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
    "registration-supplier-email_verification",
    require("../components/website/registration/supplier/email_verification_supplier.vue")
        .default
);

Vue.component(
    "registration-exhibitor-email_verification",
    require("../components/website/registration/exhibitor/email_verification.vue")
        .default
);
Vue.component(
    "registration-exhibitor-registration",
    require("../components/website/registration/exhibitor/registration.vue")
        .default
);
Vue.component(
    "registration-buyer-email_verification",
    require("../components/website/registration/buyer/email_verification.vue")
        .default
);
Vue.component(
    "registration-buyer-registration",
    require("../components/website/registration/buyer/registration.vue").default
);
Vue.component(
    "registration-conference-registration",
    require("../components/website/conference/registration.vue").default
);

Vue.component(
    "contact-us-form",
    require("../components/website/contactus.vue").default
);
Vue.component(
    "subscription-form",
    require("../components/website/subscription.vue").default
);
Vue.component(
    "popup-subscription-form",
    require("../components/website/popup_subscription.vue").default
);
Vue.component(
    "popup-login-form",
    require("../components/website/popup-login-form.vue").default
);
Vue.component("widgets", require("../components/website/widget.vue").default);
Vue.component(
    "articles",
    require("../components/website/articles/articles.vue").default
);
Vue.component(
    "on-demand-resources",
    require("../components/website/ondemand.vue").default
);
Vue.component(
    "sustainable-solutions",
    require("../components/website/sustainable-solutions.vue").default
);
Vue.component(
    "solutions-intelligence",
    require("../components/website/solutions-intelligence.vue").default
);
Vue.component(
    "solutions-directories",
    require("../components/website/companies.vue").default
);
Vue.component(
    "solutions-directories-suppliers",
    require("../components/website/suppliers.vue").default
);
Vue.component(
    "solutions-sustainable-suppliers",
    require("../components/website/sustainable_suppliers.vue").default
);
Vue.component(
    "certifications",
    require("../components/website/certifications.vue").default
);
Vue.component(
    "export-enablers",
    require("../components/website/export_enablers.vue").default
);
Vue.component(
    "global-search",
    require("../components/website/search.vue").default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app-website",
});

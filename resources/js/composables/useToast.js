// resources/js/composables/useToast.js
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

export default function useToast(Vue) {
    Vue.use(VueToast);

    const success = (message, options = {}) => {
        Vue.$toast.success(message, {
            position: "top-right",
            duration: 3000,
            ...options,
        });
    };

    const error = (message, options = {}) => {
        Vue.$toast.error(message, {
            position: "top-right",
            duration: 4000,
            ...options,
        });
    };

    const info = (message, options = {}) => {
        Vue.$toast.info(message, {
            position: "top-right",
            duration: 3000,
            ...options,
        });
    };

    return { success, error, info };
}

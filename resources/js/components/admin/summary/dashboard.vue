<template>
    <div class="row">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="py-2">
            <div class="mb-4">
                <SupplierDashboard />
            </div>

            <div class="mb-4">
                <PurchaserDashboard />
            </div>

            <div class="mb-4">
                <ConferenceDelegates />
            </div>
        </div>
    </div>
</template>

<script>
import BlockUI from "vue-blockui";
import SupplierDashboard from "./supplier-dashboard.vue";
import PurchaserDashboard from "./purchaser-dashboard.vue";
import ConferenceDelegates from "./conference-delegates.vue";

Vue.use(BlockUI);

export default {
    components: {
        SupplierDashboard,
        PurchaserDashboard,
        ConferenceDelegates,
    },

    data() {
        return {
            isLoading: true,

            msg: "Loading...",
        };
    },

    mounted() {
        this.isLoading = false;
    },
};
</script>

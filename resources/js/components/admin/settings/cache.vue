<template>
    <div>
        <div class="row">
            <BlockUI :message="msg" v-show="isLoading">
                <div class="fa-3x">
                    <i class="fas fa-spinner fa-spin lightgreen"></i>
                </div>
            </BlockUI>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Clear Website Cache</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-lg"
                                    @click="doClearCache"
                                >
                                    Clear Cache
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-dark btn-lg"
                                    @click="doClearView"
                                >
                                    Clear Templates
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg"
                                    @click="doClearRoute"
                                >
                                    Clear Route
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-lg"
                                    @click="doClearConfig"
                                >
                                    Clear Config
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cache Website</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-lg"
                                    @click="doCacheConfig"
                                >
                                    Cache Config
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg"
                                    @click="doCacheRoute"
                                >
                                    Cache Route
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button
                                    type="button"
                                    class="btn btn-dark btn-lg"
                                    @click="doCacheView"
                                >
                                    Cache Templates
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import BlockUI from "vue-blockui";

Vue.use(VueToast);
Vue.use(BlockUI);

export default {
    data() {
        return {
            isLoading: false,
            msg: "Please wait...",
        };
    },
    methods: {
        doClearCache() {
            this.isLoading = true;
            this.msg = "Clearing cache...";
            axios
                .get("/api/clear-cache")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success("Cache successfully cleared.", {
                            position: "top-right",
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doClearView() {
            this.isLoading = true;
            this.msg = "Clearing templates...";
            axios
                .get("/api/clear-view")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success("Templates successfully cleared.", {
                            position: "top-right",
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doClearRoute() {
            this.isLoading = true;
            this.msg = "Clearing routes...";
            axios
                .get("/api/clear-route")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success("Route successfully cleared.", {
                            position: "top-right",
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doClearConfig() {
            this.isLoading = true;
            this.msg = "Clearing configuration...";
            axios
                .get("/api/clear-config")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success(
                            "Configuration successfully cleared.",
                            {
                                position: "top-right",
                            }
                        );
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doCacheConfig() {
            this.isLoading = true;
            this.msg = "Caching configuration...";
            axios
                .get("/api/cache-config")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success(
                            "Configuration successfully cached.",
                            {
                                position: "top-right",
                            }
                        );
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doCacheRoute() {
            this.isLoading = true;
            this.msg = "Caching route...";
            axios
                .get("/api/cache-route")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success("Route successfully cached.", {
                            position: "top-right",
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doCacheView() {
            this.isLoading = true;
            this.msg = "Caching templates...";
            axios
                .get("/api/cache-view")
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        Vue.$toast.success("Templates successfully cached.", {
                            position: "top-right",
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

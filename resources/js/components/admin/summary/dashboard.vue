<template>
    <div class="row">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Suppliers/Exhibitors</h5>
                </div>
                <div class="card-body">
                    <div class="card card-hover">
                        <div class="box bg-cyan text-center">
                            <h1 class="font-light text-white">
                                <i class="mdi mdi-account-multiple"></i>
                            </h1>
                            <h5 class="mb-0 mt-1 text-white">
                                {{ supplier_summary.total_registered }}
                            </h5>
                            <small class="font-light text-white"
                                >Total Registered</small
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Suppliers/Exhibitors Status</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-primary text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-check"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ supplier_summary.approved }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Approved</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-danger text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-remove"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ supplier_summary.denied }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Denied</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-warning text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-alert"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ supplier_summary.incomplete }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Incomplete</small
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-info text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-off"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ supplier_summary.onhold }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >On hold</small
                                    >
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-dark text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-star"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ supplier_summary.pending }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Pending</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-secondary text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-edit"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ supplier_summary.reviewed }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Reviewed</small
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchasers/Buyers</h5>
                </div>
                <div class="card-body">
                    <div class="card card-hover">
                        <div class="box bg-cyan text-center">
                            <h1 class="font-light text-white">
                                <i class="mdi mdi-account-multiple"></i>
                            </h1>
                            <h5 class="mb-0 mt-1 text-white">
                                {{ purchaser_summary.total_registered }}
                            </h5>
                            <small class="font-light text-white"
                                >Total Registered</small
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Purchasers/Buyers Status</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-primary text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-check"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ purchaser_summary.approved }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Approved</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-danger text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-remove"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ purchaser_summary.denied }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Denied</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-warning text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-alert"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ purchaser_summary.incomplete }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Incomplete</small
                                    >
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-info text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-off"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ purchaser_summary.onhold }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >On hold</small
                                    >
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-dark text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-star"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ purchaser_summary.pending }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Pending</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2 col-xlg-3">
                            <div class="card card-hover">
                                <div class="box bg-secondary text-center">
                                    <h1 class="font-light text-white">
                                        <i class="mdi mdi-account-edit"></i>
                                    </h1>
                                    <h5 class="mb-0 mt-1 text-white">
                                        {{ purchaser_summary.reviewed }}
                                    </h5>
                                    <small class="font-light text-white"
                                        >Reviewed</small
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BlockUI from "vue-blockui";

Vue.use(BlockUI);

export default {
    data() {
        return {
            isLoading: true,
            msg: "Loading...",
            supplier_summary: [],
            purchaser_summary: [],
        };
    },
    mounted() {
        this.isLoading = false;
    },
    created() {
        this.supplierSummary();
        this.purchaserSummary();
    },
    methods: {
        supplierSummary() {
            axios
                .get("/api/dashboard/suppliers/summary/fair")
                .then((response) => {
                    if (response.status === 200) {
                        this.supplier_summary = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        purchaserSummary() {
            axios
                .get("/api/dashboard/purchasers/summary/fair")
                .then((response) => {
                    if (response.status === 200) {
                        this.purchaser_summary = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

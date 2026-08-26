<template>
    <div>
        <div class="row">
            <!-- FILTER BAR -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <!-- EVENT -->
                            <div class="col-12 col-md-4">
                                <label class="form-label">
                                    Event (Fair Code)
                                </label>

                                <select
                                    class="form-select"
                                    v-model="selectedFairCode"
                                    @change="onFairCodeChange"
                                >
                                    <option
                                        v-for="event in events"
                                        :key="event.id"
                                        :value="event.fair_code"
                                    >
                                        {{ event.fair_code }} —
                                        {{ event.event_name }}
                                    </option>
                                </select>
                            </div>

                            <!-- SEARCHABLE SUPPLIER -->
                            <div class="col-12 col-md-5">
                                <label class="form-label">
                                    Supplier / Exhibitor
                                </label>

                                <multiselect
                                    v-model="selectedSupplier"
                                    :options="suppliers"
                                    :searchable="true"
                                    :close-on-select="true"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    placeholder="Search company..."
                                    label="company"
                                    track-by="user_id"
                                >
                                    <template #option="{ option }">
                                        <div>
                                            <div class="fw-semibold">
                                                {{ option.company }}
                                            </div>
                                        </div>
                                    </template>
                                </multiselect>
                            </div>

                            <!-- ACTION -->
                            <div
                                class="col-12 col-md-3 d-flex justify-content-md-end"
                            >
                                <button
                                    class="btn btn-success text-white"
                                    @click="goToSupplierSales"
                                    :disabled="!selectedSupplier"
                                >
                                    <i
                                        class="mdi mdi-arrow-right-circle-outline me-1"
                                    ></i>

                                    Manage Sales
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SUPPLIER LIST -->
            <div class="col-12 mt-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Available Suppliers</h5>
                    </div>

                    <div class="card-body">
                        <div v-if="isLoading" class="text-center py-5">
                            <div class="spinner-border text-success"></div>
                        </div>

                        <div v-else-if="suppliers.length" class="row g-3">
                            <div
                                class="col-12 col-lg-6"
                                v-for="supplier in suppliers"
                                :key="supplier.user_id"
                            >
                                <div class="supplier-card h-100">
                                    <div
                                        class="d-flex justify-content-between align-items-start"
                                    >
                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                {{ supplier.company }}
                                            </h6>

                                            <div class="small text-muted mt-1">
                                                Event:
                                                {{ supplier.fair_code }}
                                            </div>
                                        </div>

                                        <button
                                            class="btn btn-sm btn-outline-success"
                                            @click="openSupplier(supplier)"
                                        >
                                            <i class="mdi mdi-open-in-new"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center text-muted py-5">
                            No suppliers found.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
    components: {
        Multiselect,
    },

    data() {
        return {
            events: [],

            suppliers: [],

            selectedFairCode: "",

            selectedSupplier: null,

            isLoading: false,
        };
    },

    created() {
        this.getEvents();
    },

    methods: {
        getEvents() {
            axios
                .get("/api/supplier/events")
                .then((response) => {
                    this.events = response.data;

                    if (this.events.length > 0) {
                        this.selectedFairCode = this.events[0].fair_code;

                        this.getSuppliers();
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        getSuppliers() {
            this.isLoading = true;

            axios
                .get("/api/admin/daily-sales-report/sales-management/list", {
                    params: {
                        fair_code: this.selectedFairCode,
                    },
                })
                .then((response) => {
                    this.suppliers = response.data;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        onFairCodeChange() {
            this.selectedSupplier = null;

            this.getSuppliers();
        },

        openSupplier(supplier) {
            window.location.href = `/admin/daily-sales-report/sales-management/${supplier.user_id}?fair_code=${supplier.fair_code}`;
        },

        goToSupplierSales() {
            if (!this.selectedSupplier) {
                return;
            }

            window.location.href = `/admin/daily-sales-report/sales-management/${this.selectedSupplier.user_id}?fair_code=${this.selectedFairCode}`;
        },
    },
};
</script>

<style scoped>
.supplier-card {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 18px;
    background: #fff;
    transition: all 0.2s ease;
}

.supplier-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
}

.form-label {
    font-weight: 600;
    font-size: 13px;
    color: #374151;
}

/* multiselect polish */
.multiselect {
    min-height: 38px;
}

.multiselect__tags {
    border-radius: 0.375rem;
    border-color: #ced4da;
    min-height: 38px;
    padding-top: 6px;
}

.multiselect__option--highlight {
    background: #198754;
}

.multiselect__option--selected {
    background: #d1e7dd;
    color: #000;
}
</style>

<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="card shadow-sm border-0">
                    <!-- HEADER -->
                    <div
                        class="card-header bg-white d-flex justify-content-between align-items-center border-bottom"
                    >
                        <div>
                            <h5 class="mb-0">Create Sales Inquiry</h5>
                            <p class="text-muted small mb-0">
                                Add new inquiry and buyer statistics
                            </p>
                        </div>

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-secondary"
                            @click="goBack"
                        >
                            ← Back
                        </button>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- DATE -->
                            <div class="col-12 col-md-6">
                                <label class="form-label"
                                    >Date of Sale
                                    <span class="text-danger">*</span></label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    :class="{
                                        'is-invalid':
                                            validationErrors.date_of_sale,
                                    }"
                                    v-model="form.date_of_sale"
                                    :min="eventDateRestriction.getMinDate()"
                                    :max="eventDateRestriction.getMaxDate()"
                                    @input="validationErrors.date_of_sale = ''"
                                />
                                <p
                                    v-if="validationErrors.date_of_sale"
                                    class="text-danger small mt-1 mb-0"
                                >
                                    {{ validationErrors.date_of_sale }}
                                </p>
                            </div>

                            <!-- NO OF INQUIRIES -->
                            <div class="col-12 col-md-6">
                                <label class="form-label"
                                    >No. of Inquiries</label
                                >
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="form.no_of_inquiries"
                                />
                            </div>

                            <!-- NO OF BUYERS -->
                            <div class="col-12 col-md-6">
                                <label class="form-label"
                                    >No. of Buyers Met</label
                                >
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model="form.no_of_buyers_met"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-end">
                            <button
                                type="button"
                                class="btn btn-light me-2"
                                @click="goBack"
                            >
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary px-5"
                                :disabled="isSubmitting"
                                @click="storeInquiry"
                            >
                                <span v-if="isSubmitting">Saving...</span>
                                <span v-else>Create Inquiry</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid:focus {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.15) !important;
}
</style>

<script>
import useToast from "../../../../composables/useToast";
import VueSweetalert2 from "vue-sweetalert2";
import VueToast from "vue-toast-notification";
import "sweetalert2/dist/sweetalert2.min.css";
import "vue-toast-notification/dist/theme-sugar.css";
import useEventDateRestriction from "../../../../composables/useEventDateRestriction";

Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    props: ["params"],

    data() {
        return {
            isSubmitting: false,
            toast: null,
            eventDateRestriction: null,

            form: {
                date_of_sale: "",
                no_of_inquiries: 0,
                no_of_buyers_met: 0,
            },
            validationErrors: {
                date_of_sale: "",
            },
        };
    },

    created() {
        this.toast = useToast(Vue);
        this.eventDateRestriction = useEventDateRestriction();
    },

    methods: {
        storeInquiry() {
            this.validationErrors = {
                date_of_sale: "",
            };

            let hasError = false;

            if (!this.form.date_of_sale) {
                this.validationErrors.date_of_sale = "Must input date of sale";
                hasError = true;
            }

            if (hasError) {
                this.toast.error("Please complete required fields");
                return;
            }

            this.isSubmitting = true;

            axios
                .post(`/supplier/daily-sales-report/inquiries/store`, this.form)
                .then((res) => {
                    this.toast.success("Inquiry saved successfully!");

                    this.resetForm();
                })
                .catch((error) => {
                    console.error(error);

                    this.toast.error("Failed to save inquiry sale.");
                })
                .finally(() => {
                    this.isSubmitting = false;
                });
        },
        resetForm() {
            this.form = {
                date_of_sale: "",
                no_of_inquiries: 0,
                no_of_buyers_met: 0,
            };
        },

        goBack() {
            window.location.href = "/supplier/daily-sales-report/inquiries";
        },
    },
};
</script>

<style scoped>
.card {
    border-radius: 12px;
}

.card-header,
.card-footer {
    background: #fff;
}

.form-label {
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 6px;
}

.form-control {
    min-height: 42px;
}

.btn {
    min-width: 120px;
}
</style>

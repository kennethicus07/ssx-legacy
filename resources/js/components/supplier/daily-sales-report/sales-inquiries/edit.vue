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
                            <h5 class="mb-0">Edit Sales Inquiry</h5>
                            <p class="text-muted small mb-0">
                                Update inquiry and buyer statistics
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
                                <label class="form-label">Date of Sale</label>

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
                                class="btn btn-danger me-2"
                                :disabled="isSubmitting"
                                @click="deleteInquiry"
                            >
                                Delete
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary px-5"
                                :disabled="isSubmitting"
                                @click="updateInquiry"
                            >
                                <span> Update Inquiry </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import useToast from "../../../../composables/useToast";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VueToast from "vue-toast-notification";
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
        this.getInquiry();
        this.eventDateRestriction = useEventDateRestriction();
    },

    methods: {
        getInquiry() {
            axios
                .get(
                    `/supplier/daily-sales-report/inquiries/${this.params.inquiry_id}`
                )
                .then((res) => {
                    const inquiry = res.data.data;

                    this.form = {
                        date_of_sale: this.toInputDate(inquiry.date_of_sale),
                        no_of_inquiries: inquiry.no_of_inquiries ?? 0,
                        no_of_buyers_met: inquiry.no_of_buyers_met ?? 0,
                    };
                })
                .catch(() => {
                    this.toast.error("Failed to load inquiry data");
                });
        },

        updateInquiry() {
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

            axios
                .put(
                    `/supplier/daily-sales-report/inquiries/${this.params.inquiry_id}`,
                    this.form
                )
                .then(() => {
                    this.toast.success("Inquiry sale updated successfully");
                })
                .catch(() => {
                    this.toast.error("Failed to update inquiry sale");
                })
                .finally(() => {
                    this.isSubmitting = false;
                });
        },
        deleteInquiry() {
            this.$swal({
                title: "Delete Inquiry Sale?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (!result.isConfirmed) return;

                axios
                    .delete(
                        `/supplier/daily-sales-report/inquiries/${this.params.inquiry_id}`
                    )
                    .then(() => {
                        this.$swal({
                            title: "Deleted!",
                            text: "Inquiries has been deleted.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        // redirect back after delete
                        setTimeout(() => {
                            this.goBack();
                        }, 1500);
                    })
                    .catch(() => {
                        this.$swal({
                            title: "Error!",
                            text: "Failed to delete retail sale.",
                            icon: "error",
                        });
                    });
            });
        },

        toInputDate(date) {
            if (!date) return "";
            return new Date(date).toISOString().split("T")[0];
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

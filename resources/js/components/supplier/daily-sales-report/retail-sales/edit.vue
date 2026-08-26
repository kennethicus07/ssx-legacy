<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-12 col-xl-9">
                <div class="card shadow-sm border-0">
                    <!-- HEADER -->
                    <div
                        class="pt-4 card-header bg-white d-flex justify-content-between align-items-center border-bottom"
                    >
                        <div>
                            <h5 class="mb-0">Edit Retail Sale</h5>
                            <p class="text-muted">
                                Update retail transaction details
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

                    <div class="card-body">
                        <!-- SECTION 1 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="step-circle-retail me-2">1</span>
                                <h6 class="mb-0">Event & Product</h6>
                            </div>

                            <div class="row g-3">
                                <!-- EVENT (LOCKED) -->
                                <div class="col-md-6">
                                    <label class="form-label">Event</label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.fair_code"
                                        disabled
                                    />
                                </div>

                                <!-- PRODUCT -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Product / Service
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                validationErrors.sub_category_id,
                                        }"
                                        v-model="form.sub_category_id"
                                        @change="
                                            validationErrors.sub_category_id =
                                                ''
                                        "
                                    >
                                        <option value="">-- Select --</option>

                                        <optgroup
                                            v-for="category in categories"
                                            :key="category.id"
                                            :label="category.name"
                                        >
                                            <option
                                                v-for="sub in category.sub_categories"
                                                :key="sub.id"
                                                :value="sub.id"
                                            >
                                                {{ sub.name }}
                                            </option>
                                        </optgroup>
                                    </select>
                                    <p
                                        v-if="validationErrors.sub_category_id"
                                        class="text-danger small mt-1 mb-0"
                                    >
                                        {{ validationErrors.sub_category_id }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 hr-custom" />

                        <!-- SECTION 2 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="step-circle-retail me-2">2</span>
                                <h6 class="mb-0">Buyer Information</h6>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Type of Purchaser / Buyer
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                validationErrors.type_of_purchaser_buyer,
                                        }"
                                        v-model="form.type_of_purchaser_buyer"
                                        placeholder="General, etc."
                                        @input="
                                            validationErrors.type_of_purchaser_buyer =
                                                ''
                                        "
                                    />
                                    <p
                                        v-if="
                                            validationErrors.type_of_purchaser_buyer
                                        "
                                        class="text-danger small mt-1 mb-0"
                                    >
                                        {{
                                            validationErrors.type_of_purchaser_buyer
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 hr-custom" />

                        <!-- SECTION 3 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="step-circle-retail me-2">3</span>
                                <h6 class="mb-0">Sales Value</h6>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Retail Booked</label
                                    >

                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.booked"
                                            @input="
                                                form.booked =
                                                    numberFormat.onlyNumberWithFormat(
                                                        form.booked
                                                    )
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 hr-custom" />

                        <!-- SECTION 4 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="step-circle-retail me-2">4</span>
                                <h6 class="mb-0">Timeline & Notes</h6>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Date of Sale
                                        <span class="text-danger"
                                            >*</span
                                        ></label
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
                                        @input="
                                            validationErrors.date_of_sale = ''
                                        "
                                    />
                                    <p
                                        v-if="validationErrors.date_of_sale"
                                        class="text-danger small mt-1 mb-0"
                                    >
                                        {{ validationErrors.date_of_sale }}
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Remarks</label>
                                    <textarea
                                        class="form-control"
                                        rows="3"
                                        v-model="form.remarks"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <div
                            class="d-flex justify-content-end pt-3 p-3 rounded"
                        >
                            <button
                                type="button"
                                class="btn btn-danger me-2"
                                :disabled="isSubmitting"
                                @click="deleteSale"
                            >
                                Delete
                            </button>
                            <button
                                type="button"
                                class="btn btn-success px-5"
                                :disabled="isSubmitting"
                                @click="submitForm"
                            >
                                <span class="text-white"
                                    >Update Retail Sale</span
                                >
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
import useNumericInput from "../../../../composables/useNumeric";
import useDateFormat from "../../../../composables/useDateFormat";
import useNumberFormat from "../../../../composables/useNumberFormat";
import useEventDateRestriction from "../../../../composables/useEventDateRestriction";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    props: ["params"],

    data() {
        return {
            isSubmitting: false,
            toast: null,
            numeric: null,
            dateFormat: null,
            numberFormat: null,
            eventDateRestriction: null,
            events: [],
            countries: [],
            categories: [],

            form: {
                fair_code: "",
                sub_category_id: "",
                co_buyer_name: "",
                type_of_purchaser_buyer: "",
                booked: "",
                under_negotiation: "",
                date_of_sale: "",
                remarks: "",
            },
            validationErrors: {
                sub_category_id: "",
                type_of_purchaser_buyer: "",
                date_of_sale: "",
            },
        };
    },

    created() {
        this.toast = useToast(Vue);
        this.numeric = useNumericInput();
        this.dateFormat = useDateFormat();
        this.numberFormat = useNumberFormat();
        this.eventDateRestriction = useEventDateRestriction();

        this.getSale();
        this.getCountries();
        this.getCategories();
    },

    methods: {
        getSale() {
            axios
                .get(
                    `/api/supplier/daily-sales-report/retail-sales/${this.params.sale_id}`
                )
                .then((res) => {
                    const sale = res.data.data;

                    this.form = {
                        fair_code: sale.fair_code,
                        sub_category_id: sale.sub_category_id,
                        co_buyer_name: sale.co_buyer_name,
                        type_of_purchaser_buyer: sale.type_of_purchaser_buyer,
                        booked: this.numberFormat.format(sale.booked),
                        under_negotiation: this.numberFormat.format(
                            sale.under_negotiation
                        ),
                        date_of_sale: this.dateFormat.toInputDate(
                            sale.date_of_sale
                        ),
                        remarks: sale.remarks,
                    };
                });
        },

        getCountries() {
            axios.get("/api/countries").then((res) => {
                this.countries = res.data;
            });
        },

        getCategories() {
            axios.get("/api/categories").then((res) => {
                this.categories = res.data;
            });
        },

        deleteSale() {
            this.$swal({
                title: "Delete Retail Sale?",
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
                        `/supplier/daily-sales-report/retail-sales/${this.params.sale_id}`
                    )
                    .then(() => {
                        this.$swal({
                            title: "Deleted!",
                            text: "Retail sale has been deleted.",
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

        submitForm() {
            this.validationErrors = {
                sub_category_id: "",
                type_of_purchaser_buyer: "",
                date_of_sale: "",
            };

            let hasError = false;

            if (!this.form.sub_category_id) {
                this.validationErrors.sub_category_id =
                    "Must input product / service";
                hasError = true;
            }

            if (!this.form.type_of_purchaser_buyer) {
                this.validationErrors.type_of_purchaser_buyer =
                    "Must input type of purchaser / buyer";
                hasError = true;
            }

            if (!this.form.date_of_sale) {
                this.validationErrors.date_of_sale = "Must input date of sale";
                hasError = true;
            }

            if (hasError) {
                this.toast.error("Please complete required fields");
                return;
            }

            this.isSubmitting = true;

            const payload = {
                ...this.form,
                booked: this.numberFormat.unformat(this.form.booked),
            };

            axios
                .put(
                    `/supplier/daily-sales-report/retail-sales/${this.params.sale_id}`,
                    payload
                )
                .then(() => {
                    this.toast.success("Retail sale updated successfully");
                })
                .catch(() => {
                    this.toast.error("Failed to update retail sale");
                })
                .finally(() => {
                    this.isSubmitting = false;
                });
        },
        goBack() {
            window.location.href = "/supplier/daily-sales-report/retail-sales";
        },
    },
};
</script>

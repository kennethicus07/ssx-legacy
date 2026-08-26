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
                            <h5 class="mb-0">Create Export Sale</h5>
                            <p class="text-muted">
                                Fill in the details to record a new export
                                transaction
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
                                <span class="step-circle-export me-2">1</span>
                                <h6 class="mb-0">Event & Product</h6>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Event </label>
                                    <select
                                        class="form-select"
                                        v-model="form.fair_code"
                                        disabled
                                    >
                                        <option value="">
                                            -- Select Event --
                                        </option>
                                        <option
                                            v-for="event in events"
                                            :key="event.fair_code"
                                            :value="event.fair_code"
                                        >
                                            {{ event.fair_code }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Product / Service
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <!-- Product / Service -->
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
                                        <option value="">
                                            -- Select Product / Service --
                                        </option>

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
                                <span class="step-circle-export me-2">2</span>
                                <h6 class="mb-0">Buyer Information</h6>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Buyer / Company Name<span
                                            class="text-danger"
                                        >
                                            *</span
                                        ></label
                                    >
                                    <!-- Buyer / Company Name -->
                                    <input
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                validationErrors.co_buyer_name,
                                        }"
                                        v-model="form.co_buyer_name"
                                        placeholder="e.g. ABC Trading Ltd."
                                        @input="
                                            validationErrors.co_buyer_name = ''
                                        "
                                    />
                                    <p
                                        v-if="validationErrors.co_buyer_name"
                                        class="text-danger small mt-1 mb-0"
                                    >
                                        {{ validationErrors.co_buyer_name }}
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Country Destination
                                        <span class="text-danger"
                                            >*</span
                                        ></label
                                    >
                                    <!-- Country Destination -->
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                validationErrors.country_destination,
                                        }"
                                        v-model="form.country_destination"
                                        @change="
                                            validationErrors.country_destination =
                                                ''
                                        "
                                    >
                                        <option value="">
                                            -- Select Country --
                                        </option>
                                        <option
                                            v-for="country in filteredCountries"
                                            :key="country.id"
                                            :value="country.id"
                                        >
                                            {{ country.name }}
                                        </option>
                                    </select>
                                    <p
                                        v-if="
                                            validationErrors.country_destination
                                        "
                                        class="text-danger small mt-1 mb-0"
                                    >
                                        {{
                                            validationErrors.country_destination
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 hr-custom" />

                        <!-- SECTION 3 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="step-circle-export me-2">3</span>
                                <h6 class="mb-0">Sales Value</h6>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Export Booked</label
                                    >

                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
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
                                            placeholder="0.00"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        >Under Negotiation</label
                                    >

                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.under_negotiation"
                                            @input="
                                                form.under_negotiation =
                                                    numberFormat.onlyNumberWithFormat(
                                                        form.under_negotiation
                                                    )
                                            "
                                            placeholder="0.00"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 hr-custom" />
                        <!-- SECTION 4 -->
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <span class="step-circle-export me-2">4</span>
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
                                    <!-- Date of Sale -->
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
                                        placeholder="Add optional notes about this sale..."
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
                                class="btn btn-info px-5"
                                :disabled="isSubmitting"
                                @click="submitForm"
                            >
                                <span>Save Export Sale</span>
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
import useNumericInput from "../../../../composables/useNumeric";
import useNumberFormat from "../../../../composables/useNumberFormat";
import useEventDateRestriction from "../../../../composables/useEventDateRestriction";

export default {
    props: ["params"],

    data() {
        return {
            isSubmitting: false,
            toast: null,
            numeric: null,
            numberFormat: null,
            eventDateRestriction: null,

            events: [],
            countries: [],
            categories: [],

            form: {
                fair_code: "",
                sub_category_id: "",
                co_buyer_name: "",
                country_destination: "",
                booked: "",
                under_negotiation: "",
                date_of_sale: "",
                remarks: "",
                sales_type: "EXPORT",
            },
            validationErrors: {
                co_buyer_name: "",
                sub_category_id: "",
                country_destination: "",
                date_of_sale: "",
            },
        };
    },

    created() {
        this.getEvents();
        this.getCountries();
        this.getCategories();
        this.toast = useToast(Vue);
        this.numeric = useNumericInput();
        this.numberFormat = useNumberFormat();
        this.eventDateRestriction = useEventDateRestriction();
    },

    methods: {
        // getEvents() {
        //     axios.get("/api/supplier/events").then((res) => {
        //         this.events = res.data;
        //     });
        // },
        getEvents() {
            axios.get("/api/supplier/events").then((res) => {
                this.events = res.data;

                if (this.events.length > 0) {
                    const latest = this.events[0]; // because backend is latest()
                    this.form.fair_code = latest.fair_code;
                }
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

        submitForm() {
            this.validationErrors = {
                co_buyer_name: "",
                sub_category_id: "",
                country_destination: "",
                date_of_sale: "",
            };

            let hasError = false;

            if (!this.form.co_buyer_name) {
                this.validationErrors.co_buyer_name =
                    "Must input buyer / company name";
                hasError = true;
            }

            if (!this.form.sub_category_id) {
                this.validationErrors.sub_category_id =
                    "Must input product / service";
                hasError = true;
            }

            if (!this.form.country_destination) {
                this.validationErrors.country_destination =
                    "Must input country destination";
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
                under_negotiation: this.numberFormat.unformat(
                    this.form.under_negotiation
                ),
            };

            axios
                .post(
                    "/supplier/daily-sales-report/export-sales/store",
                    payload
                )
                .then((res) => {
                    this.toast.success("Export sale saved successfully!");

                    // reset form (Mailchimp-style UX)
                    this.resetForm();
                })
                .catch((error) => {
                    console.error(error);

                    this.toast.error("Failed to save export sale.");
                })
                .finally(() => {
                    this.isSubmitting = false;
                });
        },
        resetForm() {
            this.form = {
                fair_code: this.form.fair_code,
                sub_category_id: "",
                co_buyer_name: "",
                country_destination: "",
                booked: "",
                under_negotiation: "",
                date_of_sale: "",
                remarks: "",
                sales_type: "EXPORT",
            };
        },

        goBack() {
            window.location.href = "/supplier/daily-sales-report/export-sales";
        },
    },
    computed: {
        filteredCountries() {
            return this.countries.filter(
                (country) => Number(country.id) !== 148
            );
        },
    },
};
</script>

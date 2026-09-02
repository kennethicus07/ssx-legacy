<template>
    <div class="row">
        <!-- LEFT: SOA / Billing Information -->
        <div class="col-md-4 mb-4">
            <div class="card border shadow-sm h-100">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">SOA / Billing Information</h5>

                        <small class="text-muted">
                            Statement and billing details
                        </small>
                    </div>

                    <!-- Company Name -->
                    <div class="mb-3">
                        <label class="form-label text-muted small">
                            Company Name
                        </label>

                        <div class="fw-semibold">
                            {{ conference.company_name || "-" }}
                        </div>
                    </div>

                    <!-- Company Email -->
                    <div class="mb-3">
                        <label class="form-label text-muted small">
                            Company Email Address
                        </label>

                        <div class="fw-semibold">
                            {{ conference.company_email || "-" }}
                        </div>
                    </div>

                    <!-- Registration Number -->
                    <div class="mb-3">
                        <label class="form-label text-muted small">
                            Registration Number
                        </label>

                        <div class="fw-semibold">
                            {{ conference.registration_number || "-" }}
                        </div>
                    </div>

                    <!-- Event Venue -->
                    <div class="mb-3">
                        <label class="form-label text-muted small">
                            Event Venue
                        </label>

                        <div class="fw-semibold">
                            {{
                                conference.event && conference.event.location
                                    ? conference.event.location
                                    : "-"
                            }}
                        </div>
                    </div>

                    <!-- Event Date -->
                    <div class="mb-3">
                        <label class="form-label text-muted small">
                            Event Date
                        </label>

                        <div class="fw-semibold">
                            {{
                                conference.event &&
                                conference.event.formatted_date_range
                                    ? conference.event.formatted_date_range
                                    : "-"
                            }}
                        </div>
                    </div>

                    <hr class="my-4" />

                    <!-- Date Issued -->
                    <div class="mb-3">
                        <label
                            for="date-issued"
                            class="form-label text-muted small"
                        >
                            Date Issued
                        </label>

                        <input
                            id="date-issued"
                            type="date"
                            class="form-control"
                            v-model="billing.date_issued"
                            :disabled="loading"
                        />
                    </div>

                    <!-- Date Due -->
                    <div class="mb-3">
                        <label
                            for="date-due"
                            class="form-label text-muted small"
                        >
                            Date Due
                        </label>

                        <input
                            id="date-due"
                            type="date"
                            class="form-control"
                            v-model="billing.date_due"
                            :disabled="loading"
                        />

                        <small class="text-muted">
                            Leave blank for "IMMEDIATELY".
                        </small>
                    </div>

                    <!-- Prepared By -->
                    <!-- <div class="mb-3">
                        <label
                            for="prepared-by"
                            class="form-label text-muted small"
                        >
                            Prepared By
                        </label>

                        <input
                            id="prepared-by"
                            type="text"
                            class="form-control"
                            v-model="billing.prepared_by"
                            placeholder="-"
                            readonly
                        />
                    </div> -->

                    <hr class="my-4" />

                    <!-- VAT Options -->
                    <div>
                        <label class="form-label text-muted small mb-3">
                            Tax Options
                        </label>
                        <!-- VAT Exempted -->
                        <div class="form-check mb-2">
                            <input
                                id="vat-exempted"
                                type="checkbox"
                                class="form-check-input"
                                v-model="billing.vat_exempted"
                                :disabled="loading"
                                @change="
                                    billing.vat_exempted
                                        ? (billing.vat_zero_exempted = false)
                                        : null
                                "
                            />

                            <label for="vat-exempted" class="form-check-label">
                                VAT Exempted
                            </label>
                        </div>

                        <!-- VAT Zero Exempted -->
                        <div class="form-check">
                            <input
                                id="vat-zero-exempted"
                                type="checkbox"
                                class="form-check-input"
                                v-model="billing.vat_zero_exempted"
                                :disabled="loading"
                                @change="
                                    billing.vat_zero_exempted
                                        ? (billing.vat_exempted = false)
                                        : null
                                "
                            />

                            <label
                                for="vat-zero-exempted"
                                class="form-check-label"
                            >
                                VAT Zero Exempted
                            </label>
                        </div>
                    </div>

                    <hr class="my-4" />

                    <!-- Billing Action -->
                    <!-- Billing Action -->
                    <div class="w-100">
                        <!-- Generate SOA / Billing -->
                        <button
                            v-if="canGenerateBilling"
                            type="button"
                            class="btn btn-primary w-100"
                            @click="generateSoaBilling"
                            :disabled="loading"
                        >
                            <i
                                v-if="loading"
                                class="mdi mdi-loading mdi-spin me-1"
                            ></i>

                            <i
                                v-else
                                class="mdi mdi-file-document-outline me-1"
                            ></i>

                            {{
                                loading
                                    ? "Generating..."
                                    : "Generate SOA/Billing"
                            }}
                        </button>

                        <!-- Submit for Approval -->
                        <button
                            v-if="canSubmitBilling"
                            type="button"
                            class="btn btn-warning w-100 mt-2"
                            @click="submitForApproval"
                            :disabled="loading"
                        >
                            <i class="mdi mdi-send-check-outline me-1"></i>
                            Submit for Approval
                        </button>

                        <!-- For Approval Actions -->

                        <!-- Return to Generated -->
                        <button
                            v-if="canReturnBilling"
                            type="button"
                            class="btn btn-secondary w-100"
                            @click="returnToGenerated"
                            :disabled="loading"
                        >
                            <i class="mdi mdi-arrow-left me-1"></i>
                            Return to Generated
                        </button>

                        <!-- Approve Billing -->
                        <button
                            v-if="canApproveBilling"
                            type="button"
                            class="btn btn-success w-100 mt-2"
                            @click="approveBilling"
                            :disabled="loading"
                        >
                            <i class="mdi mdi-check-circle-outline me-1"></i>
                            Approve Billing
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: SOA / Billing -->
        <div class="col-md-8 mb-4">
            <div class="card border shadow-sm">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div
                        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
                    >
                        <div>
                            <h5 class="fw-bold mb-1">SOA / Billing</h5>

                            <small class="text-muted">
                                Statement of Account and billing information
                            </small>
                        </div>

                        <!-- Status -->
                        <!-- <span
                            v-if="conference.is_billing_generated == 1"
                            class="badge bg-success"
                        >
                            Generated
                        </span>

                        <span v-else class="badge bg-secondary">
                            Not Generated
                        </span> -->
                    </div>

                    <!-- Base Rate -->
                    <div
                        class="d-flex justify-content-between align-items-center bg-light rounded px-3 py-3 mb-4"
                    >
                        <div>
                            <div class="fw-semibold">Base Rate</div>

                            <small class="text-muted">
                                Standard registration rate
                            </small>
                        </div>

                        <div class="fw-semibold">
                            {{ conference.currency }}

                            {{ formatCurrency(conference.base_rate) }}
                        </div>
                    </div>

                    <!-- Charges -->
                    <div class="mb-4">
                        <!-- Column Header -->
                        <div
                            class="row mb-2 px-1 text-uppercase fw-semibold text-muted small"
                        >
                            <div class="col">Charges</div>

                            <div class="col-3 text-end">Amount</div>
                        </div>

                        <!-- Charge Rows -->
                        <div
                            v-for="item in charges"
                            :key="`charge-${item.id}`"
                            class="row align-items-center px-1 py-2 border-bottom"
                        >
                            <!-- Description -->
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <span
                                        v-if="item.count && item.count > 0"
                                        class="text-dark me-2"
                                    >
                                        {{ item.count }} ×
                                    </span>

                                    <span>
                                        {{ item.description }}
                                    </span>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-3 text-end">
                                <span class="fw-semibold">
                                    {{ conference.currency }}

                                    {{ formatCurrency(item.value) }}
                                </span>
                            </div>
                        </div>

                        <!-- Empty -->
                        <div
                            v-if="!charges.length"
                            class="text-muted small px-1 py-3"
                        >
                            No charges.
                        </div>
                    </div>

                    <!-- Discounts -->
                    <div v-if="discounts.length" class="pt-3 mb-4">
                        <!-- Column Header -->
                        <div
                            class="row mb-2 px-1 text-uppercase fw-semibold small text-muted"
                        >
                            <div class="col">DISCOUNTS</div>

                            <div class="col-3 text-end">Amount</div>
                        </div>

                        <!-- Discount Rows -->
                        <div
                            v-for="item in discounts"
                            :key="`discount-${item.id}`"
                            class="row align-items-center px-1 py-2 border-bottom"
                        >
                            <!-- Description -->
                            <div class="col">
                                <div
                                    class="d-flex align-items-center text-danger"
                                >
                                    <span
                                        v-if="item.count && item.count > 0"
                                        class="text-danger me-2"
                                    >
                                        {{ item.count }} ×
                                    </span>

                                    <span>
                                        {{ item.description }}
                                    </span>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-3 text-end">
                                <span class="fw-semibold text-danger">
                                    -
                                    {{ conference.currency }}

                                    {{ formatCurrency(item.value) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="pt-4">
                        <div
                            class="d-flex justify-content-between align-items-center"
                        >
                            <div>
                                <div class="fw-bold fs-5">Amount Payable</div>

                                <small class="text-muted">
                                    Final billing amount
                                </small>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold fs-3 text-success">
                                    {{ conference.currency }}

                                    {{
                                        formatCurrency(conference.final_amount)
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Generated SOA -->
                    <div
                        v-if="conference.soa && conference.soa.soa_url"
                        class="mt-4 pt-4 border-top"
                    >
                        <div class="mb-3">
                            <div class="fw-semibold mb-1">Generated SOA</div>

                            <small class="text-muted">
                                {{ conference.soa.soa_file }}
                            </small>
                        </div>

                        <!-- PDF Preview -->
                        <div
                            class="border rounded overflow-hidden"
                            style="height: 1000px"
                        >
                            <iframe
                                :src="conference.soa.soa_url"
                                width="100%"
                                height="100%"
                                frameborder="0"
                                title="Statement of Account"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SoaBillingTab",

    props: {
        conference: {
            type: Object,
            required: true,
        },

        billing: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            loading: false,
        };
    },

    computed: {
        isSuperAdmin() {
            return (
                this.conference.permissions &&
                this.conference.permissions.is_super_admin
            );
        },

        canGenerateBilling() {
            return (
                this.conference.permissions &&
                (this.conference.permissions.is_super_admin ||
                    this.conference.permissions.can_generate_billing) &&
                Number(this.conference.billing_status) !== 2 &&
                Number(this.conference.billing_status) !== 1
            );
        },

        canSubmitBilling() {
            return (
                this.conference.permissions &&
                (this.conference.permissions.is_super_admin ||
                    this.conference.permissions.can_submit_billing) &&
                Number(this.conference.billing_status) === 3
            );
        },

        canReturnBilling() {
            return (
                this.isSuperAdmin ||
                (this.conference.permissions &&
                    this.conference.permissions.can_return_billing)
            );
        },

        canApproveBilling() {
            return (
                this.isSuperAdmin ||
                (this.conference.permissions &&
                    this.conference.permissions.can_approve_billing)
            );
        },
        canReturnBilling() {
            return (
                this.conference.permissions &&
                (this.conference.permissions.is_super_admin ||
                    this.conference.permissions.can_return_billing) &&
                Number(this.conference.billing_status) === 2
            );
        },

        canApproveBilling() {
            return (
                this.conference.permissions &&
                (this.conference.permissions.is_super_admin ||
                    this.conference.permissions.can_approve_billing) &&
                Number(this.conference.billing_status) === 2
            );
        },
        /*
        |--------------------------------------------------------------------------
        | Charges
        |--------------------------------------------------------------------------
        */

        charges() {
            return (this.conference.conference_breakdown || []).filter(
                (item) =>
                    item.type === "base" ||
                    item.type === "fee" ||
                    item.type === "add_fee"
            );
        },

        /*
        |--------------------------------------------------------------------------
        | Discounts
        |--------------------------------------------------------------------------
        */

        discounts() {
            return (this.conference.conference_breakdown || []).filter(
                (item) =>
                    item.type === "discount" || item.type === "add_discount"
            );
        },
    },

    methods: {
        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        formatCurrency(value) {
            return Number(value || 0).toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },

        /*
        |--------------------------------------------------------------------------
        | Generate SOA / Billing
        |--------------------------------------------------------------------------
        */
        generateSoaBilling() {
            if (!this.billing.date_issued) {
                this.$toast.open({
                    message: "Date Issued is required.",
                    type: "error",
                    duration: 3000,
                });

                return;
            }

            this.$swal({
                title: "Generate SOA/Billing?",
                text: "This will generate the Statement of Account using the billing information provided.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Generate",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                this.loading = true;

                // Tell parent to show BlockUI
                this.$emit("billing-loading", {
                    loading: true,
                    message: "Generating SOA / Billing...",
                });

                axios
                    .post(
                        `/admin/registration/delegates/${this.conference.id}/generate-soa`,
                        {
                            date_issued: this.billing.date_issued,
                            date_due: this.billing.date_due || null,
                            vat_exempted: this.billing.vat_exempted,
                            vat_zero_exempted: this.billing.vat_zero_exempted,
                        }
                    )
                    .then((response) => {
                        this.$swal({
                            icon: "success",
                            title: "SOA/Billing Generated",
                            text: response.data.message,
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.$emit("soa-generated");
                        });
                    })
                    .catch((error) => {
                        if (error.response?.status === 422) {
                            const errors = error.response.data.errors;

                            const firstError = Object.values(errors)[0][0];

                            this.$toast.open({
                                message: firstError,
                                type: "error",
                                duration: 3000,
                            });

                            return;
                        }

                        const message =
                            error.response &&
                            error.response.data &&
                            error.response.data.message
                                ? error.response.data.message
                                : "Unable to generate SOA/Billing.";

                        this.$swal({
                            icon: "error",
                            title: "Generation Failed",
                            text: message,
                        });
                    })
                    .finally(() => {
                        this.loading = false;

                        // Tell parent to hide BlockUI
                        this.$emit("billing-loading", {
                            loading: false,
                            message: "",
                        });
                    });
            });
        },

        submitForApproval() {
            this.$swal({
                title: "Submit for Approval?",
                text: "This will submit the generated SOA/Billing for approval.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Submit",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                this.loading = true;

                this.$swal({
                    title: "Submitting...",
                    text: "Please wait while the SOA/Billing is submitted for approval.",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        this.$swal.showLoading();
                    },
                });

                axios
                    .post(
                        `/admin/registration/delegates/${this.conference.id}/submit-for-approval`
                    )
                    .then((response) => {
                        this.$swal({
                            icon: "success",
                            title: "Submitted for Approval",
                            text: response.data.message,
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.$emit("soa-generated");
                        });
                    })
                    .catch((error) => {
                        const message =
                            error.response &&
                            error.response.data &&
                            error.response.data.message
                                ? error.response.data.message
                                : "Unable to submit SOA/Billing for approval.";

                        this.$swal({
                            icon: "error",
                            title: "Submission Failed",
                            text: message,
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        returnToGenerated() {
            this.$swal({
                title: "Return to Generated?",
                text: "This will return the SOA/Billing to the generated status.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Return",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                this.loading = true;

                axios
                    .post(
                        `/admin/registration/delegates/${this.conference.id}/return-to-generated`
                    )
                    .then((response) => {
                        this.$swal({
                            icon: "success",
                            title: "Returned",
                            text: response.data.message,
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.$emit("soa-generated");
                        });
                    })
                    .catch((error) => {
                        const message =
                            error.response &&
                            error.response.data &&
                            error.response.data.message
                                ? error.response.data.message
                                : "Unable to return SOA/Billing to generated status.";

                        this.$swal({
                            icon: "error",
                            title: "Action Failed",
                            text: message,
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },

        approveBilling() {
            this.$swal({
                title: "Approve Billing?",
                text: "This will approve the generated SOA/Billing and email the Statement of Account to the person who registered the delegate(s).",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Approve",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                this.loading = true;

                axios
                    .post(
                        `/admin/registration/delegates/${this.conference.id}/approve-billing`
                    )
                    .then((response) => {
                        this.$swal({
                            icon: "success",
                            title: "Billing Approved",
                            text: response.data.message,
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.$emit("soa-generated");
                        });
                    })
                    .catch((error) => {
                        const message =
                            error.response &&
                            error.response.data &&
                            error.response.data.message
                                ? error.response.data.message
                                : "Unable to approve SOA/Billing.";

                        this.$swal({
                            icon: "error",
                            title: "Approval Failed",
                            text: message,
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
    },
};
</script>

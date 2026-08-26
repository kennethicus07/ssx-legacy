<template>
    <div>
        <!-- Block UI -->
        <BlockUI :message="msg" v-show="loading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>

        <!-- Content -->
        <div v-if="conference" class="row g-4">
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <!-- Tabs -->
                    <div class="card-header bg-white pb-0">
                        <ul
                            class="nav nav-tabs card-header-tabs"
                            role="tablist"
                        >
                            <!-- Registration -->
                            <li class="nav-item" role="presentation">
                                <a
                                    id="registration-tab"
                                    href="#registration"
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'registration',
                                    }"
                                    role="tab"
                                    :aria-selected="
                                        activeTab === 'registration'
                                    "
                                    @click.prevent="switchTab('registration')"
                                >
                                    <i class="mdi mdi-office-building me-2"></i>
                                    Registration
                                </a>
                            </li>

                            <!-- SOA / Billing -->
                            <li class="nav-item" role="presentation">
                                <a
                                    id="soa-billing-tab"
                                    href="#soa-billing"
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'soa-billing',
                                    }"
                                    role="tab"
                                    :aria-selected="activeTab === 'soa-billing'"
                                    @click.prevent="switchTab('soa-billing')"
                                >
                                    <i
                                        class="mdi mdi-file-document-outline me-2"
                                    ></i>
                                    SOA / Billing
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Registration -->
                            <div
                                id="registration"
                                class="tab-pane"
                                :class="{
                                    'show active': activeTab === 'registration',
                                }"
                                role="tabpanel"
                                aria-labelledby="registration-tab"
                            >
                                <registration-tab
                                    :conference="conference"
                                    @email-loading="handleEmailLoading"
                                />
                            </div>

                            <!-- SOA / Billing -->
                            <div
                                id="soa-billing"
                                class="tab-pane"
                                :class="{
                                    'show active': activeTab === 'soa-billing',
                                }"
                                role="tabpanel"
                                aria-labelledby="soa-billing-tab"
                            >
                                <soa-billing-tab
                                    :conference="conference"
                                    :billing="billing"
                                    @soa-generated="getRegistration"
                                    @billing-loading="handleBillingLoading"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="col-md-3">
                <div
                    class="card shadow-sm border-0 sticky-top"
                    style="top: 20px"
                >
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i
                                class="mdi mdi-lightning-bolt-outline text-success me-2"
                            ></i>
                            Actions
                        </h5>
                    </div>

                    <div class="card-body">
                        <!-- Registration Summary -->
                        <div class="border rounded p-3 mb-4">
                            <!-- Status -->
                            <div
                                class="d-flex justify-content-between align-items-center mb-3"
                            >
                                <span>Status</span>

                                <span
                                    v-if="conference.status == 2"
                                    class="badge bg-success"
                                >
                                    Registered
                                </span>

                                <span
                                    v-else-if="conference.status == 1"
                                    class="badge bg-warning text-dark"
                                >
                                    Pending
                                </span>

                                <span v-else class="badge bg-secondary">
                                    Draft
                                </span>
                            </div>

                            <!-- Review -->
                            <div
                                class="d-flex justify-content-between align-items-center mb-3"
                            >
                                <span>Review</span>

                                <span
                                    v-if="conference.review === 'Yes'"
                                    class="badge bg-success"
                                >
                                    Yes
                                </span>

                                <span v-else class="badge bg-secondary">
                                    No
                                </span>
                            </div>

                            <!-- SOA / Billing -->
                            <div
                                class="d-flex justify-content-between align-items-center"
                            >
                                <span>SOA/Billing</span>

                                <span class="badge" :class="billingStatusClass">
                                    {{ billingStatusText }}
                                </span>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="mb-3">
                            <small class="text-muted d-block">
                                Date Created
                            </small>

                            <strong>
                                {{ conference.created_at | moment("llll") }}
                            </strong>
                        </div>

                        <div class="mb-4">
                            <small class="text-muted d-block">
                                Last Updated
                            </small>

                            <strong>
                                {{ conference.updated_at | moment("llll") }}
                            </strong>
                        </div>

                        <hr />

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <!-- Review -->
                            <button
                                class="btn btn-success text-white"
                                @click="reviewRegistration"
                                v-if="canReview"
                            >
                                <i
                                    v-if="conference.review !== 'Yes'"
                                    class="mdi mdi-check-circle-outline me-1"
                                ></i>

                                <i v-else class="mdi mdi-check-circle me-1"></i>

                                {{
                                    conference.review === "Yes"
                                        ? "Reviewed"
                                        : "Review"
                                }}
                            </button>

                            <!-- Generate QR -->
                            <!-- <button
                                class="btn btn-outline-success"
                                @click="generateAllQr"
                                :disabled="
                                    loading ||
                                    !conference.conference_delegates.length
                                "
                            >
                                <i class="mdi mdi-qrcode me-1"></i>
                                Generate QR
                            </button> -->

                            <!-- SOA / Billing -->
                            <!-- <button
                                class="btn btn-outline-primary"
                                @click="switchTab('soa-billing')"
                            >
                                <i
                                    class="mdi mdi-file-document-outline me-1"
                                ></i>
                                SOA/Billing
                            </button> -->

                            <!-- Back -->
                            <a
                                href="/admin/registration/delegates"
                                class="btn btn-outline-secondary"
                            >
                                <i class="mdi mdi-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Not Found -->
        <div v-else-if="!loading" class="alert alert-danger">
            Registration not found.
        </div>
    </div>
</template>

<script>
import RegistrationTab from "./components/RegistrationTab.vue";
import SoaBillingTab from "./components/SoaBillingTab.vue";

export default {
    components: {
        RegistrationTab,
        SoaBillingTab,
    },

    props: {
        id: {
            type: [String, Number],
            required: true,
        },
    },

    data() {
        return {
            billing: {
                date_issued: "",
                date_due: "",
                prepared_by: "",
                vat_exempted: false,
                vat_zero_exempted: false,
                soa: null,
            },
            loading: false,

            msg: "Please wait...",

            conference: null,

            // Vue controls which tab is active
            activeTab: "registration",
        };
    },

    mounted() {
        /*
         * Determine the initial tab from the URL hash.
         *
         * Example:
         * /details/1#registration
         * /details/1#soa-billing
         */
        this.setInitialTab();

        /*
         * Listen for browser back/forward navigation.
         */
        window.addEventListener("hashchange", this.handleHashChange);

        /*
         * Load registration.
         */
        this.getRegistration();
    },

    beforeDestroy() {
        window.removeEventListener("hashchange", this.handleHashChange);
    },

    methods: {
        /*
         * ------------------------------------------------------------------
         * TAB HANDLING
         * ------------------------------------------------------------------
         */

        setInitialTab() {
            const hash = window.location.hash.replace("#", "");

            if (hash === "registration" || hash === "soa-billing") {
                this.activeTab = hash;
            } else {
                this.activeTab = "registration";

                /*
                 * Set the default URL hash.
                 *
                 * replaceState prevents the browser from adding
                 * an unnecessary history entry.
                 */
                window.history.replaceState(null, "", "#registration");
            }
        },

        switchTab(tab) {
            /*
             * Only allow our two valid tabs.
             */
            if (tab !== "registration" && tab !== "soa-billing") {
                return;
            }

            /*
             * Tell Vue which tab is active.
             */
            this.activeTab = tab;

            /*
             * Update URL hash.
             */
            window.location.hash = tab;
        },

        handleHashChange() {
            const hash = window.location.hash.replace("#", "");

            if (hash === "registration" || hash === "soa-billing") {
                this.activeTab = hash;
            } else {
                this.activeTab = "registration";
            }
        },

        /*
         * ------------------------------------------------------------------
         * EMAIL LOADING
         * ------------------------------------------------------------------
         */

        handleEmailLoading(data) {
            this.loading = data.loading;
            this.msg = data.message;
        },

        handleBillingLoading(data) {
            this.loading = data.loading;
            this.msg = data.message || "Please wait...";
        },

        /*
         * ------------------------------------------------------------------
         * GET REGISTRATION
         * ------------------------------------------------------------------
         */

        getRegistration() {
            this.loading = true;
            this.msg = "Please wait...";

            axios
                .get(`/admin/registration/delegates/${this.id}/details`)
                .then((response) => {
                    this.conference = response.data;
                })
                .catch(() => {
                    this.$toast.open({
                        message: "Unable to load registration.",
                        type: "error",
                        duration: 3000,
                    });
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        /*
         * ------------------------------------------------------------------
         * REVIEW
         * ------------------------------------------------------------------
         */

        reviewRegistration() {
            if (this.conference.review === "Yes") {
                this.$toast.open({
                    message: "This registration has already been reviewed.",
                    type: "warning",
                    duration: 3000,
                });

                return;
            }

            this.$swal({
                title: "Review Registration?",
                text: "This will mark the registration as reviewed and notify Accounting.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Review",
                cancelButtonText: "Cancel",
                reverseButtons: true,
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                this.loading = true;
                this.msg = "Reviewing registration...";

                axios
                    .post(`/admin/registration/delegates/${this.id}/review`)
                    .then((response) => {
                        this.$swal({
                            icon: "success",
                            title: "Registration Reviewed",
                            text: response.data.message,
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.getRegistration();
                        });
                    })
                    .catch((error) => {
                        const message =
                            error.response &&
                            error.response.data &&
                            error.response.data.message
                                ? error.response.data.message
                                : "Unable to review registration.";

                        this.$swal({
                            icon: "error",
                            title: "Review Failed",
                            text: message,
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },

        /*
         * ------------------------------------------------------------------
         * SOA / BILLING
         * ------------------------------------------------------------------
         */

        soaBilling() {
            this.switchTab("soa-billing");
        },

        /*
         * ------------------------------------------------------------------
         * GENERATE QR
         * ------------------------------------------------------------------
         */

        generateAllQr() {
            if (
                !this.conference.conference_delegates ||
                !this.conference.conference_delegates.length
            ) {
                this.$toast.open({
                    message: "No delegates found.",
                    type: "warning",
                    duration: 3000,
                });

                return;
            }

            this.$swal({
                title: "Generate QR Codes?",
                text: `This will generate QR codes for all ${this.conference.conference_delegates.length} delegates.`,
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
                this.msg = "Generating QR codes...";

                axios
                    .post(
                        `/admin/registration/delegates/${this.id}/generate-qr`
                    )
                    .then((response) => {
                        this.$swal({
                            icon: "success",
                            title: "QR Codes Generated",
                            text: response.data.message,
                            confirmButtonText: "OK",
                        }).then(() => {
                            this.getRegistration();
                        });
                    })
                    .catch((error) => {
                        const message =
                            error.response &&
                            error.response.data &&
                            error.response.data.message
                                ? error.response.data.message
                                : "Unable to generate QR codes.";

                        this.$swal({
                            icon: "error",
                            title: "Generation Failed",
                            text: message,
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
    },
    computed: {
        billingStatusText() {
            if (!this.conference) {
                return "Not Generated";
            }

            switch (Number(this.conference.billing_status)) {
                case 0:
                    return "Not Generated";

                case 1:
                    return "Approved";

                case 2:
                    return "For Approval";

                case 3:
                    return "Generated";

                default:
                    return "Unknown";
            }
        },

        billingStatusClass() {
            if (!this.conference) {
                return "bg-secondary";
            }

            switch (Number(this.conference.billing_status)) {
                case 0:
                    return "bg-secondary";

                case 1:
                    return "bg-success";

                case 2:
                    return "bg-warning text-dark";

                case 3:
                    return "bg-primary";

                default:
                    return "bg-secondary";
            }
        },
        canReview() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_review &&
                (this.conference.permissions.is_super_admin ||
                    this.conference.review !== "Yes")
            );
        },
    },
};
</script>

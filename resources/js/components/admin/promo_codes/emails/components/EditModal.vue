<template>
    <div v-if="visible">
        <div class="modal d-block">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Promo Email</h5>
                        <button class="btn-close" @click="close"></button>
                    </div>

                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <!-- Fair Code -->
                            <div class="mb-3">
                                <label class="form-label"
                                    >Event (Fair Code)</label
                                >
                                <select
                                    class="form-select"
                                    v-model="form.fair_code"
                                    @change="fetchPromos"
                                >
                                    <option
                                        v-for="event in events"
                                        :key="event.id"
                                        :value="event.fair_code"
                                    >
                                        {{ event.fair_code }}
                                    </option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Starts At</label>
                                    <input
                                        type="datetime-local"
                                        class="form-control"
                                        v-model="form.starts_at"
                                        required
                                    />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expires At</label>
                                    <input
                                        type="datetime-local"
                                        class="form-control"
                                        v-model="form.expires_at"
                                        required
                                    />
                                </div>
                            </div>

                            <!-- Promo -->
                            <div class="mb-3">
                                <label class="form-label">Promo</label>
                                <select
                                    class="form-select"
                                    v-model="form.promo_id"
                                    @change="onPromoChange"
                                    required
                                >
                                    <option value="">-- Select Promo --</option>
                                    <option
                                        v-for="promo in promos"
                                        :key="promo.id"
                                        :value="promo.id"
                                    >
                                        {{ promo.promo_type_label }}

                                        <span
                                            v-if="
                                                promo.promo_type ===
                                                promo.TYPE_FREE
                                            "
                                        >
                                            — {{ promo.promo_code }}
                                        </span>

                                        <span
                                            v-if="
                                                promo.promo_type ===
                                                promo.TYPE_DISCOUNTED
                                            "
                                        >
                                            —
                                            <span
                                                v-if="
                                                    promo.discount_type ===
                                                    promo.DISCOUNT_PERCENT
                                                "
                                            >
                                                {{ promo.discount_value }}%
                                            </span>

                                            <span
                                                v-if="
                                                    promo.discount_type ===
                                                    promo.DISCOUNT_FIXED
                                                "
                                            >
                                                {{ promo.discount_value }}
                                            </span>
                                        </span>
                                    </option>
                                </select>
                            </div>

                            <!-- Attendee Type -->
                            <div class="mb-3">
                                <label class="form-label">Attendee Type</label>
                                <select
                                    class="form-select"
                                    v-model="form.attendee_type_id"
                                >
                                    <option value="">-- Select --</option>
                                    <option
                                        v-for="type in attendeeTypes"
                                        :key="type.id"
                                        :value="type.id"
                                    >
                                        {{ type.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Promo Code Input for Discounted -->
                            <div
                                class="mb-3 d-flex align-items-center"
                                v-if="
                                    selectedPromo &&
                                    selectedPromo.promo_type ===
                                        selectedPromo.TYPE_DISCOUNTED
                                "
                            >
                                <div class="flex-grow-1">
                                    <label class="form-label"
                                        >Discount Code</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="form.promo_code"
                                        placeholder="Enter discount code"
                                        required
                                    />
                                </div>
                                <button
                                    type="button"
                                    class="btn btn-outline-primary ms-2 mt-4"
                                    @click="generateDiscountedCode"
                                >
                                    Generate
                                </button>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    class="form-control"
                                    v-model="form.email"
                                    type="email"
                                />
                            </div>

                            <div class="text-end">
                                <button
                                    type="button"
                                    class="btn btn-secondary me-2"
                                    @click="close"
                                >
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import useToast from "../../../../../composables/useToast";
import useDateFormat from "../../../../../composables/useDateFormat";

export default {
    props: {
        value: Boolean,
        row: Object,
    },

    data() {
        return {
            events: [],
            promos: [],
            attendeeTypes: [],

            form: {
                id: null,
                email: "",
                fair_code: "",
                promo_id: "",
                promo_code: "",
                starts_at: "",
                expires_at: "",
                attendee_type_id: "",
            },
            selectedPromo: null,
        };
    },

    computed: {
        visible: {
            get() {
                return this.value;
            },
            set(v) {
                this.$emit("input", v);
            },
        },
    },

    watch: {
        value(val) {
            if (val && this.row) {
                this.loadForm();
            }
        },
    },

    created() {
        this.toast = useToast(Vue);
        this.fetchEvents();
        this.fetchAttendeeTypes();
        const { toInputDateTime } = useDateFormat();
        this.toInputDateTime = toInputDateTime;
    },

    methods: {
        loadForm() {
            this.form = {
                id: this.row.id,
                email: this.row.co_email,
                fair_code: this.row.fair_code,
                promo_id: this.row.promo_id,
                starts_at: this.toInputDateTime(this.row.starts_at),
                expires_at: this.toInputDateTime(this.row.expires_at),
                promo_code: this.row.promo_code,
                attendee_type_id: this.row.attendee_type_id,
            };

            this.selectedPromo = null;
            this.fetchPromos();
        },
        close() {
            this.visible = false;
        },

        fetchEvents() {
            axios
                .get("/api/supplier/events")
                .then((res) => (this.events = res.data));
        },

        fetchAttendeeTypes() {
            axios
                .get("/api/attendee-types")
                .then((res) => (this.attendeeTypes = res.data));
        },
        fetchPromos() {
            axios
                .post("/api/promo-codes/promos", {
                    fair_code: this.form.fair_code,
                })
                .then((res) => {
                    this.promos = res.data;

                    // Find the currently assigned promo
                    this.selectedPromo = this.promos.find(
                        (p) => p.id == this.form.promo_id
                    );

                    // If promo doesn't exist anymore, reset it
                    if (!this.selectedPromo) {
                        this.form.promo_id = "";
                        return;
                    }

                    // If it's a FREE promo, ensure the code is the promo's code
                    if (
                        this.selectedPromo.promo_type ===
                        this.selectedPromo.TYPE_FREE
                    ) {
                        this.form.promo_code = this.selectedPromo.promo_code;
                    }
                });
        },
        async loadAllowedAttendeeTypes() {
            if (!this.form.promo_id) {
                this.attendeeTypes = [];
                return;
            }

            try {
                const res = await axios.post(
                    "/api/promo-codes/allowed-attendee-types",
                    {
                        promo_id: this.form.promo_id,
                    }
                );

                this.attendeeTypes = res.data;
            } catch (e) {
                this.attendeeTypes = [];
            }
        },

        async generateDiscountedCode() {
            if (
                !this.form.email ||
                !this.form.promo_id ||
                !this.form.fair_code
            ) {
                alert("Enter recipient email, select promo, and event first!");
                return;
            }

            try {
                const res = await axios.post(
                    "/admin/promo-codes/generate-code",
                    {
                        email: this.form.email,
                        promo_id: this.form.promo_id,
                        fair_code: this.form.fair_code,
                    }
                );

                this.form.promo_code = res.data.code;
            } catch (err) {
                console.error(err);
                alert("Failed to generate code. Try again.");
            }
        },

        async onPromoChange() {
            this.selectedPromo = this.promos.find(
                (p) => p.id === this.form.promo_id
            );

            if (this.selectedPromo) {
                this.form.starts_at = this.toInputDateTime(
                    this.selectedPromo.starts_at
                );
                this.form.expires_at = this.toInputDateTime(
                    this.selectedPromo.expires_at
                );
            } else {
                this.form.starts_at = "";
                this.form.expires_at = "";
            }

            if (
                this.selectedPromo &&
                this.selectedPromo.promo_type === this.selectedPromo.TYPE_FREE
            ) {
                this.form.promo_code = this.selectedPromo.promo_code;
            } else {
                this.form.promo_code = "";
            }

            // Reset attendee type
            this.form.attendee_type_id = "";

            // Fetch allowed attendee types
            try {
                const res = await axios.post(
                    "/api/promo-codes/allowed-attendee-types",
                    { promo_id: this.form.promo_id }
                );

                this.attendeeTypes = res.data;
            } catch (error) {
                console.error(error);
                this.attendeeTypes = [];
            }
        },

        submitForm() {
            axios
                .put(`/admin/promo-codes/users/${this.form.id}`, {
                    email: this.form.email,
                    fair_code: this.form.fair_code,
                    promo_id: this.form.promo_id,
                    starts_at: this.form.starts_at,
                    expires_at: this.form.expires_at,
                    promo_code: this.form.promo_code,
                    attendee_type_id: this.form.attendee_type_id,
                })
                .then(() => {
                    this.toast.success(
                        "Promo assignment updated successfully."
                    );

                    this.close();
                    this.$emit("refresh");
                })
                .catch((error) => {
                    if (error.response?.data?.message) {
                        this.toast.error(error.response.data.message);
                    } else {
                        this.toast.error("Update failed.");
                    }
                });
        },
    },
};
</script>

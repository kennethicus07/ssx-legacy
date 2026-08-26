<template>
    <div v-if="visible">
        <div class="modal fade show" tabindex="-1">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Promo Email</h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <!-- Event Select -->
                            <div class="mb-3">
                                <label class="form-label"
                                    >Event (Fair Code)</label
                                >
                                <select
                                    class="form-select"
                                    v-model="form.fair_code"
                                    @change="fetchPromos"
                                    required
                                >
                                    <option value="">-- Select --</option>
                                    <option
                                        v-for="event in events"
                                        :key="event.id"
                                        :value="event.fair_code"
                                    >
                                        {{ event.fair_code }}
                                    </option>
                                </select>
                            </div>
                            <!-- Validity Period -->
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

                            <!-- Promo Select -->
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
                                    required
                                >
                                    <option value="">
                                        -- Select Attendee Type --
                                    </option>
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

                            <!-- Redeemer Email -->
                            <div class="mb-3">
                                <label class="form-label">Redeemer Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="form.email"
                                    placeholder="Enter redeemer email"
                                    required
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
                                    Create
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
import useToast from "../../../.././../composables/useToast";
import useDateFormat from "../../../../../composables/useDateFormat";
export default {
    props: { value: Boolean },
    data() {
        return {
            events: [],
            promos: [],
            attendeeTypes: [],
            form: {
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
    created() {
        this.fetchEvents();
        this.toast = useToast(Vue);
        const { toInputDateTime } = useDateFormat();
        this.toInputDateTime = toInputDateTime;
    },
    computed: {
        visible: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit("input", val);
            },
        },
    },
    watch: {
        value(newVal) {
            if (newVal) {
                this.form.email = "";
                this.form.promo_id = "";
                this.form.promo_code = "";
                (this.form.starts_at = ""),
                    (this.form.expires_at = ""),
                    (this.selectedPromo = null);
            }
        },
    },
    methods: {
        close() {
            this.visible = false;
        },

        fetchEvents() {
            axios.get("/api/supplier/events").then((res) => {
                this.events = res.data;
                if (this.events.length) {
                    const latestEvent = this.events[this.events.length];
                    this.form.fair_code = latestEvent.fair_code;
                    this.fetchPromos();
                }
            });
        },

        fetchPromos() {
            if (!this.form.fair_code) {
                this.promos = [];
                this.form.promo_id = "";
                this.selectedPromo = null;
                return;
            }

            axios
                .post(`/api/promo-codes/promos`, {
                    fair_code: this.form.fair_code,
                })
                .then((res) => {
                    this.promos = res.data;

                    if (this.promos.length) {
                        const latestPromo = this.promos[this.promos.length - 1];
                        this.form.promo_id = latestPromo.id;
                        this.form.starts_at = this.toInputDateTime(
                            latestPromo.starts_at
                        );
                        this.form.expires_at = this.toInputDateTime(
                            latestPromo.expires_at
                        );
                        this.selectedPromo = latestPromo;

                        if (latestPromo.promo_type === latestPromo.TYPE_FREE) {
                            this.form.promo_code = latestPromo.promo_code;
                        } else {
                            this.form.promo_code = "";
                        }
                    } else {
                        this.form.promo_id = "";
                        (this.form.starts_at = ""), (this.form.expires_at = "");
                        this.selectedPromo = null;
                        this.form.promo_code = "";
                    }
                });
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

            this.form.attendee_type_id = "";

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

        submitForm() {
            const payload = { ...this.form };

            axios
                .post("/admin/promo-codes/users/store", payload)
                .then(() => {
                    this.toast.success("Promo email created.");
                    this.close();
                    this.$emit("refresh");
                })
                .catch((err) => {
                    console.error(err);
                    this.toast.error("Failed to create promo email.");
                });
        },
    },
};
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}
.modal.fade.show {
    display: block;
    z-index: 1050;
}
</style>

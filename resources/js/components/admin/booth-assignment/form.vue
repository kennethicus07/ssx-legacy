<template>
    <transition name="fade">
        <div v-if="show" class="modal-backdrop-custom">
            <div class="modal-card">
                <div class="card shadow-lg border-0">
                    <!-- Header -->
                    <div
                        class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                    >
                        <h5 class="mb-0">
                            {{ isEdit ? "Edit Assignment" : "Add Assignment" }}
                        </h5>

                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            @click="$emit('close')"
                            :disabled="saving"
                        >
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Event -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Event (Fair Code)
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                v-model="form.fair_code"
                                class="form-select"
                                :disabled="saving"
                            >
                                <option value="">Select event</option>

                                <option
                                    v-for="event in events"
                                    :key="event.id"
                                    :value="event.fair_code"
                                >
                                    {{ event.fair_code }}
                                </option>
                            </select>

                            <div
                                v-if="errors.fair_code"
                                class="text-danger small mt-1"
                            >
                                {{ errors.fair_code }}
                            </div>
                        </div>

                        <!-- Assignment Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Assignment Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                v-model="form.name"
                                type="text"
                                class="form-control"
                                :class="{
                                    'is-invalid': errors.name,
                                }"
                                placeholder="e.g. Main Booth Assignment"
                                :disabled="saving"
                            />

                            <div v-if="errors.name" class="invalid-feedback">
                                {{ errors.name }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="card-footer bg-white d-flex justify-content-end"
                    >
                        <button
                            type="button"
                            class="btn btn-light me-2"
                            @click="$emit('close')"
                            :disabled="saving"
                        >
                            Cancel
                        </button>

                        <button
                            type="button"
                            class="btn btn-success text-white"
                            :disabled="saving"
                            @click="submit"
                        >
                            <span
                                v-if="saving"
                                class="spinner-border spinner-border-sm me-2"
                            ></span>

                            {{
                                isEdit ? "Update Assignment" : "Save Assignment"
                            }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "BoothSystemAssignmentForm",

    props: {
        show: {
            type: Boolean,
            default: false,
        },

        events: {
            type: Array,
            default: () => [],
        },

        assignment: {
            type: Object,
            default: null,
        },
    },

    data() {
        return {
            saving: false,

            errors: {},

            form: {
                id: null,
                fair_code: "",
                name: "",
            },
        };
    },

    computed: {
        isEdit() {
            return !!this.form.id;
        },
    },

    watch: {
        assignment: {
            immediate: true,

            handler(value) {
                if (value) {
                    this.form = {
                        id: value.id,
                        fair_code: value.fair_code || "",
                        name: value.name || "",
                    };
                } else {
                    this.resetForm();
                }
            },
        },

        show(value) {
            if (value && !this.assignment) {
                this.resetForm();

                if (this.events.length > 0) {
                    this.form.fair_code = this.events[0].fair_code;
                }
            }
        },
    },

    methods: {
        submit() {
            this.errors = {};

            if (!this.form.fair_code) {
                this.errors.fair_code = "The event field is required.";
            }

            if (!this.form.name) {
                this.errors.name = "The assignment name field is required.";
            }

            if (Object.keys(this.errors).length > 0) {
                return;
            }

            this.saving = true;

            const request = this.isEdit
                ? axios.put(`/admin/booth-system/assignments/${this.form.id}`, {
                      fair_code: this.form.fair_code,
                      name: this.form.name,
                  })
                : axios.post("/admin/booth-system/assignments", {
                      fair_code: this.form.fair_code,
                      name: this.form.name,
                  });

            request
                .then((response) => {
                    this.$toast.success(
                        this.isEdit
                            ? "Assignment successfully updated."
                            : "Assignment successfully added.",
                        {
                            position: "top-right",
                        }
                    );

                    this.$emit("saved", response.data);

                    this.$emit("close");

                    this.resetForm();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    } else {
                        const message =
                            error.response?.data?.message ||
                            "Failed to save assignment.";

                        this.$toast.error(message, {
                            position: "top-right",
                        });
                    }
                })
                .finally(() => {
                    this.saving = false;
                });
        },

        resetForm() {
            this.form = {
                id: null,
                fair_code: "",
                name: "",
            };

            this.errors = {};
        },
    },
};
</script>

<style scoped>
.modal-backdrop-custom {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-card {
    width: 100%;
    max-width: 650px;
}

.fade-enter-active,
.fade-leave-active {
    transition: 0.2s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>

<template>
    <transition name="fade">
        <div v-if="show" class="modal-backdrop-custom">
            <div class="modal-card">
                <div class="card shadow-lg border-0">
                    <!-- Header -->
                    <div
                        class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                    >
                        <h5 class="mb-0">Additional Fee</h5>

                        <button
                            class="btn btn-sm btn-light"
                            @click="$emit('close')"
                        >
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Description
                            </label>

                            <input
                                v-model="form.description"
                                type="text"
                                class="form-control"
                                placeholder="e.g. Late Registration Fee"
                            />
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Quantity
                                </label>

                                <input
                                    v-model.number="form.count"
                                    type="number"
                                    min="1"
                                    class="form-control"
                                />
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">
                                    Amount
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        {{ conferenceCurrency }}
                                    </span>

                                    <input
                                        v-model.number="form.value"
                                        type="number"
                                        step="0.01"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="card-footer bg-white d-flex justify-content-end"
                    >
                        <button
                            class="btn btn-light me-2"
                            @click="$emit('close')"
                        >
                            Cancel
                        </button>

                        <button
                            class="btn btn-success text-white"
                            :disabled="saving"
                            @click="submit"
                        >
                            <span
                                v-if="saving"
                                class="spinner-border spinner-border-sm me-2"
                            ></span>

                            Save Fee
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        show: Boolean,

        conferenceId: {
            type: Number,
            required: true,
        },
        conferenceCurrency: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            saving: false,

            form: {
                description: "",
                count: 1,
                value: null,
            },
        };
    },

    methods: {
        submit() {
            this.saving = true;

            axios
                .post(
                    `/admin/registration/delegates/breakdown/${this.conferenceId}/add-fee`,
                    this.form
                )
                .then((response) => {
                    this.$toast.success("Additional fee added.", {
                        position: "top-right",
                    });

                    this.$emit("saved", response.data);

                    this.$emit("close");

                    this.form = {
                        description: "",
                        count: 1,
                        value: null,
                    };
                })
                .finally(() => {
                    this.saving = false;
                });
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

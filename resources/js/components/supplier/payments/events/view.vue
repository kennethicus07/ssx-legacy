<template>
    <div>
        <!-- Loading Block -->
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>

        <div class="row">
            <!-- LEFT: PAYMENT UPLOAD -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="text-left mb-1 mt-4">
                                <h1 class="h3">Event Payment</h1>
                                <p>*Upload your proof of payment</p>
                            </div>

                            <div class="row g-3">
                                <!-- EVENT NAME -->
                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Event Name</label
                                    >
                                    <div class="form-control bg-light">
                                        {{ event.event_name }}
                                    </div>
                                </div>

                                <!-- PAYMENT UPLOAD -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Upload Payment Proof*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgentPayment"
                                        :multiple="true"
                                        :deletable="true"
                                        :linkable="false"
                                        :meta="false"
                                        :accept="'image/*,application/pdf'"
                                        :maxSize="'2MB'"
                                        :maxFiles="3"
                                        v-model="payment.proof"
                                        @select="onSelectPayment"
                                        @beforedelete="onBeforeDeletePayment"
                                        @delete="onDeletePayment"
                                    />
                                    <div class="form-text">
                                        Upload up to 3 clear screenshots or
                                        photos of your payment. Max 2MB per
                                        file.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: ACTIONS -->
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Actions</h5>
                    <div class="card-body">
                        <div class="row">
                            <!-- PAYMENT STATUS BADGE -->
                            <div class="col-12" v-if="attendance.id">
                                <p :class="paymentBadge().class">
                                    {{ paymentBadge().label }}
                                </p>
                            </div>

                            <!-- DATE CREATED -->
                            <div class="col-12 mt-2" v-if="attendance.id">
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :value="
                                            attendance.created_at
                                                ? $moment(
                                                      attendance.created_at
                                                  ).format('llll')
                                                : ''
                                        "
                                        readonly
                                    />
                                    <label>Date Created</label>
                                </div>
                            </div>

                            <!-- DATE LAST MODIFIED -->
                            <div
                                class="col-12 mt-2"
                                v-if="attendance.id && attendance.updated_at"
                            >
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :value="
                                            attendance.updated_at
                                                ? $moment(
                                                      attendance.updated_at
                                                  ).format('llll')
                                                : ''
                                        "
                                        readonly
                                    />
                                    <label>Date Last Modified</label>
                                </div>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="form-group row">
                            <hr class="w-100 mt-3" />
                            <div class="d-grid gap-2 mb-2">
                                <button
                                    v-if="attendance.id"
                                    type="button"
                                    class="btn btn-success text-white"
                                    :disabled="isPaymentPending"
                                    @click="submitPayment"
                                >
                                    {{
                                        isPaymentPending
                                            ? attendance.payment_status === 1
                                                ? "Paid"
                                                : "Payment Pending"
                                            : "Submit Payment"
                                    }}
                                </button>
                            </div>
                            <div class="d-grid gap-2">
                                <a
                                    href="/supplier/payments/event-list"
                                    class="btn btn-secondary"
                                    role="button"
                                >
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";
import BlockUI from "vue-blockui";
import "vue-blockui/dist/vue-blockui.css";

export default {
    props: ["attendance", "event"],

    data() {
        return {
            isLoading: false,
            msg: "Uploading...",
            payment: {
                proof: [], // all files for display
                proof_for_upload: [],
                deleted_ids: [],
            },
        };
    },

    mounted() {
        this.getLatestPayment();
    },

    methods: {
        // Payment badge
        paymentBadge() {
            const status = this.attendance.payment_status;
            switch (status) {
                case 1:
                    return {
                        label: "Paid",
                        class: "fs-3 p-3 mb-2 bg-success text-white",
                    };
                case 2:
                    return {
                        label: "Pending",
                        class: "fs-3 p-3 mb-2 bg-warning text-white",
                    };
                default:
                    return {
                        label: "Unpaid",
                        class: "fs-3 p-3 mb-2 bg-secondary text-white",
                    };
            }
        },

        getLatestPayment() {
            axios
                .get("/api/supplier/payment/event/latest-payment", {
                    params: {
                        ff_code: this.attendance.user_id,
                        fair_code: this.attendance.fair_code,
                    },
                })
                .then((res) => {
                    if (res.data.success && res.data.payments) {
                        this.payment.proof = res.data.payments
                            .filter((p) => p.url) // ✅ REMOVE BROKEN FILES
                            .map((p) => ({
                                id: p.id,
                                name: p.name,
                                url: p.url,
                                size: p.size,
                                type: p.type,
                                remote: true,
                            }));

                        this.payment.proof_for_upload = [];
                    }
                })
                .catch((err) => console.error(err));
        },

        // Handle new file selection (copied logic from product info)
        onSelectPayment(fileRecordsNewlySelected) {
            var validFileRecords = fileRecordsNewlySelected.filter(
                (fileRecord) => !fileRecord.error
            );
            this.payment.proof_for_upload =
                this.payment.proof_for_upload.concat(validFileRecords);
        },

        // Handle deletion (copied logic from product info)
        onBeforeDeletePayment(fileRecord) {
            // Remove from new files (not yet uploaded)
            const idxUpload = this.payment.proof_for_upload.indexOf(fileRecord);
            if (idxUpload !== -1) {
                this.payment.proof_for_upload.splice(idxUpload, 1);
            }

            // Remove from all displayed files
            const idxProof = this.payment.proof.indexOf(fileRecord);
            if (idxProof !== -1) {
                this.payment.proof.splice(idxProof, 1);
            }

            // If this is a remote file (already uploaded), mark for deletion
            if (fileRecord.id) {
                this.payment.deleted_ids.push(fileRecord.id);
            }

            return false; // prevent VueFileAgent default delete
        },
        // Handle remote file deletion (copied logic from product info)
        // Handle "deleting" a file visually only
        onDeletePayment(fileRecord) {
            // Find in proof_for_upload (new files not yet uploaded)
            const idxUpload = this.payment.proof_for_upload.indexOf(fileRecord);
            if (idxUpload !== -1) {
                this.payment.proof_for_upload.splice(idxUpload, 1);
            }

            // Find in proof (all files displayed)
            const idxProof = this.payment.proof.indexOf(fileRecord);
            if (idxProof !== -1) {
                this.payment.proof.splice(idxProof, 1);
            }
        },

        submitPayment() {
            if (
                !this.payment.proof.length &&
                !this.payment.deleted_ids.length
            ) {
                this.$toast.error("Please upload at least one payment proof.", {
                    position: "top-right",
                });
                return;
            }

            const formData = new FormData();
            formData.append("attendance_id", this.attendance.id);
            formData.append("fair_code", this.attendance.fair_code);
            formData.append("ff_code", this.attendance.user_id);
            formData.append("created_by", this.attendance.user_id);

            this.payment.proof_for_upload.forEach((fileRecord, idx) => {
                if (fileRecord.file) {
                    formData.append(`payment_file[${idx}]`, fileRecord.file);
                }
            });

            this.payment.deleted_ids.forEach((id) => {
                formData.append(`deleted_ids[]`, id);
            });

            this.isLoading = true;
            // ✅ Immediately disable the button
            this.attendance.payment_status = 2; // mark as "Pending" right away
            this.msg = "Updating payment, please wait...";

            axios
                .post("/api/supplier/payment/event/submit", formData)
                .then((res) => {
                    this.isLoading = false;
                    this.$toast.success(
                        res.data.message || "Payment updated!",
                        { position: "top-right" }
                    );

                    if (res.data.attendance) {
                        // ✅ Replace attendance object so button updates immediately
                        this.attendance = {
                            ...this.attendance,
                            payment_status: res.data.attendance.payment_status,
                            updated_at: res.data.attendance.updated_at,
                        };
                    } else {
                        // fallback if backend doesn't return updated attendance
                        this.attendance = {
                            ...this.attendance,
                            payment_status: 2,
                        };
                    }

                    // Reset arrays
                    this.payment.proof_for_upload = [];
                    this.payment.deleted_ids = [];

                    // Reload latest payment if needed
                    this.getLatestPayment();
                })
                .catch((err) => {
                    this.isLoading = false;
                    console.error(err);
                    this.$toast.error("Failed to update payment.");
                    // Rollback status if failed
                    this.attendance = { ...this.attendance, payment_status: 0 }; // Unpaid
                });
        },
    },
    computed: {
        isPaymentPending() {
            // disable if Paid (1) or Pending (2)
            return (
                this.attendance.payment_status === 1 ||
                this.attendance.payment_status === 2
            );
        },
    },
};
</script>

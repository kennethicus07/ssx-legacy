<template>
    <div>
        <!-- Loading Block -->
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>

        <div class="row" v-show="supplierData.attendance && supplierData.event">
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
                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                    >
                                        Company Name
                                    </label>
                                    <div class="form-control bg-light">
                                        {{ supplierData.exhibitor.co_name }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                    >
                                        Company Email
                                    </label>
                                    <div class="form-control bg-light">
                                        {{ supplierData.exhibitor.co_email }}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                    >
                                        Event Name
                                    </label>
                                    <div class="form-control bg-light">
                                        {{ supplierData.event.event_name }}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                    >
                                        Upload Payment Proof*
                                    </label>
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

            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Actions</h5>
                    <div class="card-body">
                        <div class="d-grid gap-2 mb-2">
                            <button
                                class="btn btn-sm btn-primary mb-2"
                                :disabled="!supplierData.attendance"
                                @click="openSupplierExhibitor"
                            >
                                Registration Details
                            </button>
                        </div>
                        <div class="row">
                            <!-- PAYMENT STATUS BADGE -->
                            <div class="col-12">
                                <p :class="paymentBadge().class">
                                    {{ paymentBadge().label }}
                                </p>
                            </div>

                            <!-- DATE CREATED -->
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :value="
                                            supplierData.attendance.created_at
                                                ? $moment(
                                                      supplierData.attendance
                                                          .created_at
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
                                v-if="supplierData.attendance.updated_at"
                            >
                                <div class="form-floating">
                                    <input
                                        type="text"
                                        class="form-control"
                                        :value="
                                            supplierData.attendance.updated_at
                                                ? $moment(
                                                      supplierData.attendance
                                                          .updated_at
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
                                    v-if="permissions.can_upload"
                                    type="button"
                                    class="btn btn-success text-white"
                                    @click="submitPayment"
                                    :disabled="
                                        !payment.proof_for_upload.length &&
                                        !payment.deleted_ids.length
                                    "
                                >
                                    Upload Payment
                                </button>

                                <button
                                    v-if="permissions.can_update"
                                    type="button"
                                    class="btn btn-primary text-white"
                                    @click="markAsPaid"
                                >
                                    Mark as Paid
                                </button>

                                <button
                                    v-if="permissions.can_update"
                                    type="button"
                                    class="btn btn-danger text-white"
                                    @click="markAsUnpaid"
                                >
                                    Mark as Unpaid
                                </button>
                            </div>
                            <div class="d-grid gap-2">
                                <a
                                    href="/admin/payments/supplier-exhibitors"
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
import VueSweetalert2 from "vue-sweetalert2";
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";
import BlockUI from "vue-blockui";
import "vue-blockui/dist/vue-blockui.css";
Vue.use(VueSweetalert2);
export default {
    props: ["attendance", "event"], // only identifiers

    data() {
        return {
            isLoading: false,
            msg: "Uploading...",
            permissions: [],
            supplierData: {
                attendance: null,
                event: null,
                exhibitor: null,
            },
            payment: {
                proof: [],
                proof_for_upload: [],
                deleted_ids: [],
            },
        };
    },

    mounted() {
        this.getSupplierPayment();
    },

    methods: {
        // Payment badge
        paymentBadge() {
            const status = this.supplierData.attendance?.payment_status;
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

        // Get supplier info (attendance + event)
        getSupplierPayment() {
            axios
                .get("/admin/payments/supplier-exhibitor/attendance", {
                    params: {
                        user_id: this.attendance.user_id,
                        fair_code: this.attendance.fair_code,
                    },
                })
                .then((res) => {
                    if (res.data.success) {
                        this.supplierData.attendance = res.data.attendance;
                        this.supplierData.event = res.data.event;
                        this.supplierData.exhibitor = res.data.exhibitor;
                        this.permissions = res.data.permissions;
                        // load existing files after data comes in
                        this.getLatestPayment();
                    }
                })
                .catch((err) => console.error(err));
        },

        // Get uploaded payment files
        getLatestPayment() {
            if (!this.supplierData.attendance) return;

            axios
                .get("/api/supplier/payment/event/latest-payment", {
                    params: {
                        ff_code: this.supplierData.attendance.user_id,
                        fair_code: this.supplierData.attendance.fair_code,
                    },
                })
                .then((res) => {
                    if (res.data.success && res.data.payments) {
                        this.payment.proof = res.data.payments
                            .filter((p) => p.url)
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

        onSelectPayment(files) {
            const valid = files.filter((f) => !f.error);
            this.payment.proof_for_upload =
                this.payment.proof_for_upload.concat(valid);
        },

        onBeforeDeletePayment(file) {
            const idxUpload = this.payment.proof_for_upload.indexOf(file);
            if (idxUpload !== -1)
                this.payment.proof_for_upload.splice(idxUpload, 1);

            const idxProof = this.payment.proof.indexOf(file);
            if (idxProof !== -1) this.payment.proof.splice(idxProof, 1);

            if (file.id) this.payment.deleted_ids.push(file.id);

            return false;
        },

        onDeletePayment(file) {
            const idxUpload = this.payment.proof_for_upload.indexOf(file);
            if (idxUpload !== -1)
                this.payment.proof_for_upload.splice(idxUpload, 1);

            const idxProof = this.payment.proof.indexOf(file);
            if (idxProof !== -1) this.payment.proof.splice(idxProof, 1);
        },

        async submitPayment() {
            if (
                !this.payment.proof.length &&
                !this.payment.deleted_ids.length
            ) {
                this.$toast.error("Please upload at least one payment proof.", {
                    position: "top-right",
                });
                return;
            }

            const confirmed = await this.$swal({
                title: "Upload Payment?",
                text: "This will submit/update the payment proof for this supplier/exhibitor.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, upload",
                cancelButtonText: "Cancel",
                reverseButtons: true,
                allowOutsideClick: false,
            });

            if (!confirmed.isConfirmed) return;

            const formData = new FormData();
            formData.append("attendance_id", this.supplierData.attendance.id);
            formData.append(
                "fair_code",
                this.supplierData.attendance.fair_code
            );
            formData.append("ff_code", this.supplierData.attendance.user_id);
            formData.append("created_by", this.supplierData.attendance.user_id);

            this.payment.proof_for_upload.forEach((file, idx) => {
                if (file.file)
                    formData.append(`payment_file[${idx}]`, file.file);
            });

            this.payment.deleted_ids.forEach((id) =>
                formData.append(`deleted_ids[]`, id)
            );

            this.isLoading = true;
            this.msg = "Updating payment, please wait...";
            this.supplierData.attendance.payment_status = 2;

            axios
                .post("/admin/payments/supplier-exhibitor/submit", formData)
                .then((res) => {
                    this.isLoading = false;

                    this.$swal({
                        icon: "success",
                        title: "Success",
                        text:
                            res.data.message || "Payment updated successfully!",
                        timer: 2000,
                        showConfirmButton: false,
                    });

                    if (res.data.attendance) {
                        this.supplierData.attendance.payment_status =
                            res.data.attendance.payment_status;
                        this.supplierData.attendance.updated_at =
                            res.data.attendance.updated_at;
                    }

                    this.payment.proof_for_upload = [];
                    this.payment.deleted_ids = [];
                    this.getLatestPayment();
                })
                .catch((err) => {
                    this.isLoading = false;
                    console.error(err);

                    this.$swal({
                        icon: "error",
                        title: "Upload Failed",
                        text: "Something went wrong while uploading payment.",
                    });

                    this.supplierData.attendance.payment_status = 0;
                });
        },
        async markAsPaid() {
            if (!this.supplierData.attendance) return;

            const confirmed = await this.$swal({
                title: "Mark as Paid?",
                text: "Are you sure you want to mark this payment as Paid?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, mark as Paid",
                cancelButtonText: "Cancel",
                reverseButtons: true,
                allowOutsideClick: false,
            });

            if (!confirmed.isConfirmed) return;

            this.isLoading = true;
            axios
                .post("/admin/payments/supplier-exhibitor/mark-status", {
                    attendance_id: this.supplierData.attendance.user_id,
                    fair_code: this.supplierData.attendance.fair_code,
                    status: 1,
                })
                .then((res) => {
                    this.isLoading = false;
                    this.supplierData.attendance.payment_status = 1;
                    this.supplierData.attendance.updated_at = new Date();
                    this.$toast.success("Marked as Paid", {
                        position: "top-center",
                    });
                })
                .catch((err) => {
                    this.isLoading = false;
                    console.error(err);
                    this.$toast.error("Failed to mark as Paid", {
                        position: "top-center",
                    });
                });
        },

        async markAsUnpaid() {
            if (!this.supplierData.attendance) return;

            const confirmed = await this.$swal({
                title: "Mark as Unpaid?",
                text: "Are you sure you want to mark this payment as Unpaid?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, mark as Unpaid",
                cancelButtonText: "Cancel",
                reverseButtons: true,
                allowOutsideClick: false,
            });

            if (!confirmed.isConfirmed) return;

            this.isLoading = true;
            axios
                .post("/admin/payments/supplier-exhibitor/mark-status", {
                    attendance_id: this.supplierData.attendance.user_id,
                    fair_code: this.supplierData.attendance.fair_code,
                    status: 0,
                })
                .then((res) => {
                    this.isLoading = false;
                    this.supplierData.attendance.payment_status = 0;
                    this.supplierData.attendance.updated_at = new Date();
                    this.$toast.success("Marked as Unpaid", {
                        position: "top-center",
                    });
                })
                .catch((err) => {
                    this.isLoading = false;
                    console.error(err);
                    this.$toast.error("Failed to mark as Unpaid", {
                        position: "top-center",
                    });
                });
        },

        async openSupplierExhibitor() {
            if (!this.supplierData.attendance) return;

            const url = `/admin/registration/suppliers/${this.supplierData.attendance.user_id}/${this.supplierData.attendance.fair_code}/view`;
            window.open(url, "_blank");
        },

        computed: {
            isPaymentPending() {
                return [1, 2].includes(
                    this.supplierData.attendance?.payment_status
                );
            },
        },
    },
};
</script>

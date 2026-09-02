<template>
    <div class="row">
        <div class="col-lg-4 mb-4">
            <registration-summary :conference="conference" />
        </div>

        <div class="col-lg-4 mb-4">
            <company-information :conference="conference" />
        </div>

        <div class="col-lg-4 mb-4">
            <additional-information :conference="conference" />
        </div>

        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-body p-4">
                    <!-- Header -->
                    <div
                        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
                    >
                        <div>
                            <h5 class="fw-bold mb-1">Payment Breakdown</h5>
                            <small class="text-muted">
                                Registration charges and discounts
                            </small>
                        </div>

                        <div class="d-flex gap-2">
                            <button
                                v-if="canAddDelegate"
                                class="btn btn-sm btn-success text-white"
                                @click="showAddDelegateModal = true"
                            >
                                Add Delegate
                            </button>
                            <button
                                v-if="canAddFee"
                                class="btn btn-sm btn-outline-success"
                                @click="showAddFeeModal = true"
                            >
                                Add Fee
                            </button>

                            <button
                                v-if="canAddDiscount"
                                class="btn btn-sm btn-outline-danger"
                                @click="showAddDiscountModal = true"
                            >
                                Add Discount
                            </button>
                        </div>
                    </div>

                    <!-- Base Rate -->
                    <div
                        class="d-flex justify-content-between align-items-center bg-light rounded px-3 py-3 mb-4"
                    >
                        <div>
                            <div class="fw-semibold">Base Rate</div>
                            <small class="text-muted"
                                >Standard registration rate</small
                            >
                        </div>

                        <div class="fw-semibold">
                            {{ conference.currency }}
                            {{ formatCurrency(conference.base_rate) }}
                        </div>
                    </div>

                    <!-- Charges -->
                    <div class="mb-4">
                        <div
                            class="row mb-2 px-1 text-uppercase fw-semibold text-muted small"
                        >
                            <div class="col">Charges</div>
                            <div class="col-3 text-end">Amount</div>
                            <div class="col-1 text-center">Action</div>
                        </div>

                        <div
                            v-for="item in charges"
                            :key="item.id"
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

                                    <span>{{ item.description }}</span>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-3 text-end">
                                <span class="fw-semibold">
                                    {{ conference.currency }}
                                    {{ formatCurrency(item.value) }}
                                </span>
                            </div>

                            <!-- Action -->
                            <div class="col-1 text-center">
                                <button
                                    v-if="
                                        item.type === 'add_fee' && canDeleteFee
                                    "
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteBreakdown(item)"
                                >
                                    <i class="mdi mdi-delete-outline me-1"></i>
                                    Delete
                                </button>

                                <span v-else class="text-muted small">—</span>
                            </div>
                        </div>

                        <!-- Empty -->
                        <div
                            v-if="!charges.length"
                            class="text-muted small px-1 py-3"
                        >
                            No additional fees.
                        </div>
                    </div>

                    <!-- Discounts -->
                    <div v-if="discounts.length" class="pt-3 mb-4">
                        <!-- Column Header -->
                        <div
                            class="row mb-2 px-1 text-uppercase fw-semibold small text-muted"
                        >
                            <div class="col">DISCOUNTS</div>
                            <div class="col-3 text-end"></div>
                            <div class="col-1 text-center"></div>
                        </div>

                        <!-- Rows -->
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

                                    <span>{{ item.description }}</span>
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-3 text-end">
                                <span class="fw-semibold text-danger">
                                    - {{ conference.currency }}
                                    {{ formatCurrency(item.value) }}
                                </span>
                            </div>

                            <!-- Action -->
                            <div class="col-1 text-center">
                                <button
                                    v-if="
                                        item.type === 'add_discount' &&
                                        canDeleteDiscount
                                    "
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteBreakdown(item)"
                                >
                                    <i class="mdi mdi-delete-outline me-1"></i>
                                    Delete
                                </button>

                                <span
                                    v-else-if="item.type !== 'add_discount'"
                                    class="text-muted small"
                                >
                                    —
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
                                <div class="fw-bold fs-5">Total Amount</div>
                                <small class="text-muted"
                                    >Final amount payable</small
                                >
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
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div
                    class="card-header bg-white d-flex justify-content-between align-items-center"
                >
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-group me-2 text-success"></i>
                        Conference Delegates
                    </h5>

                    <span class="badge bg-success">
                        {{
                            conference.conference_delegates.filter(
                                (delegate) =>
                                    !delegate.is_visitor_buyer &&
                                    !delegate.is_speaker
                            ).length
                        }}
                        Delegate(s)
                    </span>
                </div>

                <div class="card-body p-0">
                    <div
                        v-if="conference.conference_delegates.length"
                        class="table-responsive"
                    >
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width: 60px">#</th>
                                    <th style="min-width: 220px">Name</th>
                                    <th style="min-width: 220px">Email</th>
                                    <th style="min-width: 180px">
                                        Designation
                                    </th>
                                    <th style="min-width: 140px">Country</th>
                                    <th style="min-width: 170px">Mobile</th>
                                    <th style="min-width: 190px">
                                        Delegate Category
                                    </th>
                                    <th style="min-width: 170px">
                                        Delegate Type
                                    </th>
                                    <!-- <th style="min-width: 90px">Speaker</th>
                                    <th style="min-width: 90px">
                                        Visitor/Buyer
                                    </th> -->
                                    <th style="min-width: 140px">
                                        Email Status
                                    </th>
                                    <th style="min-width: 90px">Senior</th>
                                    <th style="min-width: 90px">PWD</th>
                                    <th style="min-width: 140px">ID File</th>
                                    <th style="width: 60px" class="text-center">
                                        Actions
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    v-for="(
                                        delegate, index
                                    ) in conference.conference_delegates"
                                    :key="delegate.id"
                                >
                                    <td>{{ index + 1 }}</td>

                                    <td>
                                        <div
                                            class="d-flex justify-content-between align-items-center gap-2"
                                        >
                                            <strong>
                                                {{ delegate.salutation }}
                                                {{ delegate.fname }}
                                                {{ delegate.lname }}
                                            </strong>

                                            <span
                                                v-if="
                                                    Number(
                                                        delegate.is_speaker
                                                    ) === 1
                                                "
                                                class="badge bg-warning text-white"
                                            >
                                                Speaker
                                            </span>

                                            <span
                                                v-else-if="
                                                    Number(
                                                        delegate.is_visitor_buyer
                                                    ) === 1
                                                "
                                                class="badge bg-info text-white"
                                            >
                                                Visitor/Buyer
                                            </span>

                                            <span
                                                v-else
                                                class="badge bg-success"
                                            >
                                                Delegate
                                            </span>
                                        </div>
                                    </td>

                                    <td>{{ delegate.email }}</td>

                                    <td>{{ delegate.designation || "-" }}</td>

                                    <td>{{ delegate.country }}</td>

                                    <td>
                                        {{ delegate.country_code_mobile }}
                                        {{ delegate.mobile_no }}
                                    </td>

                                    <td>
                                        <span class="badge bg-primary">
                                            {{
                                                delegate.delegate_category_text
                                            }}
                                        </span>

                                        <div
                                            v-if="
                                                delegate.delegate_category == 99
                                            "
                                            class="small text-muted mt-1"
                                        >
                                            {{
                                                delegate.delegate_category_other
                                            }}
                                        </div>
                                    </td>

                                    <td>{{ delegate.addtnl_type || "-" }}</td>
                                    <!-- <td class="text-center">
                                        <i
                                            :class="
                                                Number(delegate.is_speaker) ===
                                                1
                                                    ? 'mdi-check-circle text-success'
                                                    : 'mdi-close-circle text-danger'
                                            "
                                            class="mdi fs-5"
                                        ></i>
                                    </td>
                                    <td class="text-center">
                                        <i
                                            :class="
                                                Number(
                                                    delegate.is_visitor_buyer
                                                ) === 1
                                                    ? 'mdi-check-circle text-success'
                                                    : 'mdi-close-circle text-danger'
                                            "
                                            class="mdi fs-5"
                                        ></i>
                                    </td> -->
                                    <td class="text-center">
                                        <span
                                            v-if="
                                                Number(
                                                    delegate.is_email_sent
                                                ) === 1
                                            "
                                            class="badge bg-success"
                                        >
                                            <i
                                                class="mdi mdi-email-check-outline"
                                            ></i>
                                            Sent
                                        </span>

                                        <span v-else class="badge bg-secondary">
                                            Not Sent
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <i
                                            :class="
                                                delegate.senior
                                                    ? 'mdi-check-circle text-success'
                                                    : 'mdi-close-circle text-danger'
                                            "
                                            class="mdi fs-5"
                                        ></i>
                                    </td>

                                    <td class="text-center">
                                        <i
                                            :class="
                                                delegate.pwd
                                                    ? 'mdi-check-circle text-success'
                                                    : 'mdi-close-circle text-danger'
                                            "
                                            class="mdi fs-5"
                                        ></i>
                                    </td>

                                    <td>
                                        <a
                                            v-if="delegate.id_file"
                                            :href="`/storage/conf_uploads/${delegate.id_file}`"
                                            target="_blank"
                                            class="btn btn-sm btn-outline-success"
                                        >
                                            <i class="mdi mdi-file-eye"></i>
                                            View
                                        </a>

                                        <span v-else class="text-muted">—</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm btn-light border"
                                                data-bs-toggle="dropdown"
                                            >
                                                <i
                                                    class="mdi mdi-dots-vertical"
                                                ></i>
                                            </button>

                                            <ul
                                                class="dropdown-menu dropdown-menu-end shadow-sm"
                                            >
                                                <!-- Edit -->
                                                <li>
                                                    <button
                                                        class="dropdown-item"
                                                        @click="
                                                            editDelegate(
                                                                delegate
                                                            )
                                                        "
                                                    >
                                                        Edit
                                                    </button>
                                                </li>

                                                <!-- Send Email -->
                                                <li
                                                    v-if="
                                                        canSendEmail(
                                                            delegate
                                                        ) &&
                                                        !delegate.is_speaker
                                                    "
                                                >
                                                    <button
                                                        class="dropdown-item"
                                                        @click="
                                                            sendEmail(delegate)
                                                        "
                                                    >
                                                        {{
                                                            emailActionLabel(
                                                                delegate
                                                            )
                                                        }}
                                                    </button>
                                                </li>
                                                <!-- Delete -->
                                                <li>
                                                    <button
                                                        v-if="canDeleteDelegate"
                                                        class="dropdown-item text-danger"
                                                        @click="
                                                            deleteDelegate(
                                                                delegate
                                                            )
                                                        "
                                                    >
                                                        Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="text-center text-muted py-5">
                        <i class="mdi mdi-account-off display-5"></i>
                        <p class="mt-3 mb-0">No delegates registered.</p>
                    </div>
                </div>
            </div>
        </div>
        <add-fee-modal
            :show="showAddFeeModal"
            :conference-id="conference.id"
            :conference-currency="conference.currency"
            @close="showAddFeeModal = false"
            @saved="feeAdded"
        />

        <add-discount-modal
            :show="showAddDiscountModal"
            :conference-id="conference.id"
            :conference-currency="conference.currency"
            @close="showAddDiscountModal = false"
            @saved="discountAdded"
        />

        <add-delegate-modal
            :show="showAddDelegateModal"
            :conference-id="conference.id"
            @close="showAddDelegateModal = false"
            @saved="delegateAdded"
        />
        <edit-delegate-modal
            :show="showEditDelegateModal"
            :conference-id="conference.id"
            :edit-data="selectedDelegate"
            @close="showEditDelegateModal = false"
            @saved="delegateUpdated"
        />
    </div>
</template>

<script>
import RegistrationSummary from "./RegistrationTab/RegistrationSummary.vue";
import CompanyInformation from "./RegistrationTab/CompanyInformation.vue";
import AdditionalInformation from "./RegistrationTab/AdditionalInformation.vue";
import AddFeeModal from "./RegistrationTab/AddFeeModal.vue";
import AddDiscountModal from "./RegistrationTab/AddDiscountModal.vue";
import EditDelegateModal from "./RegistrationTab/EditDelegateModal.vue";
import AddDelegateModal from "./RegistrationTab/AddDelegateModal.vue";

const STATUS_MAP = {
    2: { label: "Registered", class: "bg-success" },
    1: { label: "Pending", class: "bg-warning" },
};
const STATUS_DEFAULT = { label: "Draft", class: "bg-secondary" };

export default {
    name: "RegistrationTab",

    components: {
        RegistrationSummary,
        CompanyInformation,
        AdditionalInformation,

        AddFeeModal,
        AddDiscountModal,
        AddDelegateModal,
        EditDelegateModal,
    },

    props: {
        conference: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            showAddFeeModal: false,
            showAddDiscountModal: false,
            showAddDelegateModal: false,
            showEditDelegateModal: false,
            selectedDelegate: null,
        };
    },

    computed: {
        statusBadge() {
            return STATUS_MAP[this.conference.status] || STATUS_DEFAULT;
        },

        canModifyRegistration() {
            return this.conference.review !== "Yes";
        },

        canAddDelegate() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_add &&
                (this.conference.permissions.is_super_admin ||
                    this.canModifyRegistration)
            );
        },

        canDeleteDelegate() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_delete &&
                (this.conference.permissions.is_super_admin ||
                    this.canModifyRegistration)
            );
        },

        canEditDelegate() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_edit &&
                (this.conference.permissions.is_super_admin ||
                    this.canModifyRegistration)
            );
        },

        canAddFee() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_add_fee &&
                (this.conference.permissions.is_super_admin ||
                    (this.conference.permissions.is_accounting &&
                        Number(this.conference.billing_status) !== 1) ||
                    this.canModifyRegistration)
            );
        },

        canDeleteFee() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_delete_fee &&
                (this.conference.permissions.is_super_admin ||
                    (this.conference.permissions.is_accounting &&
                        Number(this.conference.billing_status) !== 1) ||
                    this.canModifyRegistration)
            );
        },

        canAddDiscount() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_add_discount &&
                (this.conference.permissions.is_super_admin ||
                    (this.conference.permissions.is_accounting &&
                        Number(this.conference.billing_status) !== 1) ||
                    this.canModifyRegistration)
            );
        },

        canDeleteDiscount() {
            return (
                this.conference.permissions &&
                this.conference.permissions.can_delete_discount &&
                (this.conference.permissions.is_super_admin ||
                    (this.conference.permissions.is_accounting &&
                        Number(this.conference.billing_status) !== 1) ||
                    this.canModifyRegistration)
            );
        },

        charges() {
            return this.conference.conference_breakdown.filter(
                (item) =>
                    item.type === "base" ||
                    item.type === "fee" ||
                    item.type === "add_fee"
            );
        },

        discounts() {
            return this.conference.conference_breakdown.filter(
                (item) =>
                    item.type === "discount" || item.type === "add_discount"
            );
        },
    },
    methods: {
        canSendEmail(delegate) {
            const permissions = this.conference.permissions;

            if (!permissions) {
                return false;
            }

            if (Number(delegate.is_visitor_buyer) === 1) {
                return permissions.can_email_visitor_buyers;
            }

            return permissions.can_email;
        },
        formatCurrency(value) {
            return Number(value || 0).toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        },

        feeAdded(data) {
            this.showAddFeeModal = false;

            this.conference.conference_breakdown.push(data.breakdown);

            this.conference.amount =
                data.totals.base_total + data.totals.additional_fees;

            this.conference.discount = data.totals.discounts;

            this.conference.final_amount = data.totals.final_amount;
        },

        discountAdded(data) {
            this.showAddDiscountModal = false;

            this.conference.conference_breakdown.push(data.breakdown);

            this.conference.amount =
                data.totals.base_total + data.totals.additional_fees;

            this.conference.discount = data.totals.discounts;

            this.conference.final_amount = data.totals.final_amount;
        },
        editDelegate(delegate) {
            this.selectedDelegate = delegate;

            this.showEditDelegateModal = true;
        },
        delegateAdded(data) {
            this.showAddDelegateModal = false;

            /*
    |--------------------------------------------------------------------------
    | Add Delegate
    |--------------------------------------------------------------------------
    */

            this.conference.conference_delegates.push(data.delegate);

            /*
    |--------------------------------------------------------------------------
    | Update Totals
    |--------------------------------------------------------------------------
    */

            if (data.totals) {
                this.conference.amount =
                    data.totals.base_total + data.totals.additional_fees;

                this.conference.discount = data.totals.discounts;

                this.conference.final_amount = data.totals.final_amount;
            }

            /*
    |--------------------------------------------------------------------------
    | Refresh Breakdown
    |--------------------------------------------------------------------------
    */

            if (data.breakdowns) {
                this.conference.conference_breakdown = data.breakdowns;
            }
        },

        async deleteBreakdown(item) {
            const result = await this.$swal.fire({
                title: "Remove adjustment?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, remove it",
            });

            if (!result.isConfirmed) {
                return;
            }

            axios
                .delete(
                    `/admin/registration/delegates/breakdown/${item.id}/delete`
                )
                .then((response) => {
                    this.$toast.open({
                        message: "Adjustment removed successfully.",
                        type: "success",
                        duration: 3000,
                        position: "top-right",
                    });

                    // Remove the deleted item locally
                    this.conference.conference_breakdown =
                        this.conference.conference_breakdown.filter(
                            (breakdown) => breakdown.id !== response.data.id
                        );

                    // Update totals
                    this.conference.amount =
                        response.data.totals.base_total +
                        response.data.totals.additional_fees;

                    this.conference.discount = response.data.totals.discounts;

                    this.conference.final_amount =
                        response.data.totals.final_amount;
                })
                .catch(() => {
                    this.$toast.open({
                        message: "Unable to remove adjustment.",
                        type: "error",
                        duration: 3000,
                    });
                });
        },

        async deleteDelegate(delegate) {
            const result = await this.$swal.fire({
                title: "Delete delegate?",
                text: `${delegate.fname} ${delegate.lname} will be permanently removed.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Delete",
            });

            if (!result.isConfirmed) {
                return;
            }

            axios
                .delete(`/admin/registration/delegates/${delegate.id}`)
                .then((response) => {
                    this.$toast.open({
                        message: "Delegate removed successfully.",
                        type: "success",
                        duration: 3000,
                    });

                    this.conference.conference_delegates =
                        this.conference.conference_delegates.filter(
                            (item) => item.id !== delegate.id
                        );

                    if (response.data.totals) {
                        this.conference.amount =
                            response.data.totals.base_total +
                            response.data.totals.additional_fees;

                        this.conference.discount =
                            response.data.totals.discounts;

                        this.conference.final_amount =
                            response.data.totals.final_amount;

                        this.conference.conference_breakdown =
                            response.data.breakdowns;
                    }
                })
                .catch(() => {
                    this.$toast.open({
                        message: "Unable to delete delegate.",
                        type: "error",
                        duration: 3000,
                    });
                });
        },
        delegateUpdated(data) {
            this.showEditDelegateModal = false;

            /*
    |--------------------------------------------------------------------------
    | Replace delegate row
    |--------------------------------------------------------------------------
    */

            const index = this.conference.conference_delegates.findIndex(
                (item) => item.id === data.delegate.id
            );

            if (index !== -1) {
                this.$set(
                    this.conference.conference_delegates,
                    index,
                    data.delegate
                );
            }

            /*
    |--------------------------------------------------------------------------
    | Update totals
    |--------------------------------------------------------------------------
    */

            if (data.totals) {
                this.conference.amount =
                    data.totals.base_total + data.totals.additional_fees;

                this.conference.discount = data.totals.discounts;

                this.conference.final_amount = data.totals.final_amount;
            }

            /*
    |--------------------------------------------------------------------------
    | Update breakdown
    |--------------------------------------------------------------------------
    */

            if (data.breakdowns) {
                this.conference.conference_breakdown = data.breakdowns;
            }
        },
        emailActionLabel(delegate) {
            return Number(delegate.is_visitor_buyer) === 1
                ? "Send Email Visitor/Buyer"
                : "Send Email Delegate";
        },
        async sendEmail(delegate) {
            const isVisitorBuyer = Number(delegate.is_visitor_buyer) === 1;
            const recipientType = isVisitorBuyer ? "Visitor/Buyer" : "Delegate";

            // Billing status restriction applies ONLY to regular delegates
            if (
                !isVisitorBuyer &&
                Number(this.conference.billing_status) !== 1
            ) {
                this.$toast.open({
                    message: "Email cannot be sent until billing is completed.",
                    type: "error",
                    duration: 3000,
                    position: "top-right",
                });

                return;
            }

            const result = await this.$swal.fire({
                title: `Send Email to ${recipientType}?`,
                text: `An email will be sent to ${delegate.email}.`,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, send email",
                cancelButtonText: "Cancel",
            });

            if (!result.isConfirmed) {
                return;
            }

            this.$emit("email-loading", {
                loading: true,
                message: `Sending email to ${recipientType}...`,
            });

            axios
                .post(`/admin/registration/delegates/${delegate.id}/send-email`)
                .then((response) => {
                    delegate.is_email_sent = response.data.is_email_sent;
                    delegate.email_sent_at = response.data.email_sent_at;

                    this.$toast.open({
                        message: response.data.message,
                        type: "success",
                        duration: 3000,
                        position: "top-right",
                    });
                })
                .catch((error) => {
                    console.error("Send Email Error:", error);

                    this.$toast.open({
                        message:
                            error.response?.data?.message ||
                            "Unable to send email.",
                        type: "error",
                        duration: 3000,
                        position: "top-right",
                    });
                })
                .finally(() => {
                    this.$emit("email-loading", {
                        loading: false,
                        message: "Please wait...",
                    });
                });
        },
    },
};
</script>

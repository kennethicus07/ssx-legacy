<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filters</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="title" class="form-label"
                                    >Company Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    id="title"
                                    v-model="serverParams.columnFilters.co_name"
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="title" class="form-label"
                                    >Company E-mail Address</label
                                >
                                <input
                                    type="email"
                                    class="form-control form-control-sm"
                                    id="title"
                                    v-model="
                                        serverParams.columnFilters.co_email
                                    "
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="fair_code" class="form-label"
                                    >Event (Fair Code)</label
                                >
                                <select
                                    class="form-select form-select-sm"
                                    id="fair_code"
                                    v-model="selectedFairCode"
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

                            <div class="col-md-3">
                                <label for="status" class="form-label"
                                    >Status</label
                                >
                                <select
                                    class="form-select form-select-sm"
                                    v-model="serverParams.columnFilters.status"
                                >
                                    <option :value="''">-- Select --</option>
                                    <option :value="0">Incomplete</option>
                                    <option :value="1">
                                        Pending Conforme Generation
                                    </option>
                                    <option :value="2">Pending</option>
                                    <option :value="3">Reviewed</option>
                                    <!-- <option :value="4">On hold</option>
                                    <option :value="5">Denied</option> -->
                                    <option :value="6">For RTB</option>
                                    <option :value="7">
                                        Awaiting Conforme Response
                                    </option>
                                    <option value="8">Generated RTB</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="soa_status" class="form-label">
                                    SOA Status
                                </label>

                                <select
                                    id="soa_status"
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters.soa_status
                                    "
                                >
                                    <option :value="''">-- Select --</option>
                                    <option value="SOA Generated">
                                        SOA Generated
                                    </option>
                                    <option value="SOA Not Generated">
                                        SOA Not Generated
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="payment_status" class="form-label">
                                    Payment Status
                                </label>

                                <select
                                    id="payment_status"
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .payment_status
                                    "
                                >
                                    <option :value="''">-- Select --</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                </select>
                            </div>

                            <div class="col mt-3 text-end">
                                <a
                                    role="button"
                                    @click="onColumnFilter"
                                    class="btn btn-sm btn-success text-white"
                                    >Search</a
                                >
                                <a
                                    role="button"
                                    @click="onResetFilter"
                                    class="btn btn-sm btn-secondary"
                                    >Reset</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-start align-items-center gap-2 mb-2"
                        >
                            <div v-if="permissions.can_conforme">
                                <button
                                    class="btn btn-sm btn-success text-light"
                                    :disabled="!hasForRTBSelected"
                                    @click="generateRTB"
                                >
                                    Generate RTB ({{ validRTBIds.length }})
                                </button>
                            </div>

                            <div v-if="permissions.can_soa">
                                <button
                                    class="btn btn-sm btn-primary text-light"
                                    :disabled="!hasGeneratedRTBSelected"
                                    @click="generateSOA"
                                >
                                    Mark SOA Status ({{
                                        generatedRTBIds.length
                                    }})
                                </button>
                            </div>
                        </div>
                        <h5 class="card-title">
                            List of suppliers registrations application
                        </h5>
                        <!-- <div class="text-end pb-3" v-if="permissions.can_add">
                            <a
                                href="/admin/registration/suppliers/create"
                                class="btn btn-warning btn-sm text-white"
                                role="button"
                                >Add new supplier</a
                            >
                        </div> -->
                        <div class="table-responsive">
                            <vue-good-table
                                mode="remote"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                :totalRows="totalRecords"
                                :isLoading.sync="isLoading"
                                :columns="columns"
                                :rows="rows"
                                :pagination-options="{
                                    enabled: true,
                                    perPageDropdown: [10, 20, 50, 100],
                                    dropdownAllowAll: false,
                                }"
                                styleClass="vgt-table striped"
                                :row-style-class="rowStyleClass"
                            >
                                <div slot="table-column" slot-scope="props">
                                    <span
                                        v-if="props.column.field === 'checkbox'"
                                    >
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-sm btn-light dropdown-toggle p-1"
                                                data-bs-toggle="dropdown"
                                            >
                                                <i class="mdi mdi-check"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        @click="selectAllRows"
                                                    >
                                                        Select All
                                                    </a>
                                                </li>
                                                <li
                                                    v-for="status in selectableStatuses"
                                                    :key="status"
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        @click="
                                                            selectByStatus(
                                                                status
                                                            )
                                                        "
                                                    >
                                                        {{ status }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        @click="clearSelection"
                                                    >
                                                        Clear
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </span>
                                    <span v-else>
                                        {{ props.column.label }}
                                    </span>
                                </div>
                                <div
                                    slot="emptystate"
                                    class="col-12 text-center"
                                >
                                    <span class="fw-bold"
                                        >No record found.</span
                                    >
                                </div>
                                <template slot="table-row" slot-scope="props">
                                    <span
                                        v-if="props.column.field === 'checkbox'"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="props.row.id"
                                            v-model="selectedRows"
                                        />
                                    </span>

                                    <!-- Company Name -->
                                    <span
                                        v-if="props.column.field === 'co_name'"
                                        class="text-uppercase"
                                    >
                                        <span v-tooltip="props.row.co_name">
                                            {{
                                                props.row.co_name
                                                    | str_limit(40)
                                            }}
                                        </span>
                                    </span>

                                    <!-- Company Email -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'co_email'
                                        "
                                        class="text-lowercase"
                                    >
                                        {{
                                            props.row.co_email
                                                ? props.row.co_email
                                                : "—"
                                        }}
                                    </span>

                                    <!-- MOA Region -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'moa_region'
                                        "
                                        class="text-uppercase"
                                    >
                                        {{
                                            props.row.moa_region
                                                ? props.row.moa_region
                                                : "—"
                                        }}
                                    </span>

                                    <!-- Status Badge -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'display_status'
                                        "
                                    >
                                        <span
                                            :class="
                                                statusBadgeClass(
                                                    props.row.display_status
                                                )
                                            "
                                        >
                                            {{ props.row.display_status }}
                                        </span>
                                    </span>

                                    <!-- SOA Badge -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'soa_status'
                                        "
                                    >
                                        <span
                                            :class="
                                                statusBadgeClass(
                                                    props.row.soa_status
                                                )
                                            "
                                        >
                                            {{ props.row.soa_status }}
                                        </span>
                                    </span>

                                    <!-- Payment Badge -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'payment_status'
                                        "
                                    >
                                        <span
                                            :class="
                                                statusBadgeClass(
                                                    props.row.payment_status
                                                )
                                            "
                                        >
                                            {{ props.row.payment_status }}
                                        </span>
                                    </span>

                                    <!-- Modified By -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'modified_by'
                                        "
                                    >
                                        <span
                                            v-if="
                                                props.row.status === 1 &&
                                                props.row.approver
                                            "
                                            >{{
                                                props.row.approver.name
                                                    ? props.row.approver.name
                                                    : "—"
                                            }}</span
                                        >
                                        <span
                                            v-else-if="
                                                props.row.status === 3 &&
                                                props.row.reviewer
                                            "
                                            >{{
                                                props.row.reviewer.name
                                                    ? props.row.reviewer.name
                                                    : "—"
                                            }}</span
                                        >
                                        <span
                                            v-else-if="
                                                props.row.status === 4 &&
                                                props.row.onholder
                                            "
                                            >{{
                                                props.row.onholder.name
                                                    ? props.row.onholder.name
                                                    : "—"
                                            }}</span
                                        >
                                        <span
                                            v-else-if="
                                                props.row.status === 5 &&
                                                props.row.disapprover
                                            "
                                            >{{
                                                props.row.disapprover.name
                                                    ? props.row.disapprover.name
                                                    : "—"
                                            }}</span
                                        >
                                        <span v-else>—</span>
                                    </span>

                                    <!-- Created At -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'created_at'
                                        "
                                    >
                                        {{
                                            props.row.created_at
                                                | moment("llll")
                                        }}
                                    </span>

                                    <!-- Actions -->
                                    <span
                                        v-else-if="
                                            props.column.field == 'actions'
                                        "
                                    >
                                        <div class="btn-group dropstart">
                                            <button
                                                type="button"
                                                class="btn btn-outline-warning dropdown-toggle btn-sm"
                                                data-bs-display="static"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                            >
                                                Actions
                                            </button>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 1"
                                            >
                                                <!-- EXISTING VIEW DETAILS — KEEP AS IS -->
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/suppliers/' +
                                                            props.row.id +
                                                            '/' +
                                                            props.row
                                                                .fair_code +
                                                            '/view'
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details
                                                    </a>
                                                </li>

                                                <!-- DOWNLOAD CONFORME -->
                                                <li
                                                    v-if="
                                                        permissions.conforme &&
                                                        props.row.conforme_file
                                                    "
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            downloadConforme(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-file-pdf"
                                                        ></i>
                                                        Download Conforme
                                                    </a>
                                                </li>

                                                <!-- RESEND CONFORME -->
                                                <li
                                                    v-if="
                                                        permissions.conforme &&
                                                        props.row.conforme_file
                                                    "
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            resendConforme(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-paper-plane"
                                                        ></i>
                                                        Resend Conforme
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 0"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/suppliers/' +
                                                            props.row.id +
                                                            '/' +
                                                            props.row
                                                                .fair_code +
                                                            '/view'
                                                        "
                                                        ><i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details</a
                                                    >
                                                </li>
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 2"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/suppliers/' +
                                                            props.row.id +
                                                            '/' +
                                                            props.row
                                                                .fair_code +
                                                            '/view'
                                                        "
                                                        ><i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details</a
                                                    >
                                                </li>
                                                <!-- <li
                                                    v-if="
                                                        permissions.can_review
                                                    "
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            doReview(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                        ><i
                                                            class="far fa-bookmark"
                                                        ></i>
                                                        Review</a
                                                    >
                                                </li> -->
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 3"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/suppliers/' +
                                                            props.row.id +
                                                            '/' +
                                                            props.row
                                                                .fair_code +
                                                            '/view'
                                                        "
                                                        ><i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details</a
                                                    >
                                                </li>
                                                <li
                                                    v-if="
                                                        permissions.can_approved
                                                    "
                                                >
                                                    <!-- <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            doApprove(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                        ><i
                                                            class="fas fa-thumbs-up"
                                                        ></i>
                                                        Approve</a
                                                    > -->
                                                </li>
                                                <!-- <li v-if="permissions.can_deny">
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            doDeny(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                        ><i
                                                            class="fas fa-thumbs-down"
                                                        ></i>
                                                        Deny</a
                                                    >
                                                </li> -->
                                                <li v-if="permissions.can_hold">
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            doHold(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                        ><i
                                                            class="fas fa-thumbtack"
                                                        ></i>
                                                        On hold</a
                                                    >
                                                </li>
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 4"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/suppliers/' +
                                                            props.row.id +
                                                            '/' +
                                                            props.row
                                                                .fair_code +
                                                            '/view'
                                                        "
                                                        ><i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details</a
                                                    >
                                                </li>
                                                <!-- <li
                                                    v-if="
                                                        permissions.can_approved
                                                    "
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            doApprove(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                        ><i
                                                            class="fas fa-thumbs-up"
                                                        ></i>
                                                        Approve</a
                                                    >
                                                </li> -->
                                                <!-- <li v-if="permissions.can_deny">
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            doDeny(
                                                                props.row.id,
                                                                props.row
                                                                    .fair_code
                                                            )
                                                        "
                                                        ><i
                                                            class="fas fa-thumbs-down"
                                                        ></i>
                                                        Deny</a
                                                    >
                                                </li> -->
                                            </ul>
                                        </div>
                                    </span>
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <generate-r-t-b-modal
            v-model="showRTBModal"
            :companies="selectedCompanies"
            @close="showRTBModal = false"
            @submit="handleGenerateRTB"
        />
        <generate-s-o-a-modal
            v-model="showGeneratedRTBModal"
            :companies="selectedCompanies"
            @close="showGeneratedRTBModal = false"
            @submit="handleMarkSOA"
        />
    </div>
</template>
<script>
import { VueGoodTable } from "vue-good-table";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VTooltipPlugin from "v-tooltip";
import "v-tooltip/dist/v-tooltip.css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import GenerateRTBModal from "./components/GenerateRTBModal.vue";
import GenerateSOAModal from "./components/GenerateSOAModal.vue";

Vue.use(VTooltipPlugin);
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    data() {
        return {
            selectableStatuses: ["For RTB"],
            columns: [
                {
                    label: "",
                    field: "checkbox",
                    sortable: false,
                    width: "40px",
                },
                {
                    label: "Company",
                    field: "co_name",
                    tdClass: "align-middle",
                },
                {
                    label: "E-mail Address",
                    field: "co_email",
                    tdClass: "align-middle",
                },
                {
                    label: "Region",
                    field: "moa_region",
                    tdClass: "align-middle",
                },
                {
                    label: "Status",
                    field: "display_status",
                    tdClass: "align-middle",
                },
                {
                    label: "SOA ",
                    field: "soa_status",
                    tdClass: "align-middle",
                    sortable: true,
                },
                {
                    label: "Payment ",
                    field: "payment_status",
                    tdClass: "align-middle",
                    sortable: true,
                },
                {
                    label: "Reviewer/Approver",
                    field: "modified_by_name",
                    tdClass: "align-middle",
                },
                {
                    label: "Date Registered",
                    field: "created_at",
                    tdClass: "align-middle",
                },
                {
                    label: "",
                    field: "actions",
                    sortable: false,
                    tdClass: "align-middle",
                },
            ],
            selectedRows: [],

            rows: [],
            permissions: [],
            events: [],
            selectedFairCode: "",
            isLoading: false,
            totalRecords: 0,
            serverParams: {
                columnFilters: {
                    co_name: "",
                    co_email: "",
                    status: "",
                    fair_code: "",
                    soa_status: "",
                    payment_status: "",
                },
                sort: {
                    field: "created_at",
                    type: "desc",
                },
                page: 1,
                perPage: 10,
            },
            showRTBModal: false,
            showGeneratedRTBModal: false,
            selectedCompanies: [],
        };
    },
    components: {
        VueGoodTable,
        GenerateRTBModal,
        GenerateSOAModal,
    },
    created() {
        this.fetchEvents();
    },
    filters: {
        str_limit(value, size) {
            if (!value) return "";
            value = value.toString();
            return value.length <= size ? value : value.substr(0, size) + "...";
        },
    },
    methods: {
        getLists() {
            this.isLoading = true;
            const formData = new FormData();
            formData.append("sort", JSON.stringify(this.serverParams.sort));
            formData.append(
                "filter",
                JSON.stringify(this.serverParams.columnFilters)
            );
            formData.append("page", this.serverParams.page);
            formData.append("per_page", this.serverParams.perPage);

            axios
                .post("/admin/registration/suppliers/list", formData)
                .then((response) => {
                    if (response.status === 200) {
                        this.rows = response.data.data.map((exhibitor) => ({
                            ...exhibitor,
                            modified_by_name:
                                exhibitor.status === 1
                                    ? exhibitor.approver?.name
                                    : exhibitor.status === 3
                                    ? exhibitor.reviewer?.name
                                    : exhibitor.status === 4
                                    ? exhibitor.onholder?.name
                                    : exhibitor.status === 5
                                    ? exhibitor.disapprover?.name
                                    : null,

                            display_status: exhibitor.display_status,
                            soa_status: exhibitor.soa_status,
                            payment_status: exhibitor.payment_status,
                        }));

                        this.permissions = response.data.permissions;
                        this.totalRecords = response.data.total;
                    }
                })
                .catch((error) => console.error(error))
                .finally(() => {
                    this.isLoading = false;
                    this.scrollToTop();
                });
        },

        fetchEvents() {
            this.isLoading = true;
            axios
                .get("/api/supplier/events")
                .then((response) => {
                    this.events = response.data;

                    if (this.events.length > 0) {
                        const latestEvent = this.events[0];
                        this.selectedFairCode = latestEvent.fair_code;
                        this.serverParams.columnFilters.fair_code =
                            latestEvent.fair_code;
                    }

                    this.getLists();
                })
                .catch((error) => console.error(error))
                .finally(() => (this.isLoading = false));
        },

        updateParams(newProps) {
            this.serverParams = { ...this.serverParams, ...newProps };
        },

        onPageChange(params) {
            this.updateParams({ page: params.currentPage });
            this.getLists();
        },
        onPerPageChange(params) {
            this.updateParams({ page: 1, perPage: params.currentPerPage });
            this.getLists();
        },
        onSortChange(params) {
            this.updateParams({ sort: params[0] });
            this.getLists();
        },
        onColumnFilter(params) {
            this.updateParams(params);
            this.getLists();
        },
        onResetFilter() {
            const defaultFairCode =
                this.events.length > 0 ? this.events[0].fair_code : "";
            this.serverParams.columnFilters = {
                co_name: "",
                co_email: "",
                status: "",
                fair_code: defaultFairCode,
                soa_status: "",
                payment_status: "",
            };
            this.selectedFairCode = defaultFairCode;
            this.getLists();
        },

        // Actions
        reSendRegLink(id) {
            this.$swal({
                title: "Are you sure you want to resend the registration link?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        axios
                            .get(`/admin/registration/resend/${id}/link`)
                            .then((res) => {
                                if (res.status === 200) {
                                    Vue.$toast.success(
                                        "Registration link successfully re-sent.",
                                        { position: "top-right" }
                                    );
                                }
                            })
                            .finally(() => (this.isLoading = false));
                    }
                },
            });
        },

        doReview(id, fair_code) {
            this.handleAction(id, fair_code, "review", "mark as reviewed");
        },
        doApprove(id, fair_code) {
            this.handleAction(id, fair_code, "approve", "approve");
        },
        doDeny(id, fair_code) {
            this.handleAction(id, fair_code, "deny", "deny");
        },
        doHold(id, fair_code) {
            this.handleAction(id, fair_code, "onhold", "on hold");
        },

        handleAction(id, fair_code, action, actionText) {
            this.$swal({
                title: `Are you sure you want to ${actionText} this application?`,
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        axios
                            .get(
                                `/admin/registration/${action}/${id}/application`,
                                { params: { fair_code } }
                            )
                            .then((res) => {
                                if (res.status === 200) {
                                    Vue.$toast.success(
                                        `Registration application successfully ${actionText}.`,
                                        {
                                            position: "top-right",
                                            onDismiss: this.getLists(),
                                        }
                                    );
                                }
                            })
                            .finally(() => (this.isLoading = false));
                    }
                },
            });
        },

        rowStyleClass(row) {
            if (!row || !row.id) return "";
            return this.selectedRows.includes(row.id) ? "table-active" : "";
        },

        selectByStatus(status) {
            this.selectedRows = this.rows
                .filter((r) => r.display_status === status)
                .map((r) => r.id);
        },
        selectAllRows() {
            this.selectedRows = this.rows.map((r) => r.id);
        },

        clearSelection() {
            this.selectedRows = [];
        },

        generateRTB() {
            if (this.validRTBIds.length === 0) {
                this.$toast.warning("No valid 'For RTB' records selected.");
                return;
            }

            this.selectedCompanies = this.rows
                .filter((row) => this.validRTBIds.includes(row.id))
                .map((row) => row.co_name);

            this.showRTBModal = true;
        },

        handleGenerateRTB({ venue, event_date, done }) {
            this.isLoading = true;

            axios
                .post("/admin/registration/generate-rtb", {
                    ids: this.validRTBIds,
                    fair_code: this.selectedFairCode,
                    venue,
                    event_date,
                })
                .then((res) => {
                    const { message, url, filename } = res.data;

                    this.$toast.success(message, { position: "top-right" });

                    // Clear selection and refresh table
                    this.clearSelection();
                    this.getLists();

                    // Auto-download the ZIP (RTB + conformes)
                    if (url) {
                        const link = document.createElement("a");
                        link.href = url;
                        // Use the filename from backend or default
                        link.download = filename || `RTB_Conformes.zip`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                })
                .catch((err) => {
                    const message =
                        err.response?.data?.message || "Failed to generate RTB";
                    this.$toast.error(message, { position: "top-right" });
                })
                .finally(() => {
                    this.isLoading = false;
                    this.showRTBModal = false;
                    done();
                });
        },
        statusBadgeClass(status) {
            switch (status) {
                case "For RTB":
                    return "badge bg-warning";
                case "Pending":
                    return "badge bg-info";
                case "Reviewed":
                case "Awaiting Conforme Response":
                    return "badge bg-primary";
                case "Pending Conforme Generation":
                    return "badge bg-warning";
                case "Incomplete":
                    return "badge bg-secondary";
                case "Onhold":
                    return "badge bg-dark";
                case "Denied":
                    return "badge bg-danger";
                case "Generated RTB":
                    return "badge bg-success";
                case "SOA Generated":
                    return "badge bg-success";
                case "SOA Not Generated":
                    return "badge bg-secondary";
                case "Paid":
                    return "badge bg-success";
                case "Unpaid":
                    return "badge bg-secondary";
                default:
                    return "badge bg-light";
            }
        },

        generateSOA() {
            if (this.selectedRows.length === 0) {
                this.$toast.warning("No companies selected.");
                return;
            }

            // Prepare array with id, name, current SOA status
            this.selectedCompanies = this.rows
                .filter((row) => this.selectedRows.includes(row.id))
                .map((row) => ({
                    id: row.id,
                    co_name: row.co_name,
                    is_soa_generated: row.soa_status === "SOA Generated",
                }));

            this.showGeneratedRTBModal = true;
        },

        handleMarkSOA({ updates, done }) {
            this.isLoading = true;

            axios
                .post("/admin/registration/mark-soa", {
                    updates, // [{ id, new_status }]
                    fair_code: this.selectedFairCode,
                })
                .then((res) => {
                    this.$toast.success("SOA status updated successfully.", {
                        position: "top-right",
                    });

                    // Refresh table
                    this.getLists();

                    // Clear selection
                    this.clearSelection();
                })
                .catch((err) => {
                    const message =
                        err.response?.data?.message || "Failed to update SOA";
                    this.$toast.error(message, { position: "top-right" });
                })
                .finally(() => {
                    this.isLoading = false;
                    this.showGeneratedRTBModal = false;
                    done();
                });
        },

        scrollToTop() {
            window.scroll({ top: 300, behavior: "smooth" });
        },
    },
    watch: {
        selectedFairCode(newVal) {
            this.serverParams.columnFilters.fair_code = newVal;
            this.getLists();
        },
        selectedRows(newVal) {
            this.selectAll = newVal.length === this.rows.length;
        },
    },
    computed: {
        hasForRTBSelected() {
            return this.rows.some(
                (row) =>
                    this.selectedRows.includes(row.id) &&
                    row.display_status === "For RTB"
            );
        },

        validRTBIds() {
            return this.rows
                .filter(
                    (row) =>
                        this.selectedRows.includes(row.id) &&
                        row.display_status === "For RTB"
                )
                .map((row) => row.id);
        },

        hasGeneratedRTBSelected() {
            return this.rows.some(
                (row) =>
                    this.selectedRows.includes(row.id) &&
                    row.display_status === "Generated RTB" &&
                    row.soa_status !== "SOA Generated"
            );
        },

        // All selected row ids with Generated RTB status
        generatedRTBIds() {
            return this.rows
                .filter(
                    (row) =>
                        this.selectedRows.includes(row.id) &&
                        row.display_status === "Generated RTB" &&
                        row.soa_status !== "SOA Generated"
                )
                .map((row) => row.id);
        },
    },
};
</script>
<style>
table.vgt-table {
    font-size: 14px !important;
}
.vgt-table.bordered td,
.vgt-table.bordered th {
    vertical-align: middle;
}
.vgt-wrap__footer .footer__row-count__label {
    font-size: 14px !important;
    font-weight: 600 !important;
}
.vgt-wrap__footer .footer__row-count__select {
    font-size: 14px !important;
    margin-top: -5px !important;
}
.vgt-wrap__footer .footer__row-count::after {
    margin-top: -5px !important;
}
.vgt-wrap__footer .footer__navigation {
    font-size: 14px !important;
}
.vgt-wrap__footer .footer__navigation__page-btn span {
    font-size: 14px !important;
}
</style>

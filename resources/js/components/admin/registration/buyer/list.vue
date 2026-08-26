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
                                    <!-- <option value="">-- Select --</option> -->
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
                                <label for="title" class="form-label"
                                    >Status</label
                                >
                                <select
                                    class="form-select form-select-sm"
                                    v-model="serverParams.columnFilters.status"
                                >
                                    <option :value="''">-- Select --</option>
                                    <option :value="'incomplete'">
                                        Incomplete
                                    </option>
                                    <option :value="1">Approved</option>
                                    <option :value="2">Pending</option>
                                    <option :value="3">Reviewed</option>
                                    <option :value="4">On hold</option>
                                    <option :value="5">Denied</option>
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
                        <h5 class="card-title">
                            List of purchaser/buyer registrations application
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
                            >
                                <div
                                    slot="emptystate"
                                    class="col-12 text-center"
                                >
                                    <span class="fw-bold"
                                        >No record found.</span
                                    >
                                </div>
                                <template slot="table-row" slot-scope="props">
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
                                            props.column.field === 'status'
                                        "
                                    >
                                        <span
                                            v-if="props.row.status === 1"
                                            class="badge bg-success"
                                            >Approved</span
                                        >
                                        <span
                                            v-else-if="props.row.status === 2"
                                            class="badge bg-info"
                                            >Pending</span
                                        >
                                        <span
                                            v-else-if="props.row.status === 3"
                                            class="badge bg-primary"
                                            >Reviewed</span
                                        >
                                        <span
                                            v-else-if="props.row.status === 4"
                                            class="badge bg-warning"
                                            >On hold</span
                                        >
                                        <span
                                            v-else-if="props.row.status === 5"
                                            class="badge bg-danger"
                                            >Denied</span
                                        >
                                        <span v-else class="badge bg-secondary"
                                            >Incomplete</span
                                        >
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
                                        >
                                            {{
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
                                                v-if="props.row.status === 0"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/buyers/' +
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
                                                        permissions.can_resend
                                                    "
                                                >
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            reSendRegLink(
                                                                props.row.id
                                                            )
                                                        "
                                                        ><i
                                                            class="fas fa-paper-plane"
                                                        ></i>
                                                        Resend registration
                                                        link</a
                                                    >
                                                </li> -->
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 1"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/buyers/' +
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
                                                            '/admin/registration/buyers/' +
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
                                                </li>
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 3"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/buyers/' +
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
                                                <!-- <li v-if="permissions.can_hold">
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
                                                </li> -->
                                            </ul>
                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 4"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/buyers/' +
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
                                            </ul>

                                            <ul
                                                class="dropdown-menu dropdown-menu-dark"
                                                v-if="props.row.status === 5"
                                            >
                                                <li v-if="permissions.can_view">
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/registration/buyers/' +
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

Vue.use(VTooltipPlugin);
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    data() {
        return {
            columns: [
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
                    field: "status",
                    tdClass: "align-middle",
                },
                {
                    label: "Reviewer/Approver",
                    field: "modified_by",
                    sortable: false,
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
                },
                sort: {
                    field: "created_at",
                    type: "desc",
                },
                page: 1,
                perPage: 10,
            },
            filter: {
                title: "",
                status: "",
                happening: "",
                type: "",
            },
        };
    },
    components: {
        VueGoodTable,
    },
    mounted() {},
    created() {
        this.getLists();
        this.fetchEvents();
    },
    filters: {
        str_limit(value, size) {
            if (!value) return "";
            value = value.toString();
            if (value.length <= size) {
                return value;
            }
            return value.substr(0, size) + "...";
        },
    },
    methods: {
        getLists() {
            this.isLoading = true;
            let formData = new FormData();
            formData.append("sort", JSON.stringify(this.serverParams.sort));
            formData.append(
                "filter",
                JSON.stringify(this.serverParams.columnFilters)
            );
            formData.append("page", this.serverParams.page);
            formData.append("per_page", this.serverParams.perPage);

            axios
                .post("/admin/registration/buyers/list", formData)
                .then((response) => {
                    if (response.status === 200) {
                        // Just assign rows directly from backend
                        this.rows = response.data.data.map((buyer) => ({
                            ...buyer,
                            // You can add any computed fields here if needed
                            modified_by_name:
                                buyer.status === 1
                                    ? buyer.approver?.name
                                    : buyer.status === 3
                                    ? buyer.reviewer?.name
                                    : buyer.status === 4
                                    ? buyer.onholder?.name
                                    : buyer.status === 5
                                    ? buyer.disapprover?.name
                                    : null,
                        }));

                        this.permissions = response.data.permissions;
                        this.totalRecords = response.data.total;
                        this.isLoading = false;
                        this.scrollToTop();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.isLoading = false;
                });
        },

        // fetchEvents() {
        //     this.isLoading = true;
        //     axios
        //         .get("/api/supplier/events")
        //         .then((response) => {
        //             this.events = response.data;
        //         })
        //         .catch((error) => {
        //             console.error("Error fetching events:", error);
        //         })
        //         .finally(() => {
        //             this.isLoading = false;
        //         });
        // },

        fetchEvents() {
            this.isLoading = true;
            axios
                .get("/api/supplier/events")
                .then((response) => {
                    this.events = response.data;

                    if (this.events.length > 0) {
                        // Get the latest event (assumes events are sorted by date descending)
                        const latestEvent = this.events[0]; // or sort by created_at/fair_date if needed
                        this.selectedFairCode = latestEvent.fair_code;
                        this.serverParams.columnFilters.fair_code =
                            latestEvent.fair_code;
                    }

                    // Load buyers for the default latest event
                    this.getLists();
                })
                .catch((error) => {
                    console.error("Error fetching events:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },
        onPageChange(params) {
            //console.log(params+'mac')
            this.updateParams({ page: params.currentPage });
            this.getLists();
        },
        onPerPageChange(params) {
            //console.log(params+'mac devette')
            this.updateParams({ page: 1, perPage: params.currentPerPage });
            this.getLists();
        },
        onSortChange(params) {
            //console.log(params[0].type)
            this.updateParams({
                sort: params[0],
            });
            this.getLists();
        },
        onColumnFilter(params) {
            this.updateParams(params);
            this.getLists();
        },
        // onResetFilter() {
        //     this.serverParams.columnFilters = {
        //         co_name: "",
        //         co_email: "",
        //         status: "",
        //         fair_code: "",
        //     };
        //     this.selectedFairCode = "";
        //     this.getLists();
        // },
        onResetFilter() {
            // Keep fair_code as the latest event if available
            const defaultFairCode =
                this.events.length > 0 ? this.events[0].fair_code : "";

            this.serverParams.columnFilters = {
                co_name: "",
                co_email: "",
                status: "",
                fair_code: defaultFairCode,
            };
            this.selectedFairCode = defaultFairCode;

            this.getLists();
        },

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
                        this.msg = "Resending registration link...";
                        axios
                            .get("/admin/registration/resend/" + id + "/link")
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration link successfully re-sent.",
                                        {
                                            position: "top-right",
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },
        doReview(id, fair_code) {
            this.$swal({
                title: "Are you sure you want to mark as reviewed this application?",
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
                        this.msg = "Reviewing application...";
                        axios
                            .get(
                                "/admin/registration/review/" +
                                    id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully mark as reviewed.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getLists(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },
        doApprove(id, fair_code) {
            this.$swal({
                title: "Are you sure you want to approve this application?",
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
                        this.msg = "Approving application...";
                        axios
                            .get(
                                "/admin/registration/approve/" +
                                    id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully approved.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getLists(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },
        doDeny(id, fair_code) {
            this.$swal({
                title: "Are you sure you want to deny this application?",
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
                        this.msg = "Disapproving application...";
                        axios
                            .get(
                                "/admin/registration/deny/" +
                                    id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully denied.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getLists(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },
        // doHold(id, fair_code) {
        //     this.$swal({
        //         title: "Are you sure you want to on hold this application?",
        //         icon: "question",
        //         showCancelButton: true,
        //         customClass: {
        //             title: "fs-5",
        //             confirmButton: "btn btn-sm btn-success text-white m-1",
        //             cancelButton: "btn btn-sm btn-secondary m-1",
        //         },
        //         buttonsStyling: false,
        //         preConfirm: (value) => {
        //             if (value) {
        //                 this.isLoading = true;
        //                 this.msg = "On holding application...";
        //                 axios
        //                     .get(
        //                         "/admin/registration/onhold/" +
        //                             id +
        //                             "/application",
        //                         {
        //                             params: {
        //                                 fair_code: fair_code,
        //                             },
        //                         }
        //                     )
        //                     .then((response) => {
        //                         if (response.status === 200) {
        //                             this.isLoading = false;
        //                             Vue.$toast.success(
        //                                 "Registration application successfully on hold.",
        //                                 {
        //                                     position: "top-right",
        //                                     onDismiss: this.getLists(),
        //                                 }
        //                             );
        //                         }
        //                     })
        //                     .catch((error) => {
        //                         console.log(error);
        //                     });
        //             }
        //         },
        //     });
        // },
        scrollToTop() {
            window.scroll({ top: 300, behavior: "smooth" });
        },
    },
    watch: {
        selectedFairCode(newVal) {
            this.serverParams.columnFilters.fair_code = newVal;
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

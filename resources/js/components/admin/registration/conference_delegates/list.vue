<template>
    <div>
        <div class="row">
            <!-- Filters -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row gy-3">
                            <!-- Registration Number -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Registration No.
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .registration_number
                                    "
                                    placeholder="Search registration no."
                                />
                            </div>

                            <!-- Company -->
                            <div class="col-md-3">
                                <label class="form-label"> Company </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.company_name
                                    "
                                    placeholder="Search company"
                                />
                            </div>

                            <!-- Contact Person -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Contact Person
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .contact_person
                                    "
                                    placeholder="Search contact person"
                                />
                            </div>

                            <!-- Contact Email -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Contact Email
                                </label>

                                <input
                                    type="email"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.contact_email
                                    "
                                    placeholder="Search email"
                                />
                            </div>

                            <!-- Event -->
                            <div class="col-md-3">
                                <label class="form-label"> Event </label>

                                <select
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters.fair_code
                                    "
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

                            <!-- Status -->
                            <div class="col-md-3">
                                <label class="form-label"> Status </label>

                                <select
                                    class="form-select form-select-sm"
                                    v-model="serverParams.columnFilters.status"
                                >
                                    <option value="">-- Select --</option>

                                    <option value="0">Draft</option>

                                    <option value="1">Pending</option>

                                    <option value="2">Registered</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 text-end mt-3">
                                <button
                                    class="btn btn-success btn-sm text-white"
                                    @click="onColumnFilter"
                                >
                                    Search
                                </button>

                                <button
                                    class="btn btn-secondary btn-sm"
                                    @click="onResetFilter"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-end mb-4"
                        >
                            <div>
                                <h5 class="card-title mb-1">
                                    Conference Delegate Registrations
                                </h5>

                                <small class="text-muted">
                                    Registered companies and their delegates
                                </small>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <vue-good-table
                                mode="remote"
                                :columns="columns"
                                :rows="rows"
                                :totalRows="totalRecords"
                                :isLoading.sync="isLoading"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                :pagination-options="{
                                    enabled: true,
                                    perPageDropdown: [10, 20, 50, 100],
                                }"
                                styleClass="vgt-table striped"
                            >
                                <template slot="emptystate">
                                    <div class="text-center py-5">
                                        <strong>
                                            No registrations found.
                                        </strong>
                                    </div>
                                </template>

                                <template slot="table-row" slot-scope="props">
                                    <!-- Registration Number -->
                                    <span
                                        v-if="
                                            props.column.field ==
                                            'registration_number'
                                        "
                                    >
                                        {{ props.row.registration_number }}
                                    </span>

                                    <!-- Company -->
                                    <span
                                        v-else-if="
                                            props.column.field == 'company_name'
                                        "
                                    >
                                        {{ props.row.company_name }}
                                    </span>

                                    <!-- Contact -->
                                    <span
                                        v-else-if="
                                            props.column.field ==
                                            'contact_person'
                                        "
                                    >
                                        {{ props.row.contact_person }}
                                    </span>

                                    <!-- Email -->
                                    <span
                                        v-else-if="
                                            props.column.field ==
                                            'contact_email'
                                        "
                                    >
                                        {{ props.row.contact_email }}
                                    </span>

                                    <!-- Participants -->
                                    <span
                                        v-else-if="
                                            props.column.field ==
                                            'participant_count'
                                        "
                                    >
                                        {{ props.row.participant_count }}
                                    </span>

                                    <!-- Event -->
                                    <span
                                        v-else-if="
                                            props.column.field == 'fair_code'
                                        "
                                    >
                                        {{ props.row.fair_code }}
                                    </span>

                                    <!-- Status -->
                                    <span
                                        v-else-if="
                                            props.column.field == 'status'
                                        "
                                    >
                                        <span
                                            v-if="props.row.status == 2"
                                            class="badge bg-success"
                                        >
                                            Registered
                                        </span>

                                        <span
                                            v-else-if="props.row.status == 1"
                                            class="badge bg-warning"
                                        >
                                            Pending
                                        </span>

                                        <span v-else class="badge bg-secondary">
                                            Draft
                                        </span>
                                    </span>

                                    <!-- Review -->
                                    <span
                                        v-else-if="
                                            props.column.field == 'review'
                                        "
                                    >
                                        <span
                                            v-if="props.row.review === 'Yes'"
                                            class="badge bg-success"
                                        >
                                            Yes
                                        </span>

                                        <span v-else class="badge bg-secondary">
                                            No
                                        </span>
                                    </span>

                                    <!-- SOA / Billing -->
                                    <span
                                        v-else-if="
                                            props.column.field ==
                                            'billing_status'
                                        "
                                    >
                                        <span
                                            class="badge"
                                            :class="
                                                billingStatusClass(
                                                    props.row.billing_status
                                                )
                                            "
                                        >
                                            {{
                                                billingStatusText(
                                                    props.row.billing_status
                                                )
                                            }}
                                        </span>
                                    </span>

                                    <!-- Created -->
                                    <span
                                        v-else-if="
                                            props.column.field == 'created_at'
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
                                            props.column.field === 'actions'
                                        "
                                    >
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-link text-dark p-0"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false"
                                            >
                                                <i
                                                    class="mdi mdi-dots-vertical fs-5"
                                                ></i>
                                            </button>

                                            <ul
                                                class="dropdown-menu dropdown-menu-end"
                                            >
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        :href="`/admin/registration/delegates/view/${props.row.id}`"
                                                    >
                                                        <i
                                                            class="mdi mdi-eye-outline me-2"
                                                        ></i>

                                                        View Details
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Delegates Modal -->
        <div class="modal fade" id="delegateModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Conference Delegates</h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div v-if="selectedRegistration">
                            <div class="mb-3">
                                <h5 class="mb-1">
                                    {{ selectedRegistration.company_name }}
                                </h5>

                                <small class="text-muted">
                                    {{
                                        selectedRegistration.registration_number
                                    }}
                                </small>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Designation</th>
                                            <th>Company</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr
                                            v-for="delegate in selectedRegistration.delegates"
                                            :key="delegate.id"
                                        >
                                            <td>
                                                {{ delegate.name }}
                                            </td>

                                            <td>
                                                {{ delegate.email }}
                                            </td>

                                            <td>
                                                {{ delegate.designation }}
                                            </td>

                                            <td>
                                                {{ delegate.company }}
                                            </td>

                                            <td>
                                                {{ delegate.mobile }}
                                            </td>
                                        </tr>

                                        <tr
                                            v-if="
                                                !selectedRegistration.delegates
                                                    .length
                                            "
                                        >
                                            <td colspan="5" class="text-center">
                                                No delegates found.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
import VTooltipPlugin from "v-tooltip";
import VueToast from "vue-toast-notification";

Vue.use(VTooltipPlugin);
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    components: {
        VueGoodTable,
    },

    data() {
        return {
            columns: [
                {
                    label: "Registration No.",
                    field: "registration_number",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Company",
                    field: "company_name",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Contact Person",
                    field: "contact_person",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Email",
                    field: "contact_email",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Participants",
                    field: "participant_count",
                    sortable: true,
                    tdClass: "align-middle text-center",
                },

                {
                    label: "Event",
                    field: "fair_code",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Status",
                    field: "status",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Review",
                    field: "review",
                    sortable: false,
                    tdClass: "align-middle text-center",
                },

                {
                    label: "SOA/Billing",
                    field: "billing_status",
                    sortable: false,
                    tdClass: "align-middle text-center",
                },

                {
                    label: "Created",
                    field: "created_at",
                    sortable: true,
                    tdClass: "align-middle",
                },

                {
                    label: "Actions",
                    field: "actions",
                    sortable: false,
                    tdClass: "align-middle text-center",
                },
            ],

            rows: [],

            events: [],

            selectedFairCode: "",

            totalRecords: 0,

            isLoading: false,

            delegateModal: null,

            selectedRegistration: null,

            serverParams: {
                columnFilters: {
                    registration_number: "",
                    company_name: "",
                    contact_person: "",
                    contact_email: "",
                    fair_code: "",
                    status: "",
                },

                sort: {
                    field: "created_at",
                    type: "desc",
                },

                page: 1,

                perPage: 10,
            },
        };
    },

    created() {
        this.fetchEvents();
    },

    mounted() {
        this.delegateModal = new bootstrap.Modal(
            document.getElementById("delegateModal")
        );
    },

    methods: {
        getLists() {
            this.isLoading = true;

            axios
                .post("/admin/registration/delegates/list", {
                    sort: this.serverParams.sort,

                    filter: this.serverParams.columnFilters,

                    page: this.serverParams.page,

                    per_page: this.serverParams.perPage,
                })
                .then((res) => {
                    this.rows = res.data.data;

                    this.totalRecords = res.data.total;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        fetchEvents() {
            axios.get("/api/supplier/events").then((res) => {
                this.events = res.data;

                if (this.events.length) {
                    this.selectedFairCode = this.events[0].fair_code;

                    this.serverParams.columnFilters.fair_code =
                        this.selectedFairCode;
                }

                this.getLists();
            });
        },

        onColumnFilter() {
            this.serverParams.page = 1;

            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                registration_number: "",
                company_name: "",
                contact_person: "",
                contact_email: "",
                fair_code: this.events.length ? this.events[0].fair_code : "",
                status: "",
            };

            this.serverParams.page = 1;

            this.getLists();
        },

        onPageChange(params) {
            this.serverParams.page = params.currentPage;

            this.getLists();
        },

        onPerPageChange(params) {
            this.serverParams.page = 1;

            this.serverParams.perPage = params.currentPerPage;

            this.getLists();
        },

        onSortChange(params) {
            if (!params.length) {
                return;
            }

            this.serverParams.page = 1;

            this.serverParams.sort = {
                field: params[0].field,

                type: params[0].type,
            };

            this.getLists();
        },

        viewDelegates(row) {
            this.selectedRegistration = row;

            this.delegateModal.show();
        },

        deleteRegistration(row) {
            this.$swal({
                title: "Delete Registration?",

                html: `
                    <div class="text-start">

                        <p>
                            <strong>Registration No.</strong><br>
                            ${row.registration_number}
                        </p>

                        <p>
                            <strong>Company</strong><br>
                            ${row.company_name}
                        </p>

                        <p>
                            <strong>Contact Person</strong><br>
                            ${row.contact_person}
                        </p>

                        <p>
                            <strong>Email</strong><br>
                            ${row.contact_email}
                        </p>

                        <hr>

                        <p class="text-danger mb-0">
                            This action cannot be undone.
                        </p>

                    </div>
                `,

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#dc3545",

                confirmButtonText: "Delete",

                cancelButtonText: "Cancel",
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                axios
                    .delete(`/admin/conference/delegates/${row.id}`)
                    .then(() => {
                        this.$swal({
                            title: "Deleted!",

                            text: "Registration has been deleted.",

                            icon: "success",
                        });

                        this.getLists();
                    });
            });
        },
        billingStatusText(status) {
            switch (Number(status)) {
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

        billingStatusClass(status) {
            switch (Number(status)) {
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
    },

    watch: {
        selectedFairCode(newValue) {
            this.serverParams.columnFilters.fair_code = newValue;
        },
    },
};
</script>

<template>
    <div>
        <div class="row">
            <!-- Filters -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row gy-3">
                            <!-- Email -->
                            <div class="col-md-3">
                                <label class="form-label">E-mail</label>
                                <input
                                    type="email"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.co_email
                                    "
                                    placeholder="Search by email"
                                />
                            </div>

                            <!-- Attendee Type -->
                            <div class="col-md-3">
                                <label class="form-label">Attendee Type</label>
                                <select
                                    J
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters.attendee_type
                                    "
                                >
                                    <option value="">-- Select --</option>
                                    <option
                                        v-for="type in attendeeTypes"
                                        :key="type.id"
                                        :value="type.name"
                                    >
                                        {{ type.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Fair Code -->
                            <div class="col-md-3">
                                <label class="form-label"
                                    >Event (Fair Code)</label
                                >
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

                            <!-- Promo Code -->
                            <div class="col-md-3">
                                <label class="form-label">Promo Code</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.promo_code
                                    "
                                    placeholder="Search promo code"
                                />
                            </div>

                            <!-- Redeemed -->
                            <div class="col-md-3">
                                <label class="form-label">Redeemed</label>
                                <select
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters.redeemed
                                    "
                                >
                                    <option value="">-- Select --</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>

                            <!-- redeemed by -->
                            <div class="col-md-3">
                                <label class="form-label">Redeemed By</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .redeemed_by_email
                                    "
                                    placeholder="Search redeemer email"
                                />
                            </div>

                            <!-- Status -->
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select
                                    class="form-select form-select-sm"
                                    v-model="serverParams.columnFilters.status"
                                >
                                    <option value="">-- Select --</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 mt-3 text-end">
                                <button
                                    class="btn btn-success btn-sm"
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
                                    List of Emails with Promo Codes
                                </h5>
                            </div>

                            <div class="gap-2">
                                <button
                                    class="btn btn-primary btn-sm mb-2"
                                    @click="showCreatePromo = true"
                                >
                                    Create Promo Email
                                </button>
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
                                    <div class="col-12 text-center">
                                        <span class="fw-bold">
                                            No record found.
                                        </span>
                                    </div>
                                </template>

                                <template slot="table-row" slot-scope="props">
                                    <!-- Email -->
                                    <span
                                        v-if="props.column.field === 'co_email'"
                                    >
                                        {{ props.row.co_email || "—" }}
                                    </span>

                                    <!-- Promo Code -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'promo_code'
                                        "
                                    >
                                        {{ props.row.promo_code || "—" }}
                                    </span>

                                    <!-- Redeemed -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'redeemed'
                                        "
                                    >
                                        <span
                                            v-if="props.row.redeemed === 1"
                                            class="badge bg-success"
                                        >
                                            Yes
                                        </span>

                                        <span v-else class="badge bg-secondary">
                                            No
                                        </span>
                                    </span>

                                    <!-- Redeemed By -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'redeemed_by_email'
                                        "
                                    >
                                        {{ props.row.redeemed_by_email || "—" }}
                                    </span>

                                    <!-- Redeemed At -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'redeemed_at'
                                        "
                                    >
                                        <span v-if="props.row.redeemed_at">
                                            {{
                                                props.row.redeemed_at
                                                    | moment("llll")
                                            }}
                                        </span>

                                        <span v-else> — </span>
                                    </span>

                                    <!-- Date -->
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
                                                        href="#"
                                                        @click.prevent="
                                                            editPromo(props.row)
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-pencil me-2"
                                                        ></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        href="#"
                                                        @click.prevent="
                                                            deletePromo(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-delete me-2"
                                                        ></i>
                                                        Delete
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
        <create-promo-email v-model="showCreatePromo" @refresh="getLists" />
        <edit-promo-email
            v-model="showEditPromo"
            :row="selectedRow"
            @refresh="getLists"
        />
    </div>
</template>

<script>
import { VueGoodTable } from "vue-good-table";
import VueSweetalert2 from "vue-sweetalert2";
import VTooltipPlugin from "v-tooltip";
import VueToast from "vue-toast-notification";
import CreatePromoEmail from "./components/CreatePromoEmail.vue";
import EditPromoEmail from "./components/EditModal.vue";

Vue.use(VTooltipPlugin);
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    components: {
        VueGoodTable,
        CreatePromoEmail,
        EditPromoEmail,
    },

    data() {
        return {
            columns: [
                {
                    label: "E-mail",
                    field: "co_email",
                    sortable: true,
                    tdClass: "align-middle",
                },
                {
                    label: "Promo Code",
                    field: "promo_code",
                    sortable: true,
                    tdClass: "align-middle",
                },
                {
                    label: "Redeemed",
                    field: "redeemed",
                    sortable: true,
                    tdClass: "align-middle",
                },
                {
                    label: "Redeemed By",
                    field: "redeemed_by_email",
                    sortable: true,
                    tdClass: "align-middle",
                },
                {
                    label: "Redeemed At",
                    field: "redeemed_at",
                    sortable: true,
                    tdClass: "align-middle",
                },
                {
                    label: "Created at",
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
            attendeeTypes: [],

            selectedFairCode: "",
            isLoading: false,
            totalRecords: 0,

            serverParams: {
                columnFilters: {
                    co_email: "",
                    attendee_type: "",
                    fair_code: "",
                    status: "",
                    promo_code: "",
                    redeemed: "",
                    redeemed_by_email: "",
                },
                sort: {
                    field: "created_at",
                    type: "desc",
                },
                page: 1,
                perPage: 10,
            },
            showCreatePromo: false,
            showEditPromo: false,
            selectedRow: null,
        };
    },

    created() {
        this.fetchEvents();
        this.fetchAttendeeTypes();
    },

    methods: {
        getLists() {
            this.isLoading = true;

            axios
                .post("/admin/promo-codes/users/list", {
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

        fetchAttendeeTypes() {
            axios.get("/api/attendee-types").then((res) => {
                this.attendeeTypes = res.data;
            });
        },

        onColumnFilter() {
            this.serverParams.page = 1;
            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                co_email: "",
                attendee_type: "",
                fair_code: this.events.length ? this.events[0].fair_code : "",
                status: "",
                promo_code: "",
                redeemed: "",
                redeemed_by_email: "",
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
            if (!params.length) return;

            this.serverParams.page = 1;

            this.serverParams.sort = {
                field: params[0].field,
                type: params[0].type,
            };

            this.getLists();
        },
        editPromo(row) {
            this.selectedRow = row;
            this.showEditPromo = true;
        },

        deletePromo(row) {
            const redeemed = row.redeemed === 1;
            console.log("ATTENDEE TYPE:", row.attendee_type);
            this.$swal({
                title: "Delete Promo Assignment?",
                html: `
            <div class="text-start">

                <p>
                    <strong>Email:</strong><br>
                    ${row.co_email || "—"}
                </p>

                <p>
                    <strong>Event:</strong><br>
                    ${row.fair_code || "—"}
                </p>

                <p>
                    <strong>Promo Code:</strong><br>
                    ${row.promo_code || "—"}
                </p>

                <p>
                    <strong>Attendee Type:</strong><br>
                    ${row.attendee_type || "—"}
                </p>

                <p>
                    <strong>Redeemed:</strong><br>
                    ${
                        redeemed
                            ? '<span class="badge bg-success">Yes</span>'
                            : '<span class="badge bg-secondary">No</span>'
                    }
                </p>

                ${
                    redeemed
                        ? `
                        <p>
                            <strong>Redeemed By:</strong><br>
                            ${row.redeemed_by_email || "—"}
                        </p>

                        <p>
                            <strong>Redeemed At:</strong><br>
                            ${row.redeemed_at || "—"}
                        </p>
                    `
                        : ""
                }

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
                if (result.isConfirmed) {
                    axios
                        .delete(`/admin/promo-codes/users/${row.id}/delete`)
                        .then(() => {
                            this.$swal({
                                title: "Deleted!",
                                text: "The promo assignment has been deleted.",
                                icon: "success",
                            });

                            this.getLists();
                        });
                }
            });
        },
    },

    watch: {
        selectedFairCode(newVal) {
            this.serverParams.columnFilters.fair_code = newVal;
        },
    },
};
</script>

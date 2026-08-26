<template>
    <div>
        <div class="row">
            <!-- FILTERS -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filters</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-3">
                                <label class="form-label">Company Name</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.company_name
                                    "
                                />
                            </div>

                            <!-- Payment Status -->
                            <div class="col-md-3">
                                <label class="form-label">Payment Status</label>
                                <select
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .payment_status
                                    "
                                >
                                    <option value="">-- Select --</option>
                                    <option :value="0">Unpaid</option>
                                    <option :value="1">Paid</option>
                                    <option :value="2">Pending</option>
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

                            <!-- Buttons -->
                            <div class="col-md-3 mt-3 text-end">
                                <button
                                    class="btn btn-sm btn-success text-white"
                                    @click="onColumnFilter"
                                >
                                    Search
                                </button>
                                <button
                                    class="btn btn-sm btn-secondary"
                                    @click="onResetFilter"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Supplier/Exhibitor Payments</h5>
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
                                <div slot="emptystate" class="text-center">
                                    <strong>No record found.</strong>
                                </div>

                                <template slot="table-row" slot-scope="props">
                                    <span
                                        v-if="
                                            props.column.field ===
                                            'company_name'
                                        "
                                    >
                                        {{ props.row.company_name }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field === 'event_name'
                                        "
                                    >
                                        {{ props.row.event_name }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'payment_status'
                                        "
                                    >
                                        <span
                                            :class="
                                                paymentBadge(props.row).class
                                            "
                                        >
                                            {{ paymentBadge(props.row).label }}
                                        </span>
                                    </span>

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

                                    <span
                                        v-else-if="
                                            props.column.field === 'actions'
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
                                            >
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            goToSupplierPayment(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        @click.prevent="
                                                            openSupplierExhibitor(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-account"
                                                        ></i>
                                                        Registration Details
                                                    </a>
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
import "vue-good-table/dist/vue-good-table.css";

export default {
    components: { VueGoodTable },

    data() {
        return {
            columns: [
                { label: "Company Name", field: "company_name" },
                { label: "Payment Status", field: "payment_status" },
                { label: "Date Registered", field: "created_at" },
                {
                    label: "",
                    field: "actions",
                    sortable: false,
                    tdClass: "align-middle",
                },
            ],

            rows: [],
            totalRecords: 0,
            isLoading: false,

            events: [], // for Fair Code dropdown
            serverParams: {
                columnFilters: {
                    event_name: "",
                    company_name: "",
                    payment_status: "",
                    fair_code: "", // Fair code filter
                },
                sort: { field: "created_at", type: "desc" },
                page: 1,
                perPage: 10,
            },
        };
    },

    created() {
        this.fetchEvents(); // populate fair codes and default filter
    },

    methods: {
        fetchEvents() {
            this.isLoading = true;
            axios
                .get("/api/supplier/events")
                .then((response) => {
                    this.events = response.data;

                    if (this.events.length > 0) {
                        const latestEvent = this.events[0];
                        this.serverParams.columnFilters.fair_code =
                            latestEvent.fair_code;
                    }

                    this.getLists();
                })
                .catch((error) => console.error(error))
                .finally(() => (this.isLoading = false));
        },

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
                .post("/api/supplier/payment/event-list", formData)
                .then((res) => {
                    this.rows = res.data.data;
                    this.totalRecords = res.data.total;
                })
                .finally(() => (this.isLoading = false));
        },

        paymentBadge(row) {
            switch (row.payment_status) {
                case 1:
                    return { label: "Paid", class: "badge bg-success" };
                case 2:
                    return { label: "Pending", class: "badge bg-warning" };
                default:
                    return { label: "Unpaid", class: "badge bg-secondary" };
            }
        },

        goToSupplierPayment(row) {
            if (!row.user_id || !row.event_slug || !row.fair_code) {
                console.error("Missing user_id, event_slug, or fair_code!");
                return;
            }

            const url = `/admin/payments/supplier-exhibitor/${row.user_id}/${row.event_slug}/${row.fair_code}`;

            console.log("Redirect URL:", url);

            // Uncomment to navigate
            window.location.href = url;
        },

        async openSupplierExhibitor(row) {
            if (!row.user_id || !row.event_slug || !row.fair_code) {
                console.error("Missing user_id, event_slug, or fair_code!");
                return;
            }

            const url = `/admin/registration/suppliers/${row.user_id}/${row.fair_code}/view`;
            window.open(url, "_blank");
        },

        onColumnFilter() {
            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                event_name: "",
                company_name: "",
                payment_status: "",
                fair_code: this.events[0]?.fair_code ?? "",
            };
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
            this.serverParams.sort = params[0];
            this.getLists();
        },
    },
};
</script>

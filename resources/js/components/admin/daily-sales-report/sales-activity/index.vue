<template>
    <div>
        <div class="row">
            <!-- FILTERS -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title mb-0">General Summary Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <!-- COMPANY -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label"> Company Name </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="serverParams.columnFilters.company"
                                    placeholder="Search company..."
                                />
                            </div>

                            <!-- DATE -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label">
                                    Date of Activity
                                </label>

                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.date_of_sale
                                    "
                                />
                            </div>

                            <div class="col-12 col-md-6 col-lg-3">
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
                            <!-- BUTTONS -->
                            <div
                                class="col-12 col-lg-3 d-flex justify-content-end"
                            >
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm me-2 text-white"
                                    @click="onColumnFilter"
                                >
                                    Search
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-light btn-sm border"
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
            <div class="col-12 mt-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-end mb-4"
                        >
                            <div>
                                <h5 class="card-title mb-1">
                                    General Summary Feed
                                </h5>

                                <p class="text-muted small mb-0">
                                    Unified Export, Domestic, Retail and Inquiry
                                    activity logs per company
                                </p>
                            </div>

                            <div class="gap-2">
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm text-white me-2"
                                    @click="goToSalesManagement"
                                >
                                    Manage Sales
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-outline-success btn-sm"
                                    @click="exportExcel"
                                >
                                    <i
                                        class="mdi mdi-file-excel-outline me-1"
                                    ></i>
                                    Export Excel
                                </button>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <div class="activity-wrapper">
                            <vue-good-table
                                mode="remote"
                                :columns="columns"
                                :rows="groupedRows"
                                :totalRows="totalRecords"
                                :isLoading.sync="isLoading"
                                :pagination-options="{
                                    enabled: true,
                                    perPageDropdown: [10, 20, 50, 100],
                                }"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                styleClass="vgt-table striped bordered"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <!-- COMPANY -->
                                    <div
                                        v-if="props.column.field === 'company'"
                                    >
                                        <div
                                            class="company-name fw-bold text-dark"
                                        >
                                            {{ props.row.company }}
                                        </div>

                                        <div
                                            class="small text-muted mt-1"
                                            v-if="props.row.total_activities"
                                        >
                                            {{ props.row.total_activities }}
                                            activities
                                        </div>
                                    </div>

                                    <!-- EXPORT -->
                                    <div
                                        v-else-if="
                                            props.column.field === 'export'
                                        "
                                    >
                                        <div
                                            v-if="
                                                props.row.export &&
                                                props.row.export.length
                                            "
                                        >
                                            <div
                                                v-for="(item, index) in props
                                                    .row.export"
                                                :key="index"
                                                class="activity-card export-card"
                                            >
                                                <div
                                                    class="activity-header d-flex justify-content-between align-items-start"
                                                >
                                                    <div>
                                                        <span
                                                            class="badge activity-badge export-badge"
                                                        >
                                                            Export
                                                        </span>
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center gap-2"
                                                    >
                                                        <small
                                                            class="text-muted"
                                                        >
                                                            {{
                                                                item.date_of_sale
                                                            }}
                                                        </small>

                                                        <!-- ACTION MENU -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm btn-icon action-menu-btn"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                            >
                                                                <i
                                                                    class="mdi mdi-dots-vertical"
                                                                ></i>
                                                            </button>

                                                            <ul
                                                                class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                                            >
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item"
                                                                        @click="
                                                                            onEditActivity(
                                                                                item.ff_code,
                                                                                props
                                                                                    .row
                                                                                    .company,
                                                                                item.fair_code
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-pencil-outline me-2"
                                                                        ></i>
                                                                        Edit
                                                                    </button>
                                                                </li>

                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-danger"
                                                                        @click="
                                                                            onDeleteActivity(
                                                                                item,
                                                                                'export',
                                                                                props
                                                                                    .row
                                                                                    .company
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-delete-outline me-2"
                                                                        ></i>
                                                                        Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="activity-body mt-2">
                                                    <div class="fw-semibold">
                                                        {{
                                                            item.product_service
                                                        }}
                                                    </div>

                                                    <div
                                                        class="small text-muted mt-1"
                                                    >
                                                        →
                                                        {{ item.buyer_company }}
                                                        ({{ item.country }})
                                                    </div>

                                                    <div
                                                        class="metric-line mt-2"
                                                    >
                                                        <span
                                                            class="metric-success"
                                                        >
                                                            Booked:
                                                            <strong>
                                                                ${{
                                                                    item.booked
                                                                }}
                                                            </strong>
                                                        </span>

                                                        <span
                                                            class="mx-2 text-muted"
                                                        >
                                                            •
                                                        </span>

                                                        <span
                                                            class="metric-warning"
                                                        >
                                                            Under Negotiation:
                                                            <strong>
                                                                ${{
                                                                    item.under_negotiation
                                                                }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-else class="empty-state">—</div>
                                    </div>

                                    <!-- DOMESTIC -->
                                    <div
                                        v-else-if="
                                            props.column.field === 'domestic'
                                        "
                                    >
                                        <div
                                            v-if="
                                                props.row.domestic &&
                                                props.row.domestic.length
                                            "
                                        >
                                            <div
                                                v-for="(item, index) in props
                                                    .row.domestic"
                                                :key="index"
                                                class="activity-card domestic-card"
                                            >
                                                <div
                                                    class="activity-header d-flex justify-content-between align-items-start"
                                                >
                                                    <div>
                                                        <span
                                                            class="badge activity-badge domestic-badge"
                                                        >
                                                            Domestic
                                                        </span>
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center gap-2"
                                                    >
                                                        <small
                                                            class="text-muted"
                                                        >
                                                            {{
                                                                item.date_of_sale
                                                            }}
                                                        </small>
                                                        <!-- ACTION MENU -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm btn-icon action-menu-btn"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                            >
                                                                <i
                                                                    class="mdi mdi-dots-vertical"
                                                                ></i>
                                                            </button>

                                                            <ul
                                                                class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                                            >
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item"
                                                                        @click="
                                                                            onEditActivity(
                                                                                item.ff_code,
                                                                                props
                                                                                    .row
                                                                                    .company,
                                                                                item.fair_code
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-pencil-outline me-2"
                                                                        ></i>
                                                                        Edit
                                                                    </button>
                                                                </li>

                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-danger"
                                                                        @click="
                                                                            onDeleteActivity(
                                                                                item,
                                                                                'domestic',
                                                                                props
                                                                                    .row
                                                                                    .company
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-delete-outline me-2"
                                                                        ></i>
                                                                        Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="activity-body mt-2">
                                                    <div class="fw-semibold">
                                                        {{
                                                            item.product_service
                                                        }}
                                                    </div>

                                                    <div
                                                        class="small text-muted mt-1"
                                                    >
                                                        →
                                                        {{ item.buyer_company }}
                                                    </div>

                                                    <div
                                                        class="small text-muted mt-1"
                                                    >
                                                        Buyer Type:
                                                        {{ item.type_of_buyer }}
                                                    </div>

                                                    <div
                                                        class="metric-line mt-2"
                                                    >
                                                        <span
                                                            class="metric-success"
                                                        >
                                                            Booked:
                                                            <strong>
                                                                ₱{{
                                                                    item.booked
                                                                }}
                                                            </strong>
                                                        </span>

                                                        <span
                                                            class="mx-2 text-muted"
                                                        >
                                                            •
                                                        </span>

                                                        <span
                                                            class="metric-warning"
                                                        >
                                                            Under Negotiation:
                                                            <strong>
                                                                ₱{{
                                                                    item.under_negotiation
                                                                }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-else class="empty-state">—</div>
                                    </div>

                                    <!-- RETAIL -->
                                    <div
                                        v-else-if="
                                            props.column.field === 'retail'
                                        "
                                    >
                                        <div
                                            v-if="
                                                props.row.retail &&
                                                props.row.retail.length
                                            "
                                        >
                                            <div
                                                v-for="(item, index) in props
                                                    .row.retail"
                                                :key="index"
                                                class="activity-card retail-card"
                                            >
                                                <div
                                                    class="activity-header d-flex justify-content-between align-items-start"
                                                >
                                                    <div>
                                                        <span
                                                            class="badge activity-badge retail-badge"
                                                        >
                                                            Retail
                                                        </span>
                                                    </div>

                                                    <div
                                                        class="d-flex align-items-center gap-2"
                                                    >
                                                        <small
                                                            class="text-muted"
                                                        >
                                                            {{
                                                                item.date_of_sale
                                                            }}
                                                        </small>

                                                        <!-- ACTION MENU -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm btn-icon action-menu-btn"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                            >
                                                                <i
                                                                    class="mdi mdi-dots-vertical"
                                                                ></i>
                                                            </button>

                                                            <ul
                                                                class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                                            >
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item"
                                                                        @click="
                                                                            onEditActivity(
                                                                                item.ff_code,
                                                                                props
                                                                                    .row
                                                                                    .company,
                                                                                item.fair_code
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-pencil-outline me-2"
                                                                        ></i>
                                                                        Edit
                                                                    </button>
                                                                </li>

                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-danger"
                                                                        @click="
                                                                            onDeleteActivity(
                                                                                item,
                                                                                'retail',
                                                                                props
                                                                                    .row
                                                                                    .company
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-delete-outline me-2"
                                                                        ></i>
                                                                        Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="activity-body mt-2">
                                                    <div class="fw-semibold">
                                                        {{
                                                            item.product_service
                                                        }}
                                                    </div>

                                                    <div
                                                        class="small text-muted mt-1"
                                                    >
                                                        Buyer Type:
                                                        {{ item.type_of_buyer }}
                                                    </div>

                                                    <div
                                                        class="metric-line mt-2"
                                                    >
                                                        <span
                                                            class="metric-success"
                                                        >
                                                            Retail Sales:
                                                            <strong>
                                                                ₱{{
                                                                    item.booked
                                                                }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-else class="empty-state">—</div>
                                    </div>

                                    <!-- INQUIRIES -->
                                    <div
                                        v-else-if="
                                            props.column.field === 'inquiries'
                                        "
                                    >
                                        <div
                                            v-if="
                                                props.row.inquiries &&
                                                props.row.inquiries.length
                                            "
                                        >
                                            <div
                                                v-for="(item, index) in props
                                                    .row.inquiries"
                                                :key="index"
                                                class="activity-card inquiry-card"
                                            >
                                                <div
                                                    class="activity-header d-flex justify-content-between align-items-start"
                                                >
                                                    <div>
                                                        <span
                                                            class="badge activity-badge inquiry-badge"
                                                        >
                                                            Inquiry
                                                        </span>
                                                    </div>
                                                    <div
                                                        class="d-flex align-items-center gap-2"
                                                    >
                                                        <small
                                                            class="text-muted"
                                                        >
                                                            {{
                                                                item.date_of_sale
                                                            }}
                                                        </small>
                                                        <!-- ACTION MENU -->
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm btn-icon action-menu-btn"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                            >
                                                                <i
                                                                    class="mdi mdi-dots-vertical"
                                                                ></i>
                                                            </button>

                                                            <ul
                                                                class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                                            >
                                                                <li>
                                                                    <button
                                                                        class="dropdown-item"
                                                                        @click="
                                                                            onEditActivity(
                                                                                item.ff_code,
                                                                                props
                                                                                    .row
                                                                                    .company,
                                                                                item.fair_code
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-pencil-outline me-2"
                                                                        ></i>
                                                                        Edit
                                                                    </button>
                                                                </li>

                                                                <li>
                                                                    <button
                                                                        class="dropdown-item text-danger"
                                                                        @click="
                                                                            onDeleteActivity(
                                                                                item,
                                                                                'inquiry',
                                                                                props
                                                                                    .row
                                                                                    .company
                                                                            )
                                                                        "
                                                                    >
                                                                        <i
                                                                            class="mdi mdi-delete-outline me-2"
                                                                        ></i>
                                                                        Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="activity-body mt-2">
                                                    <div
                                                        class="small text-muted"
                                                    >
                                                        Supplier inquiry
                                                        activity for
                                                        {{ item.fair_code }}
                                                    </div>

                                                    <div
                                                        class="metric-line mt-2"
                                                    >
                                                        <span
                                                            class="metric-primary"
                                                        >
                                                            <strong>
                                                                {{
                                                                    item.no_of_inquiries
                                                                }}
                                                            </strong>
                                                            inquiries
                                                        </span>

                                                        <span
                                                            class="mx-2 text-muted"
                                                        >
                                                            •
                                                        </span>

                                                        <span
                                                            class="metric-primary"
                                                        >
                                                            <strong>
                                                                {{
                                                                    item.no_of_buyers_met
                                                                }}
                                                            </strong>
                                                            buyers met
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-else class="empty-state">—</div>
                                    </div>

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
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

import { VueGoodTable } from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";

Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    components: {
        VueGoodTable,
    },

    data() {
        return {
            rows: [],
            isLoading: false,
            totalRecords: 0,
            events: [],
            selectedFairCode: "",
            serverParams: {
                columnFilters: {
                    company: "",
                    date_of_sale: "",
                    activity_type: "",
                    fair_code: "",
                },

                sort: {
                    field: "date_sort",
                    type: "desc",
                },

                page: 1,
                perPage: 10,
            },

            columns: [
                {
                    label: "Company",
                    field: "company",
                    width: "220px",
                    sortable: true,
                },

                {
                    label: "Export Sales",
                    field: "export",
                    width: "420px",
                    sortable: false,
                },

                {
                    label: "Domestic Sales",
                    field: "domestic",
                    width: "420px",
                    sortable: false,
                },

                {
                    label: "Retail Sales",
                    field: "retail",
                    width: "320px",
                    sortable: false,
                },

                {
                    label: "Sales Inquiries",
                    field: "inquiries",
                    width: "320px",
                    sortable: false,
                },
            ],
        };
    },

    computed: {
        groupedRows() {
            return this.rows;
        },
    },

    created() {
        this.getLists();
        this.getEvents();
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
                .post(
                    "/api/admin/daily-sales-report/sales-activity/list",
                    formData
                )
                .then((res) => {
                    this.rows = res.data.data;

                    this.totalRecords = res.data.total;
                })
                .finally(() => {
                    this.isLoading = false;
                });
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

        onColumnFilter() {
            this.serverParams.page = 1;
            this.serverParams.columnFilters.fair_code = this.selectedFairCode;

            this.getLists();
        },

        onResetFilter() {
            const defaultFairCode =
                this.events.length > 0 ? this.events[0].fair_code : "";

            this.selectedFairCode = defaultFairCode;

            this.serverParams.columnFilters = {
                company: "",
                date_of_sale: "",
                activity_type: "",
                fair_code: defaultFairCode,
            };

            this.serverParams.page = 1;

            this.getLists();
        },
        getEvents() {
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
        onEditActivity(ff_code, company, fair_code) {
            window.location.href = `/admin/daily-sales-report/sales-management/${ff_code}?fair_code=${fair_code}`;
        },
        goToSalesManagement() {
            window.location.href = "/admin/daily-sales-report/sales-management";
        },
        onDeleteActivity(item, type, company) {
            let title = "";
            let details = "";

            switch (type) {
                case "export":
                    title = "Delete Export Sale";

                    details = `
                <div class="text-start">
                      <div><strong>Company:</strong> ${company}</div>
                    <div><strong>Product:</strong> ${item.product_service}</div>
                    <div><strong>Buyer:</strong> ${item.buyer_company}</div>
                    <div><strong>Country:</strong> ${item.country}</div>
                    <div><strong>Date:</strong> ${item.date_of_sale}</div>
                    <div><strong>Booked:</strong> $${item.booked}</div>
                      <div><strong>Under Negotiation:</strong> $${item.under_negotiation}</div>
                </div>
            `;

                    break;

                case "domestic":
                    title = "Delete Domestic Sale";

                    details = `
                <div class="text-start">
                    <div><strong>Company:</strong> ${company}</div>
                    <div><strong>Product:</strong> ${item.product_service}</div>
                    <div><strong>Buyer:</strong> ${item.buyer_company}</div>
                    <div><strong>Buyer Type:</strong> ${item.type_of_buyer}</div>
                    <div><strong>Date:</strong> ${item.date_of_sale}</div>
                    <div><strong>Booked:</strong> ₱${item.booked}</div>
                    <div><strong>Under Negotiation:</strong> $${item.under_negotiation}</div>
                </div>
            `;

                    break;

                case "retail":
                    title = "Delete Retail Sale";

                    details = `
                <div class="text-start">
                    <div><strong>Company:</strong> ${company}</div>
                    <div><strong>Product:</strong> ${item.product_service}</div>
                    <div><strong>Buyer Type:</strong> ${item.type_of_buyer}</div>
                    <div><strong>Date:</strong> ${item.date_of_sale}</div>
                    <div><strong>Retail Sales:</strong> ₱${item.booked}</div>
                </div>
            `;

                    break;

                case "inquiry":
                    title = "Delete Inquiry";

                    details = `
                <div class="text-start">
                     <div><strong>Company:</strong> ${company}</div>
                    <div><strong>Date:</strong> ${item.date_of_sale}</div>
                    <div><strong>Inquiries:</strong> ${item.no_of_inquiries}</div>
                    <div><strong>Buyers Met:</strong> ${item.no_of_buyers_met}</div>
                </div>
            `;

                    break;
            }

            this.$swal({
                title,
                html: `
            <div class="mb-3 text-danger fw-semibold">
                This activity will be permanently deleted.
            </div>

            ${details}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "Cancel",
                width: 600,
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                axios
                    .delete(
                        `/admin/daily-sales-report/sales-activity/${type}/${item.id}`
                    )
                    .then(() => {
                        this.$toast.open({
                            message: "Sales Activity deleted successfully.",
                            type: "success",
                        });

                        this.getLists();
                    })
                    .catch(() => {
                        this.$toast.open({
                            message: "Failed to delete sales activity.",
                            type: "error",
                        });
                    });
            });
        },
        async exportExcel() {
            try {
                const response = await axios.post(
                    "/admin/daily-sales-report/sales-activity/export",
                    {
                        filter: this.serverParams.columnFilters,
                        sort: this.serverParams.sort,
                    },
                    {
                        responseType: "blob",
                    }
                );

                const url = window.URL.createObjectURL(
                    new Blob([response.data])
                );

                const link = document.createElement("a");

                link.href = url;

                link.setAttribute("download", "general-summary.xlsx");

                document.body.appendChild(link);

                link.click();

                link.remove();
            } catch (error) {
                console.error(error);

                this.$toast.open({
                    message: "Export failed.",
                    type: "error",
                });
            }
        },
    },
};
</script>

<style scoped>
.activity-wrapper {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.activity-wrapper table {
    min-width: 1600px;
}

table.vgt-table {
    font-size: 14px !important;
    border-collapse: separate;
    border-spacing: 0;
}

.vgt-table th {
    background: #f8fafc !important;
    font-weight: 700;
    color: #111827;
    border-bottom: 1px solid #e5e7eb !important;
    padding: 14px !important;
    vertical-align: top;
}

.vgt-table td {
    padding: 16px !important;
    vertical-align: top !important;
}

/* {
    font-size: 14px;
    line-height: 1.5;
} */

.activity-card {
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
    border: 1px solid #e5e7eb;
    background: #fff;
    transition: all 0.2s ease;
}

.activity-card:last-child {
    margin-bottom: 0;
}

.activity-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
}

.export-card {
    border-left: 4px solid #198754;
}

.domestic-card {
    border-left: 4px solid #0d6efd;
}

.retail-card {
    border-left: 4px solid #fd7e14;
}

.inquiry-card {
    border-left: 4px solid #6f42c1;
}

.activity-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 6px 10px;
    border-radius: 30px;
}

.export-badge {
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.domestic-badge {
    background: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.retail-badge {
    background: rgba(253, 126, 20, 0.1);
    color: #fd7e14;
}

.inquiry-badge {
    background: rgba(111, 66, 193, 0.1);
    color: #6f42c1;
}

.metric-line {
    font-size: 13px;
    line-height: 1.6;
}

.metric-success {
    color: #198754;
}

.metric-warning {
    color: #fd7e14;
}

.metric-primary {
    color: #0d6efd;
}

.empty-state {
    color: #adb5bd;
    text-align: center;
    padding: 20px 0;
    font-size: 13px;
}

.vgt-table.striped tbody tr:hover {
    background: #fafafa;
}

@media (max-width: 991px) {
    .activity-wrapper table {
        min-width: 1400px;
    }
}
</style>

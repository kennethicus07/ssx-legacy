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
                            <div class="col-md-4">
                                <label class="form-label">Event Name</label>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.event_name
                                    "
                                />
                            </div>

                            <div class="col-md-4">
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

                            <div class="col mt-3 text-end">
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
                        <h5 class="card-title">Event Payments</h5>

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
                                    <!-- EVENT NAME -->
                                    <span
                                        v-if="
                                            props.column.field === 'event_name'
                                        "
                                    >
                                        {{ props.row.event_name }}
                                    </span>

                                    <!-- PAYMENT STATUS -->
                                    <!-- PAYMENT STATUS -->
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
                                    <!-- DATE -->
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
                                                        :href="
                                                            getEventPaymentUrl(
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
    props: ["params"],

    components: {
        VueGoodTable,
    },

    data() {
        return {
            columns: [
                {
                    label: "Event Name",
                    field: "event_name",
                },
                {
                    label: "Payment Status",
                    field: "payment_status",
                },
                {
                    label: "Date",
                    field: "created_at",
                },
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

            serverParams: {
                columnFilters: {
                    event_name: "",
                    payment_status: "",
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
        this.getLists();
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
            formData.append("supplier_id", this.params.supplier_id);

            axios
                .post("/api/supplier/payment/event-list", formData)
                .then((res) => {
                    this.rows = res.data.data;
                    this.totalRecords = res.data.total;
                })
                .finally(() => {
                    this.isLoading = false;
                });
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

        getEventPaymentUrl(row) {
            return row.event_slug
                ? `/supplier/payments/event/${row.event_slug}`
                : "#";
        },
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },

        onPageChange(params) {
            this.updateParams({ page: params.currentPage });
            this.getLists();
        },

        onPerPageChange(params) {
            this.updateParams({
                page: 1,
                perPage: params.currentPerPage,
            });
            this.getLists();
        },

        onSortChange(params) {
            this.updateParams({ sort: params[0] });
            this.getLists();
        },

        onColumnFilter() {
            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                event_name: "",
                payment_status: "",
            };
            this.getLists();
        },
    },
};
</script>

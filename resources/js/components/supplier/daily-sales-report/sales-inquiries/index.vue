<template>
    <div>
        <div class="row">
            <!-- FILTERS -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <!-- DATE -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label"> Date of Sale </label>

                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.date_of_sale
                                    "
                                />
                            </div>

                            <!-- BUTTONS -->
                            <div class="col-12 text-end">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-success text-white me-1"
                                    @click="onColumnFilter"
                                >
                                    Search
                                </button>

                                <button
                                    type="button"
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
                        <!-- HEADER -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-3"
                        >
                            <div>
                                <h5 class="card-title mb-1">
                                    List of Sales Inquiries
                                </h5>

                                <p class="text-muted small mb-0">
                                    Monitor supplier inquiries and buyers met
                                </p>
                            </div>
                            <button
                                type="button"
                                class="btn btn-sm btn-primary"
                                @click="goToCreateInquiries"
                            >
                                <i class="fas fa-plus me-1"></i>
                                Add Inquiry
                            </button>
                        </div>

                        <!-- TABLE -->
                        <div class="table-slider">
                            <vue-good-table
                                mode="remote"
                                :columns="columns"
                                :rows="rows"
                                :totalRows="totalRecords"
                                :isLoading.sync="isLoading"
                                :pagination-options="{
                                    enabled: true,
                                    perPageDropdown: [10, 20, 50, 100],
                                }"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                styleClass="vgt-table striped"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <!-- DATE -->
                                    <span
                                        v-if="
                                            props.column.field ===
                                            'date_of_sale'
                                        "
                                    >
                                        {{
                                            props.row.date_of_sale
                                                | moment("MMMM DD, YYYY")
                                        }}
                                    </span>

                                    <!-- INQUIRIES -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'no_of_inquiries'
                                        "
                                    >
                                        {{ props.row.no_of_inquiries || 0 }}
                                    </span>

                                    <!-- BUYERS -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'no_of_buyers_met'
                                        "
                                    >
                                        {{ props.row.no_of_buyers_met || 0 }}
                                    </span>
                                    <div
                                        v-else-if="
                                            props.column.field === 'actions'
                                        "
                                        class="dropdown d-flex justify-content-end"
                                    >
                                        <button
                                            class="btn btn-sm border-0 shadow-none p-0"
                                            type="button"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i
                                                class="mdi mdi-dots-vertical fs-5"
                                            ></i>
                                        </button>

                                        <ul
                                            class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                    @click.prevent="
                                                        editInquiry(props.row)
                                                    "
                                                >
                                                    <span
                                                        class="mdi mdi-eye"
                                                    ></span>
                                                    View
                                                </a>
                                            </li>

                                            <li>
                                                <a
                                                    class="dropdown-item text-danger"
                                                    href="#"
                                                    @click.prevent="
                                                        deleteInquiry(props.row)
                                                    "
                                                >
                                                    <span
                                                        class="mdi mdi-delete"
                                                    ></span>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
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
    props: ["params"],

    components: {
        VueGoodTable,
    },

    data() {
        return {
            rows: [],
            isLoading: false,
            totalRecords: 0,

            serverParams: {
                columnFilters: {
                    fair_code: "",
                    date_of_sale: "",
                },

                sort: {
                    field: "created_at",
                    type: "desc",
                },

                page: 1,
                perPage: 10,
            },

            columns: [
                {
                    label: "Date of Sale",
                    field: "date_of_sale",
                },
                {
                    label: "No. of Inquiries",
                    field: "no_of_inquiries",
                },

                {
                    label: "No. of Buyers Met",
                    field: "no_of_buyers_met",
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false,
                    thClass: "text-end",
                    tdClass: "text-end",
                },
            ],
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
                .post(
                    "/api/supplier/daily-sales-report/inquiries/list",
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
        editInquiry(row) {
            window.location.href = `/supplier/daily-sales-report/inquiries/${row.id}/edit`;
        },

        deleteInquiry(row) {
            this.$swal({
                title: "Delete Inquiry?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (!result.isConfirmed) return;

                axios
                    .delete(`/supplier/daily-sales-report/inquiries/${row.id}`)
                    .then(() => {
                        this.getLists();

                        this.$swal({
                            title: "Deleted!",
                            text: "Inquiry has been deleted.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    })
                    .catch(() => {
                        this.$swal({
                            title: "Error!",
                            text: "Failed to delete inquiry.",
                            icon: "error",
                        });
                    });
            });
        },
        goToCreateInquiries() {
            window.location.href =
                "/supplier/daily-sales-report/inquiries/create";
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
            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                fair_code: "",
                date_of_sale: "",
            };

            this.serverParams.page = 1;

            this.getLists();
        },
    },
};
</script>

<style>
.table-slider {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-slider table {
    min-width: 900px;
}

table.vgt-table {
    font-size: 14px !important;
}

.vgt-table.bordered td,
.vgt-table.bordered th {
    vertical-align: middle;
}
</style>

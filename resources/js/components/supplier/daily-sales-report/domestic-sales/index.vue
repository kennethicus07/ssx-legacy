<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <!-- Product / Service Dropdown -->
                            <div
                                class="col-12 col-md-6 col-lg-3 position-relative"
                            >
                                <label class="form-label"
                                    >Product / Service</label
                                >

                                <div
                                    class="form-control form-control-sm d-flex justify-content-between align-items-center"
                                    @click="
                                        toggleSubCatDropdown =
                                            !toggleSubCatDropdown
                                    "
                                    style="cursor: pointer"
                                >
                                    <span class="text-truncate">
                                        {{
                                            selectedSubCategoryName ||
                                            "-- Select Product / Service --"
                                        }}
                                    </span>

                                    <i class="fas fa-chevron-down ms-2"></i>
                                </div>

                                <!-- Dropdown -->
                                <div
                                    v-if="toggleSubCatDropdown"
                                    class="border bg-white position-absolute w-100 mt-1 p-2 shadow subcat-dropdown"
                                >
                                    <div
                                        v-for="category in categories"
                                        :key="category.id"
                                        class="mb-2"
                                    >
                                        <div class="fw-bold small text-muted">
                                            {{ category.name }}
                                        </div>

                                        <div
                                            v-for="subcategory in category.sub_categories"
                                            :key="subcategory.id"
                                            class="ps-2 py-1"
                                        >
                                            <a
                                                href="#"
                                                class="text-dark text-decoration-none d-block small"
                                                @click.prevent="
                                                    selectSubCategory(
                                                        subcategory
                                                    )
                                                "
                                            >
                                                {{ subcategory.name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buyer -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label"
                                    >Buyer / Company</label
                                >

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.co_buyer_name
                                    "
                                />
                            </div>

                            <!-- Type of Purchaser / Buyer -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label">
                                    Type of Purchaser / Buyer
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .type_of_purchaser_buyer
                                    "
                                />
                            </div>

                            <!-- Date -->
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="form-label">Date of Sale</label>

                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.date_of_sale
                                    "
                                />
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 text-end mt-2">
                                <button
                                    type="button"
                                    @click="onColumnFilter"
                                    class="btn btn-sm btn-success text-white me-1"
                                >
                                    Search
                                </button>

                                <button
                                    type="button"
                                    @click="onResetFilter"
                                    class="btn btn-sm btn-secondary"
                                >
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <!-- TABLE -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- HEADER -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-3"
                        >
                            <h5 class="card-title mb-0">
                                List of Domestic Sales
                            </h5>

                            <button
                                type="button"
                                class="btn btn-sm btn-warning"
                                @click="goToCreateDomesticSale"
                            >
                                <i class="fas fa-plus me-1"></i>
                                Add Domestic Sale
                            </button>
                        </div>

                        <!-- SLIDER WRAPPER -->
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
                                    <span
                                        v-if="
                                            props.column.field ===
                                            'product_service_name'
                                        "
                                    >
                                        {{ props.row.product_service_name }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'co_buyer_name'
                                        "
                                    >
                                        {{ props.row.co_buyer_name }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'type_of_purchaser_buyer'
                                        "
                                    >
                                        {{
                                            props.row.type_of_purchaser_buyer ||
                                            "-"
                                        }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field === 'booked'
                                        "
                                    >
                                        ₱
                                        {{
                                            useCurrencyFormat(props.row.booked)
                                        }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'under_negotiation'
                                        "
                                    >
                                        ₱
                                        {{
                                            useCurrencyFormat(
                                                props.row.under_negotiation
                                            )
                                        }}
                                    </span>

                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'date_of_sale'
                                        "
                                    >
                                        {{
                                            props.row.date_of_sale
                                                | moment("MMMM DD, YYYY")
                                        }}
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
                                                        editSale(props.row)
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
                                                        deleteSale(props.row)
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
import { useCurrencyFormat } from "../../../../composables/useCurrencyFormat";

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
            categories: [],
            countries: [],
            events: [],
            isLoading: false,
            totalRecords: 0,
            toggleSubCatDropdown: false,
            selectedSubCategoryName: "",

            serverParams: {
                columnFilters: {
                    co_buyer_name: "",
                    type_of_purchaser_buyer: "",
                    date_of_sale: "",
                    fair_code: "",
                    sub_category_ids: [],
                },
                sort: {
                    field: "created_at",
                    type: "desc",
                },
                page: 1,
                perPage: 10,
            },

            columns: [
                { label: "Product / Service", field: "product_service_name" },
                { label: "Buyer / Company", field: "co_buyer_name" },
                {
                    label: "Type of Buyer",
                    field: "type_of_purchaser_buyer",
                },
                { label: "Domestic Booked(₱)", field: "booked" },
                {
                    label: "Domestic Under Negotiation(₱)",
                    field: "under_negotiation",
                },
                { label: "Date of Sale", field: "date_of_sale" },

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
        this.getCountries();
        this.getCategories();
        this.getEvents();
    },

    methods: {
        useCurrencyFormat,
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
                    "/api/supplier/daily-sales-report/domestic-sales/list",
                    formData
                )
                .then((res) => {
                    this.rows = res.data.data;
                    this.totalRecords = res.data.total;
                    this.isLoading = false;
                });
            console.log(this.rows);
        },
        getEvents() {
            axios.get("/api/supplier/events").then((res) => {
                this.events = res.data;
            });
        },
        selectSubCategory(subcategory) {
            this.serverParams.columnFilters.sub_category_ids = [subcategory.id];

            this.selectedSubCategoryName = subcategory.name;

            this.toggleSubCatDropdown = false;
        },
        editSale(row) {
            window.location.href = `/supplier/daily-sales-report/domestic-sales/${row.id}/edit`;
        },

        deleteSale(row) {
            this.$swal({
                title: "Delete Domestic Sale?",
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
                    .delete(
                        `/supplier/daily-sales-report/domestic-sales/${row.id}`
                    )
                    .then(() => {
                        this.getLists();

                        this.$swal({
                            title: "Deleted!",
                            text: "Domestic sale has been deleted.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                    })
                    .catch(() => {
                        this.$swal({
                            title: "Error!",
                            text: "Failed to delete domestic sale.",
                            icon: "error",
                        });
                    });
            });
        },

        handleClickOutside(event) {
            let el = this.$el.querySelector(".position-relative");

            if (el && !el.contains(event.target)) {
                this.toggleSubCatDropdown = false;
            }
        },
        goToCreateDomesticSale() {
            window.location.href =
                "/supplier/daily-sales-report/domestic-sales/create";
        },

        getCountries() {
            axios.get("/api/countries").then((res) => {
                this.countries = res.data;
            });
        },

        getCategories() {
            axios.get("/api/categories").then((res) => {
                this.categories = res.data;
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
            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                co_buyer_name: "",
                type_of_purchaser_buyer: "",
                fair_code: "",
                date_of_sale: "",
                sub_category_ids: [],
            };

            this.getLists();
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
</style>

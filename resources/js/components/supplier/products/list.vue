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
                            <div class="col-md-4">
                                <label for="title" class="form-label"
                                    >Product/Service Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    id="title"
                                    v-model="
                                        serverParams.columnFilters.product_name
                                    "
                                />
                            </div>

                            <div class="col-md-4">
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
                        <h5 class="card-title">List of products/services</h5>
                        <div class="text-end pb-3">
                            <!-- <a
                                href="/admin/registration/suppliers/create"
                                class="btn btn-warning btn-sm text-white"
                                role="button"
                                >Add new supplier</a
                            > -->
                            <a
                                href="/supplier/products/add"
                                class="btn btn-warning btn-sm text-white"
                                role="button"
                                >Add new product/service</a
                            >
                        </div>
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
                                    <span
                                        v-if="
                                            props.column.field ===
                                            'product_name'
                                        "
                                    >
                                        <span
                                            v-tooltip="props.row.product_name"
                                        >
                                            {{
                                                props.row.product_name
                                                    | str_limit(40)
                                            }}
                                        </span>
                                    </span>

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
                                                        :href="`/supplier/products/${props.row.id}/view`"
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
import "vue-good-table/dist/vue-good-table.css";
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
    props: ["params"],
    data() {
        return {
            columns: [
                {
                    label: "Product/Service Name",
                    field: "product_name",
                    tdClass: "align-middle",
                },
                {
                    label: "Status",
                    field: "status",
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

            isLoading: false,
            totalRecords: 0,
            serverParams: {
                columnFilters: {
                    product_name: "",

                    status: "",
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
            formData.append("supplier_id", this.params.supplier_id);
            axios
                .post("/api/supplier/product/list", formData)
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.rows = response.data.data;

                        this.totalRecords = response.data.total;
                        this.isLoading = false;
                        this.scrollToTop();
                    }
                })
                .catch((error) => {
                    console.log(error);
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
        onResetFilter() {
            this.serverParams.columnFilters = {
                product_name: "",

                status: "",
            };
            this.getLists();
        },

        scrollToTop() {
            window.scroll({ top: 300, behavior: "smooth" });
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

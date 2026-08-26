<template>
    <div>
        <!-- Assignment Information -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-center"
                        >
                            <div>
                                <h5 class="card-title mb-1">
                                    {{ assignment.name }}
                                </h5>

                                <div class="text-muted">
                                    Event:
                                    <strong>
                                        {{ assignment.fair_code }}
                                    </strong>
                                </div>
                            </div>

                            <div>
                                <a
                                    href="/admin/booth-system"
                                    class="btn btn-sm btn-secondary me-1"
                                >
                                    <i class="fas fa-arrow-left"></i>
                                    Back
                                </a>

                                <!-- <button
                                    type="button"
                                    class="btn btn-sm btn-warning text-white"
                                    @click="openCreateGroup"
                                >
                                    Add Group
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Name -->
                            <div class="col-md-3">
                                <label class="form-label"> Name </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="serverParams.columnFilters.name"
                                    @keyup.enter="onColumnFilter"
                                />
                            </div>

                            <!-- Classification -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Classification
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .classification
                                    "
                                    @keyup.enter="onColumnFilter"
                                />
                            </div>

                            <!-- Booth Name -->
                            <div class="col-md-3">
                                <label class="form-label"> Booth Name </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.booth_name
                                    "
                                    @keyup.enter="onColumnFilter"
                                />
                            </div>

                            <!-- Booth Type -->
                            <div class="col-md-3">
                                <label class="form-label"> Booth Type </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.booth_type
                                    "
                                    @keyup.enter="onColumnFilter"
                                />
                            </div>
                        </div>

                        <div class="row mt-3">
                            <!-- Hall -->
                            <div class="col-md-3">
                                <label class="form-label"> Hall </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="
                                        serverParams.columnFilters.hall_name
                                    "
                                    @keyup.enter="onColumnFilter"
                                />
                            </div>

                            <div class="col-md-9 text-end align-self-end">
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
        </div>

        <!-- Groups List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="card-title mb-0">
                                Booth Assignment Groups
                            </h5>

                            <button
                                type="button"
                                class="btn btn-warning btn-sm text-white"
                                @click="openCreateGroup"
                            >
                                Add Group
                            </button>
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
                                    <span class="fw-bold">
                                        No group found.
                                    </span>
                                </div>

                                <template slot="table-row" slot-scope="props">
                                    <!-- Name -->
                                    <span v-if="props.column.field === 'name'">
                                        <span v-tooltip="props.row.name">
                                            {{ props.row.name | str_limit(40) }}
                                        </span>
                                    </span>

                                    <!-- Classification -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'classification'
                                        "
                                        class="text-uppercase"
                                    >
                                        <span
                                            v-tooltip="props.row.classification"
                                        >
                                            {{
                                                props.row.classification
                                                    | str_limit(40)
                                            }}
                                        </span>
                                    </span>

                                    <!-- Booth Name -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'booth_name'
                                        "
                                        class="text-uppercase"
                                    >
                                        <span v-tooltip="props.row.booth_name">
                                            {{
                                                props.row.booth_name
                                                    | str_limit(40)
                                            }}
                                        </span>
                                    </span>

                                    <!-- Booth Name Length -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'booth_name_length'
                                        "
                                    >
                                        {{ props.row.booth_name_length || "—" }}
                                    </span>

                                    <!-- Booth Type -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'booth_type'
                                        "
                                    >
                                        {{ props.row.booth_type || "—" }}
                                    </span>

                                    <!-- Hall -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'hall_name'
                                        "
                                    >
                                        {{ props.row.hall_name || "—" }}
                                    </span>

                                    <!-- Booth -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'booth'
                                        "
                                    >
                                        {{ props.row.booth || "—" }}
                                    </span>

                                    <!-- Assigned By -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'assigned_by'
                                        "
                                    >
                                        {{ props.row.assigned_by?.name || "—" }}
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
                                                <!-- Edit -->
                                                <!--
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            openEditGroup(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-edit"
                                                        ></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                -->

                                                <!-- Delete -->
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            deleteGroup(
                                                                props.row.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-trash"
                                                        ></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </span>

                                    <!-- Default -->
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

        <!-- Group Form -->
        <booth-system-assignment-group-form
            :show="groupModal.show"
            :assignment="assignment"
            :group="groupModal.group"
            @close="closeGroupModal"
            @saved="onGroupSaved"
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

import BoothSystemAssignmentGroupForm from "./form.vue";

Vue.use(VTooltipPlugin);
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    name: "BoothSystemAssignmentGroups",

    components: {
        VueGoodTable,
        BoothSystemAssignmentGroupForm,
    },

    props: {
        assignment: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            groupModal: {
                show: false,
                group: null,
            },

            columns: [
                /*
                |--------------------------------------------------------------------------
                | Name
                |--------------------------------------------------------------------------
                */

                {
                    label: "Name",
                    field: "name",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Classification
                |--------------------------------------------------------------------------
                */

                {
                    label: "Classification",
                    field: "classification",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Booth Name
                |--------------------------------------------------------------------------
                */

                {
                    label: "Booth Name",
                    field: "booth_name",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Booth Name Length
                |--------------------------------------------------------------------------
                */

                {
                    label: "Name Length",
                    field: "booth_name_length",
                    sortable: false,
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Booth Type
                |--------------------------------------------------------------------------
                */

                {
                    label: "Booth Type",
                    field: "booth_type",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Hall
                |--------------------------------------------------------------------------
                */

                {
                    label: "Hall",
                    field: "hall_name",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Booth
                |--------------------------------------------------------------------------
                */

                {
                    label: "Booth",
                    field: "booth",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Assigned By
                |--------------------------------------------------------------------------
                */

                {
                    label: "Assigned By",
                    field: "assigned_by",
                    sortable: false,
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Date Created
                |--------------------------------------------------------------------------
                */

                {
                    label: "Date Created",
                    field: "created_at",
                    tdClass: "align-middle",
                },

                /*
                |--------------------------------------------------------------------------
                | Actions
                |--------------------------------------------------------------------------
                */

                {
                    label: "",
                    field: "actions",
                    sortable: false,
                    tdClass: "align-middle",
                },
            ],

            rows: [],

            permissions: [],

            isLoading: false,

            totalRecords: 0,

            serverParams: {
                columnFilters: {
                    name: "",
                    classification: "",
                    booth_name: "",
                    booth_type: "",
                    hall_name: "",
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

    filters: {
        str_limit(value, size) {
            if (!value) {
                return "";
            }

            value = value.toString();

            if (value.length <= size) {
                return value;
            }

            return value.substr(0, size) + "...";
        },
    },

    mounted() {
        this.getLists();
    },

    methods: {
        /*
        |--------------------------------------------------------------------------
        | Get Lists
        |--------------------------------------------------------------------------
        */

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
                .post(
                    `/admin/booth-system/assignments/${this.assignment.id}/groups/list`,
                    formData
                )
                .then((response) => {
                    if (response.status === 200) {
                        this.rows = response.data.data;

                        this.permissions = response.data.permissions;

                        this.totalRecords = response.data.total;
                    }
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    this.isLoading = false;

                    this.scrollToTop();
                });
        },

        /*
        |--------------------------------------------------------------------------
        | Update Params
        |--------------------------------------------------------------------------
        */

        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        onPageChange(params) {
            this.updateParams({
                page: params.currentPage,
            });

            this.getLists();
        },

        onPerPageChange(params) {
            this.updateParams({
                page: 1,
                perPage: params.currentPerPage,
            });

            this.getLists();
        },

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        onSortChange(params) {
            this.updateParams({
                sort: params[0],
            });

            this.getLists();
        },

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        onColumnFilter() {
            this.updateParams({
                page: 1,
            });

            this.getLists();
        },

        onResetFilter() {
            this.serverParams.columnFilters = {
                name: "",
                classification: "",
                booth_name: "",
                booth_type: "",
                hall_name: "",
            };

            this.updateParams({
                page: 1,
            });

            this.getLists();
        },

        /*
        |--------------------------------------------------------------------------
        | Group Modal
        |--------------------------------------------------------------------------
        */

        openCreateGroup() {
            this.groupModal.group = null;

            this.groupModal.show = true;
        },

        openEditGroup(group) {
            this.groupModal.group = {
                ...group,
            };

            this.groupModal.show = true;
        },

        closeGroupModal() {
            this.groupModal.show = false;

            this.groupModal.group = null;
        },

        onGroupSaved() {
            this.closeGroupModal();

            this.getLists();
        },

        /*
        |--------------------------------------------------------------------------
        | Delete
        |--------------------------------------------------------------------------
        */

        deleteGroup(id) {
            this.$swal({
                title: "Are you sure you want to delete this group?",

                text: "This action cannot be undone.",

                icon: "warning",

                showCancelButton: true,

                customClass: {
                    title: "fs-5",

                    confirmButton: "btn btn-sm btn-danger text-white m-1",

                    cancelButton: "btn btn-sm btn-secondary m-1",
                },

                buttonsStyling: false,

                preConfirm: (value) => {
                    if (!value) {
                        return;
                    }

                    this.isLoading = true;

                    return axios.delete(
                        `/admin/booth-system/assignments/${this.assignment.id}/groups/${id}`
                    );
                },
            })
                .then((result) => {
                    if (
                        result.isConfirmed &&
                        result.value &&
                        result.value.data.success
                    ) {
                        Vue.$toast.success(
                            "Assignment group successfully deleted.",
                            {
                                position: "top-right",
                            }
                        );

                        this.getLists();
                    }
                })
                .catch((error) => {
                    const message =
                        error.response?.data?.message ||
                        "Failed to delete group.";

                    Vue.$toast.error(message, {
                        position: "top-right",
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        /*
        |--------------------------------------------------------------------------
        | Scroll
        |--------------------------------------------------------------------------
        */

        scrollToTop() {
            window.scroll({
                top: 300,
                behavior: "smooth",
            });
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

<template>
    <div>
        <!-- Filters -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filters</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Assignment Name -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    Assignment Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    v-model="serverParams.columnFilters.name"
                                    @keyup.enter="onColumnFilter"
                                />
                            </div>

                            <!-- Event -->
                            <div class="col-md-4">
                                <label for="fair_code" class="form-label">
                                    Event (Fair Code)
                                </label>

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

                            <!-- Buttons -->
                            <div class="col-md-4 mt-3 text-end">
                                <a
                                    role="button"
                                    @click="onColumnFilter"
                                    class="btn btn-sm btn-success text-white"
                                >
                                    Search
                                </a>

                                <a
                                    role="button"
                                    @click="onResetFilter"
                                    class="btn btn-sm btn-secondary"
                                >
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="card-title mb-0">
                                Booth System Assignments
                            </h5>

                            <button
                                type="button"
                                class="btn btn-warning btn-sm text-white"
                                @click="openCreateAssignment"
                            >
                                Add Assignment
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
                                        No record found.
                                    </span>
                                </div>

                                <template slot="table-row" slot-scope="props">
                                    <!-- Assignment Name -->
                                    <span
                                        v-if="props.column.field === 'name'"
                                        class="text-uppercase"
                                    >
                                        <span v-tooltip="props.row.name">
                                            {{ props.row.name | str_limit(50) }}
                                        </span>
                                    </span>

                                    <!-- Fair Code -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'fair_code'
                                        "
                                    >
                                        {{ props.row.fair_code || "—" }}
                                    </span>

                                    <!-- Groups -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'group_count'
                                        "
                                    >
                                        <span class="badge bg-info">
                                            {{ props.row.group_count }}
                                        </span>
                                    </span>

                                    <!-- Created By -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'creator'
                                        "
                                    >
                                        {{ props.row.creator?.name || "—" }}
                                    </span>

                                    <!-- Updated By -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'updater'
                                        "
                                    >
                                        {{ props.row.updater?.name || "—" }}
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
                                                <!-- View -->
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        :href="
                                                            '/admin/booth-system/assignments/' +
                                                            props.row.id +
                                                            '/groups'
                                                        "
                                                    >
                                                        <i
                                                            class="fas fa-eye"
                                                        ></i>
                                                        View details
                                                    </a>
                                                </li>

                                                <!-- Edit -->
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            openEditAssignment(
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

                                                <!-- Delete -->
                                                <li>
                                                    <a
                                                        class="dropdown-item"
                                                        role="button"
                                                        @click="
                                                            deleteAssignment(
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
        <booth-system-assignment-form
            :show="assignmentModal.show"
            :events="events"
            :assignment="assignmentModal.assignment"
            @close="closeAssignmentModal"
            @saved="onAssignmentSaved"
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

import BoothSystemAssignmentForm from "./Form.vue";

Vue.use(VTooltipPlugin);
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    components: {
        VueGoodTable,
        BoothSystemAssignmentForm,
    },

    data() {
        return {
            assignmentModal: {
                show: false,
                assignment: null,
            },
            columns: [
                {
                    label: "Assignment",
                    field: "name",
                    tdClass: "align-middle",
                },
                {
                    label: "Fair Code",
                    field: "fair_code",
                    tdClass: "align-middle",
                },
                {
                    label: "Groups",
                    field: "group_count",
                    sortable: false,
                    tdClass: "align-middle",
                },
                {
                    label: "Created By",
                    field: "creator",
                    sortable: false,
                    tdClass: "align-middle",
                },
                {
                    label: "Updated By",
                    field: "updater",
                    sortable: false,
                    tdClass: "align-middle",
                },
                {
                    label: "Date Created",
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
                    name: "",
                    fair_code: "",
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

    methods: {
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
                .post("/admin/booth-system/list", formData)
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

        fetchEvents() {
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

        onSortChange(params) {
            this.updateParams({
                sort: params[0],
            });

            this.getLists();
        },

        onColumnFilter() {
            this.updateParams({
                page: 1,
            });

            this.getLists();
        },

        onResetFilter() {
            const defaultFairCode =
                this.events.length > 0 ? this.events[0].fair_code : "";

            this.serverParams.columnFilters = {
                name: "",
                fair_code: defaultFairCode,
            };

            this.selectedFairCode = defaultFairCode;

            this.updateParams({
                page: 1,
            });

            this.getLists();
        },

        deleteAssignment(id) {
            this.$swal({
                title: "Are you sure you want to delete this assignment?",
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
                        "/admin/booth-system/assignments/" + id
                    );
                },
            })
                .then((result) => {
                    if (
                        result.isConfirmed &&
                        result.value &&
                        result.value.data.success
                    ) {
                        Vue.$toast.success("Assignment successfully deleted.", {
                            position: "top-right",
                        });

                        this.getLists();
                    }
                })
                .catch((error) => {
                    const message =
                        error.response?.data?.message ||
                        "Failed to delete assignment.";

                    Vue.$toast.error(message, {
                        position: "top-right",
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        scrollToTop() {
            window.scroll({
                top: 300,
                behavior: "smooth",
            });
        },
        openCreateAssignment() {
            this.assignmentModal.assignment = null;
            this.assignmentModal.show = true;
        },

        openEditAssignment(assignment) {
            this.assignmentModal.assignment = {
                ...assignment,
            };

            this.assignmentModal.show = true;
        },

        closeAssignmentModal() {
            this.assignmentModal.show = false;
            this.assignmentModal.assignment = null;
        },

        onAssignmentSaved() {
            this.closeAssignmentModal();

            this.getLists();
        },
    },

    watch: {
        selectedFairCode(newVal) {
            this.serverParams.columnFilters.fair_code = newVal;

            this.updateParams({
                page: 1,
            });

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

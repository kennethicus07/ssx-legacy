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
                            <div class="col-md-3">
                                <label for="title" class="form-label"
                                    >Company Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    id="title"
                                    v-model="serverParams.columnFilters.co_name"
                                />
                            </div>
                            <div class="col-md-3">
                                <label for="title" class="form-label"
                                    >Company E-mail Address</label
                                >
                                <input
                                    type="email"
                                    class="form-control form-control-sm"
                                    id="title"
                                    v-model="
                                        serverParams.columnFilters.co_email
                                    "
                                />
                            </div>
                            <!-- Event Fair Code -->
                            <div class="col-md-2">
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

                            <!-- Participation Type -->
                            <div class="col-md-2">
                                <label class="form-label"
                                    >Participation Type</label
                                >
                                <select
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .participation_type
                                    "
                                >
                                    <option :value="''">-- All --</option>
                                    <option :value="1">Individual</option>
                                    <option :value="2">Group</option>
                                </select>
                            </div>

                            <!-- Conference Response -->
                            <div class="col-md-2">
                                <label class="form-label"
                                    >Conference Response</label
                                >
                                <select
                                    class="form-select form-select-sm"
                                    v-model="
                                        serverParams.columnFilters
                                            .conference_response
                                    "
                                >
                                    <option :value="''">-- All --</option>
                                    <option :value="1">Yes</option>
                                    <option :value="0">No</option>
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
                        <h5 class="card-title">
                            List of conference registrations
                        </h5>
                        <!-- <div class="text-end pb-3" v-if="permissions.can_add">
                            <a
                                href="/admin/registration/suppliers/create"
                                class="btn btn-warning btn-sm text-white"
                                role="button"
                                >Add new supplier</a
                            >
                        </div> -->
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
                                    <!-- Company Name -->
                                    <span
                                        v-if="props.column.field === 'co_name'"
                                        class="text-uppercase"
                                    >
                                        <span v-tooltip="props.row.co_name">
                                            {{
                                                props.row.co_name
                                                    | str_limit(40)
                                            }}
                                        </span>
                                    </span>

                                    <!-- Company Email -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'co_email'
                                        "
                                        class="text-lowercase"
                                    >
                                        {{
                                            props.row.co_email
                                                ? props.row.co_email
                                                : "—"
                                        }}
                                    </span>

                                    <!-- Participation Type -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'participation_type_label'
                                        "
                                    >
                                        {{
                                            props.row
                                                .participation_type_label || "—"
                                        }}
                                    </span>
                                    <!-- Conference Response -->
                                    <span
                                        v-else-if="
                                            props.column.field ===
                                            'conference_response_label'
                                        "
                                    >
                                        {{
                                            props.row
                                                .conference_response_label ||
                                            "—"
                                        }}
                                    </span>

                                    <!-- Created At -->
                                    <span
                                        v-else-if="
                                            props.column.field === 'created_at'
                                        "
                                    >
                                        {{
                                            props.row.updated_at
                                                | moment("llll")
                                        }}
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
    data() {
        return {
            columns: [
                {
                    label: "Company",
                    field: "co_name",
                    tdClass: "align-middle",
                },
                {
                    label: "E-mail Address",
                    field: "co_email",
                    tdClass: "align-middle",
                },
                {
                    label: "Participation Type",
                    field: "participation_type_label",
                    tdClass: "align-middle text-left",
                    sortable: false,
                },
                {
                    label: "Conference Response",
                    field: "conference_response_label",
                    tdClass: "align-middle text-left",
                    sortable: false,
                },

                {
                    label: "Date Registered",
                    field: "created_at",
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
                    co_name: "",
                    co_email: "",
                    fair_code: "",
                    participation_type: "",
                    conference_response: "",
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
        this.fetchEvents();
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

            axios
                .post("/admin/registration/suppliers/conference-list", formData)
                .then((response) => {
                    if (response.status === 200) {
                        // Just assign rows directly from backend
                        this.rows = response.data.data.map((exhibitor) => ({
                            ...exhibitor,
                            // You can add any computed fields here if needed
                        }));

                        this.permissions = response.data.permissions;
                        this.totalRecords = response.data.total;
                        this.isLoading = false;
                        this.scrollToTop();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.isLoading = false;
                });
        },
        fetchEvents() {
            this.isLoading = true;
            axios
                .get("/api/supplier/events")
                .then((response) => {
                    this.events = response.data;

                    if (this.events.length > 0) {
                        // Get the latest event (assumes events are sorted by date descending)
                        const latestEvent = this.events[0]; // or sort by created_at/fair_date if needed
                        this.selectedFairCode = latestEvent.fair_code;
                        this.serverParams.columnFilters.fair_code =
                            latestEvent.fair_code;
                    }

                    // Load buyers for the default latest event
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
            // Keep fair_code as the latest event if available
            const defaultFairCode =
                this.events.length > 0 ? this.events[0].fair_code : "";

            this.serverParams.columnFilters = {
                co_name: "",
                co_email: "",
                fair_code: defaultFairCode,
                participation_type: "",
                conference_response: "",
            };

            this.selectedFairCode = defaultFairCode;
            this.getLists();
        },
        scrollToTop() {
            window.scroll({ top: 300, behavior: "smooth" });
        },
    },
    watch: {
        selectedFairCode(newVal) {
            this.serverParams.columnFilters.fair_code = newVal;
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

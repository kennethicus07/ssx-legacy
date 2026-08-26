<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- HEADER -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-start flex-wrap gap-3"
                        >
                            <div>
                                <h4 class="fw-bold mb-1">Sales Management</h4>

                                <div class="">
                                    {{ exhibitor?.co_name }}
                                </div>

                                <div class="mt-1">
                                    Event:
                                    {{ event?.event_name }}
                                    ({{ fairCode }})
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="small text-muted">Supplier ID</div>

                                <div class="fw-semibold">#{{ user.id }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <!-- SALES -->
                    <div class="col-12 col-xl-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="mt-3 ms-3">
                                <h5 class="mb-0">Sales</h5>
                            </div>

                            <div class="card-body">
                                <!-- SALES TYPE -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        Sales Type
                                    </label>

                                    <select
                                        class="form-select"
                                        v-model="salesType"
                                    >
                                        <option value="export">
                                            Export Sales
                                        </option>

                                        <option value="domestic">
                                            Domestic Sales
                                        </option>

                                        <option value="retail">
                                            Retail Sales
                                        </option>
                                    </select>
                                </div>

                                <!-- COMMON -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Date of Sale
                                        </label>

                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="form.date_of_sale"
                                        />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Product / Service
                                        </label>

                                        <select
                                            class="form-select"
                                            v-model="form.sub_category_id"
                                        >
                                            <option value="">
                                                -- Select Product / Service --
                                            </option>

                                            <optgroup
                                                v-for="category in categories"
                                                :key="category.id"
                                                :label="category.name"
                                            >
                                                <option
                                                    v-for="sub in category.sub_categories"
                                                    :key="sub.id"
                                                    :value="sub.id"
                                                >
                                                    {{ sub.name }}
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                <!-- EXPORT -->
                                <div v-if="salesType === 'export'" class="mt-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Buyer Company
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.buyer_company"
                                            />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Country
                                            </label>

                                            <select
                                                class="form-select"
                                                v-model="
                                                    form.country_destination
                                                "
                                            >
                                                <option value="">
                                                    -- Select Country --
                                                </option>

                                                <option
                                                    v-for="country in filteredCountries"
                                                    :key="country.id"
                                                    :value="country.id"
                                                >
                                                    {{ country.name }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Booked Sales
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    $
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="form.booked"
                                                    @input="
                                                        form.booked =
                                                            numberFormat.onlyNumberWithFormat(
                                                                form.booked
                                                            )
                                                    "
                                                    placeholder="0.00"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Under Negotiation
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    $
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="
                                                        form.under_negotiation
                                                    "
                                                    @input="
                                                        form.under_negotiation =
                                                            numberFormat.onlyNumberWithFormat(
                                                                form.under_negotiation
                                                            )
                                                    "
                                                    placeholder="0.00"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DOMESTIC -->
                                <div
                                    v-if="salesType === 'domestic'"
                                    class="mt-4"
                                >
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Buyer Company
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="form.buyer_company"
                                            />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Buyer Type
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="
                                                    form.type_of_purchaser_buyer
                                                "
                                            />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Booked Sales
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    ₱
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="form.booked"
                                                    @input="
                                                        form.booked =
                                                            numberFormat.onlyNumberWithFormat(
                                                                form.booked
                                                            )
                                                    "
                                                    placeholder="0.00"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Under Negotiation
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    ₱
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="
                                                        form.under_negotiation
                                                    "
                                                    @input="
                                                        form.under_negotiation =
                                                            numberFormat.onlyNumberWithFormat(
                                                                form.under_negotiation
                                                            )
                                                    "
                                                    placeholder="0.00"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- RETAIL -->
                                <div v-if="salesType === 'retail'" class="mt-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Buyer Type
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="
                                                    form.type_of_purchaser_buyer
                                                "
                                            />
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Retail Sales
                                            </label>

                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    ₱
                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="form.booked"
                                                    @input="
                                                        form.booked =
                                                            numberFormat.onlyNumberWithFormat(
                                                                form.booked
                                                            )
                                                    "
                                                    placeholder="0.00"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ACTION -->
                                <div class="mt-4 d-flex gap-2">
                                    <button
                                        class="btn btn-success text-white"
                                        @click="saveSales"
                                    >
                                        <i
                                            class="mdi mdi-content-save-outline me-1"
                                        ></i>

                                        {{
                                            editId
                                                ? "Update Sales"
                                                : "Save Sales"
                                        }}
                                    </button>

                                    <!-- CANCEL EDIT -->
                                    <button
                                        v-if="editId"
                                        class="btn btn-light border"
                                        @click="cancelEdit"
                                    >
                                        <i
                                            class="mdi mdi-close-circle-outline me-1"
                                        ></i>

                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- INQUIRIES -->
                    <div class="col-12 col-xl-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="mt-3 ms-3">
                                <h5 class="mb-0">Sales Inquiry</h5>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label">
                                            Date of Sale
                                        </label>

                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="form.inquries_date_of_sale"
                                        />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label">
                                            No. of Inquiries
                                        </label>

                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            v-model="form.no_of_inquiries"
                                        />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label">
                                            No. of Buyers Met
                                        </label>

                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            v-model="form.no_of_buyers_met"
                                        />
                                    </div>

                                    <div class="col-12">
                                        <div class="mt-2 d-flex gap-2">
                                            <button
                                                class="btn btn-success text-white"
                                                @click="saveInquiry"
                                            >
                                                <i
                                                    class="mdi mdi-content-save-outline me-1"
                                                ></i>

                                                {{
                                                    inquiryEditId
                                                        ? "Update Inquiry"
                                                        : "Save Inquiries"
                                                }}
                                            </button>

                                            <button
                                                v-if="inquiryEditId"
                                                class="btn btn-light border"
                                                @click="cancelInquiryEdit"
                                            >
                                                <i
                                                    class="mdi mdi-close-circle-outline me-1"
                                                ></i>

                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SALES TABLES -->
                <div class="row mt-3">
                    <!-- EXPORT TABLE -->
                    <div class="col-12 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="mt-3 ms-3">
                                <h5 class="mb-0">Export Sales</h5>
                            </div>

                            <div class="card-body">
                                <vue-good-table
                                    :columns="exportColumns"
                                    :rows="exportSales"
                                    styleClass="vgt-table striped"
                                    :pagination-options="{
                                        enabled: true,
                                        perPage: 10,
                                    }"
                                >
                                    <template
                                        slot="table-row"
                                        slot-scope="props"
                                    >
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

                                        <!-- COUNTRY -->
                                        <span
                                            v-else-if="
                                                props.column.field === 'country'
                                            "
                                        >
                                            {{
                                                props.row.country
                                                    ? props.row.country.name
                                                    : "-"
                                            }}
                                        </span>

                                        <!-- BOOKED -->
                                        <span
                                            v-else-if="
                                                props.column.field === 'booked'
                                            "
                                        >
                                            $
                                            {{
                                                useCurrencyFormat(
                                                    props.row.booked
                                                )
                                            }}
                                        </span>

                                        <!-- UNDER NEGOTIATION -->
                                        <span
                                            v-else-if="
                                                props.column.field ===
                                                'under_negotiation'
                                            "
                                        >
                                            $
                                            {{
                                                useCurrencyFormat(
                                                    props.row.under_negotiation
                                                )
                                            }}
                                        </span>

                                        <!-- ACTIONS -->
                                        <div
                                            v-else-if="
                                                props.column.field === 'actions'
                                            "
                                            class="dropdown text-center"
                                        >
                                            <button
                                                class="btn btn-sm border-0 shadow-none"
                                                type="button"
                                                data-bs-toggle="dropdown"
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
                                                        <i
                                                            class="mdi mdi-pencil-outline me-1"
                                                        ></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        href="#"
                                                        @click.prevent="
                                                            deleteSale(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-delete-outline me-1"
                                                        ></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- DEFAULT -->
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

                    <!-- DOMESTIC TABLE -->
                    <div class="col-12 mb-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="mt-3 ms-3">
                                <h5 class="mb-0">Domestic Sales</h5>
                            </div>

                            <div class="card-body">
                                <vue-good-table
                                    :columns="domesticColumns"
                                    :rows="domesticSales"
                                    styleClass="vgt-table striped"
                                    :pagination-options="{
                                        enabled: true,
                                        perPage: 10,
                                    }"
                                >
                                    <template
                                        slot="table-row"
                                        slot-scope="props"
                                    >
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

                                        <!-- BOOKED -->
                                        <span
                                            v-else-if="
                                                props.column.field === 'booked'
                                            "
                                        >
                                            ₱
                                            {{
                                                useCurrencyFormat(
                                                    props.row.booked
                                                )
                                            }}
                                        </span>

                                        <!-- UNDER NEGOTIATION -->
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

                                        <!-- ACTIONS -->
                                        <div
                                            v-else-if="
                                                props.column.field === 'actions'
                                            "
                                            class="dropdown text-center"
                                        >
                                            <button
                                                class="btn btn-sm border-0 shadow-none"
                                                type="button"
                                                data-bs-toggle="dropdown"
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
                                                        <i
                                                            class="mdi mdi-pencil-outline me-1"
                                                        ></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        href="#"
                                                        @click.prevent="
                                                            deleteSale(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-delete-outline me-1"
                                                        ></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- DEFAULT -->
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

                    <!-- RETAIL TABLE -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="mt-3 ms-3">
                                <h5 class="mb-0">Retail Sales</h5>
                            </div>

                            <div class="card-body">
                                <vue-good-table
                                    :columns="retailColumns"
                                    :rows="retailSales"
                                    styleClass="vgt-table striped"
                                    :pagination-options="{
                                        enabled: true,
                                        perPage: 10,
                                    }"
                                >
                                    <template
                                        slot="table-row"
                                        slot-scope="props"
                                    >
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

                                        <!-- BOOKED -->
                                        <span
                                            v-else-if="
                                                props.column.field === 'booked'
                                            "
                                        >
                                            ₱
                                            {{
                                                useCurrencyFormat(
                                                    props.row.booked
                                                )
                                            }}
                                        </span>

                                        <!-- ACTIONS -->
                                        <div
                                            v-else-if="
                                                props.column.field === 'actions'
                                            "
                                            class="dropdown text-center"
                                        >
                                            <button
                                                class="btn btn-sm border-0 shadow-none"
                                                type="button"
                                                data-bs-toggle="dropdown"
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
                                                        <i
                                                            class="mdi mdi-pencil-outline me-1"
                                                        ></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        href="#"
                                                        @click.prevent="
                                                            deleteSale(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-delete-outline me-1"
                                                        ></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- DEFAULT -->
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

                    <!-- INQUIRIES TABLE -->
                    <div class="col-12 mt-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="mt-3 ms-3">
                                <h5 class="mb-0">Sales Inquiries</h5>
                            </div>

                            <div class="card-body">
                                <vue-good-table
                                    :columns="inquiryColumns"
                                    :rows="inquiries"
                                    styleClass="vgt-table striped"
                                    :pagination-options="{
                                        enabled: true,
                                        perPage: 10,
                                    }"
                                >
                                    <template
                                        slot="table-row"
                                        slot-scope="props"
                                    >
                                        <!-- DATE -->
                                        <span
                                            v-if="
                                                props.column.field ===
                                                'inquiries_date_of_sale'
                                            "
                                        >
                                            {{
                                                props.row.inquiries_date_of_sale
                                                    | moment("MMMM DD, YYYY")
                                            }}
                                        </span>

                                        <!-- ACTIONS -->
                                        <div
                                            v-else-if="
                                                props.column.field === 'actions'
                                            "
                                            class="dropdown text-center"
                                        >
                                            <button
                                                class="btn btn-sm border-0 shadow-none"
                                                type="button"
                                                data-bs-toggle="dropdown"
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
                                                            editInquiry(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-pencil-outline me-1"
                                                        ></i>
                                                        Edit
                                                    </a>
                                                </li>

                                                <li>
                                                    <a
                                                        class="dropdown-item text-danger"
                                                        href="#"
                                                        @click.prevent="
                                                            deleteInquiry(
                                                                props.row
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="mdi mdi-delete-outline me-1"
                                                        ></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- DEFAULT -->
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
    </div>
</template>
<style scoped>
.card {
    border-radius: 10px !important;
}
</style>

<script>
import useToast from "../../../../composables/useToast";
import useNumberFormat from "../../../../composables/useNumberFormat";
import { useCurrencyFormat } from "../../../../composables/useCurrencyFormat";

export default {
    props: {
        user: Object,
        event: Object,
        exhibitor: Object,
        fairCode: String,
    },

    data() {
        return {
            salesType: "export",
            categories: [],
            countries: [],
            numberFormat: null,
            exportSales: [],
            domesticSales: [],
            retailSales: [],
            inquiries: [],
            editId: null,
            inquiryEditId: null,
            exportColumns: [
                {
                    label: "Date",
                    field: "date_of_sale",
                },
                {
                    label: "Product / Service",
                    field: "product_service_name",
                },
                {
                    label: "Buyer Company",
                    field: "co_buyer_name",
                },
                {
                    label: "Country",
                    field: "country",
                },
                {
                    label: "Booked ($)",
                    field: "booked",
                },
                {
                    label: "Under Negotiation ($)",
                    field: "under_negotiation",
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false,
                    thClass: "text-center",
                    tdClass: "text-center",
                },
            ],
            domesticColumns: [
                {
                    label: "Date",
                    field: "date_of_sale",
                },
                {
                    label: "Product / Service",
                    field: "product_service_name",
                },
                {
                    label: "Buyer Company",
                    field: "co_buyer_name",
                },
                {
                    label: "Buyer Type",
                    field: "type_of_purchaser_buyer",
                },
                {
                    label: "Booked (₱)",
                    field: "booked",
                },
                {
                    label: "Under Negotiation (₱)",
                    field: "under_negotiation",
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false,
                    thClass: "text-center",
                    tdClass: "text-center",
                },
            ],

            retailColumns: [
                {
                    label: "Date",
                    field: "date_of_sale",
                },
                {
                    label: "Product / Service",
                    field: "product_service_name",
                },
                {
                    label: "Buyer Type",
                    field: "type_of_purchaser_buyer",
                },
                {
                    label: "Retail Sales (₱)",
                    field: "booked",
                },
                {
                    label: "Actions",
                    field: "actions",
                    sortable: false,
                    thClass: "text-center",
                    tdClass: "text-center",
                },
            ],

            inquiryColumns: [
                {
                    label: "Date",
                    field: "inquiries_date_of_sale",
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
                    thClass: "text-center",
                    tdClass: "text-center",
                },
            ],
            form: {
                date_of_sale: "",
                sub_category_id: "",
                buyer_company: "",
                country_destination: "",
                booked: "",
                under_negotiation: "",
                type_of_purchaser_buyer: "",
                inquries_date_of_sale: "",
                no_of_inquiries: "",
                no_of_buyers_met: "",
            },
        };
    },

    watch: {
        salesType(newValue, oldValue) {
            if (!this.editId) {
                this.resetForm();
            }
        },
    },

    created() {
        this.getCategories();
        this.getCountries();
        this.getInquiries();
        this.toast = useToast(Vue);
        this.numberFormat = useNumberFormat();
        this.getSales(1, "exportSales");
        this.getSales(2, "domesticSales");
        this.getSales(3, "retailSales");
    },

    methods: {
        useCurrencyFormat,

        getSales(salesType, target) {
            axios
                .get(
                    `/admin/daily-sales-report/sales-management/list/${salesType}`,
                    {
                        params: {
                            ff_code: this.user.id,
                            fair_code: this.fairCode,
                        },
                    }
                )
                .then((res) => {
                    this[target] = res.data;
                });
        },
        getInquiries() {
            axios
                .get(
                    "/admin/daily-sales-report/sales-management/inquiries/list",
                    {
                        params: {
                            ff_code: this.user.id,
                            fair_code: this.fairCode,
                        },
                    }
                )
                .then((res) => {
                    this.inquiries = res.data;
                });
        },
        resetForm() {
            this.form = {
                date_of_sale: "",
                sub_category_id: "",
                buyer_company: "",
                country_destination: "",
                booked: "",
                under_negotiation: "",
                type_of_purchaser_buyer: "",
                inquries_date_of_sale: "",
                no_of_inquiries: "",
                no_of_buyers_met: "",
            };
            this.editId = null;
        },

        getCategories() {
            axios.get("/api/categories").then((res) => {
                this.categories = res.data;
            });
        },

        getCountries() {
            axios.get("/api/countries").then((res) => {
                this.countries = res.data;
            });
        },

        async saveInquiry() {
            let payload = {
                ff_code: this.user.id,
                fair_code: this.fairCode,
                inquiries_date_of_sale: this.form.inquries_date_of_sale,
                no_of_inquiries: this.form.no_of_inquiries,
                no_of_buyers_met: this.form.no_of_buyers_met,
            };

            try {
                const url = this.inquiryEditId
                    ? `/admin/daily-sales-report/sales-management/inquiries/update/${this.inquiryEditId}`
                    : "/admin/daily-sales-report/sales-management/inquiries/store";

                const response = this.inquiryEditId
                    ? await axios.put(url, payload)
                    : await axios.post(url, payload);

                console.log(response.data);

                this.toast.success(
                    this.inquiryEditId
                        ? "Inquiry updated successfully!"
                        : "Inquiry saved successfully!"
                );

                this.inquiryEditId = null;

                this.form.inquries_date_of_sale = "";
                this.form.no_of_inquiries = "";
                this.form.no_of_buyers_met = "";

                this.getInquiries();
            } catch (error) {
                console.error(error);

                this.toast.error("Failed to save inquiry.");
            }
        },
        editInquiry(inquiry) {
            this.inquiryEditId = inquiry.id;

            this.form.inquries_date_of_sale = inquiry.inquiries_date_of_sale
                ? inquiry.inquiries_date_of_sale.split("T")[0]
                : "";

            this.form.no_of_inquiries = inquiry.no_of_inquiries || "";

            this.form.no_of_buyers_met = inquiry.no_of_buyers_met || "";

            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },

        cancelInquiryEdit() {
            this.inquiryEditId = null;

            this.form.inquries_date_of_sale = "";
            this.form.no_of_inquiries = "";
            this.form.no_of_buyers_met = "";

            this.toast.info("Inquiry edit cancelled.");
        },

        deleteInquiry(inquiry) {
            this.$swal({
                title: "Delete Inquiry?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it",
            }).then((result) => {
                if (!result.isConfirmed) return;

                axios
                    .delete(
                        `/admin/daily-sales-report/sales-management/inquiries/delete/${inquiry.id}`
                    )
                    .then(() => {
                        this.toast.success("Inquiry deleted successfully.");

                        this.getInquiries();
                    })
                    .catch((error) => {
                        console.error(error);

                        this.toast.error("Failed to delete inquiry.");
                    });
            });
        },
        cancelEdit() {
            this.editId = null;

            this.salesType = "export";

            this.resetForm();

            this.toast.info("Edit cancelled.");
        },

        async saveSales() {
            let salesTypeValue = null;

            switch (this.salesType) {
                case "export":
                    salesTypeValue = 1;
                    break;

                case "domestic":
                    salesTypeValue = 2;
                    break;

                case "retail":
                    salesTypeValue = 3;
                    break;
            }

            let payload = {
                ff_code: this.user.id,
                fair_code: this.fairCode,
                sales_type: salesTypeValue,
                date_of_sale: this.form.date_of_sale,
                sub_category_id: this.form.sub_category_id,
            };

            switch (this.salesType) {
                case "export":
                    payload = {
                        ...payload,

                        buyer_company: this.form.buyer_company,

                        country_destination: this.form.country_destination,

                        booked: this.numberFormat.unformat(this.form.booked),

                        under_negotiation: this.numberFormat.unformat(
                            this.form.under_negotiation
                        ),
                    };

                    break;

                case "domestic":
                    payload = {
                        ...payload,

                        buyer_company: this.form.buyer_company,

                        type_of_purchaser_buyer:
                            this.form.type_of_purchaser_buyer,

                        booked: this.numberFormat.unformat(this.form.booked),

                        under_negotiation: this.numberFormat.unformat(
                            this.form.under_negotiation
                        ),
                    };

                    break;

                case "retail":
                    payload = {
                        ...payload,

                        type_of_purchaser_buyer:
                            this.form.type_of_purchaser_buyer,

                        booked: this.numberFormat.unformat(this.form.booked),
                    };

                    break;
            }

            console.log("FINAL PAYLOAD", payload);

            try {
                const response = this.editId
                    ? await axios.put(
                          `/admin/daily-sales-report/sales-management/update/${this.editId}`,
                          payload
                      )
                    : await axios.post(
                          "/admin/daily-sales-report/sales-management/store",
                          payload
                      );

                console.log(response.data);
                this.toast.success("Sales saved successfully.");

                this.resetForm();

                this.getSales(1, "exportSales");
                this.getSales(2, "domesticSales");
                this.getSales(3, "retailSales");
            } catch (error) {
                console.error(error);

                this.toast.error("Failed to save sales.");
            }
        },
        editSale(sale) {
            switch (Number(sale.sales_type)) {
                case 1:
                    this.salesType = "export";
                    break;

                case 2:
                    this.salesType = "domestic";
                    break;

                case 3:
                    this.salesType = "retail";
                    break;
            }

            this.form.date_of_sale = sale.date_of_sale
                ? sale.date_of_sale.split("T")[0]
                : "";

            this.form.sub_category_id = sale.sub_category_id || "";

            this.form.buyer_company = sale.co_buyer_name || "";

            this.form.country_destination = sale.country_destination || "";

            this.form.booked = sale.booked
                ? this.numberFormat.onlyNumberWithFormat(sale.booked)
                : "";

            this.form.under_negotiation = sale.under_negotiation
                ? this.numberFormat.onlyNumberWithFormat(sale.under_negotiation)
                : "";

            this.form.type_of_purchaser_buyer =
                sale.type_of_purchaser_buyer || "";

            this.editId = sale.id;

            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        },

        deleteSale(sale) {
            this.$swal({
                title: "Delete Sale?",
                text: "This action cannot be undone.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, delete it",
            }).then((result) => {
                if (!result.isConfirmed) return;

                axios
                    .delete(
                        `/admin/daily-sales-report/sales-management/delete/${sale.id}`
                    )
                    .then(() => {
                        this.toast.success("Sale deleted successfully.");

                        this.getSales(1, "exportSales");
                        this.getSales(2, "domesticSales");
                        this.getSales(3, "retailSales");
                    })
                    .catch((error) => {
                        console.error(error);

                        this.toast.error("Failed to delete sale.");
                    });
            });
        },
    },

    computed: {
        filteredCountries() {
            return this.countries.filter(
                (country) => Number(country.id) !== 148
            );
        },
    },
};
</script>

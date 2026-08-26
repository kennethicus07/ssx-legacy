<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="tab-pane active" id="order_info" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="accordion" id="accordionPackages">
                            <div
                                class="accordion-spaces-item mb-3 border border-2"
                                v-for="(pkg, index) in packages"
                                :key="pkg.id"
                                v-if="
                                    pkg.participation_booth_spaces &&
                                    pkg.participation_booth_spaces.some(
                                        (s) =>
                                            s.business_type_id === business_type
                                    )
                                "
                            >
                                <div class="accordion-spaces-item">
                                    <h2
                                        class="accordion-header"
                                        :id="`heading${index}`"
                                    >
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            :data-bs-target="`#collapse${index}`"
                                            aria-expanded="false"
                                            :aria-controls="`collapse${index}`"
                                            @click="togglePackage(pkg.id)"
                                        >
                                            {{ pkg.title }} -
                                            {{ pkg.sub_title }}
                                        </button>
                                    </h2>

                                    <div
                                        :id="`collapse${index}`"
                                        class="accordion-collapse collapse"
                                        :aria-labelledby="`heading${index}`"
                                        data-bs-parent="#accordionPackages"
                                    >
                                        <div class="accordion-body">
                                            <!-- Booth spaces -->
                                            <div
                                                class="row text-center g-3 align-items-stretch justify-content-center"
                                            >
                                                <div
                                                    class="col-md-4 d-flex"
                                                    v-for="space in pkg.participation_booth_spaces.filter(
                                                        (s) =>
                                                            s.business_type_id ===
                                                            business_type
                                                    )"
                                                    :key="space.id"
                                                >
                                                    <div
                                                        class="card border border-2 w-100 d-flex flex-column p-4"
                                                        :class="{
                                                            'border-primary bg-light':
                                                                order_info
                                                                    .packageState[
                                                                    pkg.id
                                                                ] &&
                                                                order_info
                                                                    .packageState[
                                                                    pkg.id
                                                                ]
                                                                    .selected_space_id ===
                                                                    space.id,
                                                        }"
                                                    >
                                                        <h5 class="card-title">
                                                            {{ space.name }}
                                                            Space
                                                        </h5>
                                                        <p
                                                            class="card-text mb-2"
                                                        >
                                                            {{ space.currency }}
                                                            {{
                                                                Number(
                                                                    space.cost_per_sqm
                                                                ).toLocaleString()
                                                            }}
                                                            / sqm
                                                        </p>
                                                        <div class="mt-auto">
                                                            <button
                                                                class="btn btn-outline-primary w-100"
                                                                @click="
                                                                    toggleCart(
                                                                        pkg.id,
                                                                        space.id
                                                                    )
                                                                "
                                                            >
                                                                Select
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cart input -->
                                            <div
                                                v-if="isCartVisibleFn(pkg.id)"
                                                class="row mt-4"
                                            >
                                                <div
                                                    class="col-md-12 d-flex justify-content-center gap-2"
                                                >
                                                    <select
                                                        class="form-select w-50"
                                                        v-model="
                                                            order_info
                                                                .packageState[
                                                                pkg.id
                                                            ].selected_size_id
                                                        "
                                                    >
                                                        <option
                                                            :value="null"
                                                            disabled
                                                        >
                                                            -- Select booth size
                                                            --
                                                        </option>

                                                        <!-- Show sizes that belong to the selected space -->
                                                        <option
                                                            v-for="size in getFilteredSizesFn(
                                                                pkg
                                                            )"
                                                            :key="size.id"
                                                            :value="size.id"
                                                        >
                                                            {{ size.name }}
                                                        </option>
                                                    </select>

                                                    <button
                                                        class="btn btn-success text-light"
                                                        @click="
                                                            addToCart(pkg.id)
                                                        "
                                                    >
                                                        Add Package to Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="add-on-container p-4"
                            v-if="addOns && addOns.length"
                        >
                            <p class="text-uppercase mb-3">Optional Add-On</p>
                            <div
                                class="accordion add-on-accordion mx-auto w-50 w-md-75 w-lg-50"
                                id="accordionExample"
                            >
                                <div
                                    class="accordion-item mb-3"
                                    v-for="(addOn, idx) in addOns"
                                    :key="addOn.id"
                                >
                                    <h2
                                        class="accordion-header"
                                        :id="`headingAddOn${idx}`"
                                    >
                                        <button
                                            class="accordion-button"
                                            :class="{
                                                collapsed: openAddOnIdx !== idx,
                                            }"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            :data-bs-target="`#collapseAddOn${idx}`"
                                            :aria-expanded="
                                                openAddOnIdx === idx
                                                    ? 'true'
                                                    : 'false'
                                            "
                                            :aria-controls="`collapseAddOn${idx}`"
                                            @click="toggleAddOnAccordion(idx)"
                                        >
                                            <div class="d-flex flex-column">
                                                <p class="fw-bold mb-0">
                                                    {{ addOn.name }}
                                                </p>
                                                <p class="mb-0 small">
                                                    {{
                                                        addOn.rates &&
                                                        addOn.rates.length
                                                            ? addOn.rates[0]
                                                                  .currency
                                                            : ""
                                                    }}
                                                    {{
                                                        addOn.rates &&
                                                        addOn.rates.length
                                                            ? addOn.rates[0].cost.toLocaleString()
                                                            : ""
                                                    }}
                                                    {{
                                                        addOn.unit
                                                            ? "/" + addOn.unit
                                                            : ""
                                                    }}
                                                    <span
                                                        v-if="
                                                            addOn.limit_per_exhibitor
                                                        "
                                                    >
                                                        — max
                                                        {{
                                                            addOn.limit_per_exhibitor
                                                        }}
                                                    </span>
                                                </p>
                                            </div>
                                        </button>
                                    </h2>

                                    <div
                                        :id="`collapseAddOn${idx}`"
                                        class="accordion-collapse collapse"
                                        :aria-labelledby="`headingAddOn${idx}`"
                                        data-bs-parent="#accordionExample"
                                    >
                                        <div
                                            class="accordion-body row g-3 align-items-center"
                                        >
                                            <div
                                                class="col-md-12 d-flex justify-content-start align-items-start gap-3"
                                            >
                                                <div class="w-50">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="Enter quantity"
                                                            v-model.number="
                                                                addOn.selectedQty
                                                            "
                                                            v-limit="{
                                                                max: 15,
                                                                numeric: true,
                                                            }"
                                                            :max="
                                                                addOn.limit_per_exhibitor
                                                            "
                                                            min="1"
                                                        />
                                                        <span
                                                            class="input-group-text"
                                                        >
                                                            {{
                                                                addOn.unit
                                                                    ? addOn.unit
                                                                    : ""
                                                            }}
                                                        </span>
                                                    </div>
                                                    <small
                                                        class="text-light d-block mt-1"
                                                        v-if="
                                                            addOn.limit_per_exhibitor
                                                        "
                                                    >
                                                        Max:
                                                        {{
                                                            addOn.limit_per_exhibitor
                                                        }}
                                                        {{ addOn.unit
                                                        }}{{
                                                            addOn.limit_per_exhibitor >
                                                            1
                                                                ? "s"
                                                                : ""
                                                        }}
                                                    </small>
                                                </div>

                                                <button
                                                    class="btn btn-light text-success fw-bold h-100"
                                                    @click="
                                                        addAddOnToCart(
                                                            addOn,
                                                            idx
                                                        )
                                                    "
                                                >
                                                    <span
                                                        class="mdi mdi-cart-outline"
                                                    ></span>
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <h6 class="fw-bold text-uppercase">
                                {{ co_name }}
                            </h6>

                            <!-- Wrap table inside a slider div -->
                            <div class="table-slider">
                                <table
                                    class="table table-sm align-middle text-center mb-0"
                                    style="min-width: 1200px"
                                >
                                    <thead class="table-light">
                                        <tr class="fw-bold">
                                            <td>Package</td>
                                            <td>Package Details</td>
                                            <td>Booth Cost</td>
                                            <td>Discount</td>
                                            <td>Booth Size</td>
                                            <td>Participation Fee</td>
                                            <td>Total</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in cart" :key="item.id">
                                            <td class="text-start">
                                                {{ item.package_title }} -
                                                {{ item.space_name }}
                                            </td>
                                            <td>
                                                {{ item.package_sub_title }}
                                            </td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.booth_amount
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                <p style="margin-bottom: 0px">
                                                    {{
                                                        item.discount
                                                            ? formatNumber(
                                                                  item.discount
                                                              )
                                                            : "-"
                                                    }}
                                                </p>
                                                <p
                                                    style="margin-bottom: 0px"
                                                    v-if="item.discount_remarks"
                                                >
                                                    <small class="">{{
                                                        item.discount_remarks
                                                    }}</small>
                                                </p>
                                            </td>
                                            <td>{{ item.booth_size_name }}</td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.total_participation
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.total_amount_due
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                <div class="mt-1">
                                                    <button
                                                        class="btn btn-sm btn-outline-danger me-1"
                                                        @click="
                                                            deleteCartItem(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="far fa-trash-alt"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- ADD-ONS SECTION -->
                                        <tr
                                            v-if="addonCart.length"
                                            class="fw-bold table-light"
                                        >
                                            <td>ADD ONS:</td>
                                            <td>Name</td>
                                            <td>Quantity</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr
                                            v-for="(item, index) in addonCart"
                                            :key="item.id"
                                        >
                                            <td></td>
                                            <!-- Add-on Name -->
                                            <td>
                                                {{ item.addon_name }}:
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.rate_cost
                                                    )
                                                }}/{{ item.unit }}
                                            </td>
                                            <!-- Qty -->
                                            <td>
                                                <span
                                                    class="badge bg-secondary rounded-pill"
                                                >
                                                    {{ item.qty }}×
                                                </span>
                                            </td>
                                            <!-- Total Amount -->
                                            <td></td>
                                            <td
                                                colspan="2"
                                                class="text-end"
                                            ></td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.total_amount_due
                                                    )
                                                }}
                                            </td>

                                            <!-- Optional delete button -->
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-outline-danger me-1"
                                                    @click="
                                                        deleteAddOnToCart(
                                                            item.id
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="far fa-trash-alt"
                                                    ></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Fallback row if cart is empty -->
                                        <tr
                                            v-if="
                                                cart.length === 0 &&
                                                addonCart.length === 0
                                            "
                                        >
                                            <td
                                                colspan="8"
                                                class="text-center text-muted py-4"
                                            >
                                                Your
                                                <span
                                                    class="mdi mdi-cart"
                                                ></span>
                                                cart is empty — please select a
                                                package to continue.
                                            </td>
                                        </tr>
                                        <!-- Summary Rows -->
                                        <tr class="table-light fw-bold">
                                            <td colspan="6" class="text-end">
                                                SSX Mandatory Fee:
                                            </td>
                                            <td>
                                                {{ mandatory.currency }}
                                                {{
                                                    formatNumber(
                                                        mandatory.price
                                                    )
                                                }}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="table-secondary fw-bold">
                                            <td colspan="6" class="text-end">
                                                Estimated Total Amount Due:
                                            </td>
                                            <td>
                                                {{ mandatory.currency }}
                                                {{ formatNumber(grandTotal) }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-2">
                                <p class="mb-0 small">
                                    {{ mandatory.details }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "OrderInfoCard",
    props: {
        order_info: {
            type: Object,
            required: true,
        },

        packages: {
            type: Array,
            default: () => [],
        },
        addOns: {
            type: Array,
            default: () => [],
        },
        co_name: {
            type: String,
            required: true,
        },
        business_type: {
            type: Number,
            required: true,
        },
        mandatory: {
            type: Object,
            required: true,
        },
        cart: {
            type: Array,
            default: () => [],
        },
        addonCart: {
            type: Array,
            default: () => [],
        },

        grandTotal: {
            type: Number,
        },
        openAddOnIdx: Number,
        validation: { type: Object, required: true },

        formatNumberFn: { type: Function, required: false },
        isCartVisibleFn: { type: Function, required: true },
        getFilteredSizesFn: { type: Function, required: true },
    },
    emits: [
        "toggle-package",
        "toggle-cart",
        "add-to-cart",
        "toggle-addon-accordion",
        "add-addon-to-cart",
        "format-number",
        "delete-cart-item",
        "delete-addon-to-cart",
    ],
    methods: {
        togglePackage(pkgId) {
            this.$emit("toggle-package", pkgId);
        },
        toggleCart(pkgId, spaceId) {
            this.$emit("toggle-cart", pkgId, spaceId);
        },

        addToCart(pkgId) {
            this.$emit("add-to-cart", pkgId);
        },
        deleteCartItem(cartItemId) {
            this.$emit("delete-cart-item", cartItemId);
        },

        toggleAddOnAccordion(idx) {
            this.$emit("toggle-addon-accordion", idx);
        },
        addAddOnToCart(addOn, idx) {
            this.$emit("add-addon-to-cart", addOn, idx);
        },
        deleteAddOnToCart(addOnId) {
            this.$emit("delete-addon-to-cart", addOnId);
        },

        formatNumber(value) {
            if (
                this.formatNumberFn &&
                typeof this.formatNumberFn === "function"
            ) {
                return this.formatNumberFn(value);
            }
            // fallback: emit event (no return)
            this.$emit("format-number", value);
            return value;
        },
    },
};
</script>

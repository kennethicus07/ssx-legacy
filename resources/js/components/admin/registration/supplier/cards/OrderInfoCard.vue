<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="tab-pane active" id="order_info" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row">
                            <div
                                v-if="
                                    !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                    ((permissions.conforme &&
                                        status_conforme_pending_generation) ||
                                        (!status_conforme_pending_generation &&
                                            permissions.can_edit))
                                "
                                class="mb-4 col-md-6 d-flex gap-2 justify-content-start"
                            >
                                <!-- Additional Fees Button -->
                                <button
                                    class="btn btn-primary"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#feesModal"
                                >
                                    Additional Fees
                                </button>

                                <!-- Discount Button -->
                                <button
                                    class="btn btn-warning text-white"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#discountModal"
                                >
                                    Discount
                                </button>
                            </div>

                            <!-- Added checkbox + button -->
                            <div
                                v-if="
                                    permissions.conforme &&
                                    status_conforme_pending_generation
                                "
                                class="mb-4 col-md-6 d-flex gap-2 justify-content-end"
                            >
                                <!-- <div
                                    class="form-check d-flex align-items-center mb-0"
                                >
                                    <input
                                        class="form-check-input me-1"
                                        type="checkbox"
                                        :checked="conforme_reviewed"
                                        @change="onAccountingReviewedChange"
                                        :disabled="
                                            is_fully_approved_by_reviewer_and_conforme_reviewed
                                        "
                                    />
                                </div> -->

                                <!-- <button
                                    class="btn btn-success text-white"
                                    @click="submitConformeReview"
                                    :disabled="
                                        is_fully_approved_by_reviewer_and_conforme_reviewed
                                    "
                                >
                                    Generate Conforme
                                </button> -->
                            </div>
                        </div>

                        <!-- Additional Fees Modal -->
                        <div
                            class="modal fade"
                            id="feesModal"
                            tabindex="-1"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content p-4">
                                    <h5 class="mb-4">Additional Fees</h5>

                                    <div class="row g-3">
                                        <!-- Remark -->
                                        <div class="col-md-6">
                                            <label
                                                for="feeRemark"
                                                class="form-label"
                                                >Additional Fee Remark<span
                                                    class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="feeRemark"
                                                v-model="feeRemark"
                                                v-limit="{
                                                    max: 95,
                                                }"
                                                placeholder="Enter remark"
                                            />
                                        </div>

                                        <!-- Amount -->
                                        <div class="col-md-6">
                                            <label
                                                for="feeAmount"
                                                class="form-label"
                                                >Additional Fee Amount ({{
                                                    mandatory.currency
                                                }})<span class="text-danger"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="feeAmount"
                                                v-model="feeAmount"
                                                v-limit="{
                                                    max: 30,
                                                    numeric: true,
                                                }"
                                                placeholder="Enter amount"
                                            />
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div
                                        class="d-flex justify-content-end gap-2 mt-4"
                                    >
                                        <button
                                            class="btn btn-success text-white"
                                            @click="addAdditionalFees"
                                        >
                                            Add Additional Fee
                                        </button>
                                        <button
                                            class="btn btn-secondary"
                                            @click="closeFeesModal"
                                        >
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Modal -->
                        <div
                            class="modal fade"
                            id="discountModal"
                            tabindex="-1"
                            aria-hidden="true"
                        >
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content p-4">
                                    <h5 class="mb-4">Discount</h5>

                                    <div class="row g-3">
                                        <!-- Discount Remark -->
                                        <div class="col-md-6">
                                            <label
                                                for="discountRemark"
                                                class="form-label"
                                            >
                                                Discount Remark<span
                                                    class="text-danger"
                                                    >*</span
                                                >
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="discountRemark"
                                                v-model="discountRemark"
                                                v-limit="{ max: 95 }"
                                                placeholder="Enter remark"
                                            />
                                        </div>

                                        <!-- Discount Amount -->
                                        <div class="col-md-6">
                                            <label
                                                for="discountAmount"
                                                class="form-label"
                                            >
                                                Discount Amount ({{
                                                    mandatory.currency
                                                }})<span class="text-danger"
                                                    >*</span
                                                >
                                            </label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="discountAmount"
                                                v-model="discountAmount"
                                                placeholder="Enter amount"
                                                v-limit="{
                                                    max: 30,
                                                    numeric: true,
                                                }"
                                            />
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div
                                        class="d-flex justify-content-end gap-2 mt-4"
                                    >
                                        <button
                                            class="btn btn-success text-white"
                                            @click="addDiscount"
                                        >
                                            Apply Discount
                                        </button>
                                        <button
                                            class="btn btn-secondary"
                                            @click="closeDiscountModal"
                                        >
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PARTICIPATION TYPE SELECTION -->
                        <div class="col-md-12 mb-3">
                            <div class="card m-0 h-100 beige-bg">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Participation Type*</h4>
                                            <div
                                                v-if="
                                                    validation_attendance_info
                                                        .participation_type
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !validation_attendance_info
                                                            .participation_type
                                                            .required
                                                    "
                                                >
                                                    Participation type is
                                                    required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="participation_type"
                                                    id="participation_individual"
                                                    :value="1"
                                                    v-model="
                                                        attendance_info.participation_type
                                                    "
                                                    :disabled="
                                                        lockParticipationType
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="participation_individual"
                                                >
                                                    Individual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="participation_type"
                                                    id="participation_group"
                                                    :value="2"
                                                    v-model="
                                                        attendance_info.participation_type
                                                    "
                                                    :disabled="
                                                        lockParticipationType ||
                                                        is_startup === 1
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="participation_group"
                                                >
                                                    Group
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PARTICIPATION TYPE -->

                        <!-- PACKAGES -->
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
                                                                formatNumber(
                                                                    space.cost_per_sqm
                                                                )
                                                            }}
                                                            / sqm
                                                        </p>
                                                        <div
                                                            class="mt-auto"
                                                            v-if="
                                                                !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                                (status_conforme_pending_generation
                                                                    ? permissions.conforme
                                                                    : permissions.can_edit)
                                                            "
                                                        >
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
                                            <!-- Booth Details -->
                                            <div
                                                v-if="pkg.booth_details"
                                                class="mt-4"
                                            >
                                                <div
                                                    v-html="pkg.booth_details"
                                                ></div>
                                            </div>

                                            <!-- Cart input -->
                                            <div
                                                v-if="isCartVisibleFn(pkg.id)"
                                                class="row mt-4"
                                            >
                                                <div
                                                    class="row justify-content-center align-items-center g-2"
                                                >
                                                    <!-- Booth size -->
                                                    <div
                                                        :class="
                                                            attendance_info.participation_type ==
                                                            2
                                                                ? 'col-12 col-md-3'
                                                                : 'col-12 col-md-6'
                                                        "
                                                    >
                                                        <select
                                                            class="form-select border-secondary"
                                                            v-model="
                                                                order_info
                                                                    .packageState[
                                                                    pkg.id
                                                                ]
                                                                    .selected_size_id
                                                            "
                                                        >
                                                            <option
                                                                :value="null"
                                                                disabled
                                                            >
                                                                Select booth
                                                                size
                                                            </option>
                                                            <option
                                                                v-for="size in getFilteredSizes(
                                                                    pkg
                                                                )"
                                                                :key="size.id"
                                                                :value="size.id"
                                                            >
                                                                {{ size.name }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <!-- Quantity (type 2 only) -->
                                                    <div
                                                        v-if="
                                                            attendance_info.participation_type ==
                                                            2
                                                        "
                                                        class="col-12 col-md-auto pe-md-4 pe-0"
                                                    >
                                                        <div
                                                            class="input-group"
                                                            :class="{
                                                                'opacity-50 pointer-events-none':
                                                                    !selected_size_id,
                                                            }"
                                                        >
                                                            <button
                                                                :class="{
                                                                    'border-end-0':
                                                                        order_info
                                                                            .packageState[
                                                                            pkg
                                                                                .id
                                                                        ]
                                                                            .selected_size_id,
                                                                }"
                                                                class="btn btn-outline-secondary"
                                                                type="button"
                                                                :disabled="
                                                                    !order_info
                                                                        .packageState[
                                                                        pkg.id
                                                                    ]
                                                                        .selected_size_id
                                                                "
                                                                @click="
                                                                    decreaseQty(
                                                                        pkg.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="mdi mdi-minus"
                                                                ></span>
                                                            </button>

                                                            <input
                                                                type="number"
                                                                class="form-control text-center border border-secondary qty-input"
                                                                :class="{
                                                                    'border-secondary border-end-0 border-start-0':
                                                                        !order_info
                                                                            .packageState[
                                                                            pkg
                                                                                .id
                                                                        ]
                                                                            .selected_size_id,
                                                                }"
                                                                style="
                                                                    max-width: 70px;
                                                                "
                                                                v-model.number="
                                                                    order_info
                                                                        .packageState[
                                                                        pkg.id
                                                                    ].qty
                                                                "
                                                                :min="
                                                                    getQtyRules(
                                                                        pkg
                                                                    ).min
                                                                "
                                                                :max="
                                                                    getQtyRules(
                                                                        pkg
                                                                    ).max
                                                                "
                                                                :disabled="
                                                                    !order_info
                                                                        .packageState[
                                                                        pkg.id
                                                                    ]
                                                                        .selected_size_id
                                                                "
                                                                placeholder="0"
                                                            />

                                                            <button
                                                                :class="{
                                                                    'border-start-0':
                                                                        order_info
                                                                            .packageState[
                                                                            pkg
                                                                                .id
                                                                        ]
                                                                            .selected_size_id,
                                                                }"
                                                                class="btn btn-outline-secondary"
                                                                type="button"
                                                                :disabled="
                                                                    !order_info
                                                                        .packageState[
                                                                        pkg.id
                                                                    ]
                                                                        .selected_size_id
                                                                "
                                                                @click="
                                                                    increaseQty(
                                                                        pkg.id
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="mdi mdi-plus"
                                                                ></span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <!-- Add to Cart -->
                                                    <div
                                                        class="col-12 col-md-auto"
                                                    >
                                                        <button
                                                            class="btn btn-success w-100 text-light"
                                                            @click="
                                                                addToCart(
                                                                    pkg.id
                                                                )
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
                        </div>
                        <!-- END PACKAGES -->

                        <!-- OPTIONAL ADD ON -->
                        <div
                            class="add-on-container p-4"
                            v-if="addOns && addOns.length && is_startup === 1"
                        >
                            <p class="text-uppercase mb-3">Optional Add-On</p>
                            <div
                                class="accordion add-on-accordion mx-auto w-50 w-md-75 w-lg-50"
                                id="accordionExample"
                            >
                                <div
                                    v-for="(addOn, idx) in addOns"
                                    :key="addOn.id"
                                >
                                    <!-- 🎤 Pitching Competition -->
                                    <div v-if="addOn.id === 5">
                                        <div class="accordion-item mb-3">
                                            <h2
                                                class="accordion-header"
                                                :id="`headingAddOn${idx}`"
                                            >
                                                <button
                                                    class="accordion-button"
                                                    :class="{
                                                        collapsed:
                                                            openAddOnIdx !==
                                                            idx,
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
                                                    @click="
                                                        toggleAddOnAccordion(
                                                            idx
                                                        )
                                                    "
                                                >
                                                    <div
                                                        class="d-flex flex-column"
                                                    >
                                                        <p class="fw-bold mb-0">
                                                            {{ addOn.name }}
                                                        </p>
                                                        <p class="mb-0 small">
                                                            <!-- No cost, just empty text -->
                                                            <span
                                                                >Free of
                                                                charge</span
                                                            >

                                                            <!-- Max per exhibitor -->
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
                                                    <p>{{ addOn.notes }}</p>

                                                    <!-- 🎤 Pitching Competition Categories -->
                                                    <div class="mb-3">
                                                        <label
                                                            class="fw-bold mb-1"
                                                            >Select Pitching
                                                            Categories:</label
                                                        >
                                                        <div
                                                            class="d-flex flex-column"
                                                        >
                                                            <div
                                                                v-for="category in addOn.pitching_session_categories"
                                                                :key="
                                                                    category.id
                                                                "
                                                                class="form-check"
                                                            >
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    :id="`pitchingCat${category.id}`"
                                                                    v-model="
                                                                        order_info.pitching_competition_selection
                                                                    "
                                                                    :value="
                                                                        category.id
                                                                    "
                                                                />
                                                                <label
                                                                    class="form-check-label"
                                                                    :for="`pitchingCat${category.id}`"
                                                                >
                                                                    {{
                                                                        category.value
                                                                    }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="col-md-12 d-flex justify-content-start align-items-start gap-3"
                                                    >
                                                        <!-- Add to Cart button -->
                                                        <button
                                                            v-if="
                                                                !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                                !status_conforme_pending_generation &&
                                                                permissions.can_edit
                                                            "
                                                            class="btn btn-light text-success fw-bold h-100"
                                                            @click="
                                                                addPitchingAddOnToCart(
                                                                    addOn,
                                                                    idx
                                                                )
                                                            "
                                                        >
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 🛒 Default add-ons -->
                                    <div v-else>
                                        <div class="accordion-item mb-3">
                                            <h2
                                                class="accordion-header"
                                                :id="`headingAddOn${idx}`"
                                            >
                                                <button
                                                    class="accordion-button"
                                                    :class="{
                                                        collapsed:
                                                            openAddOnIdx !==
                                                            idx,
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
                                                    @click="
                                                        toggleAddOnAccordion(
                                                            idx
                                                        )
                                                    "
                                                >
                                                    <div
                                                        class="d-flex flex-column"
                                                    >
                                                        <p class="fw-bold mb-0">
                                                            {{ addOn.name }}
                                                        </p>
                                                        <p class="mb-0 small">
                                                            {{
                                                                addOn.rates &&
                                                                addOn.rates
                                                                    .length
                                                                    ? addOn
                                                                          .rates[0]
                                                                          .currency
                                                                    : ""
                                                            }}
                                                            <span
                                                                v-if="
                                                                    addOn.rates &&
                                                                    addOn.rates
                                                                        .length &&
                                                                    addOn
                                                                        .rates[0]
                                                                        .cost !==
                                                                        null
                                                                "
                                                            >
                                                                {{
                                                                    addOn.rates[0].cost.toLocaleString()
                                                                }}
                                                            </span>
                                                            {{
                                                                addOn.unit
                                                                    ? "/" +
                                                                      addOn.unit
                                                                    : ""
                                                            }}

                                                            <!-- Max per exhibitor -->
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
                                                        <!-- Quantity input -->
                                                        <div class="w-50">
                                                            <div
                                                                class="input-group"
                                                            >
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

                                                        <!-- Add to Cart button -->
                                                        <button
                                                            v-if="
                                                                !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                                (status_conforme_pending_generation
                                                                    ? permissions.conforme
                                                                    : permissions.can_edit)
                                                            "
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
                            </div>
                        </div>
                        <!-- END OPTIONAL ADD ON -->

                        <!-- CONFERENCE -->
                        <div class="col-md-12 mb-3">
                            <div class="card m-0 h-100 beige-bg">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Conference*</h4>
                                            <p>
                                                Are you interested in
                                                participating in the SSX
                                                Conference?
                                            </p>
                                            <div
                                                v-if="
                                                    validation_attendance_info
                                                        .conference_response
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !validation_attendance_info
                                                            .conference_response
                                                            .required
                                                    "
                                                >
                                                    Conference is required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="conference_response"
                                                    id="conference_response_yes"
                                                    :value="1"
                                                    v-model="
                                                        attendance_info.conference_response
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="conference_response_yes"
                                                >
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="conference_response"
                                                    id="conference_response_no"
                                                    :value="0"
                                                    v-model="
                                                        attendance_info.conference_response
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="conference_response_no"
                                                >
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END CONFERENCE -->

                        <!-- SPONSORSHIP  -->
                        <div class="col-md-12 mb-3">
                            <div class="card m-0 h-100 beige-bg">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Sponsorship*</h4>
                                            <p>
                                                Are you interested in becoming a
                                                sponsor for SSX 2026?
                                            </p>
                                            <div
                                                v-if="
                                                    validation_attendance_info
                                                        .sponsorship_response
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !validation_attendance_info
                                                            .sponsorship_response
                                                            .required
                                                    "
                                                >
                                                    Sponsorship is required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="sponsorship_response"
                                                    id="sponsorship_response_yes"
                                                    :value="1"
                                                    v-model="
                                                        attendance_info.sponsorship_response
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="sponsorship_response_yes"
                                                >
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="sponsorship_response"
                                                    id="sponsorship_response_no"
                                                    :value="0"
                                                    v-model="
                                                        attendance_info.sponsorship_response
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="sponsorship_response_no"
                                                >
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END SPONSORSHIP -->

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
                                        <tr class="fw-bold text-start">
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
                                        <tr
                                            v-for="item in cart"
                                            :key="item.id"
                                            class="text-start"
                                        >
                                            <td>
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
                                                            : "—"
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
                                            <td>
                                                {{ item.booth_size_name }}
                                                <span
                                                    class="mdi mdi-window-close"
                                                ></span>
                                                {{ item.qty }}
                                            </td>
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
                                                <div
                                                    class="mt-1"
                                                    v-if="
                                                        !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                        (status_conforme_pending_generation
                                                            ? permissions.conforme
                                                            : permissions.can_edit)
                                                    "
                                                >
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
                                            class="fw-bold table-light text-start"
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
                                            class="text-start"
                                            v-for="(item, index) in addonCart"
                                            :key="item.id"
                                        >
                                            <td></td>
                                            <!-- Add-on Name -->
                                            <td>
                                                <template
                                                    v-if="item.addon_id === 5"
                                                >
                                                    {{ item.addon_name }}
                                                </template>

                                                <template v-else>
                                                    {{ item.addon_name }}:
                                                    {{ item.currency }}
                                                    {{
                                                        formatNumber(
                                                            item.rate_cost
                                                        )
                                                    }}/{{ item.unit }}
                                                </template>
                                            </td>
                                            <!-- Qty -->
                                            <td>
                                                {{ item.qty }}
                                            </td>
                                            <!-- Total Amount -->
                                            <td></td>
                                            <td
                                                colspan="2"
                                                class="text-end"
                                            ></td>
                                            <td>
                                                <template
                                                    v-if="item.addon_id === 5"
                                                >
                                                    —
                                                </template>

                                                <template v-else>
                                                    {{ item.currency }}
                                                    {{
                                                        formatNumber(
                                                            item.total_amount_due
                                                        )
                                                    }}
                                                </template>
                                            </td>

                                            <!-- Optional delete button -->
                                            <td>
                                                <button
                                                    v-if="
                                                        !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                        (status_conforme_pending_generation
                                                            ? permissions.conforme
                                                            : permissions.can_edit)
                                                    "
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
                                        <!-- ADDITIONAL FEES/DISCOUNTS SECTION -->
                                        <tr
                                            v-if="additionalFeesCart.length"
                                            class="text-start fw-bold table-light"
                                        >
                                            <td>ADDITIONAL FEES/DISCOUNTS:</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr
                                            class="text-start"
                                            v-for="(
                                                itemFee, index
                                            ) in additionalFeesCart"
                                            :key="itemFee.id"
                                        >
                                            <td></td>
                                            <!-- Additional Fee Name -->
                                            <td>{{ itemFee.remarks }}</td>

                                            <td></td>
                                            <!-- Additional Fee Amount -->
                                            <td></td>
                                            <td
                                                colspan="2"
                                                class="text-end"
                                            ></td>
                                            <td>
                                                {{ itemFee.currency }}
                                                {{
                                                    formatNumber(itemFee.amount)
                                                }}
                                            </td>

                                            <!-- Optional delete button -->
                                            <td>
                                                <button
                                                    v-if="
                                                        !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                        (status_conforme_pending_generation
                                                            ? permissions.conforme
                                                            : permissions.can_edit)
                                                    "
                                                    class="btn btn-sm btn-outline-danger me-1"
                                                    @click="
                                                        deleteAdditionalFeeCartItem(
                                                            itemFee.id
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="far fa-trash-alt"
                                                    ></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr
                                            class="text-start"
                                            v-for="(
                                                itemDiscount, index
                                            ) in discountCart"
                                            :key="itemDiscount.id"
                                        >
                                            <td></td>
                                            <!-- Additional Fee Name -->
                                            <td>{{ itemDiscount.remarks }}</td>

                                            <td></td>
                                            <!-- Additional Fee Amount -->
                                            <td></td>
                                            <td
                                                colspan="2"
                                                class="text-end"
                                            ></td>
                                            <td>
                                                {{ itemDiscount.currency }}
                                                <span class="text-danger"
                                                    ><i
                                                        class="mdi mdi-minus"
                                                    ></i></span
                                                >{{
                                                    formatNumber(
                                                        itemDiscount.amount
                                                    )
                                                }}
                                            </td>

                                            <!-- Optional delete button -->
                                            <td>
                                                <button
                                                    v-if="
                                                        !is_fully_approved_by_reviewer_and_conforme_reviewed &&
                                                        (status_conforme_pending_generation
                                                            ? permissions.conforme
                                                            : permissions.can_edit)
                                                    "
                                                    class="btn btn-sm btn-outline-danger me-1"
                                                    @click="
                                                        deleteDiscountCartItem(
                                                            itemDiscount.id
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
                                                addonCart.length === 0 &&
                                                additionalFeesCart.length ===
                                                    0 &&
                                                discountCart.length === 0
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
                                        <tr
                                            class="table-light fw-bold"
                                            v-if="
                                                mandatory &&
                                                mandatory.is_required
                                            "
                                        >
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
                                        <tr
                                            class="table-secondary fw-bold text-start"
                                        >
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

                            <div
                                class="mt-2"
                                v-if="mandatory && mandatory.is_required"
                            >
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
import * as bootstrap from "bootstrap";
import { required } from "vuelidate/lib/validators";
export default {
    name: "OrderInfoCard",
    props: {
        is_fully_approved_by_reviewer_and_conforme_reviewed: {
            type: Boolean,
        },
        order_info: {
            type: Object,
            required: true,
        },
        attendance_info: {
            type: Object,
            required: true,
        },
        permissions: {
            type: Object,
        },
        status_conforme_pending_generation: Boolean,
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
        is_startup: {
            type: Number,
            required: true,
        },
        conforme_reviewed: {
            type: Number,
            require: true,
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

        additionalFeesCart: {
            type: Array,
            default: () => [],
        },

        discountCart: {
            type: Array,
            default: () => [],
        },

        grandTotal: {
            type: Number,
        },
        openAddOnIdx: Number,
        validation: { type: Object, required: true },
        validation_attendance_info: { type: Object, required: true },
        formatNumberFn: { type: Function, required: false },
        isCartVisibleFn: { type: Function, required: true },
        getFilteredSizes: { type: Function, required: true },
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
        "add-additional-fees",
        "delete-additional-fee-cart-item",
        "add-discount",
        "delete-discount-cart-item",
        "submit-conforme-review",
        "add-pitching-add-on-to-cart",
        "increase-qty",
        "decrease-qty",
    ],
    data() {
        return {
            showFeesModal: false,
            showDiscountModal: false,
            feeRemark: "",
            feeAmount: "",
            discountRemark: "",
            discountAmount: "",
        };
    },
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
        increaseQty(pkgId) {
            this.$emit("increase-qty", pkgId);
        },
        decreaseQty(pkgId) {
            this.$emit("decrease-qty", pkgId);
        },
        toggleAddOnAccordion(idx) {
            this.$emit("toggle-addon-accordion", idx);
        },
        addAddOnToCart(addOn, idx) {
            this.$emit("add-addon-to-cart", addOn, idx);
        },
        addPitchingAddOnToCart(addOn, idx) {
            this.$emit("add-pitching-add-on-to-cart", addOn, idx);
        },

        deleteAddOnToCart(addOnId) {
            this.$emit("delete-addon-to-cart", addOnId);
        },

        addAdditionalFees() {
            if (!this.feeRemark || !this.feeAmount) {
                Vue.$toast.error("Please fill in all required fields", {
                    position: "top-right",
                });
                return;
            }

            // Emit data to parent (like addToCart emits pkgId)
            this.$emit("add-additional-fees", {
                remark: this.feeRemark,
                amount: this.feeAmount,
            });
        },

        deleteAdditionalFeeCartItem(additionalFeeCartItemId) {
            this.$emit(
                "delete-additional-fee-cart-item",
                additionalFeeCartItemId
            );
        },

        addDiscount() {
            if (!this.discountRemark || !this.discountAmount) {
                Vue.$toast.error("Please fill in all required fields", {
                    position: "top-right",
                });
                return;
            }

            // Emit data to parent (like addToCart emits pkgId)
            this.$emit("add-discount", {
                remark: this.discountRemark,
                amount: this.discountAmount,
            });
        },

        deleteDiscountCartItem(discountCartItemId) {
            this.$emit("delete-discount-cart-item", discountCartItemId);
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
        openFeesModal() {
            this.showFeesModal = true;
            const modal = new bootstrap.Modal(
                document.getElementById("feesModal")
            );
            modal.show();
        },
        closeFeesModal() {
            const modal = bootstrap.Modal.getInstance("#feesModal");
            if (modal) {
                modal.hide();
            }

            this.showFeesModal = false;
            this.feeRemark = "";
            this.feeAmount = "";
        },

        openDiscountModal() {
            this.showDiscountModal = true;
            const modal = new bootstrap.Modal(
                document.getElementById("discountModal")
            );
            modal.show();
        },
        closeDiscountModal() {
            const modal = bootstrap.Modal.getInstance("#discountModal");
            if (modal) {
                modal.hide();
            }

            this.showDiscountModal = false;
            this.discountRemark = "";
            this.discountAmount = "";
        },

        onConformeReviewedChange(e) {
            const value = e.target.checked ? 1 : 0;
            this.$emit("update:conforme_reviewed", value);
        },

        submitConformeReview() {
            this.$emit("submit-conforme-review", 1);
        },

        getQtyRules(pkg) {
            const state = this.order_info.packageState[pkg.id];

            if (
                this.attendance_info.participation_type != 2 ||
                !state?.selected_size_id
            ) {
                return {};
            }

            return {};
        },
    },
    computed: {
        lockParticipationType() {
            return (
                this.is_fully_approved_by_reviewer_and_conforme_reviewed &&
                (this.permissions.can_edit || this.permissions.conforme)
            );
        },
    },
    watch: {
        "order_info.packageState": {
            deep: true,
            handler() {
                Object.keys(this.order_info.packageState).forEach((pkgId) => {
                    const state = this.order_info.packageState[pkgId];

                    // Reset qty if no size selected
                    if (!state.selected_size_id) {
                        state.qty = null;
                        return; // skip clamping
                    }

                    const pkg = this.packages.find((p) => p.id == pkgId);
                    if (!pkg) return;

                    const rules = this.getQtyRules(pkg);
                    if (!rules.min || !rules.max) return;

                    // Clamp qty within min/max
                    if (state.qty < rules.min) state.qty = rules.min;
                    if (state.qty > rules.max) state.qty = rules.max;
                });
            },
        },
    },
};
</script>

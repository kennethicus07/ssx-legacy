<template>
    <div class="row">
        <!-- Loading Overlay -->
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div>
                        <!-- Tabs -->

                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'company_info',
                                    }"
                                    @click="activeTab = 'company_info'"
                                    data-bs-toggle="tab"
                                    href="#company_info"
                                    role="tab"
                                >
                                    Company Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'product_info',
                                    }"
                                    @click="activeTab = 'product_info'"
                                    data-bs-toggle="tab"
                                    href="#product_info"
                                    role="tab"
                                >
                                    Product Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'contact_info',
                                    }"
                                    @click="activeTab = 'contact_info'"
                                    data-bs-toggle="tab"
                                    href="#contact_info"
                                    role="tab"
                                >
                                    Contact Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'business_info',
                                    }"
                                    @click="activeTab = 'business_info'"
                                    data-bs-toggle="tab"
                                    href="#business_info"
                                    role="tab"
                                >
                                    Business Info
                                </a>
                            </li>

                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active: activeTab === 'order_info',
                                    }"
                                    @click="activeTab = 'order_info'"
                                    data-bs-toggle="tab"
                                    href="#order_info"
                                    role="tab"
                                >
                                    Order Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    :class="{
                                        active:
                                            activeTab === 'docs_requirements',
                                    }"
                                    @click="activeTab = 'docs_requirements'"
                                    data-bs-toggle="tab"
                                    href="#docs_requirements"
                                    role="tab"
                                >
                                    Upload Requirements
                                </a>
                            </li>
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content mt-3">
                            <div
                                class="tab-pane fade"
                                :class="{
                                    show: activeTab === 'company_info',
                                    active: activeTab === 'company_info',
                                }"
                                id="company_info"
                                role="tabpanel"
                            >
                                <company-info-card
                                    v-if="company_info"
                                    :company_info="company_info"
                                    :countries="countries"
                                    :regions="regions"
                                    :disabled_fa="disabled_fa"
                                    @same-as-moa-changed="handleSameAsMoa"
                                    :check_moa_address="check_moa_address"
                                    :validation="$v.company_info"
                                />
                            </div>

                            <div
                                class="tab-pane fade"
                                :class="{
                                    show: activeTab === 'product_info',
                                    active: activeTab === 'product_info',
                                }"
                                id="product_info"
                                role="tabpanel"
                            >
                                <product-info-card
                                    v-if="products"
                                    :products="products"
                                    :product_id="product_id"
                                    :product_info="product_info"
                                    :categories="categories"
                                    :certifications="certifications"
                                    :check-product-cert-others="
                                        check_product_cert_others
                                    "
                                    :permissions="permissions"
                                    @product-image-deleted="productImageDeleted"
                                    @do-product-edit="doProductEdit"
                                    @do-add-product="doAddProduct"
                                    @do-product-delete="doProductDelete"
                                    @do-save-products="doSaveProducts"
                                    @clear-product-form="clearProductForm"
                                    :validation="$v.product_info"
                                />
                            </div>

                            <div
                                class="tab-pane fade"
                                :class="{
                                    show: activeTab === 'contact_info',
                                    active: activeTab === 'contact_info',
                                }"
                                id="contact_info"
                                role="tabpanel"
                            >
                                <contact-info-card
                                    v-if="contact_info"
                                    :contact_info="contact_info"
                                    :disabled_bcp="disabled_bcp"
                                    :countries="countries"
                                    @same-as-bo-changed="handleSameAsBo"
                                    :validation="$v.contact_info"
                                />
                            </div>

                            <div
                                class="tab-pane fade"
                                :class="{
                                    show: activeTab === 'business_info',
                                    active: activeTab === 'business_info',
                                }"
                                id="business_info"
                                role="tabpanel"
                            >
                                <business-info-card
                                    v-if="business_info"
                                    :business_info="business_info"
                                    :business_types="business_types"
                                    :company_sizes="company_sizes"
                                    :annual_sales_volumes="annual_sales_volumes"
                                    :organization_types="organization_types"
                                    :nature_businesses="nature_businesses"
                                    :target_buyers="target_buyers"
                                    :countries="countries"
                                    :certifications="certifications"
                                    :categories="categories"
                                    :sdgs="sdgs"
                                    :inputs_outputs="inputs_outputs"
                                    :production_processes="production_processes"
                                    :topics="topics"
                                    :check-target-others="check_target_others"
                                    :check-nature-business-others="
                                        check_nature_business_others
                                    "
                                    :check-certification-others="
                                        check_certification_others
                                    "
                                    :on-change-industry-rep="
                                        handleOnChangeIndustryRep
                                    "
                                    :check-production-process-others="
                                        check_production_process_others
                                    "
                                    :validation="$v.business_info"
                                    :permissions="permissions"
                                />
                            </div>

                            <div
                                class="tab-pane fade"
                                :class="{
                                    show: activeTab === 'order_info',
                                    active: activeTab === 'order_info',
                                }"
                                id="order_info"
                                role="tabpanel"
                            >
                                <order-info-card
                                    v-if="order_info"
                                    ref="orderInfoCard"
                                    :attendance_info="attendance_info"
                                    :is_startup="this.business_info.start_up"
                                    :packages="packages"
                                    :addOns="addOns"
                                    :order_info="order_info"
                                    :mandatory="mandatory"
                                    :cart="cart"
                                    :addonCart="addonCart"
                                    :additionalFeesCart="additionalFeesCart"
                                    @add-additional-fees="addAdditionalFees"
                                    @delete-additional-fee-cart-item="
                                        deleteAdditionalFeeCartItem
                                    "
                                    :discountCart="discountCart"
                                    @add-discount="addADiscount"
                                    @delete-discount-cart-item="
                                        deleteDiscountCartItem
                                    "
                                    :openAddOnIdx="openAddOnIdx"
                                    :validation="$v.order_info"
                                    :validation_attendance_info="
                                        $v.attendance_info
                                    "
                                    :co_name="this.company_info.co_name"
                                    :business_type="
                                        this.business_info.business_type
                                    "
                                    :permissions="permissions"
                                    :grandTotal="grandTotal"
                                    :format-number-fn="formatNumber"
                                    @toggle-package="togglePackage"
                                    :is-cart-visible-fn="isCartVisible"
                                    :get-filtered-sizes="getFilteredSizes"
                                    @toggle-cart="toggleCart"
                                    @add-to-cart="addToCart"
                                    @toggle-addon-accordion="
                                        toggleAddOnAccordion
                                    "
                                    @add-addon-to-cart="addAddOnToCart"
                                    @add-pitching-add-on-to-cart="
                                        addPitchingAddOnToCart
                                    "
                                    @increase-qty="increaseQty"
                                    @decrease-qty="decreaseQty"
                                    @format-number="formatNumber"
                                    @delete-cart-item="deleteCartItem"
                                    @delete-addon-to-cart="deleteAddOnToCart"
                                    :conforme_reviewed="conforme_reviewed"
                                    @update:conforme_reviewed="
                                        conforme_reviewed = $event
                                    "
                                    @submit-conforme-review="
                                        submitConformeReview
                                    "
                                    :status_conforme_pending_generation="
                                        status_conforme_pending_generation
                                    "
                                    :is_fully_approved_by_reviewer_and_conforme_reviewed="
                                        is_fully_approved_by_reviewer_and_conforme_reviewed
                                    "
                                />
                            </div>
                            <div
                                class="tab-pane fade"
                                :class="{
                                    show: activeTab === 'docs_requirements',
                                    active: activeTab === 'docs_requirements',
                                }"
                                id="docs_requirements"
                                role="tabpanel"
                            >
                                <upload-requirements-card
                                    v-if="docs"
                                    :docs="docs"
                                    :is_foreign="is_foreign"
                                    @delete-doc="handleDeleteDoc"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <h5 class="card-header">Actions</h5>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="d-grid gap-2 mb-2">
                            <button
                                class="btn btn-sm btn-primary mb-2"
                                :disabled="isConformeDisabled"
                                @click="openConforme"
                            >
                                View Conforme
                            </button>

                            <button
                                class="btn btn-sm btn-primary mb-2"
                                :disabled="isRtbDisabled"
                                @click="openRtb"
                            >
                                View RTB
                            </button>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold mb-1">
                                Status
                            </label>
                            <p
                                v-if="attendance_info"
                                :class="`fs-3 p-3 mb-2 text-white ${statusBadge.bg}`"
                            >
                                {{ statusBadge.text }}
                            </p>
                            <p
                                v-else
                                class="fs-3 p-3 mb-2 text-white bg-secondary"
                            >
                                Loading...
                            </p>
                        </div>

                        <div
                            class="col-12 mt-2"
                            v-if="
                                this.status_incomplete &&
                                permissions.can_pending
                            "
                        >
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    v-model="to_pending"
                                    id="flexCheckDefault"
                                />
                                <label
                                    class="form-check-label"
                                    for="flexCheckDefault"
                                >
                                    Set account status to Pending
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    :value="
                                        currentTabData.created_at
                                            ? $moment(
                                                  currentTabData.created_at
                                              ).format('llll')
                                            : ''
                                    "
                                    readonly
                                />
                                <label>Date Created</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    :value="
                                        currentTabData.updated_at
                                            ? $moment(
                                                  currentTabData.updated_at
                                              ).format('llll')
                                            : ''
                                    "
                                    readonly
                                />
                                <label>Date Last Modified</label>
                            </div>
                        </div>

                        <div class="col-12 mb-2" v-if="approver">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="approver"
                                    readonly
                                />
                                <label>Approved By</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2" v-if="reviewer">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="reviewer"
                                    readonly
                                />
                                <label>Reviewed By</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2" v-if="onholder">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="onholder"
                                    readonly
                                />
                                <label>On hold By</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2" v-if="disapprover">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="disapprover"
                                    readonly
                                />
                                <label>Disapproved By</label>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="updater"
                                    readonly
                                />
                                <label>Last Update By</label>
                            </div>
                        </div>
                        <hr class="w-100 mt-3" />

                        <div
                            class="d-grid gap-2 mb-2"
                            v-if="
                                activeTab !== 'product_info' &&
                                permissions.can_edit &&
                                (!status_conforme_pending_generation ||
                                    is_fully_approved_by_reviewer_and_conforme_reviewed)
                            "
                        >
                            <button
                                class="btn btn-success text-white"
                                @click="saveActiveTab"
                            >
                                Update Supplier/Exhibitor Information
                            </button>
                        </div>
                        <!-- <div
                            class="d-grid gap-2 mb-2"
                            v-if="
                                current_status === 1 && permissions.can_revert
                            "
                        >
                            <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doRevertToIncomplete"
                            >
                                Revert to Incomplete
                            </button>
                        </div> -->
                        <!-- <div
                            class="d-grid gap-2 mb-2"
                            v-if="current_status === 0"
                        >
                            <button
                                class="btn btn-success text-white"
                                type="button"
                                @click="doPending"
                            >
                                Set account status to Pending
                            </button>
                        </div> -->
                        <div
                            class="d-grid gap-2 mb-2"
                            v-if="this.status_pending"
                        >
                            <button
                                class="btn btn-success text-white"
                                type="button"
                                @click="doReview"
                                v-if="permissions.can_review"
                            >
                                Review
                            </button>
                            <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doRevertToIncomplete"
                                v-if="permissions.can_revert"
                            >
                                Revert to Incomplete
                            </button>
                        </div>
                        <div
                            class="d-grid gap-2 mb-2"
                            v-if="this.status_reviewed"
                        >
                            <button
                                class="btn btn-success text-white"
                                type="button"
                                @click="doApprove"
                                v-if="permissions.can_approved"
                            >
                                Approve
                            </button>
                            <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doRevertToIncomplete"
                                v-if="permissions.can_revert"
                            >
                                Revert to Incomplete
                            </button>
                            <!-- <button
                                class="btn btn-danger text-white"
                                type="button"
                                @click="doDeny"
                            >
                                Deny
                            </button> -->
                            <!-- <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doHold"
                                v-if="permissions.can_hold"
                            >
                                On hold
                            </button> -->
                        </div>
                        <div
                            class="d-grid gap-2 mb-2"
                            v-if="this.status_onhold"
                        >
                            <button
                                class="btn btn-success text-white"
                                type="button"
                                @click="doApprove"
                                v-if="permissions.can_approved"
                            >
                                Approve
                            </button>
                            <!-- <button
                                class="btn btn-danger text-white"
                                type="button"
                                @click="doDeny"
                            >
                                Deny
                            </button> -->
                        </div>
                        <div
                            v-if="
                                permissions.conforme &&
                                status_conforme_pending_generation
                            "
                            class="d-grid gap-2 mb-2"
                        >
                            <button
                                class="btn btn-success text-white"
                                @click="submitConformeReview(1)"
                                :disabled="
                                    is_fully_approved_by_reviewer_and_conforme_reviewed
                                "
                            >
                                Generate Conforme
                            </button>
                        </div>
                        <div v-if="canResendConforme" class="d-grid gap-2 mb-2">
                            <button
                                class="btn btn-primary text-white"
                                type="button"
                                @click="resendConforme"
                                :disabled="isLoading"
                            >
                                Resend Conforme
                            </button>
                        </div>
                        <div class="d-grid gap-2">
                            <a
                                href="/admin/registration/suppliers"
                                class="btn btn-secondary"
                                role="button"
                                >Back</a
                            >
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
import BlockUI from "vue-blockui";
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";
import Multiselect from "vue-multiselect";
import Vuelidate from "vuelidate";
import {
    required,
    email,
    url,
    numeric,
    requiredIf,
} from "vuelidate/lib/validators";

import CompanyInfoCard from "./cards/CompanyInfoCard.vue";
import ContactInfoCard from "./cards/ContactInfoCard.vue";
import ProductInfoCard from "./cards/ProductInfoCard.vue";
import BusinessInfoCard from "./cards/BusinessInfoCard.vue";
import OrderInfoCard from "./cards/OrderInfoCard.vue";
import UploadRequirementsCard from "./cards/UploadRequirementsCard.vue";

Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);
Vue.use(BlockUI);
Vue.use(Vuelidate);
Vue.use(VueFileAgent);

Vue.directive("limit", {
    bind(el, binding) {
        // Allow shorthand: v-limit="100" or v-limit="{ max: 100, numeric: true }"
        const cfg =
            typeof binding.value === "object" && binding.value !== null
                ? binding.value
                : { max: binding.value };
        const max = parseInt(cfg.max, 10) || 1000;
        const numericOnly = !!cfg.numeric;

        // keep track of composition state (IME) so we don't truncate mid-composition
        el._limit = { composing: false };

        const inputHandler = (e) => {
            if (el._limit.composing) return; // don't interfere while user is composing text (IME)
            let val = el.value || "";
            if (numericOnly) val = val.replace(/\D+/g, "");
            if (val.length > max) val = val.substring(0, max);
            if (el.value !== val) {
                el.value = val;
                // update v-model
                el.dispatchEvent(new Event("input"));
            }
        };

        const pasteHandler = (e) => {
            let paste =
                (e.clipboardData || window.clipboardData).getData("text") || "";
            if (numericOnly) paste = paste.replace(/\D+/g, "");
            const currentVal = el.value || "";
            const availableSpace = max - currentVal.length;
            if (availableSpace <= 0) {
                e.preventDefault();
                return;
            }
            if (paste.length > availableSpace) {
                e.preventDefault();
                el.value = currentVal + paste.substring(0, availableSpace);
                el.dispatchEvent(new Event("input"));
            }
        };

        const onCompositionStart = () => (el._limit.composing = true);
        const onCompositionEnd = (e) => {
            el._limit.composing = false;
            // run a final input check after composition ends
            inputHandler(e);
        };

        el.addEventListener("input", inputHandler);
        el.addEventListener("paste", pasteHandler);
        el.addEventListener("compositionstart", onCompositionStart);
        el.addEventListener("compositionend", onCompositionEnd);

        // Set native maxlength for non-numeric inputs to help mobile/IME UI
        if (!numericOnly && max) {
            try {
                el.setAttribute("maxlength", String(max));
            } catch (e) {
                // ignore if element doesn't support attribute
            }
        }

        // cleanup helper
        el._limit_cleanup = () => {
            el.removeEventListener("input", inputHandler);
            el.removeEventListener("paste", pasteHandler);
            el.removeEventListener("compositionstart", onCompositionStart);
            el.removeEventListener("compositionend", onCompositionEnd);
            delete el._limit;
            delete el._limit_cleanup;
        };
    },
    unbind(el) {
        if (el._limit_cleanup) el._limit_cleanup();
    },
});

export default {
    props: ["id", "event_fair_code"],
    data() {
        return {
            activeTab: "company_info",
            isLoading: false,
            isInitialLoad: true,
            permissions: {},

            msg: "Loading...",
            fair_code: "",
            reviewer: [],
            onholder: [],
            approver: [],
            disapprover: [],
            updater: [],
            company_info: {},
            disabled_fa: false,
            contact_info: {},
            disabled_bcp: false,
            to_pending: 0,
            product_info: {
                prod_name: "",
                prod_details: "",
                prod_images: [],
                prod_images_for_upload: [],
                prod_profiles: [],
                prod_certs: [],
                store_url: "",
                certs_others: "",
            },
            products: [],
            product_id: "",
            business_info: {
                startUpDisabled: false,
                start_up: 0,
                prevBusinessType: "",
                business_type: "",
                prevStartUp: 0,
            },
            business_types: [],
            prevBusinessType: null,
            company_sizes: [],
            annual_sales_volumes: [],
            organization_types: [],
            nature_businesses: [],
            target_buyers: [],
            certifications: [],
            categories: [],
            sdgs: [],
            inputs_outputs: [],
            production_processes: [],
            topics: [],
            countries: [],
            regions: [],
            order_info: {
                packageState: {},
                pitching_competition_selection: [],
            },
            attendance_info: {
                participation_type: null,
                conference_response: null,
                sponsorship_response: null,
                status: 0,
                conforme_review: 0,
                is_rtb_generated: 0,
            },
            conforme_reviewed: 1,
            mandatory: {},
            packages: {},
            cart: [],
            addonCart: [],
            additionalFeesCart: [],
            discountCart: [],
            addOns: [],
            openAddOnIdx: null,
            docs: {},
        };
    },

    components: {
        CompanyInfoCard,
        ContactInfoCard,
        ProductInfoCard,
        BusinessInfoCard,
        OrderInfoCard,
        UploadRequirementsCard,
        Multiselect,
    },
    async mounted() {
        this.isLoading = true;
        try {
            await this.getSupplier(); // wait for supplier/fair_code
            await this.fetchOrderInfo(); // safe to call APIs now
            await this.getCategories();
        } catch (err) {
            console.error(err);
        } finally {
            this.isInitialLoad = false;
            this.isLoading = false;
        }
    },
    created() {
        this.getCountries();
        this.getRegions();
        this.getBusinessTypes();
        this.getCompanySizes();
        this.getAnnualSalesVolumes();
        this.getOrganizationTypes();
        this.getNatureBusinesses();
        this.getTargetBuyers();
        this.getCertifications();
        this.getSdgs();
        this.getInputOuputs();
        this.getProductionProcesses();
        this.getTopics();
    },

    methods: {
        async getSupplier() {
            try {
                const response = await axios.get(
                    `/admin/registration/supplier-information/${this.id}/${this.event_fair_code}`
                );
                const exhibitor = response.data.exhibitor;
                const attendance_info = response.data.attendance_info;
                const order_info = response.data.order_info;
                const business_owner = response.data.business_owner;
                const business_contact_person =
                    response.data.business_contact_person;
                const nature_business = response.data.nature_business || [];
                const category_subcategory =
                    response.data.category_subcategory || [];
                const sdg = response.data.sdg || [];
                const on_input_output = response.data.on_input_output || [];
                const on_production_process =
                    response.data.on_production_process || [];
                const target_buyer = response.data.target_buyer || [];
                const certification = response.data.certification || [];
                const topic_pick = response.data.topic_pick || [];
                this.permissions = response.data.permissions;

                this.products = response.data.products;
                this.fair_code = exhibitor.fair_code;

                this.reviewer = exhibitor.reviewer
                    ? exhibitor.reviewer.name
                    : "";
                this.onholder = exhibitor.onholder
                    ? exhibitor.onholder.name
                    : "";
                this.approver = exhibitor.approver
                    ? exhibitor.approver.name
                    : "";
                this.disapprover = exhibitor.disapprover
                    ? exhibitor.disapprover.name
                    : "";
                this.updater = exhibitor.updater ? exhibitor.updater.name : "";
                // --- COMPANY INFO ---
                this.company_info = {
                    fascia_name: exhibitor.fascia_name || "",
                    co_name: exhibitor.co_name || "",
                    co_email: exhibitor.co_email || "",
                    exhibitor_type: exhibitor.exhibitor_type
                        ? Number(exhibitor.exhibitor_type)
                        : null,

                    last_participated: exhibitor.last_participated_year
                        ? Number(exhibitor.last_participated_year)
                        : null,
                    co_details: exhibitor.co_details || "",
                    mission: exhibitor.mission_statement || "",
                    env_conservation: exhibitor.env_conservation || "",
                    directory_name: exhibitor.directory_name || "",
                    country_code: exhibitor.phone_country_code || "",
                    area_code: exhibitor.phone_area_code || "",
                    phone_no: exhibitor.phone_no || "",
                    country_code_mobile: exhibitor.mobile_country_code || "",
                    mobile_no: exhibitor.mobile_no || "",
                    website: exhibitor.website || "",
                    facebook: exhibitor.facebook || "",
                    twitter: exhibitor.twitter || "",
                    instagram: exhibitor.instagram || "",
                    linkedin: exhibitor.linkedin || "",
                    other_social: exhibitor.other_social || "",
                    fa_country: exhibitor.fa_country || "",
                    fa_state: exhibitor.fa_state || "",
                    fa_city: exhibitor.fa_city || "",
                    fa_region: exhibitor.fa_region || "",
                    fa_street: exhibitor.fa_street || "",
                    fa_zipcode: exhibitor.fa_zipcode || "",
                    same_as_moa: exhibitor.fa_same_as_moa || 0,
                    moa_country: exhibitor.moa_country || "",
                    moa_state: exhibitor.moa_state || "",
                    moa_city: exhibitor.moa_city || "",
                    moa_region: exhibitor.moa_region || "",
                    moa_street: exhibitor.moa_street || "",
                    moa_zipcode: exhibitor.moa_zipcode || "",
                    masthead: response.data.masthead
                        ? [
                              {
                                  name: response.data.masthead.basename,
                                  url: `/storage/exhibitors/mastheads/${response.data.masthead.basename}`,
                                  size: response.data.masthead.filesize || 1234,
                                  type: `image/${response.data.masthead.extension}`,
                                  ext: response.data.masthead.extension,
                              },
                          ]
                        : [],
                    co_logo: response.data.logo
                        ? [
                              {
                                  name: response.data.logo.basename,
                                  url: `/storage/exhibitors/logos/${response.data.logo.basename}`,
                                  size: response.data.logo.filesize || 1234,
                                  type: `image/${response.data.logo.extension}`,
                                  ext: response.data.logo.extension,
                              },
                          ]
                        : [],
                    created_at: exhibitor.created_at || "",
                    updated_at: exhibitor.updated_at || "",
                };

                if (this.company_info.same_as_moa === 1)
                    this.disabled_fa = true;

                // --- CONTACT INFO ---
                this.contact_info = {
                    salutation: business_owner.salutation || "",
                    fname: business_owner.fname || "",
                    lname: business_owner.lname || "",
                    mi: business_owner.mi || "",
                    designation: business_owner.designation || "",
                    email: business_owner.email || "",
                    country_code_mobile_bo: business_owner.country_code || "",
                    mobile_no_bo: business_owner.mobile_no || "",
                    same_as_bo: business_contact_person.same_as_bo || 0,
                    bcp_salutation: business_contact_person.salutation || "",
                    bcp_fname: business_contact_person.fname || "",
                    bcp_lname: business_contact_person.lname || "",
                    bcp_mi: business_contact_person.mi || "",
                    bcp_designation: business_contact_person.designation || "",
                    bcp_email: business_contact_person.email || "",
                    bcp_country_code:
                        business_contact_person.country_code || "",
                    bcp_mobile_no: business_contact_person.mobile_no || "",
                };

                if (this.contact_info.same_as_bo === 1)
                    this.disabled_bcp = true;

                // --- BUSINESS INFO ---
                this.business_info = {
                    business_type: exhibitor.business_type_id || "",
                    start_up: exhibitor.start_up || 0,
                    prevBusinessType: exhibitor.business_type_id || "",
                    prevStartUp: exhibitor.start_up || 0,
                    company_size: exhibitor.company_size_id || "",
                    annual_sales_volume: exhibitor.annual_sales_volume_id || "",
                    organization_type: exhibitor.organization_type_id || "",
                    direct: exhibitor.direct_workers || "",
                    indirect: exhibitor.indirect_workers || "",

                    industry_representation: exhibitor.industry_rep || "",
                    exporting_country_1: exhibitor.ir_country_exporting_1 || "",
                    exporting_country_2: exhibitor.ir_country_exporting_2 || "",
                    exporting_country_3: exhibitor.ir_country_exporting_3 || "",
                    target_country_1: exhibitor.target_country_export_1 || "",
                    target_country_2: exhibitor.target_country_export_2 || "",
                    target_country_3: exhibitor.target_country_export_3 || "",
                    target_buyer: [],
                    nature_business: [],

                    product_promoted: exhibitor.product_promoted || "",
                    certification: [],
                    certification_others: "",
                    category: category_subcategory.map(
                        (c) => c.sub_category_id
                    ),
                    sdg: sdg.map((sg) => sg.sdg_id),
                    input_ouput: on_input_output.map(
                        (io) => io.input_output_id
                    ),
                    production_process: [],
                    production_process_others: "",
                    target_buyer_others: "",
                    nature_business_others: "",
                    sustainability_topics: topic_pick.map((tp) => tp.topic_id),
                };

                target_buyer.forEach((tb) => {
                    this.business_info.target_buyer.push(tb.target_buyer_id);
                    if (tb.target_buyer_id === 6) {
                        this.business_info.target_buyer_others =
                            tb.remarks || "";
                    }
                });

                nature_business.forEach((nb) => {
                    this.business_info.nature_business.push(
                        nb.nature_business_id
                    );
                    if (nb.nature_business_id === 16) {
                        this.business_info.nature_business_others =
                            nb.remarks || "";
                    }
                });

                certification.forEach((c) => {
                    this.business_info.certification.push(c.certification_id);
                    if (c.certification_id === 14) {
                        this.business_info.certification_others =
                            c.remarks || "";
                    }
                });

                on_production_process.forEach((pp) => {
                    this.business_info.production_process.push(
                        pp.production_process_id
                    );
                    if (pp.production_process_id === 3) {
                        this.business_info.production_process_others =
                            pp.other_certification || "";
                    }
                });

                // -- ATTENDANCE INFO --

                this.attendance_info = {
                    participation_type:
                        (attendance_info &&
                            attendance_info.participation_type) ||
                        null,
                    conference_response:
                        attendance_info &&
                        attendance_info.conference_response !== undefined &&
                        attendance_info.conference_response !== null
                            ? attendance_info.conference_response
                            : null,
                    sponsorship_response:
                        attendance_info &&
                        attendance_info.sponsorship_response !== undefined &&
                        attendance_info.sponsorship_response !== null
                            ? attendance_info.sponsorship_response
                            : null,
                    status: (attendance_info && attendance_info.status) || 0,
                    conforme_review:
                        (attendance_info && attendance_info.conforme_review) ||
                        0,
                    conforme_response:
                        (attendance_info &&
                            attendance_info.conforme_response) ||
                        0,
                    is_rtb_generated:
                        (attendance_info && attendance_info.is_rtb_generated) ||
                        0,
                    conforme_file:
                        (attendance_info && attendance_info.conforme_file) || 0,
                    rtb_file:
                        (attendance_info && attendance_info.rtb_file) || 0,
                };

                // -- ORDER INFO --

                this.order_info.pitching_competition_selection =
                    (order_info && order_info.pitching_competition_selection) ||
                    [];

                // --- DOCS ---
                this.docs = {};
                [
                    "doc1",
                    "doc2",
                    "doc3",
                    "doc4",
                    "doc5",
                    "doc6",
                    "doc7",
                    "doc8",
                ].forEach((docKey) => {
                    const docData = response.data[docKey];
                    this.docs[docKey] = docData
                        ? [
                              {
                                  name: docData.basename,
                                  url: response.data[`${docKey}_url`],
                                  size: response.data[`${docKey}_filesize`],
                                  type:
                                      docData.extension === "pdf"
                                          ? "application/pdf"
                                          : "image/" + docData.extension,
                                  ext: docData.extension,
                              },
                          ]
                        : [];
                });
            } catch (error) {
                console.warn("❌ Unable to fetch supplier information.");
            }
        },

        async fetchOrderInfo() {
            await Promise.all([
                this.getCart(),
                this.getCartAdditionalFees(),
                this.getCartDiscount(),
                this.fetchMandatory(),
                this.fetchAddOnRates(),
                this.getAddOnToCart(),
            ]);
        },
        handleSameAsMoa(isChecked) {
            this.disabled_fa = isChecked;
        },
        handleSameAsBo(isChecked) {
            this.disabled_bcp = isChecked;
        },

        handleOnChangeIndustryRep(e) {
            if (e.target.value !== 1) {
                this.business_info.exporting_country_1 = "";
                this.business_info.exporting_country_2 = "";
                this.business_info.exporting_country_3 = "";
                this.$v.business_info.exporting_country_1.$reset();
                this.$v.business_info.exporting_country_2.$reset();
                this.$v.business_info.exporting_country_3.$reset();
            }
        },

        getCountries() {
            axios.get("/api/countries").then((response) => {
                if (response.status === 200) this.countries = response.data;
            });
        },

        getRegions() {
            axios.get("/api/regions").then((response) => {
                if (response.status === 200) this.regions = response.data;
            });
        },

        getBusinessTypes() {
            axios
                .get("/api/active_business_types")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.business_types = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCompanySizes() {
            axios
                .get("/api/company_sizes")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.company_sizes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getAnnualSalesVolumes() {
            axios
                .get("/api/annual_sales_volumes")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.annual_sales_volumes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getOrganizationTypes() {
            axios
                .get("/api/organization_types")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.organization_types = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getNatureBusinesses() {
            axios
                .get("/api/nature_businesses")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.nature_businesses = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTargetBuyers() {
            axios
                .get("/api/target_buyers")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.target_buyers = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCertifications() {
            axios
                .get("/api/certifications")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.certifications = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getCategories() {
            try {
                const response = await axios.get("/api/categories/is-startup", {
                    params: { is_startup: this.business_info.start_up },
                });

                if (response.status === 200) {
                    this.categories = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        getSdgs() {
            axios
                .get("/api/sdg")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.sdgs = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getInputOuputs() {
            axios
                .get("/api/on_input_output")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.inputs_outputs = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getProductionProcesses() {
            axios
                .get("/api/on_production_process")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.production_processes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTopics() {
            axios
                .get("/api/supplier/pick_topics")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.topics = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        productImageDeleted(fileRecord) {
            //console.log(fileRecord)
            if (fileRecord.id) {
                axios
                    .delete("/api/product/photo/delete/" + fileRecord.id)
                    .then((response) => {
                        if (response.status === 200) {
                            return true;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        doProductEdit(id) {
            this.msg = "Checking product. Please wait...";
            this.isLoading = true;
            this.product_info.prod_images = [];
            this.product_info.prod_profiles = [];
            this.product_info.prod_certs = [];
            axios
                .get("/api/product-information/" + id)
                .then((response) => {
                    //console.log(response.data)
                    // this.scrollToTop();
                    this.isLoading = false;
                    this.product_id = response.data.id;
                    this.product_info.prod_name = response.data.name;
                    this.product_info.prod_details = response.data.description;
                    this.product_info.store_url = response.data.store_url;
                    for (
                        var certs = 0;
                        certs < response.data.product_certifications.length;
                        certs++
                    ) {
                        if (
                            response.data.product_certifications[certs][
                                "certification_id"
                            ] === 14
                        ) {
                            this.product_info.certs_others =
                                response.data.product_certifications[certs][
                                    "remarks"
                                ];
                        }
                        this.product_info.prod_certs.push(
                            response.data.product_certifications[certs][
                                "certification_id"
                            ]
                        );
                    }
                    for (
                        var profile = 0;
                        profile < response.data.product_profiles.length;
                        profile++
                    ) {
                        this.product_info.prod_profiles.push(
                            response.data.product_profiles[profile][
                                "sub_category_id"
                            ]
                        );
                    }
                    for (
                        var prod_image = 0;
                        prod_image < response.data.product_images.length;
                        prod_image++
                    ) {
                        this.product_info.prod_images.push({
                            id: response.data.product_images[prod_image]["id"],
                            name: response.data.product_images[prod_image][
                                "image"
                            ],
                            url:
                                "/storage/exhibitors/products/" +
                                response.data.product_images[prod_image][
                                    "image"
                                ],
                            size: response.data.product_images[prod_image][
                                "img_size"
                            ],
                            type: response.data.product_images[prod_image][
                                "img_type"
                            ],
                            ext: response.data.product_images[prod_image][
                                "img_ext"
                            ],
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doAddProduct() {
            // this.scrollToTop();
            this.$v.product_info.$touch();
            if (!this.$v.product_info.$invalid) {
                this.msg = "Saving product. Please wait...";
                this.isLoading = true;
                let formData = new FormData();
                formData.append("event_fair_code", this.fair_code);
                formData.append("user_id", this.id);

                formData.append("product_id", this.product_id);
                formData.append("step", "add_product");
                formData.append("prod_info", JSON.stringify(this.product_info));
                return axios
                    .post("/admin/registration/supplier/store", formData)
                    .then((response) => {
                        this.isLoading = false;
                        Vue.$toast.success("Product successfully saved.", {
                            position: "top-right",
                            onDismiss: this.clearProductForm(),
                        });
                        return true;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },

        doProductDelete(id) {
            this.$swal({
                title: "Are you sure you want to delete this product?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        axios
                            .delete("/api/product/delete/" + id)
                            .then((response) => {
                                if (response.status === 200) {
                                    Vue.$toast.success(
                                        "Product successfully deleted.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.clearProductForm(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },

        doSaveProducts() {
            // this.scrollToTop();
            if (!this.product_id && this.products.length >= 1) {
                let formData = new FormData();
                formData.append("user_id", this.id);
                formData.append("event_fair_code", this.fair_code);
                formData.append("step", "save_product");
                return axios
                    .post("/admin/registration/supplier/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return true;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                Vue.$toast.error("Please add/update product", {
                    position: "top-right",
                });
                return false;
            }
        },

        clearProductForm() {
            this.product_info.prod_name = "";
            this.product_info.prod_details = "";
            this.product_info.prod_images = [];
            this.product_info.prod_images_for_upload = [];
            this.product_info.prod_profiles = [];
            this.product_info.prod_certs = [];
            this.product_info.store_url = "";
            this.product_info.certs_others = "";
            this.product_id = "";
            this.$v.product_info.$reset();
            this.getSupplier();
        },

        async deleteAllDocuments() {
            // this.isLoading = true;
            try {
                await axios.post("/api/supplier/upload-documents/delete-all", {
                    user_id: this.id,
                    fair_code: this.fair_code,
                });
            } catch (e) {
                Vue.$toast.error("Failed to delete all cart items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },

        async handleDeleteDoc(doc) {
            try {
                let formData = new FormData();
                formData.append("user_id", this.id);
                formData.append("doc", `doc_${doc}`);
                const response = await axios.post(
                    "/api/document/delete",
                    formData
                );

                if (response.status === 200) {
                    // console.log(`Deleted doc_${doc} successfully`);
                    // Clear local model so subsequent saves don't re-send the deleted file
                    if (this.docs && this.docs[`doc${doc}`]) {
                        this.docs[`doc${doc}`] = [];
                    }
                    // If using selected file placeholders, clear them too
                    if (
                        this.docs &&
                        this.docs[`doc${doc}_selected`] !== undefined
                    ) {
                        this.docs[`doc${doc}_selected`] = "";
                    }
                }
            } catch (err) {
                console.error(err);
            }
        },

        //Order Information
        async fetchPackages() {
            try {
                const { data, status } = await axios.get(
                    "/api/supplier/packages",
                    {
                        params: {
                            user_id: this.id,
                            is_startup: this.business_info.start_up, // startup flag
                            business_type: this.business_info.business_type,
                            participation_type:
                                this.attendance_info.participation_type,
                        },
                    }
                );

                if (status === 200) {
                    // console.log("✅ Packages fetched:", data);

                    this.packages = data;
                    this.initializePackageState();
                }
            } catch (error) {
                console.error("❌ Error fetching packages:", error);
            }
        },

        async fetchAddOnRates() {
            const businessTypeId = this.business_info.business_type;
            const fairCode = this.fair_code;
            try {
                const response = await axios.get(
                    `/api/supplier/addon-rates/${businessTypeId}/${fairCode}`
                );

                this.addOns = response.data.add_on_rates.map((rate) => ({
                    id: rate.add_on.id,
                    name: rate.add_on.name,
                    unit: rate.add_on.unit,
                    limit_per_exhibitor: rate.add_on.limit_per_exhibitor,
                    notes: rate.add_on.notes,
                    status: rate.add_on.status,
                    rates: [
                        {
                            id: rate.id,
                            currency: rate.currency,
                            cost: rate.cost,
                            status: rate.status,
                        },
                    ],
                    pitching_session_categories:
                        rate.pitching_session_categories || [],
                    selectedCategories: [],
                }));

                // 🧾 Log as a table for debugging
                // console.table(
                //     this.addOns.map((addOn) => ({
                //         AddOn_ID: addOn.id,
                //         Rate_ID: addOn.rates[0].id, // 👈 participation_add_on_rates.id
                //         Name: addOn.name,
                //         Unit: addOn.unit,
                //         Limit: addOn.limit_per_exhibitor,
                //         Currency: addOn.rates[0].currency,
                //         Cost: addOn.rates[0].cost,
                //         Status: addOn.status,
                //     }))
                // );
            } catch (err) {
                console.warn("❌ Failed to fetch add-ons");
            }
        },

        initializePackageState() {
            this.order_info.packageState = {};
            this.packages.forEach((pkg) => {
                this.$set(this.order_info.packageState, pkg.id, {
                    showCart: false,
                    selected_size_id: null,
                    selected_space_id: null,
                    qty: null,
                });
            });
        },

        formatNumber(value) {
            if (!value) return "0";
            return new Intl.NumberFormat("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(value);
        },

        togglePackage(pkgId) {
            const state = this.order_info.packageState[pkgId];
            if (state) {
                state.showCart = false;
                state.selected_space_id = null;
                state.selected_size_id = null;
                state.qty = null;
            }
            // console.log("Reset state for package:", pkgId);
        },

        // toggleCart(pkgId, spaceId) {
        //     // console.log("toggleCart triggered:", pkgId, spaceId);
        //     const state = this.order_info.packageState[pkgId];
        //     state.showCart = true;
        //     state.selected_size_id = null;
        //     state.selected_space_id = spaceId;
        // },

        toggleCart(pkgId, spaceId) {
            // Check if participation type is selected
            if (!this.attendance_info.participation_type) {
                // Show toast error
                Vue.$toast.error("Participation type is required.", {
                    position: "top-right",
                });
                return; // Stop further execution
            }

            // Proceed to toggle cart
            const state = this.order_info.packageState[pkgId];
            state.showCart = true;
            state.selected_size_id = null;
            state.selected_space_id = spaceId;
        },

        isCartVisible(pkgId) {
            return this.order_info.packageState[pkgId]?.showCart;
        },

        // getFilteredSizes(pkg) {
        //     const pkgState = this.order_info.packageState[pkg.id];
        //     if (!pkgState || !pkgState.selected_space_id) return [];

        //     const selectedSpace = pkg.participation_booth_spaces.find(
        //         (space) => space.id === pkgState.selected_space_id
        //     );
        //     if (!selectedSpace || !selectedSpace.filtered_sizes) return [];

        //     // Participation type 1 (existing rule)
        //     if (
        //         this.attendance_info.participation_type == 1 &&
        //         this.business_info.start_up == 0
        //     ) {
        //         return selectedSpace.filtered_sizes.filter((size) => {
        //             const sqm = size.code; // "4sqm" -> 4
        //             return sqm >= 4 && sqm <= 8;
        //         });
        //     }

        //     // Participation type 2 → only 4sqm and 6sqm
        //     if (this.attendance_info.participation_type == 2) {
        //         return selectedSpace.filtered_sizes.filter((size) => {
        //             const sqm = size.code;
        //             return sqm === 4 || sqm === 6;
        //         });
        //     }

        //     return selectedSpace.filtered_sizes;
        // },

        getFilteredSizes(pkg) {
            const pkgState = this.order_info.packageState[pkg.id];

            if (!pkgState || !pkgState.selected_space_id) {
                return [];
            }

            const selectedSpace = pkg.participation_booth_spaces.find(
                (space) => space.id == pkgState.selected_space_id
            );

            if (!selectedSpace || !selectedSpace.filtered_sizes) {
                return [];
            }

            // Group participation
            if (this.attendance_info.participation_type == 2) {
                // Startup space:
                // use filtered_sizes as-is
                if (selectedSpace.type === "startup") {
                    return selectedSpace.filtered_sizes;
                }

                // Regular/default space:
                // only 4sqm and 6sqm
                return selectedSpace.filtered_sizes.filter((size) => {
                    const sqm = Number(size.code);

                    return sqm === 4 || sqm === 6;
                });
            }

            // Regular / startup participation
            return selectedSpace.filtered_sizes;
        },

        // Additional Fees Method
        async getCartAdditionalFees() {
            try {
                const response = await axios.get(
                    "/api/supplier/cart/fetch/additional-fees",
                    {
                        params: {
                            ff_code: this.id, // adjust variable names as needed
                            fair_code: this.fair_code,
                        },
                    }
                );

                // Assign to your component data
                this.additionalFeesCart = response.data.fees ?? [];
            } catch (error) {
                console.error("Error fetching additional fees:", error);
                this.additionalFeesCart = [];
            }
        },

        async addAdditionalFees({ remark, amount }) {
            const payload = {
                ff_code: this.id,
                fair_code: this.fair_code,
                remark,
                amount,
                type: "additional",
                currency: this.mandatory.currency,
            };

            this.isLoading = true;

            try {
                const res = await axios.post(
                    "/admin/registration/supplier/cart/additional-fees/add",
                    payload
                );

                this.isLoading = false;

                if (res.data.success) {
                    Vue.$toast.success("Additional fee added successfully", {
                        position: "top-right",
                    });

                    // ⬇ Refresh additional fee cart
                    await this.getCartAdditionalFees();
                    this.$refs.orderInfoCard.closeFeesModal();
                }
            } catch (err) {
                this.isLoading = false;

                let message = "Failed to add additional fee.";
                if (err.response?.data?.message) {
                    message = err.response.data.message;
                }

                Vue.$toast.error(message, { position: "top-right" });
            }
        },

        async submitConformeReview(conforme_review) {
            const groupValid = await this.validateGroupBooths();
            if (!groupValid) return;

            const individualValid = await this.validateIndividualBooths();
            if (!individualValid) return;

            // Example payload
            const payload = {
                id: this.id,
                fair_code: this.fair_code,
                conforme_reviewed: conforme_review, // 1
                participation_type: this.attendance_info.participation_type,
            };

            // Show SweetAlert Confirmation
            this.$swal({
                title: "Are you sure you want to submit conforme review?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: async (value) => {
                    if (value) {
                        this.isLoading = true;

                        try {
                            const res = await axios.post(
                                "/admin/registration/supplier/conforme-review",
                                payload
                            );

                            this.isLoading = false;

                            if (res.data.success) {
                                Vue.$toast.success(
                                    "Conforme review submitted successfully",
                                    {
                                        position: "top-right",
                                    }
                                );

                                // Optional: update local state/UI
                                this.conforme_reviewed = conforme_review;
                                this.getSupplier();
                            }
                        } catch (err) {
                            this.isLoading = false;

                            let message = "Failed to submit conforme review.";
                            if (err.response?.data?.message) {
                                message = err.response.data.message;
                            }

                            Vue.$toast.error(message, {
                                position: "top-right",
                            });
                        }
                    }
                },
            });
        },
        async resendConforme() {
            this.$swal({
                title: "Resend Conforme?",
                text: "Are you sure you want to resend the conforme email?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-primary text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: async () => {
                    this.isLoading = true;

                    try {
                        const res = await axios.post(
                            "/admin/registration/supplier/resend-conforme",
                            {
                                id: this.id,
                                fair_code: this.fair_code,
                            }
                        );

                        this.isLoading = false;

                        if (res.data.success) {
                            Vue.$toast.success(
                                res.data.message ||
                                    "Conforme resent successfully.",
                                {
                                    position: "top-right",
                                }
                            );
                        } else {
                            Vue.$toast.error(
                                res.data.message ||
                                    "Failed to resend conforme.",
                                {
                                    position: "top-right",
                                }
                            );
                        }
                    } catch (err) {
                        this.isLoading = false;

                        let message = "Failed to resend conforme.";

                        if (err.response?.data?.message) {
                            message = err.response.data.message;
                        }

                        Vue.$toast.error(message, {
                            position: "top-right",
                        });
                    }
                },
            });
        },

        deleteAdditionalFeeCartItem(additionalFeeCartItemId) {
            if (!additionalFeeCartItemId) return;
            this.isLoading = true;
            axios
                .post(
                    "/admin/registration/supplier/cart/additional-fees/delete",
                    {
                        additional_fee_cart_item_id: additionalFeeCartItemId,
                        ff_code: this.id,
                        fair_code: this.fair_code,
                    }
                )
                .then(async (response) => {
                    this.isLoading = false;
                    if (response.data.success) {
                        this.$toast.success(
                            "Additional fee removed from cart.",
                            {
                                position: "top-right",
                            }
                        );
                        await this.getCartAdditionalFees();
                    }
                })
                .catch(() => {
                    this.isLoading = false;
                    this.$toast.error(
                        "Error deleting additional fee cart item."
                    );
                });
        },

        async deleteAllAdditionalFeeCartItems() {
            // this.isLoading = true;
            try {
                await axios.post(
                    "/admin/registration/supplier/cart/additional-fees/delete-all",
                    {
                        user_id: this.id,
                        fair_code: this.fair_code,
                    }
                );
                // await Promise.all([this.getCart(), this.fetchMandatory()]);
                // Vue.$toast.success("All cart items deleted.", {
                //     position: "top-right",
                // });
            } catch (e) {
                Vue.$toast.error("Failed to delete all discount items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },
        //End Additional Fees Method

        //Discount Methods
        async getCartDiscount() {
            try {
                const response = await axios.get(
                    "/api/supplier/cart/fetch/discount",
                    {
                        params: {
                            ff_code: this.id, // adjust variable names as needed
                            fair_code: this.fair_code,
                        },
                    }
                );

                // Assign to your component data
                this.discountCart = response.data.discounts ?? [];
            } catch (error) {
                console.error("Error fetching discounts:", error);
                this.discountCart = [];
            }
        },

        async addADiscount({ remark, amount }) {
            const payload = {
                ff_code: this.id,
                fair_code: this.fair_code,
                remark,
                amount,
                type: "discount",
                currency: this.mandatory.currency,
            };

            this.isLoading = true;

            try {
                const res = await axios.post(
                    "/admin/registration/supplier/cart/discount/add",
                    payload
                );

                this.isLoading = false;

                if (res.data.success) {
                    Vue.$toast.success("Discount added successfully", {
                        position: "top-right",
                    });

                    // ⬇ Refresh additional fee cart
                    await this.getCartDiscount();
                    this.$refs.orderInfoCard.closeDiscountModal();
                }
            } catch (err) {
                this.isLoading = false;

                let message = "Failed to add Discount.";
                if (err.response?.data?.message) {
                    message = err.response.data.message;
                }

                Vue.$toast.error(message, { position: "top-right" });
            }
        },

        deleteDiscountCartItem(discountCartItemId) {
            if (!discountCartItemId) return;
            this.isLoading = true;
            axios
                .post("/admin/registration/supplier/cart/discount/delete", {
                    discount_cart_item_id: discountCartItemId,
                    ff_code: this.id,
                    fair_code: this.fair_code,
                })
                .then(async (response) => {
                    this.isLoading = false;
                    if (response.data.success) {
                        this.$toast.success("Discount removed from cart.", {
                            position: "top-right",
                        });
                        await this.getCartDiscount();
                    }
                })
                .catch(() => {
                    this.isLoading = false;
                    this.$toast.error("Error deleting discount cart item.");
                });
        },

        async deleteAllDiscountCartItems() {
            // this.isLoading = true;
            try {
                await axios.post(
                    "/admin/registration/supplier/cart/discount/delete-all",
                    {
                        user_id: this.id,
                        fair_code: this.fair_code,
                    }
                );
                // await Promise.all([this.getCart(), this.fetchMandatory()]);
                // Vue.$toast.success("All cart items deleted.", {
                //     position: "top-right",
                // });
            } catch (e) {
                Vue.$toast.error("Failed to delete all cart items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },
        //End Discount Methods

        addToCart(pkgId) {
            const state = this.order_info.packageState[pkgId];

            if (!state) {
                Vue.$toast.error("Package state not found.", {
                    position: "top-right",
                });
                return;
            }

            if (!state.selected_space_id) {
                Vue.$toast.error("Please select a booth space.", {
                    position: "top-right",
                });
                return;
            }

            if (!state.selected_size_id) {
                Vue.$toast.error(
                    "Please select a booth size before adding to cart.",
                    { position: "top-right" }
                );
                return;
            }

            const pkg = this.packages.find((pkg) => pkg.id == pkgId);

            if (!pkg) {
                Vue.$toast.error("Package not found.", {
                    position: "top-right",
                });
                return;
            }

            const selectedSpace = (pkg.participation_booth_spaces || []).find(
                (space) => space.id == state.selected_space_id
            );

            if (!selectedSpace) {
                Vue.$toast.error("Please select a booth space.", {
                    position: "top-right",
                });
                return;
            }

            const payload = {
                user_id: this.id,
                package_id: pkgId,
                space_id: state.selected_space_id,
                size_id: state.selected_size_id,
                qty: state.qty,
                fair_code: this.fair_code,
                start_up: this.business_info.start_up,
                participation_type: this.attendance_info.participation_type,
                space_type: selectedSpace.type,
            };

            console.log("ADMIN ADD TO CART:", payload);

            this.isLoading = true;

            axios
                .post("/admin/registration/supplier/cart/add", payload)
                .then(async (response) => {
                    this.isLoading = false;

                    if (!response.data.success) {
                        Vue.$toast.error(response.data.message, {
                            position: "top-right",
                        });
                        return;
                    }

                    if (response.data.cart) {
                        const selections =
                            response.data.cart.participation_selections || [];

                        this.cart = selections.map((item) => ({
                            id: item.id,
                            booth_size_name: item.booth_size_name,
                            booth_amount: item.booth_amount,
                            currency: item.currency,
                            discount: item.discount,
                            discount_remarks: item.discount_remarks,
                            package_title: item.package?.title || "",
                            qty: item.booth_qty,
                            package_sub_title: item.package?.sub_title || "",
                            package_id: item.package_id,
                            space_name: item.space?.name || "",
                            total_participation: item.total_participation,
                            total_amount_due: item.total_amount_due,
                        }));
                    } else {
                        await this.getCart();
                    }

                    if (response.data.mandatory) {
                        this.mandatory = response.data.mandatory;
                    } else {
                        await this.fetchMandatory();
                    }

                    Vue.$toast.success("Item added to cart.", {
                        position: "top-right",
                    });

                    state.selected_space_id = null;
                    state.selected_size_id = null;
                    state.showCart = false;
                    state.qty = null;
                })
                .catch((err) => {
                    this.isLoading = false;

                    console.log("ADD TO CART ERROR:", err.response?.data);

                    let backendMessage = "Failed to add item to cart.";

                    if (
                        err.response &&
                        err.response.data &&
                        err.response.data.message
                    ) {
                        backendMessage = err.response.data.message;
                    }

                    Vue.$toast.error(backendMessage, {
                        position: "top-right",
                    });
                });
        },

        async getCart() {
            try {
                const response = await axios.get(
                    `/api/supplier/cart/fetch/${this.id}/${this.fair_code}`
                );

                if (response.data.success) {
                    // console.log("Cart fetched successfully!");
                    const selections =
                        response.data.cart.participation_selections || [];

                    // Always assign a new array to trigger reactivity
                    this.cart = selections.map((item) => ({
                        id: item.id,
                        booth_size_code: item.booth_size_code,
                        booth_size_name: item.booth_size_name,
                        booth_amount: item.booth_amount,
                        currency: item.currency,
                        discount: item.discount,
                        qty: item.booth_qty,
                        discount_remarks: item.discount_remarks,
                        package_title: item.package?.title || "",
                        package_sub_title: item.package?.sub_title || "",
                        space_name: item.space?.name || "",
                        total_participation: item.total_participation,
                        total_amount_due: item.total_amount_due,
                    }));

                    // console.table(this.cart, [
                    //     "id",
                    //     "package_title",
                    //     "package_sub_title",
                    //     "space_name",
                    //     "currency",
                    //     "booth_amount",
                    //     "discount",
                    //     "discount_remarks",
                    //     "booth_size_name",
                    //     "total_participation",
                    //     "total_amount_due",
                    // ]);
                } else {
                    // If cart is empty or fetch failed, clear the cart array
                    this.cart = [];
                    console.info("Cart:", response.data.message);
                }
            } catch (err) {
                // On error, also clear the cart array to avoid stale data
                this.cart = [];
                console.warn("❌ Error fetching cart:");
            }
        },

        deleteCartItem(cartItemId) {
            if (!cartItemId) return;
            this.isLoading = true;
            axios
                .post("/admin/registration/supplier/cart/delete", {
                    cart_item_id: cartItemId,
                    user_id: this.id,
                    fair_code: this.fair_code,
                })
                .then(async (response) => {
                    if (response.data.success) {
                        // Always refresh cart and mandatory fee after delete
                        await Promise.all([
                            this.getCart(),
                            this.fetchMandatory(),
                        ]);
                        Vue.$toast.success("Item removed from cart.", {
                            position: "top-right",
                        });
                    }
                })
                .catch(() => {
                    this.$toast.open({
                        message: "Error deleting cart item.",
                        type: "error",
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        addAddOnToCart(addOn, idx) {
            if (!addOn.selectedQty || addOn.selectedQty < 1) {
                this.$toast.error("Please enter a valid quantity.", {
                    position: "top-right",
                });
                return;
            }

            // ✅ Get rate ID safely (Vue 2, no optional chaining)
            const rateId =
                addOn.rates && addOn.rates.length && addOn.rates[0].id
                    ? addOn.rates[0].id
                    : null;

            if (!rateId) {
                this.$toast.error("Add-on rate not found.", {
                    position: "top-right",
                });
                return;
            }

            const payload = {
                user_id: this.id,
                participation_addon_rate_id: rateId,
                fair_code: this.fair_code,
                quantity: addOn.selectedQty,
            };

            this.isLoading = true;

            axios
                .post(
                    "/admin/registration/supplier/addon-selection/add",
                    payload
                )
                .then(async (response) => {
                    this.isLoading = false;

                    // ✅ Show backend message if success is false
                    if (!response.data.success) {
                        this.$toast.error(
                            response.data.message || "Failed to add add-on.",
                            {
                                position: "top-right",
                            }
                        );
                        return;
                    }

                    this.$toast.success("Add-on added to cart!", {
                        position: "top-right",
                    });

                    await this.getAddOnToCart();
                    addOn.selectedQty = null;

                    // Update index state and collapse accordion
                    this.openAddOnIdx = null;
                    this.$nextTick(() => {
                        try {
                            const collapseEl = document.getElementById(
                                `collapseAddOn${idx}`
                            );
                            if (collapseEl) {
                                const bsCollapse =
                                    bootstrap.Collapse.getInstance(
                                        collapseEl
                                    ) || new bootstrap.Collapse(collapseEl);
                                bsCollapse.hide();
                            }
                        } catch (e) {
                            console.warn(
                                "Could not programmatically hide add-on collapse",
                                e
                            );
                        }
                    });
                })
                .catch((err) => {
                    this.isLoading = false;

                    const backendMessage =
                        err.response?.data?.message || "Failed to add add-on.";
                    this.$toast.error(backendMessage, {
                        position: "top-right",
                    });

                    // console.error("❌ Add-on error:", err);
                });
        },

        deleteAddOnToCart(addonCartItemId) {
            if (!addonCartItemId) return;
            this.isLoading = true;
            axios
                .post("/admin/registration/supplier/addon-cart/delete", {
                    addon_cart_item_id: addonCartItemId,
                    user_id: this.id,
                    fair_code: this.fair_code,
                })
                .then(async (response) => {
                    this.isLoading = false;
                    if (response.data.success) {
                        this.$toast.success("Add-on removed from cart.", {
                            position: "top-right",
                        });
                        await this.getAddOnToCart();
                        this.order_info.pitching_competition_selection = [];
                    }
                })
                .catch(() => {
                    this.isLoading = false;
                    this.$toast.error("Error deleting add-on cart item.");
                });
        },

        toggleAddOnAccordion(idx) {
            if (this.openAddOnIdx === idx) {
                // Closing the currently open accordion
                this.openAddOnIdx = null;
                if (this.addOns[idx]) this.addOns[idx].selectedQty = null;
            } else {
                // Opening a new accordion, reset all others
                this.addOns.forEach((addOn, i) => {
                    if (i !== idx) addOn.selectedQty = null;
                });
                this.openAddOnIdx = idx;
            }
        },

        isAddOnAccordionOpen(idx) {
            return this.openAddOnIdx === idx;
        },

        addPitchingAddOnToCart(addOn, idx) {
            // ✅ Quantity = number of checked categories
            const selected =
                this.order_info.pitching_competition_selection || [];
            const qty = selected.length;

            if (qty < 1) {
                this.$toast.error("Please select at least one category.", {
                    position: "top-right",
                });
                return;
            }

            // ✅ Get rate ID safely (Vue 2, no optional chaining)
            const rateId =
                addOn.rates && addOn.rates.length && addOn.rates[0].id
                    ? addOn.rates[0].id
                    : null;

            if (!rateId) {
                this.$toast.error("Add-on rate not found.");
                return;
            }

            const payload = {
                user_id: this.id,
                participation_addon_rate_id: rateId,
                fair_code: this.fair_code,
                quantity: qty, // checkbox count
                selected_categories: selected, // category IDs
            };

            this.isLoading = true;

            axios
                .post(
                    "/admin/registration/supplier/addon-pitching-competition-selection/add",
                    payload
                )
                .then(async (response) => {
                    this.isLoading = false;

                    if (!response.data.success) {
                        this.$toast.error(response.data.message, {
                            position: "top-right",
                        });
                        return;
                    }

                    this.$toast.success("Pitching competition saved!", {
                        position: "top-right",
                    });

                    await this.getAddOnToCart();

                    // ✅ Reset only this special add-on state
                    // this.step4.pitching_competition_selection = [];
                    this.openAddOnIdx = null;

                    // Collapse accordion safely
                    this.$nextTick(() => {
                        try {
                            const collapseEl = document.getElementById(
                                `collapseAddOn${idx}`
                            );
                            if (collapseEl) {
                                const bsCollapse =
                                    bootstrap.Collapse.getInstance(
                                        collapseEl
                                    ) || new bootstrap.Collapse(collapseEl);
                                bsCollapse.hide();
                            }
                        } catch (e) {
                            console.warn("Accordion collapse failed", e);
                        }
                    });
                })
                .catch((err) => {
                    this.isLoading = false;

                    if (
                        err.response &&
                        err.response.data &&
                        err.response.data.message
                    ) {
                        this.$toast.error(err.response.data.message, {
                            position: "top-right",
                        });
                    } else {
                        this.$toast.error(
                            "Failed to save pitching competition.",
                            {
                                position: "top-right",
                            }
                        );
                        // console.error("❌ Pitching add-on error:", err);
                    }
                });
        },

        async deleteAllCartItems() {
            // this.isLoading = true;
            try {
                await axios.post(
                    "/admin/registration/supplier/cart/delete-all",
                    {
                        user_id: this.id,
                        fair_code: this.fair_code,
                    }
                );
                // await Promise.all([this.getCart(), this.fetchMandatory()]);
                // Vue.$toast.success("All cart items deleted.", {
                //     position: "top-right",
                // });
            } catch (e) {
                Vue.$toast.error("Failed to delete all cart items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },

        async deleteAllAddOnCartItems() {
            // this.isLoading = true;
            try {
                const response = await axios.post(
                    "/admin/registration/supplier/addon-cart/delete-all",
                    {
                        user_id: this.id,
                        fair_code: this.fair_code,
                    }
                );
                if (response.data.success) {
                    // await this.getAddOnToCart();
                    // Vue.$toast.success("All add-on cart items deleted.", {
                    //     position: "top-right",
                    // });
                    this.order_info.pitching_competition_selection = [];
                } else {
                    Vue.$toast.error(
                        response.data.message ||
                            "Failed to delete all add-on cart items.",
                        {
                            position: "top-right",
                        }
                    );
                }
            } catch (e) {
                Vue.$toast.error("Failed to delete all add-on cart items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },

        async fetchMandatory() {
            try {
                const response = await axios.get(
                    `/api/supplier/mandatory/fetch/${this.id}/${this.fair_code}`
                );

                if (response.data.success) {
                    this.mandatory = response.data.mandatory;
                }
            } catch (err) {
                console.warn("❌ Error fetching mandatory:");
            }
        },
        getAddOnToCart() {
            return axios
                .get(
                    `/api/supplier/addon-cart/fetch/${this.id}/${this.fair_code}`
                )
                .then((response) => {
                    if (response.data.success) {
                        // Save to a new data property, e.g. this.addonCart
                        this.addonCart = response.data.addon_cart || [];
                        // Optionally, log for debugging
                        // console.table(this.addonCart);
                    } else {
                        this.addonCart = [];
                        console.warn(
                            "⚠️ Add-on cart fetch failed:",
                            response.data.message
                        );
                    }
                })
                .catch((err) => {
                    this.addonCart = [];
                    console.warn("❌ Error fetching add-on cart:");
                });
        },

        //Pending
        // doPending() {
        //     this.$swal({
        //         title: "Are you sure you want to mark as Pending this application?",
        //         icon: "question",
        //         showCancelButton: true,
        //         customClass: {
        //             title: "fs-5",
        //             confirmButton: "btn btn-sm btn-success text-white m-1",
        //             cancelButton: "btn btn-sm btn-secondary m-1",
        //         },
        //         buttonsStyling: false,
        //         preConfirm: (value) => {
        //             if (value) {
        //                 this.isLoading = true;
        //                 this.msg = "Pending application...";
        //                 axios
        //                     .get(
        //                         "/admin/registration/pending/" +
        //                             this.id +
        //                             "/application",
        //                         {
        //                             params: {
        //                                 fair_code: this.fair_code,
        //                             },
        //                         }
        //                     )
        //                     .then((response) => {
        //                         if (response.status === 200) {
        //                             this.isLoading = false;
        //                             Vue.$toast.success(
        //                                 "Registration application successfully mark as pending.",
        //                                 {
        //                                     position: "top-right",
        //                                     onDismiss: this.getSupplier(),
        //                                 }
        //                             );
        //                         }
        //                     })
        //                     .catch((error) => {
        //                         console.log(error);
        //                     });
        //             }
        //         },
        //     });
        // },

        // Review
        async doReview() {
            this.$v.order_info.$touch();
            this.$v.docs.$touch();

            if (this.$v.order_info.cart_not_empty.$invalid) {
                Vue.$toast.error(
                    "You must add at least one booth/package to your cart before proceeding.",
                    { position: "top-right" }
                );
                return false;
            }

            if (this.$v.docs.docs_not_empty.$invalid) {
                Vue.$toast.error("Upload requirements are empty.", {
                    position: "top-right",
                });
                return false;
            }

            if (this.$v.order_info.$invalid || this.$v.docs.$invalid) {
                return false;
            }

            if (!this.attendance_info.participation_type) {
                // Show toast error
                Vue.$toast.error("Participation type is required.", {
                    position: "top-right",
                });
                return; // Stop further execution
            }

            const groupValid = await this.validateGroupBooths();
            if (!groupValid) return;

            const individualValid = await this.validateIndividualBooths();
            if (!individualValid) return;

            // ✅ If all validations pass, show the SweetAlert
            this.$swal({
                title: "Are you sure you want to mark as reviewed this application?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: async (value) => {
                    if (value) {
                        this.isLoading = true;
                        this.msg = "Reviewing application...";
                        try {
                            const response = await axios.get(
                                `/admin/registration/review/${this.id}/application`,
                                {
                                    params: {
                                        fair_code: this.fair_code,
                                        participation_type:
                                            this.attendance_info
                                                .participation_type,
                                    },
                                }
                            );

                            if (response.status === 200) {
                                this.isLoading = false;
                                Vue.$toast.success(
                                    "Registration application successfully marked as reviewed.",
                                    {
                                        position: "top-right",
                                        onDismiss: this.getSupplier(),
                                    }
                                );
                            }
                        } catch (error) {
                            console.log(error);
                            this.isLoading = false;
                        }
                    }
                },
            });
        },

        // Revert
        doRevertToIncomplete() {
            this.$swal({
                title: "Are you sure you want to revert back the supplier/exhibitor status to Incomplete?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        this.msg = "Reviewing application...";
                        axios
                            .get(
                                "/admin/registration/reverttoinc/" +
                                    this.id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: this.fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Supplier/Exhibitor status reverted back to Incomplete.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getSupplier(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },

        //Aprrove

        async doApprove() {
            this.$v.order_info.$touch();
            this.$v.docs.$touch();

            if (this.$v.order_info.cart_not_empty.$invalid) {
                Vue.$toast.error(
                    "You must add at least one booth/package to your cart before proceeding.",
                    { position: "top-right" }
                );
                return false;
            }

            if (this.$v.docs.docs_not_empty.$invalid) {
                Vue.$toast.error("Upload requirements are empty.", {
                    position: "top-right",
                });
                return false;
            }

            if (this.$v.order_info.$invalid || this.$v.docs.$invalid) {
                return false;
            }

            if (!this.attendance_info.participation_type) {
                // Show toast error
                Vue.$toast.error("Participation type is required.", {
                    position: "top-right",
                });
                return; // Stop further execution
            }

            const groupValid = await this.validateGroupBooths();
            if (!groupValid) return;

            const individualValid = await this.validateIndividualBooths();
            if (!individualValid) return;

            this.$swal({
                title: "Are you sure you want to approve this application?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        this.msg = "Approving application...";
                        axios
                            .get(
                                "/admin/registration/approve/" +
                                    this.id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: this.fair_code,
                                        participation_type:
                                            this.attendance_info
                                                .participation_type,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully approved.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getSupplier(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },

        //Deny
        doDeny() {
            this.$swal({
                title: "Are you sure you want to deny this application?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        this.msg = "Disapproving application...";
                        axios
                            .get(
                                "/admin/registration/deny/" +
                                    this.id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: this.fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully denied.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getSupplier(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },

        //On hold
        doHold() {
            this.$swal({
                title: "Are you sure you want to on hold this application?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        this.msg = "On holding application...";
                        axios
                            .get(
                                "/admin/registration/onhold/" +
                                    this.id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: this.fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully on hold.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getSupplier(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },

        async handleBusinessInfoResponse(response) {
            const savedBusinessType = response.business_type;
            const savedStartUp = response.start_up;
            const savedParticipationType = response.participation_type;

            const changedBusinessType =
                this.business_info.prevBusinessType !== savedBusinessType;

            const changedStartUp =
                this.business_info.prevStartUp !== savedStartUp;

            if (!changedBusinessType && !changedStartUp) return;

            // wipe cart + docs
            await Promise.all([
                this.deleteAllCartItems(),
                this.deleteAllAddOnCartItems(),
                this.deleteAllDocuments(),
                this.deleteAllAdditionalFeeCartItems(),
                this.deleteAllDiscountCartItems(),
            ]);

            // update values
            this.business_info.business_type = savedBusinessType;
            this.business_info.start_up = savedStartUp;
            this.business_info.prevBusinessType = savedBusinessType;
            this.business_info.prevStartUp = savedStartUp;
            this.attendance_info.participation_type = savedParticipationType;

            // reload dependent data
            await Promise.all([
                this.getSupplier(),
                this.getCart(),
                this.getCartAdditionalFees(),
                this.getCartDiscount(),
                this.fetchPackages(),
                this.fetchMandatory(),
                this.fetchAddOnRates(),
                this.getAddOnToCart(),
            ]);
        },

        handleSaveError(err, tabName) {
            if (err.response?.status === 422 && err.response.data.errors) {
                Object.values(err.response.data.errors).forEach(
                    (fieldErrors) => {
                        fieldErrors.forEach((message) => {
                            this.$toast.error(message, {
                                position: "top-right",
                            });
                        });
                    }
                );
            } else {
                this.$toast.error(
                    `Failed to update '${tabName}' tab information.`,
                    { position: "top-right" }
                );
            }

            console.error(err);
        },

        async checkBusinessInfoChanges() {
            // Compare previous vs current
            const changedBusinessType =
                this.business_info.prevBusinessType !==
                this.business_info.business_type;

            const changedStartUp =
                this.business_info.prevStartUp !== this.business_info.start_up;

            if (!changedBusinessType && !changedStartUp) {
                return true; // No changes → allow saving
            }

            // Show confirmation BEFORE saving
            const result = await this.$swal({
                title: "Changing Business Type / Startup",
                text: "Changing these will reset your cart, add-ons, and documents. Proceed?",
                icon: "warning",
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Yes, proceed",
                cancelButtonText: "No, keep previous settings",
            });

            // User declined evert & block save
            if (!result.isConfirmed) {
                this.business_info.business_type =
                    this.business_info.prevBusinessType;
                this.business_info.start_up = this.business_info.prevStartUp;
                return false;
            }

            return true; // User confirmed  allow save
        },

        // Order Information End

        async saveActiveTab() {
            if (this.activeTab === "company_info") {
                this.$v.company_info.$touch();
                if (this.$v.company_info.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in Company Info.",
                        { position: "top-right" }
                    );
                    return;
                }
            }

            if (this.activeTab === "product_info") {
                this.$v.product_info.$touch();
                if (this.$v.product_info.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in Product Info.",
                        { position: "top-right" }
                    );
                    return;
                }
            }

            if (this.activeTab === "contact_info") {
                this.$v.contact_info.$touch();
                if (this.$v.contact_info.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in Contact Info.",
                        { position: "top-right" }
                    );
                    return;
                }
            }

            if (this.activeTab === "business_info") {
                // 1️⃣ Validate first
                this.$v.business_info.$touch();
                if (this.$v.business_info.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in Business Info.",
                        { position: "top-right" }
                    );
                    return;
                }

                // 2️⃣ Confirm changes with SweetAlert before saving
                const proceed = await this.checkBusinessInfoChanges();
                if (!proceed) {
                    this.isLoading = false;
                    return;
                }
            }

            if (this.activeTab === "order_info") {
                this.$v.order_info.$touch();
                if (this.$v.order_info.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in Order Info.",
                        { position: "top-right" }
                    );
                    return;
                }

                if (!this.attendance_info.participation_type) {
                    // Show toast error
                    Vue.$toast.error("Participation type is required.", {
                        position: "top-right",
                    });
                    return; // Stop further execution
                }

                const groupValid = await this.validateGroupBooths();
                if (!groupValid) return;

                const individualValid = await this.validateIndividualBooths();
                if (!individualValid) return;
            }

            // if (this.activeTab === "docs_requirements") {
            //     this.$v.docs.$touch();
            //     if (this.$v.docs.$invalid) {
            //         this.$toast.error(
            //             "Please complete all required fields in upload requirements Info.",
            //             { position: "top-right" }
            //         );
            //         return;
            //     }
            // }

            this.isLoading = true;

            const formData = new FormData();
            formData.append("user_id", this.id);
            formData.append("event_fair_code", this.fair_code);
            formData.append("to_pending", this.to_pending ? 1 : 0);
            switch (this.activeTab) {
                case "company_info":
                    formData.append("step", Number(1));
                    formData.append(
                        "step1_data",
                        JSON.stringify(this.company_info)
                    );
                    formData.append(
                        "masthead",
                        this.company_info.masthead_selected || ""
                    );
                    formData.append(
                        "logo",
                        this.company_info.co_logo_selected || ""
                    );
                    break;

                case "contact_info":
                    formData.append("step", Number(2));
                    formData.append(
                        "step2_data",
                        JSON.stringify(this.contact_info)
                    );
                    break;

                case "business_info":
                    formData.append("step", Number(3));
                    formData.append(
                        "step3_data",
                        JSON.stringify(this.business_info)
                    );
                    break;

                case "order_info":
                    formData.append("step", Number(4));
                    formData.append(
                        "is_fully_approved_by_reviewer_and_conforme_reviewed",
                        this.is_fully_approved_by_reviewer_and_conforme_reviewed
                    );
                    formData.append(
                        "step4_data",
                        JSON.stringify(this.attendance_info)
                    );
                    break;

                case "docs_requirements":
                    formData.append("step", "finish");
                    for (let i = 1; i <= 8; i++) {
                        const selected = this.docs[`doc${i}_selected`];
                        const removed = this.docs[`doc${i}_removed`];

                        if (selected) {
                            // New uploaded file
                            formData.append(`doc${i}`, selected);
                        } else if (removed) {
                            // Only send delete if user removed existing file
                            formData.append(`doc${i}`, "");
                        }
                        // Otherwise: do nothing → existing file remains
                    }

                    break;
            }
            axios
                .post("/admin/registration/supplier/store", formData)
                .then(async (response) => {
                    if (this.activeTab === "business_info") {
                        await this.handleBusinessInfoResponse(response.data);
                    }

                    await this.getSupplier();
                    this.fetchMandatory();
                    this.isLoading = false;

                    const tabName = this.activeTab.replace("_", " ");
                    this.$toast.success(`${tabName} updated successfully!`, {
                        position: "top-right",
                    });
                })
                .catch((err) => {
                    this.isLoading = false;
                    const tabName = this.activeTab.replace("_", " ");
                    this.handleSaveError(err, tabName);
                });
        },

        async validateGroupBooths() {
            if (this.attendance_info.participation_type !== 2) return true; // Not group, skip

            await this.getCart(); // make sure cart is up-to-date

            try {
                const payload = this.cart.map((item) => ({
                    id: item.id,
                    booth_size_code: item.booth_size_code,
                    qty: item.qty,
                }));

                const res = await axios.post(
                    "/api/supplier/check-group-cart-booth-sizes",
                    { cart: payload }
                );

                if (res.data.has_invalid) {
                    // Display different messages based on the reason
                    switch (res.data.reason) {
                        case "empty_cart":
                            Vue.$toast.error("Your cart is empty.", {
                                position: "top-right",
                            });
                            break;
                        case "invalid_size":
                            Vue.$toast.error("Invalid booth size.", {
                                position: "top-right",
                            });
                            break;
                        case "minimum_not_met":
                            Vue.$toast.error(
                                `Group booths total ${res.data.total_code} sqm. Minimum required: 16 sqm.`,
                                { position: "top-right" }
                            );
                            break;
                        case "invalid_quantity":
                            Vue.$toast.error(
                                "Booth quantity must be more than 1.",
                                {
                                    position: "top-right",
                                }
                            );
                            break;
                        default:
                            Vue.$toast.error(
                                "Group participation validation failed.",
                                { position: "top-right" }
                            );
                    }

                    return false; // validation failed
                }

                return true; // validation passed
            } catch (err) {
                Vue.$toast.error(
                    "Failed to validate booth sizes. Please try again.",
                    { position: "top-right" }
                );
                return false;
            }
        },

        async validateIndividualBooths() {
            if (
                this.attendance_info.participation_type !== 1 ||
                this.business_info.start_up !== 0
            )
                return true; // Not individual non-startup, skip

            await this.getCart(); // make sure cart is up-to-date

            try {
                const payload = this.cart.map((item) => ({
                    id: item.id,
                    booth_size_code: item.booth_size_code,
                    qty: item.qty,
                }));

                const res = await axios.post(
                    "/api/supplier/check-cart-booth-sizes",
                    { cart: payload }
                );

                if (res.data.has_invalid) {
                    // if (res.data.reason === "only_one") {
                    //     Vue.$toast.error("Only 1 booth/package allowed.", {
                    //         position: "top-right",
                    //     });
                    // } else

                    if (res.data.reason === "invalid_size") {
                        Vue.$toast.error("Selected booth is invalid.", {
                            position: "top-right",
                        });
                    } else if (res.data.reason === "invalid_quantity") {
                        Vue.$toast.error("Quantity must be 1.", {
                            position: "top-right",
                        });
                    } else {
                        Vue.$toast.error("Your selection is invalid.", {
                            position: "top-right",
                        });
                    }
                    return false; // validation failed
                }

                return true; // validation passed
            } catch (err) {
                Vue.$toast.error(
                    "Failed to validate booth sizes. Please try again.",
                    { position: "top-right" }
                );
                return false;
            }
        },

        increaseQty(pkgId) {
            const state = this.order_info.packageState[pkgId];
            if (!state.qty) {
                this.$set(state, "qty", 1);
            }
            state.qty++;
        },

        decreaseQty(pkgId) {
            const state = this.order_info.packageState[pkgId];
            if (!state.qty || state.qty <= 1) {
                state.qty = 1;
                return;
            }
            state.qty--;
        },

        /// Conforme
        openConforme() {
            if (this.attendance_info.conforme_file) {
                window.open(
                    `/storage/${this.attendance_info.conforme_file}`,
                    "_blank"
                );
            }
        },

        openRtb() {
            if (this.attendance_info.rtb_file) {
                window.open(
                    `/storage/${this.attendance_info.rtb_file}`,
                    "_blank"
                );
            }
        },
    },
    computed: {
        currentTabData() {
            switch (this.activeTab) {
                case "company_info":
                    return this.company_info;
                case "product_info":
                    return this.company_info;
                case "contact_info":
                    return this.company_info;
                case "business_info":
                    return this.company_info;
                case "order_info":
                    return this.company_info;
                case "docs_requirements":
                    return this.company_info;
                default:
                    return {};
            }
        },
        statusBadge() {
            const status = Number(this.attendance_info?.status ?? 0);
            const conformeReview = Number(
                this.attendance_info?.conforme_review ?? 0
            );
            const conformeResponse = Number(
                this.attendance_info?.conforme_response ?? 0
            );
            const isRtbGenerated = Number(
                this.attendance_info?.is_rtb_generated ?? 0
            );

            console.log("STATUS BADGE DEBUG:", {
                status,
                conformeReview,
                conformeResponse,
                isRtbGenerated,
            });

            if (status === 1) {
                if (conformeReview === 1 && conformeResponse === 1) {
                    if (isRtbGenerated === 1) {
                        return { text: "Generated RTB", bg: "bg-success" };
                    }

                    return { text: "For RTB", bg: "bg-warning" };
                }
                if (conformeReview === 1 && conformeResponse === 0) {
                    return {
                        text: "Awaiting Conforme Response",
                        bg: "bg-primary",
                    };
                }
                return {
                    text: "Pending Conforme Generation",
                    bg: "bg-warning",
                };
            }

            const map = {
                2: { text: "Pending", bg: "bg-info" },
                3: { text: "Reviewed", bg: "bg-primary" },
                4: { text: "On hold", bg: "bg-dark" },
                5: { text: "Denied", bg: "bg-danger" },
                0: { text: "Incomplete", bg: "bg-secondary" },
            };

            return map[status] || { text: "Unknown", bg: "bg-secondary" };
        },

        check_moa_address() {
            return !(
                this.company_info.moa_country &&
                this.company_info.moa_state &&
                this.company_info.moa_city &&
                this.company_info.moa_zipcode
            );
        },

        check_production_process_others() {
            return !(this.business_info.production_process || []).includes(3);
        },

        check_nature_business_others() {
            return !(this.business_info.nature_business || []).includes(16);
        },

        check_target_others() {
            return !(this.business_info.target_buyer || []).includes(6);
        },

        check_certification_others() {
            return !(this.business_info.certification || []).includes(14);
        },
        is_foreign() {
            return this.business_info.business_type === 3;
        },

        check_product_cert_others() {
            return !(this.product_info.prod_certs || []).includes(14);
        },

        cartTotal() {
            const boothTotal = this.cart.reduce(
                (sum, item) => sum + (item.total_amount_due || 0),
                0
            );

            const addOnTotal = this.addonCart.reduce(
                (sum, item) => sum + (item.total_amount_due || 0),
                0
            );

            const additionalFeesTotal =
                this.additionalFeesCart.reduce(
                    (sum, item) => sum + (item.amount || 0),
                    0
                ) || 0;

            const discountTotal =
                this.discountCart.reduce(
                    (sum, item) => sum - (item.amount || 0),
                    0
                ) || 0;

            return (
                boothTotal + addOnTotal + additionalFeesTotal + discountTotal
            );
        },

        grandTotal() {
            const mandatoryPrice =
                this.mandatory && this.mandatory.is_required
                    ? this.mandatory.price
                    : 0;
            return this.cartTotal + mandatoryPrice;
        },

        is_fully_approved_by_reviewer_and_conforme_reviewed() {
            const info = this.attendance_info || {};
            return info.status === 1 && info.conforme_review === 1;
        },

        status_conforme_pending_generation() {
            return (
                this.attendance_info &&
                this.attendance_info.status === 1 &&
                (this.attendance_info.conforme_review === 0 ||
                    this.attendance_info.conforme_review === null)
            );
        },
        status_pending() {
            return this.attendance_info.status === 2;
        },
        status_reviewed() {
            return this.attendance_info.status === 3;
        },
        status_onhold() {
            return this.attendance_info.status === 4;
        },
        status_denied() {
            return this.attendance_info.status === 5;
        },
        status_incomplete() {
            return ![1, 2, 3, 4, 5].includes(this.attendance_info.status);
        },
        isRtbDisabled() {
            return (
                !this.attendance_info ||
                !this.attendance_info.rtb_file ||
                this.attendance_info.is_rtb_generated != 1
            );
        },
        canResendConforme() {
            const info = this.attendance_info || {};

            return (
                this.permissions.can_resend_conforme &&
                Number(info.status) === 1 &&
                Number(info.conforme_review) === 1 &&
                Number(info.conforme_response) === 0
            );
        },

        isConformeDisabled() {
            return (
                !this.attendance_info ||
                !this.attendance_info.conforme_file ||
                this.attendance_info.status != 1
            );
        },
    },
    validations: {
        company_info: {
            exhibitor_type: { required },
            last_participated: {
                required: requiredIf(function () {
                    return Number(this.company_info.exhibitor_type) === 2;
                }),
            },
            fascia_name: { required },
            directory_name: { required },
            website: { url },
            other_social: { url },
            co_details: { required },
            mission: { required },
            country_code: {},
            area_code: { numeric },
            phone_no: {},
            country_code_mobile: { required },
            mobile_no: { required },
            masthead: { required },
            co_logo: { required },
            fa_country: { required },
            fa_state: { required },
            fa_city: { required },
            fa_zipcode: { required, numeric },
            fa_region: {
                required: requiredIf(function () {
                    if (this.company_info.fa_country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            fa_street: {
                required: requiredIf(function () {
                    if (this.company_info.fa_country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            moa_country: { required },
            moa_state: { required },
            moa_city: { required },
            moa_zipcode: { required, numeric },
            moa_region: {
                required: requiredIf(function () {
                    if (
                        this.company_info.moa_country === 148 &&
                        this.disabled_moa === false
                    ) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            moa_street: {
                required: requiredIf(function () {
                    if (this.company_info.moa_country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
        },
        product_info: {
            prod_name: { required },
            prod_details: { required },
            prod_images: { required },
            prod_profiles: { required },
            prod_certs: { required },
            store_url: { url },
            certs_others: {
                required: requiredIf(function () {
                    return this.product_info.prod_certs.includes(14);
                }),
            },
        },
        contact_info: {
            salutation: { required },
            fname: { required },
            lname: { required },

            designation: { required },
            email: { required, email },
            country_code_mobile_bo: { required },
            mobile_no_bo: { required },
            bcp_salutation: { required },
            bcp_fname: { required },
            bcp_lname: { required },
            bcp_designation: { required },
            bcp_email: { required, email },
            bcp_country_code: { required },
            bcp_mobile_no: { required },
        },
        business_info: {
            business_type: { required },
            company_size: { required },
            annual_sales_volume: { required },
            organization_type: { required },
            direct: { required, numeric },
            indirect: { required, numeric },
            nature_business: { required },
            industry_representation: { required },
            exporting_country_1: {
                required: requiredIf(function () {
                    if (this.business_info.industry_representation === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
                isUnique() {
                    if (this.business_info.industry_representation === 1) {
                        const arr_exporting_country = [
                            this.business_info.exporting_country_1,
                            this.business_info.exporting_country_2,
                            this.business_info.exporting_country_3,
                        ];
                        const allUnique = !arr_exporting_country.some(
                            (v, i) => arr_exporting_country.indexOf(v) < i
                        );
                        return allUnique;
                    } else {
                        return true;
                    }
                },
            },
            exporting_country_2: {
                required: requiredIf(function () {
                    if (this.business_info.industry_representation === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            exporting_country_3: {
                required: requiredIf(function () {
                    if (this.business_info.industry_representation === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            target_country_1: {
                required,
                isUnique() {
                    const arr_target_country = [
                        this.business_info.target_country_1,
                        this.business_info.target_country_2,
                        this.business_info.target_country_3,
                    ];
                    const allUnique = !arr_target_country.some(
                        (v, i) => arr_target_country.indexOf(v) < i
                    );
                    return allUnique;
                },
            },
            target_country_2: { required },
            target_country_3: { required },
            target_buyer: { required },
            nature_business_others: {
                required: requiredIf(function () {
                    return this.business_info.nature_business.includes(16);
                }),
            },
            target_buyer_others: {
                required: requiredIf(function () {
                    return this.business_info.target_buyer.includes(6);
                }),
            },
            certification: { required },
            certification_others: {
                required: requiredIf(function () {
                    return this.business_info.certification.includes(14);
                }),
            },
            product_promoted: { required },
            category: { required },
            sdg: { required },
            input_ouput: {},
            production_process: {},
            production_process_others: {
                // required: requiredIf(function () {
                //     return this.business_info.production_process.includes(3);
                // }),
            },
        },
        order_info: {
            cart_not_empty: {
                required: function () {
                    // Custom validator: cart must not be empty
                    return this.cart && this.cart.length > 0;
                },
            },
        },
        docs: {
            docs_not_empty: {
                required() {
                    return Object.values(this.docs).some(
                        (docArray) =>
                            Array.isArray(docArray) && docArray.length > 0
                    );
                },
            },
        },
        attendance_info: {
            participation_type: { required },
            conference_response: { required },
            sponsorship_response: { required },
        },
    },
    watch: {
        "company_info.exhibitor_type"(value) {
            if (Number(value) === 1) {
                this.company_info.last_participated = null;
            }
        },
        "business_info.production_process"(newVal) {
            if (!newVal.includes(3)) {
                this.business_info.production_process_others = "";
            }
        },

        "business_info.target_buyer"(newVal) {
            if (!newVal.includes(6)) {
                this.business_info.target_buyer_others = "";
            }
        },

        "business_info.nature_business"(newVal) {
            if (!newVal.includes(16)) {
                this.business_info.nature_business_others = "";
            }
        },

        "business_info.certification"(newVal) {
            if (!newVal.includes(14)) {
                this.business_info.certification_others = "";
            }
        },

        "product_info.prod_certs"(newVal) {
            if (!newVal.includes(14)) {
                this.product_info.certs_others = "";
            }
        },

        "business_info.business_type": {
            handler(newVal) {
                if (newVal === 3) {
                    this.business_info.start_up = 0; // uncheck
                    this.business_info.startUpDisabled = true; // disable
                } else {
                    this.business_info.startUpDisabled = false; // enable
                }
            },
            immediate: true,
        },

        "business_info.start_up"(newVal, oldVal) {
            // ignore initial loading phase
            if (this.isInitialLoad) return;

            // Only react to actual user change
            if (newVal !== oldVal) {
                this.business_info.category = [];
                this.getCategories();
                this.fetchPackages();
            }
        },

        "attendance_info.participation_type": {
            handler: function (newVal, oldVal) {
                if (this.isInitialLoad) return;

                if (newVal === oldVal) return;

                Object.keys(this.order_info.packageState).forEach((pkgId) => {
                    this.order_info.packageState[pkgId].selected_space_id =
                        null;

                    this.order_info.packageState[pkgId].selected_size_id = null;

                    this.order_info.packageState[pkgId].qty = null;
                });

                // Reload spaces
                this.fetchPackages();
            },
            immediate: false,
        },
        activeTab(newTab) {
            if (newTab === "order_info") {
                this.fetchPackages();
            }
        },
    },
};
</script>

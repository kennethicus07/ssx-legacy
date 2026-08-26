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
                    <!-- Fallback for first-time users -->
                    <div
                        v-if="userNoFairCode"
                        class="alert alert-info text-center py-5"
                    >
                        <h5>Welcome!</h5>
                        <p>
                            It looks like you haven’t joined any events yet. No
                            worries — once you register for an event, your
                            account information will appear here.
                        </p>
                    </div>
                    <div v-else>
                        <!-- Tabs -->

                        <ul class="nav nav-tabs" role="tablist">
                            <!-- Company Info -->
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

                            <li
                                v-if="tab_permissions.product_info.view"
                                class="nav-item"
                            >
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
                            <!-- Contact Info -->
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
                            <!-- Business Info -->
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

                            <li
                                v-if="tab_permissions.order_info.view"
                                class="nav-item"
                            >
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
                            <!-- Docs Requirements -->
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
                                    Uploaded Requirements
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
                                    :status="status"
                                />
                            </div>

                            <div
                                class="tab-pane fade"
                                v-if="tab_permissions.product_info.view"
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
                                    :status="status"
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
                                    :can-action="
                                        tab_permissions.business_info &&
                                        tab_permissions.business_info.edit
                                    "
                                    :status="status"
                                />
                            </div>

                            <div
                                class="tab-pane fade"
                                v-if="tab_permissions.order_info.view"
                                :class="{
                                    show: activeTab === 'order_info',
                                    active: activeTab === 'order_info',
                                }"
                                id="order_info"
                                role="tabpanel"
                            >
                                <order-info-card
                                    v-if="order_info"
                                    :packages="packages"
                                    :addOns="addOns"
                                    :order_info="order_info"
                                    :mandatory="mandatory"
                                    :cart="cart"
                                    :addonCart="addonCart"
                                    :openAddOnIdx="openAddOnIdx"
                                    :validation="$v.order_info"
                                    :co_name="this.company_info.co_name"
                                    :business_type="
                                        this.business_info.business_type
                                    "
                                    :grandTotal="grandTotal"
                                    :format-number-fn="formatNumber"
                                    @toggle-package="togglePackage"
                                    :is-cart-visible-fn="isCartVisible"
                                    :get-filtered-sizes-fn="getFilteredSizes"
                                    @toggle-cart="toggleCart"
                                    @add-to-cart="addToCart"
                                    @toggle-addon-accordion="
                                        toggleAddOnAccordion
                                    "
                                    @add-addon-to-cart="addAddOnToCart"
                                    @format-number="formatNumber"
                                    @delete-cart-item="deleteCartItem"
                                    @delete-addon-to-cart="deleteAddOnToCart"
                                    :status="status"
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
                                    :validation="$v.docs"
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
                        <hr class="w-100 mt-3" />
                        <div class="col-12 mb-2" v-if="!userNoFairCode">
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
                        <div class="col-12 mb-2" v-if="!userNoFairCode">
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
                                <label>Updated At</label>
                            </div>
                        </div>
                        <div
                            class="d-grid gap-2 mb-2"
                            v-if="
                                tab_permissions[activeTab] &&
                                tab_permissions[activeTab].save &&
                                !userNoFairCode &&
                                status === 0
                            "
                        >
                            <button
                                class="btn btn-success text-white"
                                @click="saveActiveTab"
                            >
                                Update
                            </button>
                        </div>

                        <div class="d-grid gap-2">
                            <a
                                href="/supplier"
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

import CompanyInfoCard from "../cards/CompanyInfoCard.vue";
import ContactInfoCard from "../cards/ContactInfoCard.vue";
import ProductInfoCard from "../cards/ProductInfoCard.vue";
import BusinessInfoCard from "../cards/BusinessInfoCard.vue";
import OrderInfoCard from "../cards/OrderInfoCard.vue";
import UploadRequirementsCard from "../cards/UploadRequirementsCard.vue";

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
    props: ["id", "tab_permissions"],
    data() {
        return {
            activeTab: "company_info",
            isLoading: false,
            isInitialLoad: true,
            msg: "Loading...",
            fair_code: "",
            status: 0,
            userNoFairCode: false,
            company_info: {},
            disabled_fa: false,
            contact_info: {},
            disabled_bcp: false,
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

            company_sizes: [],
            annual_sales_volumes: [],
            organization_types: [],
            nature_businesses: [],
            target_buyers: [],
            certifications: [],
            categories: [],
            inputs_outputs: [],
            production_processes: [],
            topics: [],
            countries: [],
            regions: [],
            order_info: { packageState: {} },
            mandatory: {},
            packages: {},
            cart: [],
            addonCart: [],
            addOns: [],
            openAddOnIdx: null,

            docs: {
                doc1: [],
                doc2: [],
                doc3: [],
                doc4: [],
                doc5: [],
                doc6: [],
                doc7: [],
                doc8: [],
                doc1_selected: null,
                doc2_selected: null,
                doc3_selected: null,
                doc4_selected: null,
                doc5_selected: null,
                doc6_selected: null,
                doc7_selected: null,
                doc8_selected: null,
            },
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
            await this.fetchOrderInfo();
            await this.getCategories();
        } catch (err) {
            console.error("Init error:", e);
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
        this.getInputOuputs();
        this.getProductionProcesses();
        this.getTopics();
    },

    methods: {
        async getSupplier() {
            try {
                const response = await axios.get(
                    `/api/supplier/user-information/${this.id}`
                );
                const exhibitor = response.data.exhibitor;
                const latestAttendance = response.data.latest_attendance;

                if (!exhibitor.fair_code) {
                    this.fair_code = null;
                    this.userNoFairCode = true;
                    return;
                } else {
                    this.fair_code = exhibitor.fair_code;
                    this.userNoFairCode = false;
                }

                const business_owner = response.data.business_owner;
                const business_contact_person =
                    response.data.business_contact_person;

                const category_subcategory =
                    response.data.category_subcategory || [];
                const on_input_output = response.data.on_input_output || [];
                const on_production_process =
                    response.data.on_production_process || [];
                const target_buyer = response.data.target_buyer || [];
                const nature_business = response.data.nature_business || [];
                const certification = response.data.certification || [];
                const topic_pick = response.data.topic_pick || [];

                this.products = response.data.products;
                this.fair_code = exhibitor.fair_code;
                this.status = latestAttendance.status || 0;

                // --- COMPANY INFO ---
                this.company_info = {
                    co_name: exhibitor.co_name || "",
                    co_email: exhibitor.co_email || "",
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
                    fname: business_owner.fname || "",
                    lname: business_owner.lname || "",
                    mi: business_owner.mi || "",
                    designation: business_owner.designation || "",
                    email: business_owner.email || "",
                    country_code_mobile_bo: business_owner.country_code || "",
                    mobile_no_bo: business_owner.mobile_no || "",
                    same_as_bo: business_contact_person.same_as_bo || 0,
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
                    input_ouput: on_input_output.map(
                        (io) => io.input_output_id
                    ),
                    production_process: [],
                    production_process_others: "",
                    target_buyer_others: "",
                    nature_business_others: "",
                    sustainability_topics: topic_pick.map((tp) => tp.topic_id),
                };

                // console.log(
                //     "prevBusiness: ",
                //     this.business_info.prevBusinessType
                // );
                // console.log("prevStartUp", this.business_info.prevStartUp);
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

                // --- DOCS ---

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
                    if (docData) {
                        this.docs[docKey] = [
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
                        ];
                        this.docs[`${docKey}_selected`] = null; // optional: or store actual file if needed
                    } else {
                        this.docs[docKey] = [];
                        this.docs[`${docKey}_selected`] = null;
                    }
                });
            } catch (error) {
                console.warn("❌ Unable to fetch supplier information.");
                this.userNoFairCode = true;
            }
        },

        async fetchOrderInfo() {
            await Promise.all([
                this.getCart(),
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
                    .post("/supplier/account-information/store", formData)
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
                    .post("/supplier/account-information/store", formData)
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
                        },
                    }
                );

                if (status === 200) {
                    // console.log("✅ Packages fetched:", data);

                    // Optional: detailed view
                    data.forEach((pkg) => {
                        // console.log(`📦 Package: ${pkg.title} (ID: ${pkg.id})`);

                        pkg.participation_booth_spaces.forEach((space) => {
                            // console.log(
                            //     `  🏢 Space ID ${space.id} [${space.booth_min_size}-${space.booth_max_size}]`
                            // );

                            if (
                                space.filtered_sizes &&
                                space.filtered_sizes.length > 0
                            ) {
                                // console.table(space.filtered_sizes);
                            } else {
                                // console.warn(
                                //     `  ⚠️ No filtered sizes for space ${space.id}`
                                // );
                            }
                        });
                    });

                    this.packages = data;
                    this.initializePackageState();
                }
            } catch (error) {
                // console.error("❌ Error fetching packages:", error);
            }
        },

        async fetchAddOnRates() {
            if (
                !this.fair_code ||
                !this.business_info.business_type ||
                this.userNoFairCode
            ) {
                this.addOns = [];
                return;
            }

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
                }));

                // 🧾 Log as a table for debugging
                // console.table(
                //     this.addOns.map((addOn) => ({
                //         AddOn_ID: addOn.id,
                //         Rate_ID: addOn.rates[0].id,
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
            }
            // console.log("Reset state for package:", pkgId);
        },

        toggleCart(pkgId, spaceId) {
            // console.log("toggleCart triggered:", pkgId, spaceId);
            const state = this.order_info.packageState[pkgId];
            state.showCart = true;
            state.selected_size_id = null;
            state.selected_space_id = spaceId;
        },

        isCartVisible(pkgId) {
            return this.order_info.packageState[pkgId]?.showCart;
        },

        getFilteredSizes(pkg) {
            var pkgState = this.order_info.packageState[pkg.id];
            if (!pkgState || !pkgState.selected_space_id) {
                return [];
            }

            // Find the selected space
            var selectedSpace = pkg.participation_booth_spaces.find(function (
                space
            ) {
                return space.id === pkgState.selected_space_id;
            });

            if (selectedSpace && selectedSpace.filtered_sizes) {
                return selectedSpace.filtered_sizes;
            }

            return [];
        },

        addToCart(pkgId) {
            const state = this.order_info.packageState[pkgId];
            if (!state.selected_size_id) {
                Vue.$toast.error(
                    "Please select a booth size before adding to cart.",
                    { position: "top-right" }
                );
                return;
            }

            const payload = {
                user_id: this.id,
                package_id: pkgId,
                space_id: state.selected_space_id,
                size_id: state.selected_size_id,
                fair_code: this.fair_code,
            };

            this.isLoading = true;

            axios
                .post("/api/supplier/cart/add", payload)
                .then(async (response) => {
                    this.isLoading = false;
                    if (response.data.success) {
                        // If API returns updated cart and/or mandatory, use them directly for efficiency
                        if (response.data.cart) {
                            const selections =
                                response.data.cart.participation_selections ||
                                [];
                            this.cart = selections.map((item) => ({
                                id: item.id,
                                booth_size_name: item.booth_size_name,
                                booth_amount: item.booth_amount,
                                currency: item.currency,
                                discount: item.discount,
                                discount_remarks: item.discount_remarks,
                                package_title: item.package?.title || "",
                                package_sub_title:
                                    item.package?.sub_title || "",
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
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    console.error("Error adding to cart:", err);
                    Vue.$toast.error("Failed to add item to cart.", {
                        position: "top-right",
                    });
                });

            // Reset after add
            state.selected_space_id = null;
            state.selected_size_id = null;
            state.showCart = false;
        },

        async getCart() {
            if (!this.fair_code || this.userNoFairCode) {
                this.cart = [];
                return;
            }

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
                        booth_size_name: item.booth_size_name,
                        booth_amount: item.booth_amount,
                        currency: item.currency,
                        discount: item.discount,
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
                    // console.info("Cart:", response.data.message);
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
                .post("/api/supplier/cart/delete", {
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

            // ✅ No optional chaining — classic check for Vue 2
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
                quantity: addOn.selectedQty,
            };

            this.isLoading = true;
            axios
                .post("/api/supplier/addon-selection/add", payload)
                .then(async (response) => {
                    this.isLoading = false;
                    if (response.data.success) {
                        this.$toast.success("Add-on added to cart!", {
                            position: "top-right",
                        });

                        await this.getAddOnToCart();
                        addOn.selectedQty = null;

                        // update our local index state so button class updates
                        this.openAddOnIdx = null;

                        // also programmatically collapse the Bootstrap collapse element
                        // because Bootstrap's JS toggles the 'show' class itself and
                        // changing Vue state alone won't remove it.
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
                                // ignore if bootstrap is not available or something fails
                                console.warn(
                                    "Could not programmatically hide add-on collapse",
                                    e
                                );
                            }
                        });
                    }
                })
                .catch((err) => {
                    this.isLoading = false;

                    // ✅ Check if backend sent a message
                    if (
                        err.response &&
                        err.response.data &&
                        err.response.data.message
                    ) {
                        this.$toast.error(err.response.data.message, {
                            position: "top-right",
                        });
                        console.info(
                            "⚠️ Add-on request warning:",
                            message,
                            "\nFull response:",
                            err.response
                        );
                    } else {
                        this.$toast.error("Failed to add add-on.", {
                            position: "top-right",
                        });

                        // Log error details for debugging
                        console.warn("❌ Unexpected add-on error:", err);
                    }

                    console.error(err);
                });
        },

        deleteAddOnToCart(addonCartItemId) {
            if (!addonCartItemId) return;
            this.isLoading = true;
            axios
                .post("/api/supplier/addon-cart/delete", {
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

        async deleteAllCartItems() {
            // this.isLoading = true;
            try {
                await axios.post("/api/supplier/cart/delete-all", {
                    user_id: this.id,
                    fair_code: this.fair_code,
                });
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
                    "/api/supplier/addon-cart/delete-all",
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
            if (!this.fair_code || this.userNoFairCode) {
                this.mandatory = [];
                return Promise.resolve();
            }

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
            if (!this.fair_code || this.userNoFairCode) {
                // User has no fair code, skip fetching
                this.addonCart = [];
                return Promise.resolve(); // optional, keeps it async-safe
            }

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
                this.$v.business_info.$touch();
                if (this.$v.business_info.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in Business Info.",
                        { position: "top-right" }
                    );
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
            }
            if (this.activeTab === "docs_requirements") {
                this.$v.docs.$touch();
                if (this.$v.docs.$invalid) {
                    this.$toast.error(
                        "Please complete all required fields in upload requirements Info.",
                        { position: "top-right" }
                    );
                    return;
                }
            }

            this.isLoading = true;

            const formData = new FormData();
            formData.append("user_id", this.id);
            formData.append("event_fair_code", this.fair_code);

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
                .post("/supplier/account-information/store", formData)
                .then(async (response) => {
                    if (this.activeTab === "business_info") {
                        const savedBusinessType = response.data.business_type;
                        const savedStartUp = response.data.start_up;

                        // console.log("savedBusinessType:", savedBusinessType);
                        // console.log("savedStartUp:", savedStartUp);

                        const changedBusinessType =
                            this.business_info.prevBusinessType !==
                            savedBusinessType;

                        const changedStartUp =
                            this.business_info.prevStartUp !== savedStartUp;

                        if (changedBusinessType || changedStartUp) {
                            // Wipe cart + docs when user changes business type or startup
                            await Promise.all([
                                this.deleteAllCartItems(),
                                this.deleteAllAddOnCartItems(),
                                this.deleteAllDocuments(),
                            ]);

                            // update tracked values
                            this.business_info.business_type =
                                savedBusinessType;
                            this.business_info.start_up = savedStartUp;
                            this.business_info.prevBusinessType =
                                savedBusinessType;
                            this.business_info.prevStartUp = savedStartUp;

                            // reload dependent data
                            await Promise.all([
                                this.getCart(),
                                this.fetchPackages(),
                                this.fetchMandatory(),
                                this.fetchAddOnRates(),
                                this.getAddOnToCart(),
                            ]);
                        }
                    }

                    await this.getSupplier();
                    this.fetchMandatory();
                    this.isLoading = false;
                    const tabName = this.activeTab.replace("_", " ");
                    this.$toast.success(
                        `${tabName} info updated successfully!`,
                        { position: "top-right" }
                    );
                })
                .catch((err) => {
                    this.isLoading = false;
                    const tabName = this.activeTab.replace("_", " ");

                    if (
                        err.response?.status === 422 &&
                        err.response.data.errors
                    ) {
                        const errors = err.response.data.errors;

                        // Show each field error as its own toast
                        Object.values(errors).forEach((fieldErrors) => {
                            fieldErrors.forEach((message) => {
                                this.$toast.error(message, {
                                    position: "top-right",
                                });
                            });
                        });
                    } else {
                        this.$toast.error(
                            `Failed to update '${tabName}' tab information.`,
                            { position: "top-right" }
                        );
                    }

                    console.error(err);
                });
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

        check_target_others() {
            return !(this.business_info.target_buyer || []).includes(6);
        },

        check_nature_business_others() {
            return !(this.business_info.nature_business || []).includes(16);
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
            // Sum booth/package total + add-on total
            const boothTotal = this.cart.reduce(
                (sum, item) => sum + (item.total_amount_due || 0),
                0
            );
            const addOnTotal = this.addonCart.reduce(
                (sum, item) => sum + (item.total_amount_due || 0),
                0
            );
            return boothTotal + addOnTotal;
        },
        grandTotal() {
            const mandatoryPrice = this.mandatory?.price || 0;
            return this.cartTotal + mandatoryPrice;
        },
    },
    validations: {
        company_info: {
            directory_name: { required },
            website: { url },
            other_social: { url },
            co_details: { required },
            mission: { required },
            env_conservation: { required },
            country_code: { required },
            area_code: { required, numeric },
            phone_no: { required },
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
            store_url: { required, url },
            certs_others: {
                required: requiredIf(function () {
                    return this.product_info.prod_certs.includes(14);
                }),
            },
        },
        contact_info: {
            fname: { required },
            lname: { required },
            mi: { required },
            designation: { required },
            email: { required, email },
            country_code_mobile_bo: { required },
            mobile_no_bo: { required },
            bcp_fname: { required },
            bcp_mi: { required },
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
            input_ouput: { required },
            production_process: { required },
            production_process_others: {
                required: requiredIf(function () {
                    return this.business_info.production_process.includes(3);
                }),
            },
        },
        order_info: {
            banner_size: { required },
            cart_not_empty: {
                required: function () {
                    // Custom validator: cart must not be empty
                    return this.cart && this.cart.length > 0;
                },
            },
        },
        docs: {
            doc1: {
                required: requiredIf(function () {
                    return (
                        this.business_info.start_up !== 1 &&
                        this.business_info.business_type !== 3
                    );
                }),
            },
            doc2: {
                required: requiredIf(function () {
                    return (
                        this.business_info.start_up !== 1 &&
                        this.business_info.business_type !== 3
                    );
                }),
            },
            doc3: {
                required: requiredIf(function () {
                    return (
                        this.business_info.start_up !== 1 &&
                        this.business_info.business_type !== 3
                    );
                }),
            },
            doc4: {
                required: requiredIf(function () {
                    return this.business_info.business_type !== 3;
                }),
            },
            doc5: {
                required: requiredIf(function () {
                    return this.business_info.business_type !== 3;
                }),
            },
            doc6: { required },
            doc7: {
                required: requiredIf(function () {
                    return this.business_info.business_type === 3;
                }),
            },
            doc8: {
                required: requiredIf(function () {
                    return this.business_info.business_type === 3;
                }),
            },
        },
    },
    watch: {
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
                this.$v.docs.$reset();
                this.business_info.category = [];
                this.getCategories();
            }
        },

        "product_info.prod_certs"(newVal) {
            if (!newVal.includes(14)) {
                this.product_info.certs_others = "";
            }
        },
    },
};
</script>

<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Product/Service Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="text-left mb-1 mt-4">
                                <h1 class="h3">Product/Service Information</h1>
                                <p>*Required</p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Product/Service Name*</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-capitalize"
                                        :class="{
                                            'is-invalid':
                                                $v.prod_info.prod_name.$error,
                                        }"
                                        v-model="prod_info.prod_name"
                                        v-limit="{ max: 95 }"
                                    />
                                    <div v-if="$v.prod_info.prod_name.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !$v.prod_info.prod_name.required
                                            "
                                        >
                                            Product name is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Brief Product/Service
                                        Description*</label
                                    >
                                    <textarea
                                        class="form-control beige-bg"
                                        rows="3"
                                        v-model="prod_info.prod_details"
                                        v-limit="{ max: 2000 }"
                                        :class="{
                                            'is-invalid':
                                                $v.prod_info.prod_details
                                                    .$error,
                                        }"
                                    ></textarea>
                                    <div
                                        v-if="$v.prod_info.prod_details.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !$v.prod_info.prod_details
                                                    .required
                                            "
                                        >
                                            Product/Service description is
                                            required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Product/Service Photo/s*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgentProducts"
                                        :multiple="true"
                                        :deletable="true"
                                        :linkable="false"
                                        :meta="false"
                                        :accept="'image/*'"
                                        :maxSize="'1MB'"
                                        :maxFiles="5"
                                        :helpText="'Choose product images'"
                                        v-model="prod_info.prod_images"
                                        @beforedelete="
                                            onBeforeDeleteProduct($event)
                                        "
                                        @select="onSelectProduct($event)"
                                        @delete="productImageDeleted($event)"
                                    ></VueFileAgent>
                                    <div class="form-text">
                                        Please upload upto five (5) clear photos
                                        of your product/service. Preferably
                                        1080x1080 px (1:1 ratio) with max. of
                                        1MB per file.
                                    </div>
                                    <div v-if="$v.prod_info.prod_images.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !$v.prod_info.prod_images
                                                    .required
                                            "
                                        >
                                            Please upload a product/service
                                            photo.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h4>Product/Service Profile*</h4>
                                    <div
                                        v-if="$v.prod_info.prod_profiles.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !$v.prod_info.prod_profiles
                                                    .required
                                            "
                                        >
                                            Product/Service profile is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div
                                            class="col-md-6"
                                            v-for="category in categories"
                                            :key="category.id"
                                        >
                                            <div
                                                class="card m-0 h-100 beige-bg"
                                            >
                                                <div class="card-body">
                                                    <h4>{{ category.name }}</h4>
                                                    <div
                                                        class="form-check"
                                                        v-for="subcategory in category.sub_categories"
                                                        :key="subcategory.id"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            :id="
                                                                'prod_sub_categories_' +
                                                                subcategory.id
                                                            "
                                                            :value="
                                                                subcategory.id
                                                            "
                                                            v-model="
                                                                prod_info.prod_profiles
                                                            "
                                                        />
                                                        <label
                                                            class="form-check-label align-middle"
                                                            :for="
                                                                'prod_sub_categories_' +
                                                                subcategory.id
                                                            "
                                                            >{{
                                                                subcategory.name
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <div
                                                class="row justify-content-start"
                                            >
                                                <div class="col-12">
                                                    <h4>Certifications*</h4>
                                                    <div
                                                        v-if="
                                                            $v.prod_info
                                                                .prod_certs
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !$v.prod_info
                                                                    .prod_certs
                                                                    .required
                                                            "
                                                        >
                                                            Certifications is
                                                            required.
                                                        </div>
                                                    </div>
                                                    <div
                                                        v-if="
                                                            $v.prod_info
                                                                .certs_others
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !$v.prod_info
                                                                    .certs_others
                                                                    .required
                                                            "
                                                        >
                                                            Please specify other
                                                            certfication.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-4"
                                                    v-for="cert in certifications"
                                                    :key="cert.id"
                                                >
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input"
                                                            v-model="
                                                                prod_info.prod_certs
                                                            "
                                                            :value="cert.id"
                                                            :id="
                                                                'prod_certification_' +
                                                                cert.id
                                                            "
                                                        />
                                                        <div
                                                            v-if="
                                                                cert.id === 14
                                                            "
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <label
                                                                    class="form-check-label m-0 p-0 align-middle"
                                                                    :for="
                                                                        'prod_certification_' +
                                                                        cert.id
                                                                    "
                                                                    >Others,&nbsp;</label
                                                                >
                                                                <input
                                                                    id="certs_others"
                                                                    class="form-control form-control-sm w-75 border-bottom"
                                                                    :class="{
                                                                        'is-invalid':
                                                                            $v
                                                                                .prod_info
                                                                                .certs_others
                                                                                .$error,
                                                                    }"
                                                                    type="text"
                                                                    placeholder="please specify"
                                                                    v-limit="{
                                                                        max: 95,
                                                                    }"
                                                                    v-model="
                                                                        prod_info.certs_others
                                                                    "
                                                                    :readonly="
                                                                        check_prod_cert_others
                                                                    "
                                                                />
                                                            </div>
                                                        </div>
                                                        <label
                                                            v-else
                                                            class="form-check-label mb-0 align-middle"
                                                            :for="
                                                                'prod_certification_' +
                                                                cert.id
                                                            "
                                                            >{{
                                                                cert.name
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Online Store Link*</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        
                                        :class="{
                                            'is-invalid':
                                                $v.prod_info.store_url.$error,
                                        }"
                                        v-limit="{ max: 200 }"
                                        v-model="prod_info.store_url"
                                        placeholder="https://www.lazada.com.ph/shop/storename"
                                    />
                                    <div v-if="$v.prod_info.store_url.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.prod_info.store_url.url"
                                        >
                                            Invalid online store link.
                                        </div>
                                    </div>
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
                                    v-if="product_id"
                                    type="button"
                                    class="btn btn-success text-white"
                                    @click="doAddProduct"
                                >
                                    Add Product/Service Information
                                </button>
                                <button
                                    v-else
                                    type="button"
                                    class="btn btn-success text-white"
                                    @click="doAddProduct"
                                >
                                    Add Product/Service
                                </button>
                            </div>
                            <div class="d-grid gap-2 mb-2">
                                <button
                                    class="btn btn-danger text-white"
                                    type="button"
                                    @click="doProductDelete(product.id)"
                                >
                                    Delete
                                </button>
                            </div>
                            <div class="d-grid gap-2">
                                <a
                                    href="/supplier/products/"
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
    </div>
</template>
<script>
import Vuelidate from "vuelidate";
import {
    required,
    email,
    url,
    numeric,
    requiredIf,
} from "vuelidate/lib/validators";
import BlockUI from "vue-blockui";
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

Vue.use(require("vue-moment"));
Vue.use(BlockUI);
Vue.use(Vuelidate);
Vue.use(VueFileAgent);
Vue.use(VueSweetalert2);
Vue.use(VueToast);

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
    props: ["params"],
    data() {
        return {
            isLoading: false,
            msg: "Adding product. Please wait...",
            categories: [],
            certifications: [],
            products: [],

            supplier_id: this.params.supplier_id,
            prod_info: {
                prod_name: "",
                prod_created_at: "",
                prod_updated_at: "",
                prod_status: "",
                prod_details: "",
                prod_images: [],
                prod_images_for_upload: [],
                prod_profiles: [],
                prod_certs: [],
                store_url: "",
                certs_others: "",
            },
        };
    },
    computed: {
        check_prod_cert_others() {
            if (this.prod_info.prod_certs.includes(14) === true) {
                this.$nextTick(() => {
                    document.getElementById("certs_others").focus();
                });
                return false;
            } else {
                this.prod_info.certs_others = "";
                return true;
            }
        },
    },
    validations: {
        prod_info: {
            prod_name: { required },
            prod_details: { required },
            prod_images: { required },
            prod_profiles: { required },
            prod_certs: { required },
            store_url: {  url },
            certs_others: {
                required: requiredIf(function () {
                    return this.prod_info.prod_certs.includes(14);
                }),
            },
        },
    },
    mounted() {},
    created() {
        this.getCategories();
        this.getCertifications();
    },
    methods: {
        doAddProduct() {
            this.scrollToTop();
            this.$v.prod_info.$touch();

            if (!this.$v.prod_info.$invalid) {
                this.isLoading = true;
                this.msg = "Saving product. Please wait...";

                let formData = new FormData();
                formData.append("supplier_id", this.supplier_id);

                formData.append("step", "add_product");
                formData.append("prod_info", JSON.stringify(this.prod_info));

                axios
                    .post("/api/supplier/product/add", formData)
                    .then((response) => {
                        this.isLoading = false;

                        // Show success toast
                        this.$toast.success("Product successfully saved.", {
                            position: "top-right",
                        });

                        // Refresh product data from server
                        this.getUserInfo();
                    })
                    .catch((err) => {
                        this.isLoading = false;
                        this.$toast.error("Failed to save product.", {
                            position: "top-right",
                        });
                    });

                return true;
            } else {
                return false;
            }
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
        getCategories() {
            axios
                .get("/api/categories")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.categories = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onSelectProduct(fileRecordsNewlySelected) {
            var validFileRecords = fileRecordsNewlySelected.filter(
                (fileRecord) => !fileRecord.error
            );
            this.prod_info.prod_images_for_upload =
                this.prod_info.prod_images_for_upload.concat(validFileRecords);
        },
        onBeforeDeleteProduct(fileRecord) {
            //console.log(fileRecord);
            var i = this.prod_info.prod_images_for_upload.indexOf(fileRecord);
            //console.log(i)
            if (i !== -1) {
                // queued file, not yet uploaded. Just remove from the arrays
                this.prod_info.prod_images_for_upload.splice(i, 1);
                var k = this.prod_info.prod_images.indexOf(fileRecord);
                if (k !== -1) this.prod_info.prod_images.splice(k, 1);
            } else {
                if (
                    confirm(
                        "Are you sure you want to delete this product/service photo?"
                    )
                ) {
                    this.$refs.vueFileAgentProducts.deleteFileRecord(
                        fileRecord
                    ); // will trigger 'delete' event
                }
            }
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
        scrollToTop() {
            window.scroll({ top: 300, behavior: "smooth" });
        },
    },
};
</script>
<style></style>

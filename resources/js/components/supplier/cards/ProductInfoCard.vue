<template>
    <div class="card shadow-sm">
        <!-- <div class="card-header bg-primary text-white">Company Information</div> -->
        <div class="card-body">
            <div class="tab-pane active" id="product_info" role="tabpanel">
                <div class="row">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="text-left mb-1 mt-4">
                                <h1 class="h3">Product/s Information</h1>
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
                                                validation.prod_name.$error,
                                        }"
                                        v-model="product_info.prod_name"
                                        v-limit="{ max: 95 }"
                                    />
                                    <div v-if="validation.prod_name.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.prod_name.required
                                            "
                                        >
                                            Product name is required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Brief Product Description*</label
                                    >
                                    <textarea
                                        class="form-control beige-bg"
                                        rows="3"
                                        v-model="product_info.prod_details"
                                        v-limit="{ max: 2000 }"
                                        :class="{
                                            'is-invalid':
                                                validation.prod_details.$error,
                                        }"
                                    ></textarea>
                                    <div v-if="validation.prod_details.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.prod_details
                                                    .required
                                            "
                                        >
                                            Product description is required.
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
                                        v-model="product_info.prod_images"
                                        @beforedelete="
                                            onBeforeDeleteProduct($event)
                                        "
                                        @select="onSelectProduct($event)"
                                        @delete="productImageDeleted($event)"
                                    ></VueFileAgent>
                                    <div class="form-text">
                                        Please upload upto five (5) clear photos
                                        of your product. Preferably 1080x1080 px
                                        (1:1 ratio) with max. of 1MB per file.
                                    </div>
                                    <div v-if="validation.prod_images.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.prod_images.required
                                            "
                                        >
                                            Please upload a product/service
                                            photo.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h4>Product Profile*</h4>
                                    <div v-if="validation.prod_profiles.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.prod_profiles
                                                    .required
                                            "
                                        >
                                            Product profile is required.
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
                                                                product_info.prod_profiles
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
                                                            validation
                                                                .prod_certs
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                            validation
                                                                .certs_others
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                    class="col-md-4"
                                                    v-for="cert in certifications"
                                                    :key="cert.id"
                                                >
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input"
                                                            v-model="
                                                                product_info.prod_certs
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
                                                                            validation
                                                                                .certs_others
                                                                                .$error,
                                                                    }"
                                                                    type="text"
                                                                    placeholder="please specify"
                                                                    v-limit="{
                                                                        max: 95,
                                                                    }"
                                                                    v-model="
                                                                        product_info.certs_others
                                                                    "
                                                                    :readonly="
                                                                        check_product_cert_others
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
                                        >Online Store Link</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-limit="{ max: 200 }"
                                        :class="{
                                            'is-invalid':
                                                validation.store_url.$error,
                                        }"
                                        v-model="product_info.store_url"
                                        placeholder="https://www.lazada.com.ph/shop/storename"
                                    />
                                    <div v-if="validation.store_url.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.store_url.required
                                            "
                                        >
                                            Online store link is required.
                                        </div>
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.store_url.url"
                                        >
                                            Invalid online store link.
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-grid gap-2 d-md-flex justify-content-md-end"
                                >
                                    <button
                                        v-if="product_id"
                                        type="button"
                                        class="btn btn-outline-dark btn-sm"
                                        @click="doAddProduct"
                                    >
                                        <i class="far fa-edit"></i> Update
                                        product
                                    </button>
                                    <button
                                        v-else
                                        type="button"
                                        class="btn btn-outline-dark btn-sm"
                                        @click="doAddProduct"
                                    >
                                        <i class="fas fa-plus"></i> Add product
                                    </button>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-4 mb-5">
                                <div class="col-12">
                                    <h4>Added Product/s</h4>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-hover align-middle"
                                        >
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        Product Name
                                                    </th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="product in products"
                                                    :key="product.id"
                                                >
                                                    <td class="text-capitalize">
                                                        {{ product.name }}
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="d-grid gap-2 d-md-flex justify-content-md-end"
                                                        >
                                                            <button
                                                                class="btn btn-outline-warning me-md-2 btn-sm"
                                                                type="button"
                                                                :disabled="
                                                                    product_id ===
                                                                    product.id
                                                                "
                                                                @click="
                                                                    doProductEdit(
                                                                        product.id
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="far fa-edit"
                                                                ></i>
                                                                Edit
                                                            </button>
                                                            <button
                                                                class="btn btn-outline-danger btn-sm"
                                                                type="button"
                                                                @click="
                                                                    doProductDelete(
                                                                        product.id
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="far fa-trash-alt"
                                                                ></i>
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr v-if="products.length <= 0">
                                                    <td
                                                        colspan="2"
                                                        class="text-center"
                                                    >
                                                        No product found.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ProductInfoCard",
    props: {
        product_info: {
            type: Object,
            required: true,
        },

        product_id: {
            type: Number,
            required: true,
        },

        products: {
            type: Array,
            default: () => [],
        },

        categories: {
            type: Array,
            default: () => [],
        },

        certifications: {
            type: Array,
            default: () => [],
        },
        checkProductCertOthers: { type: Boolean, default: false },
        validation: { type: Object, required: true },
    },
    emits: [
        "product-image-deleted",
        "do-product-edit",
        "do-add-product",
        "do-product-delete",
        "do-save-products",
        "clear-product-form",
    ],
    computed: {
        check_product_cert_others() {
            return this.checkProductCertOthers;
        },
    },
    methods: {
        onSelectProduct(fileRecordsNewlySelected) {
            var validFileRecords = fileRecordsNewlySelected.filter(
                (fileRecord) => !fileRecord.error
            );
            this.product_info.prod_images_for_upload =
                this.product_info.prod_images_for_upload.concat(
                    validFileRecords
                );
        },

        onBeforeDeleteProduct(fileRecord) {
            //console.log(fileRecord);
            var i =
                this.product_info.prod_images_for_upload.indexOf(fileRecord);
            //console.log(i)
            if (i !== -1) {
                // queued file, not yet uploaded. Just remove from the arrays
                this.product_info.prod_images_for_upload.splice(i, 1);
                var k = this.product_info.prod_images.indexOf(fileRecord);
                if (k !== -1) this.product_info.prod_images.splice(k, 1);
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

        doProductEdit(id) {
            this.$emit("do-product-edit", id);
        },

        doAddProduct() {
            this.$emit("do-add-product");
        },

        doProductDelete(id) {
            this.$emit("do-product-delete", id);
        },

        doSaveProducts() {
            this.$emit("do-save-products");
        },

        clearProductForm() {
            this.$emit("clear-product-form");
        },
    },
};
</script>

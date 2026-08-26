<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="tab-pane active" id="docs_requirements" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row g-3">
                            <!-- Local -->
                            <div v-if="!is_foreign">
                                <!-- Copy of registration from DTI or SEC
                                        (with complete Articles of
                                        Incorporation) -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of registration from DTI or SEC
                                        (with complete Articles of
                                        Incorporation)*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent1"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc1"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 1)
                                        "
                                        @select="onSelect($event, 1)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div v-if="validation.doc1.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc1.required"
                                        >
                                            Please upload a copy of registration
                                            from dti or sec (with complete
                                            articles of incorporation).
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <!-- BIR -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of registration from BIR (Form
                                        2303)*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent2"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc2"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 2)
                                        "
                                        @select="onSelect($event, 2)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div
                                        class="mt-1"
                                        v-if="validation.doc2.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc2.required"
                                        >
                                            Please upload a copy of registration
                                            from bir (form 2303).
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <!-- LTO -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of valid License to Operate
                                        (LTO)*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent3"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc3"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 3)
                                        "
                                        @select="onSelect($event, 3)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div
                                        class="mt-1"
                                        v-if="validation.doc3.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc3.required"
                                        >
                                            Please upload a Copy of valid
                                            License to Operate (LTO) (or
                                            equivalent document, if not
                                            applicable)*
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <!-- CPR -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of valid Certificate of Product
                                        Registration (CPR) (or equivalent
                                        document, if not applicable)*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent4"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc4"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 4)
                                        "
                                        @select="onSelect($event, 4)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div
                                        class="mt-1"
                                        v-if="validation.doc4.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc4.required"
                                        >
                                            Please upload a copy of valid
                                            Certificate of Product Registration
                                            (CPR) (or equivalent document, if
                                            not applicable)*
                                        </div>
                                    </div>
                                </div>
                                <!-- Copy of valid food/ environmental
                                        certifications such as Fairtrade, FSC,
                                        Green Choice, HACCP, Halal, ISO,
                                        etc -->
                                <br />
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of valid food/ environmental
                                        certifications such as Fairtrade, FSC,
                                        Green Choice, HACCP, Halal, ISO,
                                        etc.</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent5"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc5"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 5)
                                        "
                                        @select="onSelect($event, 5)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div v-if="validation.doc5.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc5.required"
                                        >
                                            Please upload a copy of valid food/
                                            environmental certifications such as
                                            Fairtrade, FSC, Green Choice, HACCP,
                                            Halal, ISO, etc.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Local -->

                            <!-- Foreign -->
                            <div v-if="is_foreign">
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of business certification/
                                        license*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent7"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc7"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 7)
                                        "
                                        @select="onSelect($event, 7)"
                                    ></VueFileAgent>

                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div v-if="validation.doc7.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc7.required"
                                        >
                                            Please upload a copy of business
                                            certification/license.
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="col-12">
                                    <label class="form-label fw-bold">
                                        Copy of valid food/environmental
                                        certification/s issued by 3rd party
                                        certification bodies (i.e. BRC, EcoCert,
                                        Green Choice, Fairtrade, FSC, HACCP,
                                        HALAL, ISO, Kosher, USDA)
                                    </label>
                                    <VueFileAgent
                                        ref="vueFileAgent8"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="docs.doc8"
                                        :readonly="status !== 0"
                                        @beforedelete="
                                            onBeforeDelete($event, 8)
                                        "
                                        @select="onSelect($event, 8)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div v-if="validation.doc8.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.doc8.required"
                                        >
                                            Please upload a copy of valid
                                            food/environmental certification/s
                                            issued by 3rd party certification
                                            bodies.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Foreign -->
                            <!-- Local/Foreign -->
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Institutional brochure/catalog includes
                                    company profile, product/service photos, and
                                    map/site sketch of the company
                                    location</label
                                >
                                <VueFileAgent
                                    ref="vueFileAgent6"
                                    :multiple="false"
                                    :deletable="true"
                                    :linkable="true"
                                    :meta="true"
                                    :accept="'image/*,.pdf'"
                                    :maxSize="'1MB'"
                                    :maxFiles="1"
                                    :theme="'list'"
                                    v-model="docs.doc6"
                                    :readonly="status !== 0"
                                    @beforedelete="onBeforeDelete($event, 6)"
                                    @select="onSelect($event, 6)"
                                ></VueFileAgent>
                                <div id="emailHelp" class="form-text">
                                    Max size of 1MB and accept image and pdf
                                    document only.
                                </div>
                                <div v-if="validation.doc6.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.doc6.required"
                                    >
                                        Please upload a copy of valid
                                        institutional brochure/catalog.
                                    </div>
                                </div>
                            </div>
                            <!-- /Local/Foreign -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "UploadRequirementsCard",
    props: {
        docs: {
            type: Object,
            required: true,
        },
        is_foreign: {
            type: Boolean,
            default: false,
        },
        status: {
            type: Number,
            default: 0,
        },

        validation: { type: Object, required: true },
    },
    methods: {
        // onSelect(file, doc) {
        //     if (doc === 1) {
        //         this.docs.doc1_selected = file[0].file;
        //     } else if (doc === 2) {
        //         this.docs.doc2_selected = file[0].file;
        //     } else if (doc === 3) {
        //         this.docs.doc3_selected = file[0].file;
        //     } else if (doc === 4) {
        //         this.docs.doc4_selected = file[0].file;
        //     } else if (doc === 5) {
        //         this.docs.doc5_selected = file[0].file;
        //     } else if (doc === 6) {
        //         this.docs.doc6_selected = file[0].file;
        //     } else if (doc === 7) {
        //         this.docs.doc7_selected = file[0].file;
        //     } else if (doc === 8) {
        //         this.docs.doc8_selected = file[0].file;
        //     }
        // },

        onSelect(files, doc) {
            const fileRecord = files[0]; // This is a Vue File Agent FileRecord

            switch (doc) {
                case 1:
                    this.docs.doc1_selected = fileRecord.file; // raw file for backend
                    // v-model array remains as FileRecords
                    this.docs.doc1 = files;
                    break;
                case 2:
                    this.docs.doc2_selected = fileRecord.file;
                    this.docs.doc2 = files;
                    break;
                case 3:
                    this.docs.doc3_selected = fileRecord.file;
                    this.docs.doc3 = files;
                    break;
                case 4:
                    this.docs.doc4_selected = fileRecord.file;
                    this.docs.doc4 = files;
                    break;
                case 5:
                    this.docs.doc5_selected = fileRecord.file;
                    this.docs.doc5 = files;
                    break;
                case 6:
                    this.docs.doc6_selected = fileRecord.file;
                    this.docs.doc6 = files;
                    break;
                case 7:
                    this.docs.doc7_selected = fileRecord.file;
                    this.docs.doc7 = files;
                    break;
                case 8:
                    this.docs.doc8_selected = fileRecord.file;
                    this.docs.doc8 = files;
                    break;
            }
        },

        // onBeforeDelete(fileRecord, doc) {
        //     // Emit the deletion event for backend handling
        //     if (doc === 1) {
        //         // this.$emit("delete-doc", "doc_1");
        //         this.$refs.vueFileAgent1.deleteFileRecord(fileRecord);
        //         this.docs.doc1_selected = null;
        //     } else if (doc === 2) {
        //         // this.$emit("delete-doc", "doc_2");
        //         this.$refs.vueFileAgent2.deleteFileRecord(fileRecord);
        //         this.docs.doc2_selected = null;
        //     } else if (doc === 3) {
        //         // this.$emit("delete-doc", "doc_3");
        //         this.$refs.vueFileAgent3.deleteFileRecord(fileRecord);
        //         this.docs.doc3_selected = null;
        //     } else if (doc === 4) {
        //         // this.$emit("delete-doc", "doc_4");
        //         this.$refs.vueFileAgent4.deleteFileRecord(fileRecord);
        //         this.docs.doc4_selected = null;
        //     } else if (doc === 5) {
        //         // this.$emit("delete-doc", "doc_5");
        //         this.$refs.vueFileAgent5.deleteFileRecord(fileRecord);
        //         this.docs.doc5_selected = null;
        //     } else if (doc === 6) {
        //         // this.$emit("delete-doc", "doc_6");
        //         this.$refs.vueFileAgent6.deleteFileRecord(fileRecord);
        //         this.docs.doc6_selected = null;
        //     } else if (doc === 7) {
        //         // this.$emit("delete-doc", "doc_7");
        //         this.$refs.vueFileAgent7.deleteFileRecord(fileRecord);
        //         this.docs.doc7_selected = null;
        //     } else if (doc === 8) {
        //         // this.$emit("delete-doc", "doc_8");
        //         this.$refs.vueFileAgent8.deleteFileRecord(fileRecord);
        //         this.docs.doc8_selected = null;
        //     }

        //     // ✅ IMPORTANT: Do NOT clear original doc fields (like doc_1 from backend)
        //     // We only clear the _selected fields when deletion is explicit.

        //     // prevent default VueFileAgent removal

        //     return false;
        // },

        onBeforeDelete(fileRecord, doc) {
            switch (doc) {
                case 1:
                    this.$refs.vueFileAgent1.deleteFileRecord(fileRecord);
                    this.docs.doc1_selected = null;
                    this.docs.doc1 = [];
                    break;
                case 2:
                    this.$refs.vueFileAgent2.deleteFileRecord(fileRecord);
                    this.docs.doc2_selected = null;
                    this.docs.doc2 = [];
                    break;
                case 3:
                    this.$refs.vueFileAgent3.deleteFileRecord(fileRecord);
                    this.docs.doc3_selected = null;
                    this.docs.doc3 = [];
                    break;
                case 4:
                    this.$refs.vueFileAgent4.deleteFileRecord(fileRecord);
                    this.docs.doc4_selected = null;
                    this.docs.doc4 = [];
                    break;
                case 5:
                    this.$refs.vueFileAgent5.deleteFileRecord(fileRecord);
                    this.docs.doc5_selected = null;
                    this.docs.doc5 = [];
                    break;
                case 6:
                    this.$refs.vueFileAgent6.deleteFileRecord(fileRecord);
                    this.docs.doc6_selected = null;
                    this.docs.doc6 = [];
                    break;
                case 7:
                    this.$refs.vueFileAgent7.deleteFileRecord(fileRecord);
                    this.docs.doc7_selected = null;
                    this.docs.doc7 = [];
                    break;
                case 8:
                    this.$refs.vueFileAgent8.deleteFileRecord(fileRecord);
                    this.docs.doc8_selected = null;
                    this.docs.doc8 = [];
                    break;
            }

            return false; // prevent default Vue File Agent deletion
        },
    },
};
</script>

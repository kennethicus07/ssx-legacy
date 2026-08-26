<template>
    <div class="section container registration-form" id="regDiv">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <form-wizard
            title=""
            subtitle=""
            color="#9daa39"
            errorColor="#dc3545"
            stepSize="sm"
            :startIndex="0"
            finish-button-text="Submit"
            @on-loading="onLoad"
            @on-complete="onComplete"
        >
            <tab-content title="Company Information" :before-change="doStep1">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Company Information</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label
                                    for="co_name"
                                    class="form-label text-uppercase fw-bold"
                                    >Company Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    id="co_name"
                                    v-model="step1.co_name"
                                    readonly
                                />
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Country*</label
                                >
                                <select
                                    id="country"
                                    class="form-select"
                                    v-model="step1.country"
                                    :class="{
                                        'is-invalid': $v.step1.country.$error,
                                    }"
                                    @change="onChangeCountry"
                                >
                                    <option :value="''">-- Select --</option>
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :value="country.id"
                                        :data-country-code="country.dial"
                                    >
                                        {{ country.name }}
                                    </option>
                                </select>
                                <div v-if="$v.step1.country.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.country.required"
                                    >
                                        Country is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Office Address*</label
                                >
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="No. and Street/Road"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.street.$error,
                                            }"
                                            v-model="step1.street"
                                            v-limit="{ max: 95 }"
                                        />
                                        <div v-if="$v.step1.street.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.street.required"
                                            >
                                                Street is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="City/Town"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.city.$error,
                                            }"
                                            v-model="step1.city"
                                            v-limit="95"
                                        />
                                        <div v-if="$v.step1.city.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.city.required"
                                            >
                                                City/Town is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Province/State"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.state.$error,
                                            }"
                                            v-model="step1.state"
                                            v-limit="95"
                                        />
                                        <div v-if="$v.step1.state.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.state.required"
                                            >
                                                Provice/State is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col mb-2"
                                        v-show="step1.country === 148"
                                    >
                                        <select
                                            class="form-select"
                                            v-model="step1.region"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.region.$error,
                                            }"
                                        >
                                            <option :value="''">
                                                -- Region --
                                            </option>
                                            <option
                                                v-for="region in regions"
                                                :key="region.id"
                                                :value="region.name"
                                            >
                                                {{ region.name }}
                                            </option>
                                        </select>
                                        <div v-if="$v.step1.region.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.region.required"
                                            >
                                                Region is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input
                                            type="number"
                                            class="form-control"
                                            placeholder="Zipcode"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.zipcode.$error,
                                            }"
                                            v-model="step1.zipcode"
                                            v-limit="{
                                                max: 9,
                                                numeric: true,
                                            }"
                                        />
                                        <div v-if="$v.step1.zipcode.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.zipcode.required
                                                "
                                            >
                                                Zipcode is required.
                                            </div>
                                            <div
                                                class="mt-0 fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.zipcode.number"
                                            >
                                                Zipcode is invalid.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Phone Number.*</label
                                >
                                <div class="row">
                                    <div class="col">
                                        <select
                                            class="form-select"
                                            id="country_code"
                                            v-model="step1.country_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.country_code
                                                        .$error,
                                            }"
                                        >
                                            <option :value="''">
                                                Country Code
                                            </option>
                                            <option
                                                v-for="country in countries"
                                                :key="country.id"
                                                :value="country.dial"
                                            >
                                                {{ country.iso3 }} ({{
                                                    country.dial
                                                }})
                                            </option>
                                        </select>
                                        <div
                                            class="m-0"
                                            v-if="$v.step1.country_code.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.country_code
                                                        .required
                                                "
                                            >
                                                Country code is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input
                                            type="number"
                                            class="form-control"
                                            placeholder="Area Code"
                                            v-model="step1.area_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.area_code.$error,
                                            }"
                                            v-limit="{ max: 10, numeric: true }"
                                        />
                                        <div
                                            class="m-0"
                                            v-if="$v.step1.area_code.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.area_code.required
                                                "
                                            >
                                                Area code is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input
                                            type="number"
                                            class="form-control"
                                            placeholder="Phone Number"
                                            v-model="step1.phone_no"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.phone_no.$error,
                                            }"
                                            v-limit="{ max: 20, numeric: true }"
                                        />
                                        <div
                                            class="m-0"
                                            v-if="$v.step1.phone_no.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.phone_no.required
                                                "
                                            >
                                                Phone number is required.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Company E-mail Address*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    v-model="step1.co_email"
                                    :class="{
                                        'is-invalid': $v.step1.co_email.$error,
                                    }"
                                    v-limit="150"
                                    placeholder="Enter your email address"
                                />
                                <div
                                    class="m-0"
                                    v-if="$v.step1.co_email.$error"
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.co_email.required"
                                    >
                                        Company e-mail address is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.co_email.email"
                                    >
                                        Company e-mail address is invalid
                                        format.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label
                                    for="website"
                                    class="form-label text-uppercase fw-bold"
                                    >Website</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    id="website"
                                    v-model="step1.website"
                                    v-limit="140"
                                    placeholder="Enter your website link"
                                />
                                <div v-if="$v.step1.website.$error">
                                    <!-- <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.website.required"
                                    >
                                        Website is required.
                                    </div> -->
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.website.url"
                                    >
                                        Invalid website link
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label
                                    for="year_estab"
                                    class="form-label text-uppercase fw-bold"
                                    >Year Established*</label
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    id="year_estab"
                                    v-model="step1.year_established"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.year_established.$error,
                                    }"
                                    v-limit="{ max: 4, numeric: true }"
                                />
                                <div v-if="$v.step1.year_established.$error">
                                    <div
                                        class="m-0 fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step1.year_established.required
                                        "
                                    >
                                        Year established is required.
                                    </div>
                                    <div
                                        class="m-0 fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.year_established.number"
                                    >
                                        Year established is invalid.
                                    </div>
                                    <div
                                        class="m-0 fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step1.year_established
                                                .notFutureYear
                                        "
                                    >
                                        Year cannot be in the future.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <h4>Corporate Social Media Account</h4>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label
                                    for="facebook"
                                    class="form-label text-uppercase fw-bold"
                                    >Facebook</label
                                >
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        >https://www.facebook.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.facebook"
                                        placeholder="username"
                                        v-limit="195"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label
                                    for="instagram"
                                    class="form-label text-uppercase fw-bold"
                                    >Instagram</label
                                >
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        >https://www.instagram.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.instagram"
                                        placeholder="username"
                                        v-limit="195"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label
                                    for="instagram"
                                    class="form-label text-uppercase fw-bold"
                                    >Linkedin</label
                                >
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        >https://www.linked.com/in/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.linkedin"
                                        placeholder="username"
                                        v-limit="195"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label
                                    for="instagram"
                                    class="form-label text-uppercase fw-bold"
                                    >Others, please specify</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    v-model="step1.other_social"
                                    placeholder="weixin://dl/chat?username"
                                    v-limit="195"
                                />
                                <div v-if="$v.step1.other_social.$error">
                                    <!-- <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.website.required"
                                    >
                                        Website is required.
                                    </div> -->
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.other_social.url"
                                    >
                                        Invalid url
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card m-0 mt-3 h-100 beige-bg">
                                    <div class="card-body">
                                        <h4 class="">Type of Organization*</h4>
                                        <div
                                            class="form-check"
                                            v-for="org_type in organization_types"
                                            :key="org_type.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :id="
                                                    'organization_type_' +
                                                    org_type.id
                                                "
                                                :value="org_type.id"
                                                v-model="
                                                    step1.organization_type
                                                "
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="
                                                    'organization_type_' +
                                                    org_type.id
                                                "
                                                >{{ org_type.name }}</label
                                            >
                                        </div>
                                        <div
                                            v-if="
                                                $v.step1.organization_type
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.organization_type
                                                        .required
                                                "
                                            >
                                                Type of organization is
                                                required.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card m-0 mt-3 h-100 beige-bg">
                                    <div class="card-body">
                                        <h4 class="">Nature of Business*</h4>
                                        <p class="fs-12">
                                            Note: Select all that applies
                                        </p>
                                        <div
                                            v-if="
                                                $v.step1.nature_business.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.nature_business
                                                        .required
                                                "
                                            >
                                                Nature of business is required.
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                $v.step1.nature_business_other
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .nature_business_other
                                                        .required
                                                "
                                            >
                                                Please specify others.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="col-6"
                                                v-for="nature_business in nature_businesses"
                                                :key="nature_business.id"
                                            >
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        :id="
                                                            'nature_business_' +
                                                            nature_business.id
                                                        "
                                                        :value="
                                                            nature_business.id
                                                        "
                                                        v-model="
                                                            step1.nature_business
                                                        "
                                                    />
                                                    <div
                                                        v-if="
                                                            nature_business.id ===
                                                            16
                                                        "
                                                    >
                                                        <div
                                                            class="d-flex align-items-center"
                                                        >
                                                            <label
                                                                class="form-check-label m-0 p-0"
                                                                :for="
                                                                    'nature_business_' +
                                                                    nature_business.id
                                                                "
                                                                >Others,&nbsp;</label
                                                            >
                                                            <input
                                                                id="nature_business_others"
                                                                class="form-control form-control-sm w-75 border-bottom"
                                                                :class="{
                                                                    'is-invalid':
                                                                        $v.step1
                                                                            .nature_business_other
                                                                            .$error,
                                                                }"
                                                                type="text"
                                                                placeholder="please specify"
                                                                v-model="
                                                                    step1.nature_business_other
                                                                "
                                                                :readonly="
                                                                    step1.nature_business_disabled
                                                                "
                                                                v-limit="200"
                                                            />
                                                        </div>
                                                    </div>
                                                    <label
                                                        v-else
                                                        class="form-check-label"
                                                        :for="
                                                            'nature_business_' +
                                                            nature_business.id
                                                        "
                                                        >{{
                                                            nature_business.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Company Annual Sales -->
                            <div class="col-md-12">
                                <div class="card m-0 mt-3 h-100 beige-bg">
                                    <div class="card-body">
                                        <h4 class="">Company Annual Sales*</h4>
                                        <div
                                            v-if="
                                                $v.step1.company_annual_sale
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .company_annual_sale
                                                        .required
                                                "
                                            >
                                                Company annual sale is required.
                                            </div>
                                        </div>
                                        <div
                                            class="form-check"
                                            v-for="company_annual_sale in company_annual_sales"
                                            :key="company_annual_sale.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :id="
                                                    'company_annual_sale_' +
                                                    company_annual_sale.id
                                                "
                                                :value="company_annual_sale.id"
                                                v-model="
                                                    step1.company_annual_sale
                                                "
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="
                                                    'company_annual_sale_' +
                                                    company_annual_sale.id
                                                "
                                                >{{
                                                    company_annual_sale.name
                                                }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Estimated Annual Purchases from existing Philippine Supplier -->
                            <div class="col-md-12">
                                <!-- Has PH Supplier -->
                                <div class="card m-0 mt-3 h-100 beige-bg">
                                    <div class="card-body beige-bg">
                                        <h4>
                                            Any Existing Business with
                                            Philippine Suppliers?*
                                        </h4>

                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.step1
                                                    .has_ph_business_supplier
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .has_ph_business_supplier
                                                        .required
                                                "
                                            >
                                                Any existing business with
                                                Philippine suppliers is
                                                required.
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="has_ph_business_supplier_yes"
                                                :value="1"
                                                v-model="
                                                    step1.has_ph_business_supplier
                                                "
                                                @change="
                                                    onChangeHasPhBusinessSupplier
                                                "
                                            />
                                            <label
                                                class="form-check-label"
                                                for="has_ph_business_supplier_yes"
                                            >
                                                Yes
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="has_ph_business_supplier_no"
                                                :value="0"
                                                v-model="
                                                    step1.has_ph_business_supplier
                                                "
                                                @change="
                                                    onChangeHasPhBusinessSupplier
                                                "
                                            />
                                            <label
                                                class="form-check-label"
                                                for="has_ph_business_supplier_no"
                                            >
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Supplier Name (ONLY if Yes) -->
                                    <div
                                        class="card-body beige-bg"
                                        v-if="
                                            step1.has_ph_business_supplier === 1
                                        "
                                    >
                                        <h4>If yes, name of supplier/s*</h4>
                                        <p
                                            class="fs-12 text-muted d-block mb-2"
                                        >
                                            Separate suppliers with a comma (,)
                                        </p>
                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.step1.ph_supplier_name.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.ph_supplier_name
                                                        .required
                                                "
                                            >
                                                Supplier name is required.
                                            </div>
                                        </div>

                                        <input
                                            type="text"
                                            class="bg-white form-control"
                                            placeholder="Enter supplier name"
                                            v-model="step1.ph_supplier_name"
                                            v-limit="390"
                                        />
                                    </div>

                                    <!-- Estimated Annual purchases from
                                            existing Philippine Supplier* -->
                                    <div
                                        class="card-body beige-bg"
                                        v-if="
                                            step1.has_ph_business_supplier === 1
                                        "
                                    >
                                        <h4>
                                            Estimated Annual purchases from
                                            existing Philippine Supplier/s?*
                                        </h4>

                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.step1
                                                    .annual_purchase_existing_supplier
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .annual_purchase_existing_supplier
                                                        .required
                                                "
                                            >
                                                Estimated annual purchases from
                                                existing Philippine Supplier/s
                                                is required.
                                            </div>
                                        </div>

                                        <div
                                            class="form-check"
                                            v-for="item in annual_purchase_existing_suppliers"
                                            :key="item.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="annual_purchase_existing_supplier"
                                                :id="
                                                    'annual_purchase_existing_supplier_' +
                                                    item.id
                                                "
                                                :value="item.id"
                                                v-model="
                                                    step1.annual_purchase_existing_supplier
                                                "
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="
                                                    'annual_purchase_existing_supplier_' +
                                                    item.id
                                                "
                                            >
                                                {{ item.name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Representative -->
                            <div class="col-12 mt-5">
                                <h4>Company Representative</h4>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Title*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="step1.honorific"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.honorific.$error,
                                            }"
                                        >
                                            <option selected value="">
                                                Title
                                            </option>
                                            <option
                                                v-for="honorific in honorifics"
                                                :key="honorific.id"
                                                :value="honorific.name"
                                            >
                                                {{ honorific.name }}
                                            </option>
                                        </select>
                                        <div
                                            class="m-0"
                                            v-if="$v.step1.honorific.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.honorific.required
                                                "
                                            >
                                                Title is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Lastname*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Lastname"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.lname.$error,
                                            }"
                                            v-model="step1.lname"
                                            v-limit="95"
                                        />
                                        <div v-if="$v.step1.lname.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.lname.required"
                                            >
                                                Lastname is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Firstname*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Firstname"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.fname.$error,
                                            }"
                                            v-model="step1.fname"
                                            v-limit="95"
                                        />
                                        <div v-if="$v.step1.fname.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.fname.required"
                                            >
                                                Firstname is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >M.I.</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            placeholder="M.I."
                                            v-model="step1.mi"
                                            v-limit="4"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-bold"
                                    >Designation*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.designation.$error,
                                    }"
                                    v-model="step1.designation"
                                    v-limit="95"
                                />
                                <div v-if="$v.step1.designation.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.designation.required"
                                    >
                                        Designation is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-bold"
                                    >Email Address*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    v-model="step1.email"
                                    readonly
                                />
                            </div>
                            <div class="col-12">
                                <label
                                    class="form-label text-uppercase fw-bold mb-2"
                                    >Role in the company's purchasing
                                    activities*</label
                                >
                                <div class="card m-0 beige-bg">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="form-check form-check-inline"
                                                    v-for="role in roles"
                                                    :key="role.id"
                                                >
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :id="'role_' + role.id"
                                                        :value="role.id"
                                                        v-model="step1.role"
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        :for="'role_' + role.id"
                                                        >{{ role.name }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="$v.step1.role.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.step1.role.required"
                                            >
                                                Role in the company's purchasing
                                                activities is required.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
            </tab-content>
            <tab-content
                title="Product/Service of Interest"
                :before-change="doStep2"
            >
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mt-4">
                            <h1 class="h3">Product/Service of Interest</h1>
                            <p>
                                Please indicate if your company is interested in
                                the following. Please select all that apply.
                            </p>
                        </div>
                        <div class="row mt-3 g-3">
                            <div v-if="$v.step2.category.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="$v.step2.category.$invalid"
                                >
                                    Product/Service of Interest is required.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <h4>Categories</h4>

                                        <p class="fs-12">
                                            Note: Select all that applies
                                        </p>

                                        <div
                                            v-for="category in categories"
                                            :key="category.id"
                                            class="mb-4"
                                        >
                                            <!-- Pillar -->
                                            <h5 class="fw-bold mb-0">
                                                {{ category.name }}
                                            </h5>

                                            <!-- Pillar Description -->
                                            <p
                                                v-if="category.description"
                                                class="text-muted fs-12 mb-2"
                                            >
                                                ({{ category.description }})
                                            </p>

                                            <!-- Subcategories -->
                                            <div
                                                v-for="subcategory in category.sub_categories"
                                                :key="subcategory.id"
                                                class="form-check"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="
                                                        'sub_category_' +
                                                        subcategory.id
                                                    "
                                                    :value="subcategory.id"
                                                    v-model="step2.category"
                                                />

                                                <label
                                                    class="form-check-label"
                                                    :for="
                                                        'sub_category_' +
                                                        subcategory.id
                                                    "
                                                >
                                                    {{ subcategory.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
            </tab-content>
            <tab-content
                title="Participation Information"
                :before-change="doStep3"
            >
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mt-4">
                            <h1 class="h3">Participation Information</h1>
                            <p>
                                Please indicate if your company is interested in
                                the following. Please select all that apply.
                            </p>
                        </div>
                        <div class="row mt-3 g-3">
                            <div class="col-md-6">
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <h4 class="">
                                            Target UN Sustainable Development
                                            Goals (SDGs)*
                                        </h4>
                                        <p class="fs-12">
                                            Note: Select all that applies
                                        </p>
                                        <div
                                            v-if="
                                                $v.step3.participation_goal
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step3.participation_goal
                                                        .required
                                                "
                                            >
                                                Target UN Sustainable
                                                Development Goals (SDGs) is
                                                required.
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                $v.step3
                                                    .participation_goal_other
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step3
                                                        .participation_goal_other
                                                        .required
                                                "
                                            >
                                                Please specify others Target UN
                                                Sustainable Development Goals
                                                (SDGs).
                                            </div>
                                        </div>
                                        <div
                                            class="form-check"
                                            v-for="participation_goal in participation_goals"
                                            :key="participation_goal.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :id="
                                                    'participation_goal_' +
                                                    participation_goal.id
                                                "
                                                :value="participation_goal.id"
                                                v-model="
                                                    step3.participation_goal
                                                "
                                            />
                                            <div
                                                v-if="
                                                    participation_goal.id === 18
                                                "
                                            >
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <label
                                                        class="form-check-label m-0 p-0"
                                                        :for="
                                                            'participation_goal_' +
                                                            participation_goal.id
                                                        "
                                                        >Others,&nbsp;</label
                                                    >
                                                    <input
                                                        id="participation_others"
                                                        class="form-control form-control-sm w-75 border-bottom"
                                                        :class="{
                                                            'is-invalid':
                                                                $v.step3
                                                                    .participation_goal_other
                                                                    .$error,
                                                        }"
                                                        type="text"
                                                        placeholder="please specify"
                                                        v-model="
                                                            step3.participation_goal_other
                                                        "
                                                        :readonly="
                                                            step3.participation_goal_disabled
                                                        "
                                                        v-limit="200"
                                                    />
                                                </div>
                                            </div>
                                            <label
                                                v-else
                                                class="form-check-label"
                                                :for="
                                                    'participation_goal_' +
                                                    participation_goal.id
                                                "
                                                >{{
                                                    participation_goal.name
                                                }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <h4 class="">
                                            How did you learn about the event?*
                                        </h4>
                                        <p class="fs-12">
                                            Note: Select all that applies
                                        </p>
                                        <div v-if="$v.step3.about_event.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step3.about_event
                                                        .required
                                                "
                                            >
                                                How did you learn about the
                                                event is required.
                                            </div>
                                        </div>
                                        <div
                                            v-if="
                                                $v.step3.about_event_other
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step3.about_event_other
                                                        .required
                                                "
                                            >
                                                Please specify others.
                                            </div>
                                        </div>
                                        <div
                                            class="form-check"
                                            v-for="about_event in learn_about_event"
                                            :key="about_event.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :id="
                                                    'about_event_' +
                                                    about_event.id
                                                "
                                                :value="about_event.id"
                                                v-model="step3.about_event"
                                            />
                                            <div v-if="about_event.id === 9">
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <label
                                                        class="form-check-label m-0 p-0"
                                                        :for="
                                                            'about_event_' +
                                                            about_event.id
                                                        "
                                                        >Others,&nbsp;</label
                                                    >
                                                    <input
                                                        id="about_event_others"
                                                        class="form-control form-control-sm w-75 border-bottom"
                                                        :class="{
                                                            'is-invalid':
                                                                $v.step3
                                                                    .about_event_other
                                                                    .$error,
                                                        }"
                                                        type="text"
                                                        placeholder="please specify"
                                                        v-model="
                                                            step3.about_event_other
                                                        "
                                                        :readonly="
                                                            step3.about_event_disabled
                                                        "
                                                        v-limit="200"
                                                    />
                                                </div>
                                            </div>
                                            <label
                                                v-else
                                                class="form-check-label"
                                                :for="
                                                    'about_event_' +
                                                    about_event.id
                                                "
                                                >{{ about_event.name }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card m-0 h-100">
                                    <div class="card-body beige-bg">
                                        <h4 class="">
                                            Interested in pre-arrange meetings
                                            during the event dates?*
                                        </h4>
                                        <div v-if="$v.step3.interest.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step3.interest.required
                                                "
                                            >
                                                Interest in pre-arranged
                                                meetings during the event dates
                                                is required.
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :id="'interest_1'"
                                                :value="1"
                                                v-model="step3.interest"
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="'interest_1'"
                                                >Yes, I am interested in
                                                participating in pre-arranged
                                                business meetings.</label
                                            >
                                        </div>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :id="'interest_2'"
                                                :value="2"
                                                v-model="step3.interest"
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="'interest_2'"
                                                >No</label
                                            >
                                        </div>
                                        <!-- <div
                                            class="mt-2"
                                            v-if="step3.interest === 1"
                                        >
                                            <div class="fw-bold form-label">
                                                If yes*
                                            </div>
                                            <div
                                                v-if="
                                                    $v.step3.need_interpreter
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step3
                                                            .need_interpreter
                                                            .required
                                                    "
                                                >
                                                    This is required.
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :id="'need_interpreter_1'"
                                                    :value="1"
                                                    v-model="
                                                        step3.need_interpreter
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    :for="'need_interpreter_1'"
                                                    >I need an
                                                    Interpreter.</label
                                                >
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :id="'need_interpreter_2'"
                                                    :value="2"
                                                    v-model="
                                                        step3.need_interpreter
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    :for="'need_interpreter_2'"
                                                    >No need for an
                                                    Interpreter.</label
                                                >
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3"></div>
                </div>
            </tab-content>
            <tab-content title="Summary of Application">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Summary of Application</h1>
                        </div>
                        <div class="text-left mb-1 mt-4">
                            <p>
                                Before we submit your application, kindly review
                                your filled out information. Please take the
                                time to double check your details. If there are
                                any errors, simply click "Back." If there are no
                                more changes, proceed with clicking "Submit."
                            </p>
                        </div>
                        <div class="text-left mb-1 mt-4">
                            <h4>Company Information</h4>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label
                                    for="co_name"
                                    class="form-label text-uppercase fw-bold"
                                    >Company Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    id="co_name"
                                    :value="step1.co_name"
                                    disabled
                                />
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Country*</label
                                >
                                <select
                                    class="form-select"
                                    v-model="step1.country"
                                    disabled
                                >
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :value="country.id"
                                        :selected="country === step1.country"
                                    >
                                        {{ country.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Office Address*</label
                                >
                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Province/State"
                                            :value="step1.state"
                                            disabled
                                        />
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="City/Town"
                                            :value="step1.city"
                                            disabled
                                        />
                                    </div>
                                    <div
                                        class="col-12 mb-2"
                                        v-show="step1.country === 148"
                                    >
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Region"
                                            :value="step1.region"
                                            disabled
                                        />
                                    </div>
                                    <div class="col-8 mb-2">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Street"
                                            :value="step1.street"
                                            disabled
                                        />
                                    </div>
                                    <div class="col-4">
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Zipcode"
                                            :value="step1.zipcode"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Phone Number.*</label
                                >
                                <div class="row">
                                    <div class="col">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :value="step1.country_code"
                                            disabled
                                        />
                                    </div>
                                    <div class="col">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :value="step1.area_code"
                                            disabled
                                        />
                                    </div>
                                    <div class="col">
                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Phone Number"
                                            :value="step1.phone_no"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Company Email Address*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    :value="step1.co_email"
                                    disabled
                                />
                            </div>
                            <div class="col-6">
                                <label
                                    for="website"
                                    class="form-label text-uppercase fw-bold"
                                    >Website</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    id="website"
                                    :value="step1.website || '—'"
                                    disabled
                                />
                            </div>
                            <div class="col-6">
                                <label
                                    for="year_estab"
                                    class="form-label text-uppercase fw-bold"
                                    >Year Established*</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="year_estab"
                                    :value="step1.year_established"
                                    disabled
                                />
                            </div>
                            <div class="col-12 mt-5">
                                <h4>Corporate Social Media Account</h4>
                            </div>
                            <div class="col-md-6">
                                <label
                                    for="facebook"
                                    class="form-label text-uppercase fw-bold"
                                    >Facebook</label
                                >
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        >https://www.facebook.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        :value="step1.facebook"
                                        disabled
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label
                                    for="instagram"
                                    class="form-label text-uppercase fw-bold"
                                    >Instagram</label
                                >
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        >https://www.instagram.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        :value="step1.instagram"
                                        disabled
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label
                                    for="instagram"
                                    class="form-label text-uppercase fw-bold"
                                    >Linkedin</label
                                >
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        >https://www.linked.com/in/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        :value="step1.linkedin"
                                        disabled
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label
                                    for="instagram"
                                    class="form-label text-uppercase fw-bold"
                                    >Others, please specify</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    v-model="step1.other_social"
                                    disabled
                                />
                            </div>
                            <div class="col-md-4">
                                <div class="card m-0 mt-3 h-100">
                                    <div class="card-body lightgrey-bg">
                                        <h4 class="">Type of Organization*</h4>
                                        <div
                                            class="form-check"
                                            v-for="org_type in organization_types"
                                            :key="org_type.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :value="org_type.id"
                                                v-model="
                                                    step1.organization_type
                                                "
                                                disabled
                                            />
                                            <label class="form-check-label">{{
                                                org_type.name
                                            }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card m-0 mt-3 h-100">
                                    <div class="card-body lightgrey-bg">
                                        <h4 class="">Nature of Business*</h4>
                                        <div class="row">
                                            <div
                                                class="col-6"
                                                v-for="nature_business in nature_businesses"
                                                :key="nature_business.id"
                                            >
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        :value="
                                                            nature_business.id
                                                        "
                                                        v-model="
                                                            step1.nature_business
                                                        "
                                                        disabled
                                                    />
                                                    <div
                                                        v-if="
                                                            nature_business.id ===
                                                            16
                                                        "
                                                    >
                                                        <div
                                                            class="d-flex align-items-center"
                                                        >
                                                            <label
                                                                class="form-check-label m-0 p-0"
                                                                :for="
                                                                    'nature_business_' +
                                                                    nature_business.id
                                                                "
                                                                >Others,&nbsp;</label
                                                            >
                                                            <input
                                                                id="nature_business_others"
                                                                class="form-control form-control-sm w-75 border-bottom"
                                                                :class="{
                                                                    'is-invalid':
                                                                        $v.step1
                                                                            .nature_business_other
                                                                            .$error,
                                                                }"
                                                                type="text"
                                                                placeholder="please specify"
                                                                v-model="
                                                                    step1.nature_business_other
                                                                "
                                                                :readonly="
                                                                    step1.nature_business_disabled
                                                                "
                                                                v-limit="200"
                                                                disabled
                                                            />
                                                        </div>
                                                    </div>
                                                    <label
                                                        class="form-check-label"
                                                        >{{
                                                            nature_business.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Company Annual Sales -->
                            <div class="col-md-12">
                                <div class="card m-0 mt-3 h-100 lightgrey-bg">
                                    <div class="card-body">
                                        <h4 class="">Company Annual Sales*</h4>
                                        <div
                                            v-if="
                                                $v.step1.company_annual_sale
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .company_annual_sale
                                                        .required
                                                "
                                            >
                                                Company annual sale is required.
                                            </div>
                                        </div>
                                        <div
                                            class="form-check"
                                            v-for="company_annual_sale in company_annual_sales"
                                            :key="company_annual_sale.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :id="
                                                    'company_annual_sale_' +
                                                    company_annual_sale.id
                                                "
                                                :value="company_annual_sale.id"
                                                v-model="
                                                    step1.company_annual_sale
                                                "
                                                disabled
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="
                                                    'company_annual_sale_' +
                                                    company_annual_sale.id
                                                "
                                                >{{
                                                    company_annual_sale.name
                                                }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Estimated Annual Purchases from existing Philippine Supplier -->
                            <div class="col-md-12">
                                <!-- Has PH Supplier -->
                                <div class="card m-0 mt-3 h-100 lightgrey-bg">
                                    <div class="card-body lightgrey-bg">
                                        <h4>
                                            Any Existing Business with
                                            Philippine Suppliers?*
                                        </h4>

                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.step1
                                                    .has_ph_business_supplier
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .has_ph_business_supplier
                                                        .required
                                                "
                                            >
                                                Any existing business with
                                                Philippine suppliers is
                                                required.
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="has_ph_business_supplier_yes"
                                                :value="1"
                                                v-model="
                                                    step1.has_ph_business_supplier
                                                "
                                                @change="
                                                    onChangeHasPhBusinessSupplier
                                                "
                                                disabled
                                            />
                                            <label
                                                class="form-check-label"
                                                for="has_ph_business_supplier_yes"
                                            >
                                                Yes
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                id="has_ph_business_supplier_no"
                                                :value="0"
                                                v-model="
                                                    step1.has_ph_business_supplier
                                                "
                                                @change="
                                                    onChangeHasPhBusinessSupplier
                                                "
                                                disabled
                                            />
                                            <label
                                                class="form-check-label"
                                                for="has_ph_business_supplier_no"
                                            >
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Supplier Name (ONLY if Yes) -->
                                    <div
                                        class="card-body lightgrey-bg"
                                        v-if="
                                            step1.has_ph_business_supplier === 1
                                        "
                                    >
                                        <h4>If yes, name of supplier/s*</h4>

                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.step1.ph_supplier_name.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.ph_supplier_name
                                                        .required
                                                "
                                            >
                                                Supplier name is required.
                                            </div>
                                        </div>

                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter supplier name"
                                            v-model="step1.ph_supplier_name"
                                            v-limit="390"
                                            disabled
                                        />
                                    </div>

                                    <!-- Estimated Annual purchases from
                                            existing Philippine Supplier* -->
                                    <div
                                        class="card-body lightgrey-bg"
                                        v-if="
                                            step1.has_ph_business_supplier === 1
                                        "
                                    >
                                        <h4>
                                            Estimated Annual purchases from
                                            existing Philippine Supplier/s?*
                                        </h4>

                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.step1
                                                    .annual_purchase_existing_supplier
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .annual_purchase_existing_supplier
                                                        .required
                                                "
                                            >
                                                Estimated annual purchases from
                                                existing Philippine Supplier/s
                                                is required.
                                            </div>
                                        </div>

                                        <div
                                            class="form-check"
                                            v-for="item in annual_purchase_existing_suppliers"
                                            :key="item.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="annual_purchase_existing_supplier_summary"
                                                :id="
                                                    'annual_purchase_existing_supplier_' +
                                                    item.id
                                                "
                                                :value="item.id"
                                                v-model="
                                                    step1.annual_purchase_existing_supplier
                                                "
                                                disabled
                                            />
                                            <label
                                                class="form-check-label"
                                                :for="
                                                    'annual_purchase_existing_supplier_' +
                                                    item.id
                                                "
                                            >
                                                {{ item.name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <h4>Company Representative</h4>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Title*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="step1.honorific"
                                            disabled
                                        >
                                            <option
                                                v-for="honorific in honorifics"
                                                :key="honorific.id"
                                                :value="honorific.name"
                                                :selected="
                                                    honorific ===
                                                    step1.honorific
                                                "
                                            >
                                                {{ honorific.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Lastname*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Lastname"
                                            :value="step1.lname"
                                            disabled
                                        />
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Firstname*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            placeholder="Firstname"
                                            :value="step1.fname"
                                            disabled
                                        />
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >M.I.</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            placeholder="M.I."
                                            :value="step1.mi"
                                            disabled
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-bold"
                                    >Designation*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :value="step1.designation"
                                    disabled
                                />
                            </div>
                            <div class="col-6">
                                <label class="form-label text-uppercase fw-bold"
                                    >Email Address*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    :value="step1.email"
                                    disabled
                                />
                            </div>
                            <div class="col-12">
                                <label
                                    class="form-label text-uppercase fw-bold mb-0"
                                    >Role in the company's purchasing
                                    activities*</label
                                >
                                <div class="card m-0">
                                    <div class="card-body lightgrey-bg">
                                        <div class="row">
                                            <div class="col-12">
                                                <div
                                                    class="form-check form-check-inline"
                                                    v-for="role in roles"
                                                    :key="role.id"
                                                >
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :value="role.id"
                                                        v-model="step1.role"
                                                        disabled
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                        >{{ role.name }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5">
                            <h4>Product/Service of Interest</h4>
                        </div>
                        <div class="row mt-2 g-3">
                            <div class="col-md-12">
                                <div class="card m-0 h-100 lightgrey-bg">
                                    <div class="card-body">
                                        <h4>Categories</h4>
                                        <p class="fs-12">
                                            Note: Select all that applies
                                        </p>

                                        <div
                                            v-for="category in categories"
                                            :key="category.id"
                                            class="mb-4"
                                        >
                                            <!-- Pillar -->
                                            <h5 class="fw-bold mb-0">
                                                {{ category.name }}
                                            </h5>

                                            <!-- Pillar Description -->
                                            <p
                                                v-if="category.description"
                                                class="text-muted fs-12 mb-2"
                                            >
                                                ({{ category.description }})
                                            </p>

                                            <!-- Subcategories -->
                                            <div
                                                v-for="subcategory in category.sub_categories"
                                                :key="subcategory.id"
                                                class="form-check"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="
                                                        'sub_category_' +
                                                        subcategory.id
                                                    "
                                                    :value="subcategory.id"
                                                    v-model="step2.category"
                                                    disabled
                                                />

                                                <label
                                                    class="form-check-label"
                                                    :for="
                                                        'sub_category_' +
                                                        subcategory.id
                                                    "
                                                >
                                                    {{ subcategory.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-left mt-5">
                            <h4>Participation Information</h4>
                        </div>
                        <div class="row mt-2 g-3">
                            <div class="col-md-6">
                                <div class="card m-0 h-100">
                                    <div class="card-body lightgrey-bg">
                                        <h4 class="">
                                            Target UN Sustainable Development
                                            Goals (SDGs) *
                                        </h4>
                                        <div
                                            class="form-check"
                                            v-for="participation_goal in participation_goals"
                                            :key="participation_goal.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="participation_goal.id"
                                                v-model="
                                                    step3.participation_goal
                                                "
                                                disabled
                                            />
                                            <div
                                                v-if="
                                                    participation_goal.id === 18
                                                "
                                            >
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <label
                                                        class="form-check-label m-0 p-0"
                                                        >Others,&nbsp;</label
                                                    >
                                                    <input
                                                        id="participation_others"
                                                        class="form-control form-control-sm w-75"
                                                        type="text"
                                                        placeholder="please specify"
                                                        :value="
                                                            step3.participation_goal_other
                                                        "
                                                        disabled
                                                    />
                                                </div>
                                            </div>
                                            <label
                                                v-else
                                                class="form-check-label"
                                                :for="
                                                    'participation_goal_' +
                                                    participation_goal.id
                                                "
                                                >{{
                                                    participation_goal.name
                                                }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card m-0 h-100">
                                    <div class="card-body lightgrey-bg">
                                        <h4 class="">
                                            How did you learn about the event?*
                                        </h4>
                                        <div
                                            class="form-check"
                                            v-for="about_event in learn_about_event"
                                            :key="about_event.id"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="about_event.id"
                                                v-model="step3.about_event"
                                                disabled
                                            />
                                            <div v-if="about_event.id === 9">
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <label
                                                        class="form-check-label m-0 p-0"
                                                        >Others,&nbsp;</label
                                                    >
                                                    <input
                                                        id="about_event_others"
                                                        class="form-control form-control-sm w-75 border-bottom"
                                                        type="text"
                                                        placeholder="please specify"
                                                        v-model="
                                                            step3.about_event_other
                                                        "
                                                        disabled
                                                    />
                                                </div>
                                            </div>
                                            <label
                                                v-else
                                                class="form-check-label"
                                                >{{ about_event.name }}</label
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="card m-0 h-100">
                                    <div class="card-body lightgrey-bg">
                                        <h4 class="">
                                            Interested in pre-arrange meetings
                                            during the event dates?*
                                        </h4>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :value="1"
                                                v-model="step3.interest"
                                                disabled
                                            />
                                            <label class="form-check-label"
                                                >Yes, I am interested in
                                                participating in pre-arranged
                                                business meetings.</label
                                            >
                                        </div>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                :value="2"
                                                v-model="step3.interest"
                                                disabled
                                            />
                                            <label class="form-check-label"
                                                >No</label
                                            >
                                        </div>
                                        <!-- <div
                                            class="mt-2"
                                            v-if="step3.interest === 1"
                                        >
                                            <div
                                                class="text-uppercase fw-bold form-label"
                                            >
                                                IF YES*
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="1"
                                                    v-model="
                                                        step3.need_interpreter
                                                    "
                                                    disabled
                                                />
                                                <label class="form-check-label"
                                                    >I need an
                                                    Interpreter.</label
                                                >
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="2"
                                                    v-model="
                                                        step3.need_interpreter
                                                    "
                                                    disabled
                                                />
                                                <label class="form-check-label"
                                                    >No need for an
                                                    Interpreter.</label
                                                >
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <!-- <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Agreements</h1>
                        </div> -->
                        <!-- <div class="text-left mb-1 mt-4">
                            <h4>Agreements</h4>
                        </div> -->
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="col-12 pb-3 pt-4">
                                    <!-- Terms and Conditions Card -->
                                    <div class="card border-0 mb-4">
                                        <div
                                            class="card-header text-center text-uppercase lightgreen-bg text-white"
                                        >
                                            Agreements
                                        </div>
                                        <div class="card-body">
                                            <!-- Registration Agreement -->

                                            <div v-if="showAgreementError">
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                >
                                                    *Please tick the boxes
                                                    below.
                                                </div>
                                            </div>
                                            <!-- Registration Agreement -->
                                            <!-- <div
                                                class="d-flex flex-column mb-3"
                                            >
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input me-2"
                                                        v-model="
                                                            agreementChecked
                                                        "
                                                    />
                                                    <span
                                                        class="flex-grow-1"
                                                        style="cursor: pointer"
                                                        @click="
                                                            dropdownRegistrationOpen =
                                                                !dropdownRegistrationOpen
                                                        "
                                                    >
                                                        <h5 class="mb-0">
                                                            {{
                                                                agreement1.checkbox_title ||
                                                                "No Agreement Title"
                                                            }}
                                                        </h5>
                                                    </span>
                                                    <i
                                                        :class="
                                                            dropdownRegistrationOpen
                                                                ? 'mdi mdi-chevron-up'
                                                                : 'mdi mdi-chevron-down'
                                                        "
                                                        style="
                                                            font-size: 1rem;
                                                            cursor: pointer;
                                                        "
                                                        @click="
                                                            dropdownRegistrationOpen =
                                                                !dropdownRegistrationOpen
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    v-show="
                                                        dropdownRegistrationOpen
                                                    "
                                                    class="border rounded bg-light p-3 mt-2"
                                                    v-html="
                                                        agreement1.description ||
                                                        '<p>No agreement found.</p>'
                                                    "
                                                    style="font-size: 0.9rem"
                                                ></div>
                                            </div> -->

                                            <!-- Policy Privacy -->
                                            <div
                                                class="d-flex flex-column mb-3"
                                            >
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input me-2"
                                                        v-model="
                                                            agreementPolicyChecked
                                                        "
                                                    />
                                                    <span
                                                        class="flex-grow-1"
                                                        style="cursor: pointer"
                                                        @click="
                                                            dropdownPolicyPrivacyOpen =
                                                                !dropdownPolicyPrivacyOpen
                                                        "
                                                    >
                                                        <h4 class="mb-0">
                                                            {{
                                                                agreement3.checkbox_title ||
                                                                "No Privacy Policy"
                                                            }}
                                                            <span
                                                                class="text-danger"
                                                                >*</span
                                                            >
                                                        </h4>
                                                    </span>
                                                    <i
                                                        :class="
                                                            dropdownPolicyPrivacyOpen
                                                                ? 'bi bi-chevron-up'
                                                                : 'bi bi-chevron-down'
                                                        "
                                                        style="
                                                            font-size: 1rem;
                                                            cursor: pointer;
                                                        "
                                                        @click="
                                                            dropdownPolicyPrivacyOpen =
                                                                !dropdownPolicyPrivacyOpen
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    v-show="
                                                        dropdownPolicyPrivacyOpen
                                                    "
                                                    class="border rounded bg-light p-3 mt-2"
                                                    v-html="
                                                        agreement3.description ||
                                                        '<p>No agreement found.</p>'
                                                    "
                                                    style="font-size: 0.9rem"
                                                ></div>
                                            </div>

                                            <!-- Information Sharing -->
                                            <div
                                                class="d-flex flex-column mb-3"
                                            >
                                                <div
                                                    class="d-flex align-items-center"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input me-2"
                                                        v-model="
                                                            agreementInformationSharingChecked
                                                        "
                                                    />
                                                    <span
                                                        class="flex-grow-1"
                                                        style="cursor: pointer"
                                                        @click="
                                                            dropdownInformationSharingOpen =
                                                                !dropdownInformationSharingOpen
                                                        "
                                                    >
                                                        <h4 class="mb-0">
                                                            {{
                                                                agreement4.checkbox_title ||
                                                                "No Information Sharing"
                                                            }}
                                                        </h4>
                                                    </span>
                                                    <i
                                                        :class="
                                                            dropdownInformationSharingOpen
                                                                ? 'mdi mdi-chevron-up'
                                                                : 'mdi mdi-chevron-down'
                                                        "
                                                        style="
                                                            font-size: 1rem;
                                                            cursor: pointer;
                                                        "
                                                        @click="
                                                            dropdownInformationSharingOpen =
                                                                !dropdownInformationSharingOpen
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    v-show="
                                                        dropdownInformationSharingOpen
                                                    "
                                                    class="border rounded bg-light p-3 mt-2"
                                                    v-html="
                                                        agreement4.description ||
                                                        '<p>No agreement found.</p>'
                                                    "
                                                    style="font-size: 0.9rem"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tab-content>
        </form-wizard>
    </div>
</template>
<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import Vuelidate from "vuelidate";
import {
    required,
    email,
    numeric,
    requiredIf,
    url,
} from "vuelidate/lib/validators";
import BlockUI from "vue-blockui";
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";

const currentYear = new Date().getFullYear();

const notFutureYear = (value) => {
    if (!value) return true; // Let "required" handle empty values
    return Number(value) <= currentYear;
};

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
    props: ["params"],
    data() {
        return {
            isLoading: false,
            isShowThankYou: false,
            trySubmit: false,
            msg: "Saving record. Please wait.",
            user_id: "",
            fair_code: "",
            agreement: {
                id: "",
                type: "",
                title: "",
                status: "",
                description: "",
            },
            agreements: [],
            dropdownRegistrationOpen: true,
            dropdownPolicyPrivacyOpen: true,
            dropdownInformationSharingOpen: true,
            agreementChecked: false,
            agreementPolicyChecked: false,
            agreementInformationSharingChecked: false,
            token: "",
            countries: [],
            honorifics: [],
            roles: [],
            organization_types: [],
            nature_businesses: [],
            company_annual_sales: [],
            annual_purchase_existing_suppliers: [],
            regions: [],
            categories: [],
            participation_goals: [],
            learn_about_event: [],
            step1: {
                co_name: "",
                co_email: "",
                country: "",
                state: "",
                street: "",
                region: "",
                city: "",
                zipcode: "",
                country_code: "",
                area_code: "",
                phone_no: "",
                website: "",
                year_established: "",
                facebook: "",
                instagram: "",
                linkedin: "",
                other_social: "",
                organization_type: "",
                has_ph_business_supplier: null,
                ph_supplier_name: null,
                annual_purchase_existing_supplier: null,
                company_annual_sale: "",
                nature_business: [],
                nature_business_other: "",
                nature_business_disabled: true,
                honorific: "",
                fname: "",
                lname: "",
                mi: "",
                designation: "",
                email: "",
                role: "",
            },
            step2: {
                category: [],
            },
            step3: {
                participation_goal: [],
                participation_goal_other: "",
                participation_goal_disabled: true,
                about_event: [],
                about_event_other: "",
                about_event_disabled: true,
                interest: "",
                need_interpreter: "",
            },
            step4: {},
        };
    },
    validations: {
        step1: {
            country: { required },
            state: { required },
            city: { required },
            website: { url },
            other_social: { url },
            zipcode: { required, numeric },
            street: {
                required: requiredIf(function () {
                    if (this.step1.country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            region: {
                required: requiredIf(function () {
                    if (this.step1.country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            country_code: { required },
            area_code: { required },
            phone_no: { required },
            nature_business_other: {
                required: requiredIf(function () {
                    return this.step1.nature_business.includes(16);
                }),
            },
            year_established: { required, numeric, notFutureYear },
            honorific: { required },
            organization_type: { required },
            has_ph_business_supplier: {
                required,
                isValid(value) {
                    return value === 0 || value === 1;
                },
            },
            ph_supplier_name: {
                required: requiredIf(function () {
                    return this.step1.has_ph_business_supplier === 1;
                }),
            },
            annual_purchase_existing_supplier: {
                required: requiredIf(function () {
                    return this.step1.has_ph_business_supplier === 1;
                }),
            },
            company_annual_sale: { required },
            nature_business: { required },
            fname: { required },
            lname: { required },
            designation: { required },
            co_email: { required, email },
            role: { required },
        },
        step2: {
            category: { required },
        },
        step3: {
            participation_goal: { required },
            participation_goal_other: {
                required: requiredIf(function () {
                    return this.step3.participation_goal.includes(18);
                }),
            },
            about_event: { required },
            about_event_other: {
                required: requiredIf(function () {
                    return this.step3.about_event.includes(9);
                }),
            },
            interest: { required },
            // need_interpreter: {
            //     required: requiredIf(function () {
            //         return this.step3.interest === 1;
            //     }),
            // },
        },
    },
    components: {
        FormWizard,
        TabContent,
    },
    mounted() {
        this.getUserInfo();
    },
    created() {
        this.getCountries();
        this.getHonorifics();
        this.getRoles();
        this.getRegions();
        this.getOrganizationTypes();
        this.getNatureBusinesses();
        this.getCategories();
        this.getParticipationGoals();
        this.getCompanyAnnualSales();
        this.getAnnualPurchaseExistingSupplier();
        this.getLearnAboutEvent();
        this.getUserAgreement();
    },
    methods: {
        getUserInfo() {
            axios
                .get("/api/user-information/" + Number(this.params))
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.user_id = response.data.id;
                        this.token = response.data.reg_token;
                        this.fair_code = response.data.buyer.fair_code;
                        //STEP 1
                        this.step1.co_name = response.data.buyer.co_name;
                        this.step1.co_email = response.data.buyer.co_email;
                        this.step1.country = response.data.buyer.country
                            ? response.data.buyer.country
                            : "";
                        this.step1.state = response.data.buyer.state;
                        this.step1.region = response.data.buyer.region
                            ? response.data.buyer.region
                            : "";
                        this.step1.street = response.data.buyer.street;
                        this.step1.city = response.data.buyer.city;
                        this.step1.zipcode = response.data.buyer.zipcode;
                        this.step1.country_code = response.data.buyer
                            .country_code
                            ? response.data.buyer.country_code
                            : "";
                        this.step1.area_code = response.data.buyer.area_code
                            ? response.data.buyer.area_code
                            : "";
                        this.step1.phone_no = response.data.buyer.phone_no;
                        this.step1.website = response.data.buyer.website;
                        this.step1.year_established =
                            response.data.buyer.year_established;
                        this.step1.facebook = response.data.buyer.facebook;
                        this.step1.instagram = response.data.buyer.instagram;
                        this.step1.linkedin = response.data.buyer.linkedin;
                        this.step1.other_social =
                            response.data.buyer.other_social;
                        this.step1.honorific = response.data.buyer.honorific
                            ? response.data.buyer.honorific
                            : "";
                        this.step1.fname = response.data.buyer.fname;
                        this.step1.lname = response.data.buyer.lname;
                        this.step1.mi = response.data.buyer.mi;
                        this.step1.designation =
                            response.data.buyer.designation;
                        this.step1.email = response.data.buyer.email;
                        this.step1.role = response.data.buyer.company_role_id;
                        this.step1.organization_type =
                            response.data.buyer.organization_type_id;
                        this.step1.company_annual_sale =
                            response.data.buyer.company_annual_sale_id;
                        this.step1.annual_purchase_existing_supplier =
                            response.data.buyer.annual_purchase_from_existing_supplier_id;
                        this.step1.has_ph_business_supplier =
                            response.data.buyer.has_ph_business_supplier;

                        this.step1.ph_supplier_name =
                            response.data.buyer.ph_supplier_name;
                        // for (
                        //     var n = 0;
                        //     n < response.data.nature_business.length;
                        //     n++
                        // ) {
                        //     this.step1.nature_business.push(
                        //         response.data.nature_business[n][
                        //             "nature_business_id"
                        //         ]
                        //     );
                        // }

                        for (
                            var n = 0;
                            n < response.data.nature_business.length;
                            n++
                        ) {
                            if (
                                response.data.nature_business[n][
                                    "nature_business_id"
                                ] === 16
                            ) {
                                this.step1.nature_business_other =
                                    response.data.nature_business[n]["remarks"];
                            }
                            this.step1.nature_business.push(
                                response.data.nature_business[n][
                                    "nature_business_id"
                                ]
                            );
                        }
                        //STEP 2
                        for (
                            var s = 0;
                            s < response.data.category_subcategory.length;
                            s++
                        ) {
                            this.step2.category.push(
                                response.data.category_subcategory[s][
                                    "sub_category_id"
                                ]
                            );
                        }
                        //STEP 3
                        for (
                            var p = 0;
                            p < response.data.participation_goal.length;
                            p++
                        ) {
                            if (
                                response.data.participation_goal[p][
                                    "participation_id"
                                ] === 18
                            ) {
                                this.step3.participation_goal_other =
                                    response.data.participation_goal[p][
                                        "remarks"
                                    ];
                            }
                            this.step3.participation_goal.push(
                                response.data.participation_goal[p][
                                    "participation_id"
                                ]
                            );
                        }
                        for (
                            var e = 0;
                            e < response.data.learn_about_event.length;
                            e++
                        ) {
                            if (
                                response.data.learn_about_event[e][
                                    "learn_about_event_id"
                                ] === 9
                            ) {
                                this.step3.about_event_other =
                                    response.data.learn_about_event[e][
                                        "remarks"
                                    ];
                            }
                            this.step3.about_event.push(
                                response.data.learn_about_event[e][
                                    "learn_about_event_id"
                                ]
                            );
                        }
                        this.step3.interest =
                            response.data.buyer.interested_meeting;
                        this.step3.need_interpreter =
                            response.data.buyer.need_interpreter;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUserAgreement() {
            axios
                .get("/api/supplier/user-agreement/registration")
                .then(({ data }) => {
                    this.agreements = data.filter((a) => a.status === 1); // only active
                });
        },

        getCountries() {
            axios
                .get("/api/countries")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.countries = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getHonorifics() {
            axios
                .get("/api/honorifics")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.honorifics = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getRoles() {
            axios
                .get("/api/roles")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.roles = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        onChangeHasPhBusinessSupplier() {
            if (this.step1.has_ph_business_supplier === 1) {
                this.$nextTick(() => {
                    this.$v.step1.ph_supplier_name.$touch();
                    this.$v.step1.annual_purchase_existing_supplier.$touch();
                });
            } else {
                this.step1.ph_supplier_name = null;
                this.step1.annual_purchase_existing_supplier = null;

                this.$v.step1.ph_supplier_name.$reset();
                this.$v.step1.annual_purchase_existing_supplier.$reset();
            }
        },

        getRegions() {
            axios
                .get("/api/regions")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.regions = response.data;
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
        getCategories() {
            axios
                .get("/api/categories-pillar")
                .then((response) => {
                    if (response.status === 200) {
                        this.categories = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getParticipationGoals() {
            axios
                .get("/api/participation_goals_sdg")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.participation_goals = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getLearnAboutEvent() {
            axios
                .get("/api/learn_about_event")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.learn_about_event = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getCompanyAnnualSales() {
            axios
                .get("/api/company_annual_sales")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.company_annual_sales = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getAnnualPurchaseExistingSupplier() {
            axios
                .get("/api/annual_purchase_existing_supplier")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.annual_purchase_existing_suppliers = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doStep1() {
            this.scrollToTop();
            this.$v.step1.$touch();
            if (!this.$v.step1.$invalid) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("fair_code", this.fair_code);
                formData.append("token", this.token);
                formData.append("step", Number(1));
                formData.append("step1_data", JSON.stringify(this.step1));
                return axios
                    .post("/registration/purchaser/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return response.data;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },
        doStep2() {
            this.scrollToTop();
            this.$v.step2.$touch();
            if (!this.$v.step2.$invalid) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("fair_code", this.fair_code);
                formData.append("token", this.token);
                formData.append("step", Number(2));
                formData.append("step2_data", JSON.stringify(this.step2));
                return axios
                    .post("/registration/purchaser/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return response.data;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },
        doStep3() {
            this.scrollToTop();
            this.$v.step3.$touch();
            if (!this.$v.step3.$invalid) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("fair_code", this.fair_code);
                formData.append("token", this.token);
                formData.append("step", Number(3));
                formData.append("step3_data", JSON.stringify(this.step3));
                return axios
                    .post("/registration/purchaser/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return response.data;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },
        onComplete() {
            this.trySubmit = true;
            if (!this.allAgreementsChecked) {
                this.$swal({
                    icon: "warning",
                    title: "Agreements Required",
                    text: "Please check the Privacy Policy before submitting.",
                });
                return false; // ❗ BLOCK submit
            }

            this.scrollToTop();
            this.isLoading = true;
            let formData = new FormData();
            formData.append("user_id", this.user_id);
            formData.append("fair_code", this.fair_code);
            formData.append("token", this.token);
            formData.append("step", "finish");
            // Privacy policy agreement
            if (
                this.agreement3 &&
                this.agreement3.id &&
                this.agreementPolicyChecked
            ) {
                formData.append("privacy_policy_id", this.agreement3.id);
            }

            // Information Sharing
            if (
                this.agreement4 &&
                this.agreement4.id &&
                this.agreementInformationSharingChecked
            ) {
                formData.append("information_sharing_id", this.agreement4.id);
            }
            axios
                .post("/registration/purchaser/store", formData)
                .then((response) => {
                    window.location.href = `/registration/purchaser/${this.token}/thank-you?fair_code=${this.fair_code}`;
                })
                .catch((err) => {
                    return false;
                });
        },
        // onChangeParticipationGoals(e) {
        //     if (e.target.checked) {
        //         if (Number(e.target.value) === 11) {
        //             this.step3.participation_goal_disabled = false;
        //             this.$nextTick(() => {
        //                 document.getElementById("participation_others").focus();
        //             });
        //         }
        //     } else {
        //         if (Number(e.target.value) === 11) {
        //             this.step3.participation_goal_disabled = true;
        //             this.step3.participation_goal_other = "";
        //         }
        //     }
        // },
        // onChangeAboutEvent(e) {
        //     if (e.target.checked) {
        //         if (Number(e.target.value) === 9) {
        //             this.step3.about_event_disabled = false;
        //             this.$nextTick(() => {
        //                 document.getElementById("about_event_others").focus();
        //             });
        //         }
        //     } else {
        //         if (Number(e.target.value) === 9) {
        //             this.step3.about_event_disabled = true;
        //             this.step3.about_event_other = "";
        //         }
        //     }
        // },
        // onChangeNatureBusiness(e) {
        //     if (e.target.checked) {
        //         if (Number(e.target.value) === 16) {
        //             this.step1.nature_business_disabled = false;
        //             this.$nextTick(() => {
        //                 document
        //                     .getElementById("nature_business_others")
        //                     .focus();
        //             });
        //         }
        //     } else {
        //         if (Number(e.target.value) === 16) {
        //             this.step1.nature_business_disabled = true;
        //             this.step1.nature_business_other = "";
        //         }
        //     }
        // },
        onChangeInterest(e) {
            if (Number(e.target.value) === 2) {
                this.step3.need_interpreter = "";
            }
        },
        onChangeCountry(e) {
            var options = e.target.options;
            if (options.selectedIndex > -1) {
                var country_code =
                    options[options.selectedIndex].getAttribute(
                        "data-country-code"
                    );
                this.step1.country_code = country_code;
            }
        },
        scrollToTop() {
            window.scroll({ top: 150, behavior: "smooth" });
        },
        onLoad(e) {
            this.isLoading = e;
        },
    },
    computed: {
        //registration
        agreement1() {
            return this.agreements.find((a) => a.id === 1) || {};
        },
        // Policy Privacy
        agreement3() {
            return this.agreements.find((a) => a.id === 3) || {};
        },

        //Information Sharing
        agreement4() {
            return this.agreements.find((a) => a.id === 4) || {};
        },

        allAgreementsChecked() {
            return this.agreementPolicyChecked;
        },
        showAgreementError() {
            return this.trySubmit && !this.agreementPolicyChecked;
        },
        allSubCategories: function () {
            return this.categories
                .reduce(function (acc, category) {
                    var subcats = category.sub_categories.map(function (sub) {
                        return Object.assign({}, sub, {
                            parent_name: category.name,
                        });
                    });
                    return acc.concat(subcats);
                }, [])
                .sort(function (a, b) {
                    var nameA = a.name.toUpperCase(); // ignore case
                    var nameB = b.name.toUpperCase();
                    if (nameA < nameB) return -1;
                    if (nameA > nameB) return 1;
                    return 0;
                });
        },
    },
    watch: {
        "step1.nature_business"(val) {
            if (val.includes(16)) {
                this.step1.nature_business_disabled = false;
            } else {
                this.step1.nature_business_disabled = true;
                this.step1.nature_business_other = "";
            }
        },
        "step3.participation_goal"(val) {
            if (val.includes(18)) {
                this.step3.participation_goal_disabled = false;
            } else {
                this.step3.participation_goal_disabled = true;
                this.step3.participation_goal_other = "";
            }
        },
        "step3.about_event"(val) {
            if (val.includes(9)) {
                this.step3.about_event_disabled = false;
            } else {
                this.step3.about_event_disabled = true;
                this.step3.about_event_other = "";
            }
        },
    },
};
</script>

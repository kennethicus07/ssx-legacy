<template>
    <div class="row">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                data-bs-toggle="tab"
                                href="#company_info"
                                role="tab"
                            >
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down"
                                    >Company Info
                                    <span
                                        class="badge bg-danger"
                                        v-if="$v.company_info.$anyError"
                                        >Error/s</span
                                    ></span
                                >
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                href="#contact_info"
                                role="tab"
                            >
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down"
                                    >Contact Info
                                    <span
                                        class="badge bg-danger"
                                        v-if="
                                            $v.contact_info.business_owner
                                                .$anyError ||
                                            $v.contact_info
                                                .business_contact_person
                                                .$anyError
                                        "
                                        >Error/s</span
                                    ></span
                                >
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                href="#business_info"
                                role="tab"
                            >
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down"
                                    >Business Info
                                    <span
                                        class="badge bg-danger"
                                        v-if="$v.business_info.$anyError"
                                        >Error/s</span
                                    ></span
                                >
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                href="#order_info"
                                role="tab"
                            >
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down">Order Info</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <!-- COMPANY INFO -->
                        <div
                            class="tab-pane active"
                            id="company_info"
                            role="tabpanel"
                        >
                            <div class="row g-3 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Registered Business Name*</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-uppercase"
                                        :class="{
                                            'is-invalid':
                                                $v.company_info.co_name.$error,
                                        }"
                                        v-model="company_info.co_name"
                                        maxlength="150"
                                    />
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.co_name.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_name
                                                        .required
                                                "
                                            >
                                                Company name is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Company E-mail Address*</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        :class="{
                                            'is-invalid':
                                                $v.company_info.co_email.$error,
                                        }"
                                        v-model="company_info.co_email"
                                        @blur="$v.company_info.co_email.$touch"
                                        maxlength="255"
                                    />
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.co_email
                                                    .$pending
                                            "
                                            class="text-info mt-1"
                                        >
                                            <span
                                                class="spinner-border spinner-border-sm"
                                                role="status"
                                                aria-hidden="true"
                                            ></span>
                                            <span class="fs-12"
                                                >Checking company's e-mail
                                                address. Please wait...</span
                                            >
                                        </div>
                                        <div
                                            v-if="
                                                $v.company_info.co_email.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_email
                                                        .required
                                                "
                                            >
                                                Company e-mail is required.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_email
                                                        .email
                                                "
                                            >
                                                Company e-mail is invalid
                                                format.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_email
                                                        .isExist
                                                "
                                            >
                                                Company e-mail is already used.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Brief Company Profile*</label
                                    >
                                    <textarea
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                $v.company_info.co_profile
                                                    .$error,
                                        }"
                                        v-model="company_info.co_profile"
                                        rows="3"
                                    ></textarea>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.co_profile
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_profile
                                                        .required
                                                "
                                            >
                                                Brief company profile is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label mb-0 fw-bold"
                                        >Mission Statement*</label
                                    >
                                    <div class="form-text">
                                        What are your business objectives? What
                                        is your approach to reach those
                                        objectives?
                                    </div>
                                    <textarea
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                $v.company_info.mission.$error,
                                        }"
                                        v-model="company_info.mission"
                                        rows="3"
                                    ></textarea>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.mission.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.mission
                                                        .required
                                                "
                                            >
                                                Mission statement is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label mb-0 fw-bold"
                                        >Environmental / Sustainability Projects
                                        & Programs</label
                                    >
                                    <div class="form-text">
                                        Do you have any projects or programs
                                        related to the environment? Please
                                        provide a brief description for each
                                        initiative and mention the community/ies
                                        you are helping.
                                    </div>
                                    <textarea
                                        class="form-control"
                                        v-model="company_info.env_conservation"
                                        rows="3"
                                    ></textarea>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold"
                                        >Phone Number*</label
                                    >
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info
                                                        .phone_country_code
                                                        .$error,
                                            }"
                                            id="country_code"
                                            v-model="
                                                company_info.phone_country_code
                                            "
                                        >
                                            <option :value="''">--</option>
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
                                        <label for="country_code"
                                            >Country code</label
                                        >
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info
                                                    .phone_country_code.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info
                                                        .phone_country_code
                                                        .required
                                                "
                                            >
                                                Country code is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="number"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info
                                                        .phone_area_code.$error,
                                            }"
                                            v-model="
                                                company_info.phone_area_code
                                            "
                                            maxlength="10"
                                        />
                                        <label>Area code</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.phone_area_code
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info
                                                        .phone_area_code
                                                        .required
                                                "
                                            >
                                                Area code is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.phone_no
                                                        .$error,
                                            }"
                                            v-model="company_info.phone_no"
                                            maxlength="20"
                                        />
                                        <label>Phone no.</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.phone_no.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.phone_no
                                                        .required
                                                "
                                            >
                                                Phone number is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold"
                                        >Mobile Number*</label
                                    >
                                    <div class="form-floating">
                                        <select
                                            id="country_code"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info
                                                        .mobile_country_code
                                                        .$error,
                                            }"
                                            v-model="
                                                company_info.mobile_country_code
                                            "
                                        >
                                            <option :value="''">--</option>
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
                                        <label>Country code</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info
                                                    .mobile_country_code.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info
                                                        .mobile_country_code
                                                        .required
                                                "
                                            >
                                                Country code is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.mobile_no
                                                        .$error,
                                            }"
                                            v-model="company_info.mobile_no"
                                            maxlength="20"
                                        />
                                        <label>Mobile no.</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.mobile_no.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.mobile_no
                                                        .required
                                                "
                                            >
                                                Mobile number is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Website</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="company_info.website"
                                        maxlength="200"
                                    />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Brand Name*</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-capitalize"
                                        :class="{
                                            'is-invalid':
                                                $v.company_info.directory_name
                                                    .$error,
                                        }"
                                        v-model="company_info.directory_name"
                                        maxlength="100"
                                    />
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.directory_name
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info
                                                        .directory_name.required
                                                "
                                            >
                                                Brand name is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Facebook</label
                                    >
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            >https://www.facebook.com/</span
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            v-model="company_info.facebook"
                                            placeholder="username"
                                            maxlength="200"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Twitter</label
                                    >
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            >https://www.twitter.com/</span
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            v-model="company_info.twitter"
                                            placeholder="username"
                                            maxlength="200"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Instagram</label
                                    >
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            >https://www.instagram.com/</span
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            v-model="company_info.instagram"
                                            placeholder="username"
                                            maxlength="200"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Linkedin</label
                                    >
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            >https://www.linked.com/in/</span
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            v-model="company_info.linkedin"
                                            placeholder="username"
                                            maxlength="200"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Other Social Media Account/s</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="company_info.other_social"
                                        maxlength="200"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold"
                                        >Main Office Address*</label
                                    >
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            id="country_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.moa_country
                                                        .$error,
                                            }"
                                            v-model="company_info.moa_country"
                                            @change="
                                                company_info.same_as_moa = false
                                            "
                                        >
                                            <option :value="''"></option>
                                            <option
                                                v-for="country in countries"
                                                :key="country.id"
                                                :value="country.id"
                                            >
                                                {{ country.name }}
                                            </option>
                                        </select>
                                        <label>Country</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.moa_country
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.moa_country
                                                        .required
                                                "
                                            >
                                                Country is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.moa_state
                                                        .$error,
                                            }"
                                            v-model="company_info.moa_state"
                                            maxlength="200"
                                            @change="
                                                company_info.same_as_moa = false
                                            "
                                        />
                                        <label>Province/State</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.moa_state.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.moa_state
                                                        .required
                                                "
                                            >
                                                Province or state is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-5">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.moa_city
                                                        .$error,
                                            }"
                                            v-model="company_info.moa_city"
                                            maxlength="100"
                                            @change="
                                                company_info.same_as_moa = false
                                            "
                                        />
                                        <label>City/Town</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.moa_city.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.moa_city
                                                        .required
                                                "
                                            >
                                                City or town is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.moa_street
                                                        .$error,
                                            }"
                                            v-model="company_info.moa_street"
                                            maxlength="200"
                                            @change="
                                                company_info.same_as_moa = false
                                            "
                                        />
                                        <label>Street</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.moa_street
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.moa_street
                                                        .required
                                                "
                                            >
                                                Number and street or road is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div
                                    class="col-md-2"
                                    v-if="company_info.moa_country === 148"
                                >
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.moa_region
                                                        .$error,
                                            }"
                                            v-model="company_info.moa_region"
                                            @change="
                                                company_info.same_as_moa = false
                                            "
                                        >
                                            <option
                                                selected
                                                :value="''"
                                            ></option>
                                            <option
                                                v-for="region in regions"
                                                :key="region.id"
                                                :value="region.name"
                                            >
                                                {{ region.name }}
                                            </option>
                                        </select>
                                        <label>Region</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.moa_region
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.moa_region
                                                        .required
                                                "
                                            >
                                                Region is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div
                                    :class="{
                                        'col-md-2':
                                            company_info.moa_country === 148,
                                        'col-md-4':
                                            company_info.moa_country != 148,
                                    }"
                                >
                                    <div class="form-floating">
                                        <input
                                            type="number"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.moa_zipcode
                                                        .$error,
                                            }"
                                            v-model="company_info.moa_zipcode"
                                            maxlength="20"
                                            @change="
                                                company_info.same_as_moa = false
                                            "
                                        />
                                        <label>Zip code</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.moa_zipcode
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.moa_zipcode
                                                        .required
                                                "
                                            >
                                                Zipcode is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Factory Address*
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            :value="1"
                                            v-model="company_info.same_as_moa"
                                            @change="doSameAsMoa"
                                            id="same_as_moa"
                                            :disabled="check_moa_address"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="same_as_moa"
                                        >
                                            Same as Main Office Address
                                        </label>
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            id="country_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.fa_country
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_country"
                                        >
                                            <option :value="''"></option>
                                            <option
                                                v-for="country in countries"
                                                :key="country.id"
                                                :value="country.id"
                                            >
                                                {{ country.name }}
                                            </option>
                                        </select>
                                        <label>Country</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.fa_country
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.fa_country
                                                        .required
                                                "
                                            >
                                                Country is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.fa_state
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_state"
                                            maxlength="200"
                                        />
                                        <label>Province/State</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.fa_state.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.fa_state
                                                        .required
                                                "
                                            >
                                                Province or state is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.fa_city
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_city"
                                            maxlength="100"
                                        />
                                        <label>City/Town</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.fa_city.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.fa_city
                                                        .required
                                                "
                                            >
                                                City or town is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.fa_street
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_street"
                                            maxlength="200"
                                        />
                                        <label>Street</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.fa_street.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.fa_street
                                                        .required
                                                "
                                            >
                                                Number and street or road is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div
                                    class="col-md-2"
                                    v-if="company_info.fa_country === 148"
                                >
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.fa_region
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_region"
                                        >
                                            <option
                                                selected
                                                :value="''"
                                            ></option>
                                            <option
                                                v-for="region in regions"
                                                :key="region.id"
                                                :value="region.name"
                                            >
                                                {{ region.name }}
                                            </option>
                                        </select>
                                        <label>Region</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.fa_region.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.fa_region
                                                        .required
                                                "
                                            >
                                                Region is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div
                                    :class="{
                                        'col-md-2':
                                            company_info.fa_country === 148,
                                        'col-md-4':
                                            company_info.fa_country != 148,
                                    }"
                                >
                                    <div class="form-floating">
                                        <input
                                            type="number"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    $v.company_info.fa_zipcode
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_zipcode"
                                        />
                                        <label>Zip code</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.fa_zipcode
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.fa_zipcode
                                                        .required
                                                "
                                            >
                                                Zipcode is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold"
                                        >Company Banner (Masthead)*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgentMasthead"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        v-model="company_info.co_masthead"
                                        @beforedelete="
                                            onBeforeDeleteBanner($event)
                                        "
                                        @select="onSelectBanner($event)"
                                    >
                                    </VueFileAgent>
                                    <div class="form-text">
                                        Upload (1440px x 536px) hi-resolution
                                        jpg or png file; max of 1MB only
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.co_masthead
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_masthead
                                                        .required
                                                "
                                            >
                                                Company masthead is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold"
                                        >Company Logo*</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgentCompanyLogo"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        v-model="company_info.co_logo"
                                        @beforedelete="
                                            onBeforeDeleteLogo($event)
                                        "
                                        @select="onSelectLogo($event)"
                                    >
                                    </VueFileAgent>
                                    <div class="form-text">
                                        Upload (300px x 300px) hi-resolution jpg
                                        or png file; max of 1MB only
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.company_info.co_logo.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.company_info.co_logo
                                                        .required
                                                "
                                            >
                                                Company logo is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                        <!-- END COMPANY INFO -->
                        <!-- CONTACT INFO -->
                        <div class="tab-pane" id="contact_info" role="tabpanel">
                            <div class="row g-3 mt-2">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold"
                                        >Business Owner*</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_owner.fname
                                                        .$error,
                                            }"
                                            class="form-control text-capitalize"
                                            v-model="
                                                contact_info.business_owner
                                                    .fname
                                            "
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        />
                                        <label>Firstname</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info.business_owner
                                                    .fname.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner.fname
                                                        .required
                                                "
                                            >
                                                Firstname is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-5">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_owner.lname
                                                        .$error,
                                            }"
                                            class="form-control text-capitalize"
                                            v-model="
                                                contact_info.business_owner
                                                    .lname
                                            "
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        />
                                        <label>Lastname</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info.business_owner
                                                    .lname.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner.lname
                                                        .required
                                                "
                                            >
                                                Lastname is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            v-model="
                                                contact_info.business_owner.mi
                                            "
                                            maxlength="1"
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        />
                                        <label>M.I.</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_owner.email
                                                        .$error,
                                            }"
                                            class="form-control text-lowercase"
                                            v-model="
                                                contact_info.business_owner
                                                    .email
                                            "
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        />
                                        <label>E-mail address</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info.business_owner
                                                    .email.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner.email
                                                        .required
                                                "
                                            >
                                                E-mail address is required.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner.email
                                                        .email
                                                "
                                            >
                                                Invalid e-mail address format.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_owner
                                                        .designation.$error,
                                            }"
                                            v-model="
                                                contact_info.business_owner
                                                    .designation
                                            "
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        />
                                        <label>Designation</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info.business_owner
                                                    .designation.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner
                                                        .designation.required
                                                "
                                            >
                                                Designation is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_owner
                                                        .country_code.$error,
                                            }"
                                            v-model="
                                                contact_info.business_owner
                                                    .country_code
                                            "
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        >
                                            <option selected value="">
                                                -- Select --
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
                                        <label>Country code</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info.business_owner
                                                    .country_code.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner
                                                        .country_code.required
                                                "
                                            >
                                                Country code is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_owner
                                                        .mobile_no.$error,
                                            }"
                                            v-model="
                                                contact_info.business_owner
                                                    .mobile_no
                                            "
                                            @change="
                                                contact_info.business_contact_person.same_as_bo = false
                                            "
                                        />
                                        <label>Mobile no.</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info.business_owner
                                                    .mobile_no.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_owner
                                                        .mobile_no.required
                                                "
                                            >
                                                Mobile number is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Business Contact Person*
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            :value="1"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .same_as_bo
                                            "
                                            @change="doSameAsBusinessOwner"
                                            id="same_as_bo"
                                            :disabled="
                                                check_business_owner_info
                                            "
                                        />
                                        <label
                                            class="form-check-label"
                                            for="same_as_bo"
                                        >
                                            Same as Business Owner
                                        </label>
                                    </label>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_contact_person
                                                        .fname.$error,
                                            }"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .fname
                                            "
                                        />
                                        <label>Firstname</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info
                                                    .business_contact_person
                                                    .fname.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .fname.required
                                                "
                                            >
                                                Firstname is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_contact_person
                                                        .lname.$error,
                                            }"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .lname
                                            "
                                        />
                                        <label>Lastname</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info
                                                    .business_contact_person
                                                    .lname.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .lname.required
                                                "
                                            >
                                                Lastname is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            v-model="
                                                contact_info
                                                    .business_contact_person.mi
                                            "
                                            maxlength="1"
                                        />
                                        <label>M.I.</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_contact_person
                                                        .email.$error,
                                            }"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .email
                                            "
                                        />
                                        <label>E-mail address</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info
                                                    .business_contact_person
                                                    .email.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .email.required
                                                "
                                            >
                                                E-mail address is required.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .email.email
                                                "
                                            >
                                                Invalid e-mail address format.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_contact_person
                                                        .designation.$error,
                                            }"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .designation
                                            "
                                        />
                                        <label>Designation</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info
                                                    .business_contact_person
                                                    .designation.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .designation.required
                                                "
                                            >
                                                Designation is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_contact_person
                                                        .country_code.$error,
                                            }"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .country_code
                                            "
                                        >
                                            <option selected value="">
                                                -- Select --
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
                                        <label>Country code</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info
                                                    .business_contact_person
                                                    .country_code.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .country_code.required
                                                "
                                            >
                                                Country code is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            :class="{
                                                'is-invalid':
                                                    $v.contact_info
                                                        .business_contact_person
                                                        .mobile_no.$error,
                                            }"
                                            v-model="
                                                contact_info
                                                    .business_contact_person
                                                    .mobile_no
                                            "
                                        />
                                        <label>Mobile no.</label>
                                    </div>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.contact_info
                                                    .business_contact_person
                                                    .mobile_no.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.contact_info
                                                        .business_contact_person
                                                        .mobile_no.required
                                                "
                                            >
                                                Mobile number is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                        <!-- END CONTACT INFO -->
                        <!-- BUSINESS INFO -->
                        <div
                            class="tab-pane"
                            id="business_info"
                            role="tabpanel"
                        >
                            <div class="row g-3 mt-2">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold"
                                        >Business Registration*</label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                $v.business_info.business_type
                                                    .$error,
                                        }"
                                        v-model="business_info.business_type"
                                    >
                                        <option selected value="">
                                            -- Select --
                                        </option>
                                        <option
                                            v-for="btype in business_types"
                                            :key="btype.id"
                                            :value="btype.id"
                                        >
                                            {{ btype.name }}
                                        </option>
                                    </select>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.business_type
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .business_type.required
                                                "
                                            >
                                                Business registration is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold"
                                        >Company Size*</label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                $v.business_info.company_size
                                                    .$error,
                                        }"
                                        v-model="business_info.company_size"
                                    >
                                        <option selected value="">
                                            -- Select --
                                        </option>
                                        <option
                                            v-for="compsize in company_sizes"
                                            :key="compsize.id"
                                            :value="compsize.id"
                                        >
                                            {{ compsize.name }}
                                        </option>
                                    </select>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.company_size
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .company_size.required
                                                "
                                            >
                                                Company size is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Annual Sales Volume*</label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                $v.business_info
                                                    .annual_sales_volume.$error,
                                        }"
                                        v-model="
                                            business_info.annual_sales_volume
                                        "
                                    >
                                        <option selected value="">
                                            -- Select --
                                        </option>
                                        <option
                                            v-for="annual_sales in annual_sales_volumes"
                                            :key="annual_sales.id"
                                            :value="annual_sales.id"
                                        >
                                            {{ annual_sales.name }}
                                        </option>
                                    </select>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info
                                                    .annual_sales_volume.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .annual_sales_volume
                                                        .required
                                                "
                                            >
                                                Annual sales volume is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Type of Organization*</label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                $v.business_info
                                                    .organization_type.$error,
                                        }"
                                        v-model="
                                            business_info.organization_type
                                        "
                                    >
                                        <option selected value="">
                                            -- Select --
                                        </option>
                                        <option
                                            v-for="orgtype in organization_types"
                                            :key="orgtype.id"
                                            :value="orgtype.id"
                                        >
                                            {{ orgtype.name }}
                                        </option>
                                    </select>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info
                                                    .organization_type.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .organization_type
                                                        .required
                                                "
                                            >
                                                Type of organization is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Numbers of Workers</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                business_info.direct_workers
                                            "
                                        />
                                        <label>Direct</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                business_info.indirect_workers
                                            "
                                        />
                                        <label>Indirect/Sub-Contractors</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Nature of Business*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.nature_business
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .nature_business
                                                        .required
                                                "
                                            >
                                                Nature of business is required.
                                            </div>
                                        </div>
                                    </transition>
                                    <div class="row">
                                        <div
                                            class="col-6"
                                            v-for="nbusiness in nature_businesses"
                                            :key="nbusiness.id"
                                        >
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="
                                                        business_info.nature_business
                                                    "
                                                    :value="nbusiness.id"
                                                    :id="
                                                        'nature_business' +
                                                        nbusiness.id
                                                    "
                                                />
                                                <label
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'nature_business' +
                                                        nbusiness.id
                                                    "
                                                    >{{ nbusiness.name }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Target Buyer & Intent*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.target_buyers
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .target_buyers.required
                                                "
                                            >
                                                Target Buyer & Intent is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                    <div class="row">
                                        <div
                                            class="col-4"
                                            v-for="target_buyer in target_purchasers"
                                            :key="target_buyer.id"
                                        >
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="
                                                        business_info.target_buyers
                                                    "
                                                    :value="target_buyer.id"
                                                    :id="
                                                        'target' +
                                                        target_buyer.id
                                                    "
                                                />
                                                <div
                                                    class="d-flex flex-row align-items-center"
                                                    v-if="target_buyer.id === 6"
                                                >
                                                    <label
                                                        class="form-check-label m-0 align-middle"
                                                        :for="
                                                            'target' +
                                                            target_buyer.id
                                                        "
                                                        >Others &nbsp;</label
                                                    >
                                                    <input
                                                        id="target_buyer_others"
                                                        class="form-control form-control-sm w-auto align-middle"
                                                        :class="{
                                                            'is-invalid':
                                                                $v.business_info
                                                                    .target_buyer_others
                                                                    .$error,
                                                        }"
                                                        type="text"
                                                        placeholder="please specify"
                                                        v-model="
                                                            business_info.target_buyer_others
                                                        "
                                                        :readonly="
                                                            check_target_others
                                                        "
                                                    />
                                                    <transition
                                                        enter-active-class="animate__animated animate__slideInUp"
                                                        leave-active-class="animate__animated animate__fadeOut"
                                                    >
                                                        <div
                                                            v-if="
                                                                $v.business_info
                                                                    .target_buyer_others
                                                                    .$error
                                                            "
                                                        >
                                                            <div
                                                                class="fw-light invalid-feedback d-block"
                                                                v-if="
                                                                    !$v
                                                                        .business_info
                                                                        .target_buyer_others
                                                                        .required
                                                                "
                                                            >
                                                                Please specify
                                                                others.
                                                            </div>
                                                        </div>
                                                    </transition>
                                                </div>
                                                <label
                                                    v-else
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'target' +
                                                        target_buyer.id
                                                    "
                                                    >{{
                                                        target_buyer.name
                                                    }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Target Countries for Exporting (Top
                                        3)*</label
                                    >
                                    <multiselect
                                        :class="{
                                            'is-invalid':
                                                $v.business_info
                                                    .target_countries_export
                                                    .$error,
                                        }"
                                        v-model="
                                            business_info.target_countries_export
                                        "
                                        :options="countries"
                                        :multiple="true"
                                        :max="3"
                                        label="name"
                                        track-by="id"
                                    ></multiselect>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info
                                                    .target_countries_export
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .target_countries_export
                                                        .required
                                                "
                                            >
                                                Target countries for exporting
                                                is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Certifications*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.certifications
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .certifications.required
                                                "
                                            >
                                                Certifications is required.
                                            </div>
                                        </div>
                                    </transition>
                                    <div class="row">
                                        <div
                                            class="col-6"
                                            v-for="cert in certifications"
                                            :key="cert.id"
                                        >
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="
                                                        business_info.certifications
                                                    "
                                                    :value="cert.id"
                                                    :id="
                                                        'certification' +
                                                        cert.id
                                                    "
                                                />
                                                <div
                                                    class="d-flex flex-row align-items-center"
                                                    v-if="cert.id === 14"
                                                >
                                                    <label
                                                        class="form-check-label m-0 align-middle"
                                                        :for="
                                                            'certification' +
                                                            cert.id
                                                        "
                                                        >Others &nbsp;</label
                                                    >
                                                    <input
                                                        id="certification_others"
                                                        class="form-control form-control-sm w-auto align-middle"
                                                        :class="{
                                                            'is-invalid':
                                                                $v.business_info
                                                                    .certification_others
                                                                    .$error,
                                                        }"
                                                        type="text"
                                                        placeholder="please specify"
                                                        v-model="
                                                            business_info.certification_others
                                                        "
                                                        :readonly="
                                                            check_certification_others
                                                        "
                                                    />
                                                    <transition
                                                        enter-active-class="animate__animated animate__slideInUp"
                                                        leave-active-class="animate__animated animate__fadeOut"
                                                    >
                                                        <div
                                                            v-if="
                                                                $v.business_info
                                                                    .certification_others
                                                                    .$error
                                                            "
                                                        >
                                                            <div
                                                                class="fw-light invalid-feedback d-block"
                                                                v-if="
                                                                    !$v
                                                                        .business_info
                                                                        .certification_others
                                                                        .required
                                                                "
                                                            >
                                                                Please specify
                                                                others.
                                                            </div>
                                                        </div>
                                                    </transition>
                                                </div>
                                                <label
                                                    v-else
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'certification' +
                                                        cert.id
                                                    "
                                                    >{{ cert.name }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="form-label fw-bold"
                                        >Industry Representation*</label
                                    >
                                    <select
                                        class="form-select"
                                        :class="{
                                            'is-invalid':
                                                $v.business_info.industry_rep
                                                    .$error,
                                        }"
                                        v-model="business_info.industry_rep"
                                    >
                                        <option selected value="">
                                            -- Select --
                                        </option>
                                        <option :value="1">
                                            With Export Experience
                                        </option>
                                        <option :value="2">
                                            Without Export Experience
                                        </option>
                                    </select>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.industry_rep
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .industry_rep.required
                                                "
                                            >
                                                Industry Representation is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div
                                    class="col"
                                    v-if="business_info.industry_rep === 1"
                                >
                                    <label class="form-label fw-bold"
                                        >Countries Exporting To (Top 3)</label
                                    >
                                    <multiselect
                                        :class="{
                                            'is-invalid':
                                                $v.business_info
                                                    .country_exporting_to
                                                    .$error,
                                        }"
                                        v-model="
                                            business_info.country_exporting_to
                                        "
                                        :options="countries"
                                        :multiple="true"
                                        :max="3"
                                        label="name"
                                        track-by="id"
                                    ></multiselect>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info
                                                    .country_exporting_to.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .country_exporting_to
                                                        .required
                                                "
                                            >
                                                Countries exporting to is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Specific Products and/or Services
                                        Offered*</label
                                    >
                                    <textarea
                                        :class="{
                                            'is-invalid':
                                                $v.business_info
                                                    .product_promoted.$error,
                                        }"
                                        class="form-control beige-bg"
                                        rows="3"
                                        v-model="business_info.product_promoted"
                                    ></textarea>
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info
                                                    .product_promoted.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .product_promoted
                                                        .required
                                                "
                                            >
                                                Specific products and/or
                                                services offered is required.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Supplier/Exhibitor Profile*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.categories
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info.categories
                                                        .required
                                                "
                                            >
                                                Supplier/Exhibitor profile is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                    <div class="row">
                                        <div
                                            class="col-md-4"
                                            v-for="category in categories"
                                            :key="category.id"
                                        >
                                            <label class="form-label">{{
                                                category.name
                                            }}</label>
                                            <div
                                                class="form-check"
                                                v-for="subcategory in category.sub_categories"
                                                :key="subcategory.id"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="
                                                        'sub_categories_' +
                                                        subcategory.id
                                                    "
                                                    :value="subcategory.id"
                                                    v-model="
                                                        business_info.categories
                                                    "
                                                />
                                                <label
                                                    class="form-check-label align-middle"
                                                    :for="
                                                        'sub_categories_' +
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
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >On Input/Output*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.on_input_output
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .on_input_output
                                                        .required
                                                "
                                            >
                                                On input/output is required.
                                            </div>
                                        </div>
                                    </transition>
                                    <div
                                        class="form-check"
                                        v-for="inout in on_inputs_outputs"
                                        :key="inout.id"
                                    >
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            v-model="
                                                business_info.on_input_output
                                            "
                                            :value="inout.id"
                                            :id="'input_ouput_' + inout.id"
                                        />
                                        <label
                                            class="form-check-label mb-0 align-middle"
                                            :for="'input_ouput_' + inout.id"
                                            >{{ inout.name }}</label
                                        >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >On Production Process*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info
                                                    .production_process.$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info
                                                        .production_process
                                                        .required
                                                "
                                            >
                                                On production process is
                                                required.
                                            </div>
                                        </div>
                                    </transition>
                                    <div
                                        class="form-check"
                                        v-for="prod_process in production_processes"
                                        :key="prod_process.id"
                                    >
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            v-model="
                                                business_info.production_process
                                            "
                                            :value="prod_process.id"
                                            :id="
                                                'on_production_process_' +
                                                prod_process.id
                                            "
                                        />
                                        <div v-if="prod_process.id === 3">
                                            <div>
                                                <label
                                                    class="form-check-label m-0 p-0"
                                                    :for="
                                                        'on_production_process_' +
                                                        prod_process.id
                                                    "
                                                    >{{
                                                        prod_process.name
                                                    }}</label
                                                >
                                                <input
                                                    id="production_process_others"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.business_info
                                                                .production_process_others
                                                                .$error,
                                                    }"
                                                    class="form-control form-control-sm border-bottom"
                                                    type="text"
                                                    placeholder="Please specify certification/s"
                                                    v-model="
                                                        business_info.production_process_others
                                                    "
                                                    :readonly="
                                                        check_production_process_others
                                                    "
                                                />
                                                <transition
                                                    enter-active-class="animate__animated animate__slideInUp"
                                                    leave-active-class="animate__animated animate__fadeOut"
                                                >
                                                    <div
                                                        v-if="
                                                            $v.business_info
                                                                .production_process_others
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !$v
                                                                    .business_info
                                                                    .production_process_others
                                                                    .required
                                                            "
                                                        >
                                                            Please specify
                                                            others.
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                        <label
                                            v-else
                                            class="form-check-label mb-0 align-middle"
                                            :for="
                                                'on_production_process_' +
                                                prod_process.id
                                            "
                                            >{{ prod_process.name }}</label
                                        >
                                    </div>
                                    <!-- <ul class="list-group">
                                        <li class="list-group-item" v-for="process in business_info.processes" :key="process.id">{{ process.name }}</li>
                                    </ul> -->
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Sustanability is mutifaceted, which of
                                        the topics below do you think the show
                                        should focus on?*</label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div
                                            v-if="
                                                $v.business_info.topic_rank
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info.topic_rank
                                                        .isRequired
                                                "
                                            >
                                                Please rank all data.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.business_info.topic_rank
                                                        .isUnique
                                                "
                                            >
                                                Rank value must be unique.
                                            </div>
                                        </div>
                                    </transition>
                                    <div
                                        class="row"
                                        v-for="topic in rank_topics"
                                        :key="topic.id"
                                    >
                                        <label
                                            class="col-sm-10 col-form-label form-check-label"
                                            >{{ topic.name }}</label
                                        >
                                        <div class="col-sm-2">
                                            <select
                                                class="form-select form-select-sm border border-secondary"
                                                v-model="
                                                    business_info.topic_rank[
                                                        topic.id
                                                    ]
                                                "
                                            >
                                                <option
                                                    v-for="rank in rank_topics.length"
                                                    :key="rank"
                                                    :value="rank"
                                                >
                                                    {{ rank }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="rank in business_info.ranks" :key="rank.id">{{ rank.name }} <span class="badge bg-primary rounded-pill">{{ rank.rank }}</span></li>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                        <!-- END BUSINESS INFO -->
                        <!-- ORDER INFO -->
                        <div class="tab-pane" id="order_info" role="tabpanel">
                            <div class="row mt-2">
                                <div
                                    class="col-12"
                                    v-for="banner in banner_sizes"
                                    :key="banner.id"
                                >
                                    <div
                                        class="alert"
                                        :class="{
                                            'alert-success': banner.id === 1,
                                            'alert-primary': banner.id === 2,
                                            'alert-warning': banner.id === 3,
                                        }"
                                        role="alert"
                                    >
                                        <div class="form-check">
                                            <input
                                                type="radio"
                                                class="form-check-input"
                                                :id="
                                                    'banner_' + banner.item_code
                                                "
                                                v-model="order_info.banner_size"
                                                :value="banner.id"
                                            />
                                            <label
                                                class="form-check-label mb-0"
                                                :for="
                                                    'banner_' + banner.item_code
                                                "
                                                >{{ banner.name }}</label
                                            >
                                        </div>
                                        <p v-html="banner.description"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END ORDER INFO -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <h5 class="card-header">Actions</h5>
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="form-floating">
                                <select class="form-select" v-model="status">
                                    <option :value="0">Incomplete</option>
                                    <option :value="1">Approved</option>
                                    <option :value="2">Pending</option>
                                    <option :value="3">Reviewed</option>
                                    <option :value="4">On Hold</option>
                                    <option :value="5">Denied</option>
                                </select>
                                <label>Account Status</label>
                            </div>
                        </div>
                    </div>     -->
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="1"
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
                    </div>
                    <div class="form-group row">
                        <hr class="w-100 mt-3" />
                        <div class="d-grid gap-2 mb-2">
                            <button
                                class="btn btn-success text-white"
                                type="button"
                                @click="doSaveInfo"
                            >
                                Save Supplier/Exhibitor Information
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

Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);
Vue.use(BlockUI);
Vue.use(VueFileAgent);
Vue.use(Vuelidate);

export default {
    data() {
        return {
            isLoading: false,
            msg: "Please wait...",
            countries: [],
            regions: [],
            categories: [],
            certifications: [],
            products: [],
            business_types: [],
            company_sizes: [],
            annual_sales_volumes: [],
            organization_types: [],
            nature_businesses: [],
            target_purchasers: [],
            on_inputs_outputs: [],
            production_processes: [],
            rank_topics: [],
            banner_sizes: [],
            status: 0,
            to_pending: "",
            company_info: {
                co_name: "",
                co_email: "",
                co_profile: "",
                co_logo: "",
                co_masthead: "",
                mission: "",
                env_conservation: "",
                phone_country_code: "",
                phone_area_code: "",
                phone_no: "",
                mobile_country_code: "",
                mobile_no: "",
                website: "",
                directory_name: "",
                facebook: "",
                twitter: "",
                instagram: "",
                linkedin: "",
                other_social: "",
                fa_country: "",
                fa_state: "",
                fa_city: "",
                fa_region: "",
                fa_street: "",
                fa_zipcode: "",
                same_as_moa: "",
                moa_country: "",
                moa_state: "",
                moa_city: "",
                moa_region: "",
                moa_street: "",
                moa_zipcode: "",
                co_masthead: "",
                co_logo: "",
                co_masthead_selected: "",
                co_logo_selected: "",
            },
            contact_info: {
                business_owner: {
                    fname: "",
                    lname: "",
                    mi: "",
                    designation: "",
                    email: "",
                    country_code: "",
                    mobile_no: "",
                },
                business_contact_person: {
                    same_as_bo: "",
                    fname: "",
                    lname: "",
                    mi: "",
                    designation: "",
                    email: "",
                    country_code: "",
                    mobile_no: "",
                },
            },
            business_info: {
                business_type: "",
                company_size: "",
                annual_sales_volume: "",
                organization_type: "",
                direct_workers: "",
                indirect_workers: "",
                nature_business: [],
                target_buyers: [],
                target_buyer_others: "",
                certifications: [],
                certification_others: "",
                target_countries_export: [],
                industry_rep: "",
                country_exporting_to: [],
                product_promoted: "",
                categories: [],
                on_input_output: [],
                production_process: [],
                production_process_others: "",
                topic_rank: [],
            },
            order_info: {
                banner_size: 1,
            },
        };
    },
    validations: {
        company_info: {
            co_name: { required },
            co_email: {
                required,
                email,
                isExist(value) {
                    if (value === "") {
                        return true;
                    } else {
                        return axios
                            .get(
                                "/api/check-company-email-unique/" +
                                    value +
                                    "/exhibitor"
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    return response.data;
                                }
                            })
                            .catch((err) => {
                                return true;
                            });
                    }
                },
            },
            co_profile: { required },
            co_logo: { required },
            co_masthead: { required },
            mission: { required },
            phone_country_code: { required },
            phone_area_code: { required },
            phone_no: { required },
            mobile_country_code: { required },
            mobile_no: { required },
            directory_name: { required },
            fa_country: { required },
            fa_state: { required },
            fa_city: { required },
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
            fa_zipcode: { required },
            moa_country: { required },
            moa_state: { required },
            moa_city: { required },
            moa_region: {
                required: requiredIf(function () {
                    if (this.company_info.moa_country === 148) {
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
            moa_zipcode: { required },
            co_masthead: { required },
            co_logo: { required },
        },
        contact_info: {
            business_owner: {
                fname: { required },
                lname: { required },
                designation: { required },
                email: { required, email },
                country_code: { required },
                mobile_no: { required },
            },
            business_contact_person: {
                fname: { required },
                lname: { required },
                designation: { required },
                email: { required, email },
                country_code: { required },
                mobile_no: { required },
            },
        },
        business_info: {
            business_type: { required },
            company_size: { required },
            annual_sales_volume: { required },
            organization_type: { required },
            nature_business: { required },
            target_buyers: { required },
            target_buyer_others: {
                required: requiredIf(function () {
                    return this.business_info.target_buyers.includes(6);
                }),
            },
            certifications: { required },
            certification_others: {
                required: requiredIf(function () {
                    return this.business_info.certifications.includes(14);
                }),
            },
            target_countries_export: { required },
            industry_rep: { required },
            country_exporting_to: {
                required: requiredIf(function () {
                    if (this.business_info.industry_rep === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            product_promoted: { required },
            categories: { required },
            on_input_output: { required },
            production_process: { required },
            production_process_others: {
                required: requiredIf(function () {
                    return this.business_info.production_process.includes(3);
                }),
            },
            topic_rank: {
                isRequired() {
                    const rank = this.business_info.topic_rank.filter(Number);
                    if (rank.length < this.rank_topics.length) {
                        return false;
                    } else {
                        return true;
                    }
                },
                isUnique() {
                    const allUnique = !this.business_info.topic_rank.some(
                        (v, i) => this.business_info.topic_rank.indexOf(v) < i
                    );
                    return allUnique;
                },
            },
        },
    },
    components: { Multiselect },
    mounted() {
        //console.log(this.id)
    },
    computed: {
        check_prod_cert_others() {
            if (this.product_info.prod_certs.includes(14) === true) {
                this.$nextTick(() => {
                    document.getElementById("certs_others").focus();
                });
                return false;
            } else {
                this.product_info.certs_others = "";
                return true;
            }
        },
        check_target_others() {
            if (this.business_info.target_buyers.includes(6) === true) {
                this.$nextTick(() => {
                    document.getElementById("target_buyer_others").focus();
                });
                return false;
            } else {
                this.business_info.target_buyer_others = "";
                return true;
            }
        },
        check_certification_others() {
            if (this.business_info.certifications.includes(14) === true) {
                this.$nextTick(() => {
                    document.getElementById("certification_others").focus();
                });
                return false;
            } else {
                this.business_info.certification_others = "";
                return true;
            }
        },
        check_production_process_others() {
            if (this.business_info.production_process.includes(3) === true) {
                this.$nextTick(() => {
                    document
                        .getElementById("production_process_others")
                        .focus();
                });
                return false;
            } else {
                this.business_info.production_process_others = "";
                return true;
            }
        },
        check_moa_address() {
            if (
                this.company_info.moa_country &&
                this.company_info.moa_state &&
                this.company_info.moa_city &&
                this.company_info.moa_zipcode
            ) {
                return false;
            } else {
                return true;
            }
        },
        check_business_owner_info() {
            if (
                this.contact_info.business_owner.fname &&
                this.contact_info.business_owner.lname &&
                this.contact_info.business_owner.mi &&
                this.contact_info.business_owner.designation &&
                this.contact_info.business_owner.email &&
                this.contact_info.business_owner.country_code &&
                this.contact_info.business_owner.mobile_no
            ) {
                return false;
            } else {
                return true;
            }
        },
    },
    created() {
        this.getCountries();
        this.getRegions();
        this.getCategories();
        this.getCertifications();
        this.getBusinessTypes();
        this.getCompanySizes();
        this.getAnnualSalesVolumes();
        this.getOrganizationTypes();
        this.getNatureBusinesses();
        this.getTargetBuyers();
        this.getInputOuputs();
        this.getProductionProcesses();
        this.getRankTopics();
        this.getBannerSizes();
    },
    methods: {
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
        getBusinessTypes() {
            axios
                .get("/api/business_types")
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
                        this.target_purchasers = response.data;
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
                        this.on_inputs_outputs = response.data;
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
        getRankTopics() {
            axios
                .get("/api/rank_topics")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.rank_topics = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getBannerSizes() {
            axios
                .get("/api/banner_sizes")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.banner_sizes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        doSameAsMoa(e) {
            if (e.target.checked) {
                this.company_info.fa_country = this.company_info.moa_country;
                this.company_info.fa_state = this.company_info.moa_state;
                this.company_info.fa_city = this.company_info.moa_city;
                this.company_info.fa_zipcode = this.company_info.moa_zipcode;
                this.company_info.fa_region = this.company_info.moa_region;
                this.company_info.fa_street = this.company_info.moa_street;
            } else {
                this.company_info.fa_country = "";
                this.company_info.fa_state = "";
                this.company_info.fa_city = "";
                this.company_info.fa_zipcode = "";
                this.company_info.fa_region = "";
                this.company_info.fa_street = "";
            }
        },
        doSameAsBusinessOwner(e) {
            if (e.target.checked) {
                this.contact_info.business_contact_person.fname =
                    this.contact_info.business_owner.fname;
                this.contact_info.business_contact_person.lname =
                    this.contact_info.business_owner.lname;
                this.contact_info.business_contact_person.mi =
                    this.contact_info.business_owner.mi;
                this.contact_info.business_contact_person.email =
                    this.contact_info.business_owner.email;
                this.contact_info.business_contact_person.designation =
                    this.contact_info.business_owner.designation;
                this.contact_info.business_contact_person.country_code =
                    this.contact_info.business_owner.country_code;
                this.contact_info.business_contact_person.mobile_no =
                    this.contact_info.business_owner.mobile_no;
            } else {
                this.contact_info.business_contact_person.fname = "";
                this.contact_info.business_contact_person.lname = "";
                this.contact_info.business_contact_person.mi = "";
                this.contact_info.business_contact_person.email = "";
                this.contact_info.business_contact_person.designation = "";
                this.contact_info.business_contact_person.country_code = "";
                this.contact_info.business_contact_person.mobile_no = "";
            }
        },
        doSaveInfo() {
            this.$swal({
                title: "Are you sure you want to save this supplier/exhibitor information?",
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
                        this.$v.company_info.$touch();
                        this.$v.contact_info.business_owner.$touch();
                        this.$v.contact_info.business_contact_person.$touch();
                        this.$v.business_info.$touch();
                        if (
                            !this.$v.company_info.$invalid &&
                            !this.$v.contact_info.business_owner.$invalid &&
                            !this.$v.contact_info.business_contact_person
                                .$invalid &&
                            !this.$v.business_info.$invalid
                        ) {
                            this.isLoading = true;
                            this.msg = "saving application information...";
                            let formData = new FormData();
                            formData.append("to_pending", this.to_pending);
                            formData.append(
                                "company_info",
                                JSON.stringify(this.company_info)
                            );
                            formData.append(
                                "company_masthead",
                                this.company_info.co_masthead_selected
                            );
                            formData.append(
                                "company_logo",
                                this.company_info.co_logo_selected
                            );
                            formData.append(
                                "company_info",
                                JSON.stringify(this.company_info)
                            );
                            formData.append(
                                "contact_info",
                                JSON.stringify(this.contact_info)
                            );
                            formData.append(
                                "business_info",
                                JSON.stringify(this.business_info)
                            );
                            formData.append(
                                "order_info",
                                JSON.stringify(this.order_info)
                            );
                            axios
                                .post(
                                    "/admin/registration/supplier/store",
                                    formData
                                )
                                .then((response) => {
                                    //console.log(response.data)
                                    if (response.status === 200) {
                                        this.isLoading = false;
                                        Vue.$toast.success(
                                            "Supplier/Exhibitor information successfully saved.",
                                            {
                                                position: "top-right",
                                                onDismiss:
                                                    (window.location.href =
                                                        "/admin/registration/suppliers"),
                                            }
                                        );
                                    }
                                })
                                .catch((error) => {
                                    console.log(error);
                                });
                        } else {
                            Vue.$toast.error(
                                "Please review the required fields.",
                                {
                                    position: "top-right",
                                }
                            );
                            this.scrollToTop();
                        }
                    }
                },
            });
        },
        onSelectBanner(file) {
            this.company_info.co_masthead_selected = file[0].file;
        },
        onSelectLogo(file) {
            this.company_info.co_logo_selected = file[0].file;
        },
        onBeforeDeleteBanner(fileRecord) {
            if (
                confirm("Are you sure you want to remove this company banner?")
            ) {
                this.$refs.vueFileAgentMasthead.deleteFileRecord(fileRecord);
            }
        },
        onBeforeDeleteLogo(fileRecord) {
            if (confirm("Are you sure you want to remove this company logo?")) {
                this.$refs.vueFileAgentCompanyLogo.deleteFileRecord(fileRecord);
            }
        },
        scrollToTop() {
            window.scroll({ top: 0, behavior: "smooth" });
        },
    },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

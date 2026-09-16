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
                                <span class="hidden-xs-down">Company Info</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                href="#buyer_profile"
                                role="tab"
                            >
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down"
                                    >Product/Service of Interest</span
                                >
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                data-bs-toggle="tab"
                                href="#participation_info"
                                role="tab"
                            >
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down"
                                    >Participation Information</span
                                >
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div
                            class="tab-pane active"
                            id="company_info"
                            role="tabpanel"
                        >
                            <!-- VIB Dropdown standalone row -->
                            <div class="row g-3 mt-2">
                                <div class="col-md-4 mb-2">
                                    <label
                                        for="very_important_buyer"
                                        class="form-label fw-bold"
                                    >
                                        VIB (Very Important Buyer)
                                    </label>
                                    <select
                                        id="very_important_buyer"
                                        class="form-select"
                                        v-model="buyerclass"
                                    >
                                        <option :value="0">No</option>
                                        <option :value="1">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold"
                                        >Company Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-uppercase"
                                        v-model="company_info.co_name"
                                        disabled
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold"
                                        >Company E-mail Address</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="company_info.co_email"
                                        disabled
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold"
                                        >Country</label
                                    >
                                    <select
                                        class="form-select"
                                        id="country_code"
                                        v-model="company_info.country"
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
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Office Address</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            v-model="company_info.fa_state"
                                        />
                                        <label>Province/State</label>
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
                                            class="form-control text-capitalize"
                                            v-model="company_info.fa_city"
                                        />
                                        <label>City/Town</label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            v-model="company_info.fa_region"
                                            :disabled="region_disabled"
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
                                </div>
                                <div class="col-5">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            v-model="company_info.fa_street"
                                        />
                                        <label>Street</label>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating">
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="company_info.fa_zipcode"
                                        />
                                        <label>Zip code</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label fw-bold"
                                        >Phone Number</label
                                    >
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            id="country_code"
                                            v-model="company_info.country_code"
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
                                </div>
                                <div class="col-md-4">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="company_info.area_code"
                                        />
                                        <label>Area code</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="company_info.phone_no"
                                        />
                                        <label>Phone no.</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold"
                                        >Website</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="company_info.website"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label"
                                        >Year Established</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="company_info.year_estab"
                                    />
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
                                <div class="col-md-6">
                                    <label class="form-label fw-bold"
                                        >Other social media account/s</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="company_info.other_social"
                                    />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Type of Organization</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="company_info.organization_type"
                                    >
                                        <option :value="''"></option>
                                        <option
                                            v-for="orgtype in organization_types"
                                            :key="orgtype.id"
                                            :value="orgtype.id"
                                        >
                                            {{ orgtype.name }}
                                        </option>
                                    </select>
                                </div>
                                <!-- Nature Business -->
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Nature of Business</label
                                    >

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
                                                        company_info.nature_business
                                                    "
                                                    :value="nbusiness.id"
                                                    :id="
                                                        'nature_business_' +
                                                        nbusiness.id
                                                    "
                                                />

                                                <!-- OTHERS -->
                                                <div v-if="nbusiness.id === 16">
                                                    <div
                                                        class="d-flex align-items-center"
                                                    >
                                                        <label
                                                            class="form-check-label me-2"
                                                            :for="
                                                                'nature_business_' +
                                                                nbusiness.id
                                                            "
                                                        >
                                                            Others,
                                                        </label>

                                                        <input
                                                            class="form-control form-control-sm w-75"
                                                            :class="{
                                                                'is-invalid':
                                                                    $v
                                                                        .company_info
                                                                        .nature_business_other
                                                                        .$error,
                                                            }"
                                                            type="text"
                                                            placeholder="please specify"
                                                            v-model="
                                                                company_info.nature_business_other
                                                            "
                                                            :readonly="
                                                                company_info.nature_business_disabled
                                                            "
                                                            v-limit="200"
                                                        />
                                                    </div>
                                                </div>

                                                <!-- NORMAL OPTIONS -->
                                                <label
                                                    v-else
                                                    class="form-check-label"
                                                    :for="
                                                        'nature_business_' +
                                                        nbusiness.id
                                                    "
                                                >
                                                    {{ nbusiness.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Annual Sales -->
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Company Annual Sales</label
                                    >

                                    <!-- Select -->
                                    <select
                                        class="form-select"
                                        v-model="
                                            company_info.company_annual_sale
                                        "
                                    >
                                        <option disabled value="">
                                            -- Select Company Annual Sales --
                                        </option>

                                        <option
                                            v-for="company_annual_sale in company_annual_sales"
                                            :key="company_annual_sale.id"
                                            :value="company_annual_sale.id"
                                        >
                                            {{ company_annual_sale.name }}
                                        </option>
                                    </select>
                                </div>
                                <!-- Estimated Annual Purchases from existing Philippine Supplier -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Any Existing Business with
                                            Philippine Suppliers?
                                        </label>

                                        <!-- Select -->
                                        <select
                                            class="form-select"
                                            v-model="
                                                company_info.has_ph_business_supplier
                                            "
                                            @change="
                                                onChangeHasPhBusinessSupplier
                                            "
                                        >
                                            <option disabled value="">
                                                -- Select an option --
                                            </option>
                                            <option :value="1">Yes</option>
                                            <option :value="0">No</option>
                                        </select>
                                    </div>

                                    <!-- Supplier Name -->
                                    <div
                                        class="mb-3"
                                        v-if="
                                            company_info.has_ph_business_supplier ===
                                            1
                                        "
                                    >
                                        <label class="form-label fw-bold"
                                            >If yes, name of supplier/s*</label
                                        >

                                        <input
                                            type="text"
                                            class="form-control"
                                            placeholder="Enter supplier name"
                                            v-model="
                                                company_info.ph_supplier_name
                                            "
                                            @blur="
                                                $v.company_info.ph_supplier_name.$touch()
                                            "
                                            v-limit="390"
                                        />

                                        <div
                                            v-if="
                                                $v.company_info.ph_supplier_name
                                                    .$error
                                            "
                                            class="fw-light invalid-feedback d-block"
                                        >
                                            Supplier name is required.
                                        </div>
                                    </div>

                                    <!-- Estimated Annual Purchases -->
                                    <div
                                        class=""
                                        v-if="
                                            company_info.has_ph_business_supplier ===
                                            1
                                        "
                                    >
                                        <label class="form-label fw-bold">
                                            Estimated Annual purchases from
                                            existing Philippine Supplier/s?*
                                        </label>

                                        <select
                                            class="form-select"
                                            v-model="
                                                company_info.annual_purchase_existing_supplier
                                            "
                                            @blur="
                                                $v.company_info.annual_purchase_existing_supplier.$touch()
                                            "
                                        >
                                            <option disabled value="">
                                                -- Select estimated annual
                                                purchase --
                                            </option>

                                            <option
                                                v-for="item in annual_purchase_existing_suppliers"
                                                :key="item.id"
                                                :value="item.id"
                                            >
                                                {{ item.name }}
                                            </option>
                                        </select>

                                        <!-- Validation -->
                                        <div
                                            v-if="
                                                $v.company_info
                                                    .annual_purchase_existing_supplier
                                                    .$error
                                            "
                                            class="fw-light invalid-feedback d-block"
                                        >
                                            Estimated annual purchases from
                                            existing Philippine Supplier/s is
                                            required.
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Representative -->
                                <div class="col-md-3">
                                    <label class="form-label fw-bold"
                                        >Company Representative</label
                                    >
                                    <div class="form-floating">
                                        <select
                                            class="form-select"
                                            v-model="company_info.honorific"
                                        >
                                            <option :value="''"></option>
                                            <option
                                                v-for="title in honorifics"
                                                :key="title.id"
                                                :value="title.name"
                                            >
                                                {{ title.name }}
                                            </option>
                                        </select>
                                        <label>Title</label>
                                    </div>
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
                                            v-model="company_info.fname"
                                        />
                                        <label>Firstname</label>
                                    </div>
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
                                            v-model="company_info.lname"
                                        />
                                        <label>Lastname</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label
                                        class="form-label d-none d-sm-none d-md-block"
                                        >&nbsp;</label
                                    >
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="company_info.mi"
                                        />
                                        <label>M.I.</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="company_info.designation"
                                        />
                                        <label>Designation</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="company_info.email"
                                            readonly
                                        />
                                        <label>E-mail address</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Role in the Company's Purchasing
                                        Activities</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="company_info.role"
                                    >
                                        <option :value="''"></option>
                                        <option
                                            v-for="comprole in roles"
                                            :key="comprole.id"
                                            :value="comprole.id"
                                        >
                                            {{ comprole.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div
                            class="tab-pane"
                            id="buyer_profile"
                            role="tabpanel"
                        >
                            <div class="row g-3 mt-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <h4>Categories</h4>
                                        <p class="fs-12">
                                            Note: Select all that applies
                                        </p>

                                        <div
                                            class="col-md-4 mb-3"
                                            v-for="category in categories"
                                            :key="category.id"
                                        >
                                            <!-- Category Header -->
                                            <h6 class="fw-bold text-dark mb-2">
                                                {{ category.name }}
                                            </h6>

                                            <!-- Subcategories -->
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
                                                        buyer_profile.categories
                                                    "
                                                />

                                                <label
                                                    class="form-check-label"
                                                    :for="
                                                        'sub_categories_' +
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
                        <div
                            class="tab-pane"
                            id="participation_info"
                            role="tabpanel"
                        >
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label fw-bold">
                                        Target UN Sustainable Development Goals
                                        (SDGs)</label
                                    >
                                    <div class="row">
                                        <div
                                            class="col-md-12"
                                            v-for="goals in participation_goals"
                                            :key="goals.id"
                                        >
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="
                                                        'participation_goal_' +
                                                        goals.id
                                                    "
                                                    :value="goals.id"
                                                    v-model="
                                                        participation_info.participation_goals
                                                    "
                                                />
                                                <div
                                                    v-if="goals.id === 18"
                                                    class="d-flex flex-row align-items-center"
                                                >
                                                    <label
                                                        class="form-check-label"
                                                        :for="
                                                            'participation_goal_' +
                                                            goals.id
                                                        "
                                                        >{{ goals.name }}</label
                                                    >&nbsp;&nbsp;
                                                    <input
                                                        id="participation_goal_others"
                                                        class="form-control"
                                                        type="text"
                                                        placeholder="Please specify other/s"
                                                        v-model="
                                                            participation_info.participation_goal_others
                                                        "
                                                        :readonly="
                                                            check_participation_goal_others
                                                        "
                                                    />
                                                </div>
                                                <label
                                                    v-else
                                                    class="form-check-label align-middle"
                                                    :for="
                                                        'participation_goal_' +
                                                        goals.id
                                                    "
                                                    >{{ goals.name }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >How did you learn about the
                                        event?</label
                                    >
                                    <div class="row">
                                        <div
                                            class="col-md-12"
                                            v-for="learn_event in about_events"
                                            :key="learn_event.id"
                                        >
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="
                                                        'about_events_' +
                                                        learn_event.id
                                                    "
                                                    :value="learn_event.id"
                                                    v-model="
                                                        participation_info.about_events
                                                    "
                                                />
                                                <div
                                                    v-if="learn_event.id === 9"
                                                    class="d-flex flex-row align-items-center"
                                                >
                                                    <label
                                                        class="form-check-label"
                                                        :for="
                                                            'about_events_' +
                                                            learn_event.id
                                                        "
                                                        >{{
                                                            learn_event.name
                                                        }}</label
                                                    >&nbsp;&nbsp;
                                                    <input
                                                        id="about_events_others"
                                                        class="form-control"
                                                        type="text"
                                                        placeholder="Please specify other/s"
                                                        v-model="
                                                            participation_info.about_event_others
                                                        "
                                                        :readonly="
                                                            check_about_event_others
                                                        "
                                                    />
                                                </div>
                                                <label
                                                    v-else
                                                    class="form-check-label align-middle"
                                                    :for="
                                                        'about_events_' +
                                                        learn_event.id
                                                    "
                                                    >{{
                                                        learn_event.name
                                                    }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold"
                                        >Interested in pre-arrange meetings
                                        during the event dates?</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="participation_info.interested"
                                    >
                                        <option :value="''"></option>
                                        <option :value="1">
                                            Yes, I am interested in
                                            participating in pre-arranged
                                            business meetings.
                                        </option>
                                        <option :value="2">No</option>
                                    </select>
                                </div>
                                <!-- <div
                                    class="col-md-12"
                                    v-if="participation_info.interested === 1"
                                >
                                    <label class="form-label fw-bold"
                                        >If yes</label
                                    >
                                    <select
                                        class="form-select"
                                        v-model="participation_info.if_yes"
                                    >
                                        <option :value="''"></option>
                                        <option :value="1">
                                            I need an Interpreter
                                        </option>
                                        <option :value="2">
                                            No need for an Interpreter
                                        </option>
                                    </select>
                                </div> -->
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
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label fw-bold mb-1">
                                Status
                            </label>
                            <p
                                class="fs-3 p-3 mb-2 bg-success text-white"
                                v-if="this.status === 1"
                            >
                                Approved
                            </p>
                            <p
                                class="fs-3 p-3 mb-2 bg-info text-white"
                                v-else-if="this.status === 2"
                            >
                                Pending
                            </p>
                            <p
                                class="fs-3 p-3 mb-2 bg-primary text-white"
                                v-else-if="this.status === 3"
                            >
                                Reviewed
                            </p>
                            <p
                                class="fs-3 p-3 mb-2 bg-warning text-white"
                                v-else-if="this.status === 4"
                            >
                                On hold
                            </p>
                            <p
                                class="fs-3 p-3 mb-2 bg-danger text-white"
                                v-else-if="this.status === 5"
                            >
                                Denied
                            </p>
                            <p
                                class="fs-3 p-3 mb-2 bg-secondary text-white"
                                v-else
                            >
                                Incomplete
                            </p>
                        </div>
                        <div
                            class="col-12 mt-2"
                            v-if="this.status === 0 && permissions.can_pending"
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
                        <div class="col-12 mt-2">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    :value="
                                        created_at
                                            ? $moment(created_at).format('llll')
                                            : ''
                                    "
                                    readonly
                                />
                                <label>Date Created</label>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    :value="
                                        updated_at
                                            ? $moment(updated_at).format('llll')
                                            : ''
                                    "
                                    readonly
                                />
                                <label>Date Last Modified</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-2" v-if="status === 3">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="users.reviewer"
                                    readonly
                                />
                                <label>Reviewed By</label>
                            </div>
                        </div>
                        <div class="col-12 mt-2" v-if="status === 4">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="users.onholder"
                                    readonly
                                />
                                <label>On hold By</label>
                            </div>
                        </div>
                        <div class="col-12 mt-2" v-if="this.status === 5">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="users.disapprover"
                                    readonly
                                />
                                <label>Disapproved By</label>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="users.lastupdate"
                                    readonly
                                />
                                <label>Last Update By</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <hr class="w-100 mt-3" />
                        <!-- <div class="d-grid gap-2 mb-2">
                            <button
                                class="btn btn-dark text-white"
                                type="button"
                                @click="generateQr"
                                :disabled="isGeneratingQr"
                            >
                                <span v-if="isGeneratingQr">
                                    <i class="fas fa-spinner fa-spin me-1"></i>
                                    Generating QR...
                                </span>
                                <span v-else>
                                    <i class="fas fa-qrcode me-1"></i>
                                    Generate QR
                                </span>
                            </button>
                        </div> -->
                        <div class="d-grid gap-2 mb-2">
                            <button
                                class="btn btn-success text-white"
                                type="button"
                                @click="doUpdate"
                            >
                                Update Purchaser/Buyer Info
                            </button>
                        </div>
                        <div
                            class="d-grid gap-2 mb-2"
                            v-if="
                                status !== 1 &&
                                status !== 0 &&
                                permissions.can_revert
                            "
                        >
                            <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doRevertToIncomplete"
                            >
                                Revert to Incomplete
                            </button>
                        </div>
                        <!-- <div
                            class="d-grid gap-2 mb-2"
                            v-if="status === 0 && from_backend != 'backend'"
                        >
                            <button
                                class="btn btn-info text-white"
                                type="button"
                                @click="reSendRegLink"
                            >
                                Resend registation link
                            </button>
                        </div> -->
                        <div class="d-grid gap-2 mb-2" v-if="this.status === 2">
                            <button
                                class="btn btn-primary text-white"
                                type="button"
                                @click="doReview"
                                v-if="permissions.can_review"
                            >
                                Review
                            </button>
                            <!-- <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doRevertToIncomplete"
                                v-if="permissions.can_revert"
                            >
                                Revert to Incomplete
                            </button> -->
                        </div>
                        <div class="d-grid gap-2 mb-2" v-if="this.status === 3">
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
                            <!-- <button
                                class="btn btn-warning text-white"
                                type="button"
                                @click="doHold"
                                v-if="permissions.can_hold"
                            >
                                On hold
                            </button> -->
                        </div>
                        <div class="d-grid gap-2 mb-2" v-if="this.status === 4">
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
                        <div class="d-grid gap-2">
                            <a
                                href="/admin/registration/buyers"
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
import {
    required,
    email,
    numeric,
    requiredIf,
    url,
} from "vuelidate/lib/validators";
Vue.use(require("vue-moment"));
Vue.use(VueSweetalert2);
Vue.use(VueToast);
Vue.use(BlockUI);

export default {
    props: ["id", "event_fair_code"],
    data() {
        return {
            isLoading: false,
            msg: "Please wait...",
            isGeneratingQr: false,
            qrCode: null,
            status: 0,
            buyerclass: 0,
            created_at: "",
            updated_at: "",
            countries: [],
            regions: [],
            to_pending: 0,
            permissions: {},
            organization_types: [],
            nature_businesses: [],
            honorifics: [],
            roles: [],
            categories: [],
            participation_goals: [],
            company_annual_sales: [],
            annual_purchase_existing_suppliers: [],
            about_events: [],
            from_backend: "",
            company_info: {
                co_name: "",
                co_email: "",
                country: "",
                fa_state: "",
                fa_city: "",
                fa_region: "",
                fa_street: "",
                fa_zipcode: "",
                country_code: "",
                area_code: "",
                phone_no: "",
                website: "",
                year_estab: "",
                facebook: "",
                instagram: "",
                linkedin: "",
                other_social: "",
                organization_type: "",
                nature_business: [],
                nature_business_other: "",
                nature_business_disabled: true,
                has_ph_business_supplier: null,
                ph_supplier_name: null,
                annual_purchase_existing_supplier: null,
                company_annual_sale: "",
                honorific: "",
                fname: "",
                lname: "",
                mi: "",
                designation: "",
                email: "",
                role: "",
            },
            buyer_profile: {
                categories: [],
            },
            participation_info: {
                participation_goals: [],
                participation_goal_others: "",
                about_events: [],
                about_event_others: "",
                interested: "",
                if_yes: "",
            },
            users: {
                reviewer: [],
                onholder: [],
                approver: [],
                disapprover: [],
                lastupdate: [],
            },
        };
    },
    computed: {
        region_disabled() {
            if (this.company_info.country === 148) {
                return false;
            } else {
                this.company_info.fa_region = "";
                return true;
            }
        },
        check_participation_goal_others() {
            if (
                this.participation_info.participation_goals.includes(18) ===
                true
            ) {
                this.$nextTick(() => {
                    document
                        .getElementById("participation_goal_others")
                        .focus();
                });
                return false;
            } else {
                this.participation_info.participation_goal_others = "";
                return true;
            }
        },
        check_about_event_others() {
            if (this.participation_info.about_events.includes(9) === true) {
                this.$nextTick(() => {
                    document.getElementById("about_events_others").focus();
                });
                return false;
            } else {
                this.participation_info.about_events_others = "";
                return true;
            }
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
    validations: {
        company_info: {
            nature_business_other: {
                required: requiredIf(function () {
                    return this.company_info.nature_business.includes(16);
                }),
            },
            ph_supplier_name: {
                required: requiredIf(function () {
                    return this.company_info.has_ph_business_supplier === 1;
                }),
            },
            annual_purchase_existing_supplier: {
                required: requiredIf(function () {
                    return this.company_info.has_ph_business_supplier === 1;
                }),
            },
            // You can add more fields if needed
        },
    },

    watch: {
        "company_info.nature_business"(val) {
            if (val.includes(16)) {
                this.company_info.nature_business_disabled = false;
            } else {
                this.company_info.nature_business_disabled = true;
                this.company_info.nature_business_other = "";
            }
        },
    },
    mounted() {
        //console.log(this.id)
    },
    created() {
        this.getBuyer();
        this.getCountries();
        this.getRegions();
        this.getOrganizationTypes();
        this.getNatureBusinesses();
        this.getHonorifics();
        this.getRoles();
        this.getCategories();
        this.getParticipations();
        this.getLearnEvents();
        this.getCompanyAnnualSales();
        this.getAnnualPurchaseExistingSupplier();
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
        onChangeHasPhBusinessSupplier() {
            if (this.company_info.has_ph_business_supplier === 1) {
                this.$nextTick(() => {
                    this.$v.company_info.ph_supplier_name.$touch();
                    this.$v.company_info.annual_purchase_existing_supplier.$touch();
                });
            } else {
                this.company_info.ph_supplier_name = null;
                this.company_info.annual_purchase_existing_supplier = null;

                this.$v.company_info.ph_supplier_name.$reset();
                this.$v.company_info.annual_purchase_existing_supplier.$reset();
            }
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
        getCategories() {
            axios
                .get("/api/categories/group-all")
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
        getParticipations() {
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
        getLearnEvents() {
            axios
                .get("/api/learn_about_event")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.about_events = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getBuyer() {
            this.isLoading = true;
            axios
                .get(
                    `/admin/registration/buyer-information/${this.id}/${this.event_fair_code}`
                )
                .then((response) => {
                    console.log(response.data);
                    this.isLoading = false;
                    var buyer = response.data.buyer;
                    this.buyerclass = response.data.buyerclass ?? 0;
                    this.status = response.data.status;
                    this.from_backend = response.data.data_from;
                    this.created_at = response.data.created_at;
                    this.updated_at = response.data.updated_at;
                    this.permissions = response.data.permissions;
                    //COMPANY INFORMATION
                    this.company_info.co_name = buyer.co_name;
                    this.company_info.co_email = buyer.co_email;
                    this.company_info.country = buyer.country;
                    this.company_info.website = buyer.website;
                    this.company_info.facebook = buyer.facebook;
                    this.company_info.instagram = buyer.instagram;
                    this.company_info.linkedin = buyer.linkedin;
                    this.company_info.other_social = buyer.other_social;
                    this.company_info.fa_state = buyer.state;
                    this.company_info.fa_city = buyer.city;
                    this.company_info.fa_region = buyer.region;
                    this.company_info.area_code = buyer.area_code;
                    this.company_info.fa_street = buyer.street;
                    this.company_info.fa_zipcode = buyer.zipcode;
                    this.company_info.country_code = buyer.country_code;
                    this.company_info.phone_no = buyer.phone_no;
                    this.company_info.year_estab = buyer.year_established;
                    this.company_info.organization_type =
                        buyer.organization_type_id;
                    this.company_info.honorific = buyer.honorific;
                    this.company_info.fname = buyer.fname;
                    this.company_info.lname = buyer.lname;
                    this.company_info.mi = buyer.mi;
                    this.company_info.designation = buyer.designation;
                    this.company_info.email = buyer.email;
                    this.company_info.role = buyer.company_role_id;
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
                            this.company_info.nature_business_other =
                                response.data.nature_business[n]["remarks"];
                        }
                        this.company_info.nature_business.push(
                            response.data.nature_business[n][
                                "nature_business_id"
                            ]
                        );
                    }
                    this.company_info.company_annual_sale =
                        buyer.company_annual_sale_id;

                    this.company_info.annual_purchase_existing_supplier =
                        buyer.annual_purchase_from_existing_supplier_id;

                    this.company_info.has_ph_business_supplier =
                        buyer.has_ph_business_supplier;

                    this.company_info.ph_supplier_name = buyer.ph_supplier_name;
                    //BUYER PROFILE
                    if (response.data.category_subcategory) {
                        for (
                            var s = 0;
                            s < response.data.category_subcategory.length;
                            s++
                        ) {
                            this.buyer_profile.categories.push(
                                response.data.category_subcategory[s][
                                    "sub_category_id"
                                ]
                            );
                        }
                    }
                    //PARTICIPATION GOALS
                    if (response.data.participation_goal) {
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
                                this.participation_info.participation_goal_others =
                                    response.data.participation_goal[p][
                                        "remarks"
                                    ];
                            }
                            this.participation_info.participation_goals.push(
                                response.data.participation_goal[p][
                                    "participation_id"
                                ]
                            );
                        }
                    }
                    //HOW DID YOU LEARN ABOUT THE EVENTS
                    if (response.data.learn_about_event) {
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
                                this.participation_info.about_event_others =
                                    response.data.learn_about_event[e][
                                        "remarks"
                                    ];
                            }
                            this.participation_info.about_events.push(
                                response.data.learn_about_event[e][
                                    "learn_about_event_id"
                                ]
                            );
                        }
                    }
                    this.participation_info.interested =
                        buyer.interested_meeting;
                    this.participation_info.if_yes = buyer.need_interpreter;
                    this.users.reviewer = buyer.reviewer
                        ? buyer.reviewer.name
                        : "";
                    this.users.onholder = buyer.onholder
                        ? buyer.onholder.name
                        : "";
                    this.users.approver = buyer.approver
                        ? buyer.approver.name
                        : "";
                    this.users.disapprover = buyer.disapprover
                        ? buyer.disapprover.name
                        : "";
                    this.users.lastupdate = buyer.last_update
                        ? buyer.last_update.name
                        : "";
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        generateQr() {
            this.isLoading = true;
            this.msg = "Generating QR code...";

            axios
                .post(
                    `/admin/registration/buyers/${this.id}/${this.event_fair_code}/generate-qr`
                )
                .then((response) => {
                    this.isLoading = false;

                    Vue.$toast.success(
                        response.data.message ||
                            "Buyer QR code generated successfully.",
                        {
                            position: "top-right",
                        }
                    );

                    console.log("QR Response:", response.data);
                })
                .catch((error) => {
                    this.isLoading = false;

                    console.error(error);

                    Vue.$toast.error(
                        error.response?.data?.message ||
                            "Failed to generate buyer QR code.",
                        {
                            position: "top-right",
                        }
                    );
                });
        },
        reSendRegLink() {
            this.$swal({
                title: "Are you sure you want to resend the registration link?",
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
                        this.msg = "Resending registration link...";
                        axios
                            .get(
                                "/admin/registration/resend/" +
                                    this.id +
                                    "/link"
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration link successfully re-sent.",
                                        {
                                            position: "top-right",
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.msg = "Please wait...";
                    }
                },
            });
        },
        doReview() {
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
                preConfirm: (value) => {
                    if (value) {
                        this.isLoading = true;
                        this.msg = "Reviewing application...";
                        axios
                            .get(
                                "/admin/registration/review/" +
                                    this.id +
                                    "/application",
                                {
                                    params: {
                                        fair_code: this.event_fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Registration application successfully mark as reviewed.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getBuyer(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.msg = "Please wait...";
                    }
                },
            });
        },
        doRevertToIncomplete() {
            this.$swal({
                title: "Are you sure you want to revert back the purchaser/buyer status to Incomplete?",
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
                                        fair_code: this.event_fair_code,
                                    },
                                }
                            )
                            .then((response) => {
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Purchaser/Buyer status reverted back to Incomplete.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.getBuyer(),
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
        doApprove() {
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
                                        fair_code: this.event_fair_code,
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
                                            onDismiss: this.getBuyer(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.msg = "Please wait...";
                    }
                },
            });
        },
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
                                        fair_code: this.event_fair_code,
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
                                            onDismiss: this.getBuyer(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.msg = "Please wait...";
                    }
                },
            });
        },
        // doHold() {
        //     this.$swal({
        //         title: "Are you sure you want to on hold this application?",
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
        //                 this.msg = "On holding application...";
        //                 axios
        //                     .get(
        //                         "/admin/registration/onhold/" +
        //                             this.id +
        //                             "/application",
        //                         {
        //                             params: {
        //                                 fair_code: this.event_fair_code,
        //                             },
        //                         }
        //                     )
        //                     .then((response) => {
        //                         if (response.status === 200) {
        //                             this.isLoading = false;
        //                             Vue.$toast.success(
        //                                 "Registration application successfully on hold.",
        //                                 {
        //                                     position: "top-right",
        //                                     onDismiss: this.getBuyer(),
        //                                 }
        //                             );
        //                         }
        //                     })
        //                     .catch((error) => {
        //                         console.log(error);
        //                     });
        //                 this.msg = "Please wait...";
        //             }
        //         },
        //     });
        // },
        doUpdate() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                Vue.$toast.error("Please complete all required fields.", {
                    position: "top-right",
                });
                return;
            }
            this.$swal({
                title: "Are you sure you want to update the purchaser information?",
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
                        this.msg = "Updating information...";
                        let formData = new FormData();
                        formData.append("user_id", this.id);
                        formData.append("fair_code", this.event_fair_code);
                        formData.append("status", this.status);
                        formData.append("buyerclass", this.buyerclass);
                        formData.append("to_pending", this.to_pending ? 1 : 0);

                        formData.append(
                            "company_info",
                            JSON.stringify(this.company_info)
                        );
                        formData.append(
                            "buyer_profile",
                            JSON.stringify(this.buyer_profile)
                        );
                        formData.append(
                            "participation_info",
                            JSON.stringify(this.participation_info)
                        );
                        axios
                            .post("/admin/registration/buyers/update", formData)
                            .then((response) => {
                                //console.log(response.data)
                                if (response.status === 200) {
                                    this.isLoading = false;
                                    Vue.$toast.success(
                                        "Purchaser/Buyer information successfully updated.",
                                        {
                                            position: "top-right",
                                        }
                                    );
                                    this.company_info.nature_business = [];
                                    this.buyer_profile.categories = [];
                                    this.participation_info.participation_goals =
                                        [];
                                    this.participation_info.about_events = [];
                                    this.getBuyer();
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                        this.msg = "Please wait...";
                    }
                },
            });
        },
        scrollToTop() {
            window.scroll({ top: 300, behavior: "smooth" });
        },
    },
};
</script>

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
                            <a class="nav-link active" data-bs-toggle="tab" href="#company_info" role="tab">
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down">Company Info <span class="badge bg-danger" v-if="$v.company_info.$anyError">Error/s</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#buyer_profile" role="tab">
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down">Purchaser/Buyer Profile <span class="badge bg-danger" v-if="$v.buyer_profile.$anyError">Error/s</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#participation_info" role="tab">
                                <span class="hidden-sm-up"></span>
                                <span class="hidden-xs-down">Participation Information <span class="badge bg-danger" v-if="$v.participation_info.$anyError">Error/s</span></span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="company_info" role="tabpanel">
                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Company Name*</label>
                                    <input type="text" class="form-control text-uppercase" :class="{ 'is-invalid': $v.company_info.co_name.$error }" v-model="company_info.co_name">
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.co_name.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.co_name.required">Company name is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Company E-mail Address*</label>
                                    <input type="text" class="form-control text-lowercase" :class="{ 'is-invalid': $v.company_info.co_email.$error }" v-model="company_info.co_email">
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.co_email.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.co_email.required">Company e-mail address is required.</div>
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.co_email.email">Company e-mail address is invalid.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Country*</label>
                                    <select class="form-select" id="country_code" :class="{ 'is-invalid': $v.company_info.country.$error }" v-model="company_info.country">
                                        <option :value="''"></option>
                                        <option v-for="country in countries" :key="country.id" :value="country.id">{{ country.name }}</option>
                                    </select>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.country.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.country.required">Country is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Office Address*</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.company_info.fa_state.$error }" v-model="company_info.fa_state">
                                        <label>Province/State</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.fa_state.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.fa_state.required">Province/State is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-none d-sm-none d-md-block">&nbsp;</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.company_info.fa_city.$error }" v-model="company_info.fa_city">
                                        <label>City/Town</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.fa_city.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.fa_city.required">City/Town is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-5">
                                    <div class="form-floating">
                                        <select class="form-select" :class="{ 'is-invalid': $v.company_info.fa_region.$error }" v-model="company_info.fa_region" :disabled="region_disabled">
                                            <option selected :value="''"></option>
                                            <option v-for="region in regions" :key="region.id" :value="region.name">{{ region.name }}</option>
                                        </select>
                                        <label>Region</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.fa_region.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.fa_region.required">Region is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-5">
                                    <div class="form-floating">
                                        <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.company_info.fa_street.$error }" v-model="company_info.fa_street">
                                        <label>Street</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.fa_street.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.fa_street.required">Street is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-2">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" :class="{ 'is-invalid': $v.company_info.fa_zipcode.$error }" v-model="company_info.fa_zipcode">
                                        <label>Zip code</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.fa_zipcode.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.fa_zipcode.required">Zip code is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-4">
                                    <label class="form-label fw-bold">Phone Number*</label>
                                    <div class="form-floating">
                                        <select class="form-select" id="country_code" :class="{ 'is-invalid': $v.company_info.country_code.$error }" v-model="company_info.country_code">
                                            <option :value="''">--</option>
                                            <option v-for="country in countries" :key="country.id" :value="country.dial">{{ country.iso3 }} ({{ country.dial }})</option>
                                        </select>
                                        <label>Country code</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.country_code.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.country_code.required">Country code is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label d-none d-sm-none d-md-block">&nbsp;</label>
                                    <div class="form-floating">
                                        <input type="number" :class="{ 'is-invalid': $v.company_info.area_code.$error }" class="form-control" v-model="company_info.area_code">
                                        <label>Area code</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.area_code.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.area_code.required">Area code is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label d-none d-sm-none d-md-block">&nbsp;</label>
                                    <div class="form-floating">
                                        <input type="number" :class="{ 'is-invalid': $v.company_info.phone_no.$error }" class="form-control" v-model="company_info.phone_no">
                                        <label>Phone no.</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.phone_no.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.phone_no.required">Phone number is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">Website</label>
                                    <input type="text" :class="{ 'is-invalid': $v.company_info.website.$error }" class="form-control text-lowercase" v-model="company_info.website">
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.website.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.website.required">Website is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Year Established*</label>
                                    <input type="number" :class="{ 'is-invalid': $v.company_info.year_estab.$error }" class="form-control" v-model="company_info.year_estab">
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.year_estab.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.year_estab.required">Year established is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text">https://www.facebook.com/</span>
                                        <input type="text" class="form-control text-lowercase" v-model="company_info.facebook" placeholder="username" maxlength="200">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text">https://www.instagram.com/</span>
                                        <input type="text" class="form-control text-lowercase" v-model="company_info.instagram" placeholder="username" maxlength="200">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Linkedin</label>
                                    <div class="input-group">
                                        <span class="input-group-text">https://www.linked.com/in/</span>
                                        <input type="text" class="form-control text-lowercase" v-model="company_info.linkedin" placeholder="username" maxlength="200">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Other social media account/s</label>
                                    <input type="text" class="form-control" v-model="company_info.other_social">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Type of Organization*</label>
                                    <select class="form-select" :class="{ 'is-invalid': $v.company_info.organization_type.$error }" v-model="company_info.organization_type">
                                        <option :value="''"></option>
                                        <option v-for="orgtype in organization_types" :key="orgtype.id" :value="orgtype.id">{{ orgtype.name }}</option>
                                    </select>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.organization_type.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.organization_type.required">Type of organization is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Nature of Business*</label>
                                    <div class="row">
                                        <div class="col-6" v-for="nbusiness in nature_businesses" :key="nbusiness.id">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" v-model="company_info.nature_business" :value="nbusiness.id" :id="'nature_business'+nbusiness.id">
                                                <label class="form-check-label mb-0 align-middle" :for="'nature_business'+nbusiness.id">{{ nbusiness.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.nature_business.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.nature_business.required">Nature of business is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Company Representative*</label>
                                    <div class="form-floating">
                                        <select class="form-select" :class="{ 'is-invalid': $v.company_info.honorific.$error }" v-model="company_info.honorific">
                                            <option :value="''"></option>
                                            <option v-for="title in honorifics" :key="title.id" :value="title.name">{{ title.name }}</option>
                                        </select>
                                        <label>Title</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.honorific.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.honorific.required">Title is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label d-none d-sm-none d-md-block">&nbsp;</label>
                                    <div class="form-floating">
                                        <input type="text" :class="{ 'is-invalid': $v.company_info.fname.$error }" class="form-control text-capitalize" v-model="company_info.fname">
                                        <label>Firstname</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.fname.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.fname.required">Firstname is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label d-none d-sm-none d-md-block">&nbsp;</label>
                                    <div class="form-floating">
                                        <input type="text" :class="{ 'is-invalid': $v.company_info.lname.$error }" class="form-control text-capitalize" v-model="company_info.lname">
                                        <label>Lastname</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.lname.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.lname.required">Lastname is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label d-none d-sm-none d-md-block">&nbsp;</label>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" v-model="company_info.mi">
                                        <label>M.I.</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" :class="{ 'is-invalid': $v.company_info.designation.$error }" class="form-control" v-model="company_info.designation">
                                        <label>Designation</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.designation.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.designation.required">Designation is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" :class="{ 'is-invalid': $v.company_info.email.$error }" v-model="company_info.email" @blur="$v.company_info.email.$touch">
                                        <label>E-mail address</label>
                                    </div>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.email.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.email.required">E-mail address is required.</div>
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.email.email">E-mail address is invalid.</div>
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.email.isExist">E-mail address is already used.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Role in the Company's Purchasing Activities</label>
                                    <select class="form-select" :class="{ 'is-invalid': $v.company_info.role.$error }" v-model="company_info.role">
                                        <option :value="''"></option>
                                        <option v-for="comprole in roles" :key="comprole.id" :value="comprole.id">{{ comprole.name }}</option>
                                    </select>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.company_info.role.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.company_info.role.required">Role in the company's purchasing activities is required.</div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="buyer_profile" role="tabpanel">
                            <div class="row g-3 mt-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                            <div v-if="$v.buyer_profile.categories.$error">
                                                <div class="fw-light invalid-feedback d-block" v-if="!$v.buyer_profile.categories.required">Purchaser/Buyer profile is required.</div>
                                            </div>
                                        </transition>
                                        <div class="col-md-4" v-for="category in categories" :key="category.id">
                                            <label class="form-label fw-bold">{{ category.name }}</label>
                                            <div class="form-check" v-for="subcategory in category.sub_categories" :key="subcategory.id">
                                                <input class="form-check-input" type="checkbox" :id="'sub_categories_'+subcategory.id" :value="subcategory.id" v-model="buyer_profile.categories">
                                                <label class="form-check-label align-middle" :for="'sub_categories_'+subcategory.id">{{ subcategory.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="participation_info" role="tabpanel">
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Participation Goals*</label>
                                    <div class="row">
                                        <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                            <div v-if="$v.participation_info.participation_goals.$error">
                                                <div class="fw-light invalid-feedback d-block" v-if="!$v.participation_info.participation_goals.required">Participation goals is required.</div>
                                            </div>
                                        </transition>
                                        <div class="col-md-12" v-for="goals in participation_goals" :key="goals.id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="'participation_goal_'+goals.id" :value="goals.id" v-model="participation_info.participation_goals">
                                                <div v-if="goals.id === 11" class="d-flex flex-row align-items-center">
                                                    <label class="form-check-label" :for="'participation_goal_'+goals.id">{{ goals.name }}</label>&nbsp;&nbsp;
                                                    <input id="participation_goal_others" :class="{ 'is-invalid': $v.participation_info.participation_goal_others.$error }" class="form-control" type="text" placeholder="Please specify other/s" v-model="participation_info.participation_goal_others" :readonly="check_participation_goal_others">
                                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                                        <div v-if="$v.participation_info.participation_goal_others.$error">
                                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.participation_info.participation_goal_others.required">Please specify other/s.</div>
                                                        </div>
                                                    </transition>
                                                </div>
                                                <label v-else class="form-check-label align-middle" :for="'participation_goal_'+goals.id">{{ goals.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">How did you learn about the event?*</label>
                                    <div class="row">
                                        <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                            <div v-if="$v.participation_info.about_events.$error">
                                                <div class="fw-light invalid-feedback d-block" v-if="!$v.participation_info.about_events.required">How did you learn about the event is required.</div>
                                            </div>
                                        </transition>
                                        <div class="col-md-12" v-for="learn_event in about_events" :key="learn_event.id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="'about_events_'+learn_event.id" :value="learn_event.id" v-model="participation_info.about_events">
                                                <div v-if="learn_event.id === 9" class="d-flex flex-row align-items-center">
                                                    <label class="form-check-label" :for="'about_events_'+learn_event.id">{{ learn_event.name }}</label>&nbsp;&nbsp;
                                                    <input id="about_events_others" :class="{ 'is-invalid': $v.participation_info.about_event_others.$error }" class="form-control" type="text" placeholder="Please specify other/s" v-model="participation_info.about_event_others" :readonly="check_about_event_others">
                                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                                        <div v-if="$v.participation_info.about_event_others.$error">
                                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.participation_info.about_event_others.required">Please specify other/s.</div>
                                                        </div>
                                                    </transition>
                                                </div>
                                                <label v-else class="form-check-label align-middle" :for="'about_events_'+learn_event.id">{{ learn_event.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Interested in pre-arrange meetings during the event dates?*</label>
                                    <select class="form-select" :class="{ 'is-invalid': $v.participation_info.interested.$error }" v-model="participation_info.interested">
                                        <option :value="''"></option>
                                        <option :value="1">Yes, I am interested in participating in pre-arranged business meetings.</option>
                                        <option :value="2">No</option>
                                    </select>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.participation_info.interested.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.participation_info.interested.required">Interested in pre-arrange meetings during the event dates is required.</div>
                                        </div>
                                    </transition>
                                </div>
                                <div class="col-md-12" v-if="participation_info.interested === 1">
                                    <label class="form-label fw-bold">If yes*</label>
                                    <select class="form-select" :class="{ 'is-invalid': $v.participation_info.if_yes.$error }" v-model="participation_info.if_yes">
                                        <option :value="''"></option>
                                        <option :value="1">I need an Interpreter</option>
                                        <option :value="2">No need for an Interpreter</option>
                                    </select>
                                    <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                                        <div v-if="$v.participation_info.if_yes.$error">
                                            <div class="fw-light invalid-feedback d-block" v-if="!$v.participation_info.if_yes.required">This field is required.</div>
                                        </div>
                                    </transition>
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
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" :value="1" v-model="to_pending" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Set account status to Pending
                                </label>
                            </div>
                        </div>
                    </div>    
                    <div class="form-group row">
                        <hr class="w-100 mt-3">
                        <div class="d-grid gap-2 mb-2">
                            <button class="btn btn-success text-white" type="button" @click="doSave">Save Purchaser/Buyer Info</button>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="/admin/registration/buyers" class="btn btn-secondary" role="button">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'
import BlockUI from 'vue-blockui'
import Vuelidate from 'vuelidate'
import { required, email, url, numeric, requiredIf } from 'vuelidate/lib/validators'

Vue.use(require('vue-moment'))
Vue.use(VueSweetalert2)
Vue.use(VueToast)
Vue.use(BlockUI)
Vue.use(Vuelidate)

export default {
    data() {
        return {
            isLoading: false,
            msg: 'Please wait...',
            countries: [],
            regions: [],
            to_pending: 0,
            organization_types: [],
            nature_businesses: [],
            honorifics: [],
            roles: [],
            categories: [],
            participation_goals: [],
            about_events: [],
            company_info: {
                co_name: '',
                co_email: '',
                country: '',
                fa_state: '',
                fa_city: '',
                fa_region: '',
                fa_street: '',
                fa_zipcode: '',
                country_code: '',
                area_code: '',
                phone_no: '',
                website: '',
                year_estab: '',
                facebook: '',
                instagram: '',
                linkedin: '',
                other_social: '',
                organization_type: '',
                nature_business: [],
                honorific: '',
                fname: '',
                lname: '',
                mi: '',
                designation: '',
                email: '',
                role: '',
            },
            buyer_profile: {
                categories: [],
            },
            participation_info: {
                participation_goals: [],
                participation_goal_others: '',
                about_events: [],
                about_event_others: '',
                interested: '',
                if_yes: '',
            }
        }
    },
    computed: {
        region_disabled() {
            if (this.company_info.country === 148) {
                return false
            } else {
                this.company_info.fa_region = ''
                return true
            }
        },
        check_participation_goal_others() {
            if (this.participation_info.participation_goals.includes(11) === true) {
                this.$nextTick(() => {
                    document.getElementById('participation_goal_others').focus()
                })
                return false
            } else {
                this.participation_info.participation_goal_others = ''
                return true
            }
        },
        check_about_event_others() {
            if (this.participation_info.about_events.includes(9) === true) {
                this.$nextTick(() => {
                    document.getElementById('about_events_others').focus()
                })
                return false
            } else {
                this.participation_info.about_events_others = ''
                return true
            }
        },
    },
    mounted() {
        //console.log(this.id)
    },
    validations: {
        company_info: {
            co_name: { required },
            co_email: { required, email },
            country: { required },
            fa_state: { required },
            fa_city: { required },
            fa_region: {
                required: requiredIf( function() {
                    if (this.company_info.country === 148) {
                        return true
                    } else {
                        return false
                    }
                })
            },
            fa_street: { required },
            fa_zipcode: { required },
            country_code: { required },
            area_code: { required },
            phone_no: { required },
            website: { required },
            year_estab: { required },
            organization_type: { required },
            nature_business: { required },
            honorific: { required },
            fname: { required },
            lname: { required },
            designation: { required },
            email: { 
                required, email,
                isExist (value) {
                    if (value === '') {
                        return true
                    } else {
                        return axios.get('/api/check-company-email-unique/'+value+'/buyer')
                            .then(response => {
                                if (response.status === 200) {
                                    return response.data
                                }
                            }).catch(err => {
                                return true
                            })
                    }
                }
            },
            role: { required },
        },
        buyer_profile: {
            categories: { required },
        },
        participation_info: {
            participation_goals: { required },
            participation_goal_others: {
                required: requiredIf( function() {
                    return this.participation_info.participation_goals.includes(11)
                })
            },
            about_events: { required },
            about_event_others: {
                required: requiredIf( function() {
                    return this.participation_info.about_events.includes(9)
                })
            },
            interested: { required },
            if_yes: {
                required: requiredIf( function() {
                    if (this.participation_info.interested === 1) {
                        return true
                    } else {
                        return false
                    }
                })
            },
        }
    },
    created() {
        this.getCountries()
        this.getRegions()
        this.getOrganizationTypes()
        this.getNatureBusinesses()
        this.getHonorifics()
        this.getRoles()
        this.getCategories()
        this.getParticipations()
        this.getLearnEvents()
    },
    methods: {
        getCountries() {
            axios.get('/api/countries')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.countries = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getRegions() {
            axios.get('/api/regions')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.regions = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getOrganizationTypes() {
            axios.get('/api/organization_types')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.organization_types = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getNatureBusinesses() {
            axios.get('/api/nature_businesses')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.nature_businesses = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getHonorifics() {
            axios.get('/api/honorifics')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.honorifics = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getRoles() {
            axios.get('/api/roles')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.roles = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getCategories() {
            axios.get('/api/categories')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.categories = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getParticipations() {
            axios.get('/api/participation_goals')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.participation_goals = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getLearnEvents() {
            axios.get('/api/learn_about_event')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.about_events = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getBuyer() {
            this.isLoading = true
            axios.get('/api/user-information/'+this.id)
            .then(response => {
                console.log(response.data)
                this.isLoading = false
                var buyer = response.data.buyer
                
                this.status = response.data.status
                this.created_at = response.data.created_at
                this.updated_at = response.data.updated_at
                //COMPANY INFORMATION
                this.company_info.co_name = buyer.co_name
                this.company_info.co_email = buyer.co_email
                this.company_info.country = buyer.country
                this.company_info.website = buyer.website
                this.company_info.facebook = buyer.facebook
                this.company_info.instagram = buyer.instagram
                this.company_info.linkedin = buyer.linkedin
                this.company_info.other_social = buyer.other_social
                this.company_info.fa_state = buyer.state
                this.company_info.fa_city = buyer.city
                this.company_info.fa_region = buyer.region
                this.company_info.area_code = buyer.area_code
                this.company_info.fa_street = buyer.street
                this.company_info.fa_zipcode = buyer.zipcode
                this.company_info.country_code = buyer.country_code
                this.company_info.phone_no = buyer.phone_no
                this.company_info.year_estab = buyer.year_established
                this.company_info.organization_type = buyer.organization_type_id
                this.company_info.honorific = buyer.honorific
                this.company_info.fname = buyer.fname
                this.company_info.lname = buyer.lname
                this.company_info.mi = buyer.mi
                this.company_info.designation = buyer.designation
                this.company_info.email = buyer.email
                this.company_info.role = buyer.company_role_id
                if (response.data.nature_business) {
                    for (var n = 0; n < response.data.nature_business.length; n++) {
                        this.company_info.nature_business.push(response.data.nature_business[n]['nature_business_id'])
                    }
                }
                //BUYER PROFILE
                if (response.data.category_subcategory) {
                    for (var s = 0; s < response.data.category_subcategory.length; s++) {
                        this.buyer_profile.categories.push(response.data.category_subcategory[s]['sub_category_id'])
                    }
                }
                //PARTICIPATION GOALS
                if (response.data.participation_goal) {
                    for (var p = 0; p < response.data.participation_goal.length; p++) {
                        if (response.data.participation_goal[p]['participation_id'] === 11) {
                            this.participation_info.participation_goal_others = response.data.participation_goal[p]['remarks']
                        }
                        this.participation_info.participation_goals.push(response.data.participation_goal[p]['participation_id'])
                    }
                }
                //HOW DID YOU LEARN ABOUT THE EVENTS
                if (response.data.learn_about_event) {
                    for (var e = 0; e < response.data.learn_about_event.length; e++) {
                        if (response.data.learn_about_event[e]['learn_about_event_id'] === 9) {
                            this.participation_info.about_event_others = response.data.learn_about_event[e]['remarks']
                        }
                        this.participation_info.about_events.push(response.data.learn_about_event[e]['learn_about_event_id'])
                    }
                }
                this.participation_info.interested = buyer.interested_meeting
                this.participation_info.if_yes = buyer.need_interpreter
                this.users.reviewer = buyer.reviewer ? buyer.reviewer.name : ''
                this.users.onholder = buyer.onholder ? buyer.onholder.name : ''
                this.users.approver = buyer.approver ? buyer.approver.name : ''
                this.users.disapprover = buyer.disapprover ? buyer.disapprover.name : ''
                this.users.lastupdate = buyer.last_update ? buyer.last_update.name : ''
            })
            .catch(error => {
                console.log(error);
            });
        },
        doSave() {
            this.$swal({
                title: 'Are you sure you want to save the purchaser/buyer information?',
                icon: 'question',
                showCancelButton: true,
                customClass: {
                    title: 'fs-5',
                    confirmButton: 'btn btn-sm btn-success text-white m-1',
                    cancelButton: 'btn btn-sm btn-secondary m-1'
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        this.$v.company_info.$touch()
                        this.$v.buyer_profile.$touch()
                        this.$v.participation_info.$touch()
                        this.isLoading = true
                        this.msg = 'Updating information...'
                        if (!this.$v.company_info.$invalid && !this.$v.buyer_profile.$invalid && !this.$v.participation_info.$invalid) {
                            let formData = new FormData()
                                formData.append('set_to_pending', this.to_pending)
                                formData.append('company_info', JSON.stringify(this.company_info))
                                formData.append('buyer_profile', JSON.stringify(this.buyer_profile))
                                formData.append('participation_info', JSON.stringify(this.participation_info))
                            axios.post('/admin/registration/buyers/store', formData)
                            .then(response => {
                                //console.log(response.data)
                                if (response.status === 200) {
                                    this.isLoading = false
                                    Vue.$toast.success('Supplier/Exhibitor information successfully saved.', {
                                        position: 'top-right',
                                    });
                                }
                            })
                            .catch(error => {
                                console.log(error)
                            });
                            this.msg = 'Please wait...'
                        } else {
                            Vue.$toast.error('Please review the required fields.', {
                                position: 'top-right',
                            });
                            this.msg = 'Please wait...'
                            this.scrollToTop()
                            this.isLoading = false
                        }
                    }
                }
            })
        },
        scrollToTop() {
            window.scroll({ top: 300, behavior: 'smooth' })
        }
    }
}
</script>
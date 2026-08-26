<template>
    <div class="section container registration-form" id="regDiv">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <form-wizard v-if="this.submittedForm == false" title="" subtitle="" color="#9daa39" errorColor="#dc3545" stepSize="xs" :startIndex="0" finish-button-text="Submit" @on-loading="onLoad" @on-complete="onComplete">
            <tab-content title="Conference Delegates" :before-change="doStep1">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Delegates</h1>
                            <p><span style="color: red;">*</span>&nbsp;Required</p>
                        </div>
                        <div class="col-12" v-if="this.participantForm === false">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label text-uppercase fw-bold">Business Type&nbsp;<span style="color: red;">*</span></label>
                                    <br>
                                    <input type="radio" class="form-check-input" v-model="step1.type" value="local" id="typeLocal" @change="onChangeType">
                                    <label class="form-check-label mb-0 align-middle" for="typeLocal">Local</label>
                                    <br>
                                    <input type="radio" class="form-check-input" v-model="step1.type" value="foreign" id="typeForeign" @change="onChangeType">
                                    <label class="form-check-label mb-0 align-middle" for="typeForeign">Foreign</label>
                                    <br>
                                    <div v-if="$v.step1.type.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step1.type.required">Business Type is required.</div>
                                    </div>
                                </div>
                                <div v-if="this.step1.participant_count > 0 && this.step1.participant_count < 6" class="col-12 col-lg-6 mt-5">
                                    <label class="form-label text-uppercase fw-bold">Promo Code</label>
                                    <input type="text" class="form-control text-uppercase" v-model="promo_code_temp" maxlength="100" @input="onChangePromoCode">
                                    <div v-if="promo_code_error != ''">
                                        <div class="fw-light invalid-feedback d-block">{{ promo_code_error }}</div>
                                    </div>
                                    <div class="text-end mt-2">
                                        <button type="button" class="btn btn-outline-dark btn-sm" @click="checkPromoCode">Add Promo Code</button>
                                    </div>
                                </div>
                                <div v-if="step1.participant_count > 0" class="col-12 mt-5">
                                    <table class="table">
                                        <thead>
                                            <th>Delegates</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(participant, index) in this.step1.participants" :key="index">
                                                <td width="80%">
                                                    {{ participant.fname }}&nbsp;{{ participant.lname }}
                                                </td>
                                                <td width="20%">
                                                    <i class="fas fa-trash text-red-500 cursor-pointer" @click="doRemoveParticipant(index)"></i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 mt-5" v-if="this.step1.type !== '' && this.step1.participant_count < 6">
                                    <button type="button" class="btn btn-outline-dark btn-sm" @click="doToggleParticipantDetails(true)">Add Delegate</button>
                                    <br>
                                    <div v-if="$v.step1.participant_count.$error">
                                        <div class="fw-light invalid-feedback d-block">At least 1 Delegate is required.</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12" v-else>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h1 class="h3">Add Delegate Details</h1>
                                </div>
                                <div class="col-6 col-lg-3 mt-3">
                                    <label class="form-label text-uppercase fw-bold">Salutation&nbsp;<span style="color: red;">*</span></label>
                                    <select class="form-select" v-model="participant.salutation" :class="{ 'is-invalid': $v.participant.salutation.$error }">
                                        <option :value="''">-- Select --</option>
                                        <option :value="'Mr'">Mr</option>
                                        <option :value="'Ms'">Ms</option>
                                        <!-- <option :value="'Dr'">Dr</option>
                                        <option :value="'Prof'">Prof</option>
                                        <option :value="'Atty'">Atty</option> -->
                                    </select>
                                    <div v-if="$v.participant.salutation.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.salutation.required">Salutation is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">First Name&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.participant.fname.$error }" v-model="participant.fname" maxlength="100">
                                    <div v-if="$v.participant.fname.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.fname.required">First name is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Last Name&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.participant.lname.$error }" v-model="participant.lname" maxlength="100">
                                    <div v-if="$v.participant.lname.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.lname.required">Last name is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <label class="form-label text-uppercase fw-bold">Nationality/Country&nbsp;<span style="color: red;">*</span></label>
                                    <select class="form-select" v-model="participant.country" :class="{ 'is-invalid': $v.participant.country.$error }">
                                        <option :value="''">-- Select --</option>
                                        <option v-for="country in countries" :key="country.id" :value="country.name">{{ country.name }}</option>
                                    </select>
                                    <div v-if="$v.participant.country.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.country.required">Country is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <label class="form-label text-uppercase fw-bold">Designation&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.participant.designation.$error }" v-model="participant.designation" maxlength="100">
                                    <div v-if="$v.participant.designation.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.designation.required">Designation is required.</div>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <label class="form-label text-uppercase fw-bold">Email Address&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-lowercase" :class="{ 'is-invalid': $v.participant.email.$error }" v-model="participant.email" maxlength="150">
                                    <div v-if="$v.participant.email.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.email.required">Email address is required.</div>
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.email.email">Invalid email address format.</div>
                                    </div>
                                </div>

                                <div class="col-md-8 mt-3">
                                    <div class="row g-2">
                                        <div class="col-5">
                                            <label for="country_code_mobile" class="form-label text-uppercase fw-bold">Mobile Number*</label>
                                            <select class="form-select" id="country_code_mobile" v-model="participant.country_code_mobile" :class="{ 'is-invalid': $v.participant.country_code_mobile.$error }">
                                                <option :value="''">Country code</option>
                                                <option v-for="country in countries" :key="country.id" :value="country.dial">{{ country.iso3 }} ({{ country.dial }})</option>
                                            </select>
                                            <div v-if="$v.participant.country_code_mobile.$error">
                                                <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.country_code_mobile.required">Country code is required.</div>
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <label for="mobile_no" class="form-label">&nbsp;</label>
                                            <input type="number" class="form-control" placeholder="Mobile number" id="mobile_no" v-model="participant.mobile_no" :class="{ 'is-invalid': $v.participant.mobile_no.$error }" pattern="[0-9\-]+">
                                            <div v-if="$v.participant.mobile_no.$error">
                                                <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.mobile_no.required">Mobile no. is required.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <label class="form-label text-uppercase fw-bold">Delegate type:&nbsp;<span style="color: red;">*</span></label>
                                            <br>
                                            <input type="radio" class="form-check-input" v-model="participant.addtnl_type" value="Private" id="typePrivate">
                                            <label class="form-check-label mb-0 align-middle" for="typePrivate">Private</label>
                                            <br>
                                            <input type="radio" class="form-check-input" v-model="participant.addtnl_type" value="Government" id="typeGov">
                                            <label class="form-check-label mb-0 align-middle" for="typeGov">Government</label>
                                            <br>
                                            <input type="radio" class="form-check-input" v-model="participant.addtnl_type" value="AcademeStudent" id="typeAcad">
                                            <label class="form-check-label mb-0 align-middle" for="typeAcad">Academe/ Student</label>
                                            <br>
                                            <div v-if="$v.participant.addtnl_type.$error">
                                                <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.addtnl_type.required">Delegate Type is required.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="senior_check" value="yes" v-model="participant.senior">
                                                <label class="form-check-label align-middle" for="senior_check">Senior Citizen</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="pwd_check" value="yes" v-model="participant.pwd">
                                                <label class="form-check-label align-middle" for="pwd_check">Person with Disability</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3" v-if="this.isIDRequired">
                                    <label class="form-label text-uppercase fw-bold">Proof of Identification (Government, Student, Senior Citizen, or PWD):&nbsp;<span style="color: red;">*</span></label>
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
                                        v-model="participant.id_file"
                                        @beforedelete="onBeforeFileDelete($event)"
                                        @select="onFileSelect($event)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">Max size of 1MB and accept image and pdf document only.</div>
                                    <div v-if="$v.participant.id_file.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.participant.id_file.required">Please upload a valid proof of identification (Government ID, Student ID, Senior Citizen ID, or PWD ID).</div>
                                    </div>
                                </div>
                                <div class="col-12 mt-5 text-end">
                                    <button type="button" class="btn btn-outline-dark btn-sm" @click="doSubmitParticipantDetails">Submit</button>
                                    &nbsp;
                                    <button type="button" class="btn btn-outline-dark btn-sm" @click="doToggleParticipantDetails(false)">Cancel</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="this.step1.type != ''" class="col-4 mt-4">
                        <div class="row">
                            <div class="col-12 text-end">
                                <span style="font-weight: bold; font-size: 18px;">{{ this.currency }}&nbsp;{{ formattedAmount }}</span>
                            </div>
                            <div v-if="this.step1.participant_count > 0" class="col-12 text-end">
                                <small>{{ this.step1.participant_count }} x Delegates</small>
                            </div>
                            <div v-if="this.discounts.length > 0" class="col-12 text-end">
                                <div v-for="(discount, index) in discounts" :key="index" class="w-100">
                                    <small>
                                        {{ discount.count }} x {{ discount.desc }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="mb-5"></div>
                </div>
            </tab-content>
            <tab-content title="Preferences / Promotion" :before-change="doStep2">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Preferences / Promotion</h1>
                            <p><span style="color: red;">*</span>&nbsp;Required</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <h4>Preferences</h4>
                            </div>
                            <!-- <div class="col-12 mt-2">
                                <label class="form-label text-uppercase fw-bold">Do you have any dietary restrictions we need to consider?&nbsp;<span style="color: red;">*</span></label>
                                <br>

                                <input type="radio" class="form-check-input" v-model="step2.dietary" value="yes" id="dietaryYes">
                                <label class="form-check-label mb-0 align-middle" for="dietaryYes">Yes</label>
                                <br>
                                <input type="radio" class="form-check-input" v-model="step2.dietary" value="No" id="dietaryNo">
                                <label class="form-check-label mb-0 align-middle" for="dietaryNo">No</label>
                                <br>
                                <div v-if="$v.step2.dietary.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!$v.step2.dietary.required">Dietary Restrictions is required.</div>
                                </div>
                                <br>
                                <input v-if="this.step2.dietary === 'yes'" type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.step2.dietary_details.$error }" v-model="step2.dietary_details" maxlength="100">
                                <div v-if="this.step2.dietary === 'yes' && $v.step2.dietary_details.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!$v.step2.dietary_details.required">Dietary Restrictions is required.</div>
                                </div>
                            </div> -->
                            <div class="col-12 mt-2">
                                <label class="form-label text-uppercase fw-bold">Preferred certificate&nbsp;<span style="color: red;">*</span></label>
                                <br>
                                <input type="radio" class="form-check-input" v-model="step2.certificate" value="digital" id="certificateDigital">
                                <label class="form-check-label mb-0 align-middle" for="certificateDigital">Digital copy</label>
                                <br>
                                <input type="radio" class="form-check-input" v-model="step2.certificate" value="physical" id="certificatePhysical">
                                <label class="form-check-label mb-0 align-middle" for="certificatePhysical">Physical Copy</label>
                                <br>
                                <div v-if="$v.step2.certificate.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!$v.step2.certificate.required">Preferred certificate is required.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-12 mt-5">
                                <h4>Promotion</h4>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="form-label text-uppercase fw-bold">How did you know about the conference?&nbsp;<span style="color: red;">*</span></label>
                                <br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="knowHow_email" value="Email Invitation" v-model="step2.knowHow">
                                    <label class="form-check-label align-middle" for="knowHow_email">By email invitation</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="knowHow_online" value="Online Search" v-model="step2.knowHow">
                                    <label class="form-check-label align-middle" for="knowHow_online">Online Search</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="knowHow_social" value="Social Media" v-model="step2.knowHow">
                                    <label class="form-check-label align-middle" for="knowHow_social">Social Media</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="knowHow_affiliation" value="Affiliation/ Friend" v-model="step2.knowHow">
                                    <label class="form-check-label align-middle" for="knowHow_affiliation">Through affiliation/ friend</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="knowHow_other" value="Other" v-model="step2.knowHow">
                                    <label class="form-check-label align-middle" for="knowHow_other">Other</label>
                                </div>
                                <div v-if="$v.step2.knowHow.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!$v.step2.knowHow.required">At least one selection is required.</div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="form-label text-uppercase fw-bold">Do you prefer to receive promotional/ communication related to the event via email?&nbsp;<span style="color: red;">*</span></label>
                                <br>
                                <input type="radio" class="form-check-input" v-model="step2.promotional_email" value="Yes" id="promotionalYes">
                                <label class="form-check-label mb-0 align-middle" for="promotionalYes">Yes</label>
                                <br>
                                <input type="radio" class="form-check-input" v-model="step2.promotional_email" value="No" id="promotionalNo">
                                <label class="form-check-label mb-0 align-middle" for="promotionalNo">No</label>
                                <br>
                                <div v-if="$v.step2.promotional_email.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!$v.step2.promotional_email.required">Required field.</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="mb-5"></div>
                </div>
            </tab-content>
            <tab-content title="Billing" :before-change="doStep3">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Billing Information</h1>
                            <p><span style="color: red;">*</span>&nbsp;Required</p>
                        </div>
                        
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Company Name&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.step3.company_name.$error }" v-model="step3.company_name" maxlength="150">
                                    <div v-if="$v.step3.company_name.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.company_name.required">Company Name is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Company Address&nbsp;<span style="color: red;">*</span></label>
                                    <textarea class="form-control text-capitalize" 
                                        :class="{ 'is-invalid': $v.step3.company_address.$error }" 
                                        v-model="step3.company_address" 
                                        @input="step3.company_address = step3.company_address.slice(0, 200)" 
                                        rows="4"></textarea>
                                    <div v-if="$v.step3.company_address.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.company_address.required">Company Address is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Business TIN Number&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-uppercase" 
                                        :class="{ 'is-invalid': $v.step3.tin.$error }" 
                                        v-model="step3.tin" 
                                        maxlength="150"
                                        @input="step3.tin = step3.tin.replace(/[^0-9-]/g, '')">
                                    <div v-if="$v.step3.tin.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.tin.required">Business TIN number is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Contact Person&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.step3.contact_person.$error }" v-model="step3.contact_person" maxlength="200">
                                    <div v-if="$v.step3.contact_person.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.contact_person.required">Contact Person is required.</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Company Email Address&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-lowercase" :class="{ 'is-invalid': $v.step3.company_email.$error }" v-model="step3.company_email" maxlength="200">
                                    <div v-if="$v.step3.company_email.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.company_email.required">Company Email is required.</div>
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.company_email.email">Invalid email address format.</div>
                                    </div>
                                </div>
                                <div class="col-lg-5 mt-4">
                                    <label class="form-label text-uppercase fw-bold">Contact Number&nbsp;<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control text-capitalize" :class="{ 'is-invalid': $v.step3.contact_number.$error }" v-model="step3.contact_number" maxlength="15" @input="step3.contact_number = step3.contact_number.replace(/[^0-9-]/g, '')">
                                    <div v-if="$v.step3.contact_number.$error">
                                        <div class="fw-light invalid-feedback d-block" v-if="!$v.step3.contact_number.required">Contact Number is required.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 mt-3" style="font-size: 10px;">
                        <p>CITEM respects your right to privacy and is committed to protect the confidentiality of your personal information. CITEM is bound to comply with the Data Privacy Act of 2012 (RA 10173), its Implementing Rules and Regulations (IRR), and relevant issuances of the National Privacy Commission (NPC).</p>
                        <p>By filling out this form, you are consenting to our collection and use of your information in accordance with this Privacy Notice.</p>
                    </div>



                    <div class="mb-5"></div>
                </div>
            </tab-content>
        </form-wizard>
        <div v-else class="row">
            <div class="col-10 col-lg-6 mt-5 mx-auto text-center">
                <h3>Thank you for registering for the Sustainability Solutions Exchange Conference 2026</h3>
                <p>Billing information has been sent to {{ this.step3.company_email }}. <a href="https://citem.gov.ph/services/payment" target="_blank">Click here</a> to learn more about payment options for your registration.</p>
                <p><a href="https://forms.office.com/r/mBbqP2TAhN" target="_blank" rel="noopener noreferrer">Click here</a> to select your preferred track that you’re most interested in attending.</p>
                <p>
                    <h3>Registration No.:&nbsp;{{ this.registration_number }}</h3>
                    Total Amount Due (VAT Inclusive): {{ this.currency }} {{ this.formattedAmount }} 
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import {FormWizard, TabContent} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import Vuelidate from 'vuelidate'
import { required, email, url, numeric, requiredIf, minValue } from 'vuelidate/lib/validators'
import BlockUI from 'vue-blockui'
import VueFileAgent from 'vue-file-agent'
import 'vue-file-agent/dist/vue-file-agent.css'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'

Vue.use(BlockUI)
Vue.use(Vuelidate)
Vue.use(VueFileAgent)
Vue.use(VueSweetalert2)
Vue.use(VueToast)

export default {
    props: ['params'],
    data() {
        return {
            isLoading: false,
            msg: 'Standby...',
            conf_id: this.params.id ?? null,
            registration_number: '',
            participantForm: false,
            submittedForm: false,
            countries: [],
            currency: '',
            // base_rate: 0,
            base_total: 0,
            discounts_total: 0,
            discounts: [],
            promo_code_temp: '',
            promo_code_error: '',
            id_file_selected: '',
            participant: {
                p_id: 0,
                salutation: '',
                fname: '',
                lname: '',
                country: '',
                designation: '',
                email:'',
                country_code_mobile: '',
                mobile_no: '',
                addtnl_type: '',
                senior: '',
                pwd: '',
                id_file: '',
            },
            step1: {
                participant_count: 0,
                type: '',
                participants: []
            },
            step2: {
                dietary: '',
                dietary_details: '',
                certificate: '',
                knowHow: [],
                promotional_email: ''
            },
            step3: {
                company_name: '',
                company_address: '',
                tin: '',
                contact_person: '',
                company_email: '',
                contact_number: ''

            }
        };
    },
    validations() {  
        return {
            participant: {
                salutation: { required },
                fname: { required },
                lname: { required },
                country: { required },
                designation: { required },
                email: { required, email },
                country_code_mobile: { required },
                mobile_no: { required },
                addtnl_type: { required },
                id_file: {
                    required: this.isIDRequired ? required : false
                 }
            },
            step1: {
                participant_count: { required, minValue: minValue(1) },
                type: { required }
            },
            step2: {
                // dietary: { required },
                // dietary_details: {
                //     required: (value) => (this.step2.dietary === 'yes' ? required(value) : true) 
                // },
                certificate: { required },
                knowHow: {
                    required: (value) => Array.isArray(value) && value.length > 0
                },
                promotional_email: { required }
            },
            step3: {
                company_name: { required },
                company_address: { required },
                tin: { required },
                contact_person: { required },
                company_email: { required, email },
                contact_number: { required }
            }
        }
    },
    components: {
        FormWizard, TabContent
    },
    mounted() {
    },
    created() {
        this.getCountries();
    },
    computed: {
        formattedAmount() {
            const result = this.base_total - this.discounts_total;
            return result <= 0 ? '0.00' : result.toFixed(2);
        },
        isIDRequired() {
            return (
                (this.participant.addtnl_type !== "Private" && this.participant.addtnl_type !== "") ||
                this.participant.senior === true ||
                this.participant.pwd === true
            );
        }
    },
    methods: {
        doStep1() {
            // TEMP
            // return true

            this.$v.step1.$touch()
            // console.log(this.step1.participant_count)
            if(!this.$v.step1.$invalid){
                return true;
            }
            else {
                return false;
            }
        },
        doStep2() {
            // TEMP
            // return true
            
            this.$v.step2.$touch()
            if(!this.$v.step2.$invalid){
                // console.log(this.step2)
                return true;
            }
            else {
                return false;
            }
        },
        doStep3() {
            // TEMP
            // return true

            this.$v.step3.$touch()
            if(!this.$v.step3.$invalid){
                // console.log(this.step3)
                return true;
            }
            else {
                return false;
            }
        },
        async doSubmitParticipantDetails() {
            this.$v.participant.$touch();

            if (!this.$v.participant.$invalid) {
                this.isLoading = true;

                const formData = new FormData();
                formData.append('conf_id', this.conf_id);
                formData.append('participant', JSON.stringify(this.participant));

                if (this.id_file_selected) {
                    formData.append('id_file_selected', this.id_file_selected);
                }

                try {
                    const response = await axios.post(
                        '/conference/registration/participant/add',
                        formData,
                        { headers: { 'Content-Type': 'multipart/form-data' } }
                    );

                    if (response.status === 200) {
                        this.participant.p_id = response.data.pid;
                        this.step1.participants.push({ ...this.participant });
                        this.doToggleParticipantDetails(false);

                        await this.computeAll(0);
                    }
                } catch (err) {
                    alert('Something went wrong. Please try again, or contact support if the issue persists.');
                } finally {
                    this.isLoading = false;
                }
            }
        },
        async doRemoveParticipant(index) {
            this.isLoading = true;

            const formData = new FormData();
            formData.append('conf_id', this.conf_id);
            formData.append('p_id', this.step1.participants[index].p_id);

            try {
                const response = await axios.post('/conference/registration/participant/delete', formData);

                if (response.status === 200) {
                    this.step1.participants.splice(index, 1);
                    this.step1.participant_count -= 1;

                    await this.computeAll(0);
                }
            } catch (err) {
                alert('Something went wrong. Please try again, or contact support if the issue persists.');
            } finally {
                this.isLoading = false;
            }
        },
        doToggleParticipantDetails($state){
            
            if($state == true) {
                $('.wizard-card-footer.clearfix').hide();
            }
            else {
                this.clearParticipantDetails();
                $('.wizard-card-footer.clearfix').show();
            }
            this.participantForm = $state;
        },
        clearParticipantDetails(){
            this.participant.p_id = 0;
            this.participant.salutation = '';
            this.participant.fname = '';
            this.participant.lname = '';
            this.participant.country = '';
            this.participant.designation = '';
            this.participant.email = '';
            this.participant.country_code_mobile = '';
            this.participant.mobile_no = '';
            this.participant.addtnl_type = '';
            this.participant.senior = '';
            this.participant.pwd = '';
            this.participant.id_file = '';
            this.id_file_selected = '';
            this.$v.participant.$reset();
        },
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
        async checkPromoCode() {
            const promoCode = this.promo_code_temp.trim().toUpperCase();

            if (!promoCode) {
                this.promo_code_error = 'Promo code is required';
                return;
            }

            this.promo_code_error = '';
            this.isLoading = true;

            const formData = new FormData();
            formData.append('conf_id', this.conf_id);
            formData.append('promo_code', promoCode);

            try {
                const response = await axios.post('/conference/registration/code', formData);

                if (response.status === 200) {
                    await this.computeAll(0);
                }
            } catch (err) {
                if (err.response) {
                    this.promo_code_error = err.response.data.message;
                } else {
                    this.promo_code_error = 'An unexpected error occurred.';
                }
            } finally {
                this.isLoading = false;
            }
        },
        async computeAll(state) {
            // $state = 0-ongoing, 1-submit

            this.promo_code_temp = '';
            this.promo_code_error = '';
            this.discounts_total = 0;

            this.isLoading = true;

            const formData = new FormData();
            formData.append('state', state);
            formData.append('conf_id', this.conf_id);
            formData.append('type', this.step1.type);

            try {
                const response = await axios.post('/conference/registration/compute', formData);

                if (response.status === 200) {
                    this.base_total = response.data.base_total;
                    this.discounts_total = response.data.discounts_total;
                    this.step1.participant_count = response.data.participant_count;
                    this.discounts = Array.isArray(response.data.discounts) ? response.data.discounts : [];

                    console.log('Check Response:', response);

                    if (state != 1) {
                        this.isLoading = false;
                    }
                }
            } catch (err) {
                alert('Something went wrong. Please try again, or contact support if the issue persists.');
            }
        },
        onBeforeFileDelete(fileRecord) {
            if (confirm('Are you sure you want to remove this document?')) {
                // this.doDeleteDoc('doc_1')
                this.$refs.vueFileAgent1.deleteFileRecord(fileRecord)
            }
        },
        onFileSelect(file) {
            this.id_file_selected = file[0].file;
        },
        async onChangeType() {
            this.currency = this.step1.type === 'foreign' ? 'USD' : 'PHP';
            await this.computeAll(0);
        },
        onChangePromoCode() {
            this.promo_code_error = '';
        },
        async onComplete() {

            const confirmed = await this.onSubmit();
            if (!confirmed) {
                return false;
            }

            await this.computeAll(1);

            this.isLoading = true
            let formData = new FormData()
                // formData.append('breakdown', JSON.stringify(this.discounts))
                // formData.append('currency', this.currency)
                // formData.append('base_rate', this.base_rate)
                // formData.append('base_total', this.base_total)
                // formData.append('discounts_total', this.discounts_total)
                // formData.append('step1', JSON.stringify(this.step1))
                formData.append('conf_id', this.conf_id)
                formData.append('step2', JSON.stringify(this.step2))
                formData.append('step3', JSON.stringify(this.step3))

            axios.post('/conference/registration/store', formData)
                .then(response => {
                    if (response.status === 200) {
                        this.registration_number = response.data.reg_no
                        this.submittedForm = true
                        this.isLoading = false
                        return true
                    }
                }).catch(err => {

                    this.isLoading = false
                    alert('Something went wrong. Please try again, or contact support if the issue persists.')

                    // if (error.response) {
                    //     console.error("Server Error:", error.response.data);
                    //     console.log("Status Code:", error.response.status);
                    //     this.errorMessage = error.response.data.message || "Something went wrong.";
                    // } else if (error.request) {
                    //     console.error("No response received:", error.request);
                    //     this.errorMessage = "No response from server. Please check your internet connection.";
                    // } else {
                    //     console.error("Error:", error.message);
                    //     this.errorMessage = "An unexpected error occurred.";
                    // }

                    return false
                })
        },
        async onSubmit() {
            const result = await this.$swal({
                title: "SSX Conference 2025 Registration",
                text: "Would you like to submit the form? To review the form, click cancel.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Submit it!",
                cancelButtonText: "No, Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33"
            });

            return result.isConfirmed;
        },
        onLoad(e) {
            this.isLoading = e
        }
    }
}
</script>
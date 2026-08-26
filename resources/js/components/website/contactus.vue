<template>
    <div>
        <div class="alert alert-success darkgreen-bg border-0 d-flex align-items-center alert-dismissible fade show" role="alert" v-if="isShowThankYou">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            <div class="">
                Message successfully sent.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <form class="row g-3" ref="inquiry" v-on:submit.prevent>
            <div class="col-12">
                <label for="contact-email" class="form-label text-uppercase p-0 mb-0">E-mail address*</label>
                <input type="text" class="form-control text-lowercase" id="contact-email" placeholder="emailaddress@domain.com" :class="{ 'is-invalid': $v.email.$error }" v-model="email" :readonly="submitStatus">
                <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                    <div v-if="$v.email.$error">
                        <div class="fw-light invalid-feedback d-block" v-if="!$v.email.required">E-mail address is required.</div>
                        <div class="fw-light invalid-feedback d-block" v-if="!$v.email.email">Invalid e-mail address format.</div>
                    </div>
                </transition>
            </div>
            <div class="col-6">
                <label for="contact-name" class="form-label text-uppercase p-0 mb-0">full name*</label>
                <input type="text" class="form-control text-capitalize" name="contact-name" placeholder="Given Name, Surname" :class="{ 'is-invalid': $v.fullname.$error }" v-model="fullname" :readonly="submitStatus">
                <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                    <div v-if="$v.fullname.$error">
                        <div class="fw-light invalid-feedback d-block" v-if="!$v.fullname.required">Full name is required.</div>
                    </div>
                </transition>
            </div>
            <div class="col-6">
                <label for="contact-company" class="form-label text-uppercase p-0 mb-0">COMPANY OR ORGANIZATION*</label>
                <input type="text" class="form-control text-capitalize" name="contact-company" placeholder="Your Company" :class="{ 'is-invalid': $v.company.$error }" v-model="company" :readonly="submitStatus">
                <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                    <div v-if="$v.company.$error">
                        <div class="fw-light invalid-feedback d-block" v-if="!$v.company.required">Company or organization is required.</div>
                    </div>
                </transition>
            </div>
            <div class="col-12">
                <label for="contact-message" class="form-label text-uppercase p-0 mb-0">MESSAGE*</label>
                <textarea name="contact-message" placeholder="I want to be a part of SSX!" class="form-control" :class="{ 'is-invalid': $v.message.$error }" v-model="message" :readonly="submitStatus"></textarea>
                <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                    <div v-if="$v.message.$error">
                        <div class="fw-light invalid-feedback d-block" v-if="!$v.message.required">Message is required.</div>
                    </div>
                </transition>
            </div>
            <div class="btn-holder align-right mt-3">
                <button type="button" class="submit_btn" :disabled="submitStatus" @click="doSubmit">
                    <span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true" v-show="submitStatus"></span>
                    SUBMIT
                </button>
            </div>
        </form>
    </div>
</template>
<script>
    import Vuelidate from 'vuelidate'
    import { required, email } from 'vuelidate/lib/validators'

    Vue.use(Vuelidate)

    export default {
        data() {
            return {
                submitStatus: false,
                isShowThankYou: false,
                email: '',
                fullname: '',
                company: '',
                message: '',
            }
        },
        validations: {  
            email: { required, email },
            fullname: { required },
            company: { required },
            message: { required }
        },
        methods: {
            doSubmit() {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.submitStatus = true
                    let formData = new FormData()
                    formData.append('email', this.email)
                    formData.append('fullname', this.fullname)
                    formData.append('company', this.company)
                    formData.append('message', this.message)
                    axios.post('/api/contact-us', formData)
                    .then(response => {
                        //console.log(response.data);
                        if (response.status === 200) {
                            this.isShowThankYou = true
                            this.submitStatus = false
                            this.$v.$reset()
                            this.clearForm()
                            setTimeout(() => {
                                this.isShowThankYou = false
                            }, 3000)
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                }
            },
            clearForm() {
                this.email = ''
                this.fullname = ''
                this.company = ''
                this.message = ''
            }
        }
    }
</script>
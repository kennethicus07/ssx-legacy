<template>
    <div class="modal fade" id="popup-subscribe" tabindex="-1" aria-labelledby="Subscription" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content popup">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h2>Know the latest on sustainability.</h2>
                            <p class="mt-3">Subscribe to our e-newsletter and get the latest updates, news, events, and promotions from the Sustainability Solutions Exchange in your inbox for free!</p>
                        </div>
                    </div>
                    <div class="subscribe">
                        <div class="d-flex">
                            <input class="form-control me-2 beige-bg" type="text" placeholder="emailaddress@domain.com" aria-label="Email" v-model="email" :class="{ 'is-invalid': $v.email.$error, 'is-valid': isShowThankYou }" :readonly="submitStatus" maxlength="150">
                            <div class="btn-holder">
                                <button class="submit_btn" type="button" :disabled="submitStatus" @click="doSubmit">
                                    <span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true" v-show="submitStatus"></span>
                                    Submit
                                </button>
                            </div>
                        </div>
                        <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                            <div v-if="isShowThankYou" class="fw-light valid-feedback d-block">Thank you for subscribing.</div>
                            <div v-if="$v.email.$error">
                                <div class="fw-light invalid-feedback d-block" v-if="!$v.email.required">E-mail address is required.</div>
                                <div class="fw-light invalid-feedback d-block" v-if="!$v.email.email">Invalid e-mail address format.</div>
                            </div>
                        </transition>
                    </div>
                </div>
                <div class="modal-footer bg-dark text-white d-flex justify-content-center mt-5">
                    <p class="text-center"><a data-bs-dismiss="modal" aria-label="Close" role="button" class="text-white">Remind me later.</a></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vuelidate from 'vuelidate'
    import { required, email } from 'vuelidate/lib/validators'

    Vue.use(Vuelidate)
    Vue.use(require('vue-moment'))

    export default {
        data() {
            return {
                submitStatus: false,
                isShowThankYou: false,
                email: '',
            }
        },
        mounted() {
            this.doPopup()
        },
        validations: {  
            email: { required, email }
        },
        methods: {
            doSubmit() {
                this.$v.$touch()
                if (!this.$v.$invalid) {
                    this.submitStatus = true
                    let formData = new FormData()
                    formData.append('email', this.email)
                    axios.post('/api/subscribe', formData)
                    .then(response => {
                        //console.log(response.data);
                        if (response.status === 200) {
                            this.isShowThankYou = true
                            localStorage.setItem('ssx_popup_subscribe_enabled', 1);
                            this.$v.$reset()
                            this.clearForm()
                            setTimeout(() => {
                                this.isShowThankYou = false
                                this.submitStatus = false
                            }, 3000)
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                }
            },
            doPopup() {
                var newsletter_modal = new bootstrap.Modal(document.getElementById('popup-subscribe'), {
                    backdrop: 'static'
                });

                if (localStorage.getItem('ssx_popup_subscribe_enabled') === null) {
                    if (localStorage.getItem('ssx_popup_subscribe_time') === null) {
                        localStorage.setItem('ssx_popup_subscribe_time', Vue.moment().format())
                        newsletter_modal.show()
                    } else {
                        var set_date = localStorage.getItem('ssx_popup_subscribe_time')
                        var diff = Vue.moment().diff(Vue.moment(set_date), 'minutes')
                        //console.log(diff)
                        if (diff > 5) {
                            localStorage.setItem('ssx_popup_subscribe_time', Vue.moment().format())
                            newsletter_modal.show()
                        }
                    }
                }
            },
            clearForm() {
                this.email = ''
            }
        }
    }
</script>
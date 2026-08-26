<template>
    <div class="subscribe">
        <h3>Subscribe to our newsletter:</h3>
        <div class="d-flex">
            <input class="form-control me-2" type="text" placeholder="emailaddress@domain.com" aria-label="Email" v-model="email" :class="{ 'is-invalid': $v.email.$error, 'is-valid': isShowThankYou }" :readonly="submitStatus" maxlength="150">
            <div class="btn-holder w-50">
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
            }
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
            clearForm() {
                this.email = ''
            }
        }
    }
</script>
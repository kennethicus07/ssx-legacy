<template>
    <div class="row mt-4 g-3">
        <p class="animate__animated animate__slideInUp fs-12">
            <span class="font-weight-lighter text-danger" v-show="haveError">{{ errorMessage }}</span>
        </p> 
        <div class="form-label-group">
            <label for="email" class="form-label text-uppercase fw-bold">E-mail address:</label>
            <input type="email" class="form-control text-lowercase" :class="{ 'is-invalid': $v.email.$error }" v-model="email" placeholder="email@domain.com" autofocus>
            <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                <div v-if="$v.email.$error">
                    <div class="fw-light invalid-feedback d-block" v-if="!$v.email.required">E-mail address is required.</div>
                    <div class="fw-light invalid-feedback d-block" v-if="!$v.email.email">E-mail address is invalid format.</div>
                </div>
            </transition>
        </div>
        <div class="form-label-group">
            <label for="pwd" class="form-label text-uppercase fw-bold">Password:</label>
            <input type="password" class="form-control" :class="{ 'is-invalid': $v.password.$error }" v-model="password" placeholder="password">
            <transition enter-active-class="animate__animated animate__slideInUp" leave-active-class="animate__animated animate__fadeOut">
                <div v-if="$v.password.$error">
                    <div class="fw-light invalid-feedback d-block" v-if="!$v.password.required">Password is required.</div>
                </div>
            </transition>
        </div>
        <div class="pt-20 push-right link-border">
            <button type="button" class="btn btn-sm black_btn" @click="doLogin" :disabled="$v.$pending"><strong>{{ buttonText }}</strong></button>
        </div>          
        <div class="push-right mt-0">
            <a href="/forgot-password" class="black"><sub><strong>Forgot Password?</strong></sub></a>
        </div>
    </div>
</template>
<script>
    import Vuelidate from 'vuelidate'
    import { required, email } from 'vuelidate/lib/validators'

    Vue.use(Vuelidate)

    export default {
        data() {
            return {
                buttonText: 'SUBMIT',
                haveError: false,
                errorMessage: '',
                email: '',
                password: '',
            }
        },
        validations: {  
            email: { required, email },
            password: { required }
        },
        created() {
            
        },
        methods: {
            doLogin() {
                this.$v.$touch()
                if (!this.$v.$invalid && !this.$v.$pending) {
                    this.buttonText = 'LOADING...'
                    let formData = new FormData()
                    formData.append('email', this.email)
                    formData.append('password', this.password)
                    axios.post('/popup/login', formData)
                    .then(response => {
                        //console.log(response.data);
                        if (response.status === 200) {
                            if (response.data.success) {
                                location.reload()
                            } else {
                                this.haveError = true;
                                this.errorMessage = response.data.message
                                this.email = ''
                                this.password = ''
                                this.buttonText = 'SUBMIT'
                                this.$v.$reset()
                            }
                        }
                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    this.buttonText = 'SUBMIT'
                    this.password = ''
                }
            }
        }
    }
</script>
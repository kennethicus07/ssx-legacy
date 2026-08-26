<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section subnav beige-bg nav-holder gradient-top">
            <div class="content">
                <div class="flex letter-holder">
                    <strong>Jump to Letter:</strong>
                    <a role="button" class="text-uppercase" :class="{ 'lightgreen-bg text-white': sort === letter }" v-for="letter in alphabet" :key="letter" @click="doSort(letter)">{{ letter }}</a>
                </div>
            </div>
        </div>
        <div class="section form-header certification-header">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h1>Glossary of Certifications</h1>
                    </center>
                    <p>&nbsp;</p>
                    <div class="d-flex justify-content-center">
                        <vue-instant 
                            :suggestOnAllWords="true" 
                            :suggestion-attribute="suggestionAttribute" 
                            :show-autocomplete="true"
                            :autofocus="false"
                            :suggestions="suggestions"
                            v-model="query" 
                            @input="onInputChange" 
                            @click-input="clickInput" 
                            @click-button="getCertificates(1)" 
                            @selected="onSelect"  
                            @enter="getCertificates(1)" 
                            @clear="onClear"  
                            placeholder="Search..." 
                            type="amazon"
                        >
                        </vue-instant>
                    </div>
                </div>
            </div>
        </div>
        <div class="section ssx-info white-bg">
            <div class="content">
                <div class="certificate-container">
                    <div class="certificate-group" v-for="(certification, letter) in certifications" :key="letter">
                        <div class="certificate-title">{{ letter }}</div>
                        <div class="certificate-list">
                            <div class="certificate" v-for="cert in certification" :key="cert.id">
                                <div class="image">
                                    <img v-if="cert.logo" :src="'/storage/certifications/'+cert.logo" class="img-fluid img-thumbnail" alt="...">
                                    <img v-else src="https://via.placeholder.com/300.png/2a3418/2a3418" class="img-fluid img-thumbnail" alt="...">
                                    <!-- <h5>LOGO/SEAL</h5> -->
                                </div>
                                <div class="desc">
                                    <h4>{{ cert.name }}</h4>
                                    <p v-html="cert.details"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center w-100" v-if="certifications.length <= 0">
                        <h4>No certification found.</h4>
                    </div>   
                </div>
            </div>  
        </div>
    </div>
</template>
<script>
import BlockUI from 'vue-blockui'
import 'vue-instant/dist/vue-instant.css'
import VueInstant from 'vue-instant/dist/vue-instant.common'

Vue.use(VueInstant)
Vue.use(BlockUI)

export default {
    data() {
        return {
            isLoading: false,
            msg: 'Loading...',
            sort: '',  
            query: '',
            certifications: [],
            suggestionAttribute: 'name',
            suggestions: [],
            alphabet: ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"],
        }
    },
    created() {
        this.getCertificates()
    },
    methods: {
        getCertificates() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('qry', this.query)
            axios.post('/certifications/list', formData)
            .then(response => {
                //console.log(response.data);
                if (response.status === 200) {
                    this.certifications = response.data
                    this.isLoading = false
                    this.msg = 'Loading...'
                    this.scrollToTop()
                }
            }).catch(err => {
                console.log(err)
            })
        },
        onInputChange(text) {
            this.suggestions = []
            axios.get('/certifications/search/'+text)
            .then(response => {
                //console.log(response.data);
                if (response.status === 200) {
                    for (var i = 0; i < response.data.length; i++){
                        this.suggestions.push(response.data[i])
                    } 
                }
            }).catch(err => {
                console.log(err)
            })
        },
        onSelect(val) {
            console.log(val.id)
        },
        clickInput() {
            console.log('click input')
        },
        clickButton() {
            console.log('click button')
        },
        enter() {
            console.log('ENTER')
        },
        onClear() {
            this.msg = 'Resetting...'
            this.query = ''
            this.sort = ''
            this.getCertificates()
        },
        doSort(letter) {
            this.sort = letter
            this.msg = 'Sorting...'
            this.isLoading = true
            this.certifications = []
            this.page = 1
            this.getCertificates()
        },
        scrollToTop() {
            window.scroll({ top: 150, behavior: 'smooth' });
        },
    }
}
</script>
<style>
.vue-instant__suggestions li.highlighted__amazon {
    background-color: #9daa39;
}
.vue-instant__suggestions {
    top: 100%;
    text-align: left;
}
@media only screen and (min-width : 320px) {
    .sbx-amazon {
        width: 300px;
    }
}
@media only screen and (min-width : 768px) {
    .sbx-amazon {
        width: 500px;
    }
}
</style>
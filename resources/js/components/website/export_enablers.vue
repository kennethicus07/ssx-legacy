<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section form-header certification-header intelligence">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h1>Business Solutions Services</h1>
                    </center>
                    <p>Business Solutions Services is a program featuring private companies, government institutions, organizations, and individuals that offer services, solutions or products that help exporters meet their goals in all aspects of the business, from inception to operations.</p>
                    <a href="/services/business-solutions-services/about"><button type="button" class="submit_btn mb-4">Know More</button></a>
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
                            @click-button="getEnablers(1)" 
                            @selected="onSelect"  
                            @enter="getEnablers(1)" 
                            @clear="onClear"  
                            placeholder="Search..." 
                            type="amazon"
                        >
                        </vue-instant>
                    </div>
                </div>
            </div>
        </div>
        <div class="section black mt-5 mb-5">
            <div class="content">
                <h3 class="pb-3">Featured Business Solutions Partners</h3>
                <carousel paginationActiveColor="#869791" paginationColor="#D6D6D6" :navigationEnabled="true" :paginationEnabled="false" :perPage="4" :perPageCustom="[[320, 2], [820, 3], [1280, 5]]">
                    <slide v-for="partner in featured_partners" :key="partner.id">
                        <div class="card text-center">
                            <div class="card-body">
                                <img :src="partner.logo" class="img-fluid" :alt="partner.name" :title="partner.name">
                            </div>
                        </div>
                    </slide>
                </carousel>
            </div>
        </div>
        <div class="section">
            <div class="content">
                <h3 class="pb-3">Featured Programs & Offers</h3>
                <carousel paginationActiveColor="#869791" paginationColor="#D6D6D6" :navigationEnabled="true" :paginationEnabled="false" :perPage="3" :minSwipeDistance="3" :perPageCustom="[[320, 1], [820, 2], [1280, 3]]">
                    <slide v-for="offer in offers" :key="offer.id">
                        <div class="card h-100">
                            <img :src="offer.thumb" class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="event-info main" style="margin-top: -80px;">
                                        <div class="image">
                                            <img :src="offer.logo" class="border border-3 border-white white-bg">
                                        </div>
                                    </div>
                                </div>
                                <div class="fs-6 fw-bold">
                                    <a :href="'/services/business-solutions-services/programs-offers/'+offer.id+'/'+offer.slug" class="lightgreen-link">{{ offer.title }}</a>
                                </div>
                                <p class="card-text mt-2" v-html="offer.details"></p>
                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase fs-12 ms-1" v-for="tag in offer.tags" :key="tag.id">{{ tag.sub_category_remarks }}</span>
                            </div>
                        </div>
                    </slide>
                </carousel>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col text-center">
                    <h3>View all Business Solutions Partners</h3>
                </div>
            </div>
        </div>
        <div class="section white-bg ssx-info solution-listing">
            <div class="content">
                <div class="flex">
                    <div class="flex1">
                        <div class="list-header">
                            <h4 class="ico-holder filter">Filter</h4>
                        </div>
                        <div class="select-holder">
                            <div class="select-options">
                                <h4>CATEGORY</h4>
                                <div v-for="category in categories" :key="category.id">
                                    <div class="lightgreen mb-2">{{ category.name }}</div>
                                    <ul class="sub-options">
                                        <li v-for="subcategory in category.sub_categories" :key="subcategory.id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="'prod_sub_categories_'+subcategory.id" :value="subcategory.id" v-model="categories_selected">
                                                <label class="form-check-label align-middle" :for="'prod_sub_categories_'+subcategory.id">{{ subcategory.name }}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>    
                                <div class="btn-holder link-border flex">
                                    <button class="btn btn-sm black_btn" @click="getEnablers(1)">APPLY</button>
                                    <button class="btn btn-sm clear_btn" @click="doReset">RESET</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex4">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="p-1 fw-bold fs-6">Sort by:</div>
                            <div class="p-1">
                                <select class="form-select form-select-sm lightgreen border-0" v-model="sort" @change="doSort">
                                    <option :value="1">A-Z</option>
                                    <option :value="2">Z-A</option>
                                    <option :value="3">Latest</option>
                                    <option :value="4">Oldest</option>
                                </select>
                            </div>
                            <div class="p-1 fw-bold fs-6">Result Per Page:</div>
                            <div class="p-1">
                                <select class="form-select form-select-sm lightgreen border-0" v-model="per_page" @change="getEnablers(1)">
                                    <option :value="10">10</option>
                                    <option :value="20">20</option>
                                    <option :value="50">50</option>
                                    <option :value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="solutions-holder">
                            <div class="card mb-4 w-100" v-for="enabler in enablers" :key="enabler.id">
                                <div class="row g-0">
                                    <div class="col-md-4 align-self-center">
                                        <img :src="enabler.logo" class="img-fluid mx-auto d-block" alt="...">
                                    </div>
                                    <div class="col-md-8 beige-bg">
                                        <div class="card-body">
                                            <div class="fs-6 fw-bold mb-3">{{ enabler.name }}</div>
                                            <p class="card-text" v-html="enabler.details"></p>
                                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase fs-12 me-1" v-for="tag in enabler.tags" :key="tag.id">{{ tag.sub_category_remarks }}</span>
                                            <div class="row mt-3">
                                                <div class="col align-self-center" v-if="enabler.website">
                                                    <i class="fas fa-globe align-middle"></i> <a :href="enabler.website | parse_url_protocol()" target="_blank" class="text-decoration-none black"><span class="fs-12">{{ enabler.website | parse_url_remove_protocol() }}</span></a>
                                                </div>
                                                <div class="col align-self-center" v-if="enabler.email">
                                                    <i class="fas fa-at align-middle"></i> <a :href="'mailto:'+enabler.email" target="_blank" class="text-decoration-none black"><span class="fs-12">{{ enabler.email }}</span></a>
                                                </div>
                                                <div class="col align-self-center" v-if="enabler.facebook">
                                                    <i class="fab fa-facebook-f align-middle"></i> <a :href="'https://www.facebook.com/'+enabler.facebook" target="_blank" class="text-decoration-none black"><span class="fs-12">{{ enabler.facebook | parse_url_remove_protocol() }}</span></a>
                                                </div>
                                                <div class="col align-self-center" v-if="enabler.twitter">
                                                    <i class="fab fa-twitter align-middle"></i> <a :href="'https://www.twitter.com/'+enabler.twitter" target="_blank" class="text-decoration-none black"><span class="fs-12">{{ enabler.twitter | parse_url_remove_protocol() }}</span></a>
                                                </div>
                                                <div class="col align-self-center" v-if="enabler.instagram">
                                                    <i class="fab fa-instagram align-middle"></i> <a :href="'https://www.instagram.com/'+enabler.instagram" target="_blank" class="text-decoration-none black"><span class="fs-12">{{ enabler.instagram | parse_url_remove_protocol() }}</span></a>
                                                </div>
                                                <div class="col align-self-center" v-if="enabler.wechat">
                                                    <i class="fab fa-weixin align-middle"></i><span class="fs-12 ms-1" v-text="'weixin://dl/chat?'+enabler.wechat"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center w-100" v-if="total_rec <= 0">
                                <h4>No export enabler found.</h4>
                            </div>    
                            <div class="d-flex justify-content-end w-100 black pt-3" v-if="total_rec > Number(per_page)">
                                <div class="row">
                                    <pagination :records="total_rec" v-model="page" :per-page="Number(per_page)" @paginate="getEnablers(page)" :options="pagination_options"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BlockUI from 'vue-blockui'
import Pagination from 'vue-pagination-2'
import 'vue-instant/dist/vue-instant.css'
import VueInstant from 'vue-instant/dist/vue-instant.common'
import { Carousel, Slide } from 'vue-carousel';

Vue.use(VueInstant)
Vue.use(BlockUI)

export default {
    data() {
        return {
            isLoading: false,
            msg: 'Loading...',
            query: '',
            sort: 1,
            page: 1,
            per_page: 10,
            total_rec: 0,
            featured_partners: [],
            enablers: [],
            offers: [],
            suggestionAttribute: 'co_name',
            suggestions: [],
            categories: [],
            categories_selected: [],
            article_types: [],
            article_type_selected: [],
            pagination_options: {
                edgeNavigation: true,
                texts: {
                    first: 'First'
                }
            }
        }
    },
    components: {
        Pagination,
        Carousel,
        Slide
    },
    created() {
        this.getCategories()
        this.getFeaturedPartners()
        this.getProgramsOffers()
        this.getEnablers(this.page)
    },
    filters: {
        str_limit(value, size) {
            if (!value) return '';
            value = value.toString();
            if (value.length <= size) {
                return value;
            }
            return value.substr(0, size) + '...';
        },
        parse_url_remove_protocol(value) {
            try {
                url = new URL(value);
            } catch (e) {
                return value;  
            }
            return url.replace(/^https?:\/\//, '');
        },
        parse_url_protocol(value) {
            try {
                url = new URL(value);
            } catch (e) {
                return 'http://'+value;  
            }
            return value;
        }
    },
    methods: {
        getFeaturedPartners() {
            axios.get('/services/business-solutions-services/featured_partners')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.featured_partners = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getProgramsOffers() {
            axios.get('/services/business-solutions-services/programs_offers')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.offers = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getCategories() {
            axios.get('/api/enablers-categories')
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
        getEnablers(page) {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(page))
            formData.append('per_page', Number(this.per_page))
            formData.append('qry', this.query)
            formData.append('categories', JSON.stringify(this.categories_selected))
            axios.post('/services/business-solutions-services/list', formData)
            .then(response => {
                //console.log(response.data);
                if (response.status === 200) {
                    this.enablers = response.data.results
                    this.total_rec = response.data.total_rec
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
            axios.get('/services/business-solutions-services/search/'+text)
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
        onClear() {
            this.msg = 'Resetting...'
            this.query = ''
            this.getEnablers(1)
        },
        doReset() {
            this.msg = 'Resetting...'
            this.categories_selected = []
            this.getEnablers(1)
        },
        doSort() {
            this.msg = 'Sorting...'
            this.isLoading = true
            this.enablers = []
            this.page = 1
            this.getEnablers(1)
        },
        scrollToTop() {
            window.scroll({ top: 1000, behavior: 'smooth' });
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
.VueCarousel-navigation-button[data-v-453ad8cd] {
    top: 40% !important;
}
.VueCarousel-slide {
    padding-bottom: 1rem;
}
</style>
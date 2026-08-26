<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section form-header">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h1>Marketplace</h1>
                    </center>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
        <div class="section ssx-info solution-listing white-bg black">
            <div class="content">
                <h3 class="white">Browse Suppliers</h3>
                <div class="solutions-holder mt-3">
                    <div class="col-12">
                    <carousel ref="carousel" paginationActiveColor="#869791" paginationColor="#D6D6D6" :navigationEnabled="true" :paginationEnabled="false" :perPage="2" :minSwipeDistance="2" :perPageCustom="[[320, 1], [820, 2], [1280, 2]]">
                        <slide v-for="latest_supplier in latest_suppliers" :key="latest_supplier.id" class="solution company">
                            <div class="h-100 border-0">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <a :href="'/solutions/marketplace/'+latest_supplier.id+'/'+latest_supplier.slug">
                                            <img :src="latest_supplier.co_thumb" class="img-fluid w-100 h-100" alt="...">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <div class="event-info main">
                                                <div class="image">
                                                    <img :src="latest_supplier.co_logo" class="img-fluid" alt="...">
                                                </div>
                                                <div class="desc border-0">
                                                    <a :href="'/solutions/marketplace/'+latest_supplier.id+'/'+latest_supplier.slug" class="fw-bold text-decoration-none">{{ latest_supplier.co_name }}</a>
                                                </div>
                                            </div>
                                            <p>{{ latest_supplier.co_details }} <a :href="'/solutions/marketplace/'+latest_supplier.id+'/'+latest_supplier.slug">Learn more</a></p>
                                            <p class="tags" v-if="latest_supplier.tags.length >= 1">
                                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in latest_supplier.tags" :key="tag.id" :title="tag.sub_category_remarks">{{ tag.sub_category_remarks | str_limit(30) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="solution company h-100">
                                <div class="image">
                                    <a :href="'/solutions/marketplace/'+latest_supplier.id+'/'+latest_supplier.slug">
                                        <img :src="latest_supplier.co_thumb" class="d-block w-100" alt="...">
                                    </a>
                                </div>
                                <div class="desc">
                                    <div class="event-info main">
                                        <div class="image">
                                            <img :src="latest_supplier.co_logo" alt="...">
                                        </div>
                                        <div class="desc">
                                            <a :href="'/solutions/marketplace/'+latest_supplier.id+'/'+latest_supplier.slug">{{ latest_supplier.co_name }}</a>
                                        </div>
                                    </div>
                                    <p>{{ latest_supplier.co_details }} <a :href="'/solutions/marketplace/'+latest_supplier.id+'/'+latest_supplier.slug">Learn more</a></p>
                                    <p class="tags" v-if="latest_supplier.tags.length >= 1">
                                        <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in latest_supplier.tags" :key="tag.id">{{ tag.sub_category_remarks }}</span>
                                    </p>
                                </div>
                            </div> -->
                        </slide>
                    </carousel>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="p-2 bd-highlight">
                        <a href="/solutions/marketplace/suppliers" class="fs-6">View all marketplace</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section beige-bg ssx-info solution-listing">
            <div class="content">
                <h2>Browse <span class="lightgreen">Food Solutions</span></h2>
                <!-- <h4>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.</h4> -->
                <div class="solutions-holder mt-3">
                    <div class="solution company" v-for="food in food_solutions" :key="food.id">
                        <div class="image">
                            <a :href="'/solutions/marketplace/'+food.id+'/'+food.slug">
                                <img :src="food.co_thumb" class="d-block w-100" alt="...">
                            </a>
                        </div>
                        <div class="desc">
                            <div class="event-info main">
                                <div class="image">
                                    <img :src="food.co_logo" alt="...">
                                </div>
                                <div class="desc">
                                    <a :href="'/solutions/marketplace/'+food.id+'/'+food.slug">{{ food.co_name }}</a>
                                </div>
                            </div>
                            <p>{{ food.co_details }} <a :href="'/solutions/marketplace/'+food.id+'/'+food.slug">Learn more</a></p>
                            <p class="tags" v-if="food.tags.length >= 1">
                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in food.tags" :key="tag.id" :title="tag.sub_category_remarks">{{ tag.sub_category_remarks | str_limit(30) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="p-2 bd-highlight">
                        <a href="/solutions/marketplace/suppliers" class="text-black">View all marketplace</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section white-bg ssx-info solution-listing">
            <div class="content">
                <h2>Browse <span class="lightgreen">Lifestyle Solutions</span></h2>
                <!-- <h4>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.</h4> -->
                <div class="solutions-holder mt-3">
                    <div class="solution company" v-for="lifestyle in lifestyle_solutions" :key="lifestyle.id">
                        <div class="image">
                            <a :href="'/solutions/marketplace/'+lifestyle.id+'/'+lifestyle.slug">
                                <img :src="lifestyle.co_thumb" class="d-block w-100" alt="...">
                            </a>
                        </div>
                        <div class="desc">
                            <div class="event-info main">
                                <div class="image">
                                    <img :src="lifestyle.co_logo" alt="...">
                                </div>
                                <div class="desc">
                                    <a :href="'/solutions/marketplace/'+lifestyle.id+'/'+lifestyle.slug">{{ lifestyle.co_name }}</a>
                                </div>
                            </div>
                            <p>{{ lifestyle.co_details }} <a :href="'/solutions/marketplace/'+lifestyle.id+'/'+lifestyle.slug">Learn more</a></p>
                            <p class="tags" v-if="lifestyle.tags.length >= 1">
                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in lifestyle.tags" :key="tag.id" :title="tag.sub_category_remarks">{{ tag.sub_category_remarks | str_limit(30) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="p-2 bd-highlight">
                        <a href="/solutions/marketplace/suppliers" class="text-black">View all marketplace</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BlockUI from 'vue-blockui'
import { Carousel, Slide } from 'vue-carousel';

Vue.use(BlockUI)

export default {
    data() {
        return {
            isLoading: false,
            msg: 'Loading...',
            latest_suppliers: [],
            food_solutions: [],
            lifestyle_solutions: [],
            advance_solutions: [],
        }
    },
    components: {
        Carousel,
        Slide
    },
    mounted() {
        setTimeout(this.$refs.carousel.computeCarouselWidth, 300)
    },
    created() {
        this.getLatestSuppliers()
        this.getSolutions()
    },
    filters: {
        str_limit: function (value, size) {
            if (!value) return ''
            value = value.toString()

            if (value.length <= size) {
                return value;
            }
            return value.substr(0, size) + '...';
        }
    },
    methods: {
        getLatestSuppliers() {
            axios.get('/solutions/latest-suppliers')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.latest_suppliers = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getSolutions() {
            axios.get('/solutions/latest-solutions')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.food_solutions = response.data.foods
                    this.lifestyle_solutions = response.data.lifestyles
                    this.advance_solutions = response.data.advances
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        scrollToTop() {
            window.scroll({ top: 150, behavior: 'smooth' });
        },
    }
}
</script>
<style>
.VueCarousel-navigation-button[data-v-453ad8cd] {
    top: 40% !important;
}
.VueCarousel-slide {
    padding-bottom: 1rem;
}
.event-info .image {
    flex: none;
}
</style>
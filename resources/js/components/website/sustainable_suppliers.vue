<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section form-header solution-header">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h1>Sustainable Solutions</h1>
                    </center>
                    <p>&nbsp;</p>
                </div>
            </div>
        </div>
        <div class="section ssx-info solution-listing white-bg black">
            <div class="content">
                <h3 class="white">Browse Suppliers/Exhibitors</h3>
                <div class="solutions-holder mt-3">
                    <div class="col-12">
                    <carousel ref="carousel" paginationActiveColor="#869791" paginationColor="#D6D6D6" :navigationEnabled="true" :paginationEnabled="false" :perPage="2" :minSwipeDistance="2" :perPageCustom="[[320, 1], [820, 2], [1280, 2]]">
                        <slide v-for="latest_supplier in latest_suppliers" :key="latest_supplier.id">
                            <div class="card h-100">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <a :href="'/solutions/sustainable/'+latest_supplier.id+'/'+latest_supplier.slug">
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
                                                    <a :href="'/solutions/sustainable/'+latest_supplier.id+'/'+latest_supplier.slug" class="fw-bold text-decoration-none">{{ latest_supplier.co_name }}</a>
                                                </div>
                                            </div>
                                            <p>{{ latest_supplier.co_details }} <a :href="'/solutions/sustainable/'+latest_supplier.id+'/'+latest_supplier.slug">Learn more</a></p>
                                            <p class="tags" v-if="latest_supplier.tags.length >= 1">
                                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in latest_supplier.tags" :key="tag.id" :title="tag.sub_category_remarks">{{ tag.sub_category_remarks | str_limit(30) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </slide>
                    </carousel>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse bd-highlight">
                    <div class="p-2 bd-highlight">
                        <a href="/solutions/sustainable/suppliers" class="fs-6">View all sustainable solutions</a>
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
            axios.get('/solutions/sustainable/latest-suppliers')
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
        getLatestAdvanceSolutions() {
            axios.get('/solutions/sustainable/latest-advance-suppliers')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
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
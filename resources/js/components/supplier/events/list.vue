<template>
    <div class="row">
  

        <div>
            <h5>Dashboard</h5>
        </div>

        <div class="container my-4">
            <div class="row g-4">
                <div
                    v-for="event in events"
                    :key="event.id"
                    class="col-md-4 col-6"
                >
                    <div class="card shadow-sm h-100 d-flex flex-column">
                        <img
                        
                       src="assets/images/ssx-logo.png" 
                            alt="Event Image"
                            class="card-img-top p-3"
                        />
                        <div class="card-body text-center">
                            <p class="fs-3 card-title">
                                {{ event.event_name }}
                            </p>
                            <p class="card-text">
                                {{ event.location }} <br />
                                Event Date:
                                {{ formatDate(event.event_start) }} -
                                {{ formatDate(event.event_end) }} <br />
                                Registration:
                                {{ formatDate(event.registration_start) }} -
                                {{ formatDate(event.registration_end) }}
                            </p>
                            <!-- Show only if show_info_link is NOT empty -->
                            <a
                                v-if="event.show_info_link"
                                :href="event.show_info_link"
                                class="btn btn-outline-dark w-100 mb-2"
                                target="_blank"
                            >
                                Learn More
                            </a>
                            
                     <!-- IF status = null → first time registering -->
<a v-if="isWithinRegistration(event) && event.attendance_status === null"
   :href="'/supplier/registration/' + event.slug"
   class="btn btn-danger w-100">
   Register as Supplier/Exhibitor
</a>

<!-- IF status = 0 → Continue registration -->
<a v-if="isWithinRegistration(event) && event.attendance_status === 0"
   :href="'/supplier/registration/' + event.slug"
   class="btn btn-warning w-100">
   Continue my Registration
</a>

<!-- IF status = 1 + conforme_review = 0 → Pending Conforme Generation -->
<p v-if="event.attendance_status === 1 && event.conforme_review === 0"
   class="text-warning fw-bold">
   Pending Conforme Generation
</p>

<!-- IF status = 1 + conforme_review = 1 → Approved -->
<p v-if="event.attendance_status === 1 && event.conforme_review === 1"
   class="text-success fw-bold">
   Approved
</p>

<!-- IF status = 2 or 3 → Under review -->
<p v-if="[2, 3].includes(event.attendance_status)"
   class="text-muted fw-bold">
   Under Review
</p>

<!-- IF status = 4 or 5 → Dash only -->
<p v-if="[4, 5].includes(event.attendance_status)"
   class="text-muted fw-bold">
   —
</p>



                        </div>
                    </div>
                </div>

                <!-- Empty state -->
              
                       <!-- Empty state -->
                <div v-if="!isLoading && events.length === 0" class="col-12 text-center">
                    <p>No events found.</p>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            events: [],
            isLoading: false,
            msg: "Loading events...",
        };
    },
    mounted() {
        this.fetchEvents();
    },
    methods: {
        async fetchEvents() {
            this.isLoading = true;
            try {
                const response = await axios.get("/supplier/events-for-supplier");
                this.events = response.data;
            } catch (error) {
                console.error("Error fetching events:", error);
            } finally {
                this.isLoading = false;
            }
        },
        formatDate(dateString) {
            if (!dateString) return "TBA";
            const date = new Date(dateString);
            return date.toLocaleDateString("en-US", {
                year: "numeric",
                month: "short",
                day: "numeric",
            });
        },
         isWithinRegistration(event) {
        if (!event.registration_start || !event.registration_end) {
            return false;
        }
        const today = new Date();
        const start = new Date(event.registration_start);
        const end = new Date(event.registration_end);

        return today >= start && today <= end;
    }
    },
};
</script>

<style>
.card {
    border-radius: 30px;
}

.card img {
    border-top-left-radius: 30px;
    border-top-right-radius: 30px;
}
</style>

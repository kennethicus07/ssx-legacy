<template>
    <div v-html="widget.details"></div>
</template>
<script>
    export default {
        props:["id"],
        data() {
            return {
                widget: []
            }
        },
        created() {
            this.getWidget()
        },
        methods: {
            getWidget() {
                axios.get('/api/widgets/'+this.id)
                .then(response => {
                    //console.log(response.data);
                    if (response.status === 200) {
                        this.widget = response.data
                    }
                }).catch(err => {
                    console.log(err)
                })
            }
        }
    }
</script>
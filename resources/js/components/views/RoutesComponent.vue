<template>
    <div>
        <h1>Routes</h1>
        <div v-for:="city in cities" :key="city.id">
            {{ city.name }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        cities: Array
    },
    mounted() {
        console.log(this.cities)
    },
    methods: {
        getData: function() {
            axios.get('/test').then(
                response => {
                    console.log(response.data)
                }
            )
        }
    }
}
</script>

<style>

</style>
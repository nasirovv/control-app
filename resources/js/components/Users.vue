<template>
    <div>
        <h2 class="my-3">Users</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Day</th>
                    <th>Arrival Time</th>
                    <th>Departure Time</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="history in histories" :key="history.id">
                    <td>{{ history.user.name }}</td>
                    <td>{{ history.day }}</td>
                    <td>{{ history.arrival_time }}</td>
                    <td>{{ history.departure_time }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            histories: [],
            searchedUser: ''
        }
    },
    methods: {
        getHistories(){
            axios.get('/getHistories')
            .then(response => {
                this.histories = response.data
            })
            .catch(error => {
                console.log(error)
            })
        },
        search(){
            axios.get("/users/search/"+this.searchedUser)
                .then(response => {
                    this.histories = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
        connect(){
            window.Echo.channel('control').listen('ControlEvent', (e) => {
                this.getHistories();
            })
        },
    },
    created(){
        this.getHistories();
    },
    mounted() {
        this.connect();
    }

}
</script>
<style scoped>

</style>

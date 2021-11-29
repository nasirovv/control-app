<template>
    <div>
        <div class="d-flex align-items-center my-2 justify-content-between">
            <h2 class="my-auto">Users</h2>
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn btn-primary mr-4" @click="alertDisplay">Send to Mail</button>
                <a href="" class="btn btn-success" style="width: 170px">Download Excel</a>
            </div>
        </div>
        <hr>
        <div class="input-group mb-3">
            <div class="form-outline">
                <input type="text" class="form-control" placeholder="Search" v-model="searchedText" @keyup="searchTimeOut" @keyup.enter="search"/>
            </div>
            <button type="button" class="btn btn-primary ml-2" @click="search">
                Search
            </button>
        </div>
        <div class="table-responsive">
            <table v-if="!loading && histories.length" class="table table-striped table-sm">
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
            <div v-if="!histories.length && !loading">
                <h2>Nothing found</h2>
            </div>
            <div v-if="loading">
                <PuSkeleton height="34px" :count="10">
                </PuSkeleton>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            histories: [],
            searchedText: '',
            loading: true,
            timer: null
        }
    },
    methods: {
        getHistories() {
            axios.get('/getHistories')
                .then(response => {
                    this.histories = response.data
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => this.loading = false);
        },
        searchTimeOut() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.search()
            }, 800);
        },
        search() {
            this.loading = true
            if (!this.searchedText){
                this.getHistories()
            }else{
                axios.get("/users/search/" + this.searchedText)
                    .then(response => {
                        this.histories = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false);
            }
        },
        sendEmail(){
            axios.post("/mail-send")
                .then(response => {
                    this.$swal('Send', 'You successfully send this excel file', 'success')
                })
                .catch(error => {
                    console.log(error)
                })
        },
        alertDisplay(){
            this.$swal({
                title: 'Are you sure?',
                text: 'You can\'t revert your action',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Send to Mail!',
                cancelButtonText: 'No, Keep it!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if(result.value) {
                    this.sendEmail()
                } else {
                    this.$swal('Cancelled', 'Your file is still intact', 'info')
                }
            })
        },
        connect() {
            window.Echo.channel('control').listen('ControlEvent', (e) => {
                this.getHistories();
            })
        },
    },
    created() {
        this.getHistories();
    },
    mounted() {
        this.connect();
    }

}
</script>
<style scoped>

</style>

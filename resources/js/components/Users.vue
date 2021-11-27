<template>
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">
                    <button class="btn btn-sm btn-outline-secondary">Share</button>
                    <button class="btn btn-sm btn-outline-secondary">Export</button>
                </div>
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                    <span data-feather="calendar"></span>
                    This week
                </button>
            </div>
        </div>

        <h2>Section title</h2>
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
                <tr v-for="history in changedHistories" :key="history.id">
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
    props: ['histories'],
    created() {
        window.Echo.channel('control').listen('ControlEvent', (e) => {
            JSON.parse(JSON.stringify(this.changedHistories)).push();
            // let a = 1;
            // this.changedHistories.forEach(function (history){
            //     console.log(history)
            //     if(history.user_id === e.user_id && history.day === e.day){
            //         history = e;
            //         a++;
            //         console.log(a);
            //         console.log(history)
            //     }
            // })
            // if (a){
            //     this.changedHistories.push(e);
            // }
            // console.log(this.changedHistories)
        })
    },
    data(){
      return{
          changedHistories: this.histories
      }
    }
}
</script>
<style scoped>

</style>

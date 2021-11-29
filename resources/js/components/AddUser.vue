<template>
    <div class="main">
        <form @submit.prevent>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter full name" name="name" v-model="name">
            </div>
            <div class="form-group">
                <label for="id">Unique id</label>
                <input type="text" class="form-control" id="id" placeholder="Unique id" name="id" v-model="id">
            </div>
            <button type="submit" class="btn btn-primary" @click="addNewUser">Add</button>
        </form>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: '',
            id: '',
        }
    },
    methods: {
        addNewUser(){
            axios.post('/users/create', {
                'name': this.name,
                'uniqueId': this.id
            }).then(response => {
                this.name = ''
                this.id = ''
                this.$swal('Send', response.data, 'success')
            }).catch(error => {
                this.$swal('Error', 'Something went wrong', 'error')
            })
        }
    }
}
</script>

<style scoped>
    .main{
        margin-right: 300px;
    }
</style>

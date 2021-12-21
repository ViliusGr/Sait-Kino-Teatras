<template>
    <div>
        <div v-if="user && user.role === 'admin'">
            <button @click="setEditFalse()" type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                Add Screening
            </button>
        </div>
        

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="edit" class="modal-title" id="exampleModalLabel">Edit Screening</h5>
                    <h5 v-if="!edit" class="modal-title" id="exampleModalLabel">Add Screening</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addScreening" class="mb-3">
                        <datetime type="datetime" class="border mb-2" v-model="screening.time" zone="UTC+0" format="yyyy-MM-dd HH:mm:ss" :minute-step="5"></datetime>
                        <button type="submit" class="btn btn-warning btn-block">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col-md pb-3">
                        <img class="card-img-top mb-5" src="http://cdn.mos.cms.futurecdn.net/UmGVbv4jut4hQEaZ3A8YJD.jpg" alt="Card image cap">
                        <h3>{{ movie.title }}</h3>
                        <h5>{{ movie.director }}</h5>
                        <h6>{{ movie.year }}</h6>
                        <h6>{{ Math.floor(movie.length/60) }} h {{ movie.length%60 }} m </h6>
                        <p>{{ movie.description }}</p>
                </div>
                <div class="col-md pb-3 my-sidebar" v-if="screenings.length != 0">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Time</th>
                            <th scope="col" v-show="user">-</th>
                            <th scope="col" v-show="user && user.role === 'admin'">-</th>
                            <th scope="col" v-show="user && user.role === 'admin'">-</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(screening, skey) in screenings" v-bind:key="screening.id">
                                <th scope="row">{{skey+1}}</th>
                                <td>{{ screening.time }}</td>
                                <td v-show="user"><button @click="reserveScreening(screening.id, user.id)" class="btn btn-info">Reserve</button></td>
                                <td v-show="user && user.role === 'admin'"><button @click="editScreening(screening)" class="btn btn-warning mb-2" data-toggle="modal" data-target="#exampleModal">Edit</button></td>
                                <td v-show="user && user.role === 'admin'"><button @click="deleteScreening(screening.id)" class="btn btn-danger">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        

        
    </div>
</template>

<script>
    import Vue from 'vue'
    import { Datetime } from 'vue-datetime';
    import {mapGetters} from 'vuex'
 
    Vue.extend({
        template: '...',
        components: {
            datetime: Datetime
        }
    });

    export default {
        data() {
            return {
                screenings: [],
                screening: {
                    id: '',
                    time: ''
                },
                movie: {
                    id: '',
                    title: '',
                    description: '',
                    director: '',
                    year: '',
                    length: ''
                },
                screening_id: '',
                edit: false
            }
        },
        components:{
            Datetime
        },

        created() {
            this.fetchMovie(this.$route.params.movie_id);
            this.fetchScreenings(this.$route.params.movie_id);
        },

        methods: {
            fetchMovie(id){
                fetch(`/api/movies/${id}`)
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.movie = res;
                })
            },

            fetchScreenings(id){
                fetch(`/api/movies/${id}/screenings`)
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.screenings = res;
                })
            },

            deleteScreening(id) {
                if(confirm('Are you sure?')){
                    fetch(`/api/movies/${this.movie.id}/screenings/${id}`, {
                        method: 'delete',
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(data => {
                        alert('Screening removed');
                        this.fetchScreenings(this.movie.id);
                    })
                    .catch(err => console.log(err));
                }
            },

            addScreening() {
                if(this.edit === false){
                    fetch(`/api/movies/${this.movie.id}/screenings`, {
                        method: 'post',
                        body: JSON.stringify(this.screening),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.screening.time = '';
                        alert('Screening added');
                        this.fetchScreenings(this.movie.id);
                    })
                    .catch(err => console.log(err));
                } else {
                    fetch(`/api/movies/${this.movie.id}/screenings/${this.screening_id}`, {
                        method: 'put',
                        body: JSON.stringify(this.screening),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.screening.time = '';
                        alert('Screening updated');
                        this.fetchScreenings(this.movie.id);
                    })
                    .catch(err => console.log(err));
                }
            },

            editScreening(screening){
                this.edit = true;
                this.screening.id = screening.id;
                this.screening_id = screening.id;
                this.screening.time = screening.time;
            },

            setEditFalse(){
                this.edit = false;
                this.screening.id = '';
                this.screening_id = '';
                this.screening.time = '';
            },

            reserveScreening(screening_id, user_id){
                fetch(`/api/users/${user_id}/tickets`, {
                        method: 'post',
                        body: JSON.stringify({
                            cost: '5',
                            screening_id: screening_id
                        }),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('You have reserved');
                        console.log(data);
                        //this.fetchScreenings(this.movie.id);
                    })
                    .catch(err => console.log(err));
                    
            }

            
        },
        computed: {
            ...mapGetters(['user'])
        }
    }
</script>

<style>
    .my-sidebar {
        -ms-flex: 0 0 300px;
        flex: 0 0 300px;
    } 

    .table {
        overflow: auto;
    }

</style>
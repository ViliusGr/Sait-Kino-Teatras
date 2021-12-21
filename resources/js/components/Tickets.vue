<template>
    <div>
        <h2 class="mb-3">My Tickets</h2>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="edit" class="modal-title" id="exampleModalLabel">Edit Ticket</h5>
                    <h5 v-if="!edit" class="modal-title" id="exampleModalLabel">Add Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addScreening" class="mb-3">
                        <button type="submit" class="brn btn-light btn-block">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        
        
        <div class="container" v-if="tickets.length != 0">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Time</th>
                        <th scope="col">Movie</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ticket, tkey) in tickets" v-bind:key="ticket.id">
                        <th scope="row">{{tkey+1}}</th>
                        <td>{{ ticket.screening.time }}</td>
                        <td>{{ ticket.screening.movie.title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        

        
    </div>
</template>

<script>
    import Vue from 'vue'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                tickets: [],
                ticket: {
                    id: '',
                    user_id: '',
                    screening_id: '',
                    cost: '',
                    screening: {
                        id: '',
                        time: '',
                        movie: {
                            id: '',
                            title: '',
                            description: '',
                            director: '',
                            year: '',
                            length: ''
                        }
                    }
                },
                ticket_id: '',
                user_id: '',
                edit: false
            }
        },

        created() {
            //this.fetchMovie(this.$route.params.movie_id);
            this.user_id = this.$route.params.user_id
            this.fetchTickets();
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

            fetchScreening(id){
                fetch(`/api/movies/${id}`)
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.movie = res;
                })
            },

            fetchTickets(){
                fetch(`/api/users/${this.user_id}/tickets`, {
                    headers: {
                        'accept': 'application/json',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.tickets = res;
                    console.log(res);
                })
                .catch(err => console.log(err));
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

</style>
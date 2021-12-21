<template>
    <div>
        <h2 class="mb-3">Movies</h2>
        <div v-if="user && user.role === 'admin'">
            <button @click="setEditFalse()" type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                Add Movie
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="edit" class="modal-title" id="exampleModalLabel">Edit Movie</h5>
                    <h5 v-if="!edit" class="modal-title" id="exampleModalLabel">Add Movie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addMovie" class="mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Title" v-model="movie.title">
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" placeholder="Description" v-model="movie.description"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Movie director" v-model="movie.director">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Year" v-model="movie.year">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Movie length (mins)" v-model="movie.length">
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        
        <div class="row equal">
            <div class="col-md-4 d-flex pb-3" v-for="movie in movies" v-bind:key="movie.id">
                <div class="card card-block">
                    <img class="card-img-top" src="https://m.media-amazon.com/images/I/61ux6FzCdGL._AC_SL1280_.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h3 style="text-align:center">{{ movie.title }}</h3>
                        <h6>{{ movie.director }}</h6>
                        <h6>{{ movie.year }}</h6>
                        <h6>{{ Math.floor(movie.length/60) }} h {{ movie.length%60 }} m </h6>
                        <p>{{ movie.description }}</p>
                        <hr>
                        <button @click="editMovie(movie)" v-show="user && user.role === 'admin'" class="btn btn-warning my-2" data-toggle="modal" data-target="#exampleModal">Edit</button>
                        <button @click="deleteMovie(movie.id)" v-show="user && user.role === 'admin'" class="btn btn-danger my-2">Delete</button>
                        <router-link :to="{ path: '/movies/' + movie.id + '/screenings'}" tag="button" class="btn btn-info my-2">Read more...</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
    export default {
        data() {
            return {
                movies: [],
                movie: {
                    id: '',
                    title: '',
                    description: '',
                    director: '',
                    year: '',
                    length: ''
                },
                movie_id: '',
                edit: false
            }
        },

        created() {
            this.fetchMovies();
        },

        methods: {
            fetchMovies(){
                fetch('api/movies')
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.movies = res;
                })
            },

            deleteMovie(id) {
                if(confirm('Are you sure?')){
                    fetch(`api/movies/${id}`, {
                        method: 'delete',
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(data => {
                        alert('Movie removed');
                        this.fetchMovies();
                    })
                    .catch(err => console.log(err));
                }
            },

            addMovie() {
                if(this.edit === false){
                    fetch('api/movies', {
                        method: 'post',
                        body: JSON.stringify(this.movie),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.movie.title = '';
                        this.movie.description = '';
                        this.movie.director = '';
                        this.movie.year = '';
                        this.movie.length = '';
                        alert('Movie added');
                        this.fetchMovies();
                    })
                    .catch(err => console.log(err));
                } else {
                    fetch(`api/movies/${this.movie_id}`, {
                        method: 'put',
                        body: JSON.stringify(this.movie),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.movie.title = '';
                        this.movie.description = '';
                        this.movie.director = '';
                        this.movie.year = '';
                        this.movie.length = '';
                        alert('Movie updated');
                        this.fetchMovies();
                    })
                    .catch(err => console.log(err));
                }
            },

            editMovie(movie){
                this.edit = true;
                this.movie.id = movie.id;
                this.movie_id = movie.id;
                this.movie.title = movie.title;
                this.movie.description = movie.description;
                this.movie.director = movie.director;
                this.movie.length = movie.length;
                this.movie.year = movie.year;
            },

            setEditFalse(){
                this.edit = false;
                this.movie.id = '';
                this.movie_id = '';
                this.movie.title = '';
                this.movie.description = '';
                this.movie.director = '';
                this.movie.length = '';
                this.movie.year = '';
            }
            
        },
        computed: {
            ...mapGetters(['user'])
        }
    }
</script>
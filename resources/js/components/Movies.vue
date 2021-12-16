<template>
    <div>
        <h2>Movies</h2>
        <form @submit.prevent="addMovie" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="movie.title">
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" placeholder="Description" v-model="movie.description"></textarea>
            </div>
            <button type="submit" class="brn btn-light btn-block">Save</button>
        </form>
        <div class="card card-body mb-2" v-for="movie in movies" v-bind:key="movie.id">
            <h3>{{ movie.title }}</h3>
            <h6>{{ movie.director }}</h6>
            <h6>{{ movie.year }}</h6>
            <h6>{{ movie.length }}</h6>
            <p>{{ movie.description }}</p>
            <hr>
            <button @click="deleteMovie(movie.id)" class="btn btn-danger">Delete</button>
        </div>
    </div>
</template>

<script>
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
                pagination: {},
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
                        method: 'delete' 
                    })
                    .then(data => {
                        alert('Movie removed');
                        this.fetchMovies();
                    })
                    .catch(err => console.log(err));
                }
            },

            addMovie() {
                
            }
        }
    }
</script>
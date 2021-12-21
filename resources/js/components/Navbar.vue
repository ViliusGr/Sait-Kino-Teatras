<template>
    <nav class="navbar navbar-dark navbar-expand-md mb-2">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <router-link to="/" class="nav-link"><img src = "logo.svg" alt="logo" style="height: 20px; width: 20px;"/> <span class="sr-only">(current)</span></router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/movies" class="nav-link">Movies</router-link>
                </li>


                <li v-if="!user" class="nav-item">
                    <router-link to="/login" class="nav-link">Login</router-link>
                </li>
                <li v-if="!user" class="nav-item">
                    <router-link to="/register" class="nav-link">Sign up</router-link>
                </li>

                <li v-if="user && user.role === 'admin'" class="nav-item">
                    <router-link to="/auditoria" class="nav-link">Auditoria</router-link>
                </li>

                <li v-if="user" class="nav-item">
                    <router-link :to="{ path: '/users/' + user.id + '/tickets'}" class="nav-link">Tickets</router-link>
                </li>
                <li v-if="user" class="nav-item">
                    <a href="javascript:void(0)" @click="handleClick" class="nav-link">Logout</a>
                </li>
            </ul>
            
        </div>
    </nav>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: 'Nav',
    methods: {
        handleClick(){
            localStorage.removeItem('token');
            this.$store.dispatch('user', null);
            this.$router.push('/');
        }
    },
    computed: {
        ...mapGetters(['user'])
    }
};
</script>
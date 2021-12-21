<template>
    <div class="col-md-12">
        <div class="card card-container">
            <img src = "account.svg" alt="acc" id="profile-img"
            class="profile-img-card"/>
            <form name="form" @submit.prevent="handleSubmit">
            <error v-if="error" :error="error"></error>
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    v-model="email"
                    type="email"
                    class="form-control"
                    name="email"
                />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    v-model="password"
                    type="password"
                    class="form-control"
                    name="password"
                />
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block">
                <span>Login</span>
                </button>
            </div>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Error from './Error.vue'

    export default {
        name: 'Login',
        components: {
            Error
        },
        data() {
            return {
                email: '',
                password: '',
                error: ''
            }
        },
        methods: {
            async handleSubmit(){
                try{
                    const response = await axios.post('/api/login', {
                        email: this.email,
                        password: this.password
                    });

                    localStorage.setItem('token', response.data.token);
                    this.$store.dispatch('user', response.data.user);
                    this.$router.push('/');
                } catch (e) {
                    this.error = 'Invalid username/password'
                }
                
            }
        }
    }
</script>

<style scoped>
label {
  display: block;
  margin-top: 10px;
}

.card-container.card {
  max-width: 350px !important;
  padding: 40px 40px;
}

.card {
  background-color: var(--color-4);
  padding: 20px 25px 30px;
  margin: 0 auto 25px;
  margin-top: 50px;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
}

.profile-img-card {
  width: 96px;
  height: 96px;
  margin: 0 auto 10px;
  display: block;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  border-radius: 50%;
}
</style>
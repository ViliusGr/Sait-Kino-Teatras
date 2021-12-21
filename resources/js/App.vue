<template>
	<div id="app">
		<Nav />
		<div id="body">
			<transition name="fade" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
		<Footer />
  	</div>
</template>

<script>
import axios from 'axios'
import Nav from './components/Navbar.vue'
import Footer from './components/Footer.vue'

export default {
	name: 'App',
	components: {
		Nav,
		Footer
	},
	async created(){
		try {
			const response = await axios.get('/api/user');
			
			this.$store.dispatch('user', response.data);
		} catch (e) {
			console.log('No user')
		}
	}
};
</script>

<style>
	:root {
		--color-0: #ffffff;
		--color-1: #006466;
		--color-2: #065a60;
		--color-3: #0b525b;
		--color-4: #144552;
		--color-5: #1b3a4b;
		--color-6: #212f45;
		--color-7: #272640;
		--color-8: #312244;
		--color-9: #3e1f47;
		--color-10: #4d194d;
	}

	html,
	body {
		margin:0;
		padding:0;
		height:100%;
		font-family: 'Bai Jamjuree';
		background-color: var(--color-5);
		color: var(--color-0);
		/*font-size: 22px;*/
	}

	nav {
		background-color: var(--color-4);
	}

	a {
		color: var(--color-0);
	}

	a:hover {
		color: var(--color-1);
	}

	.form-control {
		background-color: var(--color-5);
		color: var(--color-0);
		border: none;
	}

	.form-control:focus {
		background-color: var(--color-5);
		color: var(--color-0);
		border: none;
	}

	.form-control:autofill {
		background-color: var(--color-4);
		color: var(--color-0);
		border: none;
	}

	.card-body {
		background-color: var(--color-4);
	}

	.card {
		border: black	;
	}

	thead {
		background-color: var(--color-3);
		color: var(--color-0);
	}

	tbody {
		background-color: var(--color-4);
		color: var(--color-0);
	}

	.modal-content{
		background-color: var(--color-4);
	}

	.table tr th {
		border-bottom: none;
	}

	.table tr td {
		border-bottom: none;
	}

	.btn-info, .btn-primary{
		background-color: var(--color-1);
		border: black;
	}

	.btn-info:hover, .btn-primary:hover{
		background-color: var(--color-3);
	}

	.btn-warning{
		background-color: var(--color-10);
		color: var(--color-0);
		border: black;
	}

	.btn-warning:hover{
		background-color: var(--color-9);
		color: var(--color-0);
	}

	.btn-danger{
		background-color: var(--color-8);
		color: var(--color-0);
		border: black;
	}

	.btn-danger:hover{
		background-color: var(--color-9);
		color: var(--color-0);
	}

	#app {
		min-height:100%;
    	position:relative;
	}
    #body {
		padding:10px;
    	padding-bottom:60px;
    }

	.table-screenings {
		width: 80%;
	}

	.route-enter-from{
		opacity: 0;
		transform: translateX(100px);
	}

	.route-enter-active{
		transition: all 0.3s ease-out;
	}

	.route-leave-to{
		opacity: 0;
		transform: translateX(-100px);
	}

	.route-leave-active{
		transition: all 0.3s ease-in;
	}

	.fade-enter, .fade-leave-to {
		opacity: 0;
		transform: translateX(2em);
	}

	.fade-enter-active, .fade-leave-active {
		transition: all 0.3s ease;
	}
</style>
<template>
    <div>
        <h2 class="mb-3">Auditoria</h2>
        <div v-if="user && user.role === 'admin'">
            <button @click="setEditFalse()" type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                Add Auditorium
            </button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-if="edit" class="modal-title" id="exampleModalLabel">Edit Auditorium</h5>
                    <h5 v-if="!edit" class="modal-title" id="exampleModalLabel">Add Auditorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addAuditorium" class="mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Code" v-model="auditorium.code">
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" placeholder="Number of rows" v-model="auditorium.numberOfRows"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Number of seats in one row" v-model="auditorium.numberOfSeatsInRow">
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
            <div class="col-md-4 d-flex pb-3" v-for="auditorium in auditoria" v-bind:key="auditorium.id">
                <div class="card card-block" style="width: 20rem;">
                    <div class="card-body">
                        <h3>Auditorium: {{ auditorium.code }}</h3>
                        <h6>Total seats: {{ auditorium.numberOfRows * auditorium.numberOfSeatsInRow }}</h6>
                        <h6>Rows: {{ auditorium.numberOfRows }}</h6>
                        <h6>Seats in row: {{ auditorium.numberOfSeatsInRow }}</h6>
                        <hr>
                        <button @click="editAuditorium(auditorium)" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Edit</button>
                        <button @click="deleteAuditorium(auditorium.id)" class="btn btn-danger">Delete</button>
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
                auditoria: [],
                auditorium: {
                    id: '',
                    code: '',
                    numberOfRows: '',
                    numberOfSeatsInRow: ''
                },
                auditorium_id: '',
                edit: false
            }
        },

        created() {
            this.fetchAuditoria();
        },

        methods: {
            fetchAuditoria(){
                fetch('/api/auditoria', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.auditoria = res;
                })
            },

            deleteAuditorium(id) {
                if(confirm('Are you sure?')){
                    fetch(`/api/auditoria/${id}`, {
                        method: 'delete',
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(data => {
                        alert('Auditorium removed');
                        this.fetchAuditoria();
                    })
                    .catch(err => console.log(err));
                }
            },

            addAuditorium() {
                if(this.edit === false){
                    fetch('/api/auditoria', {
                        method: 'post',
                        body: JSON.stringify(this.auditorium),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.auditorium.code = '';
                        this.auditorium.numberOfRows = '';
                        this.auditorium.numberOfSeatsInRow = '';
                        alert('Auditorium added');
                        this.fetchAuditoria();
                    })
                    .catch(err => console.log(err));
                } else {
                    fetch(`/api/auditoria/${this.auditorium_id}`, {
                        method: 'put',
                        body: JSON.stringify(this.auditorium),
                        headers: {
                            'content-type': 'application/json',
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.auditorium.code = '';
                        this.auditorium.numberOfRows = '';
                        this.auditorium.numberOfSeatsInRow = '';
                        alert('Auditorium updated');
                        this.fetchAuditoria();
                    })
                    .catch(err => console.log(err));
                }
            },

            editAuditorium(auditorium){
                this.edit = true;
                this.auditorium.id = auditorium.id;
                this.auditorium_id = auditorium.id;
                this.auditorium.code = auditorium.code;
                this.auditorium.numberOfRows = auditorium.numberOfRows;
                this.auditorium.numberOfSeatsInRow = auditorium.numberOfSeatsInRow;
            },
            setEditFalse(){
                this.edit = false;
                this.auditorium.id = '';
                this.auditorium_id = '';
                this.auditorium.code = '';
                this.auditorium.numberOfRows = '';
                this.auditorium.numberOfSeatsInRow = '';
            }
            
        },
        computed: {
            ...mapGetters(['user'])
        }
    }
</script>
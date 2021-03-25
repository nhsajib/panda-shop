<template>
<div id="component">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title"> Shipping Method 
                            <button type="button" @click="addshipping" class="btn btn-success float-right card-h-btn">Add Shipping Method</button>
                        </h4>

                    </div>
                    <div class="card-body">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Method Name</th>
                                  <th scope="col">Cost</th>
                                  <th scope="col">Description</th>
                                  <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(ship, index) in shippings" :kye="index">
                                    <td scope="row"> {{index+1}} </td>
                                    <td> {{ ship.name }} </td>
                                    <td> {{ ship.price }} </td>
                                    <td> {{ ship.description }} </td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" @click="editShipping(ship)">Edit Shipping</button>
                                                <button class="dropdown-item" @click="deleteShipping(ship)">Delete Shipping</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>


<!---------------------------
  Modal Section
---------------------------->


<!-- The Modal -->
<div class="modal" id="shipping">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="card">
            <div class="card-header card-head-bg text-light">
                <h4 class="card-title"> Edit Top Category</h4>
            </div>
            <div class="card-body" id="top_cat_body">
                <form @submit.prevent="" class="form-horizontal">

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 text-right control-label col-form-label">Method Name</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="shipping.name" class="form-control" id="name"
                            placeholder="Name" :class="{ 'is-invalid': shipping.errors.has('name') }">
                            <has-error :form="shipping" field="name"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-sm-3 text-right control-label col-form-label">Shipping Cost</label>
                        <div class="col-sm-9">
                            <input type="number" v-model="shipping.price" class="form-control" id="price"
                            placeholder="Price" :class="{ 'is-invalid': shipping.errors.has('price') }">
                            <has-error :form="shipping" field="price"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea v-model="shipping.description" class="form-control" :class="{ 'is-invalid': shipping.errors.has('description') }"></textarea>
                            <has-error :form="shipping" field="description"></has-error>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" v-if="!editmode" @click="createshipping()" class="btn btn-success float-right">Create</button>
                <button type="button" v-if="editmode" @click="updateShip()" class="btn btn-success float-right">Update</button>
            </div>
        </div>
    </div>
  </div>
</div>

</div>
</template>

<script>
    export default {
        data(){
            return{
                shipping: new Form({
                    id: '',
                    name: '',
                    price: '',
                    description: '',
                }),

                shippings: [],

                editmode: false,
            }
        },

        methods:{



            // Delete Top Category
            deleteShipping(ship){

                Notiflix.Confirm.Show(
                    'Delete Confirm',
                    'Do you want to delete '+ship.name+' Shipping Method?',
                    'Yes',
                    'No',
                    function(){
                        axios.delete('/api/admin/shipping/'+ship.id)
                        .then(res=>{
                            Notiflix.Notify.Info('Successfully deleted.');
                            this.getallshipping();
                        })
                        .catch(e=>{
                            console.log(e)
                        })
                    }.bind(this),
                );
            },

            // Edit Category Options
            updateShip(){
                Notiflix.Block.Dots('div#top_cat_body', 'Please wait...');
                this.shipping.put('/api/admin/shipping/'+this.shipping.id)
                .then(res=>{
                    this.getallshipping();
                    Notiflix.Notify.Success('Shipping Method Succrssfully Updated.');
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                })
            },

            editShipping(ship){
                this.editmode = true;
                this.shipping.clear();
                this.shipping.fill(ship);
                $('#shipping').modal('show');

            },

            // Add Category Options
            createshipping(){
                Notiflix.Block.Dots('div#top_cat_body', 'Please wait...');
                this.shipping.post('/api/admin/shipping')
                .then(res=>{
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                    Notiflix.Notify.Success('Shipping Method Succrssfully Created');
                    this.getallshipping();
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                })
            },

            addshipping(){
                this.shipping.clear();
                this.editmode = false;
                this.shipping.reset();
                $('#shipping').modal('show');
            },

            // Get Category data
            getallshipping(){
                Notiflix.Block.Dots('div#component', 'Please wait...');
                axios.get('/api/admin/shipping')
                .then(res=>{
                    this.shippings = res.data.data;
                    Notiflix.Block.Remove('div#component', 600);
                })
                .catch(e=>{
                    Notiflix.Block.Remove('div#component', 600);
                })
            }


        },

        mounted() {
            this.getallshipping();
        }
    }
</script>

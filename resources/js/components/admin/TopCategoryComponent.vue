<template>
<div id="component">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title"> Top Category 
                            <button type="button" @click="addtopcat" class="btn btn-success float-right card-h-btn">Add Category</button>
                        </h4>

                    </div>
                    <div class="card-body">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Category Name</th>
                                  <th scope="col">Description</th>
                                  <th scope="col" class="text-center">Image</th>
                                  <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(tcat, index) in topcategory" :kye="index">
                                    <td scope="row"> {{index+1}} </td>
                                    <td> {{ tcat.name }} </td>
                                    <td> {{ tcat.description }} </td>
                                    <td class="align-middle text-center">
                                        <img :src="'/upload/img/'+tcat.img" class="img-thumbnail" height="50px" width="50px">
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" @click="ViewTopCat(tcat)">View Category</button>
                                                <button class="dropdown-item" @click="EditTopCat(tcat)">Edit Category</button>
                                                <button class="dropdown-item" @click="DeleteTopCat(tcat)">Delete Category</button>
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
<div class="modal" id="top-cat">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="card">
            <div class="card-header card-head-bg text-light">
                <h4 class="card-title" v-show="!editmode"> Add Top Category</h4>
                <h4 class="card-title" v-show="editmode"> Edit Top Category</h4>
            </div>
            <div class="card-body" id="top_cat_body">
                <form @submit.prevent="" class="form-horizontal">

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 text-right control-label col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="tcatdata.name" class="form-control" id="name"
                            placeholder="Category Name" :class="{ 'is-invalid': tcatdata.errors.has('name') }">
                            <has-error :form="tcatdata" field="name"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea v-model="tcatdata.description" class="form-control" :class="{ 'is-invalid': tcatdata.errors.has('description') }"></textarea>
                            <has-error :form="tcatdata" field="description"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="img" class="col-sm-3 text-right control-label col-form-label">Image</label>
                        <div class="col-sm-9">
                        <input type="file" id="file" ref="image" accept="image/*" v-on:change="imagehandeler()" class="form-control"/>
                        <div id="require-img" class="invalid-feedback">Please select an image.</div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="img" class="col-sm-3 text-right control-label col-form-label"></label>
                        <div class="col-sm-9">
                            <img :src="this.tcatdata.img" alt="" v-show="previewimg" class="img-thumbnail" width="180px">
                            <img :src="'/upload/img/'+this.tcatdata.img" alt="" v-show="existingimg" class="img-thumbnail" width="180px">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" v-show="!editmode" @click="createcat()" class="btn btn-success float-right">Create</button>
                <button type="button" v-show="editmode" @click="updatecat()" class="btn btn-warning float-right">Update</button>
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
                tcatdata: new Form({
                    id: '',
                    name: '',
                    description: '',
                    img: null,
                }),
                previewimg: false,
                editmode: false,
                existingimg: false,
                topcategory: [],

            }
        },

        methods:{

            // Delete Top Category
            DeleteTopCat(cat){

                Notiflix.Confirm.Show(
                    'Delete Confirm',
                    'Do you want to delete '+cat.name+' Category ?',
                    'Yes',
                    'No',
                    function(){
                        axios.delete('/api/admin/top-category/'+cat.id)
                        .then(res=>{
                            Notiflix.Notify.Info('Delete Successfull');
                            this.getTopCategory();
                        })
                        .catch(e=>{
                            console.log(e)
                        })
                    }.bind(this),
                );
            },

            // Edit Category Options
            updatecat(){
                Notiflix.Block.Dots('div#top_cat_body', 'Please wait...');
                this.tcatdata.put('/api/admin/top-category/'+this.tcatdata.id)
                .then(res=>{
                    this.getTopCategory();
                    Notiflix.Notify.Success('Top Category Succrssfully Updated.');
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                })
            },

            EditTopCat(category){
                $( "#require-img" ).removeClass( " d-block" );
                $( "#file" ).removeClass( " is-invalid" );

                this.editmode = true;
                this.existingimg = true;
                this.previewimg = false;
                this.tcatdata.fill(category);
                this.tcatdata.clear();
                $('#top-cat').modal('show');

            },

            imagehandeler(){
                let selectImg = this.$refs.image.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.tcatdata.img = reader.result;
                            this.previewimg = true;
                            this.existingimg = false;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.tcatdata.img = null;
                        this.previewimg = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.tcatdata.img = null;
                        this.previewimg = false;
                    }
                }
            },


            // Add Category Options
            createcat(){
                if(this.tcatdata.img == null){
                    // alert('Please Select Images')
                    $( "#require-img" ).addClass( " d-block" );
                    $( "#file" ).addClass( " is-invalid" );
                }
                Notiflix.Block.Dots('div#top_cat_body', 'Please wait...');
                this.tcatdata.post('/api/admin/top-category')
                .then(res=>{
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                    Notiflix.Notify.Success('Top Category Succrssfully Created');
                    this.getTopCategory();
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#top_cat_body', 600);
                })
            },
            addtopcat(){
                this.tcatdata.clear();
                this.editmode = false;
                this.existingimg = false;
                this.tcatdata.reset();
                $('#top-cat').modal('show');
            },

            // Get Category data

            getTopCategory(){
                Notiflix.Block.Dots('div#component', 'Please wait...');
                axios.get('/api/admin/top-category')
                .then(res=>{
                    this.topcategory = res.data.data;
                    Notiflix.Block.Remove('div#component', 600);
                })
                .catch(e=>{
                    Notiflix.Block.Remove('div#component', 600);
                })

            }


        },

        mounted() {
            this.getTopCategory();
        }
    }
</script>

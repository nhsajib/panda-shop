<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title l_hight17">Top Category
                            <form class="form-inline float-right">
                              <div class="form-group mx-sm-3 live-query">
                                <label for="livesearch" class="sr-only">Live Search</label>
                                <input type="text" v-model="query" class="form-control" id="livesearch" placeholder="Search By Category">
                              </div>
                              <button type="button" @click="addcategory" class="btn btn-success float-right card-h-btn">Add Category</button>
                            </form>
                        </h4>
                    </div>
                    <div class="card-body" id="component">

                        <table class="table">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Top Category</th>
                                  <th scope="col">Category Name</th>
                                  <th scope="col">Description</th>
                                  <th scope="col" class="text-center">Image</th>
                                  <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(cat, index) in category.data" :kye="index">
                                    <td scope="row"> {{ index+1 }} </td>
                                    <td scope="row"> {{ cat.topcategory.name }} </td>
                                    <td> {{ cat.name }} </td>
                                    <td> {{ cat.description }} </td>
                                    <td class="align-middle text-center">
                                        <img :src="'/upload/img/'+cat.img" class="img-thumbnail" height="50px" width="50px">
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" @click="ViewCat(cat)">View Category</button>
                                                <button class="dropdown-item" @click="EditCat(cat)">Edit Category</button>
                                                <button class="dropdown-item" @click="DeleteCat(cat)">Delete Category</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="category" @pagination-change-page="getCategory" v-show="!inSearch"></pagination>
                        <pagination :data="category" @pagination-change-page="searchData" v-show="inSearch"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!---------------------------
  Modal Section
---------------------------->


<!-- The Modal -->
<div class="modal" id="categorymodal">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="card">
            <div class="card-header card-head-bg text-light">
                <h4 class="card-title" v-show="!editmode"> Add Categories</h4>
                <h4 class="card-title" v-show="editmode"> Edit Top Categories</h4>
            </div>
            <div class="card-body" id="cat_modal_body">
                <form @submit.prevent="" class="form-horizontal">

                    <div class="form-group row">
                        <label for="topcategory" class="col-sm-3 text-right control-label col-form-label">Top Category</label>
                        <div class="col-sm-9">
                              <v-select
                                :options="topcategory"
                                label="name"
                                :reduce="topcategory => topcategory.id"
                                v-model="catdata.topcategory_id">
                              </v-select>
                            <div id="req-id" class="invalid-feedback">Please select top category.</div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-sm-3 text-right control-label col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" v-model="catdata.name" class="form-control" id="name"
                            placeholder="Category Name" :class="{ 'is-invalid': catdata.errors.has('name') }">
                            <has-error :form="catdata" field="name"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea v-model="catdata.description" class="form-control" :class="{ 'is-invalid': catdata.errors.has('description') }"></textarea>
                            <has-error :form="catdata" field="description"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="img" class="col-sm-3 text-right control-label col-form-label">Image</label>
                        <div class="col-sm-9">
                        <input type="file" id="img" ref="image" accept="image/*" v-on:change="imagehandeler()" class="form-control" :class="{ 'is-invalid': catdata.errors.has('img') }"/>
                        <has-error :form="catdata" field="img"></has-error>
                        <!-- <div id="require-img" class="invalid-feedback">Please select an image.</div> -->
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="img" class="col-sm-3 text-right control-label col-form-label"></label>
                        <div class="col-sm-9">
                            <img :src="this.catdata.img" alt="" v-show="previewimg" class="img-thumbnail" width="180px">
                            <img :src="'/upload/img/'+this.catdata.img" alt="" v-show="existingimg" class="img-thumbnail" width="180px">
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

                category: {},

                catdata: new Form({
                    id: '',
                    topcategory_id: '',
                    name: '',
                    description: '',
                    img: null,
                }),
                previewimg: false,
                editmode: false,
                existingimg: false,
                topcategory: [],

                // Search
                query: '',
                inSearch: '',
            }
        },


        watch: {
          query: function (newQ, oldQ){
              if(newQ === ''){
                this.inSearch = false;
                this.getCategory();
              }else{
                this.searchData();
                this.inSearch = true;
              }
          }
        },

        methods:{
                // Live Searcy by Categoyr Name
            searchData(page = 1){
                Notiflix.Block.Dots('div#component', 'Please wait...');
                axios.get('/api/admin/category/search/'+this.query+'?page='+page)
                .then(res=>{
                    this.category = res.data;
                    Notiflix.Block.Remove('div#component', 600);
                })
                .catch(e=>{
                    console.log(e)
                    Notiflix.Block.Remove('div#component', 600);
                })
            },

            // Delete Top Category
            DeleteCat(cat){
                Notiflix.Confirm.Show(
                    'Delete Confirm',
                    'Do you want to delete '+cat.name+' category ?',
                    'Yes',
                    'No',
                    function(){
                        axios.delete('/api/admin/category/'+cat.id)
                        .then(res=>{
                            Notiflix.Notify.Info('Delete Successfull');
                            this.getCategory();
                        })
                        .catch(e=>{
                            console.log(e)
                        })
                    }.bind(this),
                );
            },

            // Edit Category Options
            updatecat(){
                Notiflix.Block.Dots('div#cat_modal_body', 'Please wait...');
                this.catdata.put('/api/admin/category/'+this.catdata.id)
                .then(res=>{
                    this.getCategory();
                    Notiflix.Notify.Success('Category Succrssfully Updated.');
                    Notiflix.Block.Remove('div#cat_modal_body', 600);
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#cat_modal_body', 600);
                })
            },

            EditCat(category){
                $( "#vs1__combobox" ).removeClass( " red-border" );
                $( "#req-id" ).removeClass( " d-block" );

                this.getTopCategory();
                this.editmode = true;
                this.existingimg = true;
                this.previewimg = false;
                this.catdata.fill(category);
                this.catdata.clear();
                $('#categorymodal').modal('show');

            },

            imagehandeler(){
                let selectImg = this.$refs.image.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.catdata.img = reader.result;
                            this.previewimg = true;
                            this.existingimg = false;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.catdata.img = null;
                        this.previewimg = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.catdata.img = null;
                        this.previewimg = false;
                    }
                }
            },


            // Add Category Options
            createcat(){
                if(this.catdata.topcategory_id == ''){
                    // alert('Please Select Top Category')
                    $( "#vs1__combobox" ).addClass( " red-border" );
                    $( "#req-id" ).addClass( " d-block" );
                }
                if(!this.catdata.topcategory_id == ''){
                    // alert('Please Select Top Category')
                    $( "#vs1__combobox" ).removeClass( " red-border" );
                    $( "#req-id" ).removeClass( " d-block" );
                }
                Notiflix.Block.Dots('div#cat_modal_body', 'Please wait...');
                this.catdata.post('/api/admin/category')
                .then(res=>{
                    Notiflix.Block.Remove('div#cat_modal_body', 600);
                    Notiflix.Notify.Success('Category Succrssfully Created');
                    this.getCategory();
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#cat_modal_body', 600);
                })
            },
            addcategory(){
                this.getTopCategory();
                this.catdata.clear();
                this.editmode = false;
                this.existingimg = false;
                this.catdata.reset ();
                $('#categorymodal').modal('show');
            },

            // Get Category data

            getCategory(page = 1){
                Notiflix.Block.Dots('div#component', 'Please wait...');
                axios.get('/api/admin/category?page=' + page)
                .then(res=>{
                    this.category = res.data;
                    Notiflix.Block.Remove('div#component', 600);
                })
                .catch(e=>{
                    Notiflix.Block.Remove('div#component', 600);
                })
            },

            getTopCategory(){
                axios.get('/api/admin/top-category')
                .then(res=>{
                    this.topcategory = res.data.data;
                })
                .catch(e=>{
                    console.log(e);
                })

            }


        },

        mounted() {
            this.getCategory();
        }
    }
</script>

<template>
<div id="component">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title"> Featured Products Setting </h4>
                    </div>
                    <div class="card-body" id="featured_main">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-warning">
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(fproduct, index) in featuredProducts" :kye="index">
                                    <th>{{index+1}}</th>
                                    <td>{{fproduct.category.name}}</td>
                                    <td>{{fproduct.title}}</td>
                                    <td><img :src="'/upload/img/'+fproduct.image" alt="" style="width: 50px; height: 50px"></td>
                                    <td><button class="btn btn-sm btn-outline-danger" @click="removefeatureP(fproduct.id)">Remove form Featuted</button></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row justify-content-center mt-2" style="background-color: #ffc10738;">
                            <div class="col-md-6 mt-2 p-2">
                                <form @submit.prevent="">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="product_title_search">Search Product</label>
                                        <input type="text" v-model="featuredPfind" class="form-control" id="product_title_search" placeholder="Product Title">
                                    </div>

                                    <!-- Select Featured Products Search Result -->
                                    <table class="table" v-if="fProducts.length > 0" id="featuredtable">
                                        <thead>
                                            <tr class="bg-warning">
                                                <th scope="col">#</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(product, index) in fProducts" :kye="index">
                                                <th>{{index+1}}</th>
                                                <td>{{product.category.name}}</td>
                                                <td>{{product.title}}</td>
                                                <td><img :src="'/upload/img/'+product.image" alt="" style="width: 50px; height: 50px"></td>
                                                <td> <button class="btn btn-sm btn-outline-success" @click="addtofeature(product.id)">Add to Featured</button> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
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
                featuredProducts: [],
                featuredPfind: '',
                inSearch: false,
                fProducts: [],
            }
        },

        watch:{
          featuredPfind: function (newQ, oldQ){
              if(newQ === ''){
                this.inSearch = false;
                this.fProducts = [];
              }else{
                this.searchData();
                this.inSearch = true;
              }
          }
        },

        methods:{

            removefeatureP(id){

                Notiflix.Confirm.Show(
                    'Remove Confirm',
                    'Do you want to remove this from featured.',
                    'Yes',
                    'No',
                    function(){
                        axios.delete('/api/admin/shop/setting/featured/remove/'+id)
                        .then(res=>{
                            Notiflix.Notify.Success('Successfully remove from featured.');
                            this.getfeaturedpro();
                        })
                        .catch(e=>{
                            console.log(e);
                        })
                    }.bind(this),
                );
            },

            getfeaturedpro(){
                Notiflix.Block.Dots('div#featured_main', 'Please wait...');
                axios.get('/api/admin/shop/setting/featured/get')
                .then(res=>{
                    this.featuredProducts = res.data;
                    Notiflix.Block.Remove('div#featured_main', 600)
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#featured_main', 600)
                })
            },

            addtofeature(id){
                Notiflix.Block.Dots('table#featuredtable', 'Please wait...');
                axios.post('/api/admin/shop/setting/featured/add/'+id)
                .then(res=>{
                    Notiflix.Notify.Success('Featured product successfully add');
                    this.getfeaturedpro();
                    Notiflix.Block.Remove('table#featuredtable', 600)
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('table#featuredtable', 600)
                })
            },

                // Live Searcy by Categoyr Name
            searchData(){
                axios.get('/api/admin/shop/setting/featured/search/'+this.featuredPfind)
                .then(res=>{
                    this.fProducts = res.data;
                })
                .catch(e=>{
                    console.log(e)
                })
            },
        },

        mounted() {
            this.getfeaturedpro();
        }
    }
</script>

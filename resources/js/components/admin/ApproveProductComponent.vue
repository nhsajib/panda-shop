<template>
<div id="component">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title l_hight17">All Products
                        <form class="form-inline float-right">
                            <label for="searchby" class="ls-title">Live Search:&nbsp;</label>
                            <select class="form-control">
                              <option value="" disabled selected>Search By</option>
                              <option value="id">Product Id</option>
                              <option value="product_name">Product Title</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Query" id="query">
                        </form>
                        </h4>
                    </div>
                    <div class="card-body" id="ptable">

                        <table class="table">
                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Category</th>
                                  <th>Title</th>
                                  <th class="text-center">Image</th>
                                  <th class="text-center">Status</th>
                                  <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- If no draft product -->
                                <tr v-if="products.data.length == 0">
                                    <td colspan="6" class="text-center text-danger">No Product waiting for Approve</td>
                                </tr>
                                <!-- If there is draft product -->
                                <tr v-if="products.data.length !== 0" v-for="(product, index) in products.data" kye="index">
                                    <td> {{index+1}} </td>
                                    <td> {{ product.category.name }} </td>
                                    <td> {{ product.title }} </td>
                                    <td class="align-middle text-center">
                                        <img :src="'/upload/img/'+product.image" class="img-thumbnail" height="50px" width="50px">
                                    </td>
                                    <td class="text-center">
                                        <span v-if="product.status === 0">Draft</span>
                                        <span v-else-if="product.status === 1">Approve</span>
                                    </td>
                                    <td class="align-middle text-center">

                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" @click="preview(product.id)">Preview</button>
                                                <button class="dropdown-item" @click="approve(product.id)">Approve</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getproduct" v-show="!inSearch"></pagination>
                        <!-- <pagination :data="category" @pagination-change-page="searchData" v-show="inSearch"></pagination> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


<!---------------------------
  Modal Section
---------------------------->


<!-- The Product Modal -->
<div class="modal" id="product_preview">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="card bg-light" id="cardbody">

          <div class="card-header card-head-bg text-light">
            Product and description
          </div>
          <div class="card-body" id="pcard-body">
            <div class="row  justify-content-center align-items-center">
                

            </div>
          </div>

          <div class="card-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary float-right">&nbsp; Update &nbsp;</button>
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

                appUrl: process.env.MIX_SENTRY_DSN_PUBLIC,

                products: {},
                inSearch: false,
            }
        },

        methods:{

            preview(id){
                window.open(this.appUrl+'/admin/product/publishpreview/'+id);
            },

            approve(id){
                Notiflix.Block.Dots('div#ptable', 'Please wait...');
                axios.put('/api/admin/product-approve/'+id)
                .then(res=>{
                    this.getproduct();
                    Notiflix.Notify.Success('Product Successfully Approved');
                    Notiflix.Block.Remove('div#ptable', 600);

                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#ptable', 600);
                })
            },







          deletespec(id){
            Notiflix.Block.Dots('div#specdisplay', 'Please wait...');
            axios.delete('/api/admin/product-spec/'+id)
            .then(res=>{
              Notiflix.Notify.Info('Specification Successfully Remove.');
              this.getspec(this.spec.product_id);
              Notiflix.Block.Remove('div#specdisplay', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#specdisplay', 600);
            })
          },



          getproduct(page = 1){
              Notiflix.Block.Dots('div#ptable', 'Please wait...');
              axios.get('/api/admin/product-draft?page=' + page)
              .then(res=>{
                  this.products = res.data;
                  Notiflix.Block.Remove('div#ptable', 600);
              })
              .catch(e=>{
                  console.log(e);
                  Notiflix.Block.Remove('div#ptable', 600);
              })
          }

        },

        mounted() {
            this.getproduct();
        }
    }
</script>

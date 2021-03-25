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
                            <select class="form-control" v-model="column" >
                              <option value="id" selected>Product Id</option>
                              <option value="title">Product Title</option>
                            </select>
                            <input type="text" v-model="query" class="form-control" placeholder="Query" id="query">
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
                                <tr v-if="inSearch">
                                  <td colspan="6" v-show="products.data.length == 0" class="text-center text-danger">No Product Found.</td>
                                </tr>

                                <tr v-for="(product, index) in products.data" kye="index">
                                    <td> {{index+1}} </td>
                                    <td> {{ product.category.name }} </td>
                                    <td> {{ product.title }} </td>
                                    <td class="align-middle text-center">
                                        <img :src="'/upload/img/'+product.image" class="img-thumbnail" height="50px" width="50px">
                                    </td>
                                    <td class="text-center">
                                        <span v-if="product.status === 0">Draft</span>
                                        <span v-else-if="product.status === 1">Approved</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle" data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" @click="editproduct(product)">Edit Product</button>
                                                <button class="dropdown-item" @click="editattribute(product.id)">Edit Attribute</button>
                                                <button class="dropdown-item" @click="editpimg(product.id)">Edit Image</button>
                                                <button class="dropdown-item" @click="editspec(product.id)">Edit Specifications</button>
                                                <button class="dropdown-item" @click="deleteProduct(product)">Delete Product</button>
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
<div class="modal" id="product">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card bg-light" id="cardbody">

          <div class="card-header card-head-bg text-light">
            Edit Product and description
          </div>
          <div class="card-body" id="pcard-body">
            <div class="row  justify-content-center align-items-center">
              <div class="col-md-12">
                <form @submit.prevent="">
                  <div class="form-group">
                    <label for="category">Category <span class="text-danger">*</span></label>
                    <v-select
                      :options="category"
                      label="name"
                      :reduce="name =>name.id"
                      v-model="product.category_id">
                    </v-select>
                    <div id="req-id" class="invalid-feedback">Please select category.</div>
                  </div>
                  <div class="form-group">
                    <label for="title">Product Title <span class="text-danger">*</span></label>
                    <input type="text" v-model="product.title" class="form-control" id="title" placeholder="Product Title" :class="{ 'is-invalid': product.errors.has('title') }" autocomplete="off">
                    <has-error :form="product" field="title"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="product_desc">Product Description <span class="text-danger">*</span></label>
                    <vue-editor v-model="product.description" :editorToolbar="customToolbar" class="form-control" :class="{ 'is-invalid': product.errors.has('description') }"></vue-editor>
                    <has-error :form="product" field="description"></has-error>
                  </div>

                  <div class="form-group">
                    <label for="primary_image">Primary Image <span class="text-danger">*</span></label>
                    <input type="file"  class="form-control" id="primary_image" ref="primaryimage" accept="image/*" v-on:change="PrimaryImageHandler()" :class="{ 'is-invalid': product.errors.has('image') }" autocomplete="off">
                    <has-error :form="product" field="image"></has-error>
                    <div>
                      <img :src="this.product.image" alt="" v-show="primaryImgPrev" class="mt-2" width="180px">
                      <img :src="'/upload/img/'+product.image" alt="" v-show="!primaryImgPrev" class="mt-2" width="180px">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="attr_opt_name">Attribute Option Name<span class="text-danger">*</span></label>
                    <input type="text" v-model="product.attr_opt_name" class="form-control" id="attr_opt_name" placeholder="Product Attribute Option Name" :class="{ 'is-invalid': product.errors.has('attr_opt_name') }" autocomplete="off">
                    <has-error :form="product" field="attr_opt_name"></has-error>
                  </div>

                </form>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary float-right" @click="updateProduct">&nbsp; Update &nbsp;</button>
          </div>

        </div>
    </div>
  </div>
</div>

<!-- The Attribute Modal -->
<div class="modal" id="attribute">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card bg-light" id="attrcardbody">

                    <div class="card-header card-head-bg text-light">
                      Product Attributes
                    </div>

                    <div class="card-body">
                      <div class="row justify-content-center">
                        <div class="col-md-8" id="attrdisplay">
                          <table class="table table-sm table-bordered mb-3">
                            <thead>
                              <tr class="bg-success text-light">
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">SKU</th>
                                <th scope="col">Attr. Option</th>
                                <th scope="col">Price</th>
                                <th scope="col">Discount Price</th>
                                <th scope="col">QTY</th>
                                <th scope="col" class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(attr, index) in productattr" :kye="index">
                                <th class="text-center">{{index+1}}</th>
                                <th>{{attr.sku}}</th>
                                <th>{{attr.attr_opt}}</th>
                                <td>{{attr.price}}</td>
                                <td>{{attr.discount_price}}</td>
                                <td>{{attr.stock}}</td>
                                <td class="text-center"><i @click="removeattr(attr.id)" class="remove fas fa-minus-circle"></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <br>
                      <form @submit.prevent="add_attribute">
                        <div class="form-row border" id="attrform">
                          <div class="form-group col-md-2">
                            <label for="sku">SKU</label>
                            <input type="text" v-model="attribute.sku" class="form-control" id="sku" placeholder="SKU" required autocomplete="off" :class="{ 'is-invalid': attribute.errors.has('sku') }">
                            <has-error :form="attribute" field="sku"></has-error>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="attr_option">Option</label>
                            <input type="text" v-model="attribute.attr_opt" class="form-control" id="attr_option" placeholder="Attribute Option" required autocomplete="off">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" v-model="attribute.price" class="form-control" id="price" placeholder="Price" required autocomplete="off">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="discountprice">Discount Price</label>
                            <input type="number" step="0.01" v-model="attribute.discount_price" class="form-control" id="discountprice" placeholder="Discount Price" autocomplete="off">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="stock">Stock QTY</label>
                            <input type="number" v-model="attribute.stock" class="form-control" id="stock" placeholder="QTY" required autocomplete="off">
                          </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-2">&nbsp; Add &nbsp;</button>
                      </form>
                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                    </div>

        </div>
    </div>
  </div>
</div>

<!-- The Image Modal -->
<div class="modal" id="imagemodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card bg-light" id="imagecardbody">
          

              <div class="card-header card-head-bg text-light">
                Add Product Images
              </div>
          <div id="imagecardwarp">
              <div class="card-body">
                <p class="bg-warning text-center">You can add up to 5 images.</p>
                <div class="row d-flex justify-content-center">
                  <div v-for="img in productImages" :kye="img.id" class="col-md-2 align-self-center m-1">
                    <img :src="'/upload/img/'+img.image_url" class="img-thumbnail pimg" alt="">
                    <button class="btn btn-outline-danger deletebtn" @click="deleteimg(img.id)">
                      <i class="fa fa-trash" aria-hidden="true" title="Delete Image"></i>
                    </button>
                  </div>
                </div>
              </div>
              
              <div class="card-footer">
                <div v-show="productImages.length < 5" class="row justify-content-center" id="addImgform" >
                <div class="col-md-6">
                  <form @submit.prevent="">
                    <div class="form-group">
                      <label for="image_url">Add Image <span class="text-danger">*</span></label>

                      <input type="file"  class="form-control" id="image_url" ref="addPImg" accept="image/*" v-on:change="productImage()" :class="{ 'is-invalid': image.errors.has('image_url') }">
                      <has-error :form="image" field="image_url"></has-error>

                      <div class="mt-1">
                        <img v-show="selectImgPreview" :src="image.image_url" class="img-thumbnail" style="width: 250px" alt=""/>
                      </div>
                      <button type="submit" class="btn btn-success float-left mt-2" @click="addImage">&nbsp; Add &nbsp;</button>
                    </div>
                  </form>
                </div>
                </div>
              </div>
          </div>
            <div class="card-footer border-top">
              <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- The Specifications Modal -->
<div class="modal" id="specmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="card bg-light">

                    <div class="card-header card-head-bg text-light">
                      Product Specification
                    </div>

                    <div class="card-body" id="speccardbody">
                      <div class="row justify-content-center" id="specdisplay">
                        <div class="col-md-8">
                          <p class="bg-secondary py-1 text-center text-light mb-0">Specification</p>
                          <table class="table table-sm table-bordered mb-3">
                            <thead>
                              <tr class="bg-success text-light">
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">Specification Name</th>
                                <th scope="col">Specification Details</th>
                                <th scope="col" class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(spec, index) in productspec" :kye="index">
                                <th class="text-center">{{index+1}}</th>
                                <th> {{ spec.spec_name }} </th>
                                <td> {{ spec.spec_details }} </td>
                                <td class="text-center"><i @click="deletespec(spec.id)" class="remove fas fa-minus-circle"></i></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <br>
                      <form @submit.prevent="addspec">
                        <div class="form-row justify-content-center" id="specform">
                          <div class="form-group col-md-3">
                            <label for="spec_name">Specification Name</label>
                            <input type="text" v-model="spec.spec_name" class="form-control" id="spec_name" placeholder="Name" required autocomplete="off">
                          </div>
                          <div class="form-group col-md-5">
                            <label for="spec_details">Specification Details</label>
                            <input type="text" v-model="spec.spec_details" class="form-control" id="spec_details" placeholder="Details" required autocomplete="off">
                          </div>
                          <div class="form-group col-md-1">
                            <label></label>
                            <button type="submit" class="btn btn-success mt-2" @click="">&nbsp; Add &nbsp; </button>
                          </div>
                        </div>
                      </form>
                    </div>
                    
                    <div class="card-footer">
                      <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                    </div>
        </div>
    </div>
  </div>
</div>

</div>
</template>

<script>
  import { VueEditor } from "vue2-editor";
    export default {
        data(){
            return{
                products: {},

                //Search field
                column: 'id',
                query: '',
                inSearch: false,

                // Product and Description
                product: new Form({
                    id: '',
                    category_id: '',
                    title: '',
                    description: '',
                    image: null,
                    attr_opt_name: '',
                }),
                primaryImgPrev: false,
                category: [],

                //Product Attribute
                attribute: new Form({
                  product_id: '',
                  sku: '',
                  attr_opt: '',
                  price: '',
                  discount_price: '',
                  stock: '',
                }),
                productattr: [],

                // Product Image
                image: new Form({
                  product_id: '',
                  image_url: null,
                }),
                selectImgPreview: false,
                productImages: [],

                //Product Specification
                spec: new Form({
                  product_id: '',
                  spec_name: '',
                  spec_details: '',
                }),
                productspec: [],

              customToolbar:  [
                              [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                              ["bold", "italic", "underline"],
                              [{ 'color': [] }, { 'background': [] }],
                              [{ list: "ordered" }, { list: "bullet" }],
                              [{ 'direction': 'rtl' }, "code-block"],
                              ['clean']
                              ],
            }
        },

        watch: {
          query: function (newQ, oldQ){
              if(newQ === ''){
                this.inSearch = false;
                this.getproduct();
              }else{
                this.searchproduct();
                this.inSearch = true;
              }
          }
        },

        methods:{

          //Search product
          searchproduct(){
            Notiflix.Block.Dots('div#ptable', 'Please wait...');
            axios.get('/api/admin/product/search/'+this.column+'-'+this.query)
            .then(res=>{
              this.products = res.data;
              Notiflix.Block.Remove('div#ptable', 600);
            })
            .catch(e=>{
                console.log(e);
                Notiflix.Block.Remove('div#ptable', 600);
            })
          },

          // Delete Product
          deleteProduct(product){
            Notiflix.Confirm.Show(
                'Delete Product',
                'Do you want to delete '+product.title+' product?',
                'Yes',
                'No',
                function(){
                  axios.delete('/api/admin/product/'+product.id)
                  .then(res=>{
                    Notiflix.Notify.Info('Product and all info Successfully Deleted.');
                    this.getproduct();
                  })
                  .catch(e=>{
                    console.log(e);
                  })
                }.bind(this),
            );
          },

          // Product Specification
          editspec(productId){
            this.spec.product_id = productId;
            this.getspec(productId);
            $('#specmodal').modal('show');
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

          getspec(productid){
            Notiflix.Block.Dots('div#speccardbody', 'Please wait...');
            axios.get('/api/admin/product-spec/'+productid)
            .then(res=>{
              this.productspec = res.data.data;
              Notiflix.Block.Remove('div#speccardbody', 600);
            })
            .catch(e=>{
              console.log(e)
              Notiflix.Block.Remove('div#speccardbody', 600);
            })
          },

          addspec(){
            Notiflix.Block.Dots('div#specform', 'Please wait...');
            this.spec.post('/api/admin/product-spec')
            .then(res=>{
              Notiflix.Notify.Success('Specification Successfully Added');
              Notiflix.Block.Remove('div#specform', 600);
              this.spec.spec_name = '';
              this.spec.spec_details = '';
              this.getspec(this.spec.product_id);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#specform', 600);
            })
          }, 

          // Product Image
          editpimg(productId){
            this.image.product_id = productId;
            this.image.image_url = null;
            this.getproductImage(productId);
            $('#imagemodal').modal('show');
          },

          deleteimg(id){
            axios.delete('/api/admin/product-image/'+id)
            .then(res=>{
              Notiflix.Notify.Info('Image Successfully Remove.');
              this.getproductImage(this.image.product_id);
            })
          },
          addImage(){
            Notiflix.Block.Dots('div#addImgform', 'Please wait...');

            this.image.post('/api/admin/product-image')
            .then(res=>{
                Notiflix.Notify.Success('Product Image Successfully Added');
                Notiflix.Block.Remove('div#addImgform', 600);
                this.getproductImage(this.image.product_id);
                this.image.image_url = null;
                this.selectImgPreview = false;
            })
            .catch(e=>{
              Notiflix.Block.Remove('div#addImgform', 600);
              console.log(e)
            })
          },

          productImage(){
                let selectImg = this.$refs.addPImg.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.image.image_url = reader.result;
                            this.selectImgPreview = true;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.image.image_url = null;
                        this.selectImgPreview = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.image.image_url = null;
                        this.selectImgPreview = false;
                    }
                }
          },

          getproductImage(productId){
            Notiflix.Block.Dots('div#imagecardwarp', 'Please wait...');
            axios.get('/api/admin/product-image/'+productId)
            .then(res=>{
              this.productImages = res.data.data;
              Notiflix.Block.Remove('div#imagecardwarp', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#imagecardwarp', 600);
            })
          },


          // Product Attribute
          add_attribute(){
            Notiflix.Block.Dots('div#attrform', 'Please wait...');
            this.attribute.post('/api/admin/product-attr')
            .then(res=>{
              Notiflix.Notify.Success('Specification Successfully Added');
              this.getattr(this.attribute.product_id);
              this.attribute.sku = '';
              this.attribute.attr_opt = '';
              this.attribute.price = '';
              this.attribute.discount_price = '';
              this.attribute.stock = '';
              Notiflix.Block.Remove('div#attrform', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#attrform', 600);
            })
          },

          removeattr(id){
            Notiflix.Block.Dots('div#attrcardbody', 'Please wait...');
            axios.delete('/api/admin/product-attr/'+id)
            .then(res=>{
              Notiflix.Notify.Info('Attribute Successfully Remove.');
              this.getattr(this.attribute.product_id);
              Notiflix.Block.Remove('div#attrcardbody', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#attrcardbody', 600);
            })
          },

          editattribute(productid){
            this.attribute.product_id = productid;
            this.getattr(productid);
            $('#attribute').modal('show');
          }, 

          getattr(prodcutId){
            Notiflix.Block.Dots('div#attrcardbody', 'Please wait...');
            axios.get('/api/admin/product-attr/'+prodcutId)
            .then(res=>{
              this.productattr = res.data.data;
              Notiflix.Block.Remove('div#attrcardbody', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#attrcardbody', 600);
            })
          },


          updateProduct(){
            this.product.put('/api/admin/product/'+this.product.id)
            .then(res=>{
              Notiflix.Notify.Success('Product & Description Succrssfully Updated.');
              this.getproduct();
            })
            .catch(e=>console.log(e))
          },

          editproduct(product){
            this.product.fill(product);
            this.primaryImgPrev = false;
            $('#product').modal('show');
          },

        // Handel Product and Description Image 
          PrimaryImageHandler(){
              let selectImg = this.$refs.primaryimage.files[0];
              let reader = new FileReader();
              if(selectImg){
                  if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                      reader.readAsDataURL(selectImg);
                      reader.addEventListener("load", function(){
                          this.product.image = reader.result;
                          this.primaryImgPrev = true;
                      }.bind(this), false);
                  }
                  if(selectImg['size'] > 500000){
                      Notiflix.Notify.Failure('Image size must be less than 500kb');
                      this.product.image = null;
                      this.primaryImgPrev = false;
                  }
                  if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                      Notiflix.Notify.Failure('File must be an image');
                      this.product.image = null;
                      this.primaryImgPrev = false;
                  }
              }
          },

          // Get Category data
          getCategory(){
              axios.get('/api/admin/category-all')
              .then(res=>{
                  this.category = res.data.data;
              })
              .catch(e=>console.log(e))
          },

          getproduct(page = 1){
              Notiflix.Block.Dots('div#ptable', 'Please wait...');
              axios.get('/api/admin/product?page=' + page)
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
            this.getCategory();
        }
    }
</script>

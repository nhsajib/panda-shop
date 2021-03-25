<template>
<div id="component">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title l_hight17">Shipping Orders
                        <form class="form-inline float-right">
                            <label for="searchby" class="ls-title">Order No :&nbsp;</label>
                            <input type="text" class="form-control" placeholder="Order No" id="query" v-model="orderNo">
                        </form>
                        </h4>
                    </div>

                    <div class="card-body" id="ordercard">

                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                  <th>#</th>
                                  <th>Order No</th>
                                  <th>Payment Status</th>
                                  <th>Order Status</th>
                                  <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody v-if="inSearch">
                                <tr v-if="findorders.length != 0" class="text-center align-middle">
                                    <td> {{1}} </td>
                                    <td> {{ findorders.id }} </td>
                                    <td> {{ findorders.payment_status }} </td>
                                    <td> {{findorders.order_status}} </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-toggle="dropdown">
                                                Options
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item btn-sm" @click="invoice(findorders.id)">Invoice</button>
                                                <button class="dropdown-item btn-sm" @click="moveshipping(findorders.id)">Complete order</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else class="text-center align-middle">
                                  <td colspan="5" class="text-danger">No order found</td>
                                </tr>
                            </tbody>

                            <tbody v-if="!inSearch">
                                <tr v-for="(order, index) in shiporders.data" kye="index" class="text-center align-middle">
                                    <td> {{index+1}} </td>
                                    <td> {{ order.id }} </td>
                                    <td> {{ order.payment_status }} </td>
                                    <td> {{order.order_status}} </td>
                                    <td>
                                      <button class="btn btn-sm btn-outline-success" @click="complete(order)">Complete order</button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>


                    <div class="card-footer">
                        <pagination :data="shiporders" @pagination-change-page="getshiporders" v-show="!inSearch"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!---------------------------
  Modal Section
---------------------------->

<!-- The Specifications Modal -->
<div class="modal" id="completeorder">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="card bg-light">
            <div class="card-header card-head-bg text-light">
              Complete Order
            </div>
            <div class="card-body" id="ship_omb">
              <div class="row justify-content-center" id="specdisplay">
                <div class="col-md-12">
                  <p class="bg-secondary py-1 text-center text-light mb-0">Order Info</p>
                  <table class="table table-sm table-bordered mb-3">
                    <thead>
                      <tr class="bg-success text-light text-center">
                        <th scope="col">Order No</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Payment</th>
                        <th scope="col" class="bg-danger">Due</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="text-center">
                        <td><input type="number" class="form-control text-center" v-model="order.id" disabled></td>
                        <td><input type="number" class="form-control text-center" v-model="order.amount" disabled></td>
                        <td><input type="text" class="form-control text-center" v-model="order.payment_amount" disabled></td>
                        <td><input type="text" class="form-control text-center" v-model="order.due_amount" disabled></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div id="cash_error" class="alert alert-danger d-none">
                <strong>Error!</strong> Due and cash amount must be equal.
              </div>
                <div class="row justify-content-center" id="specform">
                  <form @submit.prevent>
                    <div class="form-group">
                      <label for="cash">Cash Receive</label>
                      <input type="number" class="form-control" id="cash" v-model="order.cahs_amount">
                    </div>
                  </form>
                </div>
            </div>
            
            <div class="card-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success float-right" @click="complete_order">Complete Order</button>
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
                shiporders: {},
                findorders: "",

                //Search Data
                orderNo: "",
                inSearch: false,

                order: new Form({
                  id: '',
                  amount: '',
                  payment_amount: '',
                  due_amount: '',
                  cahs_amount: '',
                })
            }
        },

        watch: {
          orderNo: function (newQ, oldQ){
              if(newQ === ''){
                this.inSearch = false;
                this.getshiporders();
              }else{
                this.searchByOrder();
                this.inSearch = true;
              }
          }
        },

        methods:{
          complete_order(){
            if(parseInt(this.order.due_amount) == parseInt(this.order.cahs_amount)){
              Notiflix.Block.Dots('div#ship_omb', 'Please wait...');
              this.order.post('/api/admin/order-complete')
              .then(res=>{
                this.getshiporders();
                Notiflix.Notify.Success('Order successfully completed.');
                Notiflix.Block.Remove('div#ship_omb', 600);
              })
              .catch(e=>{
                console.log(e);
                Notiflix.Block.Remove('div#ship_omb', 600);
              })
            }else{
              $('#cash_error').removeClass(' d-none');
            }
          },

          complete(order){

            this.order.id = order.id;
            this.order.payment_amount = parseInt(order.payment_amount);

            // Total Amount = Shopping Amount + Shipping Charge
            var total_amount = parseInt(order.amount) + parseInt(order.shipping_charge);
            this.order.amount = total_amount;

            // Due Amount = Total Amount - Payment Amount
            var due_amount = total_amount - order.payment_amount;
            this.order.due_amount = due_amount;

            $('#completeorder').modal('show');
          },

          searchByOrder(){
            Notiflix.Block.Dots('div#ordercard', 'Please wait...');
            axios.get('/api/admin/order-inship/search/'+this.orderNo)
            .then(res=>{
              this.findorders = res.data.data;
              Notiflix.Block.Remove('div#ordercard', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#ordercard', 600);
            })
          },

          getshiporders(page = 1){
            Notiflix.Block.Dots('div#ordercard', 'Please wait...');
            axios.get('/api/admin/order-inshipping?page=' + page)
            .then(res=>{
              this.shiporders = res.data;
              Notiflix.Block.Remove('div#ordercard', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#ordercard', 600);
            })
          }
        },

        mounted() {
            this.getshiporders();
        }
    }
</script>

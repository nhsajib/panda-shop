<template>
<div id="component">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title l_hight17">New Orders
                        <form class="form-inline float-right">
                            <label for="searchby" class="ls-title">Order No :&nbsp;</label>
                            <input type="text" class="form-control" placeholder="Order No" id="query" v-model="orderNo">
                        </form>
                        </h4>
                    </div>

                    <div class="card-body" id="ordercard">

                        <table class="table">
                            <thead>
                                <tr class="text-center align-middle">
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
                                                <button class="dropdown-item btn-sm" @click="moveshipping(findorders.id)">Move to shipping</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else class="text-center align-middle">
                                  <td colspan="5" class="text-danger">No order found</td>
                                </tr>
                            </tbody>

                            <tbody v-if="!inSearch">
                                <tr v-for="(order, index) in orders.data" kye="index" class="text-center align-middle">
                                    <td> {{index+1}} </td>
                                    <td> {{ order.id }} </td>
                                    <td> {{ order.payment_status }} </td>
                                    <td> {{order.order_status}} </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-outline-success dropdown-toggle" data-toggle="dropdown">
                                                Options
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item btn-sm" @click="invoice(order.id)">Invoice</button>
                                                <button class="dropdown-item btn-sm" @click="moveshipping(order.id)">Move to shipping</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>


                    <div class="card-footer">
                        <pagination :data="orders" @pagination-change-page="getorders" v-show="!inSearch"></pagination>
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
                orders: {},
                findorders: "",

                //Search Data
                orderNo: "",
                inSearch: false,
            }
        },

        watch: {
          orderNo: function (newQ, oldQ){
              if(newQ === ''){
                this.inSearch = false;
                this.getorders();
              }else{
                this.searchByOrder();
                this.inSearch = true;
                // console.log(oldQ)
              }
          }
        },

        methods:{

          searchByOrder(){
            Notiflix.Block.Dots('div#ordercard', 'Please wait...');
            axios.get('/api/admin/order-search/'+this.orderNo)
            .then(res=>{
              this.findorders = res.data.data;
              Notiflix.Block.Remove('div#ordercard', 600);
            })
            .catch(e=>{
              console.log(e)
              Notiflix.Block.Remove('div#ordercard', 600);
            })
          },

          moveshipping(id){
            Notiflix.Block.Dots('div#ordercard', 'Please wait...');
            axios.put('/api/admin/order-shipping/'+id)
            .then(res=>{
              Notiflix.Notify.Success('Order successfully move to shipping.');
              Notiflix.Block.Remove('div#ordercard', 600);
              this.getorders();
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#ordercard', 600);
            })
          },

          invoice(id){
            axios.get('/api/admin/order-invoice/'+id)
          },

          getorders(page = 1){
            Notiflix.Block.Dots('div#ordercard', 'Please wait...');
            axios.get('/api/admin/order?page=' + page)
            .then(res=>{
              this.orders = res.data;
              Notiflix.Block.Remove('div#ordercard', 600);
            })
            .catch(e=>{
              console.log(e);
              Notiflix.Block.Remove('div#ordercard', 600);
            })
          }
        },

        mounted() {
            this.getorders();
        }
    }
</script>

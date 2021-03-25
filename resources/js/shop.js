// Notifix modules
import Notiflix from "notiflix";
window.Notiflix = Notiflix;


try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}


$(document).ready(function(){

    //GET Laravel CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //On Change Attribute Change Price
    $('#attrselect').change(function(){
        var attrid = $(this).val();

        $.get("/shop/attrbyid/"+attrid, function(data, status){
            // console.log(data);
            $('#product__sku').html('SKU: '+data.sku);
            $("#cartqty").attr({"max" : data.stock});
            if((data.discount_price === null) || (data.discount_price === 0)){
                $('#product__price').html('<span class="product__price-new">&#2547;'+data.price+'</span>');
            }else{
                $('#product__price').html('<span class="product__price-new">&#2547;'+data.discount_price+'</span> <span class="product__price-old">&#2547;'+data.price+'</span>');
            }
        });
    });


    //Cart QTY Update including total price
    $('#addcart').click(function(){
        var attributeid = $('#attrselect').val();
        var itemqty = $('#cartqty').val();
        var attr_name = $('#attr_name').html();
        var product_id = $('#product_id').val();

        if(attributeid == null){
            Notiflix.Notify.Info('Please Select '+attr_name);
            $('#attrselect').focus();
            $('#attrselect').addClass("erorfocus");
        }
        else{

            Notiflix.Block.Dots('button#addcart');
            $.post("/shop/cart", {attr_id: attributeid, qty: itemqty, product_id: product_id})
            .done(function(status){
                Notiflix.Notify.Success('Product successfully added to your cart.');
                Notiflix.Block.Remove('button#addcart');
                
                //Update Cart Item QTY in Cart Logo
                var plusitem = parseInt($("#totalitem").html());
                    plusitem += +itemqty;
                $('#totalitem').html(plusitem);
            })
            .fail(function(xhr, status, errors) {
                Notiflix.Notify.Failure(xhr.responseJSON.errors.attr_id[0]);
                Notiflix.Block.Remove('button#addcart');
            });
        }

    });

    // Cart total and subtoal price update by jquery
    $('.cartitemqty').each(function(){
        var pitemqty = $(this).val();
        var itemprice = $(this).attr('data-item-price');
        var attrId = $(this).attr('data-attr-id');
        var itmeQtyprice = pitemqty*itemprice;
        $('#total'+attrId).html(itmeQtyprice+'.00');

        //On Change Cart Item QTY update cart Subtotal amount
        var sum = 0;
        $('.itemtotal').each(function(){
            sum += parseFloat($(this).html());
        });
        $('#carttotalprice').html(+sum+'.00');

    });

    // On Select Shipping add shipping Changer in total amount
    $('#shipping').change(function(){
        var shippingCharge = parseFloat($(this).val());
        var totalShopping = parseFloat($('#carttotalprice').html());
        var total = shippingCharge+totalShopping;
        
        $('#nettotal').html(total+'.00');
    });

    // RateYo Plugin for Rate by Stars
    $(function () {
      $("#rateYo").rateYo({
        starWidth: "25px",
        spacing   : "5px",
        halfStar: true
      });

      var $rateYo = $("#rateYo").rateYo();
      $("#rateYo").click(function () {
        /* get rating */
        var rating = $rateYo.rateYo("rating");
        $('#rattingview').html(rating);
        $('#rattingval').val(rating);
      });     
    });


});
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

//Import v-from
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// Vue Select
import 'vue-select/dist/vue-select.css';
import vSelect from 'vue-select';
Vue.component('v-select', vSelect)

// Notifix modules
import Notiflix from "notiflix";
window.Notiflix = Notiflix;

// Laravel Vue Pagination
Vue.component('pagination', require('laravel-vue-pagination'));




// Admin component
Vue.component('dashboard-component', require('./components/admin/DashboardComponent.vue').default);
Vue.component('top-category-component', require('./components/admin/TopCategoryComponent.vue').default);
Vue.component('category-component', require('./components/admin/CategoryComponent.vue').default);
Vue.component('addproduct-component', require('./components/admin/AddProductComponent.vue').default);
Vue.component('viewallproduct-component', require('./components/admin/ViewAllProductComponent.vue').default);
Vue.component('shipping-component', require('./components/admin/ShippingComponent.vue').default);
Vue.component('approve-product-component', require('./components/admin/ApproveProductComponent.vue').default);
Vue.component('orders-component', require('./components/admin/OrdersComponent.vue').default);
Vue.component('orders-shipping', require('./components/admin/OrderShippingComponent.vue').default);
Vue.component('orders-complete', require('./components/admin/CompleteOrdersComponent.vue').default);
Vue.component('hero-slider-setting', require('./components/admin/HeroSliderSettingComponent.vue').default);
Vue.component('feature-products', require('./components/admin/FeaturedProductsComponent.vue').default);
Vue.component('latest-collection', require('./components/admin/LatestCollectionsComponent.vue').default);
Vue.component('general-info', require('./components/admin/GeneralinfoSettingComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('global-alert', require('./components/GlobalAlert.vue'));
Vue.component('confirm', require('./components/ConfirmComponent.vue'));

Vue.component('menu-tabs', require('./components/menu/MenuTabsComponent.vue'));
Vue.component('menu-tree', require('./components/menu/MenuTreeComponent.vue'));

Vue.component('snippet-visible', require('./components/snippet/SnippetVisibleComponent.vue'));
Vue.component('select-status', require('./components/SelectStatusComponent.vue'));

Vue.component('modal', require('./components/ModalComponent.vue'));

$.each(window.itmasterModule, function (index, value) {
    require('./../vendor/' + index +'/js/app')
});

const app = new Vue({
    el: '#app'
});

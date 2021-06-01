/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
require('vuedraggable');
import PageDocumentsComponent from './components/PageDocumentsComponent.vue'
import PageAddDocumentsComponent from './components/PageAddDocumentsComponent.vue'
import PageTabsComponent from './components/PageTabsComponent.vue'
import PagePartnersComponent from './components/PagePartnersComponent.vue'
import StaticPageReorderComponent from './components/StaticPageReorderComponent.vue'
import ExtReportsComponent from './components/ExtReportsComponent.vue'
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


window.onload = function () {
    const app_1 = new Vue({
        el: '#app_1',
        template: '<page-add-documents-component/>',
        components: { PageAddDocumentsComponent },
    });
    const partner_v = new Vue({
        el: '#partners_v',
        template: '<page-partners-component/>',
        components: { PagePartnersComponent },
    });
    const ext_report = new Vue({
        el: '#ext_report',
        template: '<ext-reports-component/>',
        components: { ExtReportsComponent },
    });
    const tabs_c = new Vue({
        el: '#tabs_c',
        template: '<page-tabs-component/>',
        components: { PageTabsComponent },
    });
    const app = new Vue({
        el: '#app',
        template: '<page-documents-component/>',
        components: { PageDocumentsComponent },
    });
    const reor = new Vue({
        el: '#reor',
        template: '<static-page-reorder-component/>',
        components: { StaticPageReorderComponent },
    });
};

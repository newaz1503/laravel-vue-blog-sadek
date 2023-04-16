
require('./bootstrap');

window.Vue = require('vue').default;

require('./Helpers/admin/filter')
//mixin
import mixin from './Helpers/admin/mixin'
Vue.mixin(mixin)
//moment
import moment from 'moment';
moment().format();
//flash message
import VueFlashMessage from '@smartweb/vue-flash-message';

Vue.use(VueFlashMessage);
// vform
import Form from 'vform';
window.Form = Form;
import {
    HasError,
    AlertError,
  } from 'vform/src/components/bootstrap5'
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// snotify
import Snotify, { SnotifyPosition } from 'vue-snotify'

const SnotifyOptions = {
  toast: {
    position: SnotifyPosition.rightTop
  }
}
Vue.use(Snotify, SnotifyOptions)
import 'vue-snotify/styles/material.css';

import ViewUI from 'view-design';
  import 'view-design/dist/styles/iview.css';
  Vue.use(ViewUI);
// vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import routes from './router/login'
const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
  })
// vue-x
import store from './store'

Vue.component('login-app', require('./components/LoginApp.vue').default);


const app = new Vue({
    el: '#loginApp',
    router,
    store
});

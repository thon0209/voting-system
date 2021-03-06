/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("votes", require("./components/votes.vue").default);
Vue.component("position", require("./components/admin/position.vue").default);
Vue.component("party", require("./components/admin/partylist.vue").default);
Vue.component("election", require("./components/admin/election.vue").default);
Vue.component("candidate", require("./components/admin/candidate.vue").default);
Vue.component("users", require("./components/admin/users.vue").default);
Vue.component("results", require("./components/admin/results.vue").default);
Vue.component("vote-log", require("./components/admin/vote-log.vue").default);

import VueProgressBar from "vue-progressbar";

Vue.use(VueProgressBar, {
    color: "rgb(255,0,0)",
    failedColor: "red",
    height: "2px"
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});

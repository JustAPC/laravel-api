window.Vue = require("vue");

import Vue from "vue";
import App from "./components/App.vue";

Vue.component("App", require("./components/App.vue").default);

const root = new Vue({
    el: "#root",
    render: (h) => h(App),
});

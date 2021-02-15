require("./bootstrap");

import Vue from "vue";
import vuetify from "./vuetify";

import App from "./App.vue";

new Vue({
    el: "#app",
    vuetify,
    components: {
        App,
    },
    // render: (h) => h(App),
});

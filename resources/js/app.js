require("./bootstrap");

import Vue from "vue";
import vuetify from "./vuetify";

import App from "./App.vue";
import Person from "./components/person/Person";

new Vue({
    el: "#app",
    vuetify,
    components: {
        App,
        Person,
    },
    // render: (h) => h(App),
});

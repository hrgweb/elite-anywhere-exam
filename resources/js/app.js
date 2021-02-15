require("./bootstrap");

import Vue from "vue";
import vuetify from "./vuetify";

import App from "./App.vue";
import Person from "./components/person/Person";
import Organization from "./components/organization/Organization";

new Vue({
    el: "#app",
    vuetify,
    components: {
        App,
        Person,
        Organization,
    },
    // render: (h) => h(App),
});

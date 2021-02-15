<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app>
      <v-navigation-drawer permanent>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="title"> {{ appName }} </v-list-item-title>
          </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            @click="onSidebarLink"
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <slot></slot>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    appName: "Elite Anywhere",

    drawer: null,

    items: [
      { title: "Dashboard", icon: "mdi-view-dashboard", url: "/" },
      { title: "Person", icon: "mdi-account", url: "/person" },
      { title: "Organization", icon: "mdi-domain", url: "/organization" },
    ],
    right: null,
  }),

  methods: {
    onSidebarLink(e) {
      let url = "/";

      switch (e.target.textContent.toLowerCase()) {
        case "person":
          url = "/person";
          break;

        case "organization":
          url = "/organization";
          break;

        default:
          url = "/";
          break;
      }

      location.href = url;
    },
  },
};
</script>

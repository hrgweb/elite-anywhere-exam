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
          <v-list-item v-for="item in items" :key="item.title" link>
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
      <v-container>
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
      { title: "Dashboard", icon: "mdi-view-dashboard" },
      { title: "Person", icon: "mdi-image", url: "/user" },
      { title: "Organization", icon: "mdi-help-box", url: "/organization" },
    ],
    right: null,
  }),
};
</script>

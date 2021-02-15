
<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app>
      <!--  -->
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-icon>mdi-access-point</v-icon>

        <v-icon large color="green darken-2"> mdi-domain </v-icon>

        <v-icon large color="blue darken-2"> mdi-message-text </v-icon>

        <v-icon large color="purple darken-2"> mdi-dialpad </v-icon>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({ drawer: null }),
};
</script>

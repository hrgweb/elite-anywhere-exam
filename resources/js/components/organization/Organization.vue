<template>
  <div class="organization">
    <v-data-table
      :headers="headers"
      :items="organizations"
      sort-by="calories"
      class="elevation-1"
      hide-default-footer
      @click:row="onClickRow"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                New Item
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <!-- NEW organization / EDIT organization -->
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.name"
                        label="Name"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.email"
                        label="Email"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <!-- ACTIONS - SAVE | CANCEL -->
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">
                  Cancel
                </v-btn>
                <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <!-- DELETE -->
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >Are you sure you want to delete this item?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancel</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >OK</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <!-- ACTIONS - EDIT | PENCIL -->
      <template v-slot:item.actions="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
    </v-data-table>

    <!-- NOTIFICAITON MESSAGE -->
    <v-snackbar v-model="snackbar">
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>

    <!-- DIALOG - PERSON BELONGS TO MANY ORGANIZATIONS -->
    <v-dialog v-model="personDialog" width="500">
      <v-card>
        <v-card-title class="headline primary white--text">
          Organization
        </v-card-title>

        <v-card-text class="py-6 d-flex flex-column align-center">
          <v-avatar color="primary" size="62">
            <v-icon color="white">mdi-account</v-icon>
          </v-avatar>

          <span class="subtitle-1">{{
            selectedItem.name ? selectedItem.name.toUpperCase() : ""
          }}</span>
        </v-card-text>

        <v-card-text class="py-6 d-flex flex-column align-center">
          <h3>PERSONS</h3>

          <div class="person-chips" v-if="persons.length">
            <v-chip
              class="ma-2"
              color="green"
              text-color="white"
              v-for="(person, index) in persons"
              :key="index"
            >
              {{ person.name ? person.name.toUpperCase() : "" }}
            </v-chip>
          </div>

          <div class="person-empty" v-else>
            <span class="caption text-center">No persons connected.</span>
          </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="personDialog = false">
            Close</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    personDialog: false,
    dialogDelete: false,
    headers: [
      { text: "Organization", value: "name" },
      { text: "Email", value: "email" },
      { text: "Registered", value: "created_at" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    organizations: [],
    persons: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      email: "",
    },
    defaultItem: {
      name: "",
      email: "",
    },
    selectedItem: {},

    // notification
    snackbar: false,
    text: ``,
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New organization" : "Edit organization";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.fetch();
  },

  methods: {
    fetch() {
      axios
        .get("/organization/list")
        .then(({ data }) => (this.organizations = data));
    },

    editItem(item) {
      this.editedIndex = this.organizations.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.organizations.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      axios
        .delete(`/organization/${this.editedItem.id}`, {
          data: this.editedItem,
        })
        .then(({ data }) => {
          if (data) {
            this.organizations.splice(this.editedIndex, 1);
            this.snackbar = true;
            this.text = "1 organization removed!";
            this.closeDelete();
          }
        });
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      const data = this.editedItem;

      //   NEW organization
      if (this.editedIndex === -1) {
        axios.post("/organization", data).then(({ data }) => {
          if (data) {
            this.fetch();
            this.snackbar = true;
            this.text = "1 organization saved!";
            this.close();
          }
        });

        return;
      }

      // EDIT organization
      axios
        .patch(`/organization/${this.editedItem.id}`, { data: data })
        .then(({ data }) => {
          if (data) {
            this.fetch();
            this.snackbar = true;
            this.text = "1 organization updated!";
            this.close();
          }
        });
    },

    onClickRow(item) {
      this.selectedItem = item;
      this.personDialog = true;
      this.persons = [];

      axios
        .get(`/organization/${this.selectedItem.id}/person/list`)
        .then(({ data }) => (this.persons = data));
    },
  },
};
</script>

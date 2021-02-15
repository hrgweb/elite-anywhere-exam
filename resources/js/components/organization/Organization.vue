<template>
  <div class="organization">
    <v-data-table
      :headers="headers"
      :items="organizations"
      sort-by="calories"
      class="elevation-1"
      hide-default-footer
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
  </div>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      { text: "Organization", value: "name" },
      { text: "Email", value: "email" },
      { text: "Registered", value: "created_at" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    organizations: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      email: "",
    },
    defaultItem: {
      name: "",
      email: "",
    },

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
  },
};
</script>

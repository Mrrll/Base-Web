<template>
  <v-card class="overflow-hidden" color="grey darken-3" dark>
    <v-toolbar flat color="grey darken-4">
      <v-icon>mdi-account</v-icon>
      <v-toolbar-title class="font-weight-light">
        User Profile
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn color="grey darken-4" fab small @click="isEditing = !isEditing">
        <v-icon v-if="isEditing">
          mdi-close
        </v-icon>
        <v-icon v-else>
          mdi-pencil
        </v-icon>
      </v-btn>
    </v-toolbar>
    <div class="text-center">
      <v-avatar class="m-2" size="128">
        <v-img :src="avatarPreview"></v-img>
      </v-avatar>
    </div>
    <v-card-text>
      <v-file-input
        :disabled="!isEditing"
        v-model="files"
        color="green accent-3"
        counter
        label="File input"
        placeholder="Select your files"
        prepend-icon="mdi-paperclip"
        outlined
        :show-size="1000"
        @change="changeFile"
      >
        <template v-slot:selection="{ index, text }">
          <v-chip v-if="index < 2" color="grey darken-4" dark label small>
            {{ text }}
          </v-chip>

          <span
            v-else-if="index === 2"
            class="text-overline grey--text text--darken-3 mx-2"
          >
            +{{ files.length - 2 }} File(s)
          </span>
        </template>
      </v-file-input>
      <v-text-field
        :disabled="!isEditing"
        color="white"
        label="Name"
      ></v-text-field>
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn :disabled="!isEditing" color="success" @click="save">
        Save
      </v-btn>
    </v-card-actions>
    <v-snackbar v-model="hasSaved" :timeout="2000" absolute bottom left>
      Your profile has been updated
    </v-snackbar>
  </v-card>
</template>
<script>
export default {
  data() {
    return {
      files: [],
      avatarPreview : "Img/perfil-avatar.jpg",
      hasSaved: false,
      isEditing: null,
      model: null
    }
  },

  methods: {
    customFilter(item, queryText, itemText) {
      const textOne = item.name.toLowerCase()
      const textTwo = item.abbr.toLowerCase()
      const searchText = queryText.toLowerCase()
      return (
        textOne.indexOf(searchText) > -1 || textTwo.indexOf(searchText) > -1
      )
    },
    save() {
      this.isEditing = !this.isEditing
      this.hasSaved = true
    },
    changeFile(event) {
      if (event) {
        let reader = new FileReader()
        reader.readAsDataURL(event)
        reader.onload = (e) => {
          this.avatarPreview = e.target.result
        }
      }
    },
  },
}
</script>

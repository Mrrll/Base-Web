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
    <v-form
      @submit.prevent="save"
      v-model="valid"
      enctype="multipart/form-data"
    >
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
        <v-row>
          <v-col cols="6">
            <v-text-field
              :disabled="!isEditing"
              v-model="firstname"
              color="white"
              label="Firstname"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              :disabled="!isEditing"
              v-model="lastname"
              color="white"
              label="Lastname"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="4">
            <v-text-field
              :disabled="!isEditing"
              v-model="dni"
              color="white"
              label="Dni"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              :disabled="!isEditing"
              v-model="phone"
              color="white"
              label="Phone"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              :disabled="!isEditing"
              v-model="mobile"
              color="white"
              label="Mobile"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">
            <v-select :disabled="!isEditing" :items="gender" label="Gender" outlined></v-select>
          </v-col>
          <v-col cols="6">
            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  :disabled="!isEditing"
                  v-model="date"
                  label="Birthday date"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="date"
                :active-picker.sync="activePicker"
                :max="
                  new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                    .toISOString()
                    .substr(0, 10)
                "
                min="1950-01-01"
              ></v-date-picker>
            </v-menu>
          </v-col>
        </v-row>
      </v-card-text>
      <v-divider></v-divider>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn :disabled="!isEditing" color="success" @click="save">
          Save
        </v-btn>
      </v-card-actions>
    </v-form>
    <v-snackbar v-model="hasSaved" :timeout="2000" absolute bottom left>
      Your profile has been updated
    </v-snackbar>
  </v-card>
</template>
<script>
export default {
  props: ['csrf'],
  mounted: function () {
    console.log(this.csrf)
  },
  data() {
    return {
      valid: false,
      firstname: '',
      lastname: '',
      dni: '',
      files: [],
      avatarPreview: 'Img/perfil-avatar.jpg',
      hasSaved: false,
      isEditing: null,
      model: null,
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
      console.log(this.csrf)
      if (this.valid) {
        this.isEditing = !this.isEditing
        let formData = new FormData()
        formData.append('avatar', this.files)
        formData.append('firstname', this.firstname)
        formData.append('lastname', this.lastname)
        formData.append('dni', this.dni)
        formData.append('csrf_name', this.csrf.csrf_name)
        formData.append('csrf_value', this.csrf.csrf_value)
        axios.post('/profile', formData).then((res) => {
          console.log(res)
          // this.pasoDatos(res.data)
        })
        this.hasSaved = true
      }
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

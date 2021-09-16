<template>
  <v-card class="overflow-hidden" color="grey darken-3" dark>
    <v-toolbar flat color="grey darken-4">
      <v-icon>mdi-account</v-icon>
      <v-toolbar-title class="font-weight-light">
        User Profile
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn color="grey darken-4" fab small @click="editing">
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
          v-model="form.avatar"
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
              v-model="form.firstname"
              color="white"
              label="Firstname"
              :messages="messages.firstname"
              :class="{ 'error--text' : hasError }"
            ></v-text-field>
          </v-col>
          <v-col cols="6">
            <v-text-field
              :disabled="!isEditing"
              v-model="form.lastname"
              color="white"
              label="Lastname"
              :messages="messages.lastname"
              :class="{ 'error--text' : hasError }"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="4">
            <v-text-field
              :disabled="!isEditing"
              v-model="form.nif"
              color="white"
              label="Nif"
              :messages="messages.nif"
              :class="{ 'error--text' : hasError }"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              :disabled="!isEditing"
              v-model="form.phone"
              color="white"
              label="Phone"
              :messages="messages.phone"
              :class="{ 'error--text' : hasError }"
            ></v-text-field>
          </v-col>
          <v-col cols="4">
            <v-text-field
              :disabled="!isEditing"
              v-model="form.mobile"
              color="white"
              label="Mobile"
              :messages="messages.mobile"
              :class="{ 'error--text' : hasError , '' : !hasError }"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="6">
            <v-select
              :disabled="!isEditing"
              v-model="form.gender"
              :items="genders"
              label="Gender"
              outlined
              :messages="messages.gender"
              :class="{ 'error--text' : hasError , '' : !hasError }"
            ></v-select>
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
                  v-model="form.birthday"
                  label="Birthday date"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  :messages="messages.birthday"
                  :class="{ 'error--text' : hasError , '' : !hasError }"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="form.birthday"
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
    // console.log(this.auth.user.getName)
  },
  created (){
    this.ready()
  },
  data() {
    return {
      valid: false,
      menu: false,
      activePicker: null,
      form : {
        firstname:  '',
        lastname: '',
        nif: '',
        phone: '',
        mobile: '',
        gender: '',
        birthday: null,
        avatar: [],
      },
      messages : {
        firstname: '',
        lastname: '',
        nif: '',
        phone: '',
        mobile: '',
        gender: '',
        birthday: '',
        avatar: '',
      },
      genders: ['Male', 'Famale'],
      avatarPreview: 'Img/perfil-avatar.jpg',
      hasSaved: false,
      isEditing: null,
      model: null,
      hasError: false
    }
  },
  methods: {
    editing () {
      this.isEditing = !this.isEditing
      this.hasError = false
      this.clearMessages()
    },
    clearForm(){
      Object.keys(this.form).forEach(element =>{
        if (element == 'birthday') {
          this.form[element] = null
        } else if (element == 'avatar') {
          this.form[element] = []
        } else {
          this.form[element] = ''
        }
      });
    },
    clearMessages(){
      Object.keys(this.messages).forEach(element =>{
          this.messages[element] = ''
      });
    },
    customFilter(item, queryText, itemText) {
      const textOne = item.name.toLowerCase()
      const textTwo = item.abbr.toLowerCase()
      const searchText = queryText.toLowerCase()
      return (
        textOne.indexOf(searchText) > -1 || textTwo.indexOf(searchText) > -1
      )
    },
    capitalize (text){
      text = text.toString()
      return text.charAt(0).toUpperCase() + text.slice(1)
    },
    save() {
      if (this.valid) {
        this.isEditing = !this.isEditing
        let formData = new FormData()
        formData.append('avatar', this.form.avatar ? this.form.avatar : [])
        formData.append('firstname', this.form.firstname)
        formData.append('lastname', this.form.lastname)
        formData.append('nif', this.form.nif)
        formData.append('phone', this.form.phone)
        formData.append('mobile', this.form.mobile)
        formData.append('gender', this.form.gender)
        formData.append('birthday', this.form.birthday)
        formData.append('csrf_name', this.csrf.csrf_name)
        formData.append('csrf_value', this.csrf.csrf_value)
        // this.clearForm()
        var that = this;
        axios
          .post('/profile', formData)
          .then((res) => {
            console.log('-- Respuesta Axios -----------')
            console.log(res.data)
            console.log('------------------------------')
          })
          .catch(function (error) {
            if (error.response) {
              if (error.response.status === 400) {
                console.log(error.response.data);
              }
              if (error.response.status === 302) {
                that.hasError = true
                let errors = error.response.data.errors
                Object.keys(errors).forEach(element =>{
                  that.messages[element] = errors[element][that.capitalize(element)]
                });
                let old = error.response.data.old
                Object.keys(old).forEach(element =>{
                  if (old[element] != '' && old[element] != "null") {
                      that.form[element] = old[element]
                  }
                });
              }
            }
          })
          .finally (()=>{
            this.hasSaved = true
          })
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
     async ready () {
       const res =  await axios.options('/profile')
       Object.keys(res.data).forEach(element =>{
         this.form[element] = res.data[element]
      });
    }
  },
}
</script>

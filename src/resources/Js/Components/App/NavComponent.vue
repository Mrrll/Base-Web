<template>
  <v-layout wrap>
    <v-app-bar color="grey darken-4" dark>
      <!-- <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
      large
      > -->
      <!-- //* Title -->
      <v-breadcrumbs>
        <v-breadcrumbs-item href="/" class="title">
          <v-avatar>
            <img src="favicon.png" :alt="title" />
          </v-avatar>
          <v-toolbar-title class="ml-2">{{ title }}</v-toolbar-title>
        </v-breadcrumbs-item>
      </v-breadcrumbs>
      <!-- ---------- -->
      <!-- //* Nav links -->
      <v-breadcrumbs v-if="auth.check" :items="NavLink"></v-breadcrumbs>
      <!-- ---------- -->
      <v-spacer></v-spacer>
      <!-- //* Menu User -->
      <v-menu offset-y v-if="auth.check">
        <template v-slot:activator="{ on, attrs }">
          <v-breadcrumbs color="grey darken-3" dark>
            <v-breadcrumbs-item v-bind="attrs" v-on="on">
              <v-avatar class="mr-2" size="28">
                <img src="Img/perfil-avatar.jpg"/>
              </v-avatar>
              {{ auth.user.name }}
              <v-icon right dark>
                mdi-menu-down
              </v-icon>
            </v-breadcrumbs-item>
          </v-breadcrumbs>
        </template>
        <v-list link color="grey darken-4" dark>
          <v-list-item-group color="grey darken-2" dark v-model="ItemSelected" >
            <v-list-item
              v-for="(item, i) in ListMenu"
              :key="i"
              :href="item.href"
              :disabled="item.disabled"
            >
              <v-list-item-icon>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="item.text"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-menu>
      <!-- ---------- -->
      <!-- //* Nav Links -->
      <v-breadcrumbs
        v-else
        :items="LoginRegister"
        divider="/"
        large
      ></v-breadcrumbs>
      <!-- ------------- -->
    </v-app-bar>
  </v-layout>
</template>
<script>
export default {
  props: ['title', 'auth', 'route'],
  data() {
    return {
      ItemSelected : '',
      NavLink: [
        {
          text: 'Home',
          disabled: this.route == 'home' ? true : false,
          href: '/home',
        },
      ],
      LoginRegister: [
        {
          text: 'Register',
          disabled: this.route == 'auth.register' ? true : false,
          href: '/register',
        },
        {
          text: 'Login',
          disabled: this.route == 'auth.login' ? true : false,
          href: '/login',
        },
      ],
      ListMenu: [
        { text: 'Profile', href: '/profile', icon: 'mdi-account-cog', disabled: this.route == 'profile' ? true : false },
        { text: 'Change Password', href: '/change', icon: 'mdi-key-variant', disabled: this.route == 'auth.password.change' ? true : false },
        { text: 'Logout', href: '/logout', icon: 'mdi-logout-variant', disabled: this.route == 'logout' ? true : false },
      ],
    }
  },
  mounted : function () {
    for (let index = 0; index < this.ListMenu.length; index++) {
      const element = this.ListMenu[index];
      if (element.disabled) {
        this.ItemSelected = index;
      }
    }
  }
}
</script>

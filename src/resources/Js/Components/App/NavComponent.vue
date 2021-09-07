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
            <img src="favicon.png" alt="John" />
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
          <v-breadcrumbs color="primary" dark>
            <v-breadcrumbs-item v-bind="attrs" v-on="on">
              <v-avatar class="mr-2">
                <img src="Img/blank_profile.png" alt="John" />
              </v-avatar>
              {{ auth.user.name }}
              <v-icon right dark>
                mdi-menu-down
              </v-icon>
            </v-breadcrumbs-item>
          </v-breadcrumbs>
        </template>
        <v-list link>
          <v-list-item-group color="primary">
            <v-list-item
              v-for="(item, i) in ListMenu"
              :key="i"
              :href="item.href"
            >
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
        { text: 'Profile', href: '/profile' },
        { text: 'Change Password', href: '/change' },
        { text: 'Logout', href: '/logout' },
      ],
    }
  },
}
</script>

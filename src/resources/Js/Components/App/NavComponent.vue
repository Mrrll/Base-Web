<template>
  <v-layout wrap>
    <v-app-bar color="grey darken-4" dark>
      <v-app-bar-nav-icon
        @click="changeDrawer"
        class="d-flex d-md-none"
      ></v-app-bar-nav-icon>
      <!-- //* Title -->
      <v-breadcrumbs class="d-none d-md-flex">
        <v-breadcrumbs-item href="/" class="title">
          <v-avatar>
            <img src="favicon.png" :alt="title" />
          </v-avatar>
          <v-toolbar-title class="ml-2">{{ title }}</v-toolbar-title>
        </v-breadcrumbs-item>
      </v-breadcrumbs>
      <!-- ---------- -->
      <!-- //* Tabs Nav links -->
      <v-tabs dark class="d-none d-md-flex" color="waith"
      grow>
        <v-tab
          v-for="(link, index) in getNavLists"
          :key="index"
          :href="link.href"
          :disabled="link.disabled"
          v-show="(link.component.indexOf('tab') > -1) && getUI.auth === link.auth"
        >
          {{ link.text }}
        </v-tab>
      </v-tabs>
      <!-- ---------- -->
      <v-spacer></v-spacer>
      <!-- //* Menu User -->
      <v-menu offset-y v-if="getUI.auth">
        <template v-slot:activator="{ on, attrs }">
          <v-breadcrumbs color="grey darken-3" dark>
            <v-breadcrumbs-item
              v-bind="attrs"
              v-on="on"
              class="d-none d-md-flex"
            >
              <v-avatar class="mr-2" size="28">
                <img id="avatar-profile" :src="imgAvatar" />
              </v-avatar>
              {{ getUI.user }}
              <v-icon right dark>
                mdi-menu-down
              </v-icon>
            </v-breadcrumbs-item>
          </v-breadcrumbs>
        </template>
        <v-list link color="grey darken-4" dark>
          <v-list-item-group color="grey darken-2" dark v-model="ItemSelected">
            <v-list-item
              v-for="(item, i) in getNavLists"
              :key="i"
              :href="item.href"
              :disabled="item.disabled"
              v-show="(item.component.indexOf('menu') > -1)"
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
import { mapActions, mapGetters, mapMutations } from 'vuex'
export default {
  props : ['title','route'],
  beforeMount() {
    this.UI()
  },
  data() {
    return {
      imgAvatar: 'Img/perfil-avatar.jpg',
      ItemSelected: '',
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
    }
  },

  mounted: function () {

  },
  computed: {
    ...mapGetters('ui', ['getSideMenuOpen']),
    ...mapGetters('ui', ['getUI']),
    ...mapGetters('ui', ['getNavLists']),
  },
  created: function () {
    this.ChargerNavList()
    if (this.avatar) {
      this.imgAvatar = this.avatar
    }
    // for (let index = 0; index < this.ListMenu.length; index++) {
    //   const element = this.ListMenu[index]
    //   if (element.disabled) {
    //     this.ItemSelected = index
    //   }
    // }
  },
  methods: {
    ...mapMutations('ui', ['toggleSideMenu']),
    ...mapActions('ui', ['UI']),
    ...mapActions('ui', ['NavLists']),
    changeDrawer() {
      let drawer = this.getSideMenuOpen //this.$store.state.ui.isSideMenuOpen
      drawer = !drawer
      this.toggleSideMenu(drawer) // this.$store.commit('ui/toggleSideMenu',drawer)
      return drawer
    },
    ChargerNavList() {
      let lista = [
        {
          text: 'Home',
          href: '/home',
          icon : 'mdi-home',
          disabled: this.route == 'home' ? true : false,
          component : ['tab', 'drawer'],
          auth : true
        },
        {
          text: 'Profile',
          href: '/profile',
          icon: 'mdi-account-cog',
          disabled: this.route == 'profile' ? true : false,
          component : ['menu'],
          auth : true
        },
        {
          text: 'Change Password',
          href: '/change',
          icon: 'mdi-key-variant',
          disabled: this.route == 'auth.password.change' ? true : false,
          component : ['menu', 'drawer'],
          auth : true
        },
        {
          text: 'Logout',
          href: '/logout',
          icon: 'mdi-logout-variant',
          disabled: this.route == 'logout' ? true : false,
          component : ['menu', 'drawer'],
          auth : true
        }
      ]
      this.NavLists(lista)
    }
  },
}
</script>

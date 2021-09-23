<template>
  <v-layout wrap>
    <v-navigation-drawer
      absolute
      temporary
      @input="updateDrawer"
      :value="getSideMenuOpen"
      dark
    >
      <v-list nav dense link color="grey darken-4">
        <v-list-item-group
          v-model="group"
          active-class="grey darken-2--text text--accent-4"
        >
          <v-list-item two-line :href="urlUser()">
            <v-list-item-avatar>
              <img :src="getUI.avatar" />
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{ getUI.user }}</v-list-item-title>
              <v-list-item-subtitle v-if="getUI.auth">
                Profile settings
              </v-list-item-subtitle>
              <v-list-item-subtitle v-else>
                Identify yourself
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item
            v-for="(list, index) in getNavLists"
            :key="index"
            :href="list.href"
            v-show="
              list.component.indexOf('drawer') > -1 && getUI.auth === list.auth
            "
          >
            <v-list-item-icon>
              <v-icon>{{ list.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              {{ list.text }}
            </v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </v-layout>
</template>
<script>
import { mapGetters, mapMutations } from 'vuex'
export default {
  data() {
    return {
      group: null,
    }
  },
  computed: {
    ...mapGetters('ui', ['getSideMenuOpen']), // this.$store.state.ui.isSideMenuOpen
    ...mapGetters('ui', ['getNavLists']),
    ...mapGetters('ui', ['getUI']),
  },
  methods: {
    ...mapMutations('ui', ['toggleSideMenu']),
    updateDrawer(e) {
      this.toggleSideMenu(e) // this.$store.commit('ui/toggleSideMenu',e)
    },
    urlUser(){
      if (this.getUI.auth) {
        return '/profile'
      } else {
        return '/'
      }
    }
  },
}
</script>

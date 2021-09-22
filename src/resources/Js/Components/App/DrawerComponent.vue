<template>
  <v-layout wrap>
    <v-navigation-drawer absolute temporary @input="updateDrawer" :value="getSideMenuOpen">
      <v-list nav dense>
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>
                mdi-home
              </v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              Home
            </v-list-item-title>
          </v-list-item>
          <v-list-item>
            <v-list-item-icon>
              <v-icon>
                mdi-account
              </v-icon>
            </v-list-item-icon>
            <v-list-item-title>
              Account
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
    ...mapGetters('ui',['getSideMenuOpen']) // this.$store.state.ui.isSideMenuOpen
  },
  methods : {
    ...mapMutations('ui',['toggleSideMenu']),
    updateDrawer(e){
      this.toggleSideMenu(e) // this.$store.commit('ui/toggleSideMenu',e)
    }
  }
}
</script>

<template>
    <v-layout wrap>
    <v-app-bar
      color="deep-purple"
      dark
    >
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

      <v-toolbar-title>Title</v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Account</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    </v-layout>
</template>
<script>
export default {
    props: [ 'user_id' ],
    mounted() {
        // console.log(this.user_id);
        // console.log(this.user_id.app);
    },
    data() {
        return {
            items_p: [
                {
                text: this.$t('Login'),
                disabled: false,
                href: '/login',
                },
                {
                text: this.$t('Register'),
                disabled: false,
                href: '/register',
                },
            ],
            items_l: [
                {
                text: this.$t('Login'),
                disabled: false,
                href: '/login',
                },
            ],
            items_r: [
                {
                text: this.$t('Register'),
                disabled: false,
                href: '/register',
                },
            ],
            items_h: [
                {
                text: 'Home',
                disabled: false,
                href: '/home',
                },
            ],
            items_title: [
                {
                text: this.user_id.app.titulo,
                disabled: false,
                href: '/',
                },
            ],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            drawer: true,
            group: null,
            mini : true,
            model: null,
            dialog : false,
            dialogSetting : false,
            bottomNav :true,
            firstname : '',
            lastname : '',
            resource_path : '',
            avatar : "img/avatarDefault.jpg",
            list_item : [
                {
                    name: "familias",
                    class: "iconDrawer_stroke",
                    icon: "familias",
                },
                {
                    name: "articulos",
                    class: "iconDrawer_stroke",
                    icon: "articulos",
                },
                {
                    name: "clientes",
                    class: "iconDrawer_fill",
                    icon: "clientes",
                },
                {
                    name: "proveedores",
                    class: "iconDrawer_stroke",
                    icon: "proveedores",
                },
                {
                    name: "albaranes",
                    class: "iconDrawer_stroke",
                    icon: "albaranes",
                },
                {
                    name: "facturas",
                    class: "iconDrawer_stroke",
                    icon: "facturas",
                },
                {
                    name: "compras",
                    class: "iconDrawer_stroke",
                    icon: "compras",
                },
                {
                    name: "pedidos",
                    class: "iconDrawer_stroke",
                    icon: "pedidos",
                },
            ],
            datos : ''
        }
    },
    methods : {
        logout(){
            document.getElementById('logout-form').submit();
        },
        onResultados(datos) {
            if(datos.avatar){
                this.firstname = datos.firstname
                this.lastname = datos.lastname
                this.avatar = datos.avatar
            } else {
                this.dialog = (datos.dialogo) ? datos.dialogo :datos;
                this.dialogSetting = (datos.dialogoSetting) ? datos.dialogoSetting :datos;
            }
        }
    },
    created() {
        if(this.user_id.app.view == 'home'){

            axios.get('/profiles/',{
                params: {
                    views : 'home'
                }
            }
            ).then((res) => {
                if(res.data.length){
                    this.avatar = (res.data[0].image) ? res.data[0].image.url : this.avatar
                    this.firstname = res.data[0].firstname
                    this.lastname = res.data[0].lastname
                }
            });
        }
    },
}
</script>

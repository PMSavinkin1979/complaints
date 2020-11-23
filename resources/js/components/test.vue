<template>
    <div>
        <!--<v-icon left color="blue" @click.stop="drawer = !drawer">mdi-menu</v-icon>-->
        <v-navigation-drawer v-model="drawer" app>
            <v-spacer></v-spacer>
            <v-divider></v-divider>

            <v-list>
                <v-list-item v-for="[icon, text, func, num] in links" :key="icon" link @click="clickDrawer(num)">
                    <v-list-item-icon>
                        <v-icon>{{ icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <!--<v-list-item-title @click="clickDrawer(func)">{{ text }}</v-list-item-title>-->
                        <router-link :to="func">{{ text }}</router-link>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

        </v-navigation-drawer>

        <v-app-bar app>
                <!--меню-->
                    <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
                    <v-toolbar-title>{{ name }}</v-toolbar-title>
        </v-app-bar>

            <router-view></router-view>

        <div class="text-center ma-2">
            <v-snackbar left v-model="snackbarMessage" :timeout="timeout" :color="color" class="align-center">
                {{ this.$store.getters.SNACKBARMESSAGE }}
            </v-snackbar>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        data () {
            return {
                drawer: 0,
                links: [
                    /*['mdi-menu', 'скрыть панель', 'drawerClose'],*/
                    /*['mdi-microsoft-excel', 'Выгрузить в Excel', 'excel'],*/
                    ['mdi-briefcase-variant', 'Рекламации', '/','0'],
                    ['mdi-chart-areaspline', 'Графики', '/charts','1'],
                    ['mdi-cogs', 'Настройки', '/setup','2'],
                    ['mdi-exit-run', 'Выход', '/','3'],
                ],
                name:'Рекламации',
                linkRouter:'',
                snackbarMessage: true,
                timeout: 0,
                color: 'red',
            }
        },
        created () {
            /*console.log(this.$router)*/
            this.god = this.$store.getters.GOD
        },
        methods:{
            clickDrawer(num){
                //console.log(num)
                this.name = this.$router.options.routes[num].nameRouter
                this.drawer = 0
            },
        },
        watch:{

        },
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <v-container fluid class="pt-12">
            <v-card>
                <v-card-title>
                    <v-row>
                        <!--Статус-->
                        <v-col cols="12" md="4">
                            Cтруктура гарантийных расходов за
                            <!--<v-select
                                outlined
                                :items="itemstatus"
                                item-text="stat"
                                :prepend-inner-icon="statusIcon(itemStatusSelect.stat)"
                                label="Статус"
                                dense
                                v-model="itemStatusSelect"
                                @change="statusChange(itemStatusSelect.stat)"
                                return-object>
                            </v-select>-->
                        </v-col>
                        <!--Квартал-->
                        <v-col cols="12" md="3">
                            <v-select style="font-size: xx-small"
                                      outlined
                                      :items="months"
                                      :menu-props="{ maxHeight: '400' }"
                                      item-text="stat"
                                      item-value="num"
                                      label="Выборка"
                                      multiple
                                      hint="по месяцам"
                                      dense
                                      v-model="monthSelect"
                                      @blur="monthChange(monthSelect)"
                                      persistent-hint
                            ></v-select>
                        </v-col>
                        <!--Год-->
                        <v-col cols="12" md="1">
                            <v-text-field dense type="number" label="Год" outlined v-model="god" hide-details @click="filterYear(god)"></v-text-field>
                        </v-col>
                        <!--Цель-->
                        <v-col cols="12" md="4">
                            Цель total - 0,35% <br> текущая - {{ currentResult }} %
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-row>
                    <!--Первая таблица-->
                    <v-col cols="12" md="6">
                        <v-card>
                            <v-card-title>
                                <v-btn x-small color="primary" @click="fontPlus()">+</v-btn>
                                <v-btn x-small color="primary" @click="fontMinus()">-</v-btn>
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Поиск"></v-text-field>
                            </v-card-title>
                            <v-data-table dense :headers="headers" :items="items" :search="search">
                                <template v-slot:item="{item}">
                                    <tr>
                                        <td :style="fontS+fn+fpx">{{ item.prikaz_gar }}</td>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs}">
                                                <td :style="fontS+fn+fpx" v-on="on">{{ item.short_zakazchik }}</td>
                                            </template>
                                            <span>{{item.zakazchik }}</span>
                                        </v-tooltip>
                                        <td :style="fontS+fn+fpx">{{ item.prikaz }}</td>
                                        <td :style="fontS+fn+fpx">{{ item.zatraty }}</td>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs}">
                                                <td :style="fontS+fn+fpx" v-on="on">{{ item.short_months }}</td>
                                            </template>
                                            <span>{{item.months }}</span>
                                        </v-tooltip>
                                        <td :style="fontS+fn+fpx">{{ item.name_vina }}</td>
                                        <td :style="fontS+fn+fpx">{{ item.name_vid_gara }}</td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-card>
                    </v-col>
                    <!--Вторая таблица-->
                    <v-col cols="12" md="3">
                        <v-card>
                            <v-card-title>
                                по видам ГС
                            </v-card-title>
                            <v-data-table dense :headers="headersG" hide-default-footer :items="itemsG" sort-by="vidgar">
                                <template v-slot:body.append>
                                    <tr style="background: silver">
                                        <!--<td></td>-->
                                        <td>
                                            <v-text-field v-show="isShow(summaZ)" v-model="summaZ" type="number" label="Итого"></v-text-field>
                                        </td>
                                        <td></td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-card>
                    </v-col>
                    <!--Графики-->
                    <v-col cols="12" md="3">
                        <v-card elevation="3">
                            <any-chart :masiv="this.itemsSend" :headers="this.headersSend"></any-chart>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
    </div>
</template>

<script>
     import axios from "axios";

     export default {
         data () {
             return {
                 monthSelect:[],
                 months:[
                     {stat: 'Янв', num: '01', god: this.$store.getters.GOD},
                     {stat: 'Фев', num: '02'},
                     {stat: 'Мар', num: '03'},
                     {stat: 'Апр', num: '04'},
                     {stat: 'Май', num: '05'},
                     {stat: 'Июн', num: '06'},
                     {stat: 'Июл', num: '07'},
                     {stat: 'Авг', num: '08'},
                     {stat: 'Сен', num: '09'},
                     {stat: 'Окт', num: '10'},
                     {stat: 'Ноя', num: '11'},
                     {stat: 'Дек', num: '12'},
                 ],
                 god:'2020',
                 itemStatusSelect:{stat: 'В работе'},
                 itemstatus:[
                     {stat: 'В работе'},
                     {stat: 'Закрытые'},
                     {stat: 'Удаленные'}
                 ],
                 search: '',
                 items:[],
                 itemsG:[],
                 headers: [
                     { text: '№ ГП', value: 'prikaz_gar' },
                     { text: 'Контрагент', value: 'short_zakazchik' },
                     { text: '№ приказа', value: 'prikaz' },
                     { text: 'Расходы', value: 'zatraty' },
                     { text: 'Период расходов', value: 'short_months' },
                     { text: 'Виновный', value: 'name_vina' },
                     { text: 'Причина ГС', value: 'name_vid_gara' },
                 ],
                 headersG: [
                     { text: 'Вид ГС', value: 'vidgs' },
                     { text: 'Затраты', value: 'vidgar' },
                 ],
                 itemsSend:[],
                 headersSend:[],
                 summaZ: 0,
                 fontS:'font-size: ',
                 fn: 12,
                 fpx:'px',
                 kvartal:[],
                 currentResult:0,
             }
         },
         created () {
             this.initialize()
         },
         computed:{
            totalSum: function(){
                let sum = 0
                this.itemsG.forEach(function(itemG){
                    sum += itemG.vidgar
                })
                //console.log(sum)
                //this.summaZ = sum
                return sum
            },
             getUnique: function() {
                 let i = 0,
                     current,
                     length = this.kvartal.length ,
                     unique = [];
                 for (; i < length; i++) {
                     current = this.kvartal[i];
                     if (!~unique.indexOf(current)) {
                         unique.push(current);
                     }
                 }
                 return unique;
             },
         },
         methods:{
             initialize(){
                 let arr = ''
                 let kv = []
                 let date = new Date()
                 let month = date.getMonth()+1
                 if (month < 4)
                 {
                     arr = '["01","02","03"]'
                     kv = ['1']
                 }
                 if (month > 3 && month < 7)
                 {
                     arr = '["04","05","06"]'
                     kv = ['2']
                 }
                 if (month > 6 && month < 10)
                 {
                     arr = '["07","08","09"]'
                     kv = ['3']
                 }
                 if (month > 9)
                 {
                     arr = '["10","11","12"]'
                     kv = ['4']

                 }
                 this.monthSelect = JSON.parse(arr)
                 // указываем текущий кварта
                 this.$store.dispatch('SET_QUARTERS', kv)
                 axios.post('/axios-send/chartStart',{month: arr, god: this.$store.getters.GOD, kvartal: this.$store.getters.QUARTERS}).then(respond => {
                     this.items = respond.data.table1
                     this.itemsG = respond.data.table2
                     this.dataSendChart()
                 })
             },
             monthChange(months){
                 this.kvartal=[]
                 //console.log(months)
                 for (let i=0; i<months.length; i++)
                 {
                     if (months[i]<4) { this.kvartal.push('1') }
                     if (months[i]>3 && months[i]<7) { this.kvartal.push('2') }
                     if (months[i]>6 && months[i]<10) { this.kvartal.push('3') }
                     if (months[i]>9) { this.kvartal.push('4') }
                 }
                 // указываем текущий кварта
                 this.$store.dispatch('SET_QUARTERS', this.getUnique)
                 console.log(this.getUnique)
                 axios.post('/axios-send/chartStart',{month: months, god: this.$store.getters.GOD, kvartal: this.$store.getters.QUARTERS}).then(respond => {
                     this.items = respond.data.table1
                     this.itemsG = respond.data.table2
                     this.summaZ = this.totalSum
                     let summm = ((this.summaZ/respond.data.purpose)*100)
                     this.currentResult = summm.toPrecision(3)
                     console.log(this.currentResult)
                     /*console.log(this.summaZ)
                     console.log(respond.data.purpose)*/
                     this.dataSendChart()
                 })
             },
             filterYear(god){
                 console.log(god)
             },
             statusIcon(text){
                 if (text == 'В работе')
                 {
                     return 'mdi-run'
                 }
                 if (text == 'Закрытые')
                 {
                     return 'mdi-check'
                 }
                 if (text == 'Удаленные')
                 {
                     return 'mdi-delete'
                 }
             },
             dataSendChart(){

                 if (this.itemsG == '')
                 {
                     console.log('нет данных для передачи')
                     this.itemsSend = []
                     this.headersSend = []
                     this.chartdata = {}
                     this.options = {}
                     this.$store.dispatch('SET_SNACKBARMESSAGE', 'нет данных для передачи' )
                     this.$store.dispatch('SET_SNACKBARBOOL', true)
                 }
                 else
                 {
                     let str='['
                     let nam1='['
                     for (let i=0; i<this.itemsG.length; i++)
                     {
                         str = str + this.itemsG[i].vidgar + ','
                         nam1 = nam1 + '"'+this.itemsG[i].vidgs+'"' + ','
                     }
                     str = str.substring(0,str.length-1)
                     nam1 = nam1.substring(0,nam1.length-1)
                     //console.log(nam1)
                     str = str+']'
                     nam1 = nam1+']'
                     this.itemsSend = JSON.parse(str)
                     this.headersSend = JSON.parse(nam1)
                     //console.log(this.chartdata)
                     //console.log(this.options)
                     //this.chartdata2 = this.chartdata2
                     this.$store.dispatch('SET_SNACKBARMESSAGE', 'данные отправленны' )
                     this.$store.dispatch('SET_SNACKBARBOOL', true)
                 }
             },
             isShow(sz){
                 if (sz == 0)
                 {
                     return false
                 }
                 else
                 {
                     return true
                 }
             },
             fontPlus(){
                this.fn++
             },
             fontMinus(){
                 this.fn--
             }
         }
     }
</script>

<style scoped>
.fss{
    font-size: xx-small;
}
</style>

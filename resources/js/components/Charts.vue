<template>
    <div>
        <v-container fluid class="pt-12">
            <v-card>
                <v-card-title>
                    <v-row>
                        <!--Cтруктура рекламационных расходов за-->
                        <v-col cols="12" md="4">
                            Cтруктура рекламационных расходов за
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
                                      item-text="name"
                                      item-value="num"
                                      value="ms"
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
                            <h6>Total Цель - 0,35%, Текущая - {{ currentResult }} %<br>Итого - ?</h6>
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
                                <v-btn x-small color="primary" @click="inExcel()">в Excel</v-btn>
                                <v-spacer></v-spacer>
                                <v-btn x-small color="primary" @click="clearVuex()"><v-icon small>mdi-broom</v-icon></v-btn>
                                <v-text-field v-model="this.$store.getters.SEARCH" class="pl-2 ml-2"></v-text-field>  <!--append-icon="mdi-magnify" label="Поиск"-->
                            </v-card-title>
                            <v-data-table dense :headers="headers" :items="items" :search="this.$store.getters.SEARCH">
                                <!--отрисовка таблицы-->
                                <template v-slot:item="{item}">
                                    <tr @click="clickTr(item)">
                                        <td :style="fontS+fn+fpx">{{ item.prikaz_gar }}
                                            <v-icon x-small left color="red">{{ iconVina(item) }}</v-icon>
                                        </td>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs}">
                                                <td :style="fontS+fn+fpx" v-on="on">{{ item.short_zakazchik2 }}</td>
                                            </template>
                                            <span>{{item.zakazchik }}</span>
                                        </v-tooltip>
                                        <td :style="fontS+fn+fpx">{{ item.prikaz }}</td>
                                        <td :style="fontS+fn+fpx">{{ item.payment }}</td>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs}">
                                                <td :style="fontS+fn+fpx" v-on="on">{{ item.pay_months }}</td>
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
                                <!--раскрасим выбранное в диаграмме-->
                                <template v-slot:item="{item}">
                                    <tr :class="test(item.vidgs)">
                                        <td>{{ item.vidgs }}</td>
                                        <td>{{ item.vidgar }}</td>
                                    </tr>
                                </template>
                                <!--итоговая сумма-->
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
                    <!--Модальное окно для просмотра информации-->
                    <v-dialog v-model="dialog" max-width="900">
                        <v-card>
                            <v-card-title class="headline">
                                Рекламация - {{editedItem.zakazchik}}
                            </v-card-title>
                            <v-card-text>
                                <v-row style="background: azure">
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.prikaz_gar" label="№ ГП"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.prikaz" label="№ приказа"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.zatraty" label="Расходы"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-textarea rows="1" dense :value="editedItem.months" label="Период расходов"></v-textarea>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.name_vina" label="Виновный"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.name_vid_gara" label="Причина ГС"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-divider></v-divider>
                                <v-row>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.data" label="Дата начала"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field rows="1" dense :value="editedItem.data_end" label="Дата конца"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.name_ustranen" label="Устранение"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.name_garantiy" label="Гарантия"></v-text-field>
                                    </v-col>
                                    <!--<v-col cols="12" md="3" class="">
                                        <v-textarea rows="1" dense :value="editedItem.regression" label="Регрессия"></v-textarea>
                                    </v-col>-->
                                    <v-col cols="12" md="3" class="">
                                        <v-checkbox label="Документы перенаправленны виновной стороне" dense :value="editedItem.regressionBool"></v-checkbox>
                                    </v-col>
                                    <!--<v-col cols="12" md="3" class="">
                                        <v-text-field dense :value="editedItem.name_vid_gara" label="Причина ГС"></v-text-field>
                                    </v-col>-->
                                </v-row>
                                <v-divider></v-divider>
                            </v-card-text>
                            <v-card-actions>
                                <!--<v-spacer></v-spacer>-->
                                <v-btn color="green darken-1" text @click="dialog = false">Закрыть</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
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
                 dialog: false,
                 monthSelect: {stat: '', num: '', ms: ''},
                 months:[],
                 god:'',
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
                 procent:[],
                 summaZ: 0,
                 fontS:'font-size: ',
                 fn: 12,
                 fpx:'px',
                 kvartal:[],
                 currentResult:0,
                 search2:'',
                 editedItem:[]
             }
         },
         created () {
             this.initialize()
             this.god = this.$store.getters.GOD
         },
         watch:{
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
                 this.monthSelect = JSON.parse(arr) //arr
                 // указываем текущий кварта
                 this.$store.dispatch('SET_QUARTERS', kv)
                 axios.post('/axios-send/months').then(respond => {
                     this.months = respond.data
                 })
                 axios.post('/axios-send/chartStart',{month: arr, god: this.$store.getters.GOD, kvartal: this.$store.getters.QUARTERS}).then(respond => {
                     this.items = respond.data.table1
                     this.itemsG = respond.data.table2
                     this.dataSendChart()
                 })
             },
             monthChange(months){
                 //console.log(this.monthSelect)
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
                 //console.log(this.getUnique)
                 axios.post('/axios-send/chartStart',{month: months, god: this.$store.getters.GOD, kvartal: this.$store.getters.QUARTERS}).then(respond => {
                     this.items = respond.data.table1
                     this.itemsG = respond.data.table2
                     this.summaZ = this.totalSum
                     //текущий процент
                     let summm = ((this.summaZ/respond.data.purpose)*100)
                     this.currentResult = summm.toPrecision(3)
                     // запускаем метод для формирования графика
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
                     this.procent = []
                     this.chartdata = {}
                     this.options = {}
                     this.$store.dispatch('SET_SNACKBARMESSAGE', 'нет данных для передачи' )
                     this.$store.dispatch('SET_SNACKBARBOOL', true)
                 }
                 else
                 {
                     this.summaZ = this.totalSum
                     console.log(this.itemsG)
                     let str='['
                     let procent='['
                     let nam1='['
                     for (let i=0; i<this.itemsG.length; i++)
                     {
                         // в процентах %
                         procent = procent + String(Math.round((this.itemsG[i].vidgar/this.summaZ)*100)) + ','
                         // в рублях
                         str = str + this.itemsG[i].vidgar + ','
                         nam1 = nam1 + '"'+this.itemsG[i].vidgs+'"' + ','
                     }
                     procent = procent.substring(0,procent.length-1)
                     str = str.substring(0,str.length-1)
                     nam1 = nam1.substring(0,nam1.length-1)
                     //console.log(str)
                     procent = procent+']'
                     str = str+']'
                     nam1 = nam1+']'
                     /*console.log(this.summaZ)
                     console.log(procent)
                     console.log(str)
                     console.log(nam1)*/
                     this.itemsSend = JSON.parse(procent)
                     //this.itemsSend = JSON.parse(str)
                     this.headersSend = JSON.parse(nam1)
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
             },
             clearVuex(){
                 this.$store.dispatch('SET_SEARCH','')
             },
             iconVina(item){
                 //console.log(item.regression)
                 if (item.regressionBool == true )
                 {
                     return 'mdi-email-send-outline'
                 }
             },
             clickTr(item){
                 //console.log(item)
                 this.editedItem = item
                 this.dialog = true
             },
             test(sear){
                 if (sear == this.$store.getters.SEARCH){
                     /*console.log('******')
                     console.log(sear)
                     console.log(this.$store.getters.SEARCH)
                     console.log('******')*/
                     return 'ok'
                 }else{
                     //console.log('НЕЕЕТ')
                     return 'notOk'
                 }

             },
             inExcel(){
                 axios.post('/axios-send/inExcel',{stat: 'chart',masiv: this.items, god: this.god, head: this.headers},{responseType: 'blob'})
                     .then(respond => {
                         var fileURL = window.URL.createObjectURL(new Blob([respond.data]));
                         var fileLink = document.createElement('a');
                         fileLink.href = fileURL;
                         fileLink.type = 'application/vnd.ms-excel';
                         let ft = 'отчет-'+'chart'+'-'+this.god+'.xlsx'
                         fileLink.setAttribute('download', ft);
                         document.body.appendChild(fileLink);
                         fileLink.click();
                         axios.post('/axios/deleteExcel',{ft:ft}).then(respond => {
                             console.log('Готово')
                         })
                     })
             },
         },
     }
</script>

<style scoped>
.ok{
    color: white;
    background: teal;
}
.notOk{
    color: black;
    background: white;
}
</style>

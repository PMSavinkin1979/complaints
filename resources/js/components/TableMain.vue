<template xmlns="http://www.w3.org/1999/html">
<div>
    <v-container fluid class="pt-12">
    <v-container>
        <!--шапка в таблице-->
        <!--<v-card class="d-flex justify-md-center mb-3">
            &lt;!&ndash;Статус&ndash;&gt;
            <v-select
                outlined
                :items="itemstatus"
                item-text="stat"
                :prepend-inner-icon="statusIcon(itemStatusSelect.stat)"
                label="Статус"
                dense
                v-model="itemStatusSelect"
                @change="statusChange(itemStatusSelect.stat)"
                return-object>
            </v-select>
            &lt;!&ndash;Год&ndash;&gt;
            <v-text-field dense type="number" label="Год" outlined v-model="god" hide-details @click="filterYear(god)"></v-text-field>
            &lt;!&ndash;Выборка&ndash;&gt;
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
                      @change="monthChange(monthSelect)"
                      persistent-hint
            ></v-select>
            &lt;!&ndash;Чебокс7&ndash;&gt;
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs}">
                    <v-checkbox label="все записи" dense v-model="checkbox7" @change="check(checkbox7)" v-on="on"></v-checkbox>
                </template>
                <span>для Выборки со всеми статутсами за {{god}}</span>
            </v-tooltip>
        </v-card>-->
        <v-card elevation="7" color="teal lighten-5">
            <v-row dense class="pt-5 pb-0">
                <!--Пусто-->
                <v-col cols="12" md="1" sm="6">

                </v-col >
                <!--статус главной формы outlined dense-->
                <v-col cols="12" md="3" sm="6">
                    <v-select
                        :items="itemstatus"
                        item-text="name2"
                        :prepend-inner-icon="statusIcon(itemStatusSelect)"
                        label="Статус"
                        v-model="itemStatusSelect"
                        @change="statusChange(itemStatusSelect)"
                        return-object>
                    </v-select>
                </v-col>
                <!--Год-->
                <v-col cols="12" md="1" sm="6">
                    <v-text-field type="number" label="Год" v-model="god" hide-details @click="filterYear(god)"></v-text-field>
                </v-col>
                <!--Квартал-->
                <v-col cols="12" md="3" sm="6">
                    <v-select style="font-size: xx-small"
                              :items="months"
                              :menu-props="{ maxHeight: '400' }"
                              item-text="stat"
                              item-value="num"
                              label="Выборка (по Начало)"
                              multiple
                              hint="по месяцам"
                              v-model="monthSelect"
                              @blur="monthChange(monthSelect)"
                              persistent-hint
                    ></v-select>
                </v-col>
                <!--Чекбокс для квартала  checkbox7-->
                <v-col cols="12" md="2" sm="6">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs}">
                            <v-checkbox label="все статусы" dense v-model="checkbox7" @change="check(checkbox7)" v-on="on"></v-checkbox>
                        </template>
                        <span>для Выборки со всеми статутсами за {{god}}</span>
                    </v-tooltip>
                </v-col>
                <!--Пусто-->
                <v-col cols="12" md="1" sm="6">

                </v-col>
            </v-row>
        </v-card>
    </v-container>
    <!--<div id="axios-send"></div>-->
        <v-data-table dense :headers="headers" :items="danye" :search="search" :items-per-page="itemsPerPage" class="elevation-7">
            <template v-slot:top>
            <v-toolbar flat dense>
                    <!--ЧЕК8-->
                    <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs}">
                        <v-checkbox class="pt-2" label="все записи" dense v-model="checkbox8" @change="check2(checkbox8)" v-on="on"></v-checkbox>
                    </template>
                    <span>для Поиска во всех статутсами за {{god}}</span>
                </v-tooltip>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                    <!--Поиск-->
                    <v-text-field v-model="search" label="Поиск" hide-details outlined dense></v-text-field>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                    <!--Иконка в EXCEL-->
                    <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs}">
                        <v-icon large color="blue" @click="inExcel()" v-on="on">mdi-microsoft-excel</v-icon>
                    </template>
                        <span>выгрузить в Excel текущую таблицу</span>
                    </v-tooltip>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                <!--модальное окно-->
                <v-dialog v-model="dialog" max-width="900">
                    <!--Новая запись-->
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn normal color="teal"  @click="newItem()" v-on="on">Новая запись</v-btn>
                    </template>
                    <v-card>
                    <v-container fluid>
                        <v-row dense>
                            <!--заголовок-->
                            <v-col cols="12" md="5">
                                <v-card-title primary-title class="pt-0" style="color: blue; font-size: 14px">
                                    {{ formTitle }} {{ editedItem.id }}
                                </v-card-title>
                            </v-col>
                            <!--закрыть-->
                            <v-col cols="12" md="2" class="pt-2">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs}">
                                        <v-icon color="red" @click="close" v-bind="attrs" v-on="on">mdi-close</v-icon>
                                    </template>
                                    <span>Закрыть без сохранения</span>
                                </v-tooltip>
                            </v-col>
                            <!--сохранить-->
                            <v-col cols="12" md="2" class="pt-2">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs}">
                                        <v-icon color="green" @click="save1" v-bind="attrs" v-on="on">mdi-content-save</v-icon>
                                    </template>
                                    <span>Сохранить и закрыть</span>
                                </v-tooltip>
                            </v-col>
                            <!--статус карточки-->
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs}">
                            <v-col cols="12" md="3" v-bind="attrs" v-on="on">
                                        <v-select
                                            :items="itemstatus_card"
                                            item-text="name"
                                            :prepend-inner-icon="statusIcon(itemStatusSelect_card)"
                                            label="Статус"
                                            dense
                                            v-model="itemStatusSelect_card"
                                            @change="statusChange_card(itemStatusSelect_card, editedItem.id)"
                                            return-object>
                                        </v-select>
                            </v-col>
                                </template>
                                <span>Изменить статус записи</span>
                            </v-tooltip>
                        </v-row>
                            <v-divider dark></v-divider>
                        <v-row dense>
                            <!--календарь начало-->
                            <v-col cols="12" md="3" class="">
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :return-value.sync="date"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            dense
                                            v-model="editedItem.data"
                                            label="Дата начала рекламации"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>

                                    <v-date-picker v-model="editedItem.data" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menu = false">Отмена</v-btn>
                                        <v-btn text color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                            <!--календарь конец-->
                            <v-col cols="12" md="3" class="">
                                <v-menu
                                    ref="menuEnd"
                                    v-model="menuEnd"
                                    :close-on-content-click="false"
                                    :return-value.sync="date_end"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            dense
                                            v-model="editedItem.data_end"
                                            label="Дата конца рекламации"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>

                                    <v-date-picker v-model="editedItem.data_end" no-title scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary" @click="menuEnd = false">Отмена</v-btn>
                                        <v-btn text color="primary" @click="$refs.menuEnd.save(date_end)">OK</v-btn>
                                    </v-date-picker>
                                </v-menu>
                            </v-col>
                            <!--приказ-->
                            <v-col cols="12" md="3" class="">
                                <v-text-field type="number" dense v-model="editedItem.prikaz" label="Приказ"></v-text-field>
                            </v-col>
                            <!--№ Гарантийного приказ-->
                            <v-col cols="12" md="3" class="">
                                <v-text-field type="number" dense v-model="editedItem.prikaz_gar" label="№ Гарантийного приказ"></v-text-field>
                            </v-col>
                            <!--Гарантия-->
                            <v-col cols="12" md="4" class="">
                                <!--<v-text-field dense outlined v-model="editedItem.name_garantiy" label="Гарантия"></v-text-field>selectgar-->
                                <v-combobox v-model="selectgar"
                                            :items="itemsgar"
                                            label="Гарантия"
                                            outlined dense
                                            item-text="name"
                                            item-value="id"
                                            return-object
                                            @change="combobox1"
                                ></v-combobox>
                            </v-col>
                            <!--статус-->
                            <v-col cols="12" md="4" class="">
                                <!--<v-text-field dense outlined v-model="editedItem.name_status" label="Статус"></v-text-field>-->
                                <v-combobox v-model="selectstatus"
                                            :items="itemsstatus"
                                            label="Статус"
                                            outlined dense
                                            item-text="name"
                                            item-value="id"
                                            return-object
                                            @change="combobox3"
                                ></v-combobox>
                            </v-col>
                            <!--вид надстройки-->
                            <v-col cols="12" md="4" class="">
                                <v-textarea rows="1" dense outlined v-model="editedItem.vid_ts" label="Вид надстройки"></v-textarea>
                            </v-col>
                            <!--Причина гарантии-->
                            <v-col cols="12" md="4" class="">
                                <!--<v-textarea rows="2" dense outlined v-model="editedItem.name_vid_gara" label="Предмет гарантии"></v-textarea>-->
                                <v-combobox v-model="selectvidgar"
                                            :items="itemsvidgar"
                                            label="Причина гарантии"
                                            outlined dense
                                            item-text="name"
                                            item-value="id"
                                            return-object
                                            @change="combobox2"
                                ></v-combobox>
                            </v-col>
                            <!--Заказчик-->
                            <v-col cols="12" md="4" class="">
                                <v-textarea rows="1" dense outlined v-model="editedItem.zakazchik" label="Заказчик" ></v-textarea>
                            </v-col>
                            <!--Предполагаемый виновник-->
                            <v-col cols="12" md="4" class="">
                                <!--<v-textarea rows="2" dense outlined v-model="editedItem.name_vid_gara" label="Предмет гарантии"></v-textarea>-->
                                <v-combobox v-model="selectvina"
                                            :items="itemsvina"
                                            label="Предполагаемый виновник"
                                            outlined dense
                                            item-text="name"
                                            item-value="id"
                                            return-object
                                            @change="combobox4"
                                ></v-combobox>
                            </v-col>
                            <!--Устранение-->
                            <v-col cols="12" md="4" class="">
                                <!--<v-textarea rows="2" dense outlined v-model="editedItem.name_vid_gara" label="Предмет гарантии"></v-textarea>-->
                                <v-combobox v-model="selectustran"
                                            :items="itemsustran"
                                            label="Устранение"
                                            outlined dense
                                            item-text="name"
                                            item-value="id"
                                            return-object
                                            @change="combobox5"
                                ></v-combobox>
                            </v-col>
                            <!--комментарий-->
                            <v-col cols="12" md="8" class="">
                                <v-textarea rows="1" outlined dense v-model="editedItem.korrect" label="Комментарий (мероприятия)"></v-textarea>
                            </v-col>
                            <!--перенаправление документов виновному-->
                            <v-col cols="12" md="4">
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs}">
                                        <v-checkbox class="pt-0" label="Документы перенаправленны виновной стороне" dense v-model="editedItem.regressionBool"
                                                    @change="check3(checkbox9)" v-on="on"></v-checkbox>
                                    </template>
                                    <span>отметить если перенаправили претензию и понесенные убытки</span>
                                </v-tooltip>
                            </v-col>
                            <v-col cols="12" md="8" class="">
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs}">
                                        <v-textarea dense rows="1" outlined v-model="editedItem.regression"
                                                    label="Перечень документов и описание" v-on="on"></v-textarea>
                                    </template>
                                    <span>Если есть факт отправки документов виновному, то вкратце описать</span>
                                </v-tooltip>
                            </v-col>

                            <v-col cols="12" md="4" class="">
                                Затраты
                                <v-btn color="primary" x-small @click="dialogPay=true">добавить</v-btn>
                                <v-card>
                                    <v-list nav dense>
                                        <v-list-item-group v-model="paymentsItemsSelect" color="primary">
                                            <v-list-item v-for="(item, i) in paymentsItems" :key="i">
                                                <v-list-item-content v-on:mouseenter="show=true" v-on:mouseleave="show=false">
                                                    <v-list-item-title>
                                                        {{item.months}} - {{item.payment}}
                                                    </v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    <v-icon small color="red">mdi-delete</v-icon>
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-list-item-group>
                                    </v-list>
                                </v-card>
                            </v-col>
                            <!--Модальное для добавления затрат-->
                            <v-dialog v-model="dialogPay" max-width="450">
                                <v-card>
                                    <v-card-title class="headline">
                                        Затраты
                                    </v-card-title>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="12" md="12">
                                            <v-card elevation="7">
                                                <v-card-text>
                                                    <!--период затрат-->
<!--                                                    <v-menu ref="menuu" v-model="menuu" :close-on-content-click="false" :return-value.sync="datee"
                                                            transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-text-field dense v-model="datee" label="Период затрат" prepend-icon="mdi-calendar" readonly
                                                                          v-bind="attrs" v-on="on"></v-text-field>
                                                        </template>
                                                        <v-date-picker v-model="datee" type="month" no-title scrollable>
                                                            <v-spacer></v-spacer>
                                                            <v-btn text color="primary" @click="menuu = false">Отмена</v-btn>
                                                            <v-btn text color="primary" @click="$refs.menuu.save(datee)">Выбрать</v-btn>
                                                        </v-date-picker>
                                                    </v-menu>-->
                                                    <v-select v-model="monthSelect" :items="months" item-text="stat" item-value="stat"
                                                              label="Период" outlined dense multiple></v-select>
                                                    <!--затраты-->
                                                    <v-text-field type="number" outlined dense v-model="editedItem.zatraty" label="Затраты"></v-text-field>
                                                </v-card-text>
                                            </v-card>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn color="green darken-1" text @click="monthSelectSave()">Сохранить</v-btn>
                                        <v-btn color="green darken-1" text @click="dialogPay = false">Отмена</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <!--выбор файлов-->
                            <v-col cols="12" md="4" class="">
                                <input style="display: none" type="file" id="files" ref="files" multiple v-on:change="handleFilesUpload()"/>
                                <label>Ранее добавленные файлы</label>
                                <v-card outlined>
                                    <v-list dense>
                                        <v-list-item-group color="primary">
                                            <v-list-item v-for="(file, key) in oldFiles" :key="key">
                                                <v-list-item-content @click="readFile(key, file.title, file.mime)">
                                                    {{ file.title }}
                                                </v-list-item-content>
                                                <v-list-item-icon @click="deleteFile(key)">
                                                    <v-icon color="red">mdi-file-remove</v-icon>
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-list-item-group>
                                    </v-list>
                                </v-card>
                            </v-col>
                            <!--Добавить файлы-->
                            <v-col cols="12" md="4" class="">
                                <label>Добавить файлы <v-icon color="green" v-on:click="addFiles()">mdi-file-plus</v-icon></label>
                                <v-card outlined>
                                    <v-list dense>
                                        <v-list-item-group color="primary">
                                            <v-list-item
                                                v-for="(file, key) in files"
                                                :key="key"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title v-text="file.name"></v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    <v-icon color="red" v-on:click="removeFile( key )">mdi-file-remove</v-icon>
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-list-item-group>
                                    </v-list>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                    </v-card>
                </v-dialog>
            </v-toolbar>

        </template>
            //---------------------
        <template v-slot:item="{item}">
            <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs}">
            <tr :class="getstatus(item.status)" @click="editItem(item)" v-on="on">
                        <td>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs}">
                                    <v-icon small left :color="iconColor(item)" v-on="on">{{ icon(item) }}</v-icon>
                                </template>
                                <span>{{iconTableStatus(item)}}</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs}">
                                    <v-icon small left color="red" v-on="on">{{ iconVina(item) }}</v-icon>
                                </template>
                                <span>регресс</span>
                            </v-tooltip>
                        </td>
                <td :class="getid(item.data)">{{ item.data}}</td>
                <td :class="getid(item.data_end)">{{ item.data_end}}</td>
                <td :class="getid(item.prikaz)">{{ item.prikaz}}</td>
                <v-tooltip top>
                    <template v-slot:activator="{ on, attrs}">
                        <td :class="getid(item.zakazchik)" v-on="on">{{ item.short_zakazchik2}}</td>
                    </template>
                    <span>{{ item.zakazchik }}</span>
                </v-tooltip>
                <!--<td :class="getid(item.vid_ts)">{{ item.vid_ts}}</td>-->
                <!--<td :class="getid(item.name_garantiy)">{{ item.name_garantiy}}</td>-->
                <td :class="getid(item.name_vid_gara)">{{ item.name_vid_gara}}</td>
                <td :class="getid(item.prikaz_gar)">{{ item.prikaz_gar}}</td>
                <td :class="getid(item.name_vina)">{{ item.name_vina}}</td>
                <!--<td :class="getid(item.name_ustranen)">{{ item.name_ustranen}}</td>-->
                <v-tooltip top>
                    <template v-slot:activator="{ on, attrs}">
                        <td :class="getid(item.zatraty)" v-on="on">{{ item.zatraty}}</td>
                    </template>
                    <span>период - {{ item.months }}</span>
                </v-tooltip>
                <!--<td :class="getid(item.korrect)">{{ item.short_korrect}}</td>-->
            </tr>
                </template>
                <span>{{ item.name_status }}</span>
            </v-tooltip>
        </template>
            //---------------------
    </v-data-table>
        <!--snackbar затраты-->
    <div class="text-center ma-2">
        <v-snackbar right v-model="snackbar" :timeout="timeout" :color="color" class="align-center">
            {{ label }}  {{ this.razryd(zatratyAll) }}
        </v-snackbar>
    </div>
    </v-container>
</div>
</template>

<script>
    import  axios from 'axios'

    export default {
        data(){
            return{
                monthsView:'период',
                datee:[], //new Date().toISOString().substr(0, 7)
                menuu: false,
                date: null,
                date_end: null,
                menu: false,
                menuEnd: false,
                dialog: false,
                dialogPay: false,
                headers: [
                    {
                        text: '',
                        //align: 'left',
                        /*sortable: false,*/
                        //filterable: false,
                        value: 'id'
                    },
                    { text: 'Начало', value: 'data' },
                    { text: 'Конец', value: 'data_end' },
                    { text: 'Приказ', value: 'prikaz' },
                    { text: 'Контрагент', value: 'short_zakazchik', align: 'center' },
                    /*{ text: 'Навеска', value: 'vid_ts' },
                    { text: 'Гарантия', value: 'name_garantiy' },*/
                    { text: 'Причина ГС', value: 'name_vid_gara' },
                    { text: 'Гара-ый приказ', value: 'prikaz_gar' },
                    { text: 'Виновная сторона', value: 'name_vina' },
                    /*{ text: 'Устранения', value: 'name_ustranen' },*/
                    { text: 'Затраты', value: 'zatraty' },
                    /*{ text: 'Мероприятия', value: 'korrect' },*/
                    /*{ text: 'Статус', value: 'name_status' },*/
                    /*{ text: 'Файлы', value: 'pretenziy', sortable: false },*/
                    /*{ text: '', value: 'actions', sortable: false },*/
                ],
                danye: [],
                editedIndex: -1,
                editedItem: {
                    id: '',
                    data: '',
                    data_end:'',
                    prikaz: '',
                    zakazchik: '',
                    vid_ts: '',
                    name_garantiy:'',
                    name_vid_gara:'',
                    prikaz_gar:'',
                    name_vina:'',
                    name_ustranen:'',
                    zatraty:'',
                    name_status:'',
                    korrect:'',
                    pretenziy:'',
                    flag: null,
                    regression:'',
                    regressionBool:'',
                },
                editsave:'',
                defaultItem: {
                    id: '',
                    data: '',
                    data_end:'',
                    prikaz: '',
                    zakazchik: '',
                    vid_ts: '',
                    name_garantiy:'',
                    name_vid_gara:'',
                    prikaz_gar:'',
                    name_vina:'',
                    name_ustranen:'',
                    zatraty:'',
                    name_status:'',
                    korrect:'',
                    pretenziy:'',
                    flag: null,
                    regression:'',
                    regressionBool:'',
                },
                search:'',
                terror:'',
                itemsPerPage: 20,
                selectgar:'',
                itemsgar:[],
                selectvidgar:'',
                itemsvidgar:[],
                selectstatus:'',
                itemsstatus:[],
                selectvina:'',
                itemsvina:[],
                selectustran:'',
                itemsustran:[],
                oldFiles:[],
                files:[],
                itemStatusSelect:'',//stat: 'В работе'
                itemstatus:[],
                itemStatusSelect_card:'', //stat: 'В работе'
                itemstatus_card:[],
                putFile:'',
                iconPress:'mdi-delete',
                zatratyAll:'0',
                label:'',
                snackbar: true,
                timeout: 0,
                color:'cyan darken-2',
                monthSelect:[],
                months:[
                    {stat: 'Янв', num: '01'},
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
                monthZatratySelect:[],
                monthsZatraty:[
                    {stat: 'Янв', num: '01'},
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
                /*checkbox7: false,*/
                checkbox7: false,
                checkbox8: false,
                checkbox9: false,
                god:'',
                danTest:[],
                paymentsItemsSelect:[],
                paymentsItems:[],
                show: false,
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Новая запись' : 'Редактирование записи №'
            },
            totalSum: function(){
                let sum = 0
                this.danye.forEach(function(item){
                    sum += item.zatraty
                })
                //console.log(sum)
                return sum
            }
        },
        watch: {
            dialog (val) {
                val || this.close()
            }
        },
        created () {
            let date = new Date()
            let god = date.getFullYear()
            this.$store.dispatch('SET_GOD',god)
            this.god = this.$store.getters.GOD
            this.initialize()
        },
        methods: {
            initialize () { //
                axios.post('/axios-send/workStatus',{status: 'trimmed'}).then(respond => {
                    this.itemstatus_card = respond.data
                    this.itemstatus = respond.data
                    //console.log(this.itemStatusSelect_card)
                    let arr = []
                    arr['id']=1
                    arr['name']='В работе'
                    arr['name2']='В работе'
                    arr['deleted_at']=null
                    //console.log(arr)

                    this.itemStatusSelect = arr

                }),
                axios.post('/axios-send/start',{god: this.god}).then(respond => {
                    this.danye = respond.data
                    this.zatratyAll = this.totalSum
                }),
                //this.summaZatraty()
                axios.post('/axios-send/garantiy',{status: 'trimmed'}).then(respond => {
                    this.itemsgar = respond.data
                }),
                    axios.post('/axios-send/vidgarantiy',{status: 'trimmed'}).then(respond => {
                        this.itemsvidgar = respond.data
                    }),
                    axios.post('/axios-send/status',{status: 'trimmed'}).then(respond => {
                        this.itemsstatus = respond.data
                    }),
                axios.post('/axios-send/vina',{status: 'trimmed'}).then(respond => {
                    this.itemsvina = respond.data
                }),
                axios.post('/axios-send/ustran',{status: 'trimmed'}).then(respond => {
                    this.itemsustran = respond.data
                })
            },
            combobox1(){
                this.editedItem.name_garantiy = this.selectgar.name
                this.editedItem.garantiy_id = this.selectgar.id
            },
            combobox2(){
                this.editedItem.name_vid_gara = this.selectvidgar.name
                this.editedItem.vid_garantii = this.selectvidgar.id
            },
            combobox3(){
                this.editedItem.name_status = this.selectstatus.name
                this.editedItem.status = this.selectstatus.id
            },
            combobox4(){
                this.editedItem.name_vina = this.selectvina.name
                this.editedItem.vina_id = this.selectvina.id
            },
            combobox5(){
                this.editedItem.name_ustranen = this.selectustran.name
                this.editedItem.ustranenie_id = this.selectustran.id
            },
            editItem (itemm) {
                this.editedIndex = this.danye.indexOf(itemm)
                this.editedItem = Object.assign({}, itemm)

                this.selectgar = this.editedItem.name_garantiy
                this.selectvidgar = this.editedItem.name_vid_gara
                this.selectstatus = this.editedItem.name_status
                this.selectvina = this.editedItem.name_vina
                this.selectustran = this.editedItem.name_ustranen
                this.itemStatusSelect_card = this.editedItem.name2_flag

                //console.log(this.itemstatus_card)
                //console.log(this.editedItem)
                if (this.editedItem.months != null)
                {
                    this.datee = JSON.parse(this.editedItem.months)
                }
                else
                {
                    this.datee = [] //new Date().toISOString().substr(0, 7)
                }

                //console.log(this.editedItem)
                axios.post('/axios-get/files',{id:itemm.id}).then(respond => {
                    this.oldFiles = respond.data
                })
                axios.post('/axios-get/payments',{id:itemm.id}).then(respond => {
                    this.paymentsItems = respond.data
                })
                //if (this.editedItem.deleted_at === 0) {this.iconPress='mdi-delete'}
                if (this.editedItem.deleted_at != null) {this.itemStatusSelect_card = 'Удалена'}
                if (this.editedItem.flag == 1) {this.itemStatusSelect_card = 'В работе'}
                if (this.editedItem.flag == 2) {this.itemStatusSelect_card = 'Завершена'}
                this.dialog = true
                //console.log(this.itemstatus_card)
            },
            deleteItem (itemm) {
                //console.log(itemm)
                const index = this.danye.indexOf(itemm)
                if (confirm('Вы уверенны в удалении записи?'))
                {
                    axios.post('/axios-send/deleteZapis',{id:this.editedItem.id}).then(respond => {
                        console.log('Удалил!')
                        this.close();
                        axios.post('/axios-send/statusChange',{stat: this.itemStatusSelect.name2, months: this.monthSelect, god: this.god}).then(respond => {
                            this.danye = respond.data
                        })
                    })
                }
            },
            close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
            save1 () {
                this.editedItem.months = this.datee
                //console.log(this.editedItem)
                if (this.editedIndex > -1)
                {
                    Object.assign(this.danye[this.editedIndex], this.editedItem)
                    Object.assign(this.danye[this.editedIndex], this.editedItem)
                } else
                {
                    this.danye.push(this.editedItem)
                }
                this.close();
                //если ID есть то обновление если нет то новая запись
                if (this.editedItem.id)
                {
                    //console.log(this.editedItem)
                    // отправка на сервер изменений
                    axios.post('/axios-send/save', {name: this.editedItem}).then(respond => {
                    })
                    if (this.files.length>0) {
                        console.log(this.files)
                        // отправляем файлы на сервер
                        let formData = new FormData();
                        for (let i = 0; i < this.files.length; i++) {
                            let file = this.files[i];
                            formData.append('files' + i, file);
                        }
                        // добавляем ID
                        formData.append('my_file_id', this.editedItem.id)
                        // отправляем файлы на сервер
                        axios.post('/select-files', formData, {headers: {'Content-Type': 'multipart/form-data'}}
                        ).then(function () {
                            console.log('Отправил!!');
                        })
                            .catch(function () {
                                console.log('Ошибка!!');
                            });
                        // очищаем список файлов
                        this.files = []
                    }
                    if (this.checkbox8 == false)
                    {
                        //console.log('[хммммммм')
                        axios.post('/axios-send/statusChange',{stat: this.itemStatusSelect.name2, months: this.monthSelect, god: this.god}).then(respond => {
                            this.danye = respond.data
                        })
                    }
                    else
                    {
                        axios.post('/axios-send/allEntries', {god: this.god}).then(respond => {
                            //document.getElementById('axios-send').innerHTML = respond.data
                            this.danye = respond.data
                            this.zatratyAll = this.totalSum
                            //this.summaZatraty()
                        })
                    }
                }
                else
                {
                    let id=0
                    // укажем, что в работе
                    this.editedItem.flag = 1
                    // укажем регресс есть или нет
                    this.editedItem.regressionBool = this.editedItem.checkbox9

                    //console.log(this.editedItem)
                    // отправка на сервер изменений
                    axios.post('/axios-send/newSave', {name: this.editedItem}).then(respond => {
                        //document.getElementById('axios-send').innerHTML = respond.data
                        id=respond.data
                        if (this.files.length>0) {
                            console.log(this.files)
                            // отправляем файлы на сервер
                            let formData = new FormData();
                            for (let i = 0; i < this.files.length; i++) {
                                let file = this.files[i];
                                formData.append('files' + i, file);
                            }
                            // добавляем ID
                            formData.append('my_file_id', id)
                            // отправляем файлы на сервер
                            axios.post('/select-files', formData, {headers: {'Content-Type': 'multipart/form-data'}}
                            ).then(function () {
                                console.log('Отправил!!');
                            })
                                .catch(function () {
                                    console.log('Ошибка!!');
                                });
                            // очищаем список файлов
                            this.files = []
                        }
                        axios.post('/axios-send/statusChange',{stat: this.itemStatusSelect.name2, months: this.monthSelect, god: this.god}).then(respond => {
                            /*document.getElementById('axios-send').innerHTML = respond.data*/
                            this.danye = respond.data
                        })
                    });
                }
            },
            save (date) {
                this.$refs.menu.save(date);
                /*this.$refs.picker.activePicker = 'YEAR'*/
                this.menu = false;
            },
            getid(id){
                /*alert('*'+id+'*');*/
                if (id==0 || id=='?' || id==null)
                {
                    return 'noinfo';
                }
            },
            getfile(id){
                return 'file';
            },
            getstatus(status){
                // 2 - не гарантийный
                if (status===2) return 'trstatus';
                // 3 - гарантия не определена
                if (status===3) return 'trstatus1';
            },
            /*trclick(status){
                alert(status)
            },*/
            addFiles(){
                this.$refs.files.click();
            },
            handleFilesUpload(){
                let uploadedFiles = this.$refs.files.files;
                for( let i = 0; i < uploadedFiles.length; i++ ){
                    this.files.push( uploadedFiles[i] );
                    console.log(uploadedFiles[i])
                }
            },
            removeFile( key ){
                this.files.splice( key, 1 );
            },
            readFile(key, fileTitle, fileMime){
                axios.post('/axios-get/readFile', {name:this.oldFiles[key].id}, {responseType: 'blob'})
                    .then(respond => {
                    var fileURL = window.URL.createObjectURL(new Blob([respond.data]));
                    var fileLink = document.createElement('a');
                    fileLink.href = fileURL;
                    fileLink.type = fileMime;
                    fileLink.setAttribute('download', fileTitle);
                    document.body.appendChild(fileLink);
                    fileLink.click();
                });
            },
            deleteFile(key){
               if (confirm('Вы уверенны в удалении файла '+this.oldFiles[key].title+' ?')) {
                   axios.post('/axios/deleteFile',{id:this.oldFiles[key].id}).then(respond => {
                       this.oldFiles.splice(key, 1)
                   })
               }
            },
            statusChange(stat){
                //console.log(stat)
                this.checkbox7 = false
                axios.post('/axios-send/statusChange',{stat: stat.name2, months: this.monthSelect, god: this.god}).then(respond => {
                    this.danye = respond.data
                    this.zatratyAll = this.totalSum
                    //this.summaZatraty()
                })
            },
            statusChange_card(stat, id){
                //alert(stat+' в карте')
                if (this.checkbox8)
                {
                    axios.post('/axios-send/statusChangeCard',{stat: stat.name2, id: id}).then(respond => {
                        axios.post('/axios-send/allEntries', {god: this.god}).then(respond => {
                            //document.getElementById('axios-send').innerHTML = respond.data
                            this.danye = respond.data
                            this.zatratyAll = this.totalSum
                            //this.summaZatraty()
                        })
                    })
                }
                else
                {
                    axios.post('/axios-send/statusChangeCard',{stat: stat.name2, id: id}).then(respond => {
                        axios.post('/axios-send/statusChange',{stat: this.itemStatusSelect.name2, months: this.monthSelect, god: this.god}).then(respond => {
                            /*document.getElementById('axios-send').innerHTML = respond.data*/
                            this.danye = respond.data
                            this.zatratyAll = this.totalSum
                            //this.summaZatraty()
                        })
                    })
                }
                this.close()
                //this.search = ''
            },
            filterYear(god){
                //alert(god)
                axios.post('/axios-send/statusChange',{god: god, months: this.monthSelect, stat: this.itemStatusSelect.name2}).then(respond => {
                    /*document.getElementById('axios-send').innerHTML = respond.data*/
                    this.danye = respond.data
                    this.zatratyAll = this.totalSum
                    //this.summaZatraty()
                })
            },
            newItem(){
                //this.editedItem = {}
                this.oldFiles = []
                this.files = []
                this.selectgar = '?'
                this.editedItem.garantiy_id = 3

                this.selectvidgar = '?'
                this.editedItem.vid_garantii = 8

                this.selectstatus = '?'
                this.editedItem.status = 3

                this.selectvina = '?'
                this.editedItem.vina_id = 6

                this.selectustran = '?'
                this.editedItem.ustranenie_id = 5
                //this.getNDate();
                this.editedItem.data = this.getNDate();
                // костылек, потом поправлю
                let arr = []
                arr['id']=1
                arr['name']='В работе'
                arr['name2']='В работе'
                arr['deleted_at']=null
                this.itemStatusSelect_card = arr
                this.datee = []

            },
            getNDate() {
                /*alert(1)*/
                var today = new Date();

                if ((today.getMonth() + 1) < 10) {
                    var mes = '0' + (today.getMonth() + 1)
                }
                if ((today.getMonth() + 1) > 9) {
                    var mes = (today.getMonth() + 1)
                }
                if ((today.getDate()) < 10) {
                    var day = '0' + today.getDate()
                }
                if ((today.getDate()) > 9) {
                    var day = today.getDate()
                }
                var date = today.getFullYear() + '-' + mes + '-' + day;
                var date1 = today.getFullYear() + '-' + mes + '-' + '01';
                /*var time = today.getHours() + ":" + today.getMinutes() + ":" +
                    today.getSeconds();*/
                return date;

            },
            inExcel(){
                axios.post('/axios-send/inExcel',{stat: this.itemStatusSelect.name2, masiv: '', god: this.god, head: this.headers},{responseType: 'blob'})
                    .then(respond => {
                        var fileURL = window.URL.createObjectURL(new Blob([respond.data]));
                        var fileLink = document.createElement('a');
                        fileLink.href = fileURL;
                        fileLink.type = 'application/vnd.ms-excel';
                        let ft = 'отчет-'+this.itemStatusSelect.name2+'-'+this.god+'.xlsx'
                        fileLink.setAttribute('download', ft);
                        document.body.appendChild(fileLink);
                        fileLink.click();
                        axios.post('/axios/deleteExcel',{ft:ft}).then(respond => {
                            console.log('Готово')
                        })
                })
            },
            razryd(razr){
                let int = String(Math.trunc(razr))
                //alert(int)
                if(int.length <= 3) {
                    this.label = 'Сумма затрат ('+this.itemStatusSelect.name2+') '+this.god+ 'г. - '
                    return int
                }
                let space = 0
                let number = ''

                for(let i = int.length - 1; i >= 0; i--) {
                    if(space === 3) {
                        number = ' ' + number;
                        space = 0
                    }
                    number = int.charAt(i) + number
                    space++
                }
                this.label = 'Сумма затрат ('+this.itemStatusSelect.name2+') '+this.god+ 'г. - '
                return number
            },
            monthChange(months){
                //console.log(months)
                axios.post('/axios-send/selectMonths',{stat: this.itemStatusSelect.name2, months: months,
                    god: this.god, check: this.checkbox7}).then(respond => {
                    this.danye = respond.data
                    this.zatratyAll = this.totalSum
                    //this.summaZatraty()
                })
            },
            icon(item){
                //console.log(item)
                if (item.flag == 1)
                {
                    return 'mdi-run'
                }
                if (item.flag == 2)
                {
                    return 'mdi-hand-okay'//'mdi-check'
                }
                if (item.deleted_at != null)
                {
                    return 'mdi-delete'
                }
            },
            iconVina(item){
                //console.log(item.regression)
                if (item.regressionBool == true )
                {
                    return 'mdi-email-send-outline'
                }
            },
            iconColor(item){
                //console.log(item)
                if (item.flag == 1)
                {
                    return 'blue'
                }
                if (item.flag == 2)
                {
                    return 'green'
                }
                if (item.deleted_at != null)
                {
                    return 'red'
                }
            },
            iconTableStatus(item){
                //console.log(item)
                if (item.flag == 1)
                {
                    return 'В работе'
                }
                if (item.flag == 2)
                {
                    return 'Завершена'
                }
                if (item.deleted_at != null)
                {
                    return 'Удалена'
                }
            },
            statusIcon(text){
                //console.log('statusIcon= '+text+' , '+text.name)
                if (text.name2 == 'В работе' || text == 'В работе')
                {
                    return 'mdi-run'
                }
                if (text.name2 == 'Завершенные' || text == 'Завершена')
                {
                    return 'mdi-hand-okay'//'mdi-check'
                }
                if (text.name2 == 'Удаленные' || text == 'Удалена')
                {
                    return 'mdi-delete'
                }
            },
            check2(stat){
                //console.log(stat)
                if (stat)
                {
                    axios.post('/axios-send/allEntries', {god: this.god}).then(respond => {
                        //document.getElementById('axios-send').innerHTML = respond.data
                        this.danye = respond.data
                        this.zatratyAll = this.totalSum
                        //this.summaZatraty()
                    })
                }
                else
                {
                    axios.post('/axios-send/statusChange',{stat: this.itemStatusSelect.name2, months: this.monthSelect, god: this.god}).then(respond => {
                        //document.getElementById('axios-send').innerHTML = respond.data
                        this.danye = respond.data
                        this.zatratyAll = this.totalSum
                        //this.summaZatraty()
                    })
                }
            },
            check(stat){
                //console.log('check= '+stat)
                axios.post('/axios-send/selectMonths',{stat: this.itemStatusSelect.name2, months: this.monthSelect,
                    god: this.god, check: this.checkbox7}).then(respond => {
                    this.danye = respond.data
                    this.zatratyAll = this.totalSum
                    //this.summaZatraty()
                })
            },
            check3(stat){
                console.log(stat)
            },
            /*summaZatraty(){
                axios.post('/axios-send/summaZatraty',{check2: this.checkbox8, check: this.checkbox7,
                    stat: this.itemStatusSelect.stat, months: this.monthSelect, god: this.god}).then(respond => {
                    /!*document.getElementById('axios-send').innerHTML = respond.data*!/
                    this.zatratyAll=this.razryd(respond.data[0].summa)
                })
            },*/
            zatratyPeriod(zatr){
                //console.log(zatr)
                return 'Затраты в сумме: ' + zatr + ' - указать за какие месяца'
            },
            ok(dat){
                console.log(dat)
            },
            mouseE(item){
                console.log('вошел')
            },
            mouseL(item){
                console.log('вышел')
            },
            monthSelectSave(){
                console.log(this.monthSelect)
            },
        },
    }
</script>

<style scoped>
    .noinfo{
        color: Red;
    }
    .trstatus{
        color: Green;
    }
    .trstatus1{
        color: Blue;
    }
    span.remove-file{
        color: red;
        cursor: pointer;
        float: right;
    }
    div.file-listing{
        width: 200px;
    }
    .file{
        font-size: xx-small;
        color: blue;
    }
</style>

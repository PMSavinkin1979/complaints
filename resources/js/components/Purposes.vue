<template>
    <v-col cols="12" md="4">
        <v-data-table dense :headers="headers" :items="items" sort-by="id" class="elevation-7">
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>{{ title }}</v-toolbar-title>
                    <v-divider
                        class="mx-4"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>

                    <v-dialog v-model="dialog" max-width="500px">
                        <!--Новая запись-->
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                                Новая запись
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="2">
                                            <v-text-field disabled v-model="editedItem.id" label="№"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="5">
                                            <v-text-field v-model="editedItem.name" label="Наименование"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="5">
                                            <v-text-field v-model="editedItem.fakt" label="Выручка"></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="close">Отменить</v-btn>
                                <v-btn color="blue darken-1" text @click="save(editedItem)">Записать</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="headline">{{dialogDeleteText}}</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon v-show="editPencil(item)" small class="mr-2" @click="editItem(item)" color="green">
                    mdi-pencil
                </v-icon>
                <v-icon :right="rigthIcon(item)" small @click="deleteItem(item)" color="red">
                    {{ deleteIcon(item) }}
                </v-icon>
            </template>
            <template v-slot:item.name="{ item }">
                <v-icon v-show="deleteShow(item)" small color="red">mdi-delete-forever-outline</v-icon>
                {{ item.name }}
            </template>
        </v-data-table>
    </v-col>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: '№', value: 'id' },
            { text: 'Наименование', value: 'name' },
            { text: 'Выручка', value: 'fakt' },
            { text: '', value: 'actions' },
        ],
        items: [],
        editedIndex: -1,
        editedItem: {
            name: '',
            id:'',
            koment:'',
        },
        defaultItem: {
            name: '',
            id:'',
            koment:'',
        },
        dialogDeleteText: '',
        idDesabled: false,
        title: 'Выручка',
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'Новая запись' : 'Редактирование'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    created () {
        this.initialize()
    },

    methods: {
        initialize () {
            axios.post('/axios-send/purpose',{status: 'all'}).then(respond => {
                this.items = respond.data
            })
        },

        editItem (item) {
            this.idDesabled = false
            this.editedIndex = this.items.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.editedIndex = this.items.indexOf(item)
            this.editedItem = Object.assign({}, item)
            if (item.deleted_at == null)
            {
                this.dialogDeleteText = 'Пометить на удаление?'
            }
            else
            {
                this.dialogDeleteText = 'Восстановить?'
            }
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            //this.garantiyItems.splice(this.editedIndex, 1)
            axios.post('/axios-send/purposeDelete', {item: this.editedItem}).then(respond => {
                this.items = respond.data
            })
            this.closeDelete()
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        save (item) {
            if (this.editedIndex > -1) {
                Object.assign(this.items[this.editedIndex], this.editedItem)
            } else {
                this.items.push(this.editedItem)
            }
            this.close()
            axios.post('/axios-send/purposeEditOrNew', {item: item}).then(respond => {
                this.items = respond.data
                //console.log(respond.data)
            })
        },
        editPencil(item){
            //console.log(item.deleted_at)
            if (item.deleted_at==null)
            {
                return true
            }
            else
            {
                return false
            }
        },
        deleteIcon(item){
            if (item.deleted_at==null)
            {
                return 'mdi-delete'
            }
            else
            {
                return 'mdi-delete-empty'
            }
        },
        rigthIcon(item){
            if (item.deleted_at==null)
            {
                return false
            }
            else
            {
                return true
            }
        },
        deleteShow(item){
            if (item.deleted_at==null)
            {
                return false
            }
            else
            {
                return true
            }
        },
    },
}
</script>

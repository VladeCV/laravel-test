<template>
    <div>
        <b-table striped hover :items="items" :fields="fields">
            <template #cell(actions)="row">
                <b-button size="sm" @click="editItem(row.item)">Edit</b-button>
            </template>
        </b-table>

        <!-- Edit Modal -->
        <b-modal v-if="currentItem" v-model="showModal" title="Edit Item" @ok="saveItem">
            <b-form @submit.stop.prevent="saveItem">
                <b-form-group label="Name">
                    <b-form-input v-model="currentItem.name" required></b-form-input>
                </b-form-group>

                <b-form-group label="Description">
                    <b-form-textarea v-model="currentItem.description"></b-form-textarea>
                </b-form-group>

                <b-form-group label="Code">
                    <b-form-input v-model="currentItem.code" required></b-form-input>
                </b-form-group>

                <b-form-group label="Status">
                    <b-form-select v-model="currentItem.status" :options="statusOptions"></b-form-select>
                </b-form-group>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
import axios from 'axios';
import {BButton, BForm, BFormGroup, BFormInput, BFormSelect, BFormTextarea, BModal, BTable} from "bootstrap-vue-3";

export default {
    components: {BFormSelect, BFormTextarea, BFormInput, BFormGroup, BForm, BModal, BButton, BTable},
    data() {
        return {
            items: [],
            fields: ['name', 'description', 'code', 'status', { key: 'actions', label: 'Actions' }],
            currentItem: null,
            showModal: false,
            open: false,
            statusOptions: ['active', 'inactive'],
        };
    },
    mounted() {
        this.loginandLoad();
    },
    methods: {
        async loginandLoad() {
            try {
                await axios.get('/sanctum/csrf-cookie');
                await this.loadItems();
            } catch (e) {
                console.error(e);
            }
        },
        async loadItems() {
            try {
                const res = await axios.get('/api/items');
                this.items = res.data.data || res.data;
            } catch (err) {
                console.error(err);
            }
        },
        editItem(item) {
            this.currentItem = { ...item }; // clone to avoid binding issues
            this.showModal = true;
        },
        async saveItem() {
            try {
                const res = await axios.put(`/api/items/${this.currentItem.id}`, this.currentItem);
                const index = this.items.findIndex(i => i.id === this.currentItem.id);
                if (index !== -1) this.items[index] = res.data.data || res.data;
                this.showModal = false;
            } catch (err) {
                console.error(err);
            }
        }
    }
};
</script>

<style scoped>
/* optional styling */
</style>

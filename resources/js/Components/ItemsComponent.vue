<template>
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-sm btn-success" @click="createItem">
            + Create Item
        </button>
    </div>
    <div class="py-4">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Code</th>
                <th>Status</th>
                <th style="width: 160px">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.name }}</td>
                <td>{{ item.description }}</td>
                <td>{{ item.code }}</td>
                <td>{{ item.status }}</td>
                <td class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary" @click="editItem(item)">
                        Edit
                    </button>

                    <button class="btn btn-sm btn-danger" @click="confirmDelete(item)">
                        Delete
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" id="itemModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ isEditing ? 'Edit Item' : 'Create Item' }}
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input class="form-control" v-model="currentItem.name"/>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" v-model="currentItem.description"/>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input class="form-control" v-model="currentItem.code"/>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" v-model="currentItem.status">
                                <option value="active">active</option>
                                <option value="inactive">inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary" @click="saveItem">
                            {{ isEditing ? 'Update' : 'Create' }}
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete "<strong>{{ itemToDelete?.name }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" :disabled="loading">
                            Cancel
                        </button>

                        <button class="btn btn-danger" @click="deleteItem" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import {Modal} from 'bootstrap';


let itemModal = null;
let deleteModalInstance = null;
export default {

    data() {
        return {
            items: [],
            currentItem: {},
            isEditing: false,
            itemToDelete: null,
            loading: false
        };
    },
    mounted() {
        axios.get('/api/items').then(res => {
            this.items = res.data.data || res.data;
        });
        itemModal = new Modal(document.getElementById('itemModal'));
        deleteModalInstance = new Modal(document.getElementById('deleteModal'));
    },
    methods: {
        createItem() {
            this.isEditing = false;
            this.currentItem = {
                name: '',
                description: '',
                code: '',
                status: 'active'
            };
            itemModal.show();
        },
        editItem(item) {
            this.isEditing = true;
            this.currentItem = {...item};
            itemModal.show();
        },
        saveItem() {
            const request = this.isEditing
                ? axios.put(`/api/items/${this.currentItem.id}`, this.currentItem)
                : axios.post('/api/items', this.currentItem);

            request.then(res => {
                if (this.isEditing) {
                    const index = this.items.findIndex(i => i.id === this.currentItem.id);
                    if (index !== -1) this.items[index] = res.data.data || res.data;
                } else {
                    this.items.unshift(res.data.data || res.data);
                }

                itemModal.hide();
            });
        },
        confirmDelete(item) {
            this.itemToDelete = item;
            deleteModalInstance.show();
        },

        deleteItem() {
            if (!this.itemToDelete) return;

            this.loading = true;
            axios.delete(`/api/items/${this.itemToDelete.id}`)
                .then(() => {
                    this.items = this.items.filter(i => i.id !== this.itemToDelete.id);
                    deleteModalInstance.hide();
                })
                .finally(() => {
                    this.loading = false;
                    this.itemToDelete = null;
                });
        }
    }
};
</script>

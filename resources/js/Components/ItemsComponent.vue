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

        <!-- BOOTSTRAP MODAL -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Item</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input class="form-control" v-model="currentItem.name" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" v-model="currentItem.description" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input class="form-control" v-model="currentItem.code" />
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
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';

export default {
    data() {
        return {
            items: [],
            currentItem: {},
            isEditing: false
        };
    },
    mounted() {
        axios.get('/api/items').then(res => {
            this.items = res.data.data || res.data;
        });
    },
    methods: {
        editItem(item) {
            this.currentItem = { ...item };
            const modal = new Modal(document.getElementById('editModal'));
            modal.show();
        },
        saveItem() {
            axios.put(`/api/items/${this.currentItem.id}`, this.currentItem)
                .then(res => {
                    const index = this.items.findIndex(i => i.id === this.currentItem.id);
                    if (index !== -1) this.items[index] = res.data.data || res.data;
                    Modal.getInstance(document.getElementById('editModal')).hide();
                });
        },
        createItem() {

        },
    }
};
</script>

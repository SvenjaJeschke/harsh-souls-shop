<template>
    <v-card class="ma-6">
        <v-card-title>
            User management
            <v-spacer />
            <v-btn text color="secondary" @click="showCreateUserDialog = true">
                Create user
            </v-btn>
        </v-card-title>
        <v-card-subtitle>
            Users who can access the admin area.
        </v-card-subtitle>
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="users"
                :options.sync="pagination"
                :loading="isLoading"
                :server-items-length="totalUsers"
                :footer-props="{
                    itemsPerPageOptions: [10, 20, 50, 100, 200]
                }"
            >
                <template v-slot:item.created_at="{ item }">
                    {{ formatDate(item.created_at) }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <edit-user-dialog
                        v-model="showEditUserDialog"
                        :user="item"
                        @updated="getUsers"
                    />
                    <delete-user-button
                        :user-id="item.id"
                        @deleted="getUsers"
                    />
                    <change-user-password-dialog :current-user="item" />
                </template>
            </v-data-table>
        </v-card-text>
        <create-user-dialog
            v-model="showCreateUserDialog"
            @created="getUsers"
        />
    </v-card>
</template>

<script>
import dayjs from 'dayjs';
import DeleteUserButton from '../../components/userActionButtons/DeleteUserButton';
import ChangeUserPasswordDialog from '../../components/userActionButtons/ChangeUserPasswordDialog';
import EditUserDialog from '../../components/userActionButtons/EditUserDialog';
import CreateUserDialog from '../../components/CreateUserDialog';

export default {
    name: 'UserManagement',
    components: {
        'edit-user-dialog': EditUserDialog,
        'delete-user-button': DeleteUserButton,
        'change-user-password-dialog': ChangeUserPasswordDialog,
        'create-user-dialog': CreateUserDialog
    },
    data() {
        return {
            headers: [
                { text: 'Name', value: 'username' },
                { text: 'Created', value: 'created_at' },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false,
                    width: '15%'
                }
            ],
            users: [],
            pagination: {},
            isLoading: false,
            totalUsers: 0,
            showCreateUserDialog: false,
            showEditUserDialog: false
        };
    },
    watch: {
        pagination: {
            handler() {
                this.getUsers();
            },
            deep: true
        }
    },
    methods: {
        getUsers() {
            this.isLoading = true;
            this.$http
                .get('/api/admin/users', { params: this.pagination })
                .then((response) => {
                    this.users = response.data.data;
                    this.totalUsers = response.data.total;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        formatDate(date) {
            return dayjs(date).format('MMMM D, YYYY hh:mm');
        }
    }
};
</script>

<style scoped></style>

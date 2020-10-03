<template>
    <v-tooltip bottom>
        <template v-slot:activator="{ on }">
            <v-btn icon color="error" v-on="on" @click.stop="confirmDelete">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </template>
        Delete
    </v-tooltip>
</template>

<script>
export default {
    name: 'DeleteUserButton',
    props: {
        user: {
            type: Object,
            required: true,
            default: () => ({
                id: null,
                username: null
            })
        }
    },
    methods: {
        confirmDelete() {
            this.$root
                .$confirm(
                    'Delete user',
                    `Do you really want to delete the user ${this.user.username}?`
                )
                .then((confirm) => {
                    if (confirm) {
                        this.deleteUser();
                    }
                });
        },
        deleteUser() {
            this.$http
                .delete(`/api/admin/users/${this.user.id}`)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('deleted');
                });
        }
    }
};
</script>

<style scoped></style>

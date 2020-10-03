<template>
    <v-dialog v-model="show" persistent max-width="900">
        <template v-slot:activator="{ on: dialog }">
            <v-tooltip bottom>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn
                        icon
                        color="primary"
                        v-on="{ ...tooltip, ...dialog }"
                    >
                        <v-icon small>fa-pen</v-icon>
                    </v-btn>
                </template>
                Edit
            </v-tooltip>
        </template>
        <v-card v-if="editUser">
            <v-card-title>
                Edit user {{ user.username }}
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    label="Username"
                    v-model="editUser.username"
                    :error="!!errorMessages.username"
                    :error-messages="errorMessages.username"
                />
                <v-text-field
                    label="E-Mail"
                    v-model="editUser.email"
                    :error="!!errorMessages.email"
                    :error-messages="errorMessages.email"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <v-btn
                            text
                            :disabled="!hasChanges"
                            v-on="on"
                            @click="revertChanges"
                        >
                            Revert changes
                        </v-btn>
                    </template>
                    You can only revert changes that are not saved yet.
                </v-tooltip>
                <v-btn
                    text
                    color="secondary"
                    :loading="isLoading"
                    :disabled="isLoading"
                    @click="update"
                >
                    Save changes
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'EditUserButton',
    props: {
        value: {
            type: Boolean,
            default: false
        },
        user: {
            type: Object,
            required: true,
            default: () => ({
                id: null,
                username: null,
                email: null
            })
        }
    },
    data() {
        return {
            editUser: null,
            show: false,
            isLoading: false,
            errorMessages: {}
        };
    },
    computed: {
        hasChanges() {
            return (
                this.editUser.username !== this.user.username ||
                this.editUser.email !== this.user.email
            );
        }
    },
    created() {
        this.editUser = this.copy(this.user);
    },
    watch: {
        value(value) {
            this.show = value;
        },
        show(value) {
            this.$emit('input', value);
        },
        user(value) {
            this.editUser = this.copy(value);
        }
    },
    methods: {
        close() {
            this.editUser = this.user;
            this.errorMessages = {};
            this.show = false;
        },
        revertChanges() {
            this.errorMessages = {};
            this.editUser = this.copy(this.user);
        },
        update() {
            this.isLoading = true;
            this.errorMessages = {};
            this.$http
                .put(`/api/admin/users/${this.user.id}`, this.editUser)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.close();
                    this.$emit('updated');
                })
                .catch((error) => {
                    this.errorMessages = error.response.data.errors;
                    this.$root.$emit('snackbar', error.response.data.message);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped></style>

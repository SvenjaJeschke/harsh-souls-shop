<template>
    <v-card flat>
        <v-card-title>
            Product Versions
            <v-spacer></v-spacer>
            <v-btn
                text
                color="secondary"
                @click="showCreateModal = true"
            >
                Create Version
            </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
            <v-row>
                <v-col
                    md="4"
                    v-for="version in product.versions"
                    :key="version.id"
                >
                    <version-card
                        :version="version"
                        :product="product"
                        @versions-changed="$emit('versions-changed')"
                    ></version-card>
                </v-col>
            </v-row>
        </v-card-text>
        <create-version-dialog
            :product="product"
            v-model="showCreateModal"
            @versions-changed="$emit('versions-changed')"
        ></create-version-dialog>
    </v-card>
</template>

<script>
import VersionCard from "./parts/VersionCard";
import CreateVersionDialog from "./parts/CreateVersionDialog";

export default {
    name: "Versions",
    components: {
        'version-card': VersionCard,
        'create-version-dialog': CreateVersionDialog
    },
    props: {
        product: {
            type: Object,
            required: true,
            default: {
                id: null,
                display_name: '',
                description: '',
                price: '',
                is_active: false,
                created_at: '',
                updated_at: '',
                deleted_at: '',
                discount: null,
                categories: [],
                versions: [],
                images: []
            }
        }
    },
    data() {
        return {
            showCreateModal: false
        };
    }
}
</script>

<style scoped>

</style>

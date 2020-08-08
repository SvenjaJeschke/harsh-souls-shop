<template>
    <v-color-picker
        :value="value || '#ffffff'"
        :error="error"
        :error-messages="errorMessage"
        hide-mode-switch
        hide-inputs
        :swatches-max-height="maxSwatchesHeight ? 400 : 150"
        hide-canvas
        show-swatches
        disabled
        width="auto"
        mode="hexa"
        @input="$emit('input', $event)"
    />
</template>

<script>
export default {
    name: 'ColorPickerSwatches',
    props: {
        value: {
            type: String,
            required: false,
            default: null
        },
        error: {
            type: Boolean,
            required: false,
            default: false
        },
        errorMessage: {
            type: String,
            required: false,
            default: null
        },
        maxSwatchesHeight: {
            type: Boolean,
            required: false,
            default: false
        }
    }
};
</script>

<style scoped></style>

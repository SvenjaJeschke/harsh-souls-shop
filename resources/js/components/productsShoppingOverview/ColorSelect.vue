<template>
    <div>
        <span class="subtitle-1">Colors</span>
        <color-picker-swatches
            :value="value"
            @input="$emit('input', $event)"
            max-swatches-height
        />
    </div>
</template>

<script>
import ColorPickerSwatches from '../ColorPickerSwatches';

export default {
    name: 'ColorSelect',
    components: {
        'color-picker-swatches': ColorPickerSwatches
    },
    props: {
        value: {
            type: String,
            required: false,
            default: null
        }
    }
};
</script>

<style scoped></style>

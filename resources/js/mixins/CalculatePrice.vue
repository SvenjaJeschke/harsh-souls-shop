<script>
export default {
    name: 'CalculatePrice',
    computed: {
        price() {
            if (!this.selection.version && !this.selection.size) return;
            let price = parseFloat(this.product.price);
            if (
                this.selection.version &&
                this.selection.version.operator &&
                this.selection.version.price_adjustment
            ) {
                const versionPriceAdjustment = parseFloat(
                    this.selection.version.price_adjustment
                );
                if (this.selection.version.operator === '+') {
                    price += versionPriceAdjustment;
                }
                if (this.selection.version.operator === '-') {
                    price -= versionPriceAdjustment;
                }
            }
            if (
                this.selection.size &&
                this.selection.size.operator &&
                this.selection.size.price_adjustment
            ) {
                const sizePriceAdjustment = parseFloat(
                    this.selection.size.price_adjustment
                );
                if (this.selection.size.operator === '+') {
                    price += sizePriceAdjustment;
                }
                if (this.selection.size.operator === '-') {
                    price -= sizePriceAdjustment;
                }
            }
            return (price * this.selection.amount).toFixed(2);
        }
    }
};
</script>

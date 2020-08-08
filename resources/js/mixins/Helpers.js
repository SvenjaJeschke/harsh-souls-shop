export default {
    methods: {
        copy(value) {
            return JSON.parse(JSON.stringify(value));
        },
        isColor(string) {
            const s = new Option().style;
            s.color = string;
            return s.color !== '';
        }
    }
};

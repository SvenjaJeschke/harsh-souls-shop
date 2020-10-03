// Helpers.js aka all the stuff that I took from StackOverflow
export default {
    methods: {
        copy(value) {
            return JSON.parse(JSON.stringify(value));
        },
        isColor(string) {
            const s = new Option().style;
            s.color = string;
            return s.color !== '';
        },
        hasWhiteSpace(string) {
            return /\s/g.test(string);
        },
        addQueryParams(params) {
            history.pushState(
                {},
                null,
                this.$route.path +
                    '?' +
                    Object.keys(params)
                        .map((key) => {
                            return (
                                encodeURIComponent(key) +
                                '=' +
                                encodeURIComponent(params[key])
                            );
                        })
                        .join('&')
            );
        },
        setQuery(query) {
            let obj = Object.assign({}, this.$route.query);

            Object.keys(query).forEach((key) => {
                let value = query[key];
                if (value) {
                    obj[key] = value;
                } else {
                    delete obj[key];
                }
            });
            this.$router
                .replace({
                    ...this.$router.currentRoute,
                    query: obj
                })
                .catch(() => {});
        },
        handleServerError(error) {
            this.$root.$emit(
                'snackbar',
                'Sorry, there was an internal server error. Please reload the page.'
            );
        }
    }
};

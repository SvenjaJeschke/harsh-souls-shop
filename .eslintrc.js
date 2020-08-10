module.exports = {
    env: {
        browser: true,
        es6: true,
        commonjs: true
    },
    extends: ['eslint:recommended', 'plugin:vue/essential'],
    globals: {
        Atomics: 'readonly',
        SharedArrayBuffer: 'readonly'
    },
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: 'module',
        parser: 'babel-eslint'
    },
    plugins: ['vue', 'prettier'],
    rules: {
        'vue/no-v-html': 'off',
        'prettier/prettier': [
            'warn',
            {
                singleQuote: true,
                semi: true,
                trailingComma: 'none',
                endOfLine: 'auto'
            }
        ],
        'vue/html-self-closing': [
            'warn',
            {
                html: {
                    void: 'always',
                    normal: 'always',
                    component: 'always'
                },
                svg: 'any',
                math: 'always'
            }
        ]
    }
};

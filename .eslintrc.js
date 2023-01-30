module.exports = {
    parserOptions: {
        requireConfigFile: false,
        parser: '@babel/eslint-parser',
        sourceType: 'module',
        allowImportExportEverywhere: true,
        ecmaVersion: 2020
    },
    extends: [
        'plugin:vue/vue3-recommended',
    ],
    rules: {
        'indent': [
            'warn',
            4
        ],
        'vue/html-indent': [
            'warn',
            4
        ],
        'jsx-quotes': [
            'error',
            'prefer-double'
        ],
        'linebreak-style': [
            'error',
            'unix'
        ],
        'quotes': [
            'warn',
            'single'
        ],
        'semi': [
            'warn',
            'never'
        ],
        'vue/sort-keys': 'off',
        'vue/static-class-names-order': 'off',
        'vue/no-v-html': 'off',
        'vue/require-valid-default-prop': 'off',
        'vue/require-explicit-emits': 'off',
        'vue/no-multiple-template-root': 'off'
    },
}

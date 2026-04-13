import js from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'

export default [
    js.configs.recommended,
    ...pluginVue.configs['flat/recommended'],
    {
        rules: {
            'indent': ['warn', 4],
            'vue/html-indent': ['warn', 4],
            'jsx-quotes': ['error', 'prefer-double'],
            'linebreak-style': ['error', 'unix'],
            'quotes': ['warn', 'single'],
            'semi': ['warn', 'never'],
            'vue/sort-keys': 'off',
            'vue/static-class-names-order': 'off',
            'vue/no-v-html': 'off',
            'vue/require-valid-default-prop': 'off',
            'vue/require-explicit-emits': 'off',
            'vue/no-multiple-template-root': 'off',
            // Rules not present in eslint-plugin-vue v7 (pre-migration) — disabled to preserve old behavior
            'vue/multi-word-component-names': 'off',
            'vue/valid-define-emits': 'off',
            // js.configs.recommended adds no-unused-vars; was not enabled pre-migration
            'no-unused-vars': 'off',
        },
    },
]

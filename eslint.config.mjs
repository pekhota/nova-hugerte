/* eslint.config.mjs  – ESLint 9 · Flat Config · Vue 3 + StandardJS */
import { defineConfig } from 'eslint/config';
import standard from '@aarongoldenthal/eslint-config-standard/recommended';
import vuePlugin from 'eslint-plugin-vue';
import vueParser from 'vue-eslint-parser';

export default defineConfig([
    // --- Base rule-sets ---------------------------------
    ...standard,                               // StandardJS rules
    ...vuePlugin.configs['flat/essential'],    // Vue 3 essential flat preset

    // --- Project-specific overrides ---------------------
    {
        files: ['resources/js/components/**/*.{vue,js}'],

        languageOptions: {
            parser: vueParser,
            parserOptions: {
                ecmaVersion: 'latest',
                sourceType: 'module',
            },
        },

        plugins: { vue: vuePlugin },

        rules: {
        },
    },
]);

# Bun Migration + Toolchain Update Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Migrate frontend package manager from npm/yarn to bun and upgrade dev tooling: ESLint 7→9 (flat config), husky 4→9, lint-staged 11→15.

**Architecture:** Pure configuration migration — no application code changes. Replace `.eslintrc.js` with `eslint.config.mjs` (ESLint flat config), move husky hooks from `package.json` to `.husky/pre-commit`, swap lock file from `package-lock.json` to `bun.lockb`.

**Tech Stack:** bun, ESLint 9, eslint-plugin-vue 9, @eslint/js 9, husky 9, lint-staged 15, sass (latest minor)

---

### Task 1: Update package.json

**Files:**
- Modify: `package.json`

- [ ] **Step 1: Update `package.json` — replace the entire file content**

```json
{
    "private": true,
    "name": "larave-vue3-spa-skeleton",
    "packageManager": "bun@latest",
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "lint": "eslint resources/js --max-warnings=0",
        "lint-fix": "eslint resources/js --fix --max-warnings=0"
    },
    "lint-staged": {
        "*.{js,vue}": [
            "eslint --fix --max-warnings=0"
        ],
        "*.php": [
            "./vendor/bin/pint --dirty"
        ]
    },
    "devDependencies": {
        "@eslint/js": "^9.0.0",
        "eslint": "^9.0.0",
        "eslint-plugin-vue": "^9.0.0",
        "husky": "^9.0.0",
        "lint-staged": "^15.0.0",
        "sass": "^1.86.0"
    },
    "dependencies": {
        "@element-plus/icons-vue": "^2.3.2",
        "@fortawesome/fontawesome-free": "^7.2",
        "@vitejs/plugin-vue": "^6.0",
        "@vue/compiler-sfc": "^3.5",
        "@websanova/vue-auth": "^4.2",
        "axios": "1.15",
        "dayjs": "^1.11",
        "element-plus": "^2.13",
        "laravel-vite-plugin": "^3.0",
        "lodash": "^4.17.19",
        "pinia": "^3.0",
        "postcss": "^8.5",
        "vite": "^8.0",
        "vue": "3.5.32",
        "vue-axios": "^3.5.2",
        "vue-i18n": "^11.3.2",
        "vue-router": "^5.0.4"
    }
}
```

Note: `resolve-url-loader` removed (webpack-only, unused in Vite). `@babel/core`, `@babel/eslint-parser` removed (not needed for ESLint 9 + Vue). `husky.hooks` block removed (moved to `.husky/pre-commit`).

- [ ] **Step 2: Commit**

```bash
git add package.json
git commit -m "chore: update package.json for bun and toolchain upgrade"
```

---

### Task 2: Update .gitignore

**Files:**
- Modify: `.gitignore`

- [ ] **Step 1: Add `package-lock.json` and `bun-error.log` to `.gitignore`**

Append these two lines at the end of `.gitignore`:
```
package-lock.json
bun-error.log
```

- [ ] **Step 2: Commit**

```bash
git add .gitignore
git commit -m "chore: add package-lock.json and bun-error.log to gitignore"
```

---

### Task 3: Replace ESLint config

**Files:**
- Delete: `.eslintrc.js`
- Create: `eslint.config.mjs`

- [ ] **Step 1: Delete `.eslintrc.js`**

```bash
rm .eslintrc.js
```

- [ ] **Step 2: Create `eslint.config.mjs`**

```js
// eslint.config.mjs
import js from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'

export default [
    js.configs.recommended,
    ...pluginVue.configs['flat/vue3-recommended'],
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
        },
    },
]
```

- [ ] **Step 3: Commit**

```bash
git add eslint.config.mjs
git rm .eslintrc.js
git commit -m "chore: migrate ESLint config to flat config (eslint.config.mjs)"
```

---

### Task 4: Install dependencies with bun

**Files:**
- Delete: `package-lock.json`
- Generated: `bun.lockb`

- [ ] **Step 1: Remove `package-lock.json` and `node_modules`**

```bash
rm package-lock.json
rm -rf node_modules
```

- [ ] **Step 2: Install with bun**

```bash
bun install
```

Expected: bun resolves all dependencies and generates `bun.lockb`.

- [ ] **Step 3: Commit `bun.lockb`**

```bash
git add bun.lockb
git commit -m "chore: switch to bun, add bun.lockb"
```

---

### Task 5: Setup husky v9

**Files:**
- Create: `.husky/pre-commit`

- [ ] **Step 1: Initialize husky**

```bash
bunx husky init
```

Expected: creates `.husky/pre-commit` with default content.

- [ ] **Step 2: Replace `.husky/pre-commit` content**

```bash
echo 'bunx lint-staged' > .husky/pre-commit
```

- [ ] **Step 3: Verify the file is executable and has correct content**

```bash
cat .husky/pre-commit
```

Expected output:
```
bunx lint-staged
```

- [ ] **Step 4: Commit**

```bash
git add .husky/
git commit -m "chore: setup husky v9 pre-commit hook"
```

---

### Task 6: Verify everything works

- [ ] **Step 1: Run lint to verify ESLint 9 + flat config works**

```bash
bun run lint
```

Expected: exits with 0 warnings/errors (or only pre-existing warnings).

- [ ] **Step 2: Run build to verify Vite still works**

```bash
bun run build
```

Expected: successful build output in `public/build/`.

- [ ] **Step 3: Final commit if any fixes were needed**

If lint produced new warnings/errors that need fixing, fix them and commit:
```bash
bun run lint-fix
git add -p
git commit -m "chore: fix lint issues after ESLint 9 migration"
```

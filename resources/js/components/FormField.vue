<template>
    <DefaultField
        :errors="errors"
        :field="currentField"
        :full-width-content="fullWidthContent"
        :show-help-text="showHelpText"
    >
        <template #field>
            <div class="relative" @mouseenter="prefetchEditor">
                <!-- LAZY STATE: textarea + dim overlay -->
                <Transition name="fade-scale">
                    <div v-if="!editorVisible" key="lazy" class="relative">
                        <textarea
                            :id="uuidLocal"
                            class="w-full form-control form-input form-input-bordered"
                            :placeholder="currentField.name"
                            :disabled="currentField.readonly"
                            v-model="value"
                            style="min-height: 180px;"
                        />
                        <!-- Slightly dark overlay (click to enable) -->
                        <div
                            v-if="isLazy && !currentField.readonly"
                            class="lazy-overlay"
                            role="button"
                            tabindex="0"
                            aria-label="Enable rich text editor"
                            title="Enable rich text editor"
                            @click.stop.prevent="mountEditorNow"
                            @keydown.enter.stop.prevent="mountEditorNow"
                            @keydown.space.stop.prevent="mountEditorNow"
                        >
                            <div class="lazy-overlay__label">
                                <svg width="14" height="14" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
                                </svg>
                                Click to enable rich editor
                            </div>
                        </div>
                    </div>
                </Transition>

                <!-- EAGER or AFTER LAZY MOUNT -->
                <Transition name="fade-scale">
                    <component
                        v-if="editorVisible"
                        key="editor"
                        :is="Editor"
                        :id="uuidLocal"
                        v-model="value"
                        :disabled="currentField.readonly"
                        :init="currentField.options.init"
                        :placeholder="currentField.name"
                        :plugins="currentField.options.plugins"
                        :toolbar="currentField.options.toolbar"
                    />
                </Transition>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { DependentFormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [DependentFormField, HandlesValidationErrors],
    props: ['resourceName', 'resourceId', 'options'],

    data() {
        return {
            value: this.currentField?.value ?? '',
            Editor: null,
            editorVisible: false,
            uuidLocal: this.makeUuid(this.currentField?.attribute || this.field?.attribute),
            prefetchDone: false,
        }
    },

    created() {
        this.ensureOptions()
        this.setupProtectContent()
        this.setEditorTheme()
    },

    mounted() {

        console.log("is lazy", this.isLazy);

        if (!this.isLazy) {
            this.mountEditorNow() // eager behavior
        }
    },

    computed: {
        // IMPORTANT: read from currentField (reactive), fallback to field, default false (eager) if absent
        isLazy() {
            const cf = this.currentField?.options?.lazy
            const f = this.field?.options?.lazy
            return typeof cf !== 'undefined' ? !!cf : (typeof f !== 'undefined' ? !!f : false)
        },
    },

    watch: {
        // If meta changes at runtime (dependent fields), respect new lazy flag:
        'currentField.options.lazy'(val) {
            // If it flips from true -> false and editor isn't mounted yet, mount it
            if (val === false && !this.editorVisible) {
                this.mountEditorNow()
            }
        },
    },

    methods: {
        ensureOptions() {
            // normalize via currentField first
            if (!this.currentField?.options) this.currentField.options = {}
            const opts = this.currentField.options
            if (!opts.init) opts.init = {}
            if (!opts.plugins) opts.plugins = []
            if (!opts.toolbar) opts.toolbar = []
            if (!opts.init.skin) opts.init.skin = 'oxide'
        },

        makeUuid(seed = '') {
            const s = (seed || '') + '-' + Math.random().toString(36).slice(2, 10)
            return `hugerte-${s}`
        },

        async ensureEditorLoaded() {
            if (this.Editor) return
            const mod = await import(/* webpackChunkName: "hugerte-vue" */ '@hugerte/hugerte-vue')
            this.Editor = mod.default
        },

        async prefetchEditor() {
            if (!this.isLazy || this.prefetchDone || this.editorVisible) return
            this.prefetchDone = true
            try { await this.ensureEditorLoaded() } catch (_) {}
        },

        async mountEditorNow() {
            if (this.editorVisible) return
            await this.ensureEditorLoaded()
            this.editorVisible = true
        },

        setupProtectContent() {
            const init = this.currentField?.options?.init
            if (init?.protect && Array.isArray(init.protect)) {
                init.protect = init.protect.map((regex) => {
                    const exp = regex.match(/^([/~@;%#'])(.*?)\1([gimsuy]*)$/)
                    if (exp) return new RegExp(exp[2], exp[3])
                    return new RegExp(regex.replace(/^\/+|\/+$/gm, ''))
                })
            }
        },

        setEditorTheme() {
            const init = this.currentField.options.init
            const selected = localStorage.novaTheme
            const set = (dark) => {
                init.skin = dark ? 'oxide-dark' : 'oxide'
                init.content_css = dark ? 'dark' : 'default'
            }

            if (typeof selected !== 'undefined') {
                if (selected === 'system') {
                    this.setSystemMode()
                } else {
                    set(selected === 'dark')
                }
            } else {
                this.setSystemMode()
            }
        },

        setSystemMode() {
            const prefersDark =
                window.matchMedia('(prefers-color-scheme: dark)').matches ||
                document.querySelector('html')?.classList?.contains('dark')

            const init = this.currentField.options.init
            init.skin = prefersDark ? 'oxide-dark' : 'oxide'
            init.content_css = prefersDark ? 'dark' : 'default'
        },

        fill(formData) {
            formData.append(this.currentField.attribute, this.value || '')
        },
    },
}
</script>

<style scoped>
/* Smooth in/out for mounting */
.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: opacity 120ms ease, transform 120ms ease;
}
.fade-scale-enter-from,
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.98);
}

/* Dim overlay that keeps text readable underneath */
.lazy-overlay {
    position: absolute;
    inset: 0;
    background: rgba(17, 24, 39, 0.42);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
    cursor: pointer;
    user-select: none;
    -webkit-backdrop-filter: blur(1px) saturate(140%);
    backdrop-filter: blur(1px) saturate(140%);
}

.lazy-overlay__label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    line-height: 1;
    color: #fff;
    padding: 8px 12px;
    border-radius: 6px;
    background: rgba(17, 24, 39, 0.85);
    border: 1px solid rgba(255, 255, 255, 0.35);
    box-shadow: 0 2px 4px rgba(0,0,0,0.35);
    font-weight: 600;
}

.lazy-overlay__label svg {
    display: inline-block;
    fill: currentColor;
}

@media (prefers-reduced-motion: reduce) {
    .fade-scale-enter-active,
    .fade-scale-leave-active {
        transition: none;
    }
}
</style>

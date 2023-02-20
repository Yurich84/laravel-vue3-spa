import { ref } from 'vue'
import { defineStore } from 'pinia'

const collapsed = window.innerWidth <= 768

export const useBaseStore = defineStore('base', () => {
    const isCollapsed = ref(collapsed)
    function toggleCollapse() {
        isCollapsed.value = !isCollapsed.value
    }

    return { isCollapsed, toggleCollapse }
})

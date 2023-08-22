import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useOpenMenuStore = defineStore('openMenu', () => {
    const open = ref(true);

    function toogleMenu() {
        open.value = !open.value
    }

    return { open, toogleMenu }
})

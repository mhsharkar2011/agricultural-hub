<template>
    <div>
        <!-- Parent Item -->
        <Link
            :href="path"
            class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-green-50 transition group"
            :class="active ? 'bg-green-50 text-green-700' : 'text-gray-700'"
            @click="toggleSubMenu"
        >
            <div class="flex items-center space-x-2">
                <i :class="`fas ${icon} ${active ? 'text-green-600' : 'text-gray-500'}`"></i>
                <span>{{ label }}</span>
            </div>
            <i v-if="subItems && subItems.length"
               :class="[isOpen ? 'fa-chevron-down' : 'fa-chevron-right', 'fas text-xs text-gray-400 transition']">
            </i>
        </Link>

        <!-- Sub Items -->
        <div v-if="subItems && subItems.length && isOpen" class="ml-8 mt-1 space-y-1">
            <Link
                v-for="item in subItems"
                :key="item.path"
                :href="item.path"
                class="block px-3 py-1.5 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition"
            >
                {{ item.label }}
            </Link>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    icon: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    path: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    },
    subItems: {
        type: Array,
        default: () => []
    }
});

const isOpen = ref(false);

const toggleSubMenu = () => {
    if (props.subItems && props.subItems.length) {
        isOpen.value = !isOpen.value;
    }
};
</script>

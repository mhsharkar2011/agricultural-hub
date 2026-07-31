<template>
    <aside class="w-64 bg-white shadow-lg min-h-screen border-r border-gray-200">
        <div class="p-6">
            <!-- User Info -->
            <div class="flex items-center space-x-3 mb-6 pb-6 border-b border-gray-200">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-user text-2xl text-green-600"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-800">{{ user?.name || 'Guest' }}</div>
                    <div class="text-sm text-gray-500">{{ user?.email || '' }}</div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                <SidebarItem
                    v-for="item in menuItems"
                    :key="item.path"
                    :icon="item.icon"
                    :label="item.label"
                    :path="item.path"
                    :active="isActive(item.path)"
                    :subItems="item.subItems"
                />
            </nav>

            <!-- Logout Button -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <button @click="logout" class="w-full flex items-center space-x-2 text-red-600 hover:bg-red-50 px-3 py-2 rounded-lg transition">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import SidebarItem from './SidebarItem.vue';

const props = defineProps({
    user: {
        type: Object,
        default: null
    }
});

const menuItems = [
    {
        icon: 'fa-chart-line',
        label: 'Dashboard',
        path: '/dashboard'
    },
    {
        icon: 'fa-book-open',
        label: 'Guides',
        path: '/guides',
        subItems: [
            { label: 'All Guides', path: '/guides' },
            { label: 'Create Guide', path: '/guides/create' },
        ]
    },
    {
        icon: 'fa-seedling',
        label: 'Crops',
        path: '/crops',
        subItems: [
            { label: 'All Crops', path: '/crops' },
            { label: 'Add Crop', path: '/crops/create' },
        ]
    },
    {
        icon: 'fa-bug',
        label: 'Pest Control',
        path: '/pest-control',
        subItems: [
            { label: 'Strategies', path: '/pest-control' },
            { label: 'Add Strategy', path: '/pest-control/create' },
        ]
    },
    {
        icon: 'fa-envelope',
        label: 'Messages',
        path: '/messages'
    },
    {
        icon: 'fa-user-cog',
        label: 'Profile',
        path: '/profile'
    },
    {
        icon: 'fa-cog',
        label: 'Settings',
        path: '/settings'
    },
];

const isActive = (path) => {
    return window.location.pathname === path;
};

const logout = () => {
    router.post(route('logout'));
};
</script>

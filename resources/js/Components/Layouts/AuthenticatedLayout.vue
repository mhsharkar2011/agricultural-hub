<template>
    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <Sidebar :user="user" />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Navigation Bar -->
            <nav class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button @click="toggleSidebar" class="lg:hidden text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">{{ pageTitle }}</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-600 hidden md:block">{{ user?.name }}</span>
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center overflow-hidden">
                                <img
                                    v-if="user?.profile_photo"
                                    :src="'/storage/' + user.profile_photo"
                                    class="w-full h-full object-cover"
                                >
                                <i v-else class="fas fa-user text-green-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Sidebar from '../Sidebar.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const pageTitle = computed(() => {
    const path = window.location.pathname;
    const titles = {
        '/dashboard': 'Dashboard',
        '/guides': 'Guides',
        '/crops': 'Crops',
        '/pest-control': 'Pest Control',
        '/messages': 'Messages',
        '/profile': 'Profile',
        '/settings': 'Settings'
    };
    return titles[path] || 'AgriHub';
});

const isSidebarOpen = ref(true);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

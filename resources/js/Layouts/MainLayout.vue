<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Main Menu -->
        <MainMenu :auth="auth" />

        <div class="flex">
            <!-- Sidebar (only for authenticated users) -->
            <Sidebar v-if="isAuthenticated" :user="auth?.user" class="hidden md:block" />

            <!-- Main Content -->
            <main class="flex-1 p-6">
                <slot />
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between flex-wrap text-sm text-gray-500">
                    <span>© 2026 AgriHub · Agricultural Information Hub</span>
                    <span>
                        <i class="fas fa-code mr-2"></i>
                        Laravel · Inertia · Vue 3 · Tailwind CSS
                    </span>
                    <span><i class="fas fa-seedling mr-1"></i> growing knowledge together</span>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import MainMenu from '@/Components/Navigation/MainMenu.vue';
import Sidebar from '@/Components/Navigation/Sidebar.vue';

const props = defineProps({
    auth: {
        type: Object,
        default: () => ({ user: null })
    }
});

const isAuthenticated = computed(() => !!props.auth?.user);
</script>

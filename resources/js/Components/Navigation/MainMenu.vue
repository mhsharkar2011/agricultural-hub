<template>
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <Link href="/" class="flex items-center space-x-2">
                    <i class="fas fa-seedling text-green-600 text-2xl"></i>
                    <span class="text-xl font-bold text-green-800">AgriHub</span>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <Link href="/" :class="[isActive('/') ? 'text-green-600' : 'text-gray-600', 'hover:text-green-600 transition']">
                        <i class="fas fa-home mr-1"></i> Home
                    </Link>
                    <Link href="/guides" :class="[isActive('/guides') ? 'text-green-600' : 'text-gray-600', 'hover:text-green-600 transition']">
                        <i class="fas fa-book-open mr-1"></i> Guides
                    </Link>
                    <Link href="/crops" :class="[isActive('/crops') ? 'text-green-600' : 'text-gray-600', 'hover:text-green-600 transition']">
                        <i class="fas fa-seedling mr-1"></i> Crops
                    </Link>
                    <Link href="/pest-control" :class="[isActive('/pest-control') ? 'text-green-600' : 'text-gray-600', 'hover:text-green-600 transition']">
                        <i class="fas fa-bug mr-1"></i> Pest Control
                    </Link>
                    <Link href="/contact" :class="[isActive('/contact') ? 'text-green-600' : 'text-gray-600', 'hover:text-green-600 transition']">
                        <i class="fas fa-envelope mr-1"></i> Contact
                    </Link>

                    <!-- Auth Links -->
                    <template v-if="isAuthenticated">
                        <Link href="/dashboard" class="bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition">
                            <i class="fas fa-user mr-1"></i> Dashboard
                        </Link>
                        <button @click="logout" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </template>
                    <template v-else>
                        <Link href="/login" class="text-green-600 hover:text-green-800">
                            Login
                        </Link>
                        <Link href="/register" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            Register
                        </Link>
                    </template>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 hover:text-green-600">
                    <i :class="mobileMenuOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div v-if="mobileMenuOpen" class="md:hidden py-4 border-t border-gray-200">
                <div class="flex flex-col space-y-3">
                    <Link href="/" class="text-gray-600 hover:text-green-600 transition">Home</Link>
                    <Link href="/guides" class="text-gray-600 hover:text-green-600 transition">Guides</Link>
                    <Link href="/crops" class="text-gray-600 hover:text-green-600 transition">Crops</Link>
                    <Link href="/pest-control" class="text-gray-600 hover:text-green-600 transition">Pest Control</Link>
                    <Link href="/contact" class="text-gray-600 hover:text-green-600 transition">Contact</Link>

                    <template v-if="isAuthenticated">
                        <Link href="/dashboard" class="text-green-600 font-medium">Dashboard</Link>
                        <button @click="logout" class="text-red-600 text-left">Logout</button>
                    </template>
                    <template v-else>
                        <Link href="/login" class="text-green-600">Login</Link>
                        <Link href="/register" class="bg-green-600 text-white px-4 py-2 rounded-lg text-center hover:bg-green-700 transition">
                            Register
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    auth: {
        type: Object,
        default: () => ({ user: null })
    }
});

const mobileMenuOpen = ref(false);
const isAuthenticated = computed(() => !!props.auth?.user);

const isActive = (path) => {
    return window.location.pathname === path;
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <header class="flex flex-wrap justify-between items-center mb-10 border-b-2 border-green-100 pb-6">
                <div>
                    <h1 class="text-4xl font-bold text-green-800">
                        <i class="fas fa-seedling text-green-600 mr-2"></i>AgriHub
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Agricultural Information Hub · knowledge for growing</p>
                </div>
                <div class="bg-green-50 px-6 py-2 rounded-full text-sm font-medium text-green-700">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                    Featured: farming guides, crop details, pest control
                </div>
            </header>

            <!-- Featured Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div v-for="(feature, index) in features" :key="index"
                     class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-6 border border-gray-100">
                    <div :class="`text-3xl mb-3 text-${feature.color}-600`">
                        <i :class="`fas ${feature.icon}`"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ feature.title }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ feature.description }}</p>
                </div>
            </div>

            <!-- Farming Guides -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-green-800 mb-4">
                    <i class="fas fa-book-open mr-2"></i>Farming Guides
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="guide in guides" :key="guide.id"
                         class="bg-white p-4 rounded-lg shadow border border-gray-100">
                        <h3 class="font-semibold text-gray-800">{{ guide.title }}</h3>
                        <p class="text-gray-600 text-sm">{{ guide.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Crop Details -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-green-800 mb-4">
                    <i class="fas fa-seedling mr-2"></i>Crop Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="crop in crops" :key="crop.id"
                         class="bg-white p-4 rounded-lg shadow border border-gray-100">
                        <h3 class="font-semibold text-gray-800">{{ crop.name }}</h3>
                        <p class="text-gray-600 text-sm">{{ crop.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Pest Control -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-green-800 mb-4">
                    <i class="fas fa-bug mr-2"></i>Pest Control
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="strategy in pestStrategies" :key="strategy.id"
                         class="bg-white p-4 rounded-lg shadow border border-gray-100">
                        <h3 class="font-semibold text-gray-800">{{ strategy.title }}</h3>
                        <p class="text-gray-600 text-sm">{{ strategy.description }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="mb-12 bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <h2 class="text-2xl font-bold text-green-800 mb-4">
                    <i class="fas fa-headset mr-2"></i>Contact Us
                </h2>
                <form @submit.prevent="handleSubmit" class="max-w-md">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input v-model="form.name" type="text"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input v-model="form.email" type="email"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                        <textarea v-model="form.message" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500"></textarea>
                    </div>
                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Tech Specs -->
            <div class="mt-12 bg-gray-100 rounded-3xl p-6 border border-gray-200">
                <div class="flex flex-wrap justify-between items-center text-sm text-gray-700">
                    <span><i class="fas fa-code mr-2"></i> Laravel 11 · Vue 3 · Tailwind CSS</span>
                    <span><i class="fas fa-layer-group mr-2"></i> Vite · Pinia · Axios</span>
                    <span><i class="fas fa-globe mr-2"></i> Cross‑browser & optimized</span>
                    <span class="bg-green-100 px-4 py-1 rounded-full text-green-700 font-medium">
                        <i class="fas fa-bolt mr-1"></i> Fast loading
                    </span>
                </div>
            </div>

            <hr class="my-6 border-dashed border-green-200" />

            <footer class="flex justify-between flex-wrap text-xs text-gray-500">
                <span>© 2026 AgriHub · Agricultural Information Hub</span>
                <span><i class="fas fa-seedling mr-1"></i> growing knowledge together</span>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
// Remove store import if it's causing issues
// import { useAgriculturalStore } from '../store/index.js'

// Sample data (remove this and use store when ready)
const features = [
    { icon: 'fa-book-open', title: 'Farming Guides', description: 'Step‑by‑step tutorials & best practices', color: 'green' },
    { icon: 'fa-seedling', title: 'Crop Details', description: 'Varieties, soil, harvest & nutrition', color: 'emerald' },
    { icon: 'fa-bug', title: 'Pest Control', description: 'IPM, biological & organic remedies', color: 'amber' },
    { icon: 'fa-headset', title: 'Expert Advice', description: 'Contact form & extension services', color: 'blue' }
];

const guides = ref([
    { id: 1, title: 'Organic Farming Basics', description: 'Learn the fundamentals of organic farming' },
    { id: 2, title: 'Soil Management', description: 'Best practices for soil health' },
    { id: 3, title: 'Irrigation Techniques', description: 'Efficient water management' }
]);

const crops = ref([
    { id: 1, name: 'Rice', description: 'Varieties, planting, harvesting' },
    { id: 2, name: 'Wheat', description: 'Nutritional requirements' },
    { id: 3, name: 'Maize', description: 'Pest management' }
]);

const pestStrategies = ref([
    { id: 1, title: 'Biological Control', description: 'Natural predators for pest management' },
    { id: 2, title: 'Organic Pesticides', description: 'Natural and organic solutions' },
    { id: 3, title: 'Integrated Pest Management', description: 'IPM strategies' }
]);

const form = reactive({
    name: '',
    email: '',
    message: ''
});

// const store = useAgriculturalStore() // Uncomment when store is ready

// onMounted(() => {
//     store.fetchGuides()
//     store.fetchCrops()
//     store.fetchPestStrategies()
// })

const handleSubmit = () => {
    console.log('Form submitted:', form);
    // Reset form
    form.name = '';
    form.email = '';
    form.message = '';
    alert('Message sent successfully!');
};
</script>

<style scoped>
/* Component-specific styles if any */
</style>

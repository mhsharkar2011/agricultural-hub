<template>
    <MainLayout>
        <div class="container mx-auto px-4 py-8">
            <!-- Hero Section -->
            <section class="text-center mb-12">
                <h1 class="text-5xl font-bold text-green-800 mb-4">
                    <i class="fas fa-seedling text-green-600 mr-3"></i>
                    Welcome to AgriHub
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Your comprehensive agricultural information hub for farming guides,
                    crop details, and pest control strategies.
                </p>
            </section>

            <!-- Featured Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <FeatureCard
                    v-for="feature in features"
                    :key="feature.id"
                    :icon="feature.icon"
                    :title="feature.title"
                    :description="feature.description"
                    :color="feature.color"
                />
            </div>

            <!-- Farming Guides -->
            <section v-if="guides.length" class="mb-12">
                <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-book-open mr-2"></i>
                    Farming Guides
                    <Link href="/guides" class="ml-4 text-sm text-green-600 hover:text-green-800">
                        View All →
                    </Link>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="guide in guides" :key="guide.id"
                         class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-800">{{ guide.title }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ guide.description }}</p>
                        <Link :href="`/guides/${guide.id}`"
                              class="text-green-600 text-sm mt-2 inline-block hover:text-green-800">
                            Learn More →
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Crop Details -->
            <section v-if="crops.length" class="mb-12">
                <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-seedling mr-2"></i>
                    Crop Details
                    <Link href="/crops" class="ml-4 text-sm text-green-600 hover:text-green-800">
                        View All →
                    </Link>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="crop in crops" :key="crop.id"
                         class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-800">{{ crop.name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ crop.description }}</p>
                        <span class="text-xs text-green-600 mt-2 block">Variety: {{ crop.variety || 'Various' }}</span>
                    </div>
                </div>
            </section>

            <!-- Pest Control -->
            <section v-if="pestStrategies.length" class="mb-12">
                <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-bug mr-2"></i>
                    Pest Control Strategies
                    <Link href="/pest-control" class="ml-4 text-sm text-green-600 hover:text-green-800">
                        View All →
                    </Link>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-for="strategy in pestStrategies" :key="strategy.id"
                         class="bg-white p-4 rounded-lg shadow border border-gray-100 hover:shadow-md transition">
                        <h3 class="font-semibold text-gray-800">{{ strategy.title }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ strategy.description }}</p>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full mt-2 inline-block">
                            {{ strategy.type || 'General' }}
                        </span>
                    </div>
                </div>
            </section>

            <!-- Contact Section -->
            <section class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <h2 class="text-2xl font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-headset mr-2"></i>
                    Get in Touch
                </h2>
                <p class="text-gray-600 mb-4">Have questions or need expert advice? We're here to help!</p>
                <Link href="/contact"
                      class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Contact Us Now
                </Link>
            </section>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import FeatureCard from '@/Components/FeatureCard.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    guides: {
        type: Array,
        default: () => []
    },
    crops: {
        type: Array,
        default: () => []
    },
    pestStrategies: {
        type: Array,
        default: () => []
    }
});

const features = [
    {
        id: 1,
        icon: 'fa-book-open',
        title: 'Farming Guides',
        description: 'Step‑by‑step tutorials & best practices',
        color: 'green'
    },
    {
        id: 2,
        icon: 'fa-seedling',
        title: 'Crop Details',
        description: 'Varieties, soil, harvest & nutrition',
        color: 'emerald'
    },
    {
        id: 3,
        icon: 'fa-bug',
        title: 'Pest Control',
        description: 'IPM, biological & organic remedies',
        color: 'amber'
    },
    {
        id: 4,
        icon: 'fa-headset',
        title: 'Expert Advice',
        description: 'Contact form & extension services',
        color: 'blue'
    }
];
</script>

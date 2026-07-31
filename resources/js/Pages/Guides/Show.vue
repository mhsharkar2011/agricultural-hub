<template>
    <MainLayout :auth="$page.props.auth">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <!-- Back Button -->
            <Link href="/guides" class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-6">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Guides
            </Link>

            <!-- Article -->
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Featured Image -->
                <div v-if="guide.image_url" class="w-full h-96 bg-cover bg-center"
                     :style="{ backgroundImage: `url(${guide.image_url})` }">
                </div>
                <div v-else class="w-full h-96 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                    <i class="fas fa-seedling text-white text-6xl"></i>
                </div>

                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <div class="flex items-center space-x-4 text-sm text-gray-500 mb-3">
                            <span>
                                <i class="fas fa-user mr-1"></i>
                                {{ guide.user?.name || 'Unknown' }}
                            </span>
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                {{ new Date(guide.created_at).toLocaleDateString() }}
                            </span>
                            <span>
                                <i class="fas fa-clock mr-1"></i>
                                {{ guide.reading_time }}
                            </span>
                            <span>
                                <i class="fas fa-eye mr-1"></i>
                                {{ guide.views }} views
                            </span>
                            <span :class="{
                                'bg-yellow-100 text-yellow-800': guide.status === 'draft',
                                'bg-green-100 text-green-800': guide.status === 'published',
                                'bg-gray-100 text-gray-800': guide.status === 'archived',
                            }" class="px-2 py-1 rounded-full text-xs font-medium">
                                {{ guide.status }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ guide.title }}</h1>
                        <p class="text-gray-600 mt-2">{{ guide.description }}</p>
                        <div v-if="guide.category" class="mt-3">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                <i class="fas fa-tag mr-1"></i>
                                {{ guide.category }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-green max-w-none">
                        <div v-html="guide.content"></div>
                    </div>

                    <!-- Actions -->
                    <div v-if="$page.props.auth.user.id === guide.user_id" class="mt-8 pt-6 border-t border-gray-200 flex space-x-4">
                        <Link :href="`/guides/${guide.id}/edit`"
                              class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Guide
                        </Link>
                        <button @click="deleteGuide" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Guide
                        </button>
                    </div>
                </div>
            </article>

            <!-- Related Guides -->
            <div v-if="relatedGuides.length" class="mt-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-book-open mr-2"></i>
                    Related Guides
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <Link v-for="related in relatedGuides" :key="related.id"
                          :href="`/guides/${related.id}`"
                          class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800">{{ related.title }}</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ related.description.substring(0, 60) }}...</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    guide: {
        type: Object,
        required: true
    },
    relatedGuides: {
        type: Array,
        default: () => []
    }
});

const deleteGuide = () => {
    if (confirm('Are you sure you want to delete this guide?')) {
        router.delete(`/guides/${props.guide.id}`);
    }
};
</script>

<template>
    <MainLayout :auth="$page.props.auth">
        <div class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-green-800">
                        <i class="fas fa-book-open mr-2"></i>
                        Farming Guides
                    </h1>
                    <p class="text-gray-600 mt-1">Manage your agricultural guides</p>
                </div>
                <Link href="/guides/create"
                      class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Create Guide
                </Link>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Search guides..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            @input="applyFilters"
                        />
                    </div>
                    <div>
                        <select
                            v-model="filters.category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            @change="applyFilters"
                        >
                            <option value="">All Categories</option>
                            <option v-for="category in categories" :key="category" :value="category">
                                {{ category }}
                            </option>
                        </select>
                    </div>
                    <div>
                        <select
                            v-model="filters.status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            @change="applyFilters"
                        >
                            <option value="">All Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div>
                        <button @click="resetFilters" class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div v-if="selectedGuides.length" class="bg-green-50 rounded-lg p-3 mb-4 flex items-center justify-between">
                <span class="text-sm text-green-700">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ selectedGuides.length }} guide(s) selected
                </span>
                <div class="flex space-x-2">
                    <select v-model="bulkStatus" class="px-3 py-1 border border-gray-300 rounded-lg text-sm">
                        <option value="">Change Status</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                        <option value="archived">Archived</option>
                    </select>
                    <button @click="applyBulkAction" class="bg-green-600 text-white px-4 py-1 rounded-lg hover:bg-green-700 transition text-sm">
                        Apply
                    </button>
                    <button @click="clearSelection" class="bg-gray-200 text-gray-700 px-4 py-1 rounded-lg hover:bg-gray-300 transition text-sm">
                        Clear
                    </button>
                </div>
            </div>

            <!-- Guides Grid -->
            <div v-if="guides.data.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="guide in guides.data" :key="guide.id"
                     class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div v-if="guide.image_url" class="h-48 bg-cover bg-center"
                         :style="{ backgroundImage: `url(${guide.image_url})` }">
                    </div>
                    <div v-else class="h-48 bg-gradient-to-r from-green-400 to-green-600 flex items-center justify-center">
                        <i class="fas fa-seedling text-white text-4xl"></i>
                    </div>

                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <Link :href="`/guides/${guide.id}`" class="block">
                                    <h3 class="text-xl font-semibold text-gray-800 hover:text-green-600 transition">
                                        {{ guide.title }}
                                    </h3>
                                </Link>
                                <p class="text-gray-600 text-sm mt-1">{{ guide.description }}</p>
                            </div>
                            <input
                                type="checkbox"
                                :value="guide.id"
                                v-model="selectedGuides"
                                class="ml-4 mt-1 w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                            />
                        </div>

                        <div class="mt-4 flex flex-wrap items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>
                                    <i class="fas fa-user mr-1"></i>
                                    {{ guide.user?.name || 'Unknown' }}
                                </span>
                                <span>
                                    <i class="fas fa-eye mr-1"></i>
                                    {{ guide.views }}
                                </span>
                                <span>
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ new Date(guide.created_at).toLocaleDateString() }}
                                </span>
                            </div>
                            <span :class="{
                                'bg-yellow-100 text-yellow-800': guide.status === 'draft',
                                'bg-green-100 text-green-800': guide.status === 'published',
                                'bg-gray-100 text-gray-800': guide.status === 'archived',
                            }" class="px-2 py-1 rounded-full text-xs font-medium">
                                {{ guide.status }}
                            </span>
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <Link :href="`/guides/${guide.id}/edit`"
                                  class="text-blue-600 hover:text-blue-800 text-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </Link>
                            <button @click="deleteGuide(guide.id)"
                                    class="text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-12">
                <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600">No guides found</h3>
                <p class="text-gray-500 mt-2">Start by creating your first farming guide</p>
                <Link href="/guides/create"
                      class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-plus mr-2"></i>
                    Create Guide
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="guides.links" class="mt-6 flex justify-center">
                <div class="flex space-x-1">
                    <Link v-for="link in guides.links" :key="link.label"
                          :href="link.url || '#'"
                          :class="{
                              'px-3 py-1 border rounded-lg hover:bg-green-50 transition': true,
                              'bg-green-600 text-white border-green-600': link.active,
                              'text-gray-500 cursor-not-allowed': !link.url,
                          }"
                          v-html="link.label">
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { ref, reactive, watch } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    guides: {
        type: Object,
        required: true
    },
    filters: {
        type: Object,
        default: () => ({})
    },
    categories: {
        type: Array,
        default: () => []
    }
});

const selectedGuides = ref([]);
const bulkStatus = ref('');
const searchTimeout = ref(null);

const filters = reactive({
    search: props.filters.search || '',
    category: props.filters.category || '',
    status: props.filters.status || '',
});

const applyFilters = () => {
    clearTimeout(searchTimeout.value);
    searchTimeout.value = setTimeout(() => {
        router.get('/guides', filters, {
            preserveState: true,
            preserveScroll: true,
        });
    }, 300);
};

const resetFilters = () => {
    filters.search = '';
    filters.category = '';
    filters.status = '';
    applyFilters();
};

const clearSelection = () => {
    selectedGuides.value = [];
};

const applyBulkAction = () => {
    if (!bulkStatus.value || !selectedGuides.value.length) {
        return;
    }

    if (confirm(`Apply '${bulkStatus.value}' status to ${selectedGuides.value.length} guide(s)?`)) {
        router.post('/guides/bulk-update', {
            ids: selectedGuides.value,
            status: bulkStatus.value,
        }, {
            onSuccess: () => {
                selectedGuides.value = [];
                bulkStatus.value = '';
            }
        });
    }
};

const deleteGuide = (id) => {
    if (confirm('Are you sure you want to delete this guide?')) {
        router.delete(`/guides/${id}`);
    }
};
</script>

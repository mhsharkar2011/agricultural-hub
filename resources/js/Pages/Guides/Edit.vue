<template>
    <MainLayout :auth="$page.props.auth">
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-green-800">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Guide
                    </h1>
                    <p class="text-gray-600 mt-1">Update your agricultural guide</p>
                </div>
                <Link href="/guides" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Guides
                </Link>
            </div>

            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md p-6">
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input
                            v-model="form.title"
                            type="text"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Enter guide title"
                        />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select
                            v-model="form.category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                            <option value="">Select Category</option>
                            <option value="Organic Farming">Organic Farming</option>
                            <option value="Crop Management">Crop Management</option>
                            <option value="Soil Health">Soil Health</option>
                            <option value="Irrigation">Irrigation</option>
                            <option value="Pest Control">Pest Control</option>
                            <option value="Harvesting">Harvesting</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Other">Other</option>
                        </select>
                        <p v-if="form.errors.category" class="mt-1 text-sm text-red-600">{{ form.errors.category }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="Brief description of the guide"
                        ></textarea>
                        <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
                        <textarea
                            v-model="form.content"
                            rows="12"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent font-mono"
                            placeholder="Write your guide content here..."
                        ></textarea>
                        <p v-if="form.errors.content" class="mt-1 text-sm text-red-600">{{ form.errors.content }}</p>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                        <input
                            v-model="form.image_url"
                            type="url"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            placeholder="https://example.com/image.jpg"
                        />
                        <p v-if="form.image_url" class="mt-2">
                            <img :src="form.image_url" alt="Preview" class="max-h-40 rounded-lg border" />
                        </p>
                        <p v-if="form.errors.image_url" class="mt-1 text-sm text-red-600">{{ form.errors.image_url }}</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select
                            v-model="form.status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                        <p v-if="form.errors.status" class="mt-1 text-sm text-red-600">{{ form.errors.status }}</p>
                    </div>

                    <!-- Published Date -->
                    <div v-if="form.status === 'published'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Published Date</label>
                        <input
                            v-model="form.published_at"
                            type="datetime-local"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        />
                        <p v-if="form.errors.published_at" class="mt-1 text-sm text-red-600">{{ form.errors.published_at }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 pt-6 border-t border-gray-200 flex space-x-4">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition disabled:opacity-50"
                    >
                        {{ form.processing ? 'Updating...' : 'Update Guide' }}
                    </button>
                    <Link href="/guides" class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition text-center">
                        Cancel
                    </Link>
                </div>
            </form>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    guide: {
        type: Object,
        required: true
    }
});

const form = useForm({
    title: props.guide.title,
    description: props.guide.description,
    content: props.guide.content,
    category: props.guide.category || '',
    image_url: props.guide.image_url || '',
    status: props.guide.status,
    published_at: props.guide.published_at ? new Date(props.guide.published_at).toISOString().slice(0, 16) : null,
});

const submit = () => {
    form.put(`/guides/${props.guide.id}`);
};
</script>

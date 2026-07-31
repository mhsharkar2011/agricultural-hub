<template>
    <MainLayout :auth="$page.props.auth">
        <div class="container mx-auto">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-chart-line text-green-600 mr-2"></i>
                    Dashboard
                </h1>
                <p class="text-gray-600">Welcome back, {{ $page.props.auth.user.name }}!</p>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Guides</p>
                            <p class="text-2xl font-bold text-gray-800">{{ stats.guides }}</p>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-book-open text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Crops</p>
                            <p class="text-2xl font-bold text-gray-800">{{ stats.crops }}</p>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-seedling text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pest Strategies</p>
                            <p class="text-2xl font-bold text-gray-800">{{ stats.pestStrategies }}</p>
                        </div>
                        <div class="bg-amber-100 p-3 rounded-full">
                            <i class="fas fa-bug text-amber-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Messages</p>
                            <p class="text-2xl font-bold text-gray-800">{{ stats.inquiries }}</p>
                        </div>
                        <div class="bg-purple-100 p-3 rounded-full">
                            <i class="fas fa-envelope text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-clock text-gray-500 mr-2"></i>
                    Recent Activity
                </h2>
                <div v-if="recentActivities.length" class="space-y-3">
                    <div v-for="activity in recentActivities" :key="activity.id"
                         class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">{{ activity.name }}</p>
                            <p class="text-sm text-gray-500">{{ activity.message }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ new Date(activity.created_at).toLocaleDateString() }}</span>
                    </div>
                </div>
                <p v-else class="text-gray-500 text-center py-4">No recent activity</p>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            guides: 0,
            crops: 0,
            pestStrategies: 0,
            inquiries: 0
        })
    },
    recentActivities: {
        type: Array,
        default: () => []
    }
});
</script>

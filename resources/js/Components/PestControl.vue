<template>
    <div class="mt-12">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-shield-halved text-3xl text-green-600"></i>
            <h2 class="text-3xl font-bold text-gray-800">Pest Control Strategies</h2>
        </div>
        <p class="text-gray-600 mb-6 pl-2 border-l-4 border-green-400 pl-4 bg-green-50/50 py-2 rounded-r-xl">
            Integrated Pest Management (IPM) · biological controls & organic remedies
        </p>

        <div v-if="store.loading" class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-3xl text-green-600"></i>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="strategy in strategies" :key="strategy.id"
                 class="bg-green-50 p-6 rounded-2xl border-l-4 border-green-500">
                <strong class="block text-lg text-gray-800 mb-1">
                    <i class="fas" :class="getIcon(strategy.type)"></i>
                    {{ strategy.title }}
                </strong>
                <p class="text-gray-600 text-sm">{{ strategy.description }}</p>
            </div>
        </div>

        <p class="mt-4 text-sm text-gray-600">
            <i class="fas fa-chevron-right text-green-600 mr-1"></i>
            Tips for monitoring, early detection & effective treatment of pest infestations.
        </p>
    </div>
</template>

<script>
import { useAgriculturalStore } from '../store/index.js'

export default {
    props: {
        strategies: Array
    },
    setup() {
        const store = useAgriculturalStore()
        return { store }
    },
    methods: {
        getIcon(type) {
            const icons = {
                monitoring: 'fa-binoculars',
                biological: 'fa-bacteria',
                organic: 'fa-spa',
                treatment: 'fa-notes-medical'
            }
            return icons[type] || 'fa-shield'
        }
    }
}
</script>

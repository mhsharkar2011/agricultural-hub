<template>
    <div class="mt-12">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-apple-alt text-3xl text-green-600"></i>
            <h2 class="text-3xl font-bold text-gray-800">Crop Details</h2>
        </div>
        <p class="text-gray-600 mb-6 pl-2 border-l-4 border-green-400 pl-4 bg-green-50/50 py-2 rounded-r-xl">
            Comprehensive info · grains, fruits, vegetables, cash crops
        </p>

        <div v-if="store.loading" class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-3xl text-green-600"></i>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="crop in crops" :key="crop.id"
                 class="bg-white p-6 rounded-2xl border border-gray-200 hover:border-green-300 transition-all">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-seedling text-green-600"></i>
                    {{ crop.name }}
                </h4>
                <p class="text-gray-600 text-sm mt-2">{{ crop.description }}</p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs">
                    <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full">
                        <i class="fas fa-clock mr-1"></i> {{ crop.harvest_time || 'N/A' }}
                    </span>
                    <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full">
                        <i class="fas fa-sun mr-1"></i> {{ crop.soil_requirements || 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        <p class="mt-4 text-sm text-gray-600">
            <i class="fas fa-chevron-right text-green-600 mr-1"></i>
            Detailed profiles with images, nutritional values & potential uses.
        </p>
    </div>
</template>

<script>
import { useAgriculturalStore } from '../store/index.js'

export default {
    props: {
        crops: Array
    },
    setup() {
        const store = useAgriculturalStore()
        return { store }
    }
}
</script>

<template>
    <div class="mt-12">
        <div class="flex items-center gap-3 mb-2">
            <i class="fas fa-tractor text-3xl text-green-600"></i>
            <h2 class="text-3xl font-bold text-gray-800">Farming Guides</h2>
        </div>
        <p class="text-gray-600 mb-6 pl-2 border-l-4 border-green-400 pl-4 bg-green-50/50 py-2 rounded-r-xl">
            Collection of guides & tutorials · categorized by crop, season, method
        </p>

        <div v-if="store.loading" class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-3xl text-green-600"></i>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="guide in guides" :key="guide.id"
                 class="bg-white p-6 rounded-2xl border border-gray-200 hover:border-green-300 transition-all">
                <h4 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-leaf text-green-600"></i>
                    {{ guide.title }}
                </h4>
                <p class="text-gray-600 text-sm mt-2">{{ guide.description }}</p>
                <span class="inline-block mt-3 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-medium">
                    {{ guide.category }}
                </span>
            </div>
        </div>

        <p class="mt-4 text-sm text-gray-600">
            <i class="fas fa-chevron-right text-green-600 mr-1"></i>
            Detailed step‑by‑step instructions, tips & best practices for effective farming.
        </p>
    </div>
</template>

<script>
import { useAgriculturalStore } from '../store/index.js'

export default {
    props: {
        guides: Array
    },
    setup() {
        const store = useAgriculturalStore()
        return { store }
    }
}
</script>

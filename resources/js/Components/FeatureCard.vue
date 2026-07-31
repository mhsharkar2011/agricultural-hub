<template>
    <div class="bg-green-50 p-6 rounded-3xl border border-green-100 hover:border-green-300 hover:bg-green-50/80 transition-all hover:-translate-y-1 shadow-sm">
        <i :class="`fas ${icon} text-3xl text-${color}-600 mb-3`"></i>
        <h3 class="text-xl font-semibold text-gray-800 mb-1">{{ title }}</h3>
        <p class="text-gray-600 text-sm">{{ description }}</p>
    </div>
</template>

<script>
export default {
    props: {
        icon: String,
        title: String,
        description: String,
        color: {
            type: String,
            default: 'green'
        }
    }
}
</script>

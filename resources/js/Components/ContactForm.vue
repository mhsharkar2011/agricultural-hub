<template>
    <div class="mt-12 bg-green-50 rounded-3xl p-8 border border-green-100">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3 mb-2">
            <i class="fas fa-envelope text-green-600"></i> Contact & inquiries
        </h3>
        <p class="text-gray-600 mb-6">Submit inquiries, seek advice, or request additional information from agricultural experts.</p>

        <form @submit.prevent="handleSubmit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="far fa-user mr-1"></i> Full name
                    </label>
                    <input v-model="form.name" type="text" required
                           class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="far fa-envelope mr-1"></i> Email address
                    </label>
                    <input v-model="form.email" type="email" required
                           class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-graduation-cap mr-1"></i> Area of expertise
                    </label>
                    <select v-model="form.expertise" required
                            class="w-full px-4 py-2 rounded-full border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition">
                        <option value="general">General advice</option>
                        <option value="crops">Crop management</option>
                        <option value="pest">Pest control</option>
                        <option value="soil">Soil & fertilizer</option>
                        <option value="irrigation">Irrigation</option>
                    </select>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="far fa-comment mr-1"></i> Message / question
                    </label>
                    <textarea v-model="form.message" required rows="4"
                              class="w-full px-4 py-2 rounded-2xl border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition resize-y">
                    </textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-paperclip mr-1"></i> Attach image or document (optional)
                    </label>
                    <input ref="fileInput" type="file" @change="handleFileUpload"
                           accept="image/*,.pdf,.doc,.docx"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-500 mt-1">Share images or documents for better assistance.</p>
                </div>

                <button type="submit" :disabled="store.loading"
                        class="w-full md:w-auto bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-8 rounded-full transition disabled:opacity-50">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ store.loading ? 'Submitting...' : 'Submit inquiry' }}
                </button>
            </div>
        </form>

        <!-- Success Message -->
        <div v-if="successMessage" class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
            <i class="fas fa-check-circle mr-2"></i> {{ successMessage }}
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ errorMessage }}
        </div>

        <!-- Contact Info Sidebar -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-2xl border border-green-100">
            <div>
                <h4 class="font-semibold text-gray-800 mb-2"><i class="fas fa-phone-alt text-green-600 mr-2"></i> Direct contact</h4>
                <p class="text-sm text-gray-600"><i class="fas fa-headset mr-2"></i> Agricultural extension services</p>
                <p class="text-sm text-gray-600"><i class="fas fa-clock mr-2"></i> Mon–Fri 8:00 – 17:00</p>
            </div>
            <div>
                <p class="text-sm text-gray-600"><i class="fas fa-envelope mr-2"></i> support@agrihub.org</p>
                <p class="text-sm text-gray-600"><i class="fas fa-phone mr-2"></i> +1 (800) 555‑0174</p>
                <p class="text-sm text-gray-600 mt-2 pt-2 border-t border-gray-200">
                    <i class="fas fa-comment-dots text-green-600 mr-2"></i> We respond within 24h.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, reactive } from 'vue'
import { useAgriculturalStore } from '../store/index.js'

export default {
    emits: ['submitted'],
    setup(_, { emit }) {
        const store = useAgriculturalStore()
        const fileInput = ref(null)
        const successMessage = ref('')
        const errorMessage = ref('')

        const form = reactive({
            name: '',
            email: '',
            expertise: 'general',
            message: '',
            attachment: null
        })

        const handleFileUpload = (event) => {
            const file = event.target.files[0]
            if (file) {
                form.attachment = file
            }
        }

        const handleSubmit = async () => {
            successMessage.value = ''
            errorMessage.value = ''

            const formData = new FormData()
            Object.keys(form).forEach(key => {
                if (form[key] !== null) {
                    formData.append(key, form[key])
                }
            })

            try {
                const response = await store.submitInquiry(formData)
                successMessage.value = response.message || 'Inquiry submitted successfully!'
                emit('submitted', response.message)

                // Reset form
                Object.keys(form).forEach(key => {
                    if (key !== 'attachment') {
                        form[key] = ''
                    }
                })
                form.attachment = null
                if (fileInput.value) {
                    fileInput.value.value = ''
                }
            } catch (error) {
                errorMessage.value = error.response?.data?.message || 'Failed to submit inquiry. Please try again.'
            }
        }

        return {
            store,
            form,
            fileInput,
            successMessage,
            errorMessage,
            handleFileUpload,
            handleSubmit
        }
    }
}
</script>

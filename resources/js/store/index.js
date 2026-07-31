import { defineStore } from 'pinia'
import axios from 'axios'

export const useAgriculturalStore = defineStore('agricultural', {
    state: () => ({
        guides: [],
        crops: [],
        pestStrategies: [],
        loading: false,
        error: null
    }),

    actions: {
        async fetchGuides() {
            this.loading = true
            try {
                const response = await axios.get('/api/guides')
                this.guides = response.data
            } catch (error) {
                this.error = error.message
            } finally {
                this.loading = false
            }
        },

        async fetchCrops() {
            this.loading = true
            try {
                const response = await axios.get('/api/crops')
                this.crops = response.data
            } catch (error) {
                this.error = error.message
            } finally {
                this.loading = false
            }
        },

        async fetchPestStrategies() {
            this.loading = true
            try {
                const response = await axios.get('/api/pest-strategies')
                this.pestStrategies = response.data
            } catch (error) {
                this.error = error.message
            } finally {
                this.loading = false
            }
        },

        async submitInquiry(formData) {
            this.loading = true
            try {
                const response = await axios.post('/api/inquiries', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                return response.data
            } catch (error) {
                this.error = error.response?.data?.message || error.message
                throw error
            } finally {
                this.loading = false
            }
        }
    }
})

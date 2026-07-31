import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('auth_token') || null,
        loading: false,
        error: null
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
        isAdmin: (state) => state.user?.role === 'admin',
        isAgronomist: (state) => state.user?.role === 'agronomist',
        isFarmer: (state) => state.user?.role === 'farmer',
    },

    actions: {
        async login(email, password) {
            this.loading = true
            this.error = null
            try {
                const response = await axios.post('/api/login', { email, password })
                this.token = response.data.access_token
                this.user = response.data.user
                localStorage.setItem('auth_token', this.token)
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                return response.data
            } catch (error) {
                this.error = error.response?.data?.message || 'Login failed'
                throw error
            } finally {
                this.loading = false
            }
        },

        async register(userData) {
            this.loading = true
            this.error = null
            try {
                const response = await axios.post('/api/register', userData)
                this.token = response.data.access_token
                this.user = response.data.user
                localStorage.setItem('auth_token', this.token)
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                return response.data
            } catch (error) {
                this.error = error.response?.data?.message || 'Registration failed'
                throw error
            } finally {
                this.loading = false
            }
        },

        async logout() {
            try {
                await axios.post('/api/logout')
            } catch (error) {
                console.error('Logout error:', error)
            } finally {
                this.token = null
                this.user = null
                localStorage.removeItem('auth_token')
                delete axios.defaults.headers.common['Authorization']
            }
        },

        async fetchProfile() {
            if (!this.token) return
            this.loading = true
            try {
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                const response = await axios.get('/api/profile')
                this.user = response.data.user
            } catch (error) {
                console.error('Fetch profile error:', error)
                if (error.response?.status === 401) {
                    this.logout()
                }
            } finally {
                this.loading = false
            }
        },

        async updateProfile(data) {
            this.loading = true
            try {
                const response = await axios.put('/api/profile', data)
                this.user = response.data.user
                return response.data
            } catch (error) {
                this.error = error.response?.data?.message || 'Profile update failed'
                throw error
            } finally {
                this.loading = false
            }
        },

        initialize() {
            if (this.token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                this.fetchProfile()
            }
        }
    }
})

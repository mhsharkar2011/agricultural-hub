<template>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
            <button @click="showCreateModal = true"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i class="fas fa-plus"></i> Add User
            </button>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input v-model="filters.search" @input="fetchUsers" type="text"
                           placeholder="Search by name or email"
                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select v-model="filters.role" @change="fetchUsers"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">All Roles</option>
                        <option v-for="(label, value) in roles" :key="value" :value="value">
                            {{ label }}
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select v-model="filters.is_active" @change="fetchUsers"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Per Page</label>
                    <select v-model="filters.per_page" @change="fetchUsers"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img v-if="user.profile_photo"
                                         :src="'/storage/' + user.profile_photo"
                                         class="h-10 w-10 rounded-full object-cover">
                                    <div v-else class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-user text-green-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                    <div class="text-sm text-gray-500">{{ user.email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ roles[user.role] || user.role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="user.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                {{ user.is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ new Date(user.created_at).toLocaleDateString() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button @click="editUser(user)" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="toggleUserStatus(user)" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                <i class="fas fa-toggle-on" v-if="user.is_active"></i>
                                <i class="fas fa-toggle-off" v-else></i>
                            </button>
                            <button @click="deleteUser(user)" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-500">
                Showing {{ users.from || 0 }} to {{ users.to || 0 }} of {{ users.total || 0 }} users
            </div>
            <div class="flex gap-2">
                <button @click="fetchUsers(users.current_page - 1)"
                        :disabled="!users.prev_page_url"
                        class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50">
                    Previous
                </button>
                <span class="px-3 py-1 border rounded bg-green-50 text-green-700">
                    {{ users.current_page || 1 }} / {{ users.last_page || 1 }}
                </span>
                <button @click="fetchUsers(users.current_page + 1)"
                        :disabled="!users.next_page_url"
                        class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50">
                    Next
                </button>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ showEditModal ? 'Edit User' : 'Add New User' }}
                    </h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form @submit.prevent="submitUser">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input v-model="form.name" type="text" required
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input v-model="form.email" type="email" required
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                            <select v-model="form.role" required
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                                <option v-for="(label, value) in roles" :key="value" :value="value">
                                    {{ label }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input v-model="form.phone" type="text"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input v-model="form.address" type="text"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input v-model="form.password" type="password"
                                   :required="!showEditModal"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                            <p v-if="showEditModal" class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input v-model="form.password_confirmation" type="password"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg">
                            {{ showEditModal ? 'Update' : 'Create' }}
                        </button>
                        <button type="button" @click="closeModal"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded-lg">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            users: {
                data: [],
                from: 0,
                to: 0,
                total: 0,
                current_page: 1,
                last_page: 1,
                prev_page_url: null,
                next_page_url: null
            },
            roles: {},
            filters: {
                search: '',
                role: '',
                is_active: '',
                per_page: 10
            },
            showCreateModal: false,
            showEditModal: false,
            form: {
                name: '',
                email: '',
                role: '',
                phone: '',
                address: '',
                password: '',
                password_confirmation: ''
            },
            editingUserId: null
        }
    },
    mounted() {
        this.fetchUsers()
    },
    methods: {
        async fetchUsers(page = 1) {
            try {
                const params = {
                    page: page,
                    ...this.filters
                }
                const response = await axios.get('/api/users', { params })
                this.users = response.data.users
                this.roles = response.data.roles
            } catch (error) {
                console.error('Error fetching users:', error)
                alert('Failed to fetch users')
            }
        },

        async submitUser() {
            try {
                if (this.showEditModal) {
                    await axios.put(`/api/users/${this.editingUserId}`, this.form)
                    alert('User updated successfully!')
                } else {
                    await axios.post('/api/users', this.form)
                    alert('User created successfully!')
                }
                this.closeModal()
                await this.fetchUsers()
            } catch (error) {
                console.error('Error submitting user:', error)
                alert(error.response?.data?.message || 'Failed to submit user')
            }
        },

        editUser(user) {
            this.editingUserId = user.id
            this.form = {
                name: user.name,
                email: user.email,
                role: user.role,
                phone: user.phone || '',
                address: user.address || '',
                password: '',
                password_confirmation: ''
            }
            this.showEditModal = true
        },

        async toggleUserStatus(user) {
            if (confirm(`Are you sure you want to ${user.is_active ? 'deactivate' : 'activate'} ${user.name}?`)) {
                try {
                    await axios.post(`/api/users/${user.id}/toggle-active`)
                    alert('User status updated!')
                    await this.fetchUsers()
                } catch (error) {
                    console.error('Error toggling user status:', error)
                    alert('Failed to update user status')
                }
            }
        },

        async deleteUser(user) {
            if (confirm(`Are you sure you want to delete ${user.name}?`)) {
                try {
                    await axios.delete(`/api/users/${user.id}`)
                    alert('User deleted successfully!')
                    await this.fetchUsers()
                } catch (error) {
                    console.error('Error deleting user:', error)
                    alert('Failed to delete user')
                }
            }
        },

        closeModal() {
            this.showCreateModal = false
            this.showEditModal = false
            this.form = {
                name: '',
                email: '',
                role: '',
                phone: '',
                address: '',
                password: '',
                password_confirmation: ''
            }
            this.editingUserId = null
        }
    }
}
</script>

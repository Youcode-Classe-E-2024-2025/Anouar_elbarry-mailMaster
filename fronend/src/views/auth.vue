<template>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 px-4 py-8">
        <div class="w-full max-w-4xl bg-white shadow-2xl rounded-2xl overflow-hidden flex">
            <!-- Left Side - Illustration -->
            <div class="hidden md:block md:w-1/2 bg-gradient-to-br from-blue-600 to-purple-700 p-12 flex items-center justify-center">
                <div class="text-center text-white">
                    <h2 class="text-4xl font-bold mb-6">Welcome to MailMaster</h2>
                    <p class="text-xl mb-8 opacity-80">
                        Streamline your email campaigns and subscriber management
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-envelope mr-4 text-2xl"></i>
                            <div>
                                <h3 class="font-semibold">Powerful Campaigns</h3>
                                <p class="text-sm opacity-70">Create and track email campaigns</p>
                            </div>
                        </div>
                        <div class="flex items-center bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-users mr-4 text-2xl"></i>
                            <div>
                                <h3 class="font-semibold">Subscriber Management</h3>
                                <p class="text-sm opacity-70">Organize and segment your lists</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Auth Forms -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                 <!-- Error Message Display -->
        <div v-if="error" class="error-message">
            {{ error }}
        </div>
        
        <!-- Success Message Display -->
        <div v-if="message" class="success-message">
            {{ message }}
        </div>
                <!-- Tab Navigation -->
                <div class="flex mb-8 border-b-2 border-gray-200">
                    <button 
                        @click="activeTab = 'login'" 
                        :class="[
                            'w-1/2 py-3 text-center font-semibold transition-all duration-300',
                            activeTab === 'login' 
                                ? 'text-blue-600 border-b-2 border-blue-600' 
                                : 'text-gray-500 hover:text-blue-600'
                        ]"
                    >
                        Sign In
                    </button>
                    <button 
                        @click="activeTab = 'register'" 
                        :class="[
                            'w-1/2 py-3 text-center font-semibold transition-all duration-300',
                            activeTab === 'register' 
                                ? 'text-blue-600 border-b-2 border-blue-600' 
                                : 'text-gray-500 hover:text-blue-600'
                        ]"
                    >
                        Sign Up
                    </button>
                </div>

                <!-- Login Form -->
                <form v-if="activeTab === 'login'" @submit.prevent="SubmitLogin" class="space-y-6">
                    <div class="space-y-4">
                        <input 
                            v-model="loginCredentials.email" 
                            type="email" 
                            placeholder="Email Address" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        />
                        <input 
                            v-model="loginCredentials.password" 
                            type="password" 
                            placeholder="Password" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        />
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2 rounded text-blue-600"/>
                            Remember me
                        </label>
                        <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Sign In
                    </button>
                </form>

                <!-- Register Form -->
                <form v-else @submit.prevent="SubmitRegister" class="space-y-6">
                    <div class="space-y-4">
                        <input 
                            v-model="registerCredentials.name" 
                            type="text" 
                            placeholder="Full Name" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        />
                        <input 
                            v-model="registerCredentials.email" 
                            type="email" 
                            placeholder="Email Address" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        />
                        <input 
                            v-model="registerCredentials.password" 
                            type="password" 
                            placeholder="Password" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        />
                        <input 
                            v-model="registerCredentials.password_confirmation" 
                            type="password" 
                            placeholder="Confirm Password" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        />
                        <select 
                            v-model="registerCredentials.role" 
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 transition-all"
                            required
                        >
                            <option value="">Select Role</option>
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios  from 'axios';

export default {
    name: 'Auth',
    data() {
        return {
            activeTab: 'login',
            loginCredentials: {
                email: '',
                password: ''
            },
            registerCredentials: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: ''
            },
            message: ''
        }
    },
    methods: {
        async SubmitRegister() {
           axios.post('/auth/register', this.registerCredentials)
           .then(response =>{
            console.log('user:', response.data.user);
           })
           .catch(error => {
            console.error('there was an error!',error);
           });
        },
        async SubmitLogin() {
    try {
        const response = await axios.post('/auth/login', this.loginCredentials);

        console.log(response.data.token);
        console.log(response.data.user);

        localStorage.setItem('token', response.data.token);

        this.message = 'Connexion réussie';
        this.$router.push('/');
    } catch (error) {
        // Affiche un message d'erreur dans la console
        console.error('Erreur lors de la connexion :', error);

        // Affiche le message d'erreur de l'API à l'utilisateur
        if (error.response && error.response.data && error.response.data.message) {
            this.message = error.response.data.message; // "user login failed."
        } else {
            this.message = 'Une erreur s\'est produite lors de la connexion.';
        }
    }
}
    },
    created() {
        axios.defaults.baseURL = 'http://localhost:8000/api';
        axios.defaults.withCredentials = true;
        axios.defaults.headers.common['Content-Type'] = 'application/json';
        axios.defaults.headers.common['Accept'] = 'application/json';
    }
    }
</script>
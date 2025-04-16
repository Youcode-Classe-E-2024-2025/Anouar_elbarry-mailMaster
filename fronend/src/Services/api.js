import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_BASE_URL,
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

// Authentication Services
export const authService = {
  register: async (userData) => {
    try {
      const response = await api.post('/auth/register', userData);
      return response.data;
    } catch (error) {
      console.error('Registration error:', error);
      throw error;
    }
  },
  login: async (credentials) => {
    try {
      const response = await api.post('/auth/login', credentials);
      return response.data;
    } catch (error) {
      console.error('Login error:', error);
      throw error;
    }
  }
};

// Campaign Services
export const campaignService = {
  create: async (campaignData) => {
    try {
      const response = await api.post('/campaigns', campaignData);
      return response.data;
    } catch (error) {
      console.error('Campaign creation error:', error);
      throw error;
    }
  },
  list: async () => {
    try {
      const response = await api.get('/campaigns');
      return response.data;
    } catch (error) {
      console.error('Campaign listing error:', error);
      throw error;
    }
  },
  send: async (campaignId) => {
    try {
      const response = await api.post(`/campaigns/${campaignId}/send`);
      return response.data;
    } catch (error) {
      console.error('Campaign send error:', error);
      throw error;
    }
  }
};

export default api;
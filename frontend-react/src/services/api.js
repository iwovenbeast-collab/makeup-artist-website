import axios from "axios";
import { APP_CONFIG } from "../config/app";

const api = axios.create({
  baseURL: APP_CONFIG.API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
  },
});

export const bookingApi = {
  create: async (bookingData) => {
    const response = await api.post("/api/bookings", bookingData);
    return response.data;
  },

  getAll: async () => {
    const response = await api.get("/api/bookings");
    return response.data;
  },
};

export default api;

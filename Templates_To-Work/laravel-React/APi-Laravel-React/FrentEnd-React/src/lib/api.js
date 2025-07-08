// src/lib/api.js
import axios from "axios";

export default axios.create({
  baseURL: import.meta.env.VITE_API_URL, // ← note the /api prefix
  withCredentials: true,
  headers: {
    "Content-Type": "application/json",
  },
});

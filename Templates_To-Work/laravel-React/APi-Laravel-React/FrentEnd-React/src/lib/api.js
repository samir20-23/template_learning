import axios from "axios";
export default axios.create({
  baseURL: import.meta.env.VITE_BACKEND_URL.replace(/\/$/, ""),
  headers: { "Content-Type": "application/json" },
  // withCredentials: false,
});
// src/components/LoginForm.jsx
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import axiosClient from "../lib/api";

const loginSchema = z.object({
  email: z.string().min(1, "Email is required").email("Invalid email"),
  password: z.string().min(6, "Password must be at least 6 characters"),
});

export default function LoginForm({ onSuccess, onError }) {
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm({ resolver: zodResolver(loginSchema) });

  const onSubmit = async (data) => {
    await axiosClient.get(`${import.meta.env.VITE_BACKEND_URL.replace(/\/$/, "")}/sanctum/csrf-cookie`);
    const res = await axiosClient.post("/api/login", data);
    onSuccess(res.data);
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="max-w-sm mx-auto space-y-4">
      <div>
        <label htmlFor="email" className="block font-medium">Email</label>
        <input id="email" type="email" {...register("email")} className="w-full border rounded px-3 py-2" />
        {errors.email && <p className="text-red-600 text-sm">{errors.email.message}</p>}
      </div>

      <div>
        <label htmlFor="password" className="block font-medium">Password</label>
        <input id="password" type="password" {...register("password")} className="w-full border rounded px-3 py-2" />
        {errors.password && <p className="text-red-600 text-sm">{errors.password.message}</p>}
      </div>

      <button type="submit" disabled={isSubmitting} className="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 disabled:opacity-50">
        {isSubmitting ? "Logging in…" : "Log In"}
      </button>
    </form>
  );
}

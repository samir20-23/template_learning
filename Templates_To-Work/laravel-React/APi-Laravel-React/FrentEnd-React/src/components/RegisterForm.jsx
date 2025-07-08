import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import axiosClient from "../lib/api";

const registerSchema = z
  .object({
    name: z.string().min(1, "Name is required"),
    email: z.string().min(1, "Email is required").email("Invalid email"),
    password: z.string().min(6, "Password must be at least 6 characters"),
    password_confirmation: z.string().min(1, "Please confirm password"),
  })
  .refine((data) => data.password === data.password_confirmation, {
    path: ["password_confirmation"],
    message: "Passwords do not match",
  });

export default function RegisterForm({ onSuccess, onError }) {
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm({
    resolver: zodResolver(registerSchema),
  });

  const onSubmit = async (data) => {
    console.log("⏳ Registering with:", axiosClient.defaults, data);
    try {
      await axiosClient.get("/sanctum/csrf-cookie");
      const res = await axiosClient.post("/register", data);
      console.log("✅ Register success:", res.data);
      onSuccess(res.data);
    } catch (err) {
      console.log("❌ Register error:", err.response?.data || err.message);
      onError(err.response?.data?.message || "Registration failed");
    }
  };

  return (
    <form
      onSubmit={handleSubmit(onSubmit)}
      className="max-w-md mx-auto space-y-4"
    >
      <div>
        <label htmlFor="name" className="block font-medium">
          Name
        </label>
        <input
          id="name"
          type="text"
          {...register("name")}
          className="w-full border rounded px-3 py-2"
          value="samir"
        />
        {errors.name && (
          <p className="text-red-600 text-sm">{errors.name.message}</p>
        )}
      </div>

      <div>
        <label htmlFor="email" className="block font-medium">
          Email
        </label>
        <input
          id="email"
          type="email"
          {...register("email")}
          className="w-full border rounded px-3 py-2"
          value="aouladamarsamir@gmail.com"
        />
        {errors.email && (
          <p className="text-red-600 text-sm">{errors.email.message}</p>
        )}
      </div>

      <div>
        <label htmlFor="password" className="block font-medium">
          Password
        </label>
        <input
          id="password"
          type="password"
          {...register("password")}
          className="w-full border rounded px-3 py-2"
          value="password123"
        />
        {errors.password && (
          <p className="text-red-600 text-sm">{errors.password.message}</p>
        )}
      </div>

      <div>
        <label htmlFor="password_confirmation" className="block font-medium">
          Confirm Password
        </label>
        <input
          id="password_confirmation"
          type="password"
          {...register("password_confirmation")}
          className="w-full border rounded px-3 py-2"
          value="password123"
        />
        {errors.password_confirmation && (
          <p className="text-red-600 text-sm">
            {errors.password_confirmation.message}
          </p>
        )}
      </div>

      <button
        type="submit"
        disabled={isSubmitting}
        className="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 disabled:opacity-50"
      >
        {isSubmitting ? "Registering…" : "Register"}
      </button>
    </form>
  );
}

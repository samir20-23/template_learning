import { useState } from "react"; 
import api from "../lib/api";

export default function RegisterForm({ onSuccess, onError }) {
  const [form, setForm] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: ""
  });
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);

  const validate = () => {
    const errs = {};
    if (!form.name) errs.name = "Name is required";
    if (!form.email) errs.email = "Email is required";
    else if (!/^\S+@\S+\.\S+$/.test(form.email))
      errs.email = "Invalid email";
    if (!form.password) errs.password = "Password is required";
    else if (form.password.length < 6)
      errs.password = "Password must be at least 6 characters";
    if (form.password !== form.password_confirmation)
      errs.password_confirmation = "Passwords do not match";
    return errs;
  };

  const handleChange = (e) => {
    setForm((f) => ({ ...f, [e.target.name]: e.target.value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const errs = validate();
    setErrors(errs);
    if (Object.keys(errs).length) return;

    console.log("⏳ Registering with:", form);
    setLoading(true);

    try {
      await api.get("/sanctum/csrf-cookie");
      const res = await api.post("/register", form);
      console.log("✅ Register success response:", res.data);
      onSuccess(res.data);
    } catch (err) {
      console.log(
        "❌ Register error response:",
        err.response?.data || err.message
      );
      onError(err.response?.data?.message || "Registration failed");
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="max-w-md mx-auto space-y-4">
      <div>
        <label htmlFor="name" className="block font-medium">Name</label>
        <input
          id="name"
          name="name"
          type="text"
          value={form.name}
          onChange={handleChange}
          className="w-full border rounded px-3 py-2"
        />
        {errors.name && <p className="text-red-600 text-sm">{errors.name}</p>}
      </div>

      <div>
        <label htmlFor="email" className="block font-medium">Email</label>
        <input
          id="email"
          name="email"
          type="email"
          value={form.email}
          onChange={handleChange}
          className="w-full border rounded px-3 py-2"
        />
        {errors.email && <p className="text-red-600 text-sm">{errors.email}</p>}
      </div>

      <div>
        <label htmlFor="password" className="block font-medium">Password</label>
        <input
          id="password"
          name="password"
          type="password"
          value={form.password}
          onChange={handleChange}
          className="w-full border rounded px-3 py-2"
        />
        {errors.password && (
          <p className="text-red-600 text-sm">{errors.password}</p>
        )}
      </div>

      <div>
        <label
          htmlFor="password_confirmation"
          className="block font-medium"
        >
          Confirm Password
        </label>
        <input
          id="password_confirmation"
          name="password_confirmation"
          type="password"
          value={form.password_confirmation}
          onChange={handleChange}
          className="w-full border rounded px-3 py-2"
        />
        {errors.password_confirmation && (
          <p className="text-red-600 text-sm">
            {errors.password_confirmation}
          </p>
        )}
      </div>

      <button
        type="submit"
        disabled={loading}
        className="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 disabled:opacity-50"
      >
        {loading ? "Registering…" : "Register"}
      </button>
    </form>
  );
}

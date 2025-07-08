import { useState } from "react";
import { useNavigate } from "react-router-dom";
import LoginForm from "../components/LoginForm";

export default function LoginPage() {
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleSuccess = (data) => {
    console.log("🏠 Redirecting after login, user:", data.user);
    // e.g. localStorage.setItem("token", data.token);
    navigate("/");
  };

  return (
    <div className="min-h-screen flex flex-col justify-center bg-gray-50 p-4">
      <h1 className="text-2xl font-bold text-center mb-6">Log In</h1>
      {error && (
        <div className="max-w-sm mx-auto mb-4 text-red-600">{error}</div>
      )}
      <LoginForm onSuccess={handleSuccess} onError={(msg) => setError(msg)} />
    </div>
  );
}

import { useState } from "react";
import { useNavigate } from "react-router-dom";
import RegisterForm from "../components/RegisterForm";

export default function RegisterPage() {
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleSuccess = (data) => {
    console.log("🏠 Redirecting after registration, user:", data.user);
    // store token or session info if needed
    navigate("/");
  };

  return (
    <div className="min-h-screen flex flex-col justify-center bg-gray-50 p-4">
      <h1 className="text-2xl font-bold text-center mb-6">
        Create an Account
      </h1>

      {error && (
        <div className="max-w-md mx-auto mb-4 text-red-600">{error}</div>
      )}

      <RegisterForm
        onSuccess={handleSuccess}
        onError={(msg) => setError(msg)}
      />
    </div>
  );
}

import { Button } from "@/components/ui/button.jsx";

export default function Contact() {
  return (
    <div className="max-w-lg mx-auto p-6">
      <h1 className="text-3xl font-bold mb-6">Contact</h1>
      <p className="mb-6 text-gray-700">
        If you have any questions, feel free to reach out!
      </p>

      <form className="space-y-4">
        <div>
          <label htmlFor="name" className="block mb-1 font-medium">Name:</label>
          <input
            type="text"
            id="name"
            name="name"
            required
            className="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label htmlFor="email" className="block mb-1 font-medium">Email:</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            className="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div>
          <label htmlFor="message" className="block mb-1 font-medium">Message:</label>
          <textarea
            id="message"
            name="message"
            required
            className="w-full border border-gray-300 rounded-md px-3 py-2 h-32 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div className="flex justify-center mt-6">
          <Button>Send</Button>
        </div>
      </form>
    </div>
  );
}

import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function About() {
  const [about, setAbout] = useState(null);

  useEffect(() => {
    axiosClient.get("/api/about").then(res => {
      // API returns an array; grab the first record
      setAbout(res.data[0]);
    });
  }, []);

  if (!about) return <p>Loading…</p>;

  return (
    <section className="p-6 max-w-3xl mx-auto">
      <h1 className="text-3xl font-bold mb-4">{about.title}</h1>
      <p className="text-lg leading-relaxed">{about.description}</p>
    </section>
  );
}

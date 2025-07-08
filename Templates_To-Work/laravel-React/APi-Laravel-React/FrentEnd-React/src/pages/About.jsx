import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function About() {
  const [about, setAbout] = useState(null);
  useEffect(() => {
    axiosClient.get("/api/about").then(res => setAbout(res.data[0]));
  }, []);

  if (!about) return <p>Loading…</p>;
  return (
    <section>
      <h1>{about.title}</h1>
      <p>{about.description}</p>
    </section>
  );
}

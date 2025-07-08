import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function Project() {
  const [projects, setProjects] = useState([]);

  useEffect(() => {
    axiosClient.get("/api/projects").then(res => setProjects(res.data));
  }, []);

  if (!projects.length) return <p>Loading…</p>;

  return (
    <section className="p-6 max-w-4xl mx-auto grid gap-6 md:grid-cols-2">
      {projects.map(project => (
        <div key={project.id} className="border rounded-lg p-4 shadow-sm">
          <h3 className="text-xl font-bold mb-2">{project.title}</h3>
          <p className="mb-3">{project.description}</p>
          {project.url && (
            <a
              href={project.url}
              target="_blank"
              rel="noopener noreferrer"
              className="text-blue-500 hover:underline"
            >
              Visit →
            </a>
          )}
        </div>
      ))}
    </section>
  );
}

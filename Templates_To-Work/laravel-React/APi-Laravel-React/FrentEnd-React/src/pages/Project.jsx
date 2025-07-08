import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function Project() {
  const [projects, setProjects] = useState([]);
  useEffect(() => {
    axiosClient.get("/api/projects").then(res => setProjects(res.data));
  }, []);

  return (
    <div className="grid grid-cols-2 gap-4">
      {projects.map(p => (
        <div key={p.id} className="border p-3">
          <h2>{p.name}</h2>
          <p>{p.description}</p>
          <a href={p.link} target="_blank" rel="noopener">View</a>
        </div>
      ))}
    </div>
  );
}

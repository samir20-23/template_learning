import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function Skills() {
  const [skills, setSkills] = useState([]);

  useEffect(() => {
    axiosClient.get("/api/skills").then(res => setSkills(res.data));
  }, []);

  if (!skills.length) return <p>Loading…</p>;

  return (
    <section className="p-6 max-w-3xl mx-auto">
      <h2 className="text-2xl font-semibold mb-4">My Skills</h2>
      <ul className="space-y-3">
        {skills.map(skill => (
          <li key={skill.id} className="flex justify-between">
            <span>{skill.name}</span>
            <span>{skill.proficiency}%</span>
          </li>
        ))}
      </ul>
    </section>
  );
}

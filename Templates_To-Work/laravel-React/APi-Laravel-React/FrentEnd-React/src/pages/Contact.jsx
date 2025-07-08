import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function Contact() {
  const [contacts, setContacts] = useState([]);

  useEffect(() => {
    axiosClient.get("/api/contacts").then(res => setContacts(res.data));
  }, []);

  if (!contacts.length) return <p>Loading…</p>;

  return (
    <section className="p-6 max-w-3xl mx-auto">
      <h2 className="text-2xl font-semibold mb-4">Get in Touch</h2>
      <ul className="space-y-3">
        {contacts.map(c => (
          <li key={c.id} className="flex items-center">
            {c.icon && <img src={`/icons/${c.icon}.svg`} alt="" className="w-5 h-5 mr-2" />}
            {c.type === 'Email' ? (
              <a href={`mailto:${c.value}`} className="hover:underline">{c.value}</a>
            ) : c.type === 'Phone' ? (
              <a href={`tel:${c.value}`} className="hover:underline">{c.value}</a>
            ) : (
              <a
                href={`https://${c.value}`}
                target="_blank"
                rel="noopener noreferrer"
                className="hover:underline"
              >
                {c.value}
              </a>
            )}
          </li>
        ))}
      </ul>
    </section>
  );
}
  
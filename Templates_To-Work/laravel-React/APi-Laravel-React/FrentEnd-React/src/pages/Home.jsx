import { useEffect, useState } from "react";
import axiosClient from "../lib/api";

export default function Home() {
  const [home, setHome] = useState(null);
  useEffect(() => {
    axiosClient.get("/api/home").then((res) => setHome(res.data[0]));
  }, []);

  if (!home) return <p>Loading…</p>;
  return (
    <section>
      <h1>{home.full_name}</h1>
      <h2>{home.headline}</h2>
      <h1>{home.full_name}</h1>
      <p>{home.bio}</p>
      <button>get a cv</button>
    </section>
  );
}
//         'headline' => "Hi, I'm Samir Aoulad Amar",
//         'full_name' => 'Samir Aoulad Amar',
//         'location' => 'Tanger, Morocco',
//         'bio' => "I'm a passionate full-stack developer from Tanger, Morocco. I specialize in crafting scalable web applications.",
//         'cv_url' => 'files/samir_cv.pdf',

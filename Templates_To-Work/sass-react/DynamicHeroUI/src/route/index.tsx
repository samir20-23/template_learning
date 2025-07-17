import { BrowserRouter, Routes, Route } from "react-router-dom";
import Header from "../pages/header";

export default function Router() {
  return (
    <>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Header />} />  
        </Routes>
      </BrowserRouter>
    </>
  );
}

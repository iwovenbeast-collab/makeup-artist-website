import { Routes, Route, Navigate, Link } from "react-router-dom";

import Navbar from "./components/Navbar/Navbar";
import Home from "./components/Home/Home";
import Profile from "./components/Profile/Profile";
import Portfolio from "./components/Portfolio/Portfolio";
import Services from "./components/Services/Services";
import Stories from "./components/Stories/Stories";
import StoryDetail from "./components/Stories/StoryDetail";
import Booking from "./components/Booking/Booking";
import {
  MessageCircle,
  ArrowUpRight,
} from "lucide-react";

function SiteFooter() {
  return (
    <footer className="mt-24 border-t border-black/5 bg-[#f8f5f2]">

      <div className="max-w-7xl mx-auto px-6 md:px-10 py-16">

        <div className="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">

          {/* Brand */}
          <div>

            <div className="font-serif text-3xl text-[#24201f]">
              Rupanjali
            </div>

            <div className="text-[9px] tracking-[0.35em] uppercase text-gold-500 mt-1">
              Makeup Artistry
            </div>

            <p className="text-sm text-gray-500 leading-relaxed mt-5 max-w-sm">
              Creating elegant, timeless makeup looks for weddings,
              celebrations and life's most memorable moments.
            </p>

          </div>


          {/* Explore */}
          <div>

            <p className="text-xs uppercase tracking-[0.2em] text-gray-400 mb-5">
              Explore
            </p>

            <div className="flex flex-col gap-3 text-sm">

              <Link
                to="/profile"
                className="hover:text-rose-600 transition"
              >
                Profile
              </Link>

              <Link
                to="/portfolio"
                className="hover:text-rose-600 transition"
              >
                Portfolio
              </Link>

              <Link
                to="/services"
                className="hover:text-rose-600 transition"
              >
                Services
              </Link>

              <Link
                to="/stories"
                className="hover:text-rose-600 transition"
              >
                Stories
              </Link>

            </div>

          </div>


          {/* Connect */}
          <div>

            <p className="text-xs uppercase tracking-[0.2em] text-gray-400 mb-5">
              Connect
            </p>

            <div className="flex items-center gap-3">

              <a
                href="https://www.instagram.com/_rupanjalis_makeup_artistry_/"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Instagram"
                className="w-10 h-10 rounded-full bg-white border border-black/5 flex items-center justify-center hover:text-rose-600 hover:-translate-y-0.5 transition"
              >
                <span className="text-xs font-semibold">IG</span>
              </a>

              <a
                href="https://www.facebook.com/people/Rupanjalis-Make-up-Artistry-An-ISO-90012015-ISO-299932017-Certified/100064056279759/"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Facebook"
                className="w-10 h-10 rounded-full bg-white border border-black/5 flex items-center justify-center hover:text-rose-600 hover:-translate-y-0.5 transition"
              >
                <span className="text-sm font-semibold">f</span>
              </a>

              <a
                href="https://wa.me/918637375351?text=Hello%20Rupanjali%2C%20I%20would%20like%20to%20enquire%20about%20your%20makeup%20services."
                target="_blank"
                rel="noopener noreferrer"
                aria-label="WhatsApp"
                className="w-10 h-10 rounded-full bg-white border border-black/5 flex items-center justify-center hover:text-rose-600 hover:-translate-y-0.5 transition"
              >
                <MessageCircle size={17} strokeWidth={1.8} />
              </a>

            </div>


            <a
              href="https://wa.me/918637375351?text=Hello%20Rupanjali%2C%20I%20would%20like%20to%20enquire%20about%20your%20makeup%20services."
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center gap-2 mt-5 text-sm font-medium hover:text-rose-600 transition"
            >
              Message on WhatsApp
              <ArrowUpRight size={15} />
            </a>

          </div>

        </div>


        {/* Bottom */}
        <div className="mt-14 pt-6 border-t border-black/5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-400">

          <p>
            © {new Date().getFullYear()} Rupanjali Makeup Artistry
          </p>

          <Link
            to="/booking"
            className="hover:text-rose-600 transition"
          >
            Book your date →
          </Link>

        </div>

      </div>

    </footer>
  );
}

function App() {
  return (
    <>
      <Navbar />

      <Routes>
        <Route path="/" element={<Home />} />

        <Route path="/profile" element={<Profile />} />

        <Route path="/portfolio" element={<Portfolio />} />

        <Route path="/services" element={<Services />} />

        {/* Stories / Blog */}
        {/* Stories / Blog */}
        <Route path="/stories" element={<Stories />} />
        <Route path="/stories/:slug" element={<StoryDetail />} />

        <Route path="/booking" element={<Booking />} />
        {/* Keep /blogs as an alias for Stories */}
        <Route path="/blogs" element={<Navigate to="/stories" replace />} />
        <Route path="/blogs/:slug" element={<Navigate to="/stories" replace />} />

        {/* Unknown pages */}
        <Route path="*" element={<Navigate to="/" replace />} />
        </Routes>

      <SiteFooter />
    </>
  );
}

export default App;
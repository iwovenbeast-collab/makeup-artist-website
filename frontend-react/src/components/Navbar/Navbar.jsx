import { useState } from "react";
import { Link } from "react-router-dom";
import {
  Menu,
  X,
  MessageCircle,
} from "lucide-react";

const navItems = [
  { label: "Home", to: "/" },
  { label: "Profile", to: "/profile" },
  { label: "Portfolio", to: "/portfolio" },
  { label: "Services", to: "/services" },
  { label: "Stories", to: "/blogs" },
];

const SOCIAL_LINKS = {
  instagram:
    "https://www.instagram.com/_rupanjalis_makeup_artistry_/",
  facebook:
    "https://www.facebook.com/people/Rupanjalis-Make-up-Artistry-An-ISO-90012015-ISO-299932017-Certified/100064056279759/",
  whatsapp:
    "https://wa.me/918637375351?text=Hello%20Rupanjali%2C%20I%20would%20like%20to%20enquire%20about%20your%20makeup%20services.",
};

function SocialLinks({ mobile = false }) {
  return (
    <div
      className={
        mobile
          ? "flex items-center gap-3 pt-2"
          : "flex items-center gap-2"
      }
    >
      <a
        href={SOCIAL_LINKS.instagram}
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Instagram"
        title="Instagram"
        className="w-8 h-8 rounded-full flex items-center justify-center text-ink/65 hover:text-rose-600 hover:bg-rose-50 transition-all duration-300"
      >
        <span className="text-xs font-semibold">IG</span>
      </a>

      <a
        href={SOCIAL_LINKS.facebook}
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Facebook"
        title="Facebook"
        className="w-8 h-8 rounded-full flex items-center justify-center text-ink/65 hover:text-rose-600 hover:bg-rose-50 transition-all duration-300"
      >
        <span className="text-sm font-semibold">f</span>
      </a>

      <a
        href={SOCIAL_LINKS.whatsapp}
        target="_blank"
        rel="noopener noreferrer"
        aria-label="WhatsApp"
        title="WhatsApp"
        className="w-8 h-8 rounded-full flex items-center justify-center text-ink/65 hover:text-rose-600 hover:bg-rose-50 transition-all duration-300"
      >
        <MessageCircle size={16} strokeWidth={1.8} />
      </a>
    </div>
  );
}

export default function Navbar() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <header className="fixed top-0 left-0 right-0 z-50">
      <div className="mx-auto max-w-7xl px-4 md:px-8 pt-4">
        <nav className="rounded-full border border-white/40 bg-white/80 backdrop-blur-xl shadow-lg shadow-black/5 px-5 md:px-7 py-3">

          <div className="flex items-center justify-between">

            {/* Logo */}
            <Link
              to="/"
              onClick={() => setMenuOpen(false)}
              className="group"
            >
              <div className="font-serif text-xl md:text-2xl tracking-wide text-ink">
                Rupanjali
              </div>

              <div className="text-[8px] md:text-[9px] tracking-[0.35em] uppercase text-gold-500">
                Makeup Artistry
              </div>
            </Link>

            {/* Desktop navigation */}
            <div className="hidden md:flex items-center gap-6">

              {navItems.map((item) => (
                <Link
                  key={item.to}
                  to={item.to}
                  className="text-sm text-ink/75 hover:text-rose-600 transition-colors"
                >
                  {item.label}
                </Link>
              ))}

              {/* Social links */}
              <SocialLinks />

              {/* Booking */}
              <Link
                to="/booking"
                className="rounded-full bg-ink text-white px-5 py-2.5 text-sm hover:bg-rose-600 transition-colors"
              >
                Book a Date
              </Link>

            </div>

            {/* Mobile menu button */}
            <button
              onClick={() => setMenuOpen(!menuOpen)}
              className="md:hidden p-2 text-ink"
              aria-label="Toggle navigation"
              aria-expanded={menuOpen}
            >
              {menuOpen ? <X size={23} /> : <Menu size={23} />}
            </button>

          </div>

          {/* Mobile navigation */}
          {menuOpen && (
            <div className="md:hidden pt-5 pb-2 border-t border-black/5 mt-3">

              <div className="flex flex-col gap-4">

                {navItems.map((item) => (
                  <Link
                    key={item.to}
                    to={item.to}
                    onClick={() => setMenuOpen(false)}
                    className="text-sm text-ink/80"
                  >
                    {item.label}
                  </Link>
                ))}

                <div>
                  <p className="text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-2">
                    Connect
                  </p>

                  <SocialLinks mobile />
                </div>

                <Link
                  to="/booking"
                  onClick={() => setMenuOpen(false)}
                  className="text-center rounded-full bg-ink text-white px-5 py-3 text-sm"
                >
                  Book a Date
                </Link>

              </div>

            </div>
          )}

        </nav>
      </div>
    </header>
  );
}
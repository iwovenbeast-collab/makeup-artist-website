import { ArrowDown, ArrowUpRight } from "lucide-react";
import { Link } from "react-router-dom";
import { motion } from "framer-motion";

export default function Hero() {
  return (
    <section className="relative min-h-screen overflow-hidden bg-cream">

      {/* Background image */}
      <div className="absolute inset-0">
        <div className="h-full w-full bg-gradient-to-br from-rose-200 via-rose-100 to-amber-100" />

        <div className="absolute inset-0 bg-gradient-to-r from-black/65 via-black/25 to-black/5" />
      </div>

      {/* Decorative glow */}
      <div className="absolute -right-40 -top-40 w-[500px] h-[500px] rounded-full bg-rose-200/20 blur-3xl" />

      <div className="relative min-h-screen max-w-7xl mx-auto px-6 md:px-10 flex items-end pb-20 md:pb-28">

        <motion.div
          initial={{ opacity: 0, y: 35 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.9 }}
          className="max-w-3xl text-white"
        >
          <p className="uppercase tracking-[0.35em] text-xs md:text-sm text-white/80 mb-5">
            Bridal • Editorial • Occasion
          </p>

          <h1 className="font-serif text-5xl md:text-7xl lg:text-8xl leading-[0.95]">
            Your beauty.
            <br />
            <span className="italic font-normal">
              Beautifully yours.
            </span>
          </h1>

          <p className="mt-7 max-w-xl text-white/80 text-base md:text-lg leading-relaxed">
            Thoughtfully crafted makeup for brides and unforgettable
            moments. Based in Kolkata, available across India.
          </p>

          <div className="mt-9 flex flex-wrap gap-4">

            <Link
              to="/booking"
              className="group inline-flex items-center gap-3 bg-white text-ink rounded-full px-7 py-4 font-medium hover:bg-rose-100 transition"
            >
              Check Availability
              <ArrowUpRight
                size={18}
                className="group-hover:translate-x-1 group-hover:-translate-y-1 transition"
              />
            </Link>

            <Link
              to="/portfolio"
              className="inline-flex items-center rounded-full border border-white/50 px-7 py-4 hover:bg-white/10 transition"
            >
              Explore My Work
            </Link>

          </div>
        </motion.div>
      </div>

      {/* Scroll indicator */}
      <div className="absolute bottom-8 right-8 hidden md:flex items-center gap-3 text-white/70 text-xs tracking-widest uppercase">
        <span>Scroll to explore</span>
        <ArrowDown size={15} />
      </div>

    </section>
  );
}

import { Link } from "react-router-dom";
import { ArrowUpRight } from "lucide-react";
import { motion } from "framer-motion";

export default function ProfileIntro() {
  return (
    <section className="py-24 md:py-32 bg-cream">
      <div className="max-w-6xl mx-auto px-6">

        <div className="grid md:grid-cols-2 gap-14 md:gap-20 items-center">

          <motion.div
            initial={{ opacity: 0, x: -30 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.7 }}
          >
            <p className="text-gold-500 uppercase tracking-[0.3em] text-xs mb-5">
              Meet the artist
            </p>

            <h2 className="font-serif text-4xl md:text-6xl text-ink leading-tight">
              Makeup that feels
              <span className="italic font-normal"> like you.</span>
            </h2>

            <p className="mt-7 text-muted leading-relaxed">
              Every face has its own character. My approach is to enhance
              what already makes you beautiful while creating a look that
              feels effortless, elegant and completely yours.
            </p>

            <p className="mt-4 text-muted leading-relaxed">
              From intimate celebrations to grand bridal occasions,
              every detail is planned around you.
            </p>

            <Link
              to="/profile"
              className="inline-flex items-center gap-2 mt-8 text-sm font-medium text-ink group"
            >
              Discover my story
              <ArrowUpRight
                size={17}
                className="group-hover:translate-x-1 group-hover:-translate-y-1 transition"
              />
            </Link>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 30 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.7 }}
            className="relative"
          >
            <div className="aspect-[4/5] overflow-hidden rounded-[2rem]">
              <div className="w-full h-full bg-gradient-to-br from-rose-100 via-rose-200 to-amber-100" />
            </div>

            <div className="absolute -bottom-5 -left-5 md:-left-8 bg-white rounded-2xl shadow-xl px-6 py-5">
              <div className="font-serif text-2xl text-ink">
                Kolkata
              </div>

              <div className="text-xs text-muted mt-1">
                Available across India
              </div>
            </div>
          </motion.div>

        </div>

      </div>
    </section>
  );
}

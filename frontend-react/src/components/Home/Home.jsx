import { motion } from "framer-motion";
import {
  ArrowRight,
  CalendarDays,
  Heart,
  Sparkles,
  Star,
} from "lucide-react";
import { Link } from "react-router-dom";

const fadeUp = {
  hidden: {
    opacity: 0,
    y: 30,
  },
  visible: {
    opacity: 1,
    y: 0,
    transition: {
      duration: 0.7,
      ease: "easeOut",
    },
  },
};

export default function Home() {
  return (
    <main className="overflow-hidden">

      {/* ================= HERO ================= */}

      <section className="relative min-h-screen flex items-center bg-[#f9f4f1]">

        {/* Decorative background */}
        <div className="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-rose-100/60 blur-3xl" />
        <div className="absolute -bottom-40 -left-40 w-[500px] h-[500px] rounded-full bg-amber-100/50 blur-3xl" />

        <div className="relative max-w-7xl mx-auto px-6 md:px-10 pt-32 pb-20 grid lg:grid-cols-2 gap-14 items-center">

          {/* LEFT */}

          <motion.div
            variants={fadeUp}
            initial="hidden"
            animate="visible"
            className="max-w-xl"
          >

            <div className="flex items-center gap-3 mb-6">
              <span className="h-px w-10 bg-rose-400" />

              <span className="uppercase tracking-[0.3em] text-xs text-rose-500">
                Makeup Artist · Kolkata
              </span>
            </div>

            <h1 className="font-serif text-5xl md:text-6xl lg:text-7xl leading-[1.05] text-[#24201f]">

              Your beauty.

              <br />

              <span className="italic text-rose-600">
                Your moment.
              </span>

              <br />

              Your story.
            </h1>

            <p className="mt-7 text-lg leading-8 text-gray-600 max-w-lg">
              Luxury bridal and occasion makeup crafted to make you feel
              confident, radiant and completely yourself on your most
              unforgettable days.
            </p>

            <div className="mt-9 flex flex-wrap gap-4">

              <Link
                to="/booking"
                className="group inline-flex items-center gap-3 rounded-full bg-[#24201f] text-white px-7 py-4 text-sm font-medium hover:bg-rose-600 transition"
              >
                Check Your Date

                <ArrowRight
                  size={17}
                  className="group-hover:translate-x-1 transition"
                />
              </Link>

              <Link
                to="/portfolio"
                className="inline-flex items-center gap-2 rounded-full border border-gray-300 bg-white/60 px-7 py-4 text-sm font-medium hover:border-rose-400 hover:text-rose-600 transition"
              >
                Explore My Work
              </Link>

            </div>

            {/* Small trust indicators */}

            <div className="mt-10 flex items-center gap-7">

              <div>
                <p className="font-serif text-2xl text-[#24201f]">
                  500+
                </p>

                <p className="text-xs text-gray-500 mt-1">
                  Happy Clients
                </p>
              </div>

              <div className="h-10 w-px bg-gray-300" />

              <div>
                <p className="font-serif text-2xl text-[#24201f]">
                  4.9/5
                </p>

                <div className="flex gap-0.5 mt-1">
                  {[1, 2, 3, 4, 5].map((star) => (
                    <Star
                      key={star}
                      size={12}
                      fill="currentColor"
                      className="text-amber-500"
                    />
                  ))}
                </div>
              </div>

              <div className="h-10 w-px bg-gray-300" />

              <div>
                <p className="font-serif text-2xl text-[#24201f]">
                  PAN India
                </p>

                <p className="text-xs text-gray-500 mt-1">
                  Available
                </p>
              </div>

            </div>

          </motion.div>

          {/* RIGHT IMAGE */}

          <motion.div
            initial={{ opacity: 0, scale: 0.94 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.9 }}
            className="relative"
          >

            <div className="relative max-w-lg mx-auto">

              {/* Main image */}

              <div className="aspect-[4/5] rounded-[180px_180px_30px_30px] overflow-hidden shadow-2xl">

                <img
                  src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=1000&q=85"
                  alt="Luxury bridal makeup"
                  className="w-full h-full object-cover"
                />

              </div>

              {/* Floating card */}

              <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{
                  delay: 0.8,
                  duration: 0.6,
                }}
                className="absolute bottom-7 -left-7 md:-left-12 bg-white rounded-2xl shadow-xl p-5"
              >

                <div className="flex items-center gap-3">

                  <div className="w-11 h-11 rounded-full bg-rose-50 flex items-center justify-center">
                    <Sparkles
                      size={20}
                      className="text-rose-500"
                    />
                  </div>

                  <div>
                    <p className="text-sm font-semibold">
                      Signature Glam
                    </p>

                    <p className="text-xs text-gray-500 mt-1">
                      Crafted for you
                    </p>
                  </div>

                </div>

              </motion.div>

              {/* Floating availability */}

              <div className="absolute top-8 -right-4 md:-right-10 bg-[#24201f] text-white rounded-2xl shadow-xl p-5">

                <CalendarDays size={19} />

                <p className="text-xs mt-3 text-gray-300">
                  Planning your day?
                </p>

                <p className="text-sm font-medium mt-1">
                  Check availability
                </p>

              </div>

            </div>

          </motion.div>

        </div>
      </section>


      {/* ================= INTRO ================= */}

      <section className="py-24 md:py-32 bg-white">

        <div className="max-w-5xl mx-auto px-6 text-center">

          <div className="flex justify-center mb-5">
            <Heart
              size={20}
              className="text-rose-400"
              fill="currentColor"
            />
          </div>

          <p className="uppercase tracking-[0.3em] text-xs text-rose-500">
            The Art of Makeup
          </p>

          <h2 className="font-serif text-4xl md:text-5xl text-[#24201f] mt-5">
            Makeup that feels like
            <span className="italic text-rose-600"> you</span>
          </h2>

          <p className="mt-7 text-gray-600 leading-8 max-w-2xl mx-auto">
            Every face is different, every story is different and every
            celebration deserves something personal. My approach combines
            refined techniques with a soft, timeless aesthetic designed
            around you.
          </p>

        </div>

      </section>


      {/* ================= SERVICES PREVIEW ================= */}

      <section className="py-24 bg-[#f9f4f1]">

        <div className="max-w-7xl mx-auto px-6">

          <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">

            <div>

              <p className="uppercase tracking-[0.3em] text-xs text-rose-500">
                Services
              </p>

              <h2 className="font-serif text-4xl md:text-5xl mt-3 text-[#24201f]">
                For your most beautiful days
              </h2>

            </div>

            <Link
              to="/services"
              className="inline-flex items-center gap-2 text-sm font-medium hover:text-rose-600 transition"
            >
              View all services
              <ArrowRight size={16} />
            </Link>

          </div>


          <div className="grid md:grid-cols-3 gap-6">

            {[
              {
                title: "Bridal Makeup",
                text: "Elegant, long-lasting bridal looks created around your features and personality.",
                image:
                  "https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=800&q=80",
              },
              {
                title: "Engagement",
                text: "Soft, sophisticated glam for the beginning of your beautiful story.",
                image:
                  "https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?auto=format&fit=crop&w=800&q=80",
              },
              {
                title: "Party & Events",
                text: "Statement makeup for celebrations, parties, shoots and special occasions.",
                image:
                  "https://images.unsplash.com/photo-1485230895905-ec40ba36b9bc?auto=format&fit=crop&w=800&q=80",
              },
            ].map((service) => (

              <motion.div
                key={service.title}
                whileHover={{ y: -6 }}
                transition={{ duration: 0.25 }}
                className="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition"
              >

                <div className="h-72 overflow-hidden">

                  <img
                    src={service.image}
                    alt={service.title}
                    className="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                  />

                </div>

                <div className="p-7">

                  <h3 className="font-serif text-2xl text-[#24201f]">
                    {service.title}
                  </h3>

                  <p className="mt-3 text-sm leading-7 text-gray-600">
                    {service.text}
                  </p>

                  <Link
                    to="/services"
                    className="inline-flex items-center gap-2 mt-5 text-sm text-rose-600"
                  >
                    Discover
                    <ArrowRight size={15} />
                  </Link>

                </div>

              </motion.div>

            ))}

          </div>

        </div>

      </section>


      {/* ================= BOOKING CTA ================= */}

      <section className="py-24 md:py-32 bg-[#24201f] text-white">

        <div className="max-w-4xl mx-auto px-6 text-center">

          <p className="uppercase tracking-[0.3em] text-xs text-rose-300">
            Your Date Matters
          </p>

          <h2 className="font-serif text-4xl md:text-6xl mt-5">
            Let's make your day
            <span className="italic text-rose-300">
              {" "}unforgettable.
            </span>
          </h2>

          <p className="mt-6 text-gray-300 max-w-xl mx-auto leading-7">
            Check availability for your date and send a booking request.
            You'll receive confirmation directly from Rupanjali.
          </p>

          <Link
            to="/booking"
            className="inline-flex items-center gap-3 mt-9 rounded-full bg-white text-[#24201f] px-8 py-4 text-sm font-semibold hover:bg-rose-100 transition"
          >
            <CalendarDays size={18} />
            Check Availability
          </Link>

        </div>

      </section>

    </main>
  );
}

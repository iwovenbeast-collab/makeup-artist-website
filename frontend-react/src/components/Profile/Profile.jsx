import { motion } from "framer-motion";
import {
  ArrowRight,
  Heart,
  Sparkles,
  MapPin,
  Award,
} from "lucide-react";
import { Link } from "react-router-dom";

export default function Profile() {
  return (
    <main className="bg-[#faf6f3] min-h-screen">

      {/* HERO */}

      <section className="pt-36 pb-20">
        <div className="max-w-7xl mx-auto px-6 md:px-10">

          <div className="grid lg:grid-cols-2 gap-16 items-center">

            {/* IMAGE */}

            <motion.div
              initial={{ opacity: 0, x: -40 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8 }}
              className="relative"
            >

              <div className="aspect-[4/5] rounded-[220px_220px_30px_30px] overflow-hidden shadow-2xl">

                <img
                  src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1000&q=85"
                  alt="Makeup artist"
                  className="w-full h-full object-cover"
                />

              </div>

              <div className="absolute -bottom-7 -right-4 md:-right-10 bg-white rounded-2xl shadow-xl p-6">

                <div className="flex items-center gap-3">

                  <div className="w-11 h-11 rounded-full bg-rose-50 flex items-center justify-center">
                    <Award className="text-rose-500" size={20} />
                  </div>

                  <div>
                    <p className="font-medium text-sm">
                      Beauty & Artistry
                    </p>

                    <p className="text-xs text-gray-500 mt-1">
                      Crafted with intention
                    </p>
                  </div>

                </div>

              </div>

            </motion.div>


            {/* CONTENT */}

            <motion.div
              initial={{ opacity: 0, x: 40 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8 }}
            >

              <div className="flex items-center gap-3">

                <span className="h-px w-10 bg-rose-400" />

                <span className="uppercase tracking-[0.3em] text-xs text-rose-500">
                  Meet the Artist
                </span>

              </div>

              <h1 className="font-serif text-5xl md:text-6xl text-[#24201f] mt-6 leading-tight">
                Beauty is personal.
                <br />
                <span className="italic text-rose-600">
                  Makeup should be too.
                </span>
              </h1>

              <p className="mt-8 text-gray-600 leading-8 text-lg">
                I'm Rupanjali, a professional makeup artist based in
                Kolkata, creating elegant and timeless looks for brides,
                celebrations and unforgettable moments.
              </p>

              <p className="mt-5 text-gray-600 leading-8">
                My philosophy is simple — makeup should enhance the person
                you already are, not hide her. Every look is thoughtfully
                designed around your features, personality, outfit and the
                feeling you want to carry on your special day.
              </p>

              <div className="grid sm:grid-cols-2 gap-5 mt-9">

                <div className="bg-white rounded-2xl p-5 shadow-sm">

                  <Sparkles
                    size={20}
                    className="text-rose-500"
                  />

                  <h3 className="font-medium mt-4">
                    Signature Style
                  </h3>

                  <p className="text-sm text-gray-500 mt-2 leading-6">
                    Soft, polished and timeless makeup with attention
                    to every detail.
                  </p>

                </div>

                <div className="bg-white rounded-2xl p-5 shadow-sm">

                  <Heart
                    size={20}
                    className="text-rose-500"
                    fill="currentColor"
                  />

                  <h3 className="font-medium mt-4">
                    Personal Approach
                  </h3>

                  <p className="text-sm text-gray-500 mt-2 leading-6">
                    Every appointment begins with understanding you
                    and your vision.
                  </p>

                </div>

              </div>

              <div className="flex items-center gap-2 mt-8 text-sm text-gray-500">

                <MapPin size={17} className="text-rose-500" />

                Kolkata · Available Across India

              </div>

            </motion.div>

          </div>

        </div>
      </section>


      {/* PHILOSOPHY */}

      <section className="py-24 bg-white">

        <div className="max-w-4xl mx-auto px-6 text-center">

          <Heart
            size={20}
            className="mx-auto text-rose-400"
            fill="currentColor"
          />

          <p className="uppercase tracking-[0.3em] text-xs text-rose-500 mt-5">
            My Philosophy
          </p>

          <h2 className="font-serif text-4xl md:text-5xl text-[#24201f] mt-5">
            The goal isn't to change you.
            <br />
            <span className="italic text-rose-600">
              It's to reveal you.
            </span>
          </h2>

          <p className="mt-7 text-gray-600 leading-8 max-w-2xl mx-auto">
            From the first consultation to the final touch in the mirror,
            the experience should feel relaxed, personal and completely
            yours.
          </p>

        </div>

      </section>


      {/* EXPERIENCE */}

      <section className="py-24 bg-[#f9f1ee]">

        <div className="max-w-7xl mx-auto px-6">

          <div className="grid md:grid-cols-3 gap-6">

            <div className="bg-white rounded-3xl p-8">

              <p className="font-serif text-5xl text-rose-600">
                500+
              </p>

              <p className="font-medium mt-4">
                Beautiful Faces
              </p>

              <p className="text-sm text-gray-500 mt-2 leading-6">
                Every client bringing a new story and a new canvas.
              </p>

            </div>

            <div className="bg-white rounded-3xl p-8">

              <p className="font-serif text-5xl text-rose-600">
                PAN
              </p>

              <p className="font-medium mt-4">
                India Availability
              </p>

              <p className="text-sm text-gray-500 mt-2 leading-6">
                Available for destination weddings and celebrations.
              </p>

            </div>

            <div className="bg-white rounded-3xl p-8">

              <p className="font-serif text-5xl text-rose-600">
                4.9
              </p>

              <p className="font-medium mt-4">
                Client Experience
              </p>

              <p className="text-sm text-gray-500 mt-2 leading-6">
                Creating an experience that feels as beautiful as
                the final look.
              </p>

            </div>

          </div>

        </div>

      </section>


      {/* CTA */}

      <section className="py-24 bg-[#24201f] text-white">

        <div className="max-w-4xl mx-auto px-6 text-center">

          <p className="uppercase tracking-[0.3em] text-xs text-rose-300">
            Let's Create Something Beautiful
          </p>

          <h2 className="font-serif text-4xl md:text-5xl mt-5">
            Have a date in mind?
          </h2>

          <p className="text-gray-300 mt-5">
            Check availability and tell me a little about your occasion.
          </p>

          <Link
            to="/booking"
            className="inline-flex items-center gap-3 mt-8 px-8 py-4 rounded-full bg-white text-[#24201f] font-medium hover:bg-rose-100 transition"
          >
            Check Availability
            <ArrowRight size={17} />
          </Link>

        </div>

      </section>

    </main>
  );
}

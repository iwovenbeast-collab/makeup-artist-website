import { useEffect, useState } from "react";
import axios from "axios";
import { motion } from "framer-motion";
import {
  Sparkles,
  Heart,
  Camera,
  Crown,
  Clock3,
  MapPin,
  ArrowRight,
} from "lucide-react";

const API_URL = "http://localhost:8080";

const SERVICE_ICONS = {
  crown: Crown,
  heart: Heart,
  sparkles: Sparkles,
  camera: Camera,
};

export default function Services() {
  const [services, setServices] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    const fetchServices = async () => {
      try {
        const response = await axios.get(`${API_URL}/api/services`);
        setServices(response.data.data || []);
      } catch (err) {
        console.error("Failed to load services:", err);
        setError("Unable to load services at the moment.");
      } finally {
        setLoading(false);
      }
    };

    fetchServices();
  }, []);

  return (
    <main className="bg-[#faf6f3] min-h-screen">

      {/* HERO */}

      <section className="pt-36 pb-20">

        <div className="max-w-7xl mx-auto px-6 md:px-10">

          <motion.div
            initial={{ opacity: 0, y: 25 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.7 }}
            className="max-w-3xl"
          >

            <div className="flex items-center gap-3">

              <span className="w-10 h-px bg-rose-400" />

              <span className="text-xs uppercase tracking-[0.3em] text-rose-500">
                Services
              </span>

            </div>

            <h1 className="font-serif text-5xl md:text-7xl leading-tight text-[#24201f] mt-6">
              Beauty designed
              <br />
              <span className="italic text-rose-600">
                around you.
              </span>
            </h1>

            <p className="mt-7 text-gray-600 text-lg leading-8 max-w-2xl">
              Every occasion deserves its own kind of beauty. Choose your
              experience and let&apos;s create a look that feels effortlessly
              yours.
            </p>

          </motion.div>

        </div>

      </section>


      {/* SERVICES */}

      <section className="pb-28">

        <div className="max-w-7xl mx-auto px-6 md:px-10">

          {loading && (
            <div className="text-center py-16 text-gray-500">
              Loading services...
            </div>
          )}

          {!loading && error && (
            <div className="text-center py-16 text-rose-500">
              {error}
            </div>
          )}

          {!loading && !error && services.length === 0 && (
            <div className="text-center py-16 text-gray-500">
              No services are available at the moment.
            </div>
          )}

          {!loading && !error && services.length > 0 && (
            <div className="grid md:grid-cols-2 gap-6">

              {services.map((service, index) => {

                const Icon = SERVICE_ICONS[service.icon] || Sparkles;
                const number = String(index + 1).padStart(2, "0");

                return (
                  <motion.article
                    key={service.id}
                    initial={{
                      opacity: 0,
                      y: 30,
                    }}
                    whileInView={{
                      opacity: 1,
                      y: 0,
                    }}
                    viewport={{
                      once: true,
                      amount: 0.15,
                    }}
                    transition={{
                      duration: 0.55,
                      delay: index * 0.08,
                    }}
                    className="group bg-white rounded-[2rem] p-7 md:p-9 border border-black/[0.04] shadow-sm hover:shadow-xl transition duration-500"
                  >

                    {/* TOP */}

                    <div className="flex items-start justify-between">

                      <div className="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition duration-500">
                        <Icon size={24} strokeWidth={1.5} />
                      </div>

                      <span className="font-serif text-4xl text-black/10">
                        {number}
                      </span>

                    </div>


                    <p className="text-xs uppercase tracking-[0.2em] text-rose-500 mt-7">
                      {service.subtitle}
                    </p>

                    <h2 className="font-serif text-3xl md:text-4xl text-[#24201f] mt-2">
                      {service.title}
                    </h2>

                    <p className="text-gray-600 leading-7 mt-4">
                      {service.description}
                    </p>


                    {/* INCLUDED */}

                    <div className="mt-7 pt-6 border-t border-gray-100">

                      <p className="text-xs uppercase tracking-[0.18em] text-gray-400 mb-4">
                        Includes
                      </p>

                      <div className="grid grid-cols-2 gap-y-3">

                        {(service.includes || []).map((item) => (

                          <div
                            key={item}
                            className="flex items-center gap-2 text-sm text-gray-600"
                          >

                            <span className="w-1.5 h-1.5 rounded-full bg-rose-400" />

                            {item}

                          </div>

                        ))}

                      </div>

                    </div>


                    {/* FOOTER */}

                    <div className="mt-7 flex items-center justify-between">

                      <div className="flex items-center gap-2 text-sm text-gray-500">
                        <Clock3 size={16} />
                        {service.duration}
                      </div>

                      <a
                        href="/booking"
                        className="flex items-center gap-2 text-sm font-medium text-[#24201f] group-hover:text-rose-600 transition"
                      >
                        Check availability
                        <ArrowRight
                          size={16}
                          className="group-hover:translate-x-1 transition"
                        />
                      </a>

                    </div>

                  </motion.article>
                );
              })}

            </div>
          )}

        </div>

      </section>


      {/* EXPERIENCE SECTION */}

      <section className="bg-[#24201f] text-white py-24">

        <div className="max-w-7xl mx-auto px-6 md:px-10">

          <div className="grid md:grid-cols-2 gap-16 items-center">

            <div>

              <p className="text-xs uppercase tracking-[0.3em] text-rose-300">
                The experience
              </p>

              <h2 className="font-serif text-4xl md:text-5xl leading-tight mt-5">
                It&apos;s more than
                <span className="italic text-rose-300">
                  {" "}makeup.
                </span>
              </h2>

              <p className="text-gray-300 leading-8 mt-6 max-w-xl">
                From our first conversation to the final touch in the mirror,
                every detail is considered. The goal isn&apos;t to change who
                you are — it&apos;s to make you feel like the most confident
                version of yourself.
              </p>

            </div>


            <div className="grid sm:grid-cols-2 gap-4">

              <div className="rounded-3xl bg-white/5 border border-white/10 p-6">

                <Sparkles
                  size={22}
                  className="text-rose-300"
                />

                <h3 className="font-serif text-xl mt-5">
                  Personalised
                </h3>

                <p className="text-sm text-gray-400 mt-2 leading-6">
                  Your features, your outfit and your personality guide the
                  final look.
                </p>

              </div>


              <div className="rounded-3xl bg-white/5 border border-white/10 p-6">

                <Clock3
                  size={22}
                  className="text-rose-300"
                />

                <h3 className="font-serif text-xl mt-5">
                  Long-lasting
                </h3>

                <p className="text-sm text-gray-400 mt-2 leading-6">
                  Carefully selected techniques and products for your special
                  occasion.
                </p>

              </div>


              <div className="rounded-3xl bg-white/5 border border-white/10 p-6">

                <MapPin
                  size={22}
                  className="text-rose-300"
                />

                <h3 className="font-serif text-xl mt-5">
                  PAN India
                </h3>

                <p className="text-sm text-gray-400 mt-2 leading-6">
                  Based in Kolkata with availability for events across India.
                </p>

              </div>


              <div className="rounded-3xl bg-white/5 border border-white/10 p-6">

                <Heart
                  size={22}
                  className="text-rose-300"
                />

                <h3 className="font-serif text-xl mt-5">
                  Your comfort
                </h3>

                <p className="text-sm text-gray-400 mt-2 leading-6">
                  A calm, comfortable experience from beginning to end.
                </p>

              </div>

            </div>

          </div>

        </div>

      </section>


      {/* CTA */}

      <section className="py-24 bg-[#faf6f3]">

        <div className="max-w-3xl mx-auto px-6 text-center">

          <p className="text-xs uppercase tracking-[0.3em] text-rose-500">
            Planning something special?
          </p>

          <h2 className="font-serif text-4xl md:text-5xl text-[#24201f] mt-5">
            Let&apos;s create your
            <span className="italic text-rose-600">
              {" "}look.
            </span>
          </h2>

          <p className="text-gray-600 mt-5 leading-7">
            Check your date and send a booking request. We&apos;ll get back to
            you with availability and the next steps.
          </p>

          <a
            href="/booking"
            className="inline-flex items-center gap-3 mt-8 px-8 py-4 rounded-full bg-[#24201f] text-white text-sm font-medium hover:bg-rose-600 transition"
          >
            Check My Date
            <ArrowRight size={17} />
          </a>

        </div>

      </section>

    </main>
  );
}

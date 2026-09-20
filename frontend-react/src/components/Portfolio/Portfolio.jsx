import { useEffect, useState } from "react";
import axios from "axios";
import { motion, AnimatePresence } from "framer-motion";
import {
  ArrowLeft,
  ArrowRight,
  X,
  Maximize2,
} from "lucide-react";

import { APP_CONFIG } from "../../config/app";

const API_URL = APP_CONFIG.API_BASE_URL;

const categories = [
  "All",
  "Bridal",
  "Engagement",
  "Party",
  "Editorial",
];

const getPortfolioImage = (image) => {
  if (!image) {
    return "/images/portfolio/home_pic.jpeg";
  }

  if (image.startsWith("http://") || image.startsWith("https://")) {
    return image;
  }

  if (image.startsWith("/uploads/")) {
    return `${API_URL}${image}`;
  }

  if (image.startsWith("/images/")) {
    return image;
  }

  return `${API_URL}/uploads/portfolio/${image}`;
};

export default function Portfolio() {
  const [portfolioItems, setPortfolioItems] = useState([]);
  const [activeCategory, setActiveCategory] = useState("All");
  const [selectedImage, setSelectedImage] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    const fetchPortfolio = async () => {
      try {
        const response = await axios.get(`${API_URL}/api/portfolio`);
        setPortfolioItems(response.data.data || []);
      } catch (err) {
        console.error("Failed to load portfolio:", err);
        setError("Unable to load portfolio at the moment.");
      } finally {
        setLoading(false);
      }
    };

    fetchPortfolio();
  }, []);

  const filteredItems =
    activeCategory === "All"
      ? portfolioItems
      : portfolioItems.filter(
          (item) => item.category === activeCategory
        );

  const currentIndex = selectedImage
    ? filteredItems.findIndex(
        (item) => item.id === selectedImage.id
      )
    : -1;

  const showPrevious = () => {
    if (currentIndex === -1 || filteredItems.length === 0) return;

    const previousIndex =
      currentIndex === 0
        ? filteredItems.length - 1
        : currentIndex - 1;

    setSelectedImage(filteredItems[previousIndex]);
  };

  const showNext = () => {
    if (currentIndex === -1 || filteredItems.length === 0) return;

    const nextIndex =
      currentIndex === filteredItems.length - 1
        ? 0
        : currentIndex + 1;

    setSelectedImage(filteredItems[nextIndex]);
  };

  useEffect(() => {
    const handleKeyboard = (event) => {
      if (!selectedImage) return;

      if (event.key === "Escape") {
        setSelectedImage(null);
      }

      if (event.key === "ArrowLeft") {
        showPrevious();
      }

      if (event.key === "ArrowRight") {
        showNext();
      }
    };

    window.addEventListener("keydown", handleKeyboard);

    return () => {
      window.removeEventListener("keydown", handleKeyboard);
    };
  }, [selectedImage, currentIndex, filteredItems]);

  useEffect(() => {
    if (selectedImage) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }

    return () => {
      document.body.style.overflow = "";
    };
  }, [selectedImage]);

  return (
    <main className="bg-[#faf6f3] min-h-screen">

      {/* ================= HEADER ================= */}

      <section className="pt-36 pb-16">

        <div className="max-w-7xl mx-auto px-6 md:px-10 text-center">

          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.6 }}
          >

            <div className="flex items-center justify-center gap-3">

              <span className="h-px w-10 bg-rose-400" />

              <span className="uppercase tracking-[0.3em] text-xs text-rose-500">
                Selected Work
              </span>

              <span className="h-px w-10 bg-rose-400" />

            </div>

            <h1 className="font-serif text-5xl md:text-6xl text-[#24201f] mt-6">
              The Art of
              <span className="italic text-rose-600">
                {" "}Beauty
              </span>
            </h1>

            <p className="max-w-2xl mx-auto mt-6 text-gray-600 leading-8">
              A collection of bridal, engagement, occasion and editorial
              makeup looks. Every face tells a different story.
            </p>

          </motion.div>

        </div>

      </section>


      {/* ================= FILTERS ================= */}

      <section className="pb-12">

        <div className="max-w-7xl mx-auto px-6">

          <div className="flex justify-center gap-2 md:gap-3 flex-wrap">

            {categories.map((category) => (

              <button
                key={category}
                onClick={() => setActiveCategory(category)}
                className={`px-5 py-2.5 rounded-full text-sm transition ${
                  activeCategory === category
                    ? "bg-[#24201f] text-white"
                    : "bg-white text-gray-600 border border-gray-200 hover:border-rose-300 hover:text-rose-600"
                }`}
              >
                {category}
              </button>

            ))}

          </div>

        </div>

      </section>


      {/* ================= GALLERY ================= */}

      <section className="pb-28">

        <div className="max-w-7xl mx-auto px-6">

          {loading && (
            <div className="text-center py-16 text-gray-500">
              Loading portfolio...
            </div>
          )}

          {!loading && error && (
            <div className="text-center py-16 text-rose-500">
              {error}
            </div>
          )}

          {!loading && !error && portfolioItems.length === 0 && (
            <div className="text-center py-16 text-gray-500">
              No portfolio items are available at the moment.
            </div>
          )}

          {!loading && !error && portfolioItems.length > 0 && (
            <motion.div
              layout
              className="columns-1 sm:columns-2 lg:columns-3 gap-5"
            >

              <AnimatePresence mode="popLayout">

                {filteredItems.map((item) => (

                  <motion.div
                    key={item.id}
                    layout
                    initial={{
                      opacity: 0,
                      scale: 0.96,
                    }}
                    animate={{
                      opacity: 1,
                      scale: 1,
                    }}
                    exit={{
                      opacity: 0,
                      scale: 0.96,
                    }}
                    transition={{
                      duration: 0.35,
                    }}
                    className="mb-5 break-inside-avoid"
                  >

                    <button
                      onClick={() => setSelectedImage(item)}
                      className="group relative block w-full overflow-hidden rounded-3xl bg-gray-100 text-left"
                    >

                      <img
                        src={getPortfolioImage(item.image)}
                        alt={item.title}
                        loading="lazy"
                        className="w-full h-auto object-cover transition duration-700 group-hover:scale-105"
                      />

                      {/* Hover overlay */}

                      <div className="absolute inset-0 bg-black/0 group-hover:bg-black/35 transition duration-500" />

                      <div className="absolute inset-x-0 bottom-0 p-5 translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-500">

                        <div className="flex items-end justify-between text-white">

                          <div>

                            <p className="text-xs uppercase tracking-[0.2em] text-white/80">
                              {item.category}
                            </p>

                            <p className="font-serif text-xl mt-1">
                              {item.title}
                            </p>

                          </div>

                          <div className="w-10 h-10 rounded-full bg-white/20 backdrop-blur flex items-center justify-center">
                            <Maximize2 size={17} />
                          </div>

                        </div>

                      </div>

                    </button>

                  </motion.div>

                ))}

              </AnimatePresence>

            </motion.div>
          )}

        </div>

      </section>


      {/* ================= CTA ================= */}

      <section className="py-24 bg-[#24201f] text-white">

        <div className="max-w-4xl mx-auto px-6 text-center">

          <p className="uppercase tracking-[0.3em] text-xs text-rose-300">
            Your Turn
          </p>

          <h2 className="font-serif text-4xl md:text-5xl mt-5">
            Ready for your
            <span className="italic text-rose-300">
              {" "}moment?
            </span>
          </h2>

          <p className="mt-5 text-gray-300 leading-7 max-w-xl mx-auto">
            Let's create a look that feels completely yours.
          </p>

          <a
            href="/booking"
            className="inline-flex items-center gap-3 mt-8 bg-white text-[#24201f] px-8 py-4 rounded-full text-sm font-medium hover:bg-rose-100 transition"
          >
            Check Availability
            <ArrowRight size={17} />
          </a>

        </div>

      </section>


      {/* ================= LIGHTBOX ================= */}

      <AnimatePresence>

        {selectedImage && (

          <motion.div
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            className="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4 md:p-10"
            onClick={() => setSelectedImage(null)}
          >

            {/* Close */}

            <button
              onClick={() => setSelectedImage(null)}
              className="absolute top-5 right-5 md:top-8 md:right-8 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition"
              aria-label="Close image"
            >
              <X size={22} />
            </button>


            {/* Previous */}

            <button
              onClick={(event) => {
                event.stopPropagation();
                showPrevious();
              }}
              className="absolute left-4 md:left-8 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition"
              aria-label="Previous image"
            >
              <ArrowLeft size={21} />
            </button>


            {/* Image */}

            <motion.div
              initial={{ opacity: 0, scale: 0.94 }}
              animate={{ opacity: 1, scale: 1 }}
              exit={{ opacity: 0, scale: 0.94 }}
              transition={{ duration: 0.3 }}
              className="relative max-w-5xl max-h-[90vh]"
              onClick={(event) => event.stopPropagation()}
            >

              <img
                src={getPortfolioImage(selectedImage.image)}
                alt={selectedImage.title}
                className="max-h-[80vh] max-w-full object-contain rounded-xl shadow-2xl"
              />

              <div className="text-center text-white mt-4">

                <p className="font-serif text-2xl">
                  {selectedImage.title}
                </p>

                <p className="text-sm text-white/60 mt-1">
                  {selectedImage.category}
                </p>

                <p className="text-xs text-white/40 mt-2">
                  {currentIndex + 1} / {filteredItems.length}
                </p>

              </div>

            </motion.div>


            {/* Next */}

            <button
              onClick={(event) => {
                event.stopPropagation();
                showNext();
              }}
              className="absolute right-4 md:right-8 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition"
              aria-label="Next image"
            >
              <ArrowRight size={21} />
            </button>

          </motion.div>

        )}

      </AnimatePresence>

    </main>
  );
}

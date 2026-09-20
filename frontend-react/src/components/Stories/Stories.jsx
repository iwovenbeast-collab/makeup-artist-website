import { useEffect, useState } from "react";
import { motion } from "framer-motion";
import {
  ArrowUpRight,
  CalendarDays,
  Sparkles,
} from "lucide-react";
import { Link } from "react-router-dom";
import axios from "axios";

import { APP_CONFIG } from "../../config/app";

const API_URL = `${APP_CONFIG.API_BASE_URL}/api`;

function formatDate(dateString) {
  if (!dateString) return "";

  const date = new Date(dateString);

  if (Number.isNaN(date.getTime())) {
    return dateString;
  }

  return date.toLocaleDateString("en-IN", {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}

function getExcerpt(story, length = 160) {
  /*
   * Prefer the dedicated excerpt field.
   * Fall back to content for older stories.
   */
  const source = story.excerpt || story.content || "";

  const text = source
    .replace(/<[^>]*>/g, "")
    .replace(/\s+/g, " ")
    .trim();

  if (text.length <= length) {
    return text;
  }

  return text.substring(0, length).trim() + "...";
}

function getCategory(story) {
  return story.category || "Beauty";
}

function getImage(story) {
  if (story.featured_image_url) {
    return story.featured_image_url;
  }

  if (
    story.images?.length > 0 &&
    story.images[0]?.image_url
  ) {
    return story.images[0].image_url;
  }

  return null;
}

function getStoryDate(story) {
  return story.published_at || story.created_at;
}

export default function Stories() {

  const [stories, setStories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  async function loadStories() {

    try {

      setLoading(true);
      setError("");

      const response = await axios.get(
        `${API_URL}/blogs`
      );

      if (response.data?.status) {

        const publishedStories = (
          response.data.blogs || []
        ).filter(
          (story) =>
            story.status === "published" ||
            !story.status
        );

        /*
         * Newest published story first.
         */
        publishedStories.sort((a, b) => {

          const dateA = new Date(
            getStoryDate(a) || 0
          ).getTime();

          const dateB = new Date(
            getStoryDate(b) || 0
          ).getTime();

          return dateB - dateA;

        });

        setStories(publishedStories);

      } else {

        setStories([]);

      }

    } catch (err) {

      console.error(
        "Failed to load stories:",
        err
      );

      setError(
        "Unable to load stories right now."
      );

    } finally {

      setLoading(false);

    }

  }

  useEffect(() => {
    loadStories();
  }, []);


  const featuredStory = stories[0];
  const latestStories = stories.slice(1);


  return (

    <main className="bg-[#faf6f3] min-h-screen">


      {/* =========================================
          HERO
      ========================================== */}

      <section className="pt-36 pb-20">

        <div className="max-w-7xl mx-auto px-6 md:px-10">

          <motion.div
            initial={{
              opacity: 0,
              y: 25,
            }}
            animate={{
              opacity: 1,
              y: 0,
            }}
            transition={{
              duration: 0.7,
            }}
            className="max-w-3xl"
          >

            <div className="flex items-center gap-3">

              <span className="w-10 h-px bg-rose-400" />

              <span className="text-xs uppercase tracking-[0.3em] text-rose-500">
                Stories & Journal
              </span>

            </div>


            <h1 className="font-serif text-5xl md:text-7xl leading-tight text-[#24201f] mt-6">

              Beauty,

              <br />

              <span className="italic text-rose-600">
                stories & moments.
              </span>

            </h1>


            <p className="mt-7 text-lg text-gray-600 leading-8 max-w-2xl">

              Discover bridal inspiration, beauty tips,
              behind-the-scenes moments and stories
              from the makeup chair.

            </p>

          </motion.div>

        </div>

      </section>


      {/* =========================================
          LOADING
      ========================================== */}

      {loading && (

        <section className="pb-28">

          <div className="max-w-7xl mx-auto px-6 md:px-10">

            <div className="grid md:grid-cols-2 gap-7">

              <div className="h-[500px] rounded-[2rem] bg-white animate-pulse" />

              <div className="h-[500px] rounded-[2rem] bg-white animate-pulse" />

            </div>

          </div>

        </section>

      )}


      {/* =========================================
          ERROR
      ========================================== */}

      {!loading && error && (

        <section className="pb-28">

          <div className="max-w-3xl mx-auto px-6 text-center">

            <div className="bg-white rounded-3xl p-10 shadow-sm">

              <Sparkles
                size={28}
                className="mx-auto text-rose-400"
              />

              <h2 className="font-serif text-3xl text-[#24201f] mt-5">
                Stories are temporarily unavailable
              </h2>

              <p className="text-gray-500 mt-4">
                {error}
              </p>

              <button
                onClick={loadStories}
                className="mt-7 px-7 py-3 rounded-full bg-[#24201f] text-white text-sm hover:bg-rose-600 transition"
              >
                Try Again
              </button>

            </div>

          </div>

        </section>

      )}


      {/* =========================================
          EMPTY
      ========================================== */}

      {!loading &&
        !error &&
        stories.length === 0 && (

          <section className="pb-28">

            <div className="max-w-3xl mx-auto px-6 text-center">

              <div className="bg-white rounded-3xl p-12 shadow-sm">

                <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                  Coming soon
                </p>

                <h2 className="font-serif text-4xl text-[#24201f] mt-4">
                  Beautiful stories are on their way.
                </h2>

                <p className="text-gray-600 mt-4 leading-7">
                  Check back soon for bridal inspiration,
                  beauty tips and behind-the-scenes moments.
                </p>

              </div>

            </div>

          </section>

        )}


      {/* =========================================
          FEATURED STORY
      ========================================== */}

      {!loading &&
        !error &&
        featuredStory && (

          <section className="pb-20">

            <div className="max-w-7xl mx-auto px-6 md:px-10">

              <Link
                to={`/stories/${featuredStory.slug}`}
              >

                <motion.article
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
                  }}
                  className="group grid md:grid-cols-2 overflow-hidden rounded-[2rem] bg-white shadow-sm hover:shadow-xl transition duration-500"
                >


                  {/* Image */}

                  <div className="relative min-h-[360px] md:min-h-[520px] overflow-hidden bg-gradient-to-br from-rose-200 via-pink-100 to-orange-100">

                    {getImage(featuredStory) ? (

                      <img
                        src={getImage(featuredStory)}
                        alt={featuredStory.title}
                        loading="eager"
                        className="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700"
                      />

                    ) : (

                      <div className="absolute inset-0 flex items-center justify-center">

                        <div className="text-center">

                          <span className="font-serif text-8xl md:text-9xl text-white/50">
                            R
                          </span>

                          <p className="uppercase tracking-[0.35em] text-xs text-white/80 mt-2">
                            Rupanjali Makeup Artistry
                          </p>

                        </div>

                      </div>

                    )}


                    <div className="absolute top-6 left-6 bg-white/90 backdrop-blur-md rounded-full px-4 py-2 text-xs uppercase tracking-wider">
                      Featured story
                    </div>

                  </div>


                  {/* Content */}

                  <div className="p-8 md:p-12 flex flex-col justify-center">

                    <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                      {getCategory(featuredStory)}
                    </p>


                    <h2 className="font-serif text-4xl md:text-5xl text-[#24201f] leading-tight mt-5">
                      {featuredStory.title}
                    </h2>


                    <p className="text-gray-600 leading-7 mt-5">
                      {getExcerpt(featuredStory, 220)}
                    </p>


                    <div className="flex items-center justify-between mt-10">

                      <div className="flex items-center gap-2 text-sm text-gray-500">

                        <CalendarDays size={16} />

                        {formatDate(
                          getStoryDate(featuredStory)
                        )}

                      </div>


                      <div className="w-11 h-11 rounded-full bg-[#24201f] text-white flex items-center justify-center group-hover:bg-rose-600 transition">

                        <ArrowUpRight size={18} />

                      </div>

                    </div>

                  </div>

                </motion.article>

              </Link>

            </div>

          </section>

        )}


      {/* =========================================
          STORY GRID
      ========================================== */}

      {!loading &&
        !error &&
        latestStories.length > 0 && (

          <section className="pb-28">

            <div className="max-w-7xl mx-auto px-6 md:px-10">

              <div className="mb-10">

                <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                  Latest
                </p>

                <h2 className="font-serif text-4xl text-[#24201f] mt-3">
                  From the journal
                </h2>

              </div>


              <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-7">

                {latestStories.map(
                  (story, index) => (

                    <motion.article
                      key={story.id}
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
                        duration: 0.5,
                        delay: index * 0.07,
                      }}
                      className="group bg-white rounded-[1.7rem] overflow-hidden shadow-sm hover:shadow-xl transition duration-500"
                    >

                      <Link
                        to={`/stories/${story.slug}`}
                      >


                        {/* Image */}

                        <div className="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-rose-100 via-pink-100 to-orange-100">

                          {getImage(story) ? (

                            <img
                              src={getImage(story)}
                              alt={story.title}
                              loading="lazy"
                              className="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700"
                            />

                          ) : (

                            <div className="absolute inset-0 flex items-center justify-center">

                              <span className="font-serif text-7xl text-white/50">
                                {String(
                                  index + 2
                                ).padStart(2, "0")}
                              </span>

                            </div>

                          )}


                          <div className="absolute top-5 left-5 bg-white/90 backdrop-blur-md rounded-full px-3 py-1.5 text-[10px] uppercase tracking-[0.2em]">
                            {getCategory(story)}
                          </div>

                        </div>


                        {/* Card */}

                        <div className="p-6">

                          <div className="flex items-center gap-2 text-xs text-gray-400">

                            <CalendarDays size={14} />

                            {formatDate(
                              getStoryDate(story)
                            )}

                          </div>


                          <h3 className="font-serif text-2xl text-[#24201f] leading-tight mt-4 group-hover:text-rose-600 transition">
                            {story.title}
                          </h3>


                          <p className="text-sm text-gray-600 leading-6 mt-3">
                            {getExcerpt(story)}
                          </p>


                          <div className="flex items-center gap-2 mt-6 text-sm font-medium">

                            Read story

                            <ArrowUpRight
                              size={16}
                              className="group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                            />

                          </div>

                        </div>

                      </Link>

                    </motion.article>

                  )
                )}

              </div>

            </div>

          </section>

        )}


      {/* =========================================
          CTA
      ========================================== */}

      <section className="bg-[#24201f] text-white py-24">

        <div className="max-w-3xl mx-auto px-6 text-center">

          <p className="text-xs uppercase tracking-[0.3em] text-rose-300">
            Your story could be next
          </p>

          <h2 className="font-serif text-4xl md:text-5xl mt-5 leading-tight">

            Planning your

            <span className="italic text-rose-300">
              {" "}special day?
            </span>

          </h2>

          <p className="text-gray-300 leading-7 mt-5">

            Check your date and send us a booking request.
            Let's create something beautiful together.

          </p>

          <Link
            to="/booking"
            className="inline-flex items-center gap-3 mt-8 px-8 py-4 rounded-full bg-white text-[#24201f] text-sm font-medium hover:bg-rose-500 hover:text-white transition"
          >

            Check Your Date

            <ArrowUpRight size={17} />

          </Link>

        </div>

      </section>

    </main>

  );
}
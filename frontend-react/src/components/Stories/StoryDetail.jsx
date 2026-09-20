import { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import {
  ArrowLeft,
  ArrowRight,
  ArrowUpRight,
  CalendarDays,
  ChevronLeft,
  ChevronRight,
  X,
  Sparkles,
} from "lucide-react";
import axios from "axios";
import { APP_CONFIG } from "../../config/app";

const API_URL = APP_CONFIG.API_BASE_URL;

function formatDate(dateString) {
  if (!dateString) {
    return "Latest story";
  }

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

function getCategory(blog) {
  return blog.category || "Beauty";
}

function getStoryDate(blog) {
  return blog.published_at || blog.created_at;
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

function getYouTubeVideoId(url) {
  if (!url) {
    return null;
  }

  const patterns = [
    /youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/,
    /youtu\.be\/([a-zA-Z0-9_-]{11})/,
    /youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/,
    /youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/,
  ];

  for (const pattern of patterns) {
    const match = url.match(pattern);

    if (match) {
      return match[1];
    }
  }

  return null;
}

export default function StoryDetail() {
  const { slug } = useParams();

  const [blog, setBlog] = useState(null);
  const [relatedStories, setRelatedStories] = useState([]);

  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  /*
   * Gallery lightbox
   */
  const [lightboxOpen, setLightboxOpen] = useState(false);
  const [activeImage, setActiveImage] = useState(0);


  /*
   * =========================================
   * LOAD STORY
   * =========================================
   */

  useEffect(() => {
    const loadBlog = async () => {
      try {
        setLoading(true);
        setError("");

        const response = await axios.get(
          `${API_URL}/api/blogs/${slug}`
        );

        if (
          response.data?.status &&
          response.data?.blog
        ) {
          const story = response.data.blog;

          /*
           * Public API already protects drafts,
           * but keep this frontend guard too.
           */
          if (
            story.status &&
            story.status !== "published"
          ) {
            setError(
              "This story is not currently available."
            );

            setBlog(null);
            return;
          }

          setBlog(story);
        } else {
          setError("Story not found.");
        }
      } catch (err) {
        console.error(
          "Failed to load story:",
          err
        );

        if (err.response?.status === 404) {
          setError("Story not found.");
        } else {
          setError(
            "Unable to load this story right now."
          );
        }
      } finally {
        setLoading(false);
      }
    };

    if (slug) {
      loadBlog();
    }
  }, [slug]);


  /*
   * =========================================
   * LOAD RELATED STORIES
   * =========================================
   */

  useEffect(() => {
    if (!blog) {
      return;
    }

    const loadRelatedStories = async () => {
      try {
        const response = await axios.get(
          `${API_URL}/api/blogs`
        );

        if (!response.data?.status) {
          return;
        }

        const stories = (
          response.data.blogs || []
        ).filter(
          (story) =>
            story.slug !== blog.slug &&
            (
              !story.status ||
              story.status === "published"
            )
        );

        /*
         * Prefer stories from the same category.
         */
        const sameCategory = stories.filter(
          (story) =>
            getCategory(story).toLowerCase() ===
            getCategory(blog).toLowerCase()
        );

        /*
         * If there aren't enough same-category stories,
         * fill the remaining slots with other stories.
         */
        const otherStories = stories.filter(
          (story) =>
            !sameCategory.some(
              (item) => item.id === story.id
            )
        );

        const combined = [
          ...sameCategory,
          ...otherStories,
        ].slice(0, 3);

        setRelatedStories(combined);
      } catch (err) {
        console.error(
          "Failed to load related stories:",
          err
        );

        setRelatedStories([]);
      }
    };

    loadRelatedStories();
  }, [blog]);


  /*
   * =========================================
   * GALLERY HELPERS
   * =========================================
   */

  const galleryImages = blog?.images || [];


  const openLightbox = (index) => {
    setActiveImage(index);
    setLightboxOpen(true);
  };


  const closeLightbox = () => {
    setLightboxOpen(false);
  };


  const showPreviousImage = () => {
    if (galleryImages.length === 0) {
      return;
    }

    setActiveImage((current) =>
      current === 0
        ? galleryImages.length - 1
        : current - 1
    );
  };


  const showNextImage = () => {
    if (galleryImages.length === 0) {
      return;
    }

    setActiveImage((current) =>
      current === galleryImages.length - 1
        ? 0
        : current + 1
    );
  };


  /*
   * =========================================
   * LIGHTBOX KEYBOARD CONTROLS
   * =========================================
   */

  useEffect(() => {
    if (!lightboxOpen) {
      return;
    }

    const handleKeyDown = (event) => {
      if (event.key === "Escape") {
        closeLightbox();
      }

      if (event.key === "ArrowLeft") {
        showPreviousImage();
      }

      if (event.key === "ArrowRight") {
        showNextImage();
      }
    };

    document.addEventListener(
      "keydown",
      handleKeyDown
    );

    /*
     * Prevent background page scrolling
     * while the lightbox is open.
     */
    document.body.style.overflow = "hidden";

    return () => {
      document.removeEventListener(
        "keydown",
        handleKeyDown
      );

      document.body.style.overflow = "";
    };
  }, [lightboxOpen, galleryImages.length]);


  /*
   * =========================================
   * LOADING
   * =========================================
   */

  if (loading) {
    return (
      <main className="bg-[#faf6f3] min-h-screen pt-36 pb-24">

        <div className="max-w-5xl mx-auto px-6">

          <div className="animate-pulse">

            <div className="h-4 w-32 bg-gray-200 rounded-full" />

            <div className="h-16 md:h-24 bg-gray-200 rounded-2xl mt-8 max-w-3xl" />

            <div className="h-6 bg-gray-200 rounded-full mt-5 max-w-xl" />

            <div className="aspect-[16/9] bg-gray-200 rounded-[2rem] mt-14" />

          </div>

        </div>

      </main>
    );
  }


  /*
   * =========================================
   * ERROR
   * =========================================
   */

  if (error || !blog) {
    return (
      <main className="bg-[#faf6f3] min-h-screen pt-36 pb-24">

        <div className="max-w-5xl mx-auto px-6">

          <Link
            to="/stories"
            className="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-rose-600 transition"
          >
            <ArrowLeft size={16} />
            Back to stories
          </Link>


          <div className="bg-white rounded-[2rem] p-12 md:p-16 text-center mt-10 shadow-sm">

            <Sparkles
              size={28}
              className="mx-auto text-rose-400"
            />

            <h1 className="font-serif text-4xl text-[#24201f] mt-5">
              Story unavailable
            </h1>

            <p className="text-gray-500 mt-4">
              {error || "We could not find this story."}
            </p>


            <Link
              to="/stories"
              className="inline-flex items-center gap-2 mt-8 px-7 py-3 rounded-full bg-[#24201f] text-white text-sm hover:bg-rose-600 transition"
            >
              <ArrowLeft size={16} />
              All stories
            </Link>

          </div>

        </div>

      </main>
    );
  }


  return (
    <main className="bg-[#faf6f3] min-h-screen">


      {/* =========================================
          BACK
      ========================================== */}

      <section className="pt-32">

        <div className="max-w-6xl mx-auto px-6">

          <Link
            to="/stories"
            className="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-rose-600 transition"
          >
            <ArrowLeft size={16} />
            Back to stories
          </Link>

        </div>

      </section>


      {/* =========================================
          ARTICLE
      ========================================== */}

      <article className="max-w-6xl mx-auto px-6 pt-12 pb-28">


        {/* Header */}

        <header className="max-w-4xl mx-auto text-center">

          <div className="flex flex-wrap items-center justify-center gap-4 text-xs uppercase tracking-[0.2em]">

            <span className="text-rose-500">
              {getCategory(blog)}
            </span>

            <span className="w-1 h-1 rounded-full bg-gray-300" />

            <span className="flex items-center gap-2 text-gray-400">

              <CalendarDays size={14} />

              {formatDate(
                getStoryDate(blog)
              )}

            </span>

          </div>


          <h1 className="font-serif text-5xl md:text-7xl text-[#24201f] leading-[1.05] mt-7">
            {blog.title}
          </h1>


          {blog.excerpt && (
            <p className="text-lg md:text-xl text-gray-600 leading-8 max-w-2xl mx-auto mt-7">
              {blog.excerpt}
            </p>
          )}

        </header>


        {/* =========================================
            FEATURED IMAGE
        ========================================== */}

        {blog.featured_image_url ? (

          <div className="relative aspect-[16/9] rounded-[2rem] overflow-hidden mt-14 bg-gray-100 shadow-sm">

            <img
              src={blog.featured_image_url}
              alt={blog.title}
              className="absolute inset-0 w-full h-full object-cover"
            />

          </div>

        ) : (

          <div className="relative aspect-[16/9] rounded-[2rem] overflow-hidden mt-14 bg-gradient-to-br from-rose-200 via-pink-100 to-orange-100">

            <div className="absolute inset-0 flex items-center justify-center">

              <div className="text-center">

                <span className="font-serif text-9xl text-white/50">
                  R
                </span>

                <p className="uppercase tracking-[0.4em] text-xs text-white/80 mt-3">
                  Rupanjali Makeup Artistry
                </p>

              </div>

            </div>

          </div>

        )}


        {/* =========================================
            CONTENT
        ========================================== */}

        <div className="max-w-3xl mx-auto mt-16">

          <div
            className="
              text-lg
              text-gray-700
              leading-9
              whitespace-pre-line
              break-words
            "
          >
          {blog.content}
        </div>


        {/* =========================================
            STORY VIDEO
        ========================================== */}

        {(blog.video_type === "upload" && blog.video_path) ||
        (blog.video_type === "youtube" && blog.video_url) ? (

          <section className="mt-16">

            <div className="flex items-center gap-3 mb-6">

              <span className="w-8 h-px bg-rose-400" />

              <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                Watch the story
              </p>

            </div>


            {blog.video_type === "upload" &&
              blog.video_path && (

                <div className="relative overflow-hidden rounded-[2rem] bg-black shadow-sm">

                  <video
                     src={`${API_URL}/uploads/blogs/videos/${blog.video_path}`}
                      autoPlay
                      muted
                      playsInline
                      controls
                      preload="metadata"
                      className="w-full h-auto max-h-[75vh] object-contain rounded-3xl bg-black"
                  >
                    <source
                      src={`${API_URL}/uploads/blogs/videos/${blog.video_path}`}
                      type={
                        blog.video_path
                          .toLowerCase()
                          .endsWith(".webm")
                          ? "video/webm"
                          : "video/mp4"
                      }
                    />

                    Your browser does not support video playback.
                  </video>

                </div>

              )}


            {blog.video_type === "youtube" &&
              blog.video_url && (
                (() => {
                  const youtubeId =
                    getYouTubeVideoId(
                      blog.video_url
                    );

                  if (!youtubeId) {
                    return null;
                  }

                  return (
                    <div className="relative w-full aspect-video overflow-hidden rounded-[2rem] bg-black shadow-sm">

                      <iframe
                        src={`https://www.youtube.com/embed/${youtubeId}`}
                        title={blog.title}
                        className="absolute inset-0 w-full h-full"
                        frameBorder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowFullScreen
                      />

                    </div>
                  );
                })()
              )}

          </section>

        ) : null}


        {/* =========================================
            GALLERY
        ========================================== */}

          {galleryImages.length > 0 && (

            <section className="mt-16">

              <div className="flex items-center justify-between gap-4 mb-6">

                <div>

                  <div className="flex items-center gap-3">

                    <span className="w-8 h-px bg-rose-400" />

                    <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                      From the story
                    </p>

                  </div>

                  <p className="text-sm text-gray-400 mt-2">
                    Tap an image to view it full screen
                  </p>

                </div>


                <span className="text-xs text-gray-400">
                  {galleryImages.length}{" "}
                  {galleryImages.length === 1
                    ? "image"
                    : "images"}
                </span>

              </div>


              <div className="grid grid-cols-1 md:grid-cols-2 gap-5">

                {galleryImages.map(
                  (image, index) => (

                    <button
                      key={image.id}
                      type="button"
                      onClick={() =>
                        openLightbox(index)
                      }
                      className="
                        group
                        relative
                        aspect-square
                        rounded-3xl
                        overflow-hidden
                        bg-gray-100
                        text-left
                        focus:outline-none
                        focus:ring-2
                        focus:ring-rose-400
                        focus:ring-offset-2
                      "
                      aria-label={`Open gallery image ${
                        index + 1
                      }`}
                    >

                      <img
                        src={image.image_url}
                        alt={`${blog.title} - image ${
                          index + 1
                        }`}
                        loading="lazy"
                        className="
                          w-full
                          h-full
                          object-cover
                          group-hover:scale-105
                          transition
                          duration-700
                        "
                      />


                      <div className="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300" />


                      <div className="absolute bottom-4 right-4 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition">

                        <ArrowRight size={16} />

                      </div>

                    </button>

                  )
                )}

              </div>

            </section>

          )}


          {/* =========================================
              INSTAGRAM
          ========================================== */}

          {/* =========================================
              CONNECT / CONTACT
          ========================================== */}

          <section className="mt-16">

            <div className="rounded-3xl bg-white border border-black/5 p-7 md:p-9 shadow-sm">

              <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-7">

                <div>

                  <div className="flex items-center gap-3 mb-3">

                    <span className="w-8 h-px bg-rose-400" />

                    <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                      Stay connected
                    </p>

                  </div>

                  <h3 className="font-serif text-3xl md:text-4xl text-[#24201f]">
                    Love this look?
                  </h3>

                  <p className="text-sm text-gray-500 mt-2 max-w-md leading-relaxed">
                    Let's create something beautiful for your special
                    occasion. Explore more work or get in touch directly.
                  </p>

                </div>


                <div className="flex flex-wrap items-center gap-3">

                  <a
                    href="https://www.instagram.com/_rupanjalis_makeup_artistry_/"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-2 rounded-full border border-black/10 px-4 py-2.5 text-sm hover:border-rose-300 hover:text-rose-600 transition"
                  >
                    Instagram
                  </a>

                  <a
                    href="https://www.facebook.com/people/Rupanjalis-Make-up-Artistry-An-ISO-90012015-ISO-299932017-Certified/100064056279759/"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-2 rounded-full border border-black/10 px-4 py-2.5 text-sm hover:border-rose-300 hover:text-rose-600 transition"
                  >
                    Facebook
                  </a>

                  <a
                    href="https://wa.me/918637375351?text=Hello%20Rupanjali%2C%20I%20would%20like%20to%20enquire%20about%20your%20makeup%20services."
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-2 rounded-full bg-ink text-white px-5 py-2.5 text-sm hover:bg-rose-600 transition"
                  >
                    WhatsApp
                  </a>

                  <Link
                    to="/booking"
                    className="inline-flex items-center gap-2 rounded-full bg-rose-500 text-white px-5 py-2.5 text-sm hover:bg-rose-600 transition"
                  >
                    Book a Date
                    <ArrowUpRight size={15} />
                  </Link>

                </div>

              </div>

            </div>

          </section>

        </div>


        {/* =========================================
            RELATED STORIES
        ========================================== */}

        {relatedStories.length > 0 && (

          <section className="mt-24 pt-16 border-t border-black/10">

            <div className="flex items-end justify-between gap-5 mb-8">

              <div>

                <div className="flex items-center gap-3">

                  <span className="w-8 h-px bg-rose-400" />

                  <p className="text-xs uppercase tracking-[0.25em] text-rose-500">
                    Keep reading
                  </p>

                </div>

                <h2 className="font-serif text-4xl md:text-5xl text-[#24201f] mt-3">
                  More from the journal
                </h2>

              </div>


              <Link
                to="/stories"
                className="hidden sm:inline-flex items-center gap-2 text-sm font-medium hover:text-rose-600 transition"
              >
                View all
                <ArrowRight size={16} />
              </Link>

            </div>


            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

              {relatedStories.map((story) => {

                const image =
                  getImage(story);

                return (

                  <Link
                    key={story.id}
                    to={`/stories/${story.slug}`}
                    className="group bg-white rounded-[1.7rem] overflow-hidden shadow-sm hover:shadow-xl transition duration-500"
                  >

                    {/* Image */}

                    <div className="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-rose-100 via-pink-100 to-orange-100">

                      {image ? (

                        <img
                          src={image}
                          alt={story.title}
                          loading="lazy"
                          className="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700"
                        />

                      ) : (

                        <div className="absolute inset-0 flex items-center justify-center">

                          <span className="font-serif text-7xl text-white/50">
                            R
                          </span>

                        </div>

                      )}


                      <div className="absolute top-4 left-4 bg-white/90 backdrop-blur-md rounded-full px-3 py-1.5 text-[10px] uppercase tracking-[0.2em]">
                        {getCategory(story)}
                      </div>

                    </div>


                    {/* Content */}

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


                      {story.excerpt && (

                        <p className="text-sm text-gray-600 leading-6 mt-3 line-clamp-3">
                          {story.excerpt}
                        </p>

                      )}


                      <div className="flex items-center gap-2 mt-6 text-sm font-medium">

                        Read story

                        <ArrowUpRight
                          size={16}
                          className="group-hover:translate-x-1 group-hover:-translate-y-1 transition"
                        />

                      </div>

                    </div>

                  </Link>

                );
              })}

            </div>


            <Link
              to="/stories"
              className="sm:hidden inline-flex items-center gap-2 mt-7 text-sm font-medium hover:text-rose-600 transition"
            >
              View all stories
              <ArrowRight size={16} />
            </Link>

          </section>

        )}


        {/* =========================================
            FOOTER NAVIGATION
        ========================================== */}

        <div className="max-w-3xl mx-auto mt-16 pt-8 border-t border-black/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

          <Link
            to="/stories"
            className="inline-flex items-center gap-2 text-sm font-medium hover:text-rose-600 transition"
          >
            <ArrowLeft size={16} />
            All stories
          </Link>


          <Link
            to="/booking"
            className="inline-flex items-center gap-2 text-sm font-medium hover:text-rose-600 transition"
          >
            Check availability
            <ArrowRight size={16} />
          </Link>

        </div>

      </article>


      {/* =========================================
          FINAL CTA
      ========================================== */}

      <section className="bg-[#24201f] text-white py-24">

        <div className="max-w-3xl mx-auto px-6 text-center">

          <p className="text-xs uppercase tracking-[0.3em] text-rose-300">
            Your beauty story
          </p>


          <h2 className="font-serif text-4xl md:text-5xl mt-5 leading-tight">

            Ready for your

            <span className="italic text-rose-300">
              {" "}special day?
            </span>

          </h2>


          <p className="text-gray-300 leading-7 mt-5">
            Check your date and send a booking request.
            Let's create something beautiful together.
          </p>


          <Link
            to="/booking"
            className="inline-flex items-center gap-3 mt-8 px-8 py-4 rounded-full bg-white text-[#24201f] text-sm font-medium hover:bg-rose-500 hover:text-white transition"
          >

            Check Your Date

            <ArrowRight size={17} />

          </Link>

        </div>

      </section>


      {/* =========================================
          GALLERY LIGHTBOX
      ========================================== */}

      {lightboxOpen &&
        galleryImages.length > 0 && (

          <div
            className="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center"
            role="dialog"
            aria-modal="true"
            aria-label="Story image viewer"
            onClick={(event) => {

              /*
               * Clicking the dark background closes
               * the lightbox.
               */
              if (event.target === event.currentTarget) {
                closeLightbox();
              }

            }}
          >

            {/* Close */}

            <button
              type="button"
              onClick={closeLightbox}
              className="
                absolute
                top-5
                right-5
                md:top-7
                md:right-7
                z-20
                w-11
                h-11
                rounded-full
                bg-white/10
                hover:bg-white/20
                text-white
                flex
                items-center
                justify-center
                transition
              "
              aria-label="Close image viewer"
            >

              <X size={22} />

            </button>


            {/* Counter */}

            <div className="absolute top-7 left-1/2 -translate-x-1/2 text-white/80 text-xs tracking-[0.2em] uppercase">

              {activeImage + 1}
              {" / "}
              {galleryImages.length}

            </div>


            {/* Previous */}

            {galleryImages.length > 1 && (

              <button
                type="button"
                onClick={showPreviousImage}
                className="
                  absolute
                  left-3
                  md:left-7
                  top-1/2
                  -translate-y-1/2
                  z-20
                  w-11
                  h-11
                  md:w-12
                  md:h-12
                  rounded-full
                  bg-white/10
                  hover:bg-white/20
                  text-white
                  flex
                  items-center
                  justify-center
                  transition
                "
                aria-label="Previous image"
              >

                <ChevronLeft size={24} />

              </button>

            )}


            {/* Next */}

            {galleryImages.length > 1 && (

              <button
                type="button"
                onClick={showNextImage}
                className="
                  absolute
                  right-3
                  md:right-7
                  top-1/2
                  -translate-y-1/2
                  z-20
                  w-11
                  h-11
                  md:w-12
                  md:h-12
                  rounded-full
                  bg-white/10
                  hover:bg-white/20
                  text-white
                  flex
                  items-center
                  justify-center
                  transition
                "
                aria-label="Next image"
              >

                <ChevronRight size={24} />

              </button>

            )}


            {/* Image */}

            <div className="w-full h-full px-14 md:px-24 py-20 flex items-center justify-center">

              <img
                src={
                  galleryImages[activeImage]
                    ?.image_url
                }
                alt={`${blog.title} - image ${
                  activeImage + 1
                }`}
                className="
                  max-w-full
                  max-h-full
                  object-contain
                  rounded-xl
                  shadow-2xl
                  select-none
                "
                onClick={(event) =>
                  event.stopPropagation()
                }
              />

            </div>

          </div>

        )}

    </main>
  );
}
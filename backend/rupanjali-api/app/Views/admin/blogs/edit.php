<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<main class="flex-1 p-6 md:p-10 bg-gray-50 min-h-screen">

    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="mb-8">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

                <div>

                    <p class="text-xs uppercase tracking-[0.25em] text-pink-500 font-semibold">
                        Stories & Journal
                    </p>

                    <h1 class="text-3xl md:text-4xl font-bold mt-2 text-gray-900">
                        Edit Story
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Refine your story, publishing details and visual gallery.
                    </p>

                </div>

                <a
                    href="/admin/blogs"
                    class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition font-medium"
                >
                    ← Back to Stories
                </a>

            </div>

        </div>


        <!-- Flash Messages -->

        <?php if (session()->getFlashdata('success')): ?>

            <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100 text-green-700">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')): ?>

            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>

        <?php endif; ?>


        <form
            action="/admin/blogs/update/<?= $blog['id'] ?>"
            method="POST"
            enctype="multipart/form-data"
        >

            <div class="grid xl:grid-cols-[1fr_340px] gap-7">


                <!-- =========================
                     MAIN EDITOR
                ========================== -->

                <div class="space-y-7">


                    <!-- Basic Information -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

                        <div class="mb-6">

                            <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">
                                Story Details
                            </p>

                            <h2 class="text-xl font-bold mt-1">
                                Basic Information
                            </h2>

                        </div>


                        <!-- Title -->

                        <div class="mb-6">

                            <label class="block font-semibold mb-2">
                                Story Title
                            </label>

                            <input
                                type="text"
                                id="storyTitle"
                                name="title"
                                value="<?= esc($blog['title'] ?? '') ?>"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-300 transition"
                                required
                            >

                        </div>


                        <!-- Slug -->

                        <div class="mb-6">

                            <label class="block font-semibold mb-2">
                                URL Slug
                            </label>

                            <input
                                type="text"
                                id="storySlug"
                                name="slug"
                                value="<?= esc($blog['slug'] ?? '') ?>"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-300 transition"
                                required
                            >

                            <div class="mt-3 px-4 py-3 rounded-xl bg-pink-50 border border-pink-100">

                                <p class="text-xs text-gray-500">
                                    Public URL
                                </p>

                                <p
                                    id="slugPreview"
                                    class="text-sm text-pink-600 font-medium mt-1 break-all"
                                >
                                    /stories/<?= esc($blog['slug'] ?? '') ?>
                                </p>

                            </div>

                        </div>


                        <!-- Category -->

                        <div class="mb-6">

                            <label class="block font-semibold mb-2">
                                Category
                            </label>

                            <input
                                type="text"
                                name="category"
                                value="<?= esc($blog['category'] ?? '') ?>"
                                placeholder="Bridal Beauty, Makeup Tips, Inspiration..."
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-300 transition"
                            >

                            <p class="text-xs text-gray-400 mt-2">
                                Helps organize stories on the website.
                            </p>

                        </div>


                        <!-- Excerpt -->

                        <div>

                            <div class="flex items-center justify-between mb-2">

                                <label class="block font-semibold">
                                    Short Excerpt
                                </label>

                                <span
                                    id="excerptCounter"
                                    class="text-xs text-gray-400"
                                >
                                    0 / 300
                                </span>

                            </div>

                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="4"
                                maxlength="300"
                                placeholder="A short introduction that will appear on story cards..."
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-300 transition resize-none"
                            ><?= esc($blog['excerpt'] ?? '') ?></textarea>

                            <p class="text-xs text-gray-400 mt-2">
                                Keep this concise so it looks good in story previews.
                            </p>

                        </div>

                    </section>


                    <!-- Story Content -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

                        <div class="mb-6">

                            <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">
                                Editorial
                            </p>

                            <h2 class="text-xl font-bold mt-1">
                                Story Content
                            </h2>

                        </div>


                        <textarea
                            name="content"
                            rows="18"
                            placeholder="Write your story..."
                            class="w-full px-4 py-4 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-300 transition resize-y leading-7"
                            required
                        ><?= esc($blog['content'] ?? '') ?></textarea>

                        <p class="text-xs text-gray-400 mt-3">
                            Use paragraphs and spacing to keep the published story easy to read.
                        </p>

                    </section>


                    <!-- Gallery -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

                        <div class="mb-6">

                            <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">
                                Visual Story
                            </p>

                            <h2 class="text-xl font-bold mt-1">
                                Gallery
                            </h2>

                            <p class="text-sm text-gray-400 mt-1">
                                Add more images to the story without removing your existing gallery.
                            </p>

                        </div>


                        <!-- Add Gallery Images -->

                        <div>

                            <label class="block font-semibold mb-2">
                                Add Gallery Images
                            </label>

                            <input
                                type="file"
                                id="galleryInput"
                                name="gallery_images[]"
                                accept="image/*"
                                multiple
                                class="w-full border border-gray-200 rounded-xl p-3 bg-gray-50"
                            >

                            <p class="text-xs text-gray-400 mt-2">
                                You can select multiple images at once.
                            </p>

                        </div>


                        <!-- New Gallery Preview -->

                        <div
                            id="galleryPreview"
                            class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6"
                        ></div>


                        <!-- Existing Gallery -->

                        <div class="mt-8 pt-7 border-t border-gray-100">

                            <div class="flex items-center justify-between mb-5">

                                <div>

                                    <h3 class="font-semibold text-lg">
                                        Existing Gallery
                                    </h3>

                                    <p class="text-sm text-gray-400">
                                        <?= count($images ?? []) ?> image(s)
                                    </p>

                                </div>

                            </div>


                            <?php if (!empty($images)): ?>

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-5">

                                    <?php foreach ($images as $image): ?>

                                        <div class="group relative overflow-hidden rounded-2xl bg-gray-100">

                                            <img
                                                src="/uploads/blogs/<?= esc($image['image_path']) ?>"
                                                alt="Story gallery"
                                                loading="lazy"
                                                class="w-full aspect-square object-cover transition duration-300 group-hover:scale-105"
                                            >

                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/25 transition"></div>

                                            <a
                                                href="/admin/blogs/images/delete/<?= $image['id'] ?>"
                                                onclick="return confirm('Delete this gallery image?')"
                                                class="absolute top-3 right-3 bg-white text-red-600 px-3 py-2 rounded-full text-xs font-semibold shadow hover:bg-red-50 transition"
                                            >
                                                Delete
                                            </a>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            <?php else: ?>

                                <div class="border border-dashed border-gray-200 rounded-2xl p-10 text-center text-gray-400">
                                    No gallery images yet.
                                </div>

                            <?php endif; ?>

                        </div>

                    </section>

                    <!-- STORY VIDEO -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">

                        <div class="mb-6">

                            <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">
                                Story Video
                            </p>

                            <h2 class="text-xl font-bold mt-1">
                                Video
                            </h2>

                            <p class="text-sm text-gray-400 mt-1">
                                Add or replace the video for this story.
                            </p>

                        </div>


                        <!-- Existing Video -->

                        <?php if (
                            !empty($blog['video_type']) &&
                            (
                                !empty($blog['video_path']) ||
                                !empty($blog['video_url'])
                            )
                        ): ?>

                            <div class="mb-7">

                                <p class="text-sm font-semibold mb-3">
                                    Current Video
                                </p>


                                <?php if ($blog['video_type'] === 'upload' && !empty($blog['video_path'])): ?>

                                    <div class="overflow-hidden rounded-2xl bg-black">

                                        <video
                                            src="/uploads/blogs/videos/<?= esc($blog['video_path']) ?>"
                                            controls
                                            playsinline
                                            class="w-full max-h-[420px] object-contain"
                                        ></video>

                                    </div>

                                <?php elseif ($blog['video_type'] === 'youtube' && !empty($blog['video_url'])): ?>

                                    <?php
                                        $youtubeId = null;

                                        if (preg_match(
                                            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/',
                                            $blog['video_url'],
                                            $matches
                                        )) {
                                            $youtubeId = $matches[1];
                                        }
                                    ?>

                                    <?php if ($youtubeId): ?>

                                        <div class="aspect-video overflow-hidden rounded-2xl bg-black">

                                            <iframe
                                                src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>"
                                                title="Story video"
                                                class="w-full h-full"
                                                loading="lazy"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen
                                            ></iframe>

                                        </div>

                                    <?php endif; ?>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>


                        <!-- Replace / Add Video -->

                        <div>

                            <label
                                for="storyVideo"
                                class="block cursor-pointer rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 p-6 text-center hover:border-pink-300 transition"
                            >

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-pink-50">

                                    <span class="text-lg text-pink-500">
                                        ▶
                                    </span>

                                </div>

                                <p class="mt-3 text-sm font-semibold">
                                    Upload a new video
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    MP4 or WebM · Maximum 100 MB
                                </p>

                                <input
                                    id="storyVideo"
                                    type="file"
                                    name="video_file"
                                    accept="video/mp4,video/webm"
                                    class="hidden"
                                >

                            </label>


                            <div
                                id="videoFileName"
                                class="mt-3 text-sm text-gray-400 text-center hidden"
                            ></div>


                            <div class="flex items-center gap-4 my-6">

                                <div class="h-px flex-1 bg-gray-100"></div>

                                <span class="text-xs uppercase tracking-wider text-gray-400">
                                    or
                                </span>

                                <div class="h-px flex-1 bg-gray-100"></div>

                            </div>


                            <label
                                for="videoUrl"
                                class="block font-semibold mb-2"
                            >
                                YouTube video URL
                            </label>

                            <input
                                id="videoUrl"
                                type="url"
                                name="video_url"
                                value="<?= esc($blog['video_url'] ?? '') ?>"
                                placeholder="https://www.youtube.com/watch?v=..."
                                class="w-full border border-gray-200 rounded-xl p-3 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-300"
                            >

                            <p class="text-xs text-gray-400 mt-2">
                                Adding a new video replaces the current video.
                            </p>

                        </div>


                        <!-- New Video Preview -->

                        <div
                            id="videoPreview"
                            class="hidden overflow-hidden rounded-2xl bg-black mt-6"
                        >

                            <video
                                id="videoPreviewPlayer"
                                controls
                                playsinline
                                class="w-full max-h-[420px] object-contain"
                            ></video>

                        </div>

                    </section>

                    <!-- Actions -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                        <div class="flex flex-col sm:flex-row gap-3">

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center bg-pink-600 hover:bg-pink-700 text-white px-7 py-3.5 rounded-xl font-semibold transition shadow-sm"
                            >
                                Save Changes
                            </button>

                            <a
                                href="/admin/blogs"
                                class="inline-flex items-center justify-center px-7 py-3.5 rounded-xl border border-gray-200 hover:bg-gray-50 transition font-medium"
                            >
                                Cancel
                            </a>

                            <a
                                href="/admin/blogs/delete/<?= $blog['id'] ?>"
                                onclick="return confirm('Delete this entire story and all of its images? This cannot be undone.')"
                                class="inline-flex items-center justify-center px-7 py-3.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition sm:ml-auto"
                            >
                                Delete Story
                            </a>

                        </div>

                    </section>

                </div>


                <!-- =========================
                     SIDEBAR
                ========================== -->

                <aside class="space-y-7">


                    <!-- Publishing -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                        <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">
                            Publishing
                        </p>

                        <h2 class="text-xl font-bold mt-1 mb-6">
                            Story Status
                        </h2>


                        <!-- Status -->

                        <div class="mb-5">

                            <label class="block font-semibold mb-2">
                                Status
                            </label>

                            <select
                                name="status"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 bg-white"
                            >

                                <option
                                    value="published"
                                    <?= ($blog['status'] ?? 'published') === 'published' ? 'selected' : '' ?>
                                >
                                    Published
                                </option>

                                <option
                                    value="draft"
                                    <?= ($blog['status'] ?? '') === 'draft' ? 'selected' : '' ?>
                                >
                                    Draft
                                </option>

                            </select>

                        </div>


                        <!-- Published Date -->

                        <div>

                            <label class="block font-semibold mb-2">
                                Published Date
                            </label>

                            <input
                                type="datetime-local"
                                name="published_at"
                                value="<?=
                                    !empty($blog['published_at'])
                                        ? date('Y-m-d\TH:i', strtotime($blog['published_at']))
                                        : ''
                                ?>"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400"
                            >

                            <p class="text-xs text-gray-400 mt-2">
                                Leave empty if you do not want to specify a publication date.
                            </p>

                        </div>

                    </section>


                    <!-- Featured Image -->

                    <section class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

                        <p class="text-xs uppercase tracking-wider text-pink-500 font-semibold">
                            Cover Image
                        </p>

                        <h2 class="text-xl font-bold mt-1 mb-5">
                            Featured Image
                        </h2>


                        <!-- Current Image -->

                        <?php if (!empty($blog['featured_image'])): ?>

                            <div class="mb-5">

                                <div class="overflow-hidden rounded-2xl bg-gray-100">

                                    <img
                                        id="currentFeaturedImage"
                                        src="/uploads/blogs/<?= esc($blog['featured_image']) ?>"
                                        alt="<?= esc($blog['title']) ?>"
                                        class="w-full aspect-[4/3] object-cover"
                                    >

                                </div>

                                <p class="text-xs text-gray-400 mt-2">
                                    Current featured image
                                </p>

                            </div>

                        <?php endif; ?>


                        <!-- New Image -->

                        <input
                            type="file"
                            id="featuredImageInput"
                            name="featured_image"
                            accept="image/*"
                            class="w-full border border-gray-200 rounded-xl p-3 bg-gray-50"
                        >

                        <div
                            id="featuredPreviewWrapper"
                            class="hidden mt-4"
                        >

                            <p class="text-xs font-semibold text-gray-500 mb-2">
                                New image preview
                            </p>

                            <img
                                id="featuredPreview"
                                src=""
                                alt="New featured image preview"
                                class="w-full aspect-[4/3] object-cover rounded-2xl"
                            >

                        </div>

                        <p class="text-xs text-gray-400 mt-2">
                            Upload a new image only if you want to replace the current one.
                        </p>

                    </section>


                    <!-- Story Info -->

                    <section class="bg-gray-900 text-white rounded-3xl p-6">

                        <p class="text-xs uppercase tracking-wider text-pink-300 font-semibold">
                            Story Information
                        </p>

                        <div class="mt-5 space-y-4">

                            <div>
                                <p class="text-xs text-gray-400">
                                    Story ID
                                </p>

                                <p class="font-semibold mt-1">
                                    #<?= esc($blog['id']) ?>
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-gray-400">
                                    Created
                                </p>

                                <p class="font-semibold mt-1 text-sm">
                                    <?= esc($blog['created_at'] ?? '—') ?>
                                </p>
                            </div>


                            <?php if (!empty($blog['slug'])): ?>

                                <div>

                                    <p class="text-xs text-gray-400">
                                        Current Slug
                                    </p>

                                    <p class="font-semibold mt-1 text-sm break-all">
                                        <?= esc($blog['slug']) ?>
                                    </p>

                                </div>

                            <?php endif; ?>

                        </div>

                    </section>

                </aside>

            </div>

        </form>

    </div>

</main>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
     * ----------------------------------------
     * SLUG PREVIEW
     * ----------------------------------------
     */

    const slugInput = document.getElementById('storySlug');
    const slugPreview = document.getElementById('slugPreview');

    function updateSlugPreview() {

        if (!slugInput || !slugPreview) {
            return;
        }

        slugPreview.textContent =
            '/stories/' + slugInput.value.trim();

    }

    slugInput?.addEventListener('input', updateSlugPreview);

    updateSlugPreview();


    /*
     * ----------------------------------------
     * EXCERPT COUNTER
     * ----------------------------------------
     */

    const excerpt = document.getElementById('excerpt');
    const excerptCounter = document.getElementById('excerptCounter');

    function updateExcerptCounter() {

        if (!excerpt || !excerptCounter) {
            return;
        }

        excerptCounter.textContent =
            excerpt.value.length + ' / 300';

    }

    excerpt?.addEventListener('input', updateExcerptCounter);

    updateExcerptCounter();


    /*
     * ----------------------------------------
     * FEATURED IMAGE PREVIEW
     * ----------------------------------------
     */

    const featuredInput =
        document.getElementById('featuredImageInput');

    const featuredPreviewWrapper =
        document.getElementById('featuredPreviewWrapper');

    const featuredPreview =
        document.getElementById('featuredPreview');


    featuredInput?.addEventListener('change', function () {

        const file = this.files?.[0];

        if (!file) {

            featuredPreviewWrapper?.classList.add('hidden');

            if (featuredPreview) {
                featuredPreview.src = '';
            }

            return;
        }


        if (!file.type.startsWith('image/')) {

            alert('Please select an image file.');

            this.value = '';

            featuredPreviewWrapper?.classList.add('hidden');

            return;
        }


        const reader = new FileReader();

        reader.onload = function (event) {

            if (featuredPreview) {
                featuredPreview.src = event.target.result;
            }

            featuredPreviewWrapper?.classList.remove('hidden');

        };

        reader.readAsDataURL(file);

    });


    /*
     * ----------------------------------------
     * GALLERY IMAGE PREVIEW
     * ----------------------------------------
     */

    const galleryInput =
        document.getElementById('galleryInput');

    const galleryPreview =
        document.getElementById('galleryPreview');


    galleryInput?.addEventListener('change', function () {

        if (!galleryPreview) {
            return;
        }

        galleryPreview.innerHTML = '';


        Array.from(this.files || []).forEach(function (file) {

            if (!file.type.startsWith('image/')) {
                return;
            }


            const reader = new FileReader();


            reader.onload = function (event) {

                const wrapper =
                    document.createElement('div');

                wrapper.className =
                    'relative overflow-hidden rounded-2xl bg-gray-100';


                const image =
                    document.createElement('img');

                image.src = event.target.result;

                image.alt = 'New gallery image';

                image.className =
                    'w-full aspect-square object-cover';


                wrapper.appendChild(image);

                galleryPreview.appendChild(wrapper);

            };


            reader.readAsDataURL(file);

        });

    });

});

document.addEventListener('DOMContentLoaded', function () {
    const storyVideoInput = document.getElementById('storyVideo');
    const videoFileName = document.getElementById('videoFileName');
    const videoPreview = document.getElementById('videoPreview');
    const videoPreviewPlayer = document.getElementById('videoPreviewPlayer');
    const videoUrlInput = document.getElementById('videoUrl');

    storyVideoInput?.addEventListener('change', function () {
        const file = this.files?.[0];

        if (!file) {
            videoFileName?.classList.add('hidden');
            videoPreview?.classList.add('hidden');
            return;
        }

        const maxSize = 100 * 1024 * 1024;

        if (file.size > maxSize) {
            alert('Video must be smaller than 100 MB.');

            this.value = '';

            videoFileName?.classList.add('hidden');
            videoPreview?.classList.add('hidden');

            return;
        }

        videoFileName.textContent =
            `${file.name} · ${(file.size / 1024 / 1024).toFixed(1)} MB`;

        videoFileName.classList.remove('hidden');

        if (videoUrlInput) {
            videoUrlInput.value = '';
        }

        const previewUrl = URL.createObjectURL(file);

        videoPreviewPlayer.src = previewUrl;
        videoPreviewPlayer.load();

        videoPreview.classList.remove('hidden');
    });

    videoUrlInput?.addEventListener('input', function () {
        if (this.value.trim() !== '') {
            if (storyVideoInput) {
                storyVideoInput.value = '';
            }

            videoFileName?.classList.add('hidden');
            videoPreview?.classList.add('hidden');
        }
    });
});

</script>


<?= view('admin/layout/footer') ?>
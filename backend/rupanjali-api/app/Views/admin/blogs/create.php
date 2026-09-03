<?= view('admin/layout/header', [
    'title' => 'Create Story | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<main class="flex-1 min-w-0 bg-[#faf7f5] min-h-screen">

    <div class="p-5 sm:p-6 lg:p-10">

        <div class="max-w-5xl mx-auto">

            <!-- HEADER -->

            <div class="mb-8">

                <a
                    href="<?= base_url('admin/blogs') ?>"
                    class="inline-flex items-center gap-2 text-sm text-[#a56b76] hover:underline mb-5"
                >
                    ← Back to Stories
                </a>

                <p class="text-[10px] uppercase tracking-[0.3em] text-[#a56b76] font-semibold">
                    Stories & Journal
                </p>

                <h1 class="mt-2 font-serif text-4xl sm:text-5xl text-[#292322]">
                    Create Story
                </h1>

                <p class="mt-3 text-sm sm:text-base text-[#817673]">
                    Create a beautiful story for your website.
                </p>

            </div>


            <!-- FLASH -->

            <?php if (session()->getFlashdata('error')): ?>

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>

            <?php endif; ?>


            <!-- FORM -->

            <form
                action="<?= site_url('admin/blogs/store') ?>"
                method="post"
                enctype="multipart/form-data"
            >


                <!-- BASIC INFORMATION -->

                <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                    <div class="px-5 sm:px-7 py-5 border-b border-[#eee5e5]">

                        <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                            Story information
                        </p>

                        <h2 class="mt-1 font-serif text-2xl text-[#292322]">
                            Tell your story
                        </h2>

                    </div>


                    <div class="p-5 sm:p-7 space-y-6">

                        <!-- TITLE -->

                        <div>

                            <label
                                for="storyTitle"
                                class="block text-sm font-semibold text-[#443b3d] mb-2"
                            >
                                Story Title
                            </label>

                            <input
                                id="storyTitle"
                                type="text"
                                name="title"
                                value="<?= esc(old('title')) ?>"
                                placeholder="The Making of a Timeless Bridal Look"
                                required
                                class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3.5 text-sm text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >

                        </div>


                        <!-- SLUG -->

                        <div>

                            <label
                                for="storySlug"
                                class="block text-sm font-semibold text-[#443b3d] mb-2"
                            >
                                URL Slug
                            </label>

                            <input
                                id="storySlug"
                                type="text"
                                name="slug"
                                value="<?= esc(old('slug')) ?>"
                                placeholder="timeless-bridal-look"
                                class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3.5 text-sm text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >

                            <p class="mt-2 text-xs text-[#a59a96]">
                                This becomes the public story URL.
                            </p>

                        </div>


                        <!-- CATEGORY + STATUS -->

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>

                                <label
                                    for="category"
                                    class="block text-sm font-semibold text-[#443b3d] mb-2"
                                >
                                    Category
                                </label>

                                <input
                                    id="category"
                                    type="text"
                                    name="category"
                                    value="<?= esc(old('category')) ?>"
                                    placeholder="Bridal Makeup"
                                    class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3.5 text-sm text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                                >

                                <p class="mt-2 text-xs text-[#a59a96]">
                                    Example: Bridal, Beauty Tips, Behind the Scenes.
                                </p>

                            </div>


                            <div>

                                <label
                                    for="status"
                                    class="block text-sm font-semibold text-[#443b3d] mb-2"
                                >
                                    Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3.5 text-sm text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                                >

                                    <option
                                        value="published"
                                        <?= old('status', 'published') === 'published' ? 'selected' : '' ?>
                                    >
                                        Published
                                    </option>

                                    <option
                                        value="draft"
                                        <?= old('status') === 'draft' ? 'selected' : '' ?>
                                    >
                                        Draft
                                    </option>

                                </select>

                            </div>

                        </div>


                        <!-- PUBLISHED AT -->

                        <div>

                            <label
                                for="published_at"
                                class="block text-sm font-semibold text-[#443b3d] mb-2"
                            >
                                Publish Date
                            </label>

                            <input
                                id="published_at"
                                type="datetime-local"
                                name="published_at"
                                value="<?= esc(old('published_at')) ?>"
                                class="w-full sm:max-w-md rounded-xl border border-[#ded3d5] bg-white px-4 py-3.5 text-sm text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >

                            <p class="mt-2 text-xs text-[#a59a96]">
                                Leave empty if you don't want to specify a publish date.
                            </p>

                        </div>


                        <!-- EXCERPT -->

                        <div>

                            <div class="flex items-center justify-between gap-3 mb-2">

                                <label
                                    for="excerpt"
                                    class="block text-sm font-semibold text-[#443b3d]"
                                >
                                    Short Excerpt
                                </label>

                                <span
                                    id="excerptCounter"
                                    class="text-xs text-[#a59a96]"
                                >
                                    0 / 220
                                </span>

                            </div>

                            <textarea
                                id="excerpt"
                                name="excerpt"
                                rows="3"
                                maxlength="220"
                                placeholder="A short introduction that will appear on story cards..."
                                class="w-full resize-none rounded-xl border border-[#ded3d5] bg-white px-4 py-3.5 text-sm leading-6 text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            ><?= esc(old('excerpt')) ?></textarea>

                            <p class="mt-2 text-xs text-[#a59a96]">
                                Keep this short and inviting. It will be used as the story preview.
                            </p>

                        </div>

                    </div>

                </section>


                <!-- CONTENT -->

                <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                    <div class="px-5 sm:px-7 py-5 border-b border-[#eee5e5]">

                        <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                            Editorial
                        </p>

                        <h2 class="mt-1 font-serif text-2xl text-[#292322]">
                            Story Content
                        </h2>

                    </div>


                    <div class="p-5 sm:p-7">

                        <textarea
                            name="content"
                            rows="16"
                            required
                            placeholder="Write your story here..."
                            class="w-full resize-y rounded-2xl border border-[#ded3d5] bg-white px-4 py-4 text-sm leading-7 text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                        ><?= esc(old('content')) ?></textarea>

                        <p class="mt-2 text-xs text-[#a59a96]">
                            Write the full story that visitors will read on the story page.
                        </p>

                    </div>

                </section>


                <!-- FEATURED IMAGE -->

                <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                    <div class="px-5 sm:px-7 py-5 border-b border-[#eee5e5]">

                        <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                            Cover image
                        </p>

                        <h2 class="mt-1 font-serif text-2xl text-[#292322]">
                            Featured Image
                        </h2>

                    </div>


                    <div class="p-5 sm:p-7">

                        <label
                            for="featuredImage"
                            class="group block cursor-pointer rounded-2xl border-2 border-dashed border-[#ded3d5] bg-[#faf7f5] p-6 sm:p-8 text-center hover:border-[#a56b76] transition"
                        >

                            <div
                                id="featuredPreview"
                                class="hidden mb-5"
                            >

                                <img
                                    id="featuredPreviewImage"
                                    src=""
                                    alt="Featured image preview"
                                    class="mx-auto max-h-72 rounded-2xl object-cover shadow-sm"
                                >

                            </div>


                            <div id="featuredPlaceholder">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-[#f2e4e7]">

                                    <span class="text-xl text-[#a56b76]">
                                        +
                                    </span>

                                </div>

                                <p class="mt-4 text-sm font-semibold text-[#443b3d]">
                                    Choose featured image
                                </p>

                                <p class="mt-1 text-xs text-[#a59a96]">
                                    JPG, PNG or WebP
                                </p>

                            </div>


                            <input
                                id="featuredImage"
                                type="file"
                                name="featured_image"
                                accept="image/*"
                                class="hidden"
                            >

                        </label>

                    </div>

                </section>


                <!-- GALLERY -->

                <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                    <div class="px-5 sm:px-7 py-5 border-b border-[#eee5e5]">

                        <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                            Story gallery
                        </p>

                        <h2 class="mt-1 font-serif text-2xl text-[#292322]">
                            Additional Images
                        </h2>

                    </div>


                    <div class="p-5 sm:p-7">

                        <label
                            for="galleryImages"
                            class="block cursor-pointer rounded-2xl border-2 border-dashed border-[#ded3d5] bg-[#faf7f5] p-6 text-center hover:border-[#a56b76] transition"
                        >

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#f2e4e7]">

                                <span class="text-lg text-[#a56b76]">
                                    +
                                </span>

                            </div>

                            <p class="mt-3 text-sm font-semibold text-[#443b3d]">
                                Add gallery images
                            </p>

                            <p class="mt-1 text-xs text-[#a59a96]">
                                Select multiple images at once
                            </p>

                            <input
                                id="galleryImages"
                                type="file"
                                name="gallery_images[]"
                                accept="image/*"
                                multiple
                                class="hidden"
                            >

                        </label>


                        <div
                            id="galleryPreview"
                            class="mt-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"
                        ></div>

                    </div>

                </section>

                <!-- STORY VIDEO -->
                <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-[#eadfe0]">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-[#3b3032]">Story Video</h2>
                                <p class="text-sm text-[#8b777b] mt-1">
                                    Add a short video to make this story more engaging.
                                </p>
                            </div>

                            <span class="text-xs font-medium px-3 py-1.5 rounded-full bg-[#faf3f4] text-[#8b6269]">
                                Optional
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">

                        <!-- Upload Video -->
                        <div>
                            <label class="block text-sm font-medium text-[#4a3d40] mb-2">
                                Upload Video
                            </label>

                            <label
                                for="storyVideo"
                                class="flex flex-col items-center justify-center w-full min-h-[180px] border-2 border-dashed border-[#e5d7da] rounded-2xl bg-[#fcfafb] hover:bg-[#faf5f6] hover:border-[#cdaeb4] transition cursor-pointer"
                            >
                                <div class="text-center px-6">
                                    <svg
                                        class="mx-auto w-10 h-10 text-[#b9959c] mb-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 19h8a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                        />
                                    </svg>

                                    <p class="text-sm font-medium text-[#514346]">
                                        Click to upload a video
                                    </p>

                                    <p class="text-xs text-[#9b898d] mt-1">
                                        MP4 or WebM · Maximum 100 MB
                                    </p>

                                    <p
                                        id="videoFileName"
                                        class="hidden text-sm font-medium text-[#8b6269] mt-3"
                                    ></p>
                                </div>

                                <input
                                    id="storyVideo"
                                    type="file"
                                    name="video_file"
                                    accept="video/mp4,video/webm"
                                    class="hidden"
                                >
                            </label>
                        </div>

                        <!-- OR divider -->
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-px bg-[#eadfe0]"></div>
                            <span class="text-xs uppercase tracking-[0.18em] text-[#a38f93]">
                                Or
                            </span>
                            <div class="flex-1 h-px bg-[#eadfe0]"></div>
                        </div>

                        <!-- YouTube -->
                        <div>
                            <label
                                for="videoUrl"
                                class="block text-sm font-medium text-[#4a3d40] mb-2"
                            >
                                YouTube Video URL
                            </label>

                            <input
                                id="videoUrl"
                                type="url"
                                name="video_url"
                                value="<?= esc(old('video_url')) ?>"
                                placeholder="https://www.youtube.com/watch?v=..."
                                class="w-full rounded-xl border border-[#dfd0d3] bg-white px-4 py-3 text-sm text-[#3b3032] outline-none transition focus:border-[#b9959c] focus:ring-2 focus:ring-[#b9959c]/10"
                            >

                            <p class="text-xs text-[#9b898d] mt-2">
                                Supports YouTube watch, short, embed and youtu.be links.
                            </p>
                        </div>

                        <!-- Local Preview -->
                        <div id="videoPreview" class="hidden">
                            <p class="text-sm font-medium text-[#4a3d40] mb-2">
                                Video Preview
                            </p>

                            <div class="overflow-hidden rounded-2xl bg-black">
                                <video
                                    id="videoPreviewPlayer"
                                    controls
                                    playsinline
                                    class="w-full max-h-[420px]"
                                ></video>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- ACTIONS -->

                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 pb-5">

                    <a
                        href="<?= base_url('admin/blogs') ?>"
                        class="inline-flex items-center justify-center rounded-xl border border-[#ded3d5] bg-white px-6 py-3.5 text-sm font-medium text-[#655b5d] hover:bg-[#faf6f3] transition"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-[#292322] px-7 py-3.5 text-sm font-semibold text-white hover:bg-[#3b3331] transition"
                    >
                        Publish Story
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>


<script>

const titleInput =
    document.getElementById('storyTitle');

const slugInput =
    document.getElementById('storySlug');

let slugManuallyEdited =
    slugInput.value.trim() !== '';


function makeSlug(text) {

    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');

}


slugInput.addEventListener('input', function () {

    slugManuallyEdited = true;

    this.value = makeSlug(this.value);

});


titleInput.addEventListener('input', function () {

    if (!slugManuallyEdited) {

        slugInput.value =
            makeSlug(this.value);

    }

});


/*
 * EXCERPT COUNTER
 */

const excerptInput =
    document.getElementById('excerpt');

const excerptCounter =
    document.getElementById('excerptCounter');


function updateExcerptCounter() {

    excerptCounter.textContent =
        `${excerptInput.value.length} / 220`;

}


excerptInput.addEventListener(
    'input',
    updateExcerptCounter
);

updateExcerptCounter();


/*
 * FEATURED IMAGE PREVIEW
 */

const featuredInput =
    document.getElementById('featuredImage');

const featuredPreview =
    document.getElementById('featuredPreview');

const featuredPreviewImage =
    document.getElementById('featuredPreviewImage');

const featuredPlaceholder =
    document.getElementById('featuredPlaceholder');


featuredInput.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) {
        return;
    }

    featuredPreviewImage.src =
        URL.createObjectURL(file);

    featuredPreview.classList.remove(
        'hidden'
    );

    featuredPlaceholder.classList.add(
        'hidden'
    );

});


/*
 * GALLERY PREVIEW
 */

const galleryInput =
    document.getElementById('galleryImages');

const galleryPreview =
    document.getElementById('galleryPreview');


galleryInput.addEventListener('change', function () {

    galleryPreview.innerHTML = '';

    Array.from(this.files).forEach(file => {

        const image =
            document.createElement('img');

        image.src =
            URL.createObjectURL(file);

        image.className =
            'w-full aspect-square object-cover rounded-xl';

        galleryPreview.appendChild(image);

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

            if (videoPreviewPlayer) {
                videoPreviewPlayer.removeAttribute('src');
                videoPreviewPlayer.load();
            }

            return;
        }

        const maxSize = 100 * 1024 * 1024;

        if (file.size > maxSize) {
            alert('Video must be smaller than 100 MB.');

            this.value = '';

            videoFileName?.classList.add('hidden');
            videoPreview?.classList.add('hidden');

            if (videoPreviewPlayer) {
                videoPreviewPlayer.removeAttribute('src');
                videoPreviewPlayer.load();
            }

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

            if (videoPreviewPlayer) {
                videoPreviewPlayer.removeAttribute('src');
                videoPreviewPlayer.load();
            }
        }
    });
});

</script>


<?= view('admin/layout/footer') ?>
<?= view('admin/layout/header', [
    'title' => 'Home | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<main class="flex-1 min-w-0 bg-[#faf7f5] min-h-screen">
    <div class="p-5 sm:p-6 lg:p-8 xl:p-10">
        <div class="max-w-[1500px] mx-auto">

            <div class="mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-10 h-px bg-[#c65d72]"></span>

                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72] font-semibold">
                        Home Page Management
                    </span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl text-[#292322]">
                    Home Page Images
                </h1>

                <p class="mt-3 text-sm sm:text-base text-[#817673] max-w-2xl">
                    Manage the images displayed across the public Home page.
                    Upload only the sections you want to change.
                </p>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form
                method="POST"
                action="<?= base_url('admin/home/update') ?>"
                enctype="multipart/form-data"
            >

                <?= csrf_field() ?>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Hero -->
                    <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                        <div class="aspect-[16/9] bg-[#f5efec] overflow-hidden">
                            <?php if (!empty($home['hero_image'])): ?>
                                <img
                                    src="<?= esc(base_url('uploads/home/' . $home['hero_image'])) ?>"
                                    alt="Home hero"
                                    class="w-full h-full object-cover"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="font-serif text-3xl text-[#c8b5b7]">
                                        Hero Image
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                                        Section 01
                                    </p>

                                    <h2 class="mt-2 font-serif text-2xl text-[#292322]">
                                        Hero Image
                                    </h2>

                                    <p class="mt-2 text-sm text-[#817673]">
                                        Main image shown at the top of the Home page.
                                    </p>
                                </div>

                                <span class="rounded-full bg-[#f7ecee] px-3 py-1 text-xs font-medium text-[#a56b76]">
                                    Hero
                                </span>
                            </div>

                            <label class="block mt-5">
                                <span class="text-sm font-medium text-[#4b3a3d]">
                                    Choose new image
                                </span>

                                <input
                                    type="file"
                                    name="hero_image"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="mt-2 block w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#655b5d] file:mr-4 file:rounded-lg file:border-0 file:bg-[#f3e6e8] file:px-4 file:py-2 file:text-sm file:font-medium file:text-[#8f5260]"
                                />
                            </label>

                            <p class="mt-2 text-xs text-[#9a8f91]">
                                JPG, PNG or WebP · Maximum 5 MB
                            </p>
                        </div>
                    </section>

                    <!-- Bridal -->
                    <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                        <div class="aspect-[16/9] bg-[#f5efec] overflow-hidden">
                            <?php if (!empty($home['bridal_image'])): ?>
                                <img
                                    src="<?= esc(base_url('uploads/home/' . $home['bridal_image'])) ?>"
                                    alt="Bridal makeup"
                                    class="w-full h-full object-cover"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="font-serif text-3xl text-[#c8b5b7]">
                                        Bridal Image
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                                        Section 02
                                    </p>

                                    <h2 class="mt-2 font-serif text-2xl text-[#292322]">
                                        Bridal Image
                                    </h2>

                                    <p class="mt-2 text-sm text-[#817673]">
                                        Image used for the Bridal Makeup section.
                                    </p>
                                </div>

                                <span class="rounded-full bg-[#f7ecee] px-3 py-1 text-xs font-medium text-[#a56b76]">
                                    Bridal
                                </span>
                            </div>

                            <label class="block mt-5">
                                <span class="text-sm font-medium text-[#4b3a3d]">
                                    Choose new image
                                </span>

                                <input
                                    type="file"
                                    name="bridal_image"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="mt-2 block w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#655b5d] file:mr-4 file:rounded-lg file:border-0 file:bg-[#f3e6e8] file:px-4 file:py-2 file:text-sm file:font-medium file:text-[#8f5260]"
                                />
                            </label>

                            <p class="mt-2 text-xs text-[#9a8f91]">
                                JPG, PNG or WebP · Maximum 5 MB
                            </p>
                        </div>
                    </section>

                    <!-- Engagement -->
                    <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                        <div class="aspect-[16/9] bg-[#f5efec] overflow-hidden">
                            <?php if (!empty($home['engagement_image'])): ?>
                                <img
                                    src="<?= esc(base_url('uploads/home/' . $home['engagement_image'])) ?>"
                                    alt="Engagement makeup"
                                    class="w-full h-full object-cover"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="font-serif text-3xl text-[#c8b5b7]">
                                        Engagement Image
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                                        Section 03
                                    </p>

                                    <h2 class="mt-2 font-serif text-2xl text-[#292322]">
                                        Engagement Image
                                    </h2>

                                    <p class="mt-2 text-sm text-[#817673]">
                                        Image used for the Engagement section.
                                    </p>
                                </div>

                                <span class="rounded-full bg-[#f7ecee] px-3 py-1 text-xs font-medium text-[#a56b76]">
                                    Engagement
                                </span>
                            </div>

                            <label class="block mt-5">
                                <span class="text-sm font-medium text-[#4b3a3d]">
                                    Choose new image
                                </span>

                                <input
                                    type="file"
                                    name="engagement_image"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="mt-2 block w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#655b5d] file:mr-4 file:rounded-lg file:border-0 file:bg-[#f3e6e8] file:px-4 file:py-2 file:text-sm file:font-medium file:text-[#8f5260]"
                                />
                            </label>

                            <p class="mt-2 text-xs text-[#9a8f91]">
                                JPG, PNG or WebP · Maximum 5 MB
                            </p>
                        </div>
                    </section>

                    <!-- Party -->
                    <section class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

                        <div class="aspect-[16/9] bg-[#f5efec] overflow-hidden">
                            <?php if (!empty($home['party_image'])): ?>
                                <img
                                    src="<?= esc(base_url('uploads/home/' . $home['party_image'])) ?>"
                                    alt="Party and events makeup"
                                    class="w-full h-full object-cover"
                                >
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="font-serif text-3xl text-[#c8b5b7]">
                                        Party Image
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                                        Section 04
                                    </p>

                                    <h2 class="mt-2 font-serif text-2xl text-[#292322]">
                                        Party & Events Image
                                    </h2>

                                    <p class="mt-2 text-sm text-[#817673]">
                                        Image used for Party and Events content.
                                    </p>
                                </div>

                                <span class="rounded-full bg-[#f7ecee] px-3 py-1 text-xs font-medium text-[#a56b76]">
                                    Events
                                </span>
                            </div>

                            <label class="block mt-5">
                                <span class="text-sm font-medium text-[#4b3a3d]">
                                    Choose new image
                                </span>

                                <input
                                    type="file"
                                    name="party_image"
                                    accept="image/jpeg,image/png,image/webp"
                                    class="mt-2 block w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#655b5d] file:mr-4 file:rounded-lg file:border-0 file:bg-[#f3e6e8] file:px-4 file:py-2 file:text-sm file:font-medium file:text-[#8f5260]"
                                />
                            </label>

                            <p class="mt-2 text-xs text-[#9a8f91]">
                                JPG, PNG or WebP · Maximum 5 MB
                            </p>
                        </div>
                    </section>

                </div>

                <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 rounded-2xl border border-[#eadfe0] bg-white p-5 shadow-sm">

                    <div>
                        <p class="text-sm font-semibold text-[#4b3a3d]">
                            Save Home Page Changes
                        </p>

                        <p class="mt-1 text-xs text-[#817673]">
                            You can update one or multiple images at the same time.
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-[#292322] px-7 py-3.5 text-sm font-semibold text-white hover:bg-[#3b3331] transition"
                    >
                        Save Images
                    </button>

                </div>

            </form>

        </div>
    </div>
</main>
<div class="min-h-screen md:flex bg-[#faf6f3]">

    <!-- ================= MOBILE TOP BAR ================= -->

    <header class="md:hidden sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-black/5">

        <div class="h-16 px-5 flex items-center justify-between">

            <a href="/admin/dashboard" class="flex items-center gap-3">

                <div class="w-9 h-9 rounded-full bg-[#f7e4e7] flex items-center justify-center">
                    <span class="font-serif text-[#c65d72] text-lg">
                        R
                    </span>
                </div>

                <div>
                    <p class="font-serif text-lg leading-none text-[#292322]">
                        Rupanjali
                    </p>

                    <p class="text-[8px] uppercase tracking-[0.25em] text-[#b28a72] mt-1">
                        Makeup Artistry
                    </p>
                </div>

            </a>

            <button
                type="button"
                onclick="toggleAdminMenu()"
                class="w-10 h-10 rounded-full bg-[#292322] text-white flex items-center justify-center"
                aria-label="Open menu"
            >
                <svg
                    id="adminMenuIcon"
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                >
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <line x1="4" y1="18" x2="20" y2="18"/>
                </svg>
            </button>

        </div>


        <!-- Mobile Menu -->

        <div
            id="adminMobileMenu"
            class="hidden border-t border-black/5 bg-white px-5 py-4"
        >

            <nav class="space-y-1">

                <a href="/admin/dashboard" class="admin-mobile-link">
                    Dashboard
                </a>

                <a href="/admin/bookings" class="admin-mobile-link">
                    Bookings
                </a>

                <a href="/admin/bookings/create" class="admin-mobile-link">
                    Add Booking
                </a>

                <a href="/admin/availability" class="admin-mobile-link">
                    Availability
                </a>

                <a href="/admin/blogs" class="admin-mobile-link">
                    Stories & Blogs
                </a>

                <a href="/admin/blogs/create" class="admin-mobile-link">
                    Create Story
                </a>

                <a href="<?= base_url('admin/portfolio') ?>" class="admin-mobile-link">
                    Portfolio
                </a>

                <a href="<?= base_url('admin/services') ?>" class="admin-mobile-link">
                    Services
                </a>

                <a href="/admin/services/create" class="admin-mobile-link">
                    Add Service
                </a>

                <a
                    href="/admin/logout"
                    class="admin-mobile-link text-red-500"
                >
                    Logout
                </a>

            </nav>

        </div>

    </header>


    <!-- ================= DESKTOP SIDEBAR ================= -->

    <aside
        class="hidden md:flex md:w-64 lg:w-72 shrink-0 min-h-screen bg-[#292322] text-white flex-col"
    >

        <!-- Brand -->

        <div class="px-8 pt-10 pb-8">

            <a href="/admin/dashboard" class="block">

                <p class="font-serif text-3xl">
                    Rupanjali
                </p>

                <div class="flex items-center gap-2 mt-2">

                    <span class="w-6 h-px bg-[#d48a99]"></span>

                    <p class="text-[9px] uppercase tracking-[0.35em] text-[#d8b6a4]">
                        Makeup Artistry
                    </p>

                </div>

            </a>

        </div>


        <!-- Navigation -->

        <nav class="px-4 flex-1">

            <p class="px-4 mb-3 text-[10px] uppercase tracking-[0.3em] text-white/40">
                Manage
            </p>

            <a
                href="/admin/dashboard"
                class="admin-desktop-link"
            >
                <span class="admin-icon">⌂</span>
                Dashboard
            </a>

            <a
                href="/admin/bookings"
                class="admin-desktop-link"
            >
                <span class="admin-icon">○</span>
                Bookings
            </a>

            <a
                href="/admin/bookings/create"
                class="admin-desktop-link"
            >
                <span class="admin-icon">+</span>
                Add Booking
            </a>

            <a
                href="/admin/availability"
                class="admin-desktop-link"
            >
                <span class="admin-icon">□</span>
                Availability
            </a>


            <div class="h-px bg-white/10 my-5"></div>


            <p class="px-4 mb-3 text-[10px] uppercase tracking-[0.3em] text-white/40">
                Stories
            </p>

            <a
                href="/admin/blogs"
                class="admin-desktop-link"
            >
                <span class="admin-icon">✦</span>
                Stories & Blogs
            </a>

            <a
                href="/admin/blogs/create"
                class="admin-desktop-link"
            >
                <span class="admin-icon">+</span>
                Create Story
            </a>

            <a
                href="<?= base_url('admin/portfolio') ?>"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-[#655b5d] hover:bg-[#f5efec] hover:text-[#292322] transition"
            >
                <span>▧</span>
                Portfolio
            </a>

            <a
                href="<?= base_url('admin/services') ?>"
                class="admin-desktop-link"
            >
                <span class="admin-icon">◇</span>
                Services
            </a>

            <a
                href="<?= base_url('admin/services/create') ?>"
                class="admin-desktop-link"
            >
                <span class="admin-icon">+</span>
                Add Service
            </a>

        </nav>


        <!-- Bottom -->

        <div class="p-5">

            <div class="rounded-2xl bg-white/5 border border-white/10 p-4 mb-4">

                <p class="text-xs text-white/50">
                    Admin panel
                </p>

                <p class="text-sm mt-1">
                    Rupanjali Makeup Artistry
                </p>

            </div>

            <a
                href="/admin/logout"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/70 hover:text-white hover:bg-white/10 transition"
            >
                <span>↪</span>
                Logout
            </a>

        </div>

    </aside>


    <!-- ================= PAGE CONTENT STARTS HERE ================= -->

    <main class="flex-1 min-w-0">

        <div class="max-w-[1400px] mx-auto w-full px-4 py-6 sm:px-6 md:px-10 md:py-10">


<style>

    .admin-mobile-link {
        display: block;
        padding: 13px 14px;
        border-radius: 12px;
        font-size: 14px;
        color: #4b4543;
        transition: all .2s ease;
    }

    .admin-mobile-link:hover {
        background: #faf0f2;
        color: #c65d72;
    }


    .admin-desktop-link {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px 16px;
        margin-bottom: 4px;
        border-radius: 13px;
        color: rgba(255,255,255,.68);
        font-size: 14px;
        transition: all .2s ease;
    }

    .admin-desktop-link:hover {
        color: white;
        background: rgba(255,255,255,.09);
        transform: translateX(2px);
    }


    .admin-icon {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d9a0ac;
        font-size: 15px;
    }

</style>


<script>

    function toggleAdminMenu() {

        const menu = document.getElementById('adminMobileMenu');

        if (!menu) {
            return;
        }

        menu.classList.toggle('hidden');
    }

</script>

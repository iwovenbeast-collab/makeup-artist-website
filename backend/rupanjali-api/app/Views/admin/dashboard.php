<?= view('admin/layout/header', [
    'title' => 'Dashboard | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<div class="min-h-screen bg-[#faf7f4]">

    <div class="p-5 md:p-8 lg:p-10 max-w-[1600px] mx-auto">

        <!-- Header -->

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">

            <div>

                <div class="flex items-center gap-3 mb-3">

                    <span class="w-10 h-px bg-[#c65d72]"></span>

                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72]">
                        Admin Overview
                    </span>

                </div>

                <h1 class="font-serif text-4xl md:text-5xl text-[#292322]">
                    Welcome back, <?= esc(session()->get('admin_name')) ?>
                </h1>

                <p class="text-[#817673] mt-3">
                    Here's what's happening with your makeup artistry.
                </p>

            </div>

            <div class="flex flex-wrap gap-3">

                <a
                    href="/admin/availability"
                    class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-black/10 bg-white text-sm font-medium text-[#4d4542] hover:bg-[#f5efec] transition"
                >
                    View Calendar
                </a>

                <a
                    href="/admin/bookings/create"
                    class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-[#292322] text-white text-sm font-medium hover:bg-[#3b3331] transition"
                >
                    + Add Booking
                </a>

            </div>

        </div>


        <!-- Statistics -->

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <!-- Total -->

            <div class="bg-white rounded-3xl border border-black/5 shadow-sm p-5 md:p-6">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                            Total Bookings
                        </p>

                        <p class="font-serif text-4xl text-[#292322] mt-3">
                            <?= $totalBookings ?>
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-2xl bg-[#f7e9e9] flex items-center justify-center text-[#a85f70]">
                        ◇
                    </div>

                </div>

            </div>


            <!-- Pending -->

            <div class="bg-white rounded-3xl border border-black/5 shadow-sm p-5 md:p-6">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                            Pending
                        </p>

                        <p class="font-serif text-4xl text-[#b87932] mt-3">
                            <?= $pendingBookings ?>
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-2xl bg-[#fbf2df] flex items-center justify-center text-[#b87932]">
                        ○
                    </div>

                </div>

            </div>


            <!-- Confirmed -->

            <div class="bg-white rounded-3xl border border-black/5 shadow-sm p-5 md:p-6">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                            Confirmed
                        </p>

                        <p class="font-serif text-4xl text-[#668a63] mt-3">
                            <?= $confirmedBookings ?>
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-2xl bg-[#eaf3e8] flex items-center justify-center text-[#668a63]">
                        ✓
                    </div>

                </div>

            </div>


            <!-- Stories -->

            <div class="bg-white rounded-3xl border border-black/5 shadow-sm p-5 md:p-6">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                            Stories
                        </p>

                        <p class="font-serif text-4xl text-[#292322] mt-3">
                            <?= $totalBlogs ?>
                        </p>
                    </div>

                    <div class="w-11 h-11 rounded-2xl bg-[#f2eeeb] flex items-center justify-center text-[#665d59]">
                        ✦
                    </div>

                </div>

            </div>

        </div>


        <!-- Main Dashboard Grid -->

        <div class="grid xl:grid-cols-[1.35fr_0.65fr] gap-6 items-start">


            <!-- Upcoming Appointments -->

            <section class="bg-white rounded-3xl border border-black/5 shadow-sm overflow-hidden">

                <div class="p-5 md:p-6 border-b border-black/5 flex items-center justify-between">

                    <div>

                        <p class="text-[10px] uppercase tracking-[0.25em] text-[#c65d72]">
                            Your Calendar
                        </p>

                        <h2 class="font-serif text-2xl md:text-3xl text-[#292322] mt-1">
                            Upcoming Appointments
                        </h2>

                    </div>

                    <a
                        href="/admin/bookings"
                        class="text-sm font-medium text-[#a45e6e] hover:text-[#7f4655]"
                    >
                        View all →
                    </a>

                </div>


                <!-- SCROLLABLE APPOINTMENTS -->

                <div class="h-[420px] overflow-y-auto overscroll-contain">

                    <?php if (empty($upcomingBookings)): ?>

                        <div class="p-10 text-center">

                            <div class="w-14 h-14 mx-auto rounded-full bg-[#f5efec] flex items-center justify-center text-[#9a8f8b] text-xl">
                                ✦
                            </div>

                            <h3 class="font-serif text-xl text-[#292322] mt-4">
                                No upcoming appointments
                            </h3>

                            <p class="text-sm text-[#817673] mt-2">
                                New bookings will appear here.
                            </p>

                        </div>

                    <?php else: ?>

                        <div class="divide-y divide-black/5">

                            <?php foreach ($upcomingBookings as $booking): ?>

                                <?php
                                    $date = new \DateTime($booking['event_date']);

                                    $statusClass = match ($booking['status']) {
                                        'confirmed' => 'bg-[#eaf3e8] text-[#668a63]',
                                        'pending'   => 'bg-[#fbf2df] text-[#a87531]',
                                        default     => 'bg-gray-100 text-gray-500',
                                    };
                                ?>

                                <div class="p-5 md:p-6 hover:bg-[#fdfaf8] transition">

                                    <div class="flex gap-4">

                                        <!-- Date -->

                                        <div class="shrink-0 w-16 h-16 rounded-2xl bg-[#faf3f0] flex flex-col items-center justify-center">

                                            <span class="text-[10px] uppercase tracking-wider text-[#a45e6e]">
                                                <?= $date->format('M') ?>
                                            </span>

                                            <span class="font-serif text-2xl leading-none text-[#292322]">
                                                <?= $date->format('d') ?>
                                            </span>

                                        </div>


                                        <!-- Details -->

                                        <div class="min-w-0 flex-1">

                                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">

                                                <div>

                                                    <h3 class="font-medium text-[#292322] truncate">
                                                        <?= esc($booking['name']) ?>
                                                    </h3>

                                                    <p class="text-sm text-[#817673] mt-1">
                                                        <?= esc($booking['event_type']) ?>
                                                    </p>

                                                </div>

                                                <span class="self-start px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-semibold <?= $statusClass ?>">
                                                    <?= esc($booking['status']) ?>
                                                </span>

                                            </div>

                                            <div class="flex flex-wrap gap-x-5 gap-y-1 mt-3 text-sm text-[#706763]">

                                                <span>
                                                    <?= esc(date('g:i A', strtotime($booking['start_time']))) ?>
                                                    –
                                                    <?= esc(date('g:i A', strtotime($booking['end_time']))) ?>
                                                </span>

                                                <span class="truncate">
                                                    <?= esc($booking['location']) ?>
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>

                <?php if (count($upcomingBookings) >= 20): ?>

                    <div class="px-5 py-3 bg-[#faf6f3] border-t border-black/5 text-center text-xs text-[#817673]">
                        Showing the next 20 appointments ·
                        <a href="/admin/bookings" class="text-[#a45e6e] font-medium">
                            View all bookings
                        </a>
                    </div>

                <?php endif; ?>

            </section>


            <!-- Recent Bookings -->

            <section class="bg-white rounded-3xl border border-black/5 shadow-sm overflow-hidden">

                <div class="p-5 md:p-6 border-b border-black/5 flex items-center justify-between">

                    <div>

                        <p class="text-[10px] uppercase tracking-[0.25em] text-[#c65d72]">
                            Activity
                        </p>

                        <h2 class="font-serif text-2xl text-[#292322] mt-1">
                            Recent Bookings
                        </h2>

                    </div>

                    <a
                        href="/admin/bookings"
                        class="text-sm text-[#a45e6e]"
                    >
                        All →
                    </a>

                </div>


                <div class="max-h-[420px] overflow-y-auto divide-y divide-black/5">

                    <?php if (empty($recentBookings)): ?>

                        <div class="p-8 text-center text-sm text-[#817673]">
                            No booking activity yet.
                        </div>

                    <?php else: ?>

                        <?php foreach ($recentBookings as $booking): ?>

                            <div class="p-5">

                                <div class="flex items-center justify-between gap-3">

                                    <div class="min-w-0">

                                        <p class="font-medium text-[#292322] truncate">
                                            <?= esc($booking['name']) ?>
                                        </p>

                                        <p class="text-xs text-[#817673] mt-1">
                                            <?= esc($booking['event_type']) ?>
                                        </p>

                                    </div>

                                    <?php
                                        $recentStatusClass = match ($booking['status']) {
                                            'confirmed' => 'bg-[#eaf3e8] text-[#668a63]',
                                            'pending'   => 'bg-[#fbf2df] text-[#a87531]',
                                            'cancelled' => 'bg-[#f0eeee] text-[#77706d]',
                                            default     => 'bg-gray-100 text-gray-500',
                                        };
                                    ?>

                                    <span class="shrink-0 px-2.5 py-1 rounded-full text-[9px] uppercase tracking-wider font-semibold <?= $recentStatusClass ?>">
                                        <?= esc($booking['status']) ?>
                                    </span>

                                </div>

                                <p class="text-xs text-[#9a908b] mt-2">
                                    <?= esc(date('d M Y', strtotime($booking['event_date']))) ?>
                                </p>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </section>

        </div>


        <!-- Quick Actions -->

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">

            <a
                href="/admin/bookings"
                class="bg-white rounded-2xl border border-black/5 p-5 hover:-translate-y-0.5 hover:shadow-md transition"
            >
                <p class="text-xs uppercase tracking-wider text-[#9b908b]">
                    Manage
                </p>
                <p class="font-serif text-xl text-[#292322] mt-1">
                    Bookings →
                </p>
            </a>

            <a
                href="/admin/availability"
                class="bg-white rounded-2xl border border-black/5 p-5 hover:-translate-y-0.5 hover:shadow-md transition"
            >
                <p class="text-xs uppercase tracking-wider text-[#9b908b]">
                    Manage
                </p>
                <p class="font-serif text-xl text-[#292322] mt-1">
                    Availability →
                </p>
            </a>

            <a
                href="/admin/blogs"
                class="bg-white rounded-2xl border border-black/5 p-5 hover:-translate-y-0.5 hover:shadow-md transition"
            >
                <p class="text-xs uppercase tracking-wider text-[#9b908b]">
                    Manage
                </p>
                <p class="font-serif text-xl text-[#292322] mt-1">
                    Stories →
                </p>
            </a>

        </div>

    </div>

</div>

<?= view('admin/layout/footer') ?>

<?= $this->include('admin/layout/header') ?>
<?= $this->include('admin/layout/sidebar') ?>

<div class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8">

    <!-- PAGE HEADER -->
    <div class="mb-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                    Schedule Management
                </p>

                <h1 class="mt-1 text-2xl sm:text-3xl font-semibold text-[#332b2d]">
                    Availability Calendar
                </h1>

                <p class="mt-2 text-sm text-gray-500 max-w-2xl">
                    Manage appointments, unavailable periods and your available dates.
                </p>
            </div>

        </div>
    </div>


    <!-- FLASH MESSAGES -->
    <?php if (session()->getFlashdata('success')): ?>

        <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>


    <!-- CALENDAR CARD -->
    <div class="rounded-2xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

        <!-- LEGEND -->
        <div class="px-4 sm:px-6 py-4 border-b border-[#eee5e5]">

            <div class="flex flex-wrap items-center gap-x-5 gap-y-3 text-xs sm:text-sm text-gray-600">

                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-[#8caf8a]"></span>
                    Available
                </div>

                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-[#a56b76]"></span>
                    Confirmed
                </div>

                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-[#c89b50]"></span>
                    Pending
                </div>

                <div class="flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full bg-[#655b5d]"></span>
                    Unavailable
                </div>

            </div>

        </div>


        <!-- CALENDAR -->
        <div class="p-3 sm:p-5 lg:p-6">

            <div id="adminCalendar"></div>

        </div>

    </div>


    <!-- DETAILS PANEL -->
    <div
        id="eventInspector"
        class="hidden mt-5 rounded-2xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden"
    >

        <div class="px-5 sm:px-6 py-5 border-b border-[#eee5e5] flex items-start justify-between gap-4">

            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-[#a56b76] font-semibold">
                    Calendar Details
                </p>

                <h2
                    id="inspectorTitle"
                    class="mt-1 text-xl font-semibold text-[#332b2d]"
                ></h2>

                <p
                    id="inspectorSubtitle"
                    class="mt-1 text-sm text-gray-500"
                ></p>
            </div>


            <button
                type="button"
                onclick="closeInspector()"
                class="shrink-0 h-9 w-9 rounded-full bg-[#faf6f3] text-gray-500 hover:bg-[#f2e9e6] hover:text-[#332b2d] transition"
            >
                &times;
            </button>

        </div>


        <div
            id="inspectorContent"
            class="p-5 sm:p-6"
        ></div>

    </div>


    <!-- BLOCK AVAILABILITY -->
    <div class="mt-6 rounded-2xl border border-[#eadfe0] bg-white shadow-sm">

        <div class="px-5 sm:px-6 py-5 border-b border-[#eee5e5]">

            <p class="text-xs uppercase tracking-[0.2em] text-[#a56b76] font-semibold">
                Availability
            </p>

            <h2 class="mt-1 text-lg font-semibold text-[#332b2d]">
                Block Availability
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Block an entire day or a specific time period.
            </p>

        </div>


        <form
            action="<?= base_url('admin/availability/store') ?>"
            method="POST"
            class="p-5 sm:p-6"
        >

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- DATE -->
                <div>

                    <label
                        for="block_date"
                        class="block text-sm font-medium text-[#443b3d] mb-2"
                    >
                        Date
                    </label>

                    <input
                        type="date"
                        id="block_date"
                        name="block_date"
                        required
                        class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                    >

                </div>


                <!-- START TIME -->
                <div id="startTimeWrapper">

                    <label
                        for="start_time"
                        class="block text-sm font-medium text-[#443b3d] mb-2"
                    >
                        Start Time
                    </label>

                    <input
                        type="time"
                        id="start_time"
                        name="start_time"
                        class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                    >

                </div>


                <!-- END TIME -->
                <div id="endTimeWrapper">

                    <label
                        for="end_time"
                        class="block text-sm font-medium text-[#443b3d] mb-2"
                    >
                        End Time
                    </label>

                    <input
                        type="time"
                        id="end_time"
                        name="end_time"
                        class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                    >

                </div>


                <!-- REASON -->
                <div>

                    <label
                        for="reason"
                        class="block text-sm font-medium text-[#443b3d] mb-2"
                    >
                        Reason
                    </label>

                    <input
                        type="text"
                        id="reason"
                        name="reason"
                        placeholder="Personal work"
                        class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3 text-sm text-gray-700 outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                    >

                </div>

            </div>


            <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <label class="inline-flex items-center gap-3 cursor-pointer">

                    <input
                        type="checkbox"
                        id="all_day"
                        name="all_day"
                        value="1"
                        class="h-4 w-4 rounded border-gray-300 text-[#a56b76] focus:ring-[#a56b76]"
                    >

                    <span class="text-sm font-medium text-gray-700">
                        Block entire day
                    </span>

                </label>


                <button
                    type="submit"
                    class="w-full sm:w-auto rounded-xl bg-[#4b3a3d] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#382c2f] active:scale-[0.98]"
                >
                    Block Availability
                </button>

            </div>

        </form>

    </div>


    <!-- EXISTING BLOCKS -->
    <div class="mt-6 rounded-2xl border border-[#eadfe0] bg-white shadow-sm overflow-hidden">

        <div class="px-5 sm:px-6 py-5 border-b border-[#eee5e5]">

            <p class="text-xs uppercase tracking-[0.2em] text-[#a56b76] font-semibold">
                Blocked Schedule
            </p>

            <h2 class="mt-1 text-lg font-semibold text-[#332b2d]">
                Current Unavailable Periods
            </h2>

        </div>


        <?php if (!empty($blocks)): ?>

            <!-- DESKTOP -->
            <div class="hidden md:block overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-[#faf6f3]">

                        <tr class="text-left text-gray-500">

                            <th class="px-6 py-4 font-medium">
                                Date
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Time
                            </th>

                            <th class="px-6 py-4 font-medium">
                                Reason
                            </th>

                            <th class="px-6 py-4 font-medium text-right">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#eee5e5]">

                        <?php foreach ($blocks as $block): ?>

                            <tr>

                                <td class="px-6 py-4 font-medium text-gray-700">
                                    <?= esc($block['block_date']) ?>
                                </td>


                                <td class="px-6 py-4 text-gray-600">

                                    <?php if ((int) $block['all_day'] === 1): ?>

                                        <span class="inline-flex rounded-full bg-[#f1e8e8] px-3 py-1 text-xs font-medium text-[#8d5964]">
                                            Entire Day
                                        </span>

                                    <?php else: ?>

                                        <?= esc(substr($block['start_time'], 0, 5)) ?>
                                        -
                                        <?= esc(substr($block['end_time'], 0, 5)) ?>

                                    <?php endif; ?>

                                </td>


                                <td class="px-6 py-4 text-gray-600">
                                    <?= esc($block['reason'] ?: 'Unavailable') ?>
                                </td>


                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="<?= base_url('admin/availability/delete/' . $block['id']) ?>"
                                        onclick="return confirm('Remove this unavailable period?')"
                                        class="inline-flex rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50"
                                    >
                                        Remove
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


            <!-- MOBILE -->
            <div class="md:hidden divide-y divide-[#eee5e5]">

                <?php foreach ($blocks as $block): ?>

                    <div class="p-5">

                        <div class="flex items-start justify-between gap-4">

                            <div>

                                <p class="text-sm font-semibold text-[#332b2d]">
                                    <?= esc($block['block_date']) ?>
                                </p>


                                <p class="mt-1 text-sm text-gray-500">

                                    <?php if ((int) $block['all_day'] === 1): ?>

                                        Entire Day

                                    <?php else: ?>

                                        <?= esc(substr($block['start_time'], 0, 5)) ?>
                                        -
                                        <?= esc(substr($block['end_time'], 0, 5)) ?>

                                    <?php endif; ?>

                                </p>


                                <?php if (!empty($block['reason'])): ?>

                                    <p class="mt-2 text-sm text-gray-600">
                                        <?= esc($block['reason']) ?>
                                    </p>

                                <?php endif; ?>

                            </div>


                            <a
                                href="<?= base_url('admin/availability/delete/' . $block['id']) ?>"
                                onclick="return confirm('Remove this unavailable period?')"
                                class="shrink-0 rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50"
                            >
                                Remove
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="px-6 py-10 text-center">

                <p class="text-sm text-gray-500">
                    No unavailable periods have been added yet.
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>


<!-- FULLCALENDAR -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>


<style>

    #adminCalendar {
        width: 100%;
    }


    .fc {
        font-family: inherit;
    }


    .fc .fc-toolbar {
        margin-bottom: 1rem;
    }


    .fc .fc-toolbar-title {
        color: #332b2d;
        font-size: 1.3rem;
        font-weight: 600;
    }


    .fc .fc-button {
        background: #4b3a3d;
        border-color: #4b3a3d;
        border-radius: 9px;
        box-shadow: none;
        font-size: 0.78rem;
        font-weight: 500;
    }


    .fc .fc-button:hover,
    .fc .fc-button:focus {
        background: #382c2f;
        border-color: #382c2f;
        box-shadow: none;
    }


    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background: #a56b76;
        border-color: #a56b76;
    }


    .fc .fc-daygrid-day {
        transition: background 0.2s ease;
    }


    /*
     * AVAILABLE DATE
     */
    .fc .rup-available-day {
        background: rgba(140, 175, 138, 0.10) !important;
    }


    .fc .rup-available-day:hover {
        background: rgba(140, 175, 138, 0.18) !important;
    }


    .fc .rup-available-day .fc-daygrid-day-number {
        color: #628060;
        font-weight: 600;
    }


    .rup-available-label {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        margin: 1px 4px;
        color: #6d8d6b;
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.02em;
    }


    .rup-available-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #8caf8a;
        display: inline-block;
    }


    .fc .fc-day-today {
        background: rgba(165, 107, 118, 0.09) !important;
    }


    /*
     * EVENTS
     */
    .fc-event {
        border-radius: 5px;
        border-width: 0;
        padding: 2px 4px;
        cursor: pointer;
        font-size: 0.72rem;
        box-shadow: none;
    }


    .fc-daygrid-event {
        white-space: normal;
    }


    .fc .fc-daygrid-day-number {
        color: #4b3a3d;
        font-weight: 500;
    }


    .fc .fc-col-header-cell-cushion {
        color: #756a6d;
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }


    /*
     * MOBILE
     */
    @media (max-width: 640px) {

        #adminCalendar {
            width: 100%;
        }


        .fc .fc-toolbar {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 5px;
        }


        .fc .fc-toolbar-chunk:first-child {
            display: flex;
            gap: 4px;
        }


        .fc .fc-toolbar-title {
            text-align: center;
            font-size: 1rem;
        }


        .fc .fc-button {
            padding: 0.42rem 0.55rem;
            font-size: 0.68rem;
        }


        .fc .fc-button.fc-today-button {
            display: none;
        }


        .fc .fc-daygrid-day-number {
            font-size: 0.68rem;
            padding: 4px;
        }


        .fc .fc-col-header-cell-cushion {
            font-size: 0.58rem;
        }


        .fc-event {
            font-size: 0.59rem;
            padding: 1px 2px;
            line-height: 1.25;
        }


        .rup-available-label {
            font-size: 7px;
            margin: 1px 2px;
        }


        .rup-available-dot {
            width: 4px;
            height: 4px;
        }

    }

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const calendarEl =
        document.getElementById('adminCalendar');


    if (!calendarEl) {
        return;
    }


    /*
     * IMPORTANT:
     *
     * These bookings come from the admin controller.
     * They are NOT being exposed through the public
     * availability API.
     */
    const adminBookings =
        <?= json_encode(
            $bookings ?? [],
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_AMP |
            JSON_HEX_QUOT
        ) ?>;


    const adminBlocks =
        <?= json_encode(
            $blocks ?? [],
            JSON_HEX_TAG |
            JSON_HEX_APOS |
            JSON_HEX_AMP |
            JSON_HEX_QUOT
        ) ?>;


    const availabilityUrl =
        '<?= base_url('api/availability') ?>';


    let calendar = null;

    let dayState = {};


    /*
     * DATE HELPERS
     */
    function formatDate(date) {

        const year =
            date.getFullYear();

        const month =
            String(date.getMonth() + 1).padStart(2, '0');

        const day =
            String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;

    }


    function addOneDay(dateString) {

        const date =
            new Date(dateString + 'T00:00:00');

        date.setDate(
            date.getDate() + 1
        );

        return formatDate(date);

    }


    function formatTime(time) {

        if (!time) {
            return '';
        }

        return time.substring(0, 5);

    }


    function formatTime12(time) {

        if (!time) {
            return '';
        }

        const parts =
            time.substring(0, 5).split(':');

        let hour =
            parseInt(parts[0], 10);

        const minute =
            parts[1];

        const suffix =
            hour >= 12 ? 'PM' : 'AM';

        hour =
            hour % 12 || 12;

        return `${hour}:${minute} ${suffix}`;

    }


    function escapeHtml(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

    }


    function niceDate(dateString) {

        if (!dateString) {
            return '';
        }

        const date =
            new Date(dateString + 'T00:00:00');

        return date.toLocaleDateString(
            undefined,
            {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }
        );

    }


    /*
     * CREATE EVENTS FROM ADMIN DATA
     *
     * We use the admin-loaded bookings so the
     * details panel can show customer information.
     */
    function createAdminEvents() {

        const events = [];

        dayState = {};


        /*
         * MARK BLOCKED DATES
         */
        adminBlocks.forEach(block => {

            const date =
                block.block_date;

            if (!dayState[date]) {

                dayState[date] = {
                    bookings: [],
                    blocks: []
                };

            }


            dayState[date].blocks.push(block);


            /*
             * FULL DAY
             */
            if (parseInt(block.all_day, 10) === 1) {

                events.push({

                    id: `admin-block-${block.id}`,

                    title:
                        'Unavailable',

                    start:
                        date,

                    end:
                        addOneDay(date),

                    allDay:
                        true,

                    backgroundColor:
                        '#655b5d',

                    borderColor:
                        '#655b5d',

                    extendedProps: {

                        type:
                            'unavailable',

                        block:
                            block

                    }

                });

                return;

            }


            /*
             * PARTIAL BLOCK
             */
            if (
                block.start_time &&
                block.end_time
            ) {

                events.push({

                    id:
                        `admin-block-${block.id}`,

                    title:
                        block.reason ||
                        'Unavailable',

                    start:
                        `${date}T${block.start_time}`,

                    end:
                        `${date}T${block.end_time}`,

                    allDay:
                        false,

                    backgroundColor:
                        '#655b5d',

                    borderColor:
                        '#655b5d',

                    extendedProps: {

                        type:
                            'unavailable',

                        block:
                            block

                    }

                });

            }

        });


        /*
         * BOOKINGS
         */
        adminBookings.forEach(booking => {

            const date =
                booking.event_date;


            if (!dayState[date]) {

                dayState[date] = {
                    bookings: [],
                    blocks: []
                };

            }


            dayState[date].bookings.push(booking);


            const status =
                String(
                    booking.status || 'pending'
                ).toLowerCase();


            const isConfirmed =
                status === 'confirmed';


            /*
             * OLD BOOKINGS WITHOUT TIME
             */
            if (
                !booking.start_time ||
                !booking.end_time
            ) {

                events.push({

                    id:
                        `admin-booking-${booking.id}`,

                    title:
                        `${isConfirmed ? 'Confirmed' : 'Pending'} • ${booking.event_type || 'Booking'}`,

                    start:
                        date,

                    end:
                        addOneDay(date),

                    allDay:
                        true,

                    backgroundColor:
                        isConfirmed
                            ? '#a56b76'
                            : '#c89b50',

                    borderColor:
                        isConfirmed
                            ? '#a56b76'
                            : '#c89b50',

                    extendedProps: {

                        type:
                            'booking',

                        booking:
                            booking

                    }

                });

                return;

            }


            /*
             * NORMAL TIMED BOOKING
             */
            events.push({

                id:
                    `admin-booking-${booking.id}`,

                title:
                    `${isConfirmed ? 'Confirmed' : 'Pending'} • ${booking.event_type || 'Booking'}`,

                start:
                    `${date}T${booking.start_time}`,

                end:
                    `${date}T${booking.end_time}`,

                allDay:
                    false,

                backgroundColor:
                    isConfirmed
                        ? '#a56b76'
                        : '#c89b50',

                borderColor:
                    isConfirmed
                        ? '#a56b76'
                        : '#c89b50',

                extendedProps: {

                    type:
                        'booking',

                    booking:
                        booking

                }

            });

        });


        return events;

    }


    /*
     * DECORATE EMPTY DATES GREEN
     */
    function decorateAvailableDays() {

        document
            .querySelectorAll(
                '#adminCalendar .fc-daygrid-day'
            )
            .forEach(cell => {

                const date =
                    cell.getAttribute('data-date');


                if (!date) {
                    return;
                }


                const state =
                    dayState[date];


                /*
                 * A date is available only if
                 * it has NO booking and NO block.
                 */
                const available =
                    !state ||
                    (
                        state.bookings.length === 0 &&
                        state.blocks.length === 0
                    );


                if (!available) {
                    return;
                }


                /*
                 * Don't mark dates belonging to
                 * the previous/next month too strongly.
                 */
                cell.classList.add(
                    'rup-available-day'
                );


                /*
                 * Avoid duplicate label.
                 */
                if (
                    !cell.querySelector(
                        '.rup-available-label'
                    )
                ) {

                    const label =
                        document.createElement('div');

                    label.className =
                        'rup-available-label';

                    label.innerHTML =
                        '<span class="rup-available-dot"></span> Available';


                    const frame =
                        cell.querySelector(
                            '.fc-daygrid-day-frame'
                        );

                    if (frame) {

                        frame.appendChild(label);

                    }

                }

            });

    }


    /*
     * SHOW DETAILS PANEL
     */
    function showInspector(
        title,
        subtitle,
        html
    ) {

        const inspector =
            document.getElementById(
                'eventInspector'
            );

        document.getElementById(
            'inspectorTitle'
        ).textContent = title;


        document.getElementById(
            'inspectorSubtitle'
        ).textContent = subtitle || '';


        document.getElementById(
            'inspectorContent'
        ).innerHTML = html;


        inspector.classList.remove('hidden');


        setTimeout(() => {

            inspector.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

        }, 50);

    }


    /*
     * BOOKING DETAILS
     */
    function showBookingDetails(booking) {

        const status =
            String(
                booking.status || 'pending'
            ).toLowerCase();


        const statusLabel =
            status === 'confirmed'
                ? 'Confirmed'
                : 'Pending';


        const statusClass =
            status === 'confirmed'
                ? 'bg-[#f2e1e5] text-[#8d5964]'
                : 'bg-[#f7eddc] text-[#9a742e]';


        const timeText =
            booking.start_time &&
            booking.end_time

                ? `${formatTime12(booking.start_time)} – ${formatTime12(booking.end_time)}`

                : 'Time not specified';


        const html = `

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Customer
                    </p>

                    <p class="mt-1 font-semibold text-[#332b2d]">
                        ${escapeHtml(booking.name || 'Not provided')}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Status
                    </p>

                    <span class="inline-flex mt-1 rounded-full px-3 py-1 text-xs font-semibold ${statusClass}">
                        ${statusLabel}
                    </span>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Phone
                    </p>

                    <p class="mt-1 font-medium text-[#332b2d]">
                        ${escapeHtml(booking.phone || 'Not provided')}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Email
                    </p>

                    <p class="mt-1 font-medium text-[#332b2d] break-all">
                        ${escapeHtml(booking.email || 'Not provided')}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Event
                    </p>

                    <p class="mt-1 font-medium text-[#332b2d]">
                        ${escapeHtml(booking.event_type || 'Booking')}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Date & Time
                    </p>

                    <p class="mt-1 font-medium text-[#332b2d]">
                        ${escapeHtml(niceDate(booking.event_date))}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        ${escapeHtml(timeText)}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4 sm:col-span-2">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Location
                    </p>

                    <p class="mt-1 font-medium text-[#332b2d]">
                        ${escapeHtml(booking.location || 'Not provided')}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4 sm:col-span-2">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Customer Message
                    </p>

                    <p class="mt-1 text-sm leading-6 text-gray-600">
                        ${escapeHtml(booking.message || 'No message provided.')}
                    </p>

                </div>

            </div>

        `;


        showInspector(
            booking.event_type || 'Booking',
            niceDate(booking.event_date),
            html
        );

    }


    /*
     * UNAVAILABLE DETAILS
     */
    function showBlockDetails(block) {

        const isAllDay =
            parseInt(block.all_day, 10) === 1;


        const timeText =
            isAllDay

                ? 'Entire day'

                : `${formatTime12(block.start_time)} – ${formatTime12(block.end_time)}`;


        const html = `

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Date
                    </p>

                    <p class="mt-1 font-semibold text-[#332b2d]">
                        ${escapeHtml(niceDate(block.block_date))}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Time
                    </p>

                    <p class="mt-1 font-semibold text-[#332b2d]">
                        ${escapeHtml(timeText)}
                    </p>

                </div>


                <div class="rounded-xl bg-[#faf6f3] p-4 sm:col-span-2">

                    <p class="text-xs uppercase tracking-wider text-gray-400">
                        Reason
                    </p>

                    <p class="mt-1 text-sm text-gray-600">
                        ${escapeHtml(block.reason || 'Unavailable')}
                    </p>

                </div>

            </div>

        `;


        showInspector(
            'Unavailable',
            niceDate(block.block_date),
            html
        );

    }


    /*
     * SHOW ALL ITEMS FOR A DATE
     */
    function showDateDetails(date) {

        const state =
            dayState[date];


        /*
         * Completely empty date
         */
        if (
            !state ||
            (
                state.bookings.length === 0 &&
                state.blocks.length === 0
            )
        ) {

            const html = `

                <div class="rounded-2xl bg-[#eef5ed] border border-[#d6e6d3] p-5">

                    <div class="flex items-center gap-3">

                        <div class="h-11 w-11 rounded-full bg-[#dcebd9] flex items-center justify-center shrink-0">

                            <span class="text-[#668a63] text-lg">
                                ✓
                            </span>

                        </div>


                        <div>

                            <p class="font-semibold text-[#526f50]">
                                Available
                            </p>

                            <p class="text-sm text-[#6f856d]">
                                No bookings or blocked periods.
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">

                        <!-- ADD BOOKING -->
                        <a
                            href="<?= base_url('admin/bookings/create') ?>?date=${encodeURIComponent(date)}"
                            class="flex items-center justify-center gap-2 rounded-xl bg-[#a56b76] px-5 py-3 text-sm font-semibold text-white hover:bg-[#8f5b66] transition"
                        >
                            <span class="text-base">+</span>
                            Add Booking
                        </a>


                        <!-- BLOCK DATE -->
                        <button
                            type="button"
                            onclick="selectDateForBlocking('${date}')"
                            class="flex items-center justify-center gap-2 rounded-xl border border-[#655b5d] bg-white px-5 py-3 text-sm font-semibold text-[#4b4345] hover:bg-[#f6f3f2] transition"
                        >
                            <span>🚫</span>
                            Block Date
                        </button>

                    </div>

                </div>

            `;


            showInspector(
                niceDate(date),
                'No appointments or unavailable periods',
                html
            );

            return;

        }


        let html = '';


        /*
         * BOOKINGS
         */
        state.bookings.forEach(booking => {

            const status =
                String(
                    booking.status || 'pending'
                ).toLowerCase();


            const color =
                status === 'confirmed'
                    ? '#a56b76'
                    : '#c89b50';


            const time =
                booking.start_time &&
                booking.end_time

                    ? `${formatTime12(booking.start_time)} – ${formatTime12(booking.end_time)}`

                    : 'Time not specified';


            html += `

                <button
                    type="button"
                    onclick="showBookingById(${Number(booking.id)})"
                    class="w-full text-left rounded-xl border border-[#eadfe0] bg-white hover:bg-[#faf6f3] p-4 mb-3 transition"
                >

                    <div class="flex items-start gap-3">

                        <span
                            class="mt-1 h-3 w-3 rounded-full shrink-0"
                            style="background:${color}"
                        ></span>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center justify-between gap-2">

                                <p class="font-semibold text-[#332b2d]">
                                    ${escapeHtml(booking.name || 'Customer')}
                                </p>

                                <span class="text-xs text-gray-400">
                                    ${escapeHtml(time)}
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                ${escapeHtml(booking.event_type || 'Booking')}
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                ${status === 'confirmed' ? 'Confirmed' : 'Pending'}
                                ${booking.location ? ' • ' + escapeHtml(booking.location) : ''}
                            </p>

                        </div>

                    </div>

                </button>

            `;

        });


        /*
         * BLOCKS
         */
        state.blocks.forEach(block => {

            const time =
                parseInt(block.all_day, 10) === 1

                    ? 'Entire day'

                    : `${formatTime12(block.start_time)} – ${formatTime12(block.end_time)}`;


            html += `

                <button
                    type="button"
                    onclick="showBlockById(${Number(block.id)})"
                    class="w-full text-left rounded-xl border border-[#e3dddd] bg-[#f6f3f2] hover:bg-[#eee9e7] p-4 mb-3 transition"
                >

                    <div class="flex items-start gap-3">

                        <span class="mt-1 h-3 w-3 rounded-full bg-[#655b5d] shrink-0"></span>

                        <div>

                            <p class="font-semibold text-[#4b4345]">
                                Unavailable
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                ${escapeHtml(time)}
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                ${escapeHtml(block.reason || 'No reason specified')}
                            </p>

                        </div>

                    </div>

                </button>

            `;

        });


        showInspector(
            niceDate(date),
            `${state.bookings.length} booking(s), ${state.blocks.length} unavailable period(s)`,
            html
        );

    }


    /*
     * GLOBAL HELPERS FOR BUTTONS
     */
    window.showBookingById = function(id) {

        const booking =
            adminBookings.find(
                item => Number(item.id) === Number(id)
            );


        if (booking) {
            showBookingDetails(booking);
        }

    };


    window.showBlockById = function(id) {

        const block =
            adminBlocks.find(
                item => Number(item.id) === Number(id)
            );


        if (block) {
            showBlockDetails(block);
        }

    };


    window.selectDateForBlocking = function(date) {

        const dateInput =
            document.getElementById('block_date');


        dateInput.value =
            date;


        dateInput.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });


        dateInput.focus();

    };


    window.closeInspector = function() {

        document
            .getElementById('eventInspector')
            .classList.add('hidden');

    };


    /*
     * BUILD CALENDAR
     */
    const events =
        createAdminEvents();


    calendar =
        new FullCalendar.Calendar(
            calendarEl,
            {

                initialView:
                    'dayGridMonth',

                height:
                    'auto',

                fixedWeekCount:
                    false,

                dayMaxEvents:
                    4,

                firstDay:
                    1,

                eventDisplay:
                    'block',

                headerToolbar: {

                    left:
                        'prev,next today',

                    center:
                        'title',

                    right:
                        ''

                },


                events:
                    events,


                /*
                 * CLICK A DATE
                 */
                dateClick: function(info) {

                    showDateDetails(
                        info.dateStr
                    );

                },


                /*
                 * CLICK AN EVENT
                 */
                eventClick: function(info) {

                    const props =
                        info.event.extendedProps;


                    if (
                        props.type ===
                        'booking'
                    ) {

                        showBookingDetails(
                            props.booking
                        );

                        return;

                    }


                    if (
                        props.type ===
                        'unavailable'
                    ) {

                        showBlockDetails(
                            props.block
                        );

                    }

                },


                datesSet: function() {

                    setTimeout(
                        decorateAvailableDays,
                        100
                    );

                }

            }
        );


    calendar.render();


    /*
     * INITIAL AVAILABLE-DATE DECORATION
     */
    setTimeout(
        decorateAvailableDays,
        300
    );


    /*
     * FULL-DAY CHECKBOX
     */
    const allDayCheckbox =
        document.getElementById('all_day');


    const startWrapper =
        document.getElementById(
            'startTimeWrapper'
        );


    const endWrapper =
        document.getElementById(
            'endTimeWrapper'
        );


    const startInput =
        document.getElementById(
            'start_time'
        );


    const endInput =
        document.getElementById(
            'end_time'
        );


    function toggleTimeFields() {

        if (
            allDayCheckbox.checked
        ) {

            startWrapper.classList.add(
                'hidden'
            );

            endWrapper.classList.add(
                'hidden'
            );

            startInput.value =
                '';

            endInput.value =
                '';

        } else {

            startWrapper.classList.remove(
                'hidden'
            );

            endWrapper.classList.remove(
                'hidden'
            );

        }

    }


    allDayCheckbox.addEventListener(
        'change',
        toggleTimeFields
    );


    toggleTimeFields();

});

</script>


<?= $this->include('admin/layout/footer') ?>
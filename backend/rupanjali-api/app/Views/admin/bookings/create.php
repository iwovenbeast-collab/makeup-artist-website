<?= view('admin/layout/header') ?>
<?= view('admin/layout/sidebar') ?>

<div class="min-h-screen">

    <div class="max-w-5xl mx-auto px-5 py-8 sm:px-7 md:px-10">

        <!-- Header -->

        <div class="mb-8">

            <a
                href="/admin/bookings"
                class="inline-flex items-center gap-2 text-sm text-[#c65d72] mb-5"
            >
                ← Back to bookings
            </a>

            <p class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72] mb-2">
                Manual booking
            </p>

            <h1 class="font-serif text-4xl sm:text-5xl text-[#292322]">
                Add Booking
            </h1>

            <p class="mt-3 text-[#817673]">
                Add an appointment that was received through WhatsApp,
                phone, or another source.
            </p>

        </div>


        <!-- Error -->

        <?php if (session()->getFlashdata('error')): ?>

            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>

        <?php endif; ?>


        <!-- Form -->

        <form
            method="POST"
            action="/admin/bookings/store"
            class="bg-white rounded-3xl border border-black/5 shadow-sm overflow-hidden"
        >

            <!-- Client -->

            <div class="p-6 sm:p-8 border-b border-black/5">

                <h2 class="font-serif text-2xl text-[#292322]">
                    Client details
                </h2>

                <p class="text-sm text-[#817673] mt-1">
                    Information about the customer.
                </p>


                <div class="grid sm:grid-cols-2 gap-5 mt-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="<?= esc(old('name')) ?>"
                            required
                            maxlength="100"
                            placeholder="Client name"
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#c65d72]"
                        >

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Phone
                        </label>

                        <input
                            type="tel"
                            name="phone"
                            value="<?= esc(old('phone')) ?>"
                            required
                            maxlength="20"
                            placeholder="Phone number"
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#c65d72]"
                        >

                    </div>


                    <div class="sm:col-span-2">

                        <label class="block text-sm font-medium mb-2">
                            Email
                            <span class="text-[#a59a96] font-normal">
                                (optional)
                            </span>
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="<?= esc(old('email')) ?>"
                            placeholder="client@example.com"
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#c65d72]"
                        >

                    </div>

                </div>

            </div>


            <!-- Appointment -->

            <div class="p-6 sm:p-8 border-b border-black/5">

                <h2 class="font-serif text-2xl text-[#292322]">
                    Appointment
                </h2>

                <div class="grid sm:grid-cols-2 gap-5 mt-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Event type
                        </label>

                        <select
                            name="event_type"
                            required
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 bg-white outline-none focus:border-[#c65d72]"
                        >

                            <option value="">
                                Select event
                            </option>

                            <option value="Bridal Makeup"
                                <?= old('event_type') === 'Bridal Makeup' ? 'selected' : '' ?>>
                                Bridal Makeup
                            </option>

                            <option value="Engagement Makeup"
                                <?= old('event_type') === 'Engagement Makeup' ? 'selected' : '' ?>>
                                Engagement Makeup
                            </option>

                            <option value="Party Makeup"
                                <?= old('event_type') === 'Party Makeup' ? 'selected' : '' ?>>
                                Party Makeup
                            </option>

                            <option value="Photoshoot Makeup"
                                <?= old('event_type') === 'Photoshoot Makeup' ? 'selected' : '' ?>>
                                Photoshoot Makeup
                            </option>

                            <option value="Other"
                                <?= old('event_type') === 'Other' ? 'selected' : '' ?>>
                                Other
                            </option>

                        </select>

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Appointment date
                        </label>

                        <p class="text-xs text-[#817673] mb-3">
                            Select the date for this appointment.
                        </p>


                        <!-- DATE DISPLAY -->
                        <button
                            type="button"
                            id="openBookingCalendar"
                            class="w-full text-left rounded-2xl border border-black/10 bg-white px-4 py-4 hover:border-[#c65d72] transition"
                        >

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex items-center gap-3">

                                    <div class="h-11 w-11 rounded-xl bg-[#faf0f2] flex items-center justify-center">
                                        <span class="text-[#c65d72] text-lg">
                                            ♡
                                        </span>
                                    </div>


                                    <div>

                                        <p class="text-[10px] uppercase tracking-[0.2em] text-[#a59a96]">
                                            Selected date
                                        </p>

                                        <p
                                            id="selectedDateLabel"
                                            class="mt-1 font-medium text-[#292322]"
                                        >
                                            Choose a date
                                        </p>

                                    </div>

                                </div>


                                <span class="text-[#c65d72] text-sm">
                                    Change
                                </span>

                            </div>

                        </button>


                        <!-- REAL FORM VALUE -->
                        <input
                            type="hidden"
                            id="event_date"
                            name="event_date"
                            value="<?= esc(old('event_date', $selectedDate ?? '')) ?>"
                            required
                        >


                        <!-- CALENDAR -->
                        <div
                            id="bookingDatePicker"
                            class="hidden mt-3 rounded-2xl border border-[#eadfe0] bg-[#fffdfc] p-4"
                        >

                            <div class="flex items-center justify-between mb-4">

                                <button
                                    type="button"
                                    id="previousMonth"
                                    class="h-9 w-9 rounded-full hover:bg-[#f6eeee] text-[#5d5552]"
                                >
                                    ←
                                </button>


                                <p
                                    id="calendarMonth"
                                    class="font-serif text-lg text-[#292322]"
                                ></p>


                                <button
                                    type="button"
                                    id="nextMonth"
                                    class="h-9 w-9 rounded-full hover:bg-[#f6eeee] text-[#5d5552]"
                                >
                                    →
                                </button>

                            </div>


                            <div
                                class="grid grid-cols-7 gap-1 text-center text-[10px] uppercase tracking-wider text-[#a59a96] mb-2"
                            >

                                <span>Mon</span>
                                <span>Tue</span>
                                <span>Wed</span>
                                <span>Thu</span>
                                <span>Fri</span>
                                <span>Sat</span>
                                <span>Sun</span>

                            </div>


                            <div
                                id="bookingCalendarDays"
                                class="grid grid-cols-7 gap-1"
                            ></div>


                            <div class="mt-4 flex items-center gap-4 text-[10px] text-[#817673]">

                                <div class="flex items-center gap-1.5">
                                    <span class="h-2 w-2 rounded-full bg-[#8caf8a]"></span>
                                    Available
                                </div>

                                <div class="flex items-center gap-1.5">
                                    <span class="h-2 w-2 rounded-full bg-[#d7b0b8]"></span>
                                    Selected
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- Appointment Time -->

                    <div class="sm:col-span-2">

                        <label class="block text-sm font-medium mb-2">
                            Appointment time
                        </label>

                        <p class="text-xs text-[#817673] mb-3">
                            Choose one of the available appointment windows.
                        </p>

                        <?php
                            $oldStart = substr((string) old('start_time'), 0, 5);
                            $oldEnd   = substr((string) old('end_time'), 0, 5);

                            $selectedSlot = '';

                            if ($oldStart === '09:00' && $oldEnd === '11:00') {
                                $selectedSlot = 'morning';
                            } elseif ($oldStart === '12:00' && $oldEnd === '14:00') {
                                $selectedSlot = 'afternoon';
                            } elseif ($oldStart === '15:00' && $oldEnd === '18:00') {
                                $selectedSlot = 'evening';
                            }
                        ?>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                            <!-- Morning -->

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="appointment_slot"
                                    value="morning"
                                    class="peer sr-only"
                                    <?= $selectedSlot === 'morning' ? 'checked' : '' ?>
                                    required
                                >

                                <div class="rounded-2xl border border-[#e6dcdc] bg-white p-4 transition
                                            peer-checked:border-[#c18e99]
                                            peer-checked:bg-[#f5e1e5]
                                            hover:border-[#d5b6bd]">

                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#a56b76]">
                                        Morning
                                    </p>

                                    <p class="mt-2 font-medium text-[#292322]">
                                        9:00 AM – 11:00 AM
                                    </p>

                                    <p class="mt-1 text-xs text-[#817673]">
                                        2 hours
                                    </p>

                                </div>

                            </label>


                            <!-- Afternoon -->

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="appointment_slot"
                                    value="afternoon"
                                    class="peer sr-only"
                                    <?= $selectedSlot === 'afternoon' ? 'checked' : '' ?>
                                >

                                <div class="rounded-2xl border border-[#e6dcdc] bg-white p-4 transition
                                            peer-checked:border-[#c18e99]
                                            peer-checked:bg-[#f5e1e5]
                                            hover:border-[#d5b6bd]">

                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#a56b76]">
                                        Afternoon
                                    </p>

                                    <p class="mt-2 font-medium text-[#292322]">
                                        12:00 PM – 2:00 PM
                                    </p>

                                    <p class="mt-1 text-xs text-[#817673]">
                                        2 hours
                                    </p>

                                </div>

                            </label>


                            <!-- Evening -->

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="appointment_slot"
                                    value="evening"
                                    class="peer sr-only"
                                    <?= $selectedSlot === 'evening' ? 'checked' : '' ?>
                                >

                                <div class="rounded-2xl border border-[#e6dcdc] bg-white p-4 transition
                                            peer-checked:border-[#c18e99]
                                            peer-checked:bg-[#f5e1e5]
                                            hover:border-[#d5b6bd]">

                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#a56b76]">
                                        Evening
                                    </p>

                                    <p class="mt-2 font-medium text-[#292322]">
                                        3:00 PM – 6:00 PM
                                    </p>

                                    <p class="mt-1 text-xs text-[#817673]">
                                        3 hours
                                    </p>

                                </div>

                            </label>

                        </div>


                        <!-- Hidden values submitted to existing backend -->

                        <input
                            type="hidden"
                            id="start_time"
                            name="start_time"
                            value="<?= esc($oldStart) ?>"
                        >

                        <input
                            type="hidden"
                            id="end_time"
                            name="end_time"
                            value="<?= esc($oldEnd) ?>"
                        >

                    </div>


                    <div class="sm:col-span-2">

                        <label class="block text-sm font-medium mb-2">
                            Location
                        </label>

                        <input
                            type="text"
                            name="location"
                            value="<?= esc(old('location')) ?>"
                            required
                            maxlength="150"
                            placeholder="Venue / location"
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#c65d72]"
                        >

                    </div>

                </div>

            </div>


            <!-- Source + status -->

            <div class="p-6 sm:p-8 border-b border-black/5">

                <h2 class="font-serif text-2xl text-[#292322]">
                    Booking information
                </h2>

                <div class="grid sm:grid-cols-2 gap-5 mt-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Booking source
                        </label>

                        <select
                            name="source"
                            required
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 bg-white outline-none focus:border-[#c65d72]"
                        >

                            <option value="">
                                Select source
                            </option>

                            <option value="website"
                                <?= old('source') === 'website' ? 'selected' : '' ?>>
                                Website
                            </option>

                            <option value="whatsapp"
                                <?= old('source') === 'whatsapp' ? 'selected' : '' ?>>
                                WhatsApp
                            </option>

                            <option value="phone"
                                <?= old('source') === 'phone' ? 'selected' : '' ?>>
                                Phone
                            </option>

                            <option value="other"
                                <?= old('source') === 'other' ? 'selected' : '' ?>>
                                Other
                            </option>

                        </select>

                    </div>


                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Status
                        </label>

                        <select
                            name="status"
                            required
                            class="w-full rounded-xl border border-black/10 px-4 py-3.5 bg-white outline-none focus:border-[#c65d72]"
                        >

                            <option value="pending"
                                <?= old('status', 'pending') === 'pending' ? 'selected' : '' ?>>
                                Pending
                            </option>

                            <option value="confirmed"
                                <?= old('status') === 'confirmed' ? 'selected' : '' ?>>
                                Confirmed
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            <!-- Message -->

            <div class="p-6 sm:p-8">

                <label class="block text-sm font-medium mb-2">
                    Notes
                    <span class="text-[#a59a96] font-normal">
                        (optional)
                    </span>
                </label>

                <textarea
                    name="message"
                    rows="4"
                    placeholder="Any additional notes about this booking..."
                    class="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#c65d72]"
                ><?= esc(old('message')) ?></textarea>

            </div>


            <!-- Actions -->

            <div class="px-6 sm:px-8 py-5 bg-[#faf6f3] flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                <a
                    href="/admin/bookings"
                    class="text-center px-6 py-3 rounded-xl border border-black/10 text-[#5d5552] hover:bg-white"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-7 py-3 rounded-xl bg-[#292322] text-white hover:bg-[#3b3331] transition"
                >
                    Add Booking
                </button>

            </div>

        </form>

    </div>

</div>
<script>

    const appointmentSlots = {
        morning: {
            start: "09:00",
            end: "11:00"
        },

        afternoon: {
            start: "12:00",
            end: "14:00"
        },

        evening: {
            start: "15:00",
            end: "18:00"
        }
    };


    document.querySelectorAll(
        'input[name="appointment_slot"]'
    ).forEach(function (radio) {

        radio.addEventListener('change', function () {

            const slot =
                appointmentSlots[this.value];

            if (!slot) {
                return;
            }

            document.getElementById(
                'start_time'
            ).value = slot.start;

            document.getElementById(
                'end_time'
            ).value = slot.end;

        });

    });


    const initialSlot =
        document.querySelector(
            'input[name="appointment_slot"]:checked'
        );

        if (initialSlot) {

            const slot =
                appointmentSlots[initialSlot.value];

            if (slot) {

                document.getElementById(
                    'start_time'
                ).value = slot.start;

                document.getElementById(
                    'end_time'
                ).value = slot.end;

            }

        }

document.addEventListener('DOMContentLoaded', function () {

    const dateInput =
        document.getElementById('event_date');

    const dateLabel =
        document.getElementById('selectedDateLabel');

    const openButton =
        document.getElementById('openBookingCalendar');

    const calendarPicker =
        document.getElementById('bookingDatePicker');

    const calendarDays =
        document.getElementById('bookingCalendarDays');

    const calendarMonth =
        document.getElementById('calendarMonth');

    const previousMonth =
        document.getElementById('previousMonth');

    const nextMonth =
        document.getElementById('nextMonth');


    let selectedDate =
        dateInput.value || '';


    /*
     * Start calendar on selected date,
     * otherwise current month.
     */
    let calendarDate;

    if (selectedDate) {

        calendarDate =
            new Date(
                selectedDate + 'T00:00:00'
            );

    } else {

        calendarDate =
            new Date();

    }


    /*
     * DATE FORMAT
     */
    function formatDate(date) {

        const year =
            date.getFullYear();

        const month =
            String(
                date.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                date.getDate()
            ).padStart(2, '0');

        return `${year}-${month}-${day}`;

    }


    /*
     * DISPLAY DATE
     */
    function displayDate(dateString) {

        if (!dateString) {

            dateLabel.textContent =
                'Choose a date';

            return;

        }


        const date =
            new Date(
                dateString + 'T00:00:00'
            );


        dateLabel.textContent =
            date.toLocaleDateString(
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
     * RENDER CALENDAR
     */
    function renderCalendar() {

        calendarDays.innerHTML =
            '';


        const year =
            calendarDate.getFullYear();

        const month =
            calendarDate.getMonth();


        calendarMonth.textContent =
            calendarDate.toLocaleDateString(
                undefined,
                {
                    month: 'long',
                    year: 'numeric'
                }
            );


        /*
         * First day of month.
         *
         * Convert Sunday=0 to
         * Monday=0.
         */
        const firstDay =
            new Date(
                year,
                month,
                1
            );


        let startingDay =
            firstDay.getDay();

        startingDay =
            startingDay === 0
                ? 6
                : startingDay - 1;


        const daysInMonth =
            new Date(
                year,
                month + 1,
                0
            ).getDate();


        /*
         * Empty cells before month.
         */
        for (
            let i = 0;
            i < startingDay;
            i++
        ) {

            const empty =
                document.createElement('div');

            empty.className =
                'h-10 sm:h-11';

            calendarDays.appendChild(
                empty
            );

        }


        /*
         * DAYS
         */
        for (
            let day = 1;
            day <= daysInMonth;
            day++
        ) {

            const date =
                new Date(
                    year,
                    month,
                    day
                );


            const dateString =
                formatDate(date);


            const button =
                document.createElement('button');


            button.type =
                'button';


            button.textContent =
                day;


            button.className =
                'h-10 sm:h-11 rounded-xl text-sm transition';


            /*
             * SELECTED
             */
            if (
                dateString ===
                selectedDate
            ) {

                button.classList.add(
                    'bg-[#d7b0b8]',
                    'text-[#4b3439]',
                    'font-semibold'
                );

            } else {

                button.classList.add(
                    'text-[#5d5552]',
                    'hover:bg-[#f4e9ea]'
                );

            }


            /*
             * TODAY
             */
            const today =
                formatDate(
                    new Date()
                );


            if (
                dateString ===
                today &&
                dateString !==
                selectedDate
            ) {

                button.classList.add(
                    'ring-1',
                    'ring-[#8caf8a]'
                );

            }


            button.addEventListener(
                'click',
                function () {

                    selectedDate =
                        dateString;


                    dateInput.value =
                        selectedDate;


                    displayDate(
                        selectedDate
                    );


                    renderCalendar();


                    calendarPicker.classList.add(
                        'hidden'
                    );

                }
            );


            calendarDays.appendChild(
                button
            );

        }

    }


    /*
     * OPEN / CLOSE CALENDAR
     */
    openButton.addEventListener(
        'click',
        function () {

            calendarPicker.classList.toggle(
                'hidden'
            );

            renderCalendar();

        }
    );


    /*
     * PREVIOUS MONTH
     */
    previousMonth.addEventListener(
        'click',
        function () {

            calendarDate.setMonth(
                calendarDate.getMonth() - 1
            );

            renderCalendar();

        }
    );


    /*
     * NEXT MONTH
     */
    nextMonth.addEventListener(
        'click',
        function () {

            calendarDate.setMonth(
                calendarDate.getMonth() + 1
            );

            renderCalendar();

        }
    );


    /*
     * INITIAL STATE
     */
    displayDate(
        selectedDate
    );

    renderCalendar();

});

</script>

<?= view('admin/layout/footer') ?>

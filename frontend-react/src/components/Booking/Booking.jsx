import { useEffect, useMemo, useState } from "react";
import { bookingApi } from "../../services/api";
import { APP_CONFIG } from "../../config/app";

const API_BASE_URL = APP_CONFIG.API_BASE_URL;

const EVENT_TYPES = [
  "Bridal Makeup",
  "Engagement Makeup",
  "Party Makeup",
  "Photoshoot Makeup",
  "Other",
];

const APPOINTMENT_SLOTS = [
  {
    id: "morning",
    start: "09:00",
    end: "11:00",
    label: "Morning",
    duration: "2 hours",
  },
  {
    id: "afternoon",
    start: "12:00",
    end: "14:00",
    label: "Afternoon",
    duration: "2 hours",
  },
  {
    id: "evening",
    start: "15:00",
    end: "18:00",
    label: "Evening",
    duration: "3 hours",
  },
];
function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");

  return `${year}-${month}-${day}`;
}

function formatDisplayDate(dateString) {
  if (!dateString) return "";

  const date = new Date(`${dateString}T00:00:00`);

  return date.toLocaleDateString(undefined, {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric",
  });
}

function formatTime(time) {
  if (!time) return "";

  const [hour, minute] = time.substring(0, 5).split(":");

  let h = Number(hour);
  const suffix = h >= 12 ? "PM" : "AM";

  h = h % 12 || 12;

  return `${h}:${minute} ${suffix}`;
}

function timeToMinutes(time) {
  if (!time) return null;

  const [hour, minute] = time.substring(0, 5).split(":");

  return Number(hour) * 60 + Number(minute);
}

function minutesToTime(minutes) {
  const hour = Math.floor(minutes / 60);
  const minute = minutes % 60;

  return `${String(hour).padStart(2, "0")}:${String(minute).padStart(
    2,
    "0"
  )}`;
}

function overlaps(start, end, existingStart, existingEnd) {
  return start < existingEnd && end > existingStart;
}

function getMonthDays(monthDate) {
  const year = monthDate.getFullYear();
  const month = monthDate.getMonth();

  const firstDay = new Date(year, month, 1);

  let startOffset = firstDay.getDay();

  // Monday = 0
  startOffset = startOffset === 0 ? 6 : startOffset - 1;

  const daysInMonth = new Date(year, month + 1, 0).getDate();

  const days = [];

  for (let i = 0; i < startOffset; i++) {
    days.push(null);
  }

  for (let day = 1; day <= daysInMonth; day++) {
    days.push(new Date(year, month, day));
  }

  return days;
}

export default function Booking() {
  const today = useMemo(() => {
    const date = new Date();
    date.setHours(0, 0, 0, 0);
    return date;
  }, []);

  const [calendarDate, setCalendarDate] = useState(
    new Date(today.getFullYear(), today.getMonth(), 1)
  );

  const [selectedDate, setSelectedDate] = useState("");

  const [availability, setAvailability] = useState({});

  const [loadingAvailability, setLoadingAvailability] = useState(false);

  const [availabilityError, setAvailabilityError] = useState("");

  const [selectedStartTime, setSelectedStartTime] = useState("");

  const [selectedEndTime, setSelectedEndTime] = useState("");

  const [step, setStep] = useState(1);

  const [submitting, setSubmitting] = useState(false);

  const [successMessage, setSuccessMessage] = useState("");

  const [errorMessage, setErrorMessage] = useState("");

  const [form, setForm] = useState({
    name: "",
    phone: "",
    email: "",
    event_type: "",
    location: "",
    message: "",
  });


  /*
   * Load the current month plus surrounding calendar days.
   */
  useEffect(() => {
    const year = calendarDate.getFullYear();
    const month = calendarDate.getMonth();

    const start = new Date(year, month, 1);
    const end = new Date(year, month + 1, 0);

    const startDate = formatDate(start);
    const endDate = formatDate(end);

    async function loadAvailability() {
      try {
        setLoadingAvailability(true);
        setAvailabilityError("");

        const response = await fetch(
          `${API_BASE_URL}/api/availability?start_date=${startDate}&end_date=${endDate}`
        );

        if (!response.ok) {
          throw new Error("Unable to load availability.");
        }

        const data = await response.json();

        if (!data.status) {
          throw new Error("Unable to load availability.");
        }

        setAvailability(data.dates || {});
      } catch (error) {
        console.error(error);
        setAvailabilityError(
          "We couldn't load the calendar right now. Please try again."
        );
      } finally {
        setLoadingAvailability(false);
      }
    }

    loadAvailability();
  }, [calendarDate]);


  /*
   * Reset time whenever the selected date changes.
   */
  useEffect(() => {
    setSelectedStartTime("");
    setSelectedEndTime("");
    setErrorMessage("");
  }, [selectedDate]);


  const monthDays = useMemo(
    () => getMonthDays(calendarDate),
    [calendarDate]
  );


  /*
   * Determine whether a date is selectable.
   */
  function getDateState(dateString) {
    const day = availability[dateString];

    if (!day) {
      return {
        blocked: false,
        hasBooking: false,
        partial: false,
      };
    }

    return {
      blocked: Boolean(day.all_day_blocked),
      hasBooking: (day.bookings || []).length > 0,
      partial:
        (day.blocks || []).length > 0 &&
        !day.all_day_blocked,
    };
  }


  function handleDateSelect(dateString) {
    const state = getDateState(dateString);

    if (state.blocked) {
      return;
    }

    setSelectedDate(dateString);
    setStep(2);
    setSuccessMessage("");
    setErrorMessage("");
  }


  function previousMonth() {
    setCalendarDate(
      new Date(
        calendarDate.getFullYear(),
        calendarDate.getMonth() - 1,
        1
      )
    );
  }


  function nextMonth() {
    setCalendarDate(
      new Date(
        calendarDate.getFullYear(),
        calendarDate.getMonth() + 1,
        1
      )
    );
  }


  /*
 * Build the three fixed appointment windows.
 *
 * 09:00 AM - 11:00 AM
 * 12:00 PM - 02:00 PM
 * 03:00 PM - 06:00 PM
 *
 * Any window overlapping an existing booking or
 * availability block is removed.
 */
  const APPOINTMENT_SLOTS = [
    {
      id: "morning",
      start: "09:00",
      end: "11:00",
      label: "Morning",
      time: "9:00 AM – 11:00 AM",
      duration: "2 hours",
    },
    {
      id: "afternoon",
      start: "12:00",
      end: "14:00",
      label: "Afternoon",
      time: "12:00 PM – 2:00 PM",
      duration: "2 hours",
    },
    {
      id: "evening",
      start: "15:00",
      end: "18:00",
      label: "Evening",
      time: "3:00 PM – 6:00 PM",
      duration: "3 hours",
    },
  ];

  const timeSlots = useMemo(() => {
    if (!selectedDate) {
      return [];
    }

    const dayAvailability = availability?.dates?.[selectedDate];

    /*
    * If availability data has not loaded for this date yet,
    * don't assume anything is unavailable.
    */
    if (!dayAvailability) {
      return APPOINTMENT_SLOTS;
    }

    /*
    * Full-day block means no appointment is possible.
    */
    if (dayAvailability.all_day_blocked) {
      return [];
    }

    const blockedRanges = [];

    /*
    * Admin availability blocks
    */
    if (Array.isArray(dayAvailability.blocks)) {
      dayAvailability.blocks.forEach((block) => {
        if (block.start_time && block.end_time) {
          blockedRanges.push({
            start: timeToMinutes(block.start_time),
            end: timeToMinutes(block.end_time),
          });
        }
      });
    }

    /*
    * Existing pending / confirmed bookings
    */
    if (Array.isArray(dayAvailability.bookings)) {
      dayAvailability.bookings.forEach((booking) => {
        if (booking.start_time && booking.end_time) {
          blockedRanges.push({
            start: timeToMinutes(booking.start_time),
            end: timeToMinutes(booking.end_time),
          });
        }
      });
    }

    /*
    * Only show one of the three fixed appointment windows
    * when the entire window is available.
    */
    return APPOINTMENT_SLOTS.filter((slot) => {
      const slotStart = timeToMinutes(slot.start);
      const slotEnd = timeToMinutes(slot.end);

      const overlaps = blockedRanges.some(
        (range) =>
          slotStart < range.end &&
          slotEnd > range.start
      );

      return !overlaps;
    });
  }, [selectedDate, availability]);


  function selectTime(slot) {
    setSelectedStartTime(slot.start);
    setSelectedEndTime(slot.end);
    setErrorMessage("");
  }


  function updateForm(field, value) {
    setForm((previous) => ({
      ...previous,
      [field]: value,
    }));
  }


  function continueToDetails() {
    if (!selectedDate) {
      setErrorMessage("Please select a date.");
      return;
    }

    if (!selectedStartTime || !selectedEndTime) {
      setErrorMessage("Please select an appointment time.");
      return;
    }

    setErrorMessage("");
    setStep(3);
  }


  async function submitBooking(event) {
    event.preventDefault();

    setSubmitting(true);
    setErrorMessage("");
    setSuccessMessage("");

    try {
      const payload = {
        name: form.name,
        phone: form.phone,
        email: form.email || null,
        event_type: form.event_type,
        event_date: selectedDate,
        start_time: selectedStartTime,
        end_time: selectedEndTime,
        location: form.location,
        message: form.message || null,
      };

      const response =
        await bookingApi.create(payload);

      if (!response.status) {
        throw new Error(
          response.message ||
            "Unable to create booking."
        );
      }

      setSuccessMessage(
        "Your booking request has been received. We will contact you shortly to confirm your appointment."
      );

      setStep(4);
    } catch (error) {
      console.error(error);

      const message =
        error?.response?.data?.message ||
        error?.response?.data?.error ||
        error?.message ||
        "Something went wrong. Please try again.";

      setErrorMessage(message);
    } finally {
      setSubmitting(false);
    }
  }


  return (
    <div className="min-h-screen bg-[#faf6f3] text-[#332b2d]">

      {/* HERO */}
      <section className="px-5 pt-16 pb-10 sm:px-8 sm:pt-20">

        <div className="mx-auto max-w-5xl text-center">

          <p className="text-xs uppercase tracking-[0.3em] text-[#a56b76] font-semibold">
            Appointment
          </p>

          <h1 className="mt-3 font-serif text-4xl sm:text-5xl lg:text-6xl">
            Reserve Your Date
          </h1>

          <p className="mx-auto mt-4 max-w-2xl text-sm sm:text-base leading-7 text-[#817673]">
            Choose your preferred date and time for your makeup appointment.
            We'll take care of the rest.
          </p>

        </div>

      </section>


      {/* STEPS */}
      <div className="px-5 pb-8 sm:px-8">

        <div className="mx-auto max-w-3xl">

          <div className="flex items-center justify-center gap-2 sm:gap-4">

            {[1, 2, 3].map((number) => (

              <div
                key={number}
                className="flex items-center gap-2"
              >

                <div
                  className={[
                    "h-8 w-8 rounded-full flex items-center justify-center text-xs font-semibold transition",
                    step >= number
                      ? "bg-[#a56b76] text-white"
                      : "bg-white border border-[#e5d9d9] text-[#9a8f8f]",
                  ].join(" ")}
                >
                  {number}
                </div>

                <span
                  className={[
                    "hidden sm:block text-xs",
                    step >= number
                      ? "text-[#5d454a]"
                      : "text-[#9a8f8f]",
                  ].join(" ")}
                >
                  {number === 1
                    ? "Date"
                    : number === 2
                    ? "Time"
                    : "Details"}
                </span>

                {number < 3 && (
                  <span className="hidden sm:block h-px w-10 bg-[#e4d9d9]" />
                )}

              </div>

            ))}

          </div>

        </div>

      </div>


      <main className="px-5 pb-20 sm:px-8">

        <div className="mx-auto max-w-5xl">


          {/* ERROR */}
          {errorMessage && (

            <div className="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
              {errorMessage}
            </div>

          )}


          {/* SUCCESS */}
          {successMessage && step === 4 && (

            <div className="rounded-3xl bg-white border border-[#eadfe0] shadow-sm p-8 sm:p-12 text-center">

              <div className="mx-auto h-16 w-16 rounded-full bg-[#e5f0e3] flex items-center justify-center text-[#668a63] text-2xl">
                ✓
              </div>

              <p className="mt-6 text-xs uppercase tracking-[0.25em] text-[#a56b76] font-semibold">
                Thank You
              </p>

              <h2 className="mt-2 font-serif text-3xl text-[#332b2d]">
                Your request is received
              </h2>

              <p className="mx-auto mt-4 max-w-lg text-sm leading-7 text-[#817673]">
                {successMessage}
              </p>

              <div className="mt-6 rounded-2xl bg-[#faf6f3] p-5">

                <p className="font-medium text-[#332b2d]">
                  {formatDisplayDate(selectedDate)}
                </p>

                <p className="mt-1 text-sm text-[#817673]">
                  {formatTime(selectedStartTime)}
                  {" – "}
                  {formatTime(selectedEndTime)}
                </p>

              </div>

            </div>

          )}


          {/* STEP 1 — DATE */}
          {step === 1 && (

            <div className="rounded-3xl bg-white border border-[#eadfe0] shadow-sm overflow-hidden">

              <div className="p-5 sm:p-8">

                <div className="flex items-center justify-between gap-4 mb-6">

                  <div>

                    <p className="text-xs uppercase tracking-[0.2em] text-[#a56b76] font-semibold">
                      Step 1
                    </p>

                    <h2 className="mt-1 font-serif text-2xl sm:text-3xl">
                      Choose your date
                    </h2>

                  </div>

                  {loadingAvailability && (
                    <span className="text-xs text-[#817673]">
                      Checking availability…
                    </span>
                  )}

                </div>


                {availabilityError && (
                  <p className="mb-5 text-sm text-red-600">
                    {availabilityError}
                  </p>
                )}


                {/* MONTH NAVIGATION */}
                <div className="flex items-center justify-between mb-5">

                  <button
                    type="button"
                    onClick={previousMonth}
                    className="h-10 w-10 rounded-full hover:bg-[#f7eeee] text-[#5d5552]"
                  >
                    ←
                  </button>


                  <h3 className="font-serif text-xl text-[#332b2d]">

                    {calendarDate.toLocaleDateString(
                      undefined,
                      {
                        month: "long",
                        year: "numeric",
                      }
                    )}

                  </h3>


                  <button
                    type="button"
                    onClick={nextMonth}
                    className="h-10 w-10 rounded-full hover:bg-[#f7eeee] text-[#5d5552]"
                  >
                    →
                  </button>

                </div>


                {/* WEEKDAYS */}
                <div className="grid grid-cols-7 gap-1 mb-2">

                  {[
                    "Mon",
                    "Tue",
                    "Wed",
                    "Thu",
                    "Fri",
                    "Sat",
                    "Sun",
                  ].map((day) => (

                    <div
                      key={day}
                      className="text-center text-[10px] uppercase tracking-wider text-[#a59a96] py-2"
                    >
                      {day}
                    </div>

                  ))}

                </div>


                {/* DAYS */}
                <div className="grid grid-cols-7 gap-1 sm:gap-2">

                  {monthDays.map(
                    (date, index) => {

                      if (!date) {

                        return (
                          <div
                            key={`empty-${index}`}
                            className="aspect-square"
                          />
                        );

                      }


                      const dateString =
                        formatDate(date);

                      const state =
                        getDateState(dateString);


                      const isPast =
                        date < today;


                      const isSelected =
                        selectedDate ===
                        dateString;


                      const isBlocked =
                        state.blocked ||
                        isPast;


                      return (

                        <button
                          key={dateString}
                          type="button"
                          disabled={isBlocked}
                          onClick={() =>
                            handleDateSelect(
                              dateString
                            )
                          }
                          className={[
                            "relative aspect-square rounded-xl sm:rounded-2xl flex flex-col items-center justify-center transition border",
                            isBlocked
                              ? "bg-[#f5f2f1] text-[#c5bdbc] border-transparent cursor-not-allowed"
                              : isSelected
                              ? "bg-[#d7b0b8] border-[#c18e99] text-[#4b3439] shadow-sm"
                              : state.hasBooking
                              ? "bg-[#fbf0f2] border-[#ecd7db] text-[#7f5962] hover:bg-[#f6e5e8]"
                              : state.partial
                              ? "bg-[#f5f2f1] border-[#e5dddd] text-[#62595a] hover:bg-[#eee9e7]"
                              : "bg-[#eef5ed] border-[#d9e8d7] text-[#587355] hover:bg-[#e4f0e2]",
                          ].join(" ")}
                        >

                          <span className="text-sm sm:text-base font-medium">
                            {date.getDate()}
                          </span>


                          {!isBlocked && (
                            <span className="absolute bottom-1.5 sm:bottom-2">

                              {isSelected ? (
                                <span className="block h-1.5 w-1.5 rounded-full bg-[#8d5964]" />
                              ) : state.hasBooking ? (
                                <span className="block h-1.5 w-1.5 rounded-full bg-[#a56b76]" />
                              ) : state.partial ? (
                                <span className="block h-1.5 w-1.5 rounded-full bg-[#655b5d]" />
                              ) : (
                                <span className="block h-1.5 w-1.5 rounded-full bg-[#8caf8a]" />
                              )}

                            </span>
                          )}

                        </button>

                      );

                    }
                  )}

                </div>


                {/* LEGEND */}
                <div className="mt-6 flex flex-wrap gap-x-5 gap-y-2 text-[11px] text-[#817673]">

                  <div className="flex items-center gap-2">
                    <span className="h-2 w-2 rounded-full bg-[#8caf8a]" />
                    Available
                  </div>

                  <div className="flex items-center gap-2">
                    <span className="h-2 w-2 rounded-full bg-[#a56b76]" />
                    Booked
                  </div>

                  <div className="flex items-center gap-2">
                    <span className="h-2 w-2 rounded-full bg-[#655b5d]" />
                    Partially unavailable
                  </div>

                </div>

              </div>

            </div>

          )}


          {/* STEP 2 — TIME */}
          {step === 2 && (

            <div className="rounded-3xl bg-white border border-[#eadfe0] shadow-sm overflow-hidden">

              <div className="p-5 sm:p-8">

                <button
                  type="button"
                  onClick={() => setStep(1)}
                  className="text-sm text-[#a56b76] mb-5"
                >
                  ← Change date
                </button>


                <p className="text-xs uppercase tracking-[0.2em] text-[#a56b76] font-semibold">
                  Step 2
                </p>

                <h2 className="mt-1 font-serif text-2xl sm:text-3xl">
                  Choose your time
                </h2>

                <p className="mt-2 text-sm text-[#817673]">
                  {formatDisplayDate(selectedDate)}
                </p>


                {timeSlots.length === 0 ? (

                  <div className="mt-8 rounded-2xl bg-[#faf6f3] p-6 text-center">

                    <p className="font-medium text-[#4b3f41]">
                      No appointment times are available.
                    </p>

                    <p className="mt-2 text-sm text-[#817673]">
                      Please choose another date.
                    </p>

                  </div>

                ) : (

                  <>

                    <div className="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">

                      {timeSlots.map((slot) => {

                        const selected =
                          selectedStartTime ===
                          slot.start;


                        return (

                          <button
                            key={slot.start}
                            type="button"
                            onClick={() => selectTime(slot)}
                            className={[
                              "rounded-2xl border px-4 py-5 text-left transition",
                              selected
                                ? "border-[#c18e99] bg-[#f5e1e5] text-[#553a40]"
                                : "border-[#e6dcdc] bg-white hover:bg-[#faf3f4] hover:border-[#d5b6bd] text-[#514849]",
                            ].join(" ")}
                          >
                            <span className="block text-xs uppercase tracking-[0.18em] text-[#a56b76]">
                              {slot.label}
                            </span>

                            <span className="block mt-2 font-medium text-base">
                              {formatTime(slot.start)}
                              {" – "}
                              {formatTime(slot.end)}
                            </span>

                            <span className="block mt-1 text-xs opacity-60">
                              {slot.duration}
                            </span>
                          </button>

                        );

                      })}

                    </div>


                    <div className="mt-8 flex justify-end">

                      <button
                        type="button"
                        disabled={!selectedStartTime}
                        onClick={continueToDetails}
                        className="w-full sm:w-auto rounded-2xl bg-[#4b3a3d] px-7 py-4 text-sm font-semibold text-white disabled:opacity-40 hover:bg-[#382c2f] transition"
                      >
                        Continue
                      </button>

                    </div>

                  </>

                )}

              </div>

            </div>

          )}


          {/* STEP 3 — DETAILS */}
          {step === 3 && (

            <form
              onSubmit={submitBooking}
              className="rounded-3xl bg-white border border-[#eadfe0] shadow-sm overflow-hidden"
            >

              <div className="p-5 sm:p-8 border-b border-[#eee5e5]">

                <button
                  type="button"
                  onClick={() => setStep(2)}
                  className="text-sm text-[#a56b76] mb-5"
                >
                  ← Change time
                </button>


                <p className="text-xs uppercase tracking-[0.2em] text-[#a56b76] font-semibold">
                  Step 3
                </p>

                <h2 className="mt-1 font-serif text-2xl sm:text-3xl">
                  Your details
                </h2>


                <div className="mt-5 rounded-2xl bg-[#faf6f3] p-4">

                  <p className="font-medium text-[#332b2d]">
                    {formatDisplayDate(selectedDate)}
                  </p>

                  <p className="mt-1 text-sm text-[#817673]">
                    {formatTime(selectedStartTime)}
                    {" – "}
                    {formatTime(selectedEndTime)}
                  </p>

                </div>

              </div>


              <div className="p-5 sm:p-8">

                <div className="grid sm:grid-cols-2 gap-5">

                  <div>

                    <label className="block text-sm font-medium mb-2">
                      Your name
                    </label>

                    <input
                      type="text"
                      value={form.name}
                      onChange={(event) =>
                        updateForm(
                          "name",
                          event.target.value
                        )
                      }
                      required
                      minLength={3}
                      maxLength={100}
                      placeholder="Your name"
                      className="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#a56b76]"
                    />

                  </div>


                  <div>

                    <label className="block text-sm font-medium mb-2">
                      Phone
                    </label>

                    <input
                      type="tel"
                      value={form.phone}
                      onChange={(event) =>
                        updateForm(
                          "phone",
                          event.target.value
                        )
                      }
                      required
                      maxLength={20}
                      placeholder="Phone number"
                      className="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#a56b76]"
                    />

                  </div>


                  <div className="sm:col-span-2">

                    <label className="block text-sm font-medium mb-2">
                      Email
                      <span className="ml-1 text-[#a59a96] font-normal">
                        (optional)
                      </span>
                    </label>

                    <input
                      type="email"
                      value={form.email}
                      onChange={(event) =>
                        updateForm(
                          "email",
                          event.target.value
                        )
                      }
                      placeholder="you@example.com"
                      className="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#a56b76]"
                    />

                  </div>


                  <div>

                    <label className="block text-sm font-medium mb-2">
                      Event type
                    </label>

                    <select
                      value={form.event_type}
                      onChange={(event) =>
                        updateForm(
                          "event_type",
                          event.target.value
                        )
                      }
                      required
                      className="w-full rounded-xl border border-black/10 px-4 py-3.5 bg-white outline-none focus:border-[#a56b76]"
                    >

                      <option value="">
                        Select event
                      </option>

                      {EVENT_TYPES.map((eventType) => (
                        <option
                          key={eventType}
                          value={eventType}
                        >
                          {eventType}
                        </option>
                      ))}

                    </select>

                  </div>


                  <div>

                    <label className="block text-sm font-medium mb-2">
                      Location
                    </label>

                    <input
                      type="text"
                      value={form.location}
                      onChange={(event) =>
                        updateForm(
                          "location",
                          event.target.value
                        )
                      }
                      required
                      maxLength={150}
                      placeholder="Venue / location"
                      className="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#a56b76]"
                    />

                  </div>


                  <div className="sm:col-span-2">

                    <label className="block text-sm font-medium mb-2">
                      Message
                      <span className="ml-1 text-[#a59a96] font-normal">
                        (optional)
                      </span>
                    </label>

                    <textarea
                      value={form.message}
                      onChange={(event) =>
                        updateForm(
                          "message",
                          event.target.value
                        )
                      }
                      rows={4}
                      placeholder="Tell us anything you'd like us to know..."
                      className="w-full rounded-xl border border-black/10 px-4 py-3.5 outline-none focus:border-[#a56b76]"
                    />

                  </div>

                </div>

              </div>


              <div className="px-5 sm:px-8 py-5 bg-[#faf6f3]">

                <button
                  type="submit"
                  disabled={submitting}
                  className="w-full rounded-2xl bg-[#292322] px-7 py-4 text-sm font-semibold text-white disabled:opacity-50 hover:bg-[#3b3331] transition"
                >
                  {submitting
                    ? "Sending request..."
                    : "Request Appointment"}
                </button>

              </div>

            </form>

          )}

        </div>

      </main>

    </div>
  );
}
document.getElementById("openBookingBtn").addEventListener("click", function () {
  if (BOOKING_OPEN_MODE === 1) {
    document.getElementById("bookingModal").classList.remove("hidden");
    document.getElementById("bookingModal").classList.add("flex");
    document.body.style.overflow = "hidden"; // 🔒 lock background
  } else {
    window.location.href = "frontend/booking.html";
  }
});

// Close modal
function closeBookingModal() {
  document.getElementById("bookingModal").classList.add("hidden");
  document.getElementById("bookingModal").classList.remove("flex");
  document.body.style.overflow = ""; // 🔓 unlock scroll
}

document.getElementById("closeBookingModal").addEventListener("click", closeBookingModal);

document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    closeBookingModal();
  }
});

document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    closeBookingModal();
  }
});

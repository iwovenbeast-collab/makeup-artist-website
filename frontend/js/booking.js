document.getElementById("bookingForm").addEventListener("submit", async function (e) {
  e.preventDefault();

  const form = e.target;
  const successMsg = document.getElementById("successMsg");

  const data = {
    name: form.name.value,
    phone: form.phone.value,
    email: form.email.value,
    event_type: form.event_type.value,
    event_date: form.event_date.value,
    location: form.location.value,
    message: form.message.value,
  };

  try {
    const response = await fetch("http://localhost:8080/api/bookings", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });
    
    if (!response.ok) {
        const err = await response.json();
        alert(Object.values(err.errors).join("\n"));
        return;
    }


    successMsg.classList.remove("hidden");
    form.reset();

    // Auto close popup after 2 seconds
    setTimeout(() => {
    if (window.parent && window.parent.closeBookingModal) {
        window.parent.closeBookingModal();
    }
    }, 2000);

  } catch (error) {
    alert("Something went wrong. Please try again.");
  }
});

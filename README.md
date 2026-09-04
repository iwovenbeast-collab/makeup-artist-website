# Rupanjali Makeup Artistry

A full-stack website and appointment management system for **Rupanjali
Makeup Artistry**.

The project has two main applications:

-   **Public Website:** React + Vite
-   **Admin/API Backend:** CodeIgniter 4 + MySQL

The public website is designed to present the makeup artist's brand,
portfolio, services, stories, and booking experience. The admin panel is
used to manage bookings, availability, and stories.

# Rupanjali Makeup Artistry Website

A makeup artist portfolio and booking website with a React frontend and CodeIgniter 4 backend.

## Features

- Public makeup artist profile
- Services section
- Database-backed portfolio gallery
- Stories and blogs
- Optional video or YouTube content for stories
- Booking form
- Booking availability management
- Admin dashboard
- Admin booking management
- Admin services management
- Admin portfolio management
- MySQL database integration

## Project structure

```text
makeup-artist-website/
├── frontend-react/          # React + Vite frontend
├── backend/rupanjali-api/   # CodeIgniter 4 backend
└── README.md

------------------------------------------------------------------------

## 1. Project Architecture

``` text
Rupanjali Makeup Artistry
│
├── frontend-react/
│   └── React + Vite public website
│
└── backend/
    └── rupanjali-api/
        └── CodeIgniter 4 backend + Admin Panel + API
```

### Frontend

The React application runs separately from the CodeIgniter application.

Current development URL:

``` text
http://localhost:5173
```

### Backend

The CodeIgniter application provides:

-   Admin authentication
-   Admin dashboard
-   Booking management
-   Availability management
-   Story/blog management
-   Public API endpoints
-   MySQL database access

Current development URL:

``` text
http://localhost:8080
```

------------------------------------------------------------------------

# 2. Technology Stack

## Frontend

-   React
-   Vite
-   React Router
-   Axios
-   Tailwind CSS
-   Framer Motion
-   Lucide React
-   FullCalendar packages
    -   `@fullcalendar/react`
    -   `@fullcalendar/daygrid`
    -   `@fullcalendar/interaction`

The frontend is responsible for the public-facing experience.

------------------------------------------------------------------------

## Backend

-   PHP
-   CodeIgniter 4.6.4
-   CodeIgniter Models
-   CodeIgniter Controllers
-   CodeIgniter Views
-   CodeIgniter Sessions
-   CodeIgniter Validation
-   MySQL

The backend is responsible for business logic, database operations,
authentication, admin pages, and APIs.

------------------------------------------------------------------------

# 3. Database

Current database:

``` text
artistry
```

Important tables include:

## `bookings`

Stores appointment requests and manually created bookings.

Current fields include:

``` text
id
name
phone
email
event_type
event_date
start_time
end_time
location
message
status
source
created_at
```

### Booking status

``` text
pending
confirmed
cancelled
```

### Booking source

``` text
website
whatsapp
phone
other
```

The `source` field allows the admin to distinguish between online
requests and bookings received through WhatsApp, phone, or other
channels.

------------------------------------------------------------------------

## `availability_blocks`

Stores periods when the makeup artist is unavailable.

Fields include:

``` text
id
block_date
start_time
end_time
all_day
reason
created_at
```

Availability blocks can represent:

-   A complete unavailable day
-   A partial unavailable period

------------------------------------------------------------------------

# 4. Public Website

The React application currently contains the main public sections:

``` text
/
├── Home
├── Profile
├── Portfolio
├── Services
├── Stories
├── Stories/:slug
└── Booking
```

There are also legacy blog routes that redirect toward the Stories
section.

------------------------------------------------------------------------

## Home

The homepage acts as the main brand introduction.

It contains the primary navigation and calls-to-action leading visitors
toward the makeup artist's work and booking experience.

------------------------------------------------------------------------

## Profile

The profile section introduces the makeup artist and brand.

------------------------------------------------------------------------

## Portfolio

The portfolio is intended to showcase makeup work visually.

The project is designed around an image-first beauty/makeup aesthetic.

------------------------------------------------------------------------

## Services

Displays the makeup services offered by the artist.

------------------------------------------------------------------------

## Stories

Stories are the project's blog/editorial section.

The public Stories page loads content from the backend API.

Individual stories are accessed through:

``` text
/stories/:slug
```

------------------------------------------------------------------------

# 5. Public Booking System

The booking system is one of the main features of the project.

Public customers use:

``` text
/booking
```

The booking experience is divided into three steps:

``` text
Step 1 → Date
Step 2 → Time
Step 3 → Details
```

------------------------------------------------------------------------

## Step 1 --- Choose Date

The customer sees a custom calendar rather than relying on a basic date
input.

The calendar considers:

-   Past dates
-   Existing bookings
-   Full-day availability blocks
-   Partial availability blocks
-   Available dates

Available dates are visually highlighted.

------------------------------------------------------------------------

## Step 2 --- Choose Time

Available appointment slots are generated in 30-minute intervals.

The current booking interface uses a one-hour appointment duration.

The current development working window is:

``` text
09:00 AM – 09:00 PM
```

Time slots that overlap existing bookings or unavailable periods are
removed.

------------------------------------------------------------------------

## Step 3 --- Customer Details

The customer provides:

``` text
Name
Phone
Email (optional)
Event type
Location
Message
```

The request is submitted to:

``` text
POST /api/bookings
```

A successful submission displays a confirmation screen.

------------------------------------------------------------------------

# 6. Booking Conflict Prevention

Booking conflicts are checked on the backend.

The backend checks:

### Full-day block

A booking cannot be created on a fully blocked date.

### Partial block

A booking cannot overlap an unavailable time period.

### Existing booking

Pending and confirmed bookings reserve their time.

The overlap logic follows:

``` text
new_start < existing_end
AND
new_end > existing_start
```

This prevents two appointments from occupying overlapping periods.

The backend therefore remains the final authority for booking
availability even if someone attempts to bypass the frontend.

------------------------------------------------------------------------

# 7. Public Availability API

The public booking calendar retrieves availability from:

``` text
GET /api/availability
```

It supports date-based queries such as:

``` text
/api/availability?date=YYYY-MM-DD
```

and date ranges:

``` text
/api/availability?start_date=YYYY-MM-DD&end_date=YYYY-MM-DD
```

The public availability response is intentionally sanitized.

Customer private information such as:

-   Name
-   Phone
-   Email
-   Location
-   Message

is not exposed through the public availability response.

The public calendar only needs booking timing/status information to
determine availability.

------------------------------------------------------------------------

# 8. Admin Panel

The admin panel is built with CodeIgniter views and Tailwind styling.

Main areas currently include:

``` text
/admin/dashboard
/admin/bookings
/admin/bookings/create
/admin/availability
/admin/blogs
```

Admin authentication protects the management pages.

------------------------------------------------------------------------

# 9. Admin Dashboard

The dashboard has been redesigned as an admin overview rather than a
plain statistics page.

It currently contains:

-   Total bookings
-   Pending bookings
-   Confirmed bookings
-   Stories count
-   Upcoming appointments
-   Recent booking activity
-   Quick management links
-   View Calendar action
-   Add Booking action

Upcoming appointments and recent bookings use their own internal scroll
areas so a growing number of bookings does not make the entire dashboard
excessively tall.

------------------------------------------------------------------------

# 10. Admin Booking Management

The booking management page is:

``` text
/admin/bookings
```

It supports:

-   Viewing bookings
-   Confirming pending bookings
-   Cancelling bookings
-   Manually adding bookings
-   Website bookings
-   WhatsApp bookings
-   Phone bookings
-   Other booking sources
-   Search
-   Status filtering
-   Date-from filtering
-   Date-to filtering
-   Pagination

The booking list is paginated rather than displaying every database
record at once.

The current UI is designed to work as:

``` text
10 bookings per page
```

This keeps the page manageable even as the database grows.

------------------------------------------------------------------------

# 11. Manual Admin Bookings

The admin can create a booking manually for customers who contacted the
artist through:

``` text
WhatsApp
Phone
Other
```

The admin booking form supports:

``` text
Client details
Appointment details
Date
Start time
End time
Location
Booking source
Status
Notes
```

Manual bookings go through backend conflict checks just like public
bookings.

The admin can therefore add historical or offline bookings without
bypassing the scheduling rules.

------------------------------------------------------------------------

# 12. Admin Availability Calendar

The admin availability page provides a calendar-based scheduling
interface.

The calendar displays:

### Available

Soft sage/green styling.

### Confirmed

Blush/rose styling.

### Pending

Champagne/gold styling.

### Unavailable

Warm charcoal styling.

------------------------------------------------------------------------

## Calendar interactions

Clicking an available date provides:

``` text
+ Add Booking
Block Date
```

Clicking a booking displays an inspection panel containing information
such as:

``` text
Customer
Phone
Email
Event
Date & Time
Location
Message
Status
```

Clicking an unavailable period displays:

``` text
Date
Time
Reason
```

------------------------------------------------------------------------

# 13. Blocking Availability

The admin can block:

### Entire day

Example:

``` text
15 September 2026
Entire Day
Personal work
```

### Specific period

Example:

``` text
15 September 2026
2:00 PM – 5:00 PM
Personal work
```

The backend prevents a new booking from being created inside an
unavailable period.

It also prevents creating overlapping availability blocks.

Availability blocks can be removed from the admin panel.

------------------------------------------------------------------------

# 14. Admin Stories / Blogs

The backend contains an admin Stories/Blogs section for managing
editorial content.

Current files include:

``` text
app/Views/admin/blogs/create.php
app/Views/admin/blogs/edit.php
app/Views/admin/blogs/index.php
```

The Stories system is connected to the public Stories section through
the backend API.

Further pagination/search polish for the Stories administration is part
of the remaining project work.

------------------------------------------------------------------------

# 15. API / Frontend Communication

The React frontend uses Axios.

The API base URL is currently configured in:

``` text
frontend-react/src/config/app.js
```

Current development configuration:

``` text
API_BASE_URL = http://localhost:8080
```

The React booking service is handled through:

``` text
frontend-react/src/services/api.js
```

The booking API currently exposes methods for:

``` text
Create booking
Get bookings
```

------------------------------------------------------------------------

# 16. React Booking Configuration

The frontend currently contains a booking configuration similar to:

``` text
APP_CONFIG
├── API_BASE_URL
└── BOOKING_OPEN_MODE
```

`BOOKING_OPEN_MODE` controls whether the public booking flow is open.

------------------------------------------------------------------------

# 17. Routing

React Router controls the public application routes.

The public app uses a single `BrowserRouter`.

Important routes include:

``` text
/
/profile
/portfolio
/services
/stories
/stories/:slug
/booking
```

The old blog paths redirect toward Stories.

------------------------------------------------------------------------

# 18. Admin Calendar Technology

The admin calendar is implemented inside the CodeIgniter PHP view using
the FullCalendar browser build.

The current admin view loads:

``` text
FullCalendar 6.1.19
```

from the jsDelivr CDN.

This is separate from the React FullCalendar packages.

That distinction is intentional:

``` text
Public calendar
    ↓
React
    ↓
npm FullCalendar packages

Admin calendar
    ↓
CodeIgniter PHP View
    ↓
FullCalendar browser build
```

------------------------------------------------------------------------

# 19. Security / Privacy Design

The public availability endpoint does not expose customer private
details.

Admin booking data is loaded directly into the protected admin calendar
so administrators can inspect customer information.

Booking creation is validated on the backend.

Admin pages require an authenticated admin session.

Important business rules are enforced server-side rather than relying
only on frontend JavaScript.

------------------------------------------------------------------------

# 20. Current Development Environment

Expected development setup:

### Frontend

``` bash
cd ~/makeup-artist-website/frontend-react
npm install
npm run dev
```

Frontend:

``` text
http://localhost:5173
```

### Backend

``` bash
cd ~/makeup-artist-website/backend/rupanjali-api
php spark serve
```

Backend:

``` text
http://localhost:8080
```

The MySQL database is:

``` text
artistry
```

------------------------------------------------------------------------

# 21. Important Project Directories

## React

``` text
frontend-react/
├── src/
│   ├── components/
│   │   ├── Booking/
│   │   ├── Home/
│   │   ├── Navbar/
│   │   ├── Portfolio/
│   │   ├── Profile/
│   │   ├── Services/
│   │   └── Stories/
│   │
│   ├── config/
│   │   └── app.js
│   │
│   ├── services/
│   │   └── api.js
│   │
│   └── App.jsx
```

## CodeIgniter

``` text
backend/rupanjali-api/
├── app/
│   ├── Controllers/
│   │   └── Admin/
│   │
│   ├── Models/
│   │
│   ├── Views/
│   │   └── admin/
│   │
│   └── Config/
│
├── public/
└── writable/
```

------------------------------------------------------------------------

# 22. Current Project Status

## Completed / Working

-   Public website structure
-   Responsive navigation
-   Home/Profile/Portfolio/Services sections
-   Stories API integration
-   Public Stories display
-   Public booking page
-   Custom booking calendar
-   Time-slot selection
-   Booking form
-   Booking confirmation screen
-   Backend booking API
-   Availability API
-   Booking conflict prevention
-   Availability block conflict prevention
-   Admin authentication
-   Admin dashboard UI
-   Upcoming appointment dashboard
-   Recent booking activity
-   Admin booking listing
-   Booking pagination
-   Booking search/filter system
-   Date-from/date-to booking filters
-   Status filtering
-   Manual admin bookings
-   Booking source tracking
-   Admin availability calendar
-   Full-day availability blocks
-   Partial availability blocks
-   Calendar booking inspection
-   Calendar availability inspection
-   Mobile admin booking cards
-   Mobile responsive booking flow

------------------------------------------------------------------------

# 23. Remaining Work

The project is now in the finishing stage.

Recommended order:

``` text
1. Finish Admin Stories/Blogs
       ↓
2. Improve Public Stories
       ↓
3. Finish Portfolio gallery experience
       ↓
4. Full mobile/responsive audit
       ↓
5. Backend security/validation audit
       ↓
6. Production configuration
       ↓
7. Final testing
       ↓
8. Deployment
```

The scheduling/booking system is already the core completed business
feature.

------------------------------------------------------------------------

# 24. Design Direction

The visual direction is intentionally:

-   Premium
-   Elegant
-   Feminine
-   Editorial
-   Minimal
-   Luxury beauty brand
-   Soft neutral backgrounds
-   Blush/rose accents
-   Sage availability indicators
-   Serif display typography
-   Rounded cards
-   Subtle borders and shadows
-   Strong mobile responsiveness

The goal is for the website to feel like a **premium makeup artist
brand**, rather than a generic business template.

------------------------------------------------------------------------

# 25. Development Notes

When adding new booking functionality:

1.  Update backend validation first.
2.  Keep conflict detection server-side.
3.  Do not expose customer information through public availability APIs.
4.  Keep admin customer information inside authenticated admin pages.
5.  Test both desktop and mobile.
6.  Test with multiple bookings on the same date.
7.  Test overlapping and non-overlapping time periods.
8.  Test full-day and partial-day blocks.
9.  Test pagination with a large number of records.

For frontend changes, remember that the React public application and
CodeIgniter admin application are separate applications.

------------------------------------------------------------------------

# 26. Current Goal

The immediate goal is to finish the remaining UI/content work and then
perform a complete end-to-end test.

The final system should allow:

``` text
Customer
   │
   ├── Browse makeup work
   ├── Read stories
   └── Request appointment
             │
             ↓
        Backend API
             │
             ↓
        MySQL Database
             │
             ↓
          Admin
             │
       ┌─────┴─────┐
       │           │
   Bookings    Calendar
       │           │
       └─────┬─────┘
             │
        Confirm / Manage
```

This README should be kept updated as major architecture, features, or
deployment configuration changes are made.

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import axios from 'axios';

// Initialize FullCalendar
document.addEventListener('DOMContentLoaded', function () {
  const calendarEl = document.getElementById('calendar');
  const addEventSidebar = document.getElementById('addEventSidebar');
  const btnAddEvent = document.querySelector('.btn-add-event');
  const eventForm = document.getElementById('eventForm');

  // Fetch events from Laravel and add to the calendar
  function fetchEvents(calendar) {
    axios.get('/dev/corpu2/simapeka/public/kalender/events')
      .then(response => {
        const events = response.data;
  
        // Add dynamic "Tanggal Merah" for Saturdays and Sundays
        const startDate = new Date(); // Start from today
        const endDate = new Date(startDate.getFullYear(), 11, 31); // Until the end of the year
        const weekendEvents = [];
  
        for (let date = new Date(startDate); date <= endDate; date.setDate(date.getDate() + 1)) {
          const day = date.getDay();
          if (day === 0 || day === 6) { // Sunday (0) or Saturday (6)
            weekendEvents.push({
              title: 'Tanggal Merah',
              start: date.toISOString().split('T')[0], // Format as YYYY-MM-DD
              allDay: true,
            });
          }
        }
  
        // Add fetched events and weekend events to the calendar
        calendar.removeAllEvents();
        calendar.addEventSource([...events, ...weekendEvents]);
      })
      .catch(error => {
        console.error('Error fetching events:', error);
      });
  }
  

  // Initialize FullCalendar
  const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    editable: true,
    selectable: true,
    dateClick: function (info) {
      // Pre-fill dates in the sidebar form
      document.getElementById('eventStartDate').value = info.dateStr;
      document.getElementById('eventEndDate').value = info.dateStr;

      // Open sidebar
      new bootstrap.Offcanvas(addEventSidebar).show();
    },
  });

  // Render the calendar
  fetchEvents(calendar);
  calendar.render();

  // Handle "Add Event" button click
  btnAddEvent.addEventListener('click', function (e) {
    e.preventDefault();

    const eventTitle = document.getElementById('eventTitle').value;
    const eventStartDate = document.getElementById('eventStartDate').value;

    if (eventTitle && eventStartDate) {
      // Save event to the database
      axios.post('/dev/corpu2/simapeka/public/kalender/events', {
        nama: eventTitle,
        tanggal: eventStartDate,
      })
        .then(() => {
          fetchEvents(calendar); // Refresh events after adding
          eventForm.reset(); // Reset the form
          new bootstrap.Offcanvas(addEventSidebar).hide(); // Close the sidebar
        })
        .catch(error => {
          console.error('Error adding event:', error);
        });
    } else {
      alert('Please fill in all fields!');
    }
  });
});

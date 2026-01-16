/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';

document.addEventListener('DOMContentLoaded', () => {

    const calendarEl = document.getElementById('calendar');

    if (!calendarEl) return; // ✅ prevent FullCalendar crash
    
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',

        // Enable clicking on date & event
        dateClick: showEventsOnDate,
        eventClick: showEventDetails,
        
        events: "/calendar/events"
    });

    calendar.render();

    calendar.render();
    function showEventsOnDate(info) {
        let selectedDate = info.dateStr;
        document.getElementById("modalDate").innerText = selectedDate;

        fetch("/calendar/events")
            .then(res => res.json())
            .then(events => {
                let list = events.filter(e => e.start.startsWith(selectedDate));
                let html = "";

                if (list.length === 0) {
                    html = "<p>No events.</p>";
                } else {
                    list.forEach(e => {
                        html += `
                            <div class="p-2 border rounded mb-2 event-item"
                                 style="cursor:pointer"
                                 onclick="openEvent(${e.id}, '${e.title}', '${e.start}', '${e.end}', '${e.venue}', \`${e.description ?? ''}\`)">
                                <strong>${e.title}</strong><br>
                                ${e.start.substring(11, 16)}
                            </div>
                        `;
                    });
                }

                document.getElementById("dateEventList").innerHTML = html;

                new bootstrap.Modal(document.getElementById("dateEventsModal")).show();
            });
    }

    // When clicking an EVENT on the calendar
    function showEventDetails(info) {
        openEvent(
            info.event.id,
            info.event.title,
            info.event.startStr,
            info.event.endStr,
            info.event.extendedProps.venue,
            info.event.extendedProps.description
        );
    }
});

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


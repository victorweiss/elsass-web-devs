import "./scss/front.scss";
// import "bootstrap/js/src/dropdown"
import "bootstrap/js/src/collapse";

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";

var events = $("#calendar").data("events");
console.log(events);
const calendarEl = document.getElementById("calendar");
const calendar = new Calendar(calendarEl, {
  plugins: [dayGridPlugin, listPlugin],
  headerToolbar: {
    initialView: "dayGridMonth",
    left: "dayGridMonth,listMonth",
    center: "title",
    right: "prev,next today",
  },
  locale: "fr",
  buttonText: {
    today: "Aujourd'hui",
    month: "Mois",
    week: "Semaine",
    day: "Jour",
    list: "Liste",
  },
  events: events,
  eventColor: "#D50000",
  navLinks: true,

  eventClick: function() {
    // alert('Event: ' + info.event.title);

  }
});

calendar.render();

import "./scss/front.scss";
// import "bootstrap/js/src/dropdown"
import "bootstrap/js/src/collapse";


import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";

// var rdvs = JSON.parse("{{ data|raw }}");
var events = $("#calendar").data("events");
console.log(events);
const calendarEl = document.getElementById("calendar");
const calendar = new Calendar(calendarEl, {
  plugins: [
    dayGridPlugin,
    listPlugin,
    // any other plugins
  ],
  headerToolbar: {
    initialView: "dayGridMonth",
    left: "dayGridMonth,listMonth",
    center: "title",
    right: "prev,next today",
  },
  locale: "fr",
  buttonText: {
    today: "Aujourd'hui",
    month: "mois",
    week: "semaine",
    day: "jour",
    list: "liste",
  },
  events: events,
  navLinks: true,
});

calendar.render();

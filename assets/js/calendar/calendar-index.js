import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from '@fullcalendar/timegrid';
import momentPlugin from '@fullcalendar/moment'; 

import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";
import "@fullcalendar/interaction/main.js";
import "@fullcalendar/core/locales-all.js";
import './admin-index.css';


document.addEventListener("DOMContentLoaded", () => {
    var calendarEl = document.getElementById("calendar-holder");

    var eventsUrl = calendarEl.dataset.eventsUrl;

  var calendar = new Calendar(calendarEl,{
       
    defaultView: "dayGridMonth",
     locale: 'fr',
   buttonText: {
    today:    'Aujourd\'hui',
    month:    'Mois',
    week:     'Semaine',
    day: 'Jour',
    allDayHtml: "Toute la<br/>journée",
    'timeGrid': 'Heure',
    list: 'Liste',
  
    }, 
      plugins: [ interactionPlugin,  dayGridPlugin,  timeGridPlugin, momentPlugin], // https://fullcalendar.io/docs/plugin-index
      timeZone:  'Europe/Paris',
     'nowIndicator' : true,
     'selectable': false,
      editable: false,
        eventSources: [
            {
                url: eventsUrl,
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
      ],
        header: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
     
      
      dateClick: (event) => {
          $('#modal').modal('show');
       
      },
      validRange: function (nowDate) {
           
       return {
         start:  nowDate,
         end: nowDate.allDay,   
       
        };
      },
   
      eventDrop: (infos) => {
          console.log("le nouveau rendez-vous commencera à "+infos.event.start)
    } 
   
  });

    calendar.render();
});



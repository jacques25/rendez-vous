import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from '@fullcalendar/list';
import timeGridPlugin from '@fullcalendar/timegrid';


import momentPlugin from '@fullcalendar/moment'; 


import "@fullcalendar/core/main.css";
import "@fullcalendar/daygrid/main.css";
import "@fullcalendar/timegrid/main.css";
import "@fullcalendar/interaction/main.js";
import "@fullcalendar/core/locales-all.js";
import "@fullcalendar/list/main.css";
import './index.css';


document.addEventListener("DOMContentLoaded", () => {
    var calendarEl = document.getElementById("calendar-holder");

    var eventsUrl = calendarEl.dataset.eventsUrl;
  
  var calendar = new Calendar(calendarEl,{
   plugins: [ interactionPlugin,  dayGridPlugin,  timeGridPlugin, momentPlugin, listPlugin], // https://fullcalendar.io/docs/plugin-index
    defaultView: 'timeGridWeek',
     locale: 'fr',
   buttonText: {
    today:    'Aujourd\'hui',
    month:    'Mois',
     week: 'Semaine',
     'list' :  'Liste',
    day: 'Jour',
    allDayHtml: "Toute la<br/>journée",
    'timeGrid': 'Heure',
    list: 'Liste',
  
    }, 
   
      timeZone:  'Europe/Paris',
     nowIndicator:  true,
     selectable: true,
    editable: true,
      
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
                rendering: 'inverse-background'
            },
      ],
        header: {
            left: "prev,next today",
            center: "title",
            right: "timeGridWeek ,timeGridDay",
        },
      
    views: {
      timeGrid: {
          
          }
        },

     dateClick: (startParam) => {  
    
        
        $("input#beginAt").attr('data-date', startParam.dateStr); 
       $("#beginAt").attr('value', startParam.dateStr);
        $('#modalForm').modal('show');
      
      },
      
    validRange: function (nowDate) {
      return {
           start: nowDate,
         }
      },
      eventDrop: (infos) => {
          console.log("le nouveau rendez-vous commencera à "+infos.event.start)
    } ,
    

  });
 
    calendar.render();
});



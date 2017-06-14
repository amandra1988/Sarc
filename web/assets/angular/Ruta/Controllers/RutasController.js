angular.module('admin-rutas')
.controller('RutasController',['$scope','$http','uiCalendarConfig','$uibModal','urlBasePartials',function ($scope,$http,uiCalendarConfig,$uibModal,urlBasePartials) {


    $scope.eventSources = [];
    $scope.SelectedEvent=null;
    var isFirstTime = true ;


    $scope.events = [];


    $scope.events = [
        {
            title: 'All Day Event',
            start: '2017-06-01'
        },
        {
            title: 'Long Event',
            start: '2017-06-07',
            end: '2017-06-10'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2017-06-06'
        },
        {
            id: 999,
            title: 'Repeating Event',
            start: '2017-06-16'
        },
        {
            title: 'Conference',
            start: '2017-06-11',
            end: '2017-06-13'
        },
        {
            title: 'Meeting',
            start: '2017-06-12',
            end: '2017-06-12'
        },
        {
            title: 'Lunch',
            start: '2017-06-12'
        },
        {
            title: 'Meeting',
            start: '2017-06-12'
        },
        {
            title: 'Happy Hour',
            start: '2017-06-12'
        },
        {
            title: 'Dinner',
            start: '2017-06-12'
        },
        {
            title: 'Birthday Party',
            start: '2017-06-13'
        },
        {
            title: 'Click for Google',
            url: 'http://google.com/',
            start: '2017-06-28'
        }
    ];

    $scope.eventSources = [$scope.events];

    $scope.uiConfig = {
         calendar: {
             height: 450,
             editable: true,
             displayEventTime:true,
             fixedWeekCount : false,
             header: {
                 left:  'prev,next,today',
                 center:'title',
                 right: 'agendaDay,agendaWeek,month'
             },
             buttonText:
             {
                 day   : 'Día',
                 month : 'Mes',
                 week  : 'Semana',
                 today : 'Hoy'
             },

             monthNames      : ['Enero' , 'Febrero' , 'Marzo' , 'Abril' , 'Mayo' , 'Junio' , 'Julio' ,'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ],
             monthNamesShort : ['Ene' , 'Feb' , 'Mar' , 'Abr' , 'May' , 'Jun' , 'Jul' ,'Ago' , 'Sep' , 'Oct' , 'Nov' , 'Dec' ],
             dayNames        : ['Domingo','Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
             dayNamesShort   : ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],

             eventClick: function(event){
                $scope.SelectedEvent = event;
             },
             eventAfterRender: function(){
                 if($scope.event.length > 0 && isFirstTime){
                   uiCalendarConfig.calendar.myCalendar.fullCalendar('gotoDate','2017-06-01' /*$scope.events[0].start*/);
                 }
             }
         }
     }
    }]
);
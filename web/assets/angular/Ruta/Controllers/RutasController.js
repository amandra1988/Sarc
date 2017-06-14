angular.module('admin-rutas')
.controller('RutasController',['$scope','$http','uiCalendarConfig','$uibModal','urlBasePartials',function ($scope,$http,uiCalendarConfig,$uibModal,urlBasePartials) {


    $scope.eventSources = [];
    $scope.SelectedEvent=null;
    var isFirstTime = true ;

    $scope.events = [];

    $scope.events = [
        {
            title: 'Recorrido Uno',
            start: '2017-06-05',
			end:   '2017-06-05'
        },
        {
            title: 'Recorrido Dos',
            start: '2017-06-07',
            end: '2017-06-07'
        },
        {
            title: 'Recorrido Tres',
            start: '2017-06-08',
			end: '2017-06-08'
        }];

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
             /*eventAfterRender: function(){
                 if($scope.events.length > 0 && isFirstTime){
                   uiCalendarConfig.calendar.myCalendar.fullCalendar('gotoDate',$scope.events[0].start);
                 }
             }*/
         }
     }
    }]
);
angular.module('admin-rutas')
.controller('RutasController',['$scope','$http','uiCalendarConfig','$uibModal','urlBasePartials','RutaFactory',function ($scope,$http,uiCalendarConfig,$uibModal,urlBasePartials,RutaFactory) {

    $scope.eventSources = [];
    $scope.SelectedEvent=null;
    var isFirstTime = true ;

    $scope.listaDeRutas= function (){
        RutaFactory.query({idEmpresa:2,'expand[]': [/*'r_ruta_operador','operador_detalle','r_ruta_camion','camion_detalle'*/]}, function(retorno) {
            $scope.events = retorno;
        });
    };
    $scope.listaDeRutas();


    /*
    $scope.events =[
       {
           "id": 1,
           "title": "Ruta 05/06/2017",
           "start": "2017-06-05T00:00:00+0200"
       },
       {
           "id": 2,
           "title": "Ruta 06/06/2016",
           "start": "2017-06-06T00:00:00+0200"
       },
       {
           "id": 3,
           "title": "Ruta 06/07/2016",
           "start": "2017-06-07T00:00:00+0200"
       }
    ];
    */

    $scope.eventSources = [$scope.events];

    $scope.uiConfig = {
         calendar: {
             height: 450,
             editable: true,
             displayEventTime:false,
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
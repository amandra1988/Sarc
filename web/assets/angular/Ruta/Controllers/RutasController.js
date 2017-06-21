angular.module('admin-rutas')
.controller('RutasController',['$scope','$http','uiCalendarConfig','$uibModal','urlBasePartials','RutaFactory','idEmpresa',function ($scope,$http,uiCalendarConfig,$uibModal,urlBasePartials,RutaFactory,idEmpresa) {

    $scope.eventSources = [];
    $scope.SelectedEvent=null;

    $scope.listaDeRutas= function (){
        RutaFactory.query({idEmpresa:idEmpresa,'expand[]': ['r_ruta_operador','operador_detalle','r_ruta_camion',
                                                    'camion_detalle','r_operador_usuario','r_usuario_empresa',
                                                    'r_empresa_centro_acopio','centro_detalle','r_ruta_detalle',
                                                    'rutaDet_detalle','r_ruta_cliente','cliente_detalle'
                                                   ]}, function(retorno) {
            angular.forEach(retorno, function(value,key){
                $scope.events.push( value );
            });
        });
    };

    $scope.events = [];
    $scope.evento = [];

    $scope.mostrarEvento = function(evento) {
        $scope.evento = evento;
        var modalInstance = $scope.modal();
        modalInstance.result.then(function()
        {
           //$scope.listaDeEmpresas();
        });
    };
    
    $scope.modal =  function(){
        var modalInstance= $uibModal.open({
            templateUrl: urlBasePartials+'modal_rutas.html',
            backdrop: 'static',
            size: 'lg',
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            controller: 'PopupModal',
            resolve: {
                evento: function() {
                    return $scope.evento;
                }
            }
        });
        return modalInstance;
     };
        
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
                $scope.mostrarEvento(event); 
             },
             eventAfterRender: function(){
                //$scope.eventSources =[];
                //$scope.eventSources = [$scope.events,$scope.listaDeRutas];
             }
         }
     };

     $scope.eventSources = [$scope.events,$scope.listaDeRutas];

    }]
)
.controller('PopupModal', ['$scope','$uibModalInstance','evento','$timeout', '$log', '$http', 'uiGmapLogger',function ($scope,$uibModalInstance,evento,$timeout,$log, $http,uiGmapLogger) {
    $scope.evento = evento;


    uiGmapLogger.doLog = true;

    angular.extend($scope, {
        example2: {
            doRebuildAll: false
        },
        clickWindow: function () {
            $log.info('CLICK CLICK');
            Logger.info('CLICK CLICK');
        },
        map: {
            control: {},
            //version: "uknown",
            center: {
                //latitude: -33.438166,longitude:  -70.64528
            },
            options: {
                streetViewControl: false,
                panControl: false,
                maxZoom: 20,
                minZoom: 3
            },
            zoom: 20,
            dragging: false,
            bounds: {},
            events: {
                tilesloaded: function (map, eventName, originalEventArgs) {
                }
            },
            polylines: [ ],
            markers2: [
                {
                    id: 1,
                    latitude: -33.438166,longitude:  -70.64528,
                    showWindow: false,
                    title: 'Marker 2'
                },
                {
                    id: 2,
                    latitude: -33.447243,longitude: -70.650034,
                    showWindow: false,
                    title: 'Marker 2'
                },
                {
                    id: 3,
                    icon: 'assets/images/plane.png',
                    latitude: -33.441107,longitude: -70.654256,
                    showWindow: false,
                    title: 'Plane'
                }
                ,
                {
                    id: 3,
                    icon: 'assets/images/plane.png',
                    latitude: -33.442868,longitude: -70.66005,
                    showWindow: false,
                    title: 'Plane'
                }
            ]
        },
        toggleColor: function (color) {
            return color == 'red' ? '#6060FB' : 'red';
        }

    });

    var markerToClose = null;

    $scope.onMarkerClicked = function (marker) {

        markerToClose = marker; // for next go around
        marker.showWindow = true;
        $scope.$apply();

    };

    $timeout(function () {
        $scope.map.polylines.push({
            id: 3,
            path: [
                {
                    latitude: -33.438166,longitude:  -70.64528
                },
                {
                    latitude: -33.447243,longitude: -70.650034
                },
                {
                    latitude: -33.441107,longitude: -70.654256
                },
                {
                    latitude: -33.442868,longitude: -70.66005
                }
            ],
            stroke: {
                color: '#6060FB',
                weight: 3
            },
            editable: false,
            draggable: true,
            geodesic: true,
            visible: true
        });
    }, 2000);





    $scope.close = function () {
        $uibModalInstance.dismiss();
    };
    
    $scope.ok = function(){
        $uibModalInstance.close();
    };
}
]);
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

.controller('PopupModal', ['$scope','$uibModalInstance','evento',function ($scope,$uibModalInstance,evento) {
    $scope.evento = evento;

    $scope.map = {
            center: {
                    latitude: 40.454018, 
                    longitude: -3.509205
            }, 
            zoom: 12,
            options : {
                    scrollwheel: false
            },
            control: {}
    };
    $scope.marker = {
            id: 0,
            coords: {
                    latitude: 40.454018,
                    longitude: -3.509205
            },
            options: {
                    draggable: true
            }
    };
    
    
    $scope.close = function () {
        $uibModalInstance.dismiss();
    };
    
    $scope.ok = function(){
        $uibModalInstance.close();
    };
}
]);
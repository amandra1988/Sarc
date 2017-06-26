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

.controller('PopupModal', ['$scope','$uibModalInstance','evento','uiGmapGoogleMapApi',function ($scope,$uibModalInstance,evento,uiGmapGoogleMapApi) {
    $scope.evento = evento;




angular.extend($scope, {
      map: {
        control: {},
        center: {
          latitude: 45,
          longitude: -74
        },
        marker: {
          id: 0,
          latitude: 45,
          longitude: -74,
          options: {
            visible: false
          }
        },
        marker2: {
          id: 0,
          latitude: 45.2,
          longitude: -74.5
        },
        zoom: 7,
        options: {
          draggable:true,
          disableDefaultUI: true,
          panControl: false,
          navigationControl: false,
          scrollwheel: false,
          scaleControl: false
        },
        refresh: function () {
          $scope.map.control.refresh(origCenter);
        }
      }


});





    // uiGmapGoogleMapApi is a promise.
    // The "then" callback function provides the google.maps object.
    uiGmapGoogleMapApi.then(function(maps) {
        console.log(maps);

    maps.visualRefresh = true;

});

var origCenter = {latitude: $scope.map.center.latitude, longitude: $scope.map.center.longitude};

    $scope.close = function () {
        $uibModalInstance.dismiss();
    };

    $scope.ok = function(){
        $uibModalInstance.close();
    };
}
]);
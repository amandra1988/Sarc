angular.module('admin-rutas')
.filter('estadoVisita', function() {
    return function(numero) {
    var estados = [ 'Por realizar','En proceso','Con problemas','Cancelada','Realizada' ]; 
            return estados[numero];
    };
})
.controller('RutasController',['$scope','$http','uiCalendarConfig','$uibModal','urlBasePartials','RutaFactory','idEmpresa',function ($scope,$http,uiCalendarConfig,$uibModal,urlBasePartials,RutaFactory,idEmpresa) {
    
    $scope.help =  function(modulo){
    $scope.modulo = modulo;
    var modalInstance= $uibModal.open({
            templateUrl: urlBasePartials+'../../help.html',
            backdrop: 'static',
            size: 'lg',
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            controller: 'Help',
            resolve: {
                modulo: function() {
                    return $scope.modulo;
                }
            }
        });
        return modalInstance;
    };

    $("#help").click( function(){
        $scope.help('Rutas');
    });

    $scope.eventSources = [];
    $scope.SelectedEvent=null;
    

    function getRandomSpan(){
        return Math.floor((Math.random()*6)+1);
    };


    /*var fecha = new Date();
    $scope.mes = fecha.getMonth();
    $scope.anio= fecha.getFullYear();*/
    $scope.colores =['#F2F51F','#70F51F','#F5AA1F','#1FEBF5','#1FC1F5','#F371EF','#829BF2','#ABEBC6'];
    $scope.operadores =[];
    $scope.listaDeRutas= function (){
        RutaFactory.query({idEmpresa:idEmpresa/*, mes:$scope.mes, anio:$scope.anio*/ ,'expand[]': 
                                                   ['r_ruta_operador','operador_detalle','r_ruta_camion',
                                                    'camion_detalle','r_operador_usuario','r_usuario_empresa',
                                                    'r_empresa_centro_acopio','centro_detalle','r_ruta_detalle',
                                                    'rutaDet_detalle','r_ruta_cliente','cliente_detalle'
                                                   ]}, 
        function(retorno){
            angular.forEach(retorno, function(value,key){

                if( $scope.operadores[value.ruta_operador.id_operador]){
                    var color = $scope.operadores[value.ruta_operador.id_operador];
                }else{

                    var numero = getRandomSpan();
                    var color  = $scope.colores[numero];
                    $scope.operadores[value.ruta_operador.id_operador] = color;
                }     
                value.color= color;
                value.textColor= 'black';
                $scope.events.push(value);
            });

            console.log($scope.operadores);
        });
    };

    $scope.events = [];
    $scope.evento = [];

    $scope.mostrarEvento = function(evento) {
        $scope.evento = evento;
        var modalInstance = $scope.modal();
        modalInstance.result.then(function()
        {
        }, function () {
        });
    };

    $scope.eventsF = function (start, end, timezone, callback) {
        var y = new Date(start).getFullYear();
        var s = new Date(start).getTime() / 1000;
        $scope.mes = s + 604800;
        $scope.anio= y;
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
             height: 500,
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
             }
        }
    };
    $scope.eventSources = [$scope.events,$scope.eventsF,$scope.listaDeRutas];
    }]
)

.controller('PopupModal', ['$scope','$uibModalInstance','evento','uiGmapGoogleMapApi',function ($scope,$uibModalInstance,evento,uiGmapGoogleMapApi) {
    
    $scope.evento = evento;

    var indice = 1;

    $scope.datacentro ={};
        $scope.datacentro ={
        id:$scope.evento.ruta_operador.usuario.empresa.centro_de_acopio.id_centro, 
        longitude: $scope.evento.ruta_operador.usuario.empresa.centro_de_acopio.longitud_centro,
        latitude:  $scope.evento.ruta_operador.usuario.empresa.centro_de_acopio.latitud_centro,
        indice:'',
        ruta_cliente: { 
            cliente_nombre:'Centro de Acopio',
            cliente_direccion: $scope.evento.ruta_operador.usuario.empresa.centro_de_acopio.nombre_centro, 
            comuna:{comuna_nombre:''}
        }
    };

    $scope.map={
                center:{
                    latitude:  $scope.datacentro.latitude, 
                    longitude: $scope.datacentro.longitude
                }, 
                zoom: 12,
                options: {
                    streetViewControl: true,
                    panControl: true,
                    maxZoom: 20,
                    minZoom: 1
                  }
            };
                
    $scope.polylines = [];

    $scope.coordenadas = [];

    $scope.coordenadas.push($scope.datacentro);

    angular.forEach($scope.evento, function(value,key){

        if(key == "ruta_detalle")
        {
            for(var x = 0 ; x < value.length; x++){
                value[x].indice = indice++;
                $scope.coordenadas.push(value[x]);
            }
        }
    });

    $scope.coordenadas.push($scope.datacentro);
    uiGmapGoogleMapApi.then(function(){
        $scope.randomMarkers = $scope.coordenadas;
        $scope.polylines = [
        {
            editable: false,
            draggable: false,
            geodesic: true,
            visible: true,
            path: $scope.coordenadas,
            stroke: {
                color: '#6060FB',
                weight: 2
            }  
        }];
    });

    $scope.onClick = function(marker, eventName, model) {
        model.show = !model.show;
    };
        
    uiGmapGoogleMapApi.then(function(maps) {
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
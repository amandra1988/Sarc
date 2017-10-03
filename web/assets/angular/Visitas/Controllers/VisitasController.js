angular.module('cliente-visitas')

.filter('estadoVisita', function() {
	return function(numero) {
        var estados = [ 'Por realizar','En proceso','Con problemas','Cancelada','Realizada' ]; 
		return estados[numero];
	}
})

.controller('VisitasController',['$scope','$http','uiCalendarConfig','$uibModal','urlBasePartials','VisitasFactory','idEmpresa','idCliente',function ($scope,$http,uiCalendarConfig,$uibModal,urlBasePartials,VisitasFactory,idEmpresa,idCliente) {

	$scope.eventSources = [];
	$scope.SelectedEvent=null;
	$scope.mes = 0;
	$scope.anio= 0;

	$scope.listaDeVisitas= function (){
	    VisitasFactory.query({idCliente:idCliente, mes:$scope.mes, anio:$scope.anio ,'expand[]': ['r_ruta_operador','operador_detalle','r_ruta_camion','camion_detalle','r_operador_usuario','r_usuario_empresa','r_empresa_centro_acopio','centro_detalle','r_ruta_detalle','rutaDet_detalle','r_ruta_cliente','cliente_detalle']}, function(retorno) {
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
	        templateUrl: urlBasePartials+'modal_visita.html',
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
	         },
	         eventAfterRender: function(){
	         }
	     }
	};
	 
	$scope.eventSources = [$scope.events,$scope.eventsF,$scope.listaDeVisitas];
	  
    }]
)
.controller('PopupModal', ['idCliente','CometarioVisitasFactory','$scope','$uibModalInstance','evento',function (idCliente,CometarioVisitasFactory,$scope,$uibModalInstance,evento) {
	
	$scope.evento = evento;

    CometarioVisitasFactory.query({idCliente:idCliente, idRuta:$scope.evento.id ,'expand[]': ['r_ruta_operador','operador_detalle','r_ruta_camion','camion_detalle','r_operador_usuario','r_usuario_empresa','r_empresa_centro_acopio','centro_detalle','r_ruta_detalle','rutaDet_detalle','r_ruta_cliente','cliente_detalle']}, function(retorno) {
		/*angular.forEach(retorno, function(value,key){
			$scope.events.push( value );
		});*/

		console.log(retorno);
	});



/*
	$scope.centro = evento.ruta_operador.usuario.empresa.centro_de_acopio.nombre_centro;
	$scope.estado = evento.ruta_detalle.estado;
	$scope.comentario = evento.ruta_detalle.comentario;
	console.log(evento);
	console.log($scope.centro);
	console.log($scope.estado);
	console.log($scope.comentario);

    $scope.close = function () {
        $uibModalInstance.dismiss();
    };

    $scope.ok = function(){
        $uibModalInstance.close();
    };*/
}
]);
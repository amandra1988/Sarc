var app = angular.module('admin-procesos');

app.filter('estadoproceso', function() {
	return function(numero) {
        var estados = ['En espera','En proceso','Error','Finalizado']; 
		return estados[numero];
	};
});

app.controller('ProcesoController',['$timeout','$scope','ProcesoFactory','$uibModal','urlBasePartials','idEmpresa','urlBaseImg',
function ($timeout,$scope,ProcesoFactory,$uibModal,urlBasePartials,idEmpresa,urlBaseImg) {
    
        $scope.valida=[];
        $scope.valida[0] = urlBaseImg+"validar.png";
        $scope.valida[1] = urlBaseImg+"invalidar.png";
        $scope.valida[2] = urlBaseImg+"espera.png";
        $scope.valida[3] = urlBaseImg+"finalizar.png";
        $scope.mensaje ='';
        $scope.class='success';
        
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
            $scope.help('Procesos');
        });
        
        $scope.procesos =[];
        $scope.listaDeProcesos= function (){
            ProcesoFactory.query({ idEmpresa: idEmpresa , 'expand[]': []}, function(retorno) {
                $scope.procesos = retorno;
            });   
        };
        $scope.listaDeProcesos();

        $scope.validacion = function(proceso,valido){
            var v = new ProcesoFactory();
            v.validar = valido;
            v.idproceso = proceso;
            v.$patch({idEmpresa:idEmpresa }, function(response) {
                $scope.listaDeProcesos();
            });
        };

        $scope.crearProceso = function(){
            var v = new ProcesoFactory();
            v.accion = 1;
            v.$save({idEmpresa:idEmpresa}, function(response) {
                
                console.log(response.mensaje);
                
                
                if(response.mensaje){
                    $scope.class='success';
                    $scope.mensaje = response.mensaje;
                    $scope.listaDeProcesos();
                    $timeout(function() {
                        $scope.mensaje="";
                    },2000);
                }
            });
        };
       
        $scope.ejecutarProceso = function(){
            
           var v = new ProcesoFactory();
           v.accion = 2;
           v.$save({idEmpresa:idEmpresa}, function(response) {
               if(response.mensaje){
                   $scope.class='info';
                   $scope.mensaje = response.mensaje;
                   $timeout(function() {
                       $scope.listaDeProcesos();
                       $scope.mensaje="";
                   },2000);
               }
           });
        };        
    }]
);
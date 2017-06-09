angular.module('superadmin-centro-de-acopio')
.controller('CentroController',['$scope','CentroFactory','$uibModal','urlBasePartials','ComunaFactory',function ($scope,CentroFactory, $uibModal,urlBasePartials,ComunaFactory) {
        
        $scope.centros =[];

        $scope.listaDeCentros= function (){
            CentroFactory.query({'expand[]': ['comuna_detalle','provincia_detalle','region_detalle']}, function(retorno) {
                $scope.centros = retorno;   
            });   
        };
        
        $scope.listaDeCentros();
        
        $scope.comunas =[];

        $scope.listaDeComunas= function (){
            ComunaFactory.query({'expand[]': ['comuna_detalle','provincia_detalle','region_detalle']}, function(retorno) {
                $scope.comunas = retorno;  
            });   
        };
            
        $scope.listaDeComunas();

        $scope.nuevoCentro = function() {
            $scope.accion = 1;
            $scope.centro = [];
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeCentros();
            });
        };
       
        $scope.editarCentro = function(id) {
            $scope.centro =[];
            $scope.accion = 2;
            for(var i=0,len=$scope.centros.length; i<len;i++)
            {
                if($scope.centros[i].id_centro === id) {
                    $scope.centro.id  =$scope.centros[i].id_centro ;
                    $scope.centro.nombre =$scope.centros[i].nombre_centro ;
                    $scope.centro.direccion =$scope.centros[i].direccion_centro ;
                    $scope.centro.numero =$scope.centros[i].numero_centro;
                    $scope.centro.comuna =$scope.centros[i].comuna.comuna_id;
                    break;
                }
            }
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeCentros();
            });
        };
        
        $scope.eliminarCentro =  function(id){
            $scope.accion = 0; 
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
                var c = new CentroFactory();
                c.visible = 0;
                c.$patch({idCentro:id}, function(response) {
                    $scope.listaDeCentros();
                });
            }); 
        };
        
        $scope.modal =  function(){
             var modalInstance= $uibModal.open({
                templateUrl: urlBasePartials+'modal_centros.html',
                backdrop: 'static',
                size: 'lg',
                animation: true,
                ariaLabelledBy: 'modal-title',
                ariaDescribedBy: 'modal-body',
                controller: 'PopupModal',
                resolve: {
                    accion: function() {
                        return $scope.accion;
                    },
                    comunas: function() {
                        return $scope.comunas;
                    },
                    centro: function(){
                        return $scope.centro;
                    }
                }
            });
            return modalInstance;
        };
    }]
)

.controller('PopupModal', ['$scope','$uibModalInstance','accion','CentroFactory','comunas','centro', function ($scope,$uibModalInstance,accion,CentroFactory,comunas,centro) {
 
    $scope.accion  = accion;
    $scope.mensaje = '';
    $scope.error   = '';
    $scope.confirm = '';
    $scope.comunas = comunas;
    $scope.centro  = centro;
    
    if($scope.accion === 1){
        $scope.mensaje = 'Nuevo' ;
    }
  
    if($scope.accion === 2){
        $scope.mensaje = 'Editar' ;
    }
  
    if($scope.accion === 0){
        $scope.mensaje ='Eliminar';
    }
    
    $scope.guardar= function(){
        var c = new CentroFactory();
        c.nombre    = $scope.centro.nombre;
        c.direccion = $scope.centro.direccion;
        c.numero    = $scope.centro.numero;
        c.comuna    = $scope.centro.comuna.comuna_id;
        c.visible = 1;
        if(accion === 1)
        {
            c.$save({}, function(response) {
               $uibModalInstance.close();
            });  
        }else{ // Editar
            c.$patch({idCentro: $scope.centro.id}, function(response) {
                $uibModalInstance.close();
            });
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
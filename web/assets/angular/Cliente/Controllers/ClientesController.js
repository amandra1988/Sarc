angular.module('admin-clientes')
.controller('ClientesController',['$scope','ClienteFactory','$uibModal','urlBasePartials',function ($scope,ClienteFactory,$uibModal,urlBasePartials) {
        
        $scope.clientes =[];

        $scope.listaDeClientes= function (){
            ClienteFactory.query({ idEmpresa: 2 , 'expand[]': []}, function(retorno) {
                $scope.clientes = retorno;   
            });   
        };
        
        $scope.listaDeClientes= function (){
            ClienteFactory.query({ idEmpresa: 2 , 'expand[]': []}, function(retorno) {
                $scope.clientes = retorno;   
            });   
        };
        
        $scope.listaDeClientes();

        $scope.accion = 1;
       
        $scope.nuevoCliente = function() {
            $scope.accion =1;
            $scope.camion =[];
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeClientes();
            });
        };
        
        /*$scope.editarCamion = function(id) {
           
            $scope.accion = 2;
            $scope.camion =[];
            
            for(var i=0,len=$scope.camiones.length; i<len;i++)
            {
                if($scope.camiones[i].id_camion === id) {
                    $scope.camion.id =$scope.camiones[i].id_camion ;
                    $scope.camion.patente =$scope.camiones[i].patente_camion ;
                    $scope.camion.capacidad =$scope.camiones[i].capacidad_camion ;
                    $scope.camion.tipo_carga =$scope.camiones[i].tipo_carga_camion ;
                    break;
                }
            }
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeCamiones();
            });
        };
        
        $scope.eliminarCamion =  function(id){
            $scope.accion = 0; 
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
                var c = new CamionFactory();
                c.visible = 0;
                c.$patch({idEmpresa:2,idCamion:id}, function(response) {
                    $scope.listaDeCamiones();
                });
            }); 
        };*/
        
        $scope.modal =  function(){
             var modalInstance= $uibModal.open({
                templateUrl: urlBasePartials+'modal_clientes.html',
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
                    cliente: function() {
                        return $scope.cliente;
                    }
                }
            });
            return modalInstance;
        };
    }]
)

.controller('PopupModal', ['$scope','$uibModalInstance','accion','ClienteFactory','ComunaFactory','FrecuenciaFactory','cliente', function ($scope,$uibModalInstance,accion,ClienteFactory,ComunaFactory,FrecuenciaFactory,cliente) {
    $scope.accion  = accion;
    $scope.cliente = cliente;
    $scope.error = '';
    $scope.confirm = '';
    $scope.mensaje = '';
    
    if($scope.accion === 1){
        $scope.mensaje = 'Nuevo' ;
    }
    
   /* if($scope.accion === 2){
        $scope.mensaje = 'Editar' ;
        $scope.cam.id = $scope.camion.id;
        $scope.cam.patente = $scope.camion.patente;
        $scope.cam.capacidad = $scope.camion.capacidad;
        $scope.cam.tipo_carga = $scope.camion.tipo_carga;
    }*/
    
    if($scope.accion === 0){
        $scope.mensaje ='Eliminar';
    }
    
    $scope.frecuencias =[];
    $scope.listaDeFrecuencias= function (){
        FrecuenciaFactory.query({'expand[]': []}, function(retorno) {
            $scope.frecuencias = retorno;   
        });   
    };
    
    $scope.comunas =[];
    $scope.listaDeComunas= function (){
        ComunaFactory.query({'expand[]': []}, function(retorno) {
            $scope.comunas = retorno;   
        });   
    };
    
    $scope.listaDeComunas();
    
    $scope.guardar= function(){
        var c = new ClienteFactory();
        c.patente    = $scope.cam.patente;
        c.capacidad  = $scope.cam.capacidad;
        c.tipo_carga = $scope.cam.tipo_carga;
        c.visible    = true;
        if(accion === 1)
        {
            c.$save({idEmpresa: 2}, function(response) {
               $uibModalInstance.close();
            });
        }else{ // Editar
            c.$patch({idEmpresa:2, idCliente:$scope.cli.id }, function(response) {
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
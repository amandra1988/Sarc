angular.module('admin-operadores')
.controller('OperadoresController',['$scope','OperadorFactory','$uibModal','urlBasePartials',function ($scope,OperadorFactory,$uibModal,urlBasePartials) {
        
        $scope.camiones =[];

        $scope.listaDeOperadores= function (){
            OperadorFactory.query({ idEmpresa: 2 , 'expand[]': []}, function(retorno) {
                $scope.operadores = retorno;   
            });   
        };
        
        $scope.listaDeOperadores();

        /*$scope.accion = 1;
       
        $scope.nuevoCamion = function() {
            $scope.accion =1;
            $scope.camion =[];
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeCamiones();
            });
        };
        
        $scope.editarCamion = function(id) {
           
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
        };
        
        $scope.modal =  function(){
             var modalInstance= $uibModal.open({
                templateUrl: urlBasePartials+'modal_camiones.html',
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
                    camion: function() {
                        return $scope.camion;
                    }
                }
            });
            return modalInstance;
        };*/
    }]
)
/*
.controller('PopupModal', ['$scope','$uibModalInstance','accion','CamionFactory','camion', function ($scope,$uibModalInstance,accion,CamionFactory,camion) {

    $scope.mensaje = '';
    $scope.accion = accion;
    $scope.camion = camion;
    $scope.error = '';
    $scope.confirm = '';
    $scope.cam = {tipo_carga:1};
    
    console.log($scope.camion);
    if($scope.accion === 1){
        $scope.mensaje = 'Nueva' ;
    }
    
    if($scope.accion === 2){
        $scope.mensaje = 'Editar' ;
        $scope.cam.id = $scope.camion.id;
        $scope.cam.patente = $scope.camion.patente;
        $scope.cam.capacidad = $scope.camion.capacidad;
        $scope.cam.tipo_carga = $scope.camion.tipo_carga;
    }
    
    if($scope.accion === 0){
        $scope.mensaje ='Eliminar';
    }
    
    $scope.guardar= function(){
        var c = new CamionFactory();
        c.patente    = $scope.cam.patente;
        c.capacidad  = $scope.cam.capacidad;
        c.tipo_carga = $scope.cam.tipo_carga;
        c.estado     = 1;
        c.visible    = 1;
        if(accion === 1)
        {
            c.$save({idEmpresa: 2}, function(response) {
               $uibModalInstance.close();
            });
        }else{ // Editar
            c.$patch({idEmpresa:2, idCamion:$scope.cam.id }, function(response) {
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

]) */
;
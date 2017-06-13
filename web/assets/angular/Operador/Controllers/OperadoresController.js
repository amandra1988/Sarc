var app = angular.module('admin-operadores')
app.controller('OperadoresController',['$scope','OperadorFactory','$uibModal','urlBasePartials',function ($scope,OperadorFactory,$uibModal,urlBasePartials) {
        
        $scope.operadores =[];

        $scope.listaDeOperadores= function (){
            OperadorFactory.query({ idEmpresa: 2 , 'expand[]': ['usuario_detalle']}, function(retorno) {
                $scope.operadores = retorno;   
            });   
        };
        
        $scope.listaDeOperadores();

        $scope.accion = 1;
       
        $scope.nuevoOperador = function() {
            $scope.accion =1;
            $scope.camion =[];
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeOperadores();
            });
        };
        
        /*
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
        };*/
        
        $scope.eliminarOperador =  function(id){
            $scope.accion = 0; 
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
                var o = new OperadorFactory();
                o.visible = false;
                o.$patch({idEmpresa:2,idOperador:id}, function(response) {
                    $scope.listaDeOperadores();
                });
            }); 
        };
        
        $scope.modal =  function(){
             var modalInstance= $uibModal.open({
                templateUrl: urlBasePartials+'modal_operadores.html',
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
                    operador: function() {
                        return $scope.operador;
                    }
                }
            });
            return modalInstance;
        };
    }]
)

.controller('PopupModal', ['$scope','$uibModalInstance','accion','OperadorFactory','operador','validarRut', function ($scope,$uibModalInstance,accion,OperadorFactory,operador,validarRut) {

    $scope.mensaje = '';
    $scope.error   = '';
    $scope.confirm = '';
    $scope.accion   = accion;
    $scope.operador = operador;
    $scope.ope = {};

    if($scope.accion === 1){
        $scope.mensaje = 'Nuevo' ;
    }
    
    /*if($scope.accion === 2){
        $scope.mensaje = 'Editar' ;
        $scope.cam.id = $scope.camion.id;
        $scope.cam.patente = $scope.camion.patente;
        $scope.cam.capacidad = $scope.camion.capacidad;
        $scope.cam.tipo_carga = $scope.camion.tipo_carga;
    }
    
    if($scope.accion === 0){
        $scope.mensaje ='Eliminar';
    }
    */
    $scope.guardar= function(){
        
        if(!$scope.ope.nombre){
            $scope.error = 'Ingrese nombre del operador';
            return;  
        }
        if(!$scope.ope.apellido){
            $scope.error = 'Ingrese apellido del operador.';
            return; 
        }
        if(!validarRut($scope.ope.rut)){
            $scope.error = 'El RUT no es válido.';
            $scope.ope.rut = '';
            return;
        }
        if(!$scope.ope.licencia){
            $scope.error = 'Ingrese n° de licencia del operador.';
            return;   
        }
        
        if($scope.ope.celular > 999999999)
        {
            $scope.error = 'El campo celular deben tener máximo 9 dígitos.';
            return;
        }

        var o = new OperadorFactory();
        o.nombre = $scope.ope.nombre;
        o.apellido = $scope.ope.apellido;
        o.rut = $scope.ope.rut;
        o.licencia = $scope.ope.licencia;
        o.correo = $scope.ope.correo;
        o.visible = true;
        if(accion === 1)
        {
            o.$save({idEmpresa: 2}, function(response) {
               $uibModalInstance.close();
            });
        }else{ // Editar
            o.$patch({idEmpresa:2, idOperador:$scope.ope.id }, function(response) {
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
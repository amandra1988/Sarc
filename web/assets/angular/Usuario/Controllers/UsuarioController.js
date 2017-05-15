angular.module('superadmin-usuarios')
.controller('UsuarioController',['$scope','UsuarioFactory','EmpresaFactory','$uibModal','urlBasePartials',function ($scope,UsuarioFactory,EmpresaFactory,$uibModal,urlBasePartials) {
       
        $scope.empresas =[];
        $scope.listaUsuarios =[];
        $scope.iduser = '';

        EmpresaFactory.query({'expand[]': []}, function(retorno) {
           $scope.empresas = retorno;
        });   
        
        $scope.listaDeUsuarios = function() {
            UsuarioFactory.query({'expand[]': []}, function(retorno) {
                $scope.usuarios = retorno;
            });
        };
        
        $scope.listaDeUsuarios();
        
        $scope.eliminarUsuario =  function(id){
            $scope.accion = 0; 
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
                var u = new UsuarioFactory();
                u.visible = 0;
                u.$patch({idUsuario:id}, function(response) {
                    $scope.listaDeUsuarios();
                });
            }); 
        };
        
         $scope.cambiarClave = function(id) {
            $scope.iduser = id;
            $scope.accion  = 2;
            $scope.modal();
        };
    
        $scope.nuevoUsuario = function() {
            $scope.accion = 1;
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeUsuarios();
            });
        };
        
        $scope.modal =  function(){
             var modalInstance= $uibModal.open({
                templateUrl: urlBasePartials+'modal_usuarios.html',
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
                    empresas: function() {
                        return $scope.empresas;
                    },
                    iduser: function() {
                        return $scope.iduser;
                    }
                    
                    
                }
            });
            return modalInstance;
        };
        
    }]
)

.controller('PopupModal', ['$scope','$uibModalInstance','accion','UsuarioFactory','empresas','iduser',function ($scope,$uibModalInstance,accion,UsuarioFactory,empresas,iduser) {
    $scope.accion = accion;
    $scope.empresas=empresas;
    $scope.user={};
    $scope.error = '';
    $scope.confirm = '';
    $scope.iduser= iduser;
    
    
    if($scope.accion === 0){
        $scope.mensaje ='Eliminar';
    }
    
    if($scope.accion === 1){
        $scope.mensaje ='Nuevo';
    }
    
    if($scope.accion === 2){
        $scope.mensaje ='Cambiar password ';
    }
    
    
    $scope.cambiarPass= function(){
        
        $scope.error = '';
        $scope.confirm = '';
    
        if($scope.user.newpass !== $scope.user.confirpass )
        {
            $scope.error = "Las claves ingresadas no coinciden";
            return;
        }
       
        var u = new UsuarioFactory();
        u.visible= 1;
        u.password = $scope.user.newpass;
        u.$patch({idUsuario:$scope.iduser}, function(response) {
            $scope.confirm = 'La clave fue actualizada con éxito';
        });
    };
    
    $scope.guardar= function(){
        var u = new UsuarioFactory();
        u.idempresa= $scope.user.miempresa.id_empresa;
        u.username = $scope.user.username;
        u.password = $scope.user.password;
        u.$save({}, function(response) {
            if(response.data.message){
                $scope.error = response.data.message;
            }else{
                $uibModalInstance.close();
            }
        });
    };
    
    $scope.close = function () {
        $uibModalInstance.dismiss();
    };
    
    $scope.ok = function(){
        $uibModalInstance.close();
    };
}
]);
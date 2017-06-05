angular.module('admin-rutas')
.controller('RutasController',['$scope','RutaFactory','$uibModal','urlBasePartials',function ($scope,RutaFactory,$uibModal,urlBasePartials) {
        
       /* $scope.empresas =[];

        $scope.listaDeEmpresas= function (){
            EmpresaFactory.query({'expand[]': []}, function(retorno) {
                $scope.empresas = retorno;   
            });   
        };
        
        $scope.listaDeEmpresas();
        
        $scope.listaDeCentros= function (){
            CentroFactory.query({'expand[]': []}, function(retorno) {
                $scope.centros = retorno;
            });   
        };
        
        $scope.listaDeCentros();

        $scope.accion = 1;
       
        $scope.nuevaEmpresa = function() {
            $scope.accion  = 1;
            $scope.empresa =[];
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeEmpresas();
            });
        };
        
        $scope.editarEmpresa = function(id) {
            $scope.accion = 2;
            $scope.empresa =[];           
            for(var i=0, len=$scope.empresas.length; i<len;i++)
            {
                if($scope.empresas[i].id_empresa === id) {
                    $scope.empresa.id =$scope.empresas[i].id_empresa ;
                    $scope.empresa.cen =$scope.empresas[i].centro_de_acopio.id_centro ;
                    $scope.empresa.nom =$scope.empresas[i].nombre_empresa ;
                    $scope.empresa.rut =$scope.empresas[i].rut_empresa ;
                    $scope.empresa.dir =$scope.empresas[i].direccion_empresa;
                    $scope.empresa.cel =$scope.empresas[i].celular_empresa;
                    $scope.empresa.tel =$scope.empresas[i].telefono_empresa;
                    break;
                }
            }
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
               $scope.listaDeEmpresas();
            });
        };
        
        $scope.eliminarEmpresa =  function(id){
            $scope.accion = 0; 
            var modalInstance = $scope.modal();
            modalInstance.result.then(function()
            {
                var e = new EmpresaFactory();
                e.visible = 0;
                e.$patch({idEmpresa:id}, function(response) {
                    $scope.listaDeEmpresas();
                });
            }); 
        };
        
        $scope.modal =  function(){
             var modalInstance= $uibModal.open({
                templateUrl: urlBasePartials+'modal_empresas.html',
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
                    empresa: function() {
                        return $scope.empresa;
                    },
                    centros:function(){
                        return $scope.centros;
                    }
                }
            });
            return modalInstance;
        };*/
    }]
)
/*
.controller('PopupModal', ['$scope','$uibModalInstance','accion','EmpresaFactory','empresa','centros', function ($scope,$uibModalInstance,accion,EmpresaFactory,empresa,centros) {
    
    $scope.emp = {};
    $scope.mensaje ='';
    $scope.accion = accion;
    $scope.centros = centros;
    if($scope.accion === 1){
        $scope.mensaje = 'Nueva' ;
    } 
    if($scope.accion === 2){
        $scope.mensaje = 'Editar' ;
        $scope.emp.centro = empresa.cen;
        $scope.emp.id = empresa.id;
        $scope.emp.nombre = empresa.nom;
        $scope.emp.rut = empresa.rut;
        $scope.emp.direccion = empresa.dir;
        $scope.emp.telefono = empresa.tel;
        $scope.emp.celular = empresa.cel;
    }
    if($scope.accion === 0){
        $scope.mensaje ='Eliminar';
    }
    $scope.guardar= function(){
        var e = new EmpresaFactory();
        e.nombre = $scope.emp.nombre;
        e.centro = $scope.emp.centro.id_centro;
        e.rut = $scope.emp.rut;
        e.direccion = $scope.emp.direccion;
        e.telefono = $scope.emp.telefono;
        e.celular = $scope.emp.celular;
        e.visible = 1;
        if(accion === 1)
        {
            e.$save({}, function(response) {
               $uibModalInstance.close();
            });
        }else{ // Editar
            e.$patch({idEmpresa: $scope.emp.id}, function(response) {
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
*/
]);
angular.module('admin-rutas')
.controller('RutasController',['$scope','RutaFactory','$uibModal','urlBasePartials',function ($scope,RutaFactory,$uibModal,urlBasePartials) {
        
        $scope.rutas =[];

        $scope.listaDeRutas= function (){
            RutaFactory.query({idEmpresa: 2 ,'expand[]': []}, function(retorno) {
                $scope.rutas = retorno;   
            });   
        };
        
        $scope.listaDeRutas();
		
        /*$scope.listaDeCentros= function (){
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
        };*/
        
		$scope.verMapa = function(){
			var modalInstance = $scope.modal();	
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
                    /*accion: function() {
                        return $scope.accion;
                    },
                    empresa: function() {
                        return $scope.empresa;
                    },
                    centros:function(){
                        return $scope.centros;
                    }*/
                }
            });
            return modalInstance;
        };
    }]
)

.controller('PopupModal', ['$scope','$uibModalInstance',function ($scope,$uibModalInstance) {
    
    $scope.close = function () {
        $uibModalInstance.dismiss();
    };
    
    $scope.ok = function(){
        $uibModalInstance.close();
    };
}

]);
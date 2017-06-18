var app = angular.module('admin-procesos');
app.controller('ProcesoController',['$scope','ProcesoFactory','$uibModal','urlBasePartials',function ($scope,ProcesoFactory,$uibModal,urlBasePartials) {
        
        $scope.procesos =[];
        $scope.listaDeProcesos= function (){
            ProcesoFactory.query({ idEmpresa: 2 , 'expand[]': []}, function(retorno) {
                $scope.procesos = retorno;
                console.log( $scope.procesos );
            });   
        };
        $scope.listaDeProcesos();
    }]
);
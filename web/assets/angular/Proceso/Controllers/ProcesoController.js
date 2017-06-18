var app = angular.module('admin-procesos');
app.controller('ProcesoController',['$scope','ProcesoFactory','$uibModal','urlBasePartials','idEmpresa',function ($scope,ProcesoFactory,$uibModal,urlBasePartials,idEmpresa) {
        
        $scope.procesos =[];
        $scope.listaDeProcesos= function (){
            ProcesoFactory.query({ idEmpresa: idEmpresa , 'expand[]': []}, function(retorno) {
                $scope.procesos = retorno;
                console.log( $scope.procesos );
            });   
        };
        $scope.listaDeProcesos();
    }]
);
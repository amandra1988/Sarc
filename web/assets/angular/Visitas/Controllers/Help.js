angular.module('cliente-visitas')

.controller('Help', function(modulo,$uibModalInstance,$scope) {
    $scope.modulo = modulo;
    $scope.close = function () {
        $uibModalInstance.dismiss();
    };
    $scope.ok = function(){
        $uibModalInstance.close();
    };
});
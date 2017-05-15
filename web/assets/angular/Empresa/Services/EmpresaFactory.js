angular.module('superadmin-empresas')

.factory('EmpresaFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'empresas/:idEmpresa',
            {},
            {'query': {method: 'GET', isArray:true },'patch': {method:'PATCH'}}
         );
    }
]);
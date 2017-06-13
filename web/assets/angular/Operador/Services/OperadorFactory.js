angular.module('admin-operadores')

.factory('OperadorFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'empresas/:idEmpresa/operadores/:idOperador',
            {},
            {'query': {method: 'GET', isArray:false },'patch': {method:'PATCH'}}
         );
    }
]);
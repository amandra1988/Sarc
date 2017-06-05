angular.module('admin-clientes')

.factory('ClienteFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'empresas/:idEmpresa/clientes/:idCliente',
            {},
            {'query': {method: 'GET', isArray:false },'patch': {method:'PATCH'}}
         );
    }
]);
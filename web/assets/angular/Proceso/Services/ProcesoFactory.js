angular.module('admin-procesos')

.factory('ProcesoFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'empresas/:idEmpresa/procesos/:idProceso',
            {},
            {'query': {method: 'GET', isArray:true },'patch': {method:'PATCH'}}
         );
    }
]);

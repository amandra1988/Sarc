angular.module('admin-camiones')

.factory('CamionFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'empresas/:idEmpresa/camiones/:idCamion',
            {},
            {'query': {method: 'GET', isArray:false },'patch': {method:'PATCH'}}
         );
    }
]);
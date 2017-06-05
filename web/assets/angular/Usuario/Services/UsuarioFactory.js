angular.module('superadmin-usuarios')

.factory('UsuarioFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'usuarios/:idUsuario',
            {},
            {'query': {method: 'GET', isArray:false },'patch': {method:'PATCH'}}
         );
    }
])

.factory('EmpresaFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
        return $resource(
            urlBaseApi + 'empresas/',
            {},
            {'query': {method: 'GET', isArray:true }}
         );
    }
]);

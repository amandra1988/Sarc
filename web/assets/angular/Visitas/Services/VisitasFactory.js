angular.module('cliente-visitas')

	.factory('VisitasFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
		        return $resource(
		            urlBaseApi + 'visitasclientes/:idCliente',
		            {},
		            {'query': {method: 'GET', isArray:true },'patch': {method:'PATCH'}}
		);
	}
	])

	.factory('CometarioVisitasFactory', ['$resource', 'urlBaseApi', function ($resource ,  urlBaseApi ) {
		return $resource(
			urlBaseApi + 'visitas/:idCliente/ruta/:idRuta',
			{},
			{'query': {method: 'GET', isArray:true },'patch': {method:'PATCH'}}
		);
	}
]);
<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/20/2017
 * Time: 1:03 PM
 */

require_once './vendor/autoload.php';

use GraphQL\GraphQL;
use \GraphQL\Schema;
use graphql_base\Data\DataSource;
use graphql_base\QueryType;
use graphql_base\Types;


if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
	$rawBody = file_get_contents('php://input');
	$data = json_decode($rawBody ?: '', true);
} else {
	$data = $_POST;
}

$requestString = isset($data['query']) ? $data['query'] : null;
$operationName = isset($data['operation']) ? $data['operation'] : null;
$variableValues = isset($data['variables']) ? $data['variables'] : null;
try {
	DataSource::init();
	$schema = new Schema([
		'query' => new QueryType(),
		'types' => [
			Types::user(),
			Types::userStatus()
		]
	]);
	$result = GraphQL::execute(
		$schema,
		$requestString,
		/* $rootValue */ null,
		/* $context */ null, // A custom context that can be used to pass current User object etc to all resolvers.
		$variableValues,
		$operationName
	);
} catch (Exception $exception) {
	$result = [
		'errors' => [
			['message' => $exception->getMessage()]
		]
	];
}

header('Content-Type: application/json');
echo json_encode($result);
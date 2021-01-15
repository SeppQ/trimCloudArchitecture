<!DOCTYPE html>
<html>
	<head>
		<title>ALL</title>
		
		<meta charset="UTF-8">
			<link href="styles/visit.css" rel="stylesheet" type="text/css" />
			<link href="styles/history.css" rel="stylesheet" type="text/css" />
			<link href="images/icon1.png" rel="shortcut icon" type="image/x-icon" />	
			<link href="styles/common.css" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
		<main>
		
		<br />
		
		<?php
		
			require 'aws/aws-autoloader.php';
			use Aws\DynamoDb\DynamoDbClient;
			use Aws\DynamoDb\Exception\DynamoDbException;
			use Aws\DynamoDb\Marshaler;
			#use Aws\Iam\IamClient;
			
			#$client = new IamClient([
			#	'region' => 'us-east-1',
			#	'version' => 'latest'
			#]);
			$client = DynamoDbClient::factory(array(
				'profile' => 'default',
				'region' => 'us-east-1',
				'version' => 'latest'
				));
			
			#$result = $client->createRole([
			#	'AssumeRolePolicyDocument' => 'rolesForDynamo.json', // REQUIRED
			#	'RoleName' => 'DynamoDbRoles', // REQUIRED
			#]);
			#$client = DynamoDbClient::factory(array(
			#'profile' => 'C:\Users\arche\.aws\credentials',
			#'region'  => 'us-east-1',
			#'version' => 'latest'
			#));
			
			$sdk = new Aws\Sdk([
				#'endpoint'   => 'http://localhost:8000',
				'region'   => 'us-east-1',
				'version'  => 'latest'
			]);
			
			
			$dynamodb = $sdk->createDynamoDb();
			$marshaler = new Marshaler();

			$tableName = 'Trim';
			$theName=$_POST["name"];
			$theSurName=$_POST["surname"];
			$theAddress=$_POST["adress"];
			$theMobileNumber=$_POST["mobile"];
			$theEmailAddress=$_POST["email"];
			$theCounty=$_POST["county"];	
			$item = $marshaler->marshalJson('
			{
				"firstName": "'.$theName.'"  ,
				"surName": "'.$theSurName.'" ,
				"address": "'.$theAddress.'" ,
				"mobileNumber": "'.$theMobileNumber.'",
				"emailAddress": "'.$theEmailAddress.'" ,
				"county": "'.$theCounty.'"
			}
			');

			$params = [
				'TableName' => $tableName,
				'Item' => $item
			];

			try {
				$result = $dynamodb->putItem($params);
				echo "Added to Raffle ";
				header('Location: visitcastle.php');
			} catch (DynamoDbException $e) {
				echo "Unable to add item:\n";
				echo $e->getMessage() . "\n";
			}
			
			?>



		</main>
		<br />
	</body>

				
</html>				
				
					
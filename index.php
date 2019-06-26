<?php
mb_internal_encoding('utf-8');
include_once  'functions.php';
include_once   'header.php';
include   'config.php';


$errors=[];

switch(getenv('REQUEST_METHOD'))
{
	case 'GET':
		if(isset($_GET['success']))
		{
			include 'templates/answer.php';	//форма отправлена
			exit;
		}
		include 'templates/request.php' ;
		break;
	
	
	case 'POST' :
		if(!empty($_POST))
		{
			$fields=[
				'name' => trim(array_get(get_post(),'name', '')),
				'lastname'=> trim(array_get(get_post(),'lastname', '')),
				'age'=> trim(array_get(get_post(),'age', '')),
				'city'=>trim(array_get(get_post(),'city', '')),
				'phone'=> trim(array_get(get_post(),'phone', '')),
				'email'=> trim(array_get(get_post(),'email', '')),
				'tema'=> trim(array_get(get_post(),'tema', '')),
				'pay'=> trim(array_get(get_post(),'pay', '')),
				'agree'=> trim(array_get(get_post(),'agree', '')),
				
			];
			
			$filename ='/formdata.json';	//даем уникальное имя файлам ,в которые будем сохранять
			
			
			$errors=check_error($fields);	//проверки введенных данных
			if($errors)//проверки окончены ,смотрим есть ли ошибки
			{		
					echo '<div class="errors">'.'ФОРМА НЕ ОТПРАВЛЕНА. ИСПРАВЬТЕ ОШИБКИ! </div>';
					include 'templates/request.php';
			}
			else
			{
				//массив заполненных данных
				$contents = json_encode([$fields['name']."|".$fields['lastname']."|".$fields['age']."|".$fields['city']."|".
										$fields['phone']."|".$fields['email']."|".$fields['tema']."|".
										$fields['pay']."|".$fields['agree']."|".date('Y-m-d-H-i-s')."|".$_SERVER['REMOTE_ADDR']."|"."n"."\n"]);

				
				save_json($config['data_dir'] . $filename, $contents);
				include 'templates/answer.php';	//форма отправлена
				exit;
				
			}
		}
}



?>

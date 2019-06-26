<?php 

include_once  'functions.php';
include  'config.php';

mb_internal_encoding('utf-8');

$fields=[];
$errors=[];

switch(getenv('REQUEST_METHOD'))
{
	case 'GET':
		if(!empty($_GET['id']))
		{
			$id=str_replaсe(['..','/'],$_GET['id']);
			$filename=$config['data_dir'] . '/formdata.json';	//файл со всеми данными регистраций
			$json=$config['data_dir'] . '/formdata.json';	
			$file=file_get_contents($config['data_dir'] .'/formdata.json');
			$fields=json_decode($file,true);
			$_POST=$data;
			include '/templates/admin-edit.php';
		}
		else
		{
			$data=[];
				$id='data/formdata.json';	 //Возвращает имя файла из указанного пути
				$data[$id]=json_decode(file_get_contents('data/formdata.json'),true);
			include '/templates/admin-edit.php';
		}
		break;
	
	case 'POST' :
	if (!empty($_POST))
	{
		$name = isset($_POST['name']) ? trim($_POST['name']) : null;
		$lastname = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
		$email = isset($_POST['email']) ? trim($_POST['email']) : null;
		$phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
		$topic = isset($_POST['tema']) ? trim($_POST['tema']) : null;
		$pay = isset($_POST['pay']) ? trim($_POST['pay']) : null;
		foreach (['name', 'lastname', 'email', 'phone', 'tema','pay'] as $key) 
		{
			if(empty($$key))
			{
				$error[$key] = true;
			}
		}
		$contents =  json_encode([$fields['name']." | ".$fields['lastname']." | ".$fields['phone']." | ".$fields['email']." | ".$fields['tema']." | ".
										$fields['pay']."|".$fields['agree']."|".date('Y-m-d-H-i-s')."|".$_SERVER['REMOTE_ADDR']."|"."n"."\n"]);
		$filename ='/formdata.json';	//файл со всеми данными регистраций
		save_json($config['data_dir'] . $filename, $contents);
		header('Location: header.php');
		
		
		include '/templates/admin-edit.php';
		exit;
	}
}

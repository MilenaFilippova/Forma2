<?php

	function array_get($array,$key,$default = null)
	{
		return $array[$key];
	}
	
	function e($value)
	{
		return htmlspecialchars($value);
	}
	
	
	function get_from_request($keys)
	{
		$data=[];
		foreach($keys as $key)
		{
			$data[$key]=trim(array_get(get_post(),$key,''));
		}
		return $data;
	}
	
	function get_validation_rules()
	{
		return[
			'name' =>[
				'not_empty'=>'Не указано имя!',
				'valid_name' => 'Неправильно указано имя!'
			],
			'lastname' =>[
				'not_empty'=>'Не указанa фамилия!',
				'valid_lastname' => 'Неправильно указана фамилия!'
			],
			'email' => [
				'not_empty' => 'Не указан e-mail!',
				'valid_email' => 'Неправильный e-mail!'
			],
			'phone' =>[
				'not_empty'=>'Не указан телефон!',
				'valid_phone' => 'Неправильно указан телефон!'
			],
		];
	}
	
	function save_json($path,$array)
	{
		return save_file($path,json_encode($array));
	}
	
	function save_file($path,$contents)
	{
		$dir = dirname($path);
		if (!file_exists($dir))
		{
			mkdir($dir,0777,true);
		}
		file_put_contents($path,$contents,FILE_APPEND);
	}
	
	function check_error($fields)
	{
		//проверки имени
			if(!$fields['name'])
			{
				$errors['name'] = 'Не указано имя!';
			}
			
			//проверки фамилии
			if(!$fields['lastname'])
			{
				$errors['lastname'] = 'Не указана фамилия!' ;
			}
			
			//проверки телефона
			if(!$fields['phone'])
			{
				$errors['phone'] = 'Не указан телефон!' ;
			}
			else if(strlen($fields['phone'])<11)
			{
				$errors['phone'] = 'Неверно указан телефон!' ;
			}
			else if(!(ctype_digit($fields['phone'])))	//проверяет, являются ли все символы в строке phone цифровыми.
			{
				$errors['phone'] = 'Неверно указан телефон,вводите только цифры!' ;
			}
			
			/*if(!(substr($phone,0)=='8'))	//проверяет, чтобы телефон начинался на 8
			{
				$errors['phone'] = 'Неверно указан телефон !' ;
			}*/
			
			//проверки e-mail
			if(!$fields['email'])
			{
				$errors['email'] = 'Не указан e-mail!' ;
				
			}
			else if(strpos($email, '@'))
			{
				$errors['email'] ='Неправильный e-mail! ';
			}
			
			return $errors;
	}

	
	function chek_newdel($del)
	{
		$filelist = file_get_contents("data/formdata.json");	//список всех файлов
		$filelist = explode("\n", $filelist);	//explode — Разбивает строку с помощью разделителя
		$flag = 0;
		foreach ($del as $j) 
		{
			foreach ($filelist as $key => $values)
			{
				$str = explode("|", $values);
				$str[11]='delited';	//устанавливаем удаленный стутус 
				$filelist[$key] = implode("|", $str);
				$flag++;
				break;

			}
		}
		$filelist = implode("\n", $filelist);
		file_put_contents("data/formdata.json", $filelist);
		if ($flag === count($del))
		{

			return true;
		}
		return false;
	}



	
	function get_post()
	{
		return $_POST;
	}

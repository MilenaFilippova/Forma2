<?php include_once  '/../functions.php';?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title> 
	<meta charset ="utf-8">
	<meta name="robots" content ="noindex,nofollow">
	
</head>
<body>
	<header>
		<table border=1>	
			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>lastname</th>
					<th>age</th>
					<th>city</th>
					<th>phone</th>
					<th>e-mail</th>
					<th>tema</th>
					<th>pay</th>
					<th>agree</th>
					<th>date</th>
					<th>server</th>
					<th>status</th>
					<th>delite</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$fd = fopen($config['data_dir'].'formdata.json', 'r+') or die ( "Не удалось открыть файл" );//r+ чтение и запись. Указатель файла устанавливается на его начало
			?> 
			<form action="admindel.php" method="POST"> 
			<?php
				$n=0;
				while (!feof($fd))	//пока не конец файла 
				{
					
					$ft = e(fgets($fd));	//считывать строку
					$str = [];	
					$str = explode("|", trim($ft));
					$str[12]="exists";
					if (!empty($str[0]))
					{
							echo "<tr><td>".$id."[".$n."]</td>";
							for ($i=0;$i<11;$i++)
							{
								$str[$i]=json_decode ($str[$i]);	//декодируем содержимое		
								echo "<td>".$str[$i]."</td>";
							}
							echo "<td>".$str[12]."</td>";
							if ($str[12]==="exists")	//если еще не удаляли даем возможность удалить
							{
								echo "<td><input type='checkbox' name='yesdel[]' value=" .$id."[".$n."]".">"."del"."<br></td></tr>";
							}
							$n++;
					}
				}
				fclose($fd) ;
			?> 
<p><input type="submit" value="Удалить данные"></p> 

</form>  

	<p><a href="/index.php">Вернутся к форме для заполнения</a></p>

</body>
<html> 

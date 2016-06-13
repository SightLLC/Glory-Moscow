<?php
/**
 * @package Sdelaysite_reg
 * @version 1.0
 */
/*
Plugin Name: SdelaySite_reg
Plugin URI: http://www.sdelaysite.com
Description: Плагин регистрации пользователей. Разработан для образовательных целей.
Armstrong: My Plugin.
Author: Andrey Morkovin
Version: 1.0
Author URI: http://www.sdelaysite.com
*/

// Функция выводит форму регистрации нового пользователя. Данные заносятся в промежуточную таблицу "m_reg_temp". После верификации e-mail данные переносятся в стандартную таблицу для хранения информации о пользователе в WP.

$m_output = "";

add_action( 'plugins_loaded', 'm_reg_run' );

function m_reg_run() 
{
	if(isset($_GET['m_regiser_usr_btn']))
	{
		m_add_new_user_temp();
	}
	elseif(isset($_GET['code']))
	{
		m_add_new_user_in_WP();
	}
}

// Производит сохранение данных в промежуточную таблицу до верификации e-mail нового пользователя.
function m_add_new_user_temp()
{
	global $wpdb;
	global $m_output;
	$table_new_user = $wpdb->prefix.'m_reg_temp';

	if(isset($_GET['m_user_name']))
	{
		$user_name = $_GET['m_user_name'];	
	}
	else
	{
		$user_name = "";
	}

	if(isset($_GET['m_user_email']))
	{
		$user_email = $_GET['m_user_email'];
	}
	else
	{
		$user_email = "";
	}
	

	$errors = array();

	$vals['user_name'] = $user_name;
	$vals['user_email'] = $user_email;

	$errors = m_user_data_validation($vals);

	if ($errors) 
	{
		$m_output = "<div style=\"color: red;\"><p>В процессе регистрации возникли ошибки:</p>";
		$m_output = $m_output."<ul>";
		foreach ($errors as $error)
		{
			$m_output = $m_output."<li>$error</li>";
		}
		$m_output = $m_output."</ul></div>";

		add_filter('the_content', 'm_content_filter');

		return ;
	}

	$random_code = wp_generate_password($length=12, $include_standard_special_chars=false);
	$password = wp_generate_password($length=12, $include_standard_special_chars=false);
	$ctime = time();

	$wpdb->insert(
					$table_new_user,  
					array('user_name' => $user_name, 'user_email' => $user_email, 'password' => $password, 'code' => $random_code, 'ctime' => $ctime),
					array('%s', '%s', '%s', '%s', '%d')
				);

	wp_mail($user_email, "Проверка почты", "Вы успешно зарегистрировались. Ваш логин: $user_name; ваш пароль: $password. Для активации учетной записи перейдите по ссылке: http://glorymoscow.ru/?code=$random_code");

	echo "<p>Для завершения регистрации перейдите по ссылке в письме, отправленном на указанный адрес эл. почты.</p>";

	$m_output = "<p>Для завершения регистрации перейдите по ссылке в письме, отправленном на указанный адрес эл. почты.</p>";
	add_filter('the_content', 'm_content_filter');
}


// Валидация добавления пользователя
function m_user_data_validation($vals)
{
	$errors = array();

	//
	if ($vals['user_name'] == '')
	{
		$errors['user_name'] = 'Укажите логин.';
	}
	elseif(mb_strlen($vals['user_name']) > 60)
	{
		$errors['user_name'] = 'Длина логина не должна превышать 60 символов.';
	}

	$user_id = username_exists($vals['user_name']);
	if($user_id)
	{
		$errors['user_name'] = 'Указанный логин занят, придумайте другой.';
	}

	$exp = '/^[0-9a-z][0-9a-z_\-\.%#]*@[0-9a-z][0-9a-z\-\.]{0,63}\.[a-z]{2,}$/i';
	if (!preg_match($exp, $vals['user_email']))
	{
		$errors['user_email'] = "Нужно указать e-mail, а не что-то еще.";
	}

	if ($vals['user_email'] == '')
	{
		$errors['user_email'] = 'Укажите адрес эл. почты.';
	}
	elseif(mb_strlen($vals['user_email']) > 100)
	{
		$errors['user_email'] = 'Длина адреса эл. почты не должна превышать 100 символов.';
	}

	if(email_exists($vals['user_email']))
	{
		$errors['user_email'] = 'Указанный адрес эл. почты уже используется.';
	}

	return $errors;
}

function m_add_new_user_in_WP()
{
	global $wpdb;
	global $m_output;

	$table_new_user = $wpdb->prefix.'m_reg_temp';

	$emailcode = $_GET['code'];
	
	$email_check = $wpdb->get_row(  
		$wpdb->prepare(  
			"SELECT * FROM $table_new_user WHERE code = %s", 
			$emailcode
		)
	);

	if($email_check)
	{	
		$vals['user_name'] = $email_check->user_name;
		$vals['user_email'] = $email_check->user_email;

		$errors = m_user_data_validation($vals);

		if($errors)
		{
			$m_output = "<p>Вы уже активировали учетную запись. Воспользуйтесь формой авториазации.</p>";
		}
		else
		{
			$user_id = wp_create_user($email_check->user_name, $email_check->password, $email_check->user_email);
            $host='localhost'; // имя хоста (уточняется у провайдера)
            $database='sergeydons_worp1'; // имя базы данных, которую вы должны создать
            $user='sergeydons_worp1'; // заданное вами имя пользователя, либо определенное провайдером
            $pswd='evegiticif'; // заданный вами пароль
            $dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
            mysql_select_db($database) or die("Не могу подключиться к базе.");
            mysql_query('SET names "utf8"');
            $av = rand(1, 43);
            $query = "UPDATE profiles SET avatar_id=".$av." WHERE user_id=".$user_id;
            mysql_query($query);
			$m_output = "<p>Вы успешно зарегистрировались.</p>";
		}
	}
	else
	{
		$m_output = "<p>Код подтверждения НЕ подходит!</p>";
	}
	
	add_filter('the_content', 'm_content_filter');
}

function m_content_filter($content)
{
	global $m_output;
	
	return $content.$m_output;
}
?>
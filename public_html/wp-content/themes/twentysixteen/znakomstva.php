<?php
/*
Template Name: Znakomstva page
*/
get_header(); ?>
<?php 
$host='localhost'; // имя хоста (уточняется у провайдера)
$database='sergeydons_worp1'; // имя базы данных, которую вы должны создать
$user='sergeydons_worp1'; // заданное вами имя пользователя, либо определенное провайдером
$pswd='evegiticif'; // заданный вами пароль
$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
mysql_select_db($database) or die("Не могу подключиться к базе.");
mysql_query('SET names "utf8"');
$user = get_current_user_id();
?>

<body class="search">
    <header class="main-header profile about">
			<div class="container">
				<nav class="main-nav">
					<ul class="menu clearfix">
						<li class="main">
							<a href="http://glorymoscow.ru">Главная</a>
						</li>
						<li class="acquaintance">
							<a>Знакомства</a>
						</li>
						<li class="about active">
							<a href="/about">О Glory Moscow</a>
						</li>
						<div class="user-block">
							<div class="logged-out <?php if($user!=0) { echo 'hide'; } else { echo 'show';} ?>">
								<li class="registration">
									<a href="#" class="sign-up-btn js-open-form-button js-close-form-button">Регистрация</a>
								</li>
								<li class="menu-item">
									<a href="#" class="sign-in-btn js-open-form-button js-close-form-button">Вход</a>
								</li>
							</div>
							<div class="logged-in <?php if($user!=0) { echo 'show'; } else { echo 'hide';} ?>">
								<li class="user-account">
									<a href="/account">
									<div class="user-avatar">
										<?php user_avatar($user, 40); ?>
									</div>
										Личный кабинет
									</a>
								</li>
							</div>
						</div>
					</ul>
				</nav>
			</div>
    </header>
	<main class="search container clearfix">
        <?php 
                            $status = $_GET['status'];
                            $figura = $_GET['figura'];
                            $strizhka = $_GET['strizhka'];
                            $sex = $_GET['iwant'];
                            $age_min = $GET['age_min'];
                            $age_max = $GET['age_max'];
                            $length_min = $GET['length_min'];
                            $length_max = $GET['length_max'];
                            if (!isset($age_min)) { $age_min = 18; }
                            if (!isset($age_max)) { $age_max = 27; }
                            if (!isset($length_min)) { $length_min = 14; }
                            if (!isset($length_max)) { $length_max = 20; }
                            
                            ?>
			<div class="left-part">
				<form class="simple-search" method="GET">
					<div class="I-want">
						<span class="filter-title">Я хочу</span>
						<div class="btn">
							<input type="checkbox" value="Анал актив" name="iwant[]" class="js-search-buttons"<?php if (in_array ('Анал актив', $sex)) { echo ' checked'; } ?>>
							<label for="want-anal-active">Анал актив</label>
						</div>
						<div class="btn">
							<input type="checkbox" value="Анал пассив" name="iwant[]" class="js-search-buttons"<?php if (in_array ('Анал пассив', $sex)) { echo ' checked'; } ?>>
							<label for="want-anal-passive">Анал пассив</label>
						</div>
						<div class="btn">
							<input type="checkbox" value="Орал актив" name="iwant[]" class="js-search-buttons"<?php if (in_array ('Орал актив', $sex)) { echo ' checked'; } ?>>
							<label for="want-oral-active">Орал актив</label>
						</div>
						<div class="btn">
							<input type="checkbox" value="Орал пассив" name="iwant[]" class="js-search-buttons"<?php if (in_array ('Орал пассив', $sex)) { echo ' checked'; } ?>>
							<label for="want-oral-passive">Орал пассив</label>
						</div>
					</div>
					<div class="status">
						<span class="filter-title">Статус</span>
						<label for="new">Новые</label>
						<input type="checkbox" class="filter-checkbox" value="Новые" id="new" name="status[]"<?php if (in_array ('Новые', $status)) { echo ' checked'; } ?>>
						<label for="old">Активные</label>
						<input type="checkbox" class="filter-checkbox" value="Активные" id="old" name="status[]"<?php if (in_array ('Активные', $status)) { echo ' checked'; } ?>>
					</div>
					<button class="submit-btn" name="poisk">Начать поиск</button>
				</form>
                <section class="result">
                    <form method="post">

<?php
$search = $_GET['search'];
if(isset($_GET['poisk'])) 
{	
    $t=1;
	$query = "SELECT user_id, wishes, age, length, figure FROM profiles WHERE ";
    
    if (isset($_GET['figura']))
    {
        if (count($_GET['figura'])!=2)
        {
            $query .= "figure = '".$_GET['figura'][0]."' AND ";
        }
        else
        {
            $query .= "1 AND ";
        }
    }
    else
    {
         $query .= "1 AND ";
    }
    
    if (isset($_GET['strizhka']))
    {
        if (count($_GET['strizhka'])!=2)
        {
            $query .= "shaved = '".$_GET['strizhka'][0]."' ";
        }
        else
        {
            $query .= "1 ";
        }
    }
    else
    {
         $query .= "1 ";
    }
    
	if (isset($sex)) 
	{
        $query .= "AND ("; 
		$N = count($sex);
		for ($i=0; $i<$N; $i++)
		{
			if ($i != 0) {  $query .= "OR "; }
			switch ($sex[$i]) {
				case "Анал актив" : $poisk = "Анал пассив"; break;
				case "Анал пассив" : $poisk = "Анал актив"; break;
				case "Орал актив" : $poisk = "Орал пассив"; break;
				case "Орал пассив" : $poisk = "Орал актив"; break;
			}
			$query .= "wishes LIKE '%".$poisk."%'";
		}
        $query .= ") ";
	}
    
	if (isset($status)) 
	{ 
        $N = count($status); 
        if ($N != 2) 
        { 
            if ($status[0]=='Новые')
            { $query .= "AND experience_id = 1 "; }
            else
            { $query .= "AND experience_id = 2 "; }
        } 
    }
    
    /* if (isset($length_min))
    {
        $query .= "AND length>=".$length_min." AND length<=".$length_max." ";
    }
    
    if (isset($age_min))
    {
        $query .= "AND age>=".$age_min." AND age<=".$age_max;
    }
    */
    $k=1;
    /* echo $query; */
	$res = mysql_query($query) or die("Invalid query1: " . mysql_error());
    
	while($row = mysql_fetch_array($res))
	{
        
		echo '<article class="result-item"><div class="js-open-meeting-window"><div class="avatar">';
		$search['id'] = $row['user_id'];
		$search['age'] = $row['age'];
		$search['length'] = $row['length'];
        user_avatar($search['id'], 160);
		echo '</div><div class="nickname">';
		echo get_the_author_meta('display_name', $search['id']);
        echo '</div></div>';
        $query1 = "SELECT `event_date` FROM `events` WHERE `event_date` in (SELECT `event_date` FROM `events` WHERE user_id = ".$user.") and user_id = ".$search['id']; 
        $res1 = mysql_query($query1) or die("Invalid query2: " . mysql_error());
        echo '<div class="meeting-choose no-display" id="'.$k.'-search-result"><div class="meeting-choose-title js-protect-from-auto-closure">Приглашение</div>';
       	while($row1 = mysql_fetch_array($res1)) 
        {
            
            $query2 = "select `event_date`, `time_book_id` from `events` WHERE `event_date` = '".$row1['event_date']."' and `time_book_id` in (SELECT `time_book_id` FROM `events` WHERE user_id = ".$user." and `event_date` = '".$row1['event_date']."') and user_id = ".$search['id'];
            $res2 = mysql_query($query2) or die("Invalid query3: " . mysql_error());
            while($row2 = mysql_fetch_array($res2))
               			{
                            
                            echo '<div class="meeting-var-item js-protect-from-auto-closure">';
                            echo '<label for="'.$t.'">';
                            echo $row2['event_date'];
                            echo ', ';
                            echo 'Время: '.$row2['time_book_id'];
                            echo '</label>';
                            echo '<input type="checkbox" id="'.$t.'" value="'.$t.'" name="inv[]">';
                            $queries[$t] = "INSERT INTO `meetings`(`sender_id`, `receiver_id`, `meeting_date`, `meeting_time`) VALUES (".$user.",".$search['id'].",'".$row2['event_date']."',".$row2['time_book_id'].")";
                            $t++;
                            echo '</div>';
               			}
            
      		  }
        echo '<button class="send-invitation" name="send_inv">Отправить приглашение</button>';
        echo '</article>';
        $k++;
        
	}
}
                    if(isset($_POST['send_inv']))
                    {
                        
                        if(!empty($_POST['inv']))
                        {
                           
                            $inv = $_POST['inv'];
                           
                            for ($i=0; $i < count($inv); $i++)
                            {
                                mysql_query($queries[$inv[$i]]);
                            }
                        }
                    }
                    /*
                    $query = "SELECT `events`.`event_date`from `events` WHERE `events`.`user_id` =".$user;
                    $res = mysql_query($query) or die("Invalid query: " . mysql_error());
                    while($row = mysql_fetch_array($res))
                    {
                        $query1 = " SELECT `user_id` FROM `events` WHERE `event_date` = '".$row['event_date']."' and `time_book_id` in (SELECT `time_book_id` FROM `events` WHERE user_id = ".$user." and  `event_date` = '".$row['event_date']."') AND user_id !=".$user;
                        $res1 = mysql_query($query1) or die("Invalid query: " . mysql_error());
                        $query_end = "SELECT `user_id`, `wishes`, `age`, `figure`, `shaved`, `length`, `experience_id` FROM `profiles` WHERE `user_id` in (";
                        while($row1 = mysql_fetch_array($res1))
                        {
                            $query_end .= row1['user_id'].',';
                        }
                        $query_end = substr($query_end, 0, -1);
                        $query_end .= ')';
                    }
                    */
                    ?>
                    </form>
</section>
            </div>
        <form class="right-part" method="GET">
				<div class="filter-title">
					Расширенный поиск
				</div>
				<div class="paddings-maker">
					<div class="filter-sub-title">
						Возраст
					</div>
					<div class="age filter-toggle">
						<div class="bar"></div>
						<div class="selected-range"></div>
						<div class="toggle toggle-left" draggable="true">
							<span class="toggle-label"><?php echo $age_min; ?></span>
							<input type="text" class="js-toggles" name="age_min" value="<?php echo $age_min; ?>">
						</div>
						<div class="toggle toggle-right">
							<span class="toggle-label"><?php echo $age_max; ?></span>
							<input type="text" class="js-toggles" name="age_max" value="<?php echo $age_max; ?>">
						</div>
					</div>
					<div class="filter-sub-title">
						Тип фигуры
					</div>
					<div class="filter-parameters">
						<div class="case">
                            
							<input type="checkbox" class="filter-checkbox" value="Стройный" id="skinny" name="figura[]"<?php if (in_array ('Стройный', $figura)) { echo ' checked'; } ?>>
							<label for="skinny">Стройная</label>
						</div>
						<div class="case">
							<input type="checkbox" class="filter-checkbox" value="Полный" id="fat" name="figura[]"<?php if (in_array ('Полный', $figura)) { echo ' checked'; } ?>>
							<label for="fat">Полная</label>
						</div>
					</div>
					<div class="filter-sub-title">
						Интимная стрижка
					</div>
					<div class="filter-parameters">
						<div class="case">
							<input type="checkbox" class="filter-checkbox" value="Бритый" id="skinny" name="strizhka[]"<?php if (in_array ('Бритый', $strizhka)) { echo ' checked'; } ?>>
							<label for="skinny">Бритый</label>
						</div>
						<div class="case">
							<input type="checkbox" class="filter-checkbox" value="Небритый" id="fat" name="strizhka[]"<?php if (in_array ('Небритый', $strizhka)) { echo ' checked'; } ?>>
							<label for="fat">Небритый</label>
						</div>
					</div>
					<div class="filter-sub-title">Длина в эррегированном состоянии</div>
					<div class="length filter-toggle">
						<div class="bar"></div>
						<div class="selected-range"></div>
						<div class="toggle toggle-left">
							<span class="toggle-label"><?php echo $length_min; ?></span>
							<input type="text" class="js-toggles" name="length_min" value="<?php echo $length_min; ?>">
						</div>
						<div class="toggle toggle-right">
							<span class="toggle-label"><?php echo $length_max; ?></span>
							<input type="text" class="js-toggles" name="length_max" value="<?php echo $length_max; ?>">
						</div>
					</div>
				</div>
				<button class="filter-submit" name="poisk">Применить</button>
			</form>
		</main>
		<div class="sign-up-window no-display js-window">
			<a class="close-window js-close-form-button" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
			<form>
				<input type="text" value="Логин" name="login" data-name="Логин" class="user-info">
				<input type="text" value="Пароль" name="password" data-name="Пароль" class="user-info">
				<input type="text" value="Почта" name="email" data-name="Почта" class="user-info">
				<input type="submit" class="sign-up-btn" value="Регистрация">
			</form>
		</div>
		<div class="sign-in-window no-display js-window">
			<a class="close-window js-close-form-button" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
			<form>
				<input type="text" value="Логин" name="login" data-name="Логин" class="user-info">
				<input type="text" value="Пароль" name="password" data-name="Пароль" class="user-info">
				<input type="submit" class="login-btn" value="Войти">
				<a class="remember-password js-open-form-button js-close-form-button" href="#">Не помню пароль</a>
			</form>
		</div>
		<div class="forgot-password-window no-display js-window">
			<a class="close-window js-close-form-button" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
			<form>
				<input type="text" value="Почта" name="FPemail" data-name="Почта" class="user-info">
				<input type="submit" class="forgot-password-btn" value="Напомнить пароль">
			</form>
		</div>
		<script src="http://glorymoscow.ru/js/togglerAge.js"></script>
		<script src="http://glorymoscow.ru/js/togglerLength.js"></script>
		<script src="http://glorymoscow.ru/js/loginWindow.js"></script>
		<script src="http://glorymoscow.ru/js/filterButtons.js"></script>
	</body>
</html>
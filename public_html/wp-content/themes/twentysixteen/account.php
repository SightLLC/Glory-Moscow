<?php
/*
Template Name: Account page
*/
get_header(); ?>

<?php 
$host='localhost'; // имя хоста (уточняется у провайдера)
$database='sergeydons_worp1'; // имя базы данных, которую вы должны создать
$user='sergeydons_worp1'; // заданное вами имя пользователя, либо определенное провайдером
$pswd='evegiticif'; // заданный вами пароль

$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
mysql_select_db($database) or die("Не могу подключиться к базе.");

$user = get_current_user_id();
?>

<body class="profile">
    <script src="http://glorymoscow.ru/js/moment.js"></script>
		<header class="main-header profile">
			<div class="container">
				<nav class="main-nav">
					<ul class="menu clearfix">
						<li class="main">
							<a href="http://glorymoscow.ru">Главная</a>
						</li>
						<li class="acquaintance">
							<a href="/znakomstva">Знакомства</a>
						</li>
						<li class="about active">
							<a href="/about">О Glory Moscow</a>
						</li>
						<div class="user-block">
							<div class="logged-out <?php if($user!=0) { echo 'hide'; } else { echo 'show';} ?>">
								<li class="registration">
									<a href="#" class="sign-up-btn">Регистрация</a>
								</li>
								<li class="menu-item">
									<a href="#" class="sign-in-btn">Вход</a>
								</li>
							</div>
							<div class="logged-in <?php if($user!=0) { echo 'show'; } else { echo 'hide';} ?>">
								<li class="user-account">
									<a href="#">
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
		<main class="container clearfix profile">
			<h1 class="page-title profile">Мой профиль</h1>
			<section class="account">
				<div class="avatar">
					<?php user_avatar($user, 160); ?>
				</div>
				<div class="nickname">
					<?php echo get_the_author_meta('display_name', $user); ?>
				</div>
					<div class="statistics">
						<div class="statistics-item">
							<span class="statistics-title">Предложения мне(активные)</span>
                            <div class="statistics-number js-stat-form-button">
								<?php 
                                $query = "SELECT COUNT(receiver_id) FROM meetings WHERE receiver_id=".$user." and meeting_status=1";
                                $predl = mysql_query($query);
                                $row = mysql_fetch_row($predl);
                                echo '<a href="#">'.$row[0].'</a></div>';
                                ?>
								<section class="my-offers no-display js-protect-from-auto-closure js-stat-form-window" id="firstStatSection">
                                    <div class="meetings-scroller">
                                    <?php
                                    $query = "SELECT `sender_id`, `meeting_date`, `meeting_time` FROM `meetings` WHERE `receiver_id`=".$user." and `meeting_status`=1";
                                    $res = mysql_query($query);
                                    $j=0;
                                    while($row = mysql_fetch_array($res)) 
                                    {
                                        echo '<form method="post"><article class="my-offers-item"><div class="offer-body clearfix">';
                                        echo '<div class="offers-avatar">';
                                        user_avatar($row['sender_id'], 60);
                                        echo '</div>';
                                        echo '<div class="offer-text">';
                                        echo '<p>Пользователь <span class="user-name">'.get_the_author_meta('display_name', $row['sender_id']).'</span><br>
												хочет назначить вам встречу</p>';
                                        echo '<p class="offer-time">'.$row['meeting_date'].' в'.$row['meeting_time'].'</p>';
                                        echo '</div></div>';
                                        echo '<div class="offer-buttons clearfix">
											<button name="accept_predl_mne" value="'.$j.'" class="offer-button accept">Принять</button>
											<button name="decline_predl_mne" value="'.$j.'"class="offer-button decline">Отклонить</button>
										</div>';
                                        echo'</article></form>';
                                        $queries_accept[$j] = "UPDATE `meetings` SET `meeting_status`=2 WHERE `receiver_id`=".$user." AND `sender_id`=".$row['sender_id']." AND `meeting_date`='".$row['meeting_date']."' AND `meeting_time`=".$row['meeting_time'];
                                        $queries_decline[$j] = "UPDATE `meetings` SET `meeting_status`=3 WHERE `receiver_id`=".$user." AND `sender_id`=".$row['sender_id']." AND `meeting_date`='".$row['meeting_date']."' AND `meeting_time`=".$row['meeting_time'];
                                        $j++;
                                    }
                                    
                                    
		                              ?>
                                    </div>
								</section>
							
						</div>
                        <?php
                        if(isset($_POST['accept_predl_mne']))
                                    {
                                        $temp = $_POST['accept_predl_mne'];
                                       
                                        mysql_query($queries_accept[$temp]);
                                    }
                                    if(isset($_POST['decline_predl_mne']))
                                    {
                                        $temp = $_POST['decline_predl_mne'];
                                        mysql_query($queries_decline[$temp]);
                                    }
                        ?>
                        <div class="statistics-item">
							<span class="statistics-title">Предложения мне(принятые)</span>
							<div class="statistics-number js-stat-form-button">
                                <?php 
                                $query = "SELECT COUNT(*) FROM `meetings` WHERE `receiver_id`=".$user." and `meeting_status`=2";
                                $predl1 = mysql_query($query);
                                $row = mysql_fetch_row($predl1);
                                echo '<a href="#">'.$row[0].'</a>';
                                ?>
                                <section class="active-offers js-protect-from-auto-closure js-stat-form-window no-display" id="secondStatSection">
                                    <?php
                                    $query = "SELECT `sender_id`, `meeting_date`, `meeting_time` FROM `meetings` WHERE `receiver_id`=".$user." and `meeting_status`=2";
                                    $res = mysql_query($query);
                                    while($row = mysql_fetch_array($res)) 
                                    {
                                        echo '<article class="my-offers-item"><div class="offer-body clearfix">';
                                        echo '<div class="offers-avatar">';
                                        user_avatar($row['sender_id'], 60);
                                        echo '</div>';
                                        echo '<div class="offer-text">';
                                        echo '<p>Пользователь <span class="user-name">'.get_the_author_meta('display_name', $row['sender_id']).'</span><br>
												назначил вам встречу</p>';
                                        echo '<p class="offer-time">'.$row['meeting_date'].' в'.$row['meeting_time'].'</p>';
                                        echo '</div></div>';
                                        echo'</article>';
                                    }
		                              ?>
									
								</section>
                            </div>
                            
						</div>
						<div class="statistics-item">
							<span class="statistics-title">Мои предложения (активные)
                            </span>
							<div class="statistics-number js-stat-form-button">
                                <?php 
                                $query = "SELECT COUNT(*) FROM `meetings` WHERE `sender_id`=".$user." AND `meeting_status`=1";
                                $act = mysql_query($query);
                                $row = mysql_fetch_row($act);
                                echo '<a href="#">'.$row[0].'</a>';
                                echo '</div>';
                                ?>
                                <section class="active-offers js-protect-from-auto-closure js-stat-form-window no-display" id="thirdStatSection">
                                    <div class="active-offers-title">
									Ожидают подтверждения
								    </div>
                                    <div class="meetings-scroller">
                                    <?php
                                    $query = "SELECT `receiver_id`, `meeting_date`, `meeting_time`, `meeting_status` FROM `meetings` WHERE `sender_id`= ".$user." AND `meeting_status`=1";
                                    $res = mysql_query($query);
                                    while($row = mysql_fetch_array($res)) 
                                    {
                                        echo '<article class="my-offers-item"><div class="offer-body clearfix">';
                                        echo '<div class="offers-avatar">';
                                        user_avatar($row['receiver_id'], 60);
                                        echo '</div>';
                                        echo '<div class="offer-text active">';
                                        echo '<p class="active-user">'.get_the_author_meta('display_name', $row['receiver_id']).'</p>';
                                        echo '<p class="offer-time">'.$row['meeting_date'].' в '.$row['meeting_time'].'</p>';
                                        echo '</div></div>';
                                        echo'</article>';
                                    }
		                              ?>
                                    </div>
								</section>
                            </div>
						</div>
						<div class="statistics-item">
							<span class="statistics-title">Мои предложения (принятые)</span>
							<div class="statistics-number js-stat-form-button">
                                <?php 
                                $query = "SELECT COUNT(*) FROM `meetings` WHERE `sender_id`=".$user." AND `meeting_status`=2";
                                $prin = mysql_query($query);
                                $row = mysql_fetch_row($prin);
                                echo '<a href="#">'.$row[0].'</a>';
                                ?>
                                <section class="active-offers js-protect-from-auto-closure js-stat-form-window no-display" id="forthStatSection">
                                    <?php
                                    $query = "SELECT `receiver_id`, `meeting_date`, `meeting_time`, `meeting_status` FROM `meetings` WHERE `sender_id`= ".$user." AND `meeting_status`=2";
                                    $res = mysql_query($query);
                                    while($row = mysql_fetch_array($res)) 
                                    {
                                        echo '<article class="my-offers-item"><div class="offer-body clearfix">';
                                        echo '<div class="offers-avatar">';
                                        user_avatar($row['sender_id'], 60);
                                        echo '</div>';
                                        echo '<div class="offer-text">';
                                        echo '<p>Вы назначили встречу пользователю<span class="user-name">'.get_the_author_meta('display_name', $row['sender_id']).'</span></p>';
                                        echo '<p class="offer-time">'.$row['meeting_date'].' в'.$row['meeting_time'].'</p>';
                                        echo '</div></div>';
                                        echo'</article>';
                                    }
		                              ?>
									
								</section>
                            </div>
						</div>
						<div class="statistics-item">
							<span class="statistics-title">Проведено встреч</span>
							<div class="statistics-number js-stat-form-button">
                                <?php 
                                $query = "SELECT COUNT(*) FROM `meetings` WHERE (`sender_id`= ".$user." OR `receiver_id` = ".$user.") AND `meeting_status`=2";
                                $prov = mysql_query($query);
                                $row = mysql_fetch_row($prov);
                                echo '<a href="#">'.$row[0].'</a>';
                                ?>
                                <section class="my-offers js-stat-form-window no-display">
                                    <?php
                                    $query = "SELECT `receiver_id`, `meeting_date`, `meeting_time`, `meeting_status` FROM `meetings` WHERE `sender_id`= ".$user." AND `meeting_status`=2";
                                    $res = mysql_query($query);
                                    while($row = mysql_fetch_array($res)) 
                                    {
                                        echo '<article class="my-offers-item"><div class="offer-body clearfix">';
                                        echo '<div class="offers-avatar">';
                                        user_avatar($row['sender_id'], 60);
                                        echo '</div>';
                                        echo '<div class="offer-text">';
                                        echo '<p>У вас состоялась встреча с пользователем <span class="user-name">'.get_the_author_meta('display_name', $row['sender_id']).'</span></p>';
                                        echo '<p class="offer-time">'.$row['meeting_date'].' в'.$row['meeting_time'].'</p>';
                                        echo '</div></div>';
                                        echo'</article>';
                                    }
		                              ?>
									
								</section>
                            </div>
						</div>
					</div>
			</section>
            <?php 
            $query = "SELECT * FROM profiles WHERE user_id=".$user;
            $res = mysql_query($query);
            while($row = mysql_fetch_array($res))
            {
                $age = $row['age'];
                $figure = $row['figure'];
                $shaved = $row['shaved'];
                $length = $row['length'];
                $wishes = $row['wishes'];
            }
            ?>
            
			<section class="settings clearfix">
                <form method="post">
                    <section class="settings clearfix">
                        <select multiple name="iwant[]" class="iwant">
                                <option disabled>Я хочу</option>
                                <option <?php $pos = strpos($wishes, 'Анал актив'); if ($pos == true) { echo 'selected'; } ?>value="Анал актив">Анал актив</option>
                                <option <?php $pos = strpos($wishes, 'Анал пассив'); if ($pos == true) { echo 'selected'; } ?>value="Анал пассив">Анал пассив</option>
                                <option <?php $pos = strpos($wishes, 'Орал актив'); if ($pos == true) { echo 'selected'; } ?>value="Орал актив">Орал актив</option>
                                <option <?php $pos = strpos($wishes, 'Орал пассив'); if ($pos == true) { echo 'selected'; } ?>value="Орал пассив">Орал пассив</option>
                        </select>
                        <select name="age" class="age">
                                <option disabled>Возраст</option>
                                <?php 
                                for ($i=18; $i<58; $i++)
                                {
                                    if ($age!=$i)
                                    { echo '<option value="'.$i.'">'.$i.'</option>'; }
                                    else
                                    { echo '<option selected value="'.$i.'">'.$i.'</option>'; }
                                }
                                ?>
                        </select>
                        <select name="figura" class="figure">
                                <option disabled>Фигура</option>
                                <option <?php if($figure=='Стройный') { echo 'selected '; } ?>value="Стройный">Стройный</option>
                                <option <?php if($figure=='Полный') { echo 'selected '; } ?>value="Полный">Полный</option>
                        </select>
                        <select name="strizhka" class="cut">
                                <option disabled>Интимная стрижка</option>
                                <option <?php if($shaved=='Небритый') { echo 'selected '; } ?>value="Небритый">Небритый</option>
                                <option <?php if($shaved=='Бритый') { echo 'selected '; } ?>value="Бритый">Бритый</option>
                        </select>
                        <select name="length" class="length">
                                <option disabled>Длина в эрегированном состоянии</option>
                                <?php 
                                for ($i=5; $i<31; $i++)
                                {
                                    if ($length==$i)
                                    { echo '<option selected value="'.$i.'">'.$i.'</option>'; }
                                    else
                                    { echo '<option value="'.$i.'">'.$i.'</option>'; }
                                }
                                ?>
                        </select>
                        <div class="buttons">
                            <button name="save_btn" class="save">Сохранить</button>
                            <button class="edit">Редактировать</button>
                        </div>
                    </section>
                </form>
                
                <?php 
               
                if (isset($_POST['save_btn']))
                { 
                     if (isset($_POST['iwant']))
                    {
                        foreach ($_POST['iwant'] as $select)
                            { $iwant .= $select.' '; }
                    }
                    if (isset($_POST['length']))
                    { $length = $_POST['length'];}
                    if (isset($_POST['figura']))
                    { $figura = $_POST['figura'];}
                    if (isset($_POST['strizhka']))
                    { $strizhka = $_POST['strizhka'];}
                    if (isset($_POST['age']))
                    { $age = $_POST['age'];}
                    $query = "UPDATE profiles SET wishes='".$iwant."', age=".$age.", figure='".$figura."', shaved='".$strizhka."', length=".$length." WHERE user_id=".$user; 
                    mysql_query($query);
                    header("Location: http://glorymoscow.ru/about/");
                    
                    
                }
                ?>
			</section>
			<section class="calendar clearfix">
    <div class="title">
        Удобное время встреч
    </div>
    <div class="border-maker clearfix">
        <form name="calendar" method="get">
            <div class="first month">
                            <div class="big-simbols">
                                <div class="weekday-and-month">
                                    <span>
                                        Friday<br>
                                        April 2016
                                    </span>
                                </div>
                                <div class="day">
                                    14
                                </div>
                                <div class="previous-meeting"></div>
                                <div class="next-meeting"></div>
                            </div>
                            <div class="days">
                                <table id="calendar_prev" class="month-data">
                                    <thead>
                                        <tr><td><b>‹</b><td colspan="5"><td><b>›</b>
                                        <tr class="weekdays"><td>M<td>T<td>W<td>T<td>F<td>S<td>S
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
            <div class="second month">
                <div class="big-simbols">
                                <div class="weekday-and-month">
                                    <span>
                                        Wednesday<br>
                                        May 2016
                                    </span>
                                </div>
                                <div class="day">
                                    10
                                </div>
                                <div class="previous-meeting"></div>
                                <div class="next-meeting"></div>
                </div>
                <div class="days">
                        <table id="calendar" class="month-data" >
                          <thead>
                            <tr><td><b>‹</b><td colspan="5"><td><b>›</b>
                            <tr class="weekdays"><td>M<td>T<td>W<td>T<td>F<td>S<td>S
                          </thead>
                          <tbody></tbody>
                        </table>

                </div>
            </div>
            <div class="third month">
                            <div class="big-simbols">
                                <div class="weekday-and-month">
                                    <span>
                                        Friday<br>
                                        April 2016
                                    </span>
                                </div>
                                <div class="day">
                                    14
                                </div>
                                <div class="previous-meeting"></div>
                                <div class="next-meeting"></div>
                            </div>
                            <div class="days">
                                <table id="calendar_next" class="month-data">
                                    <thead>
                                        <tr><td><b>‹</b><td colspan="5"><td><b>›</b>
                                        <tr class="weekdays"><td>M<td>T<td>W<td>T<td>F<td>S<td>S
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
        </form>
    </div>
      
</section>
		</main>


		
      
<?php
$query = "SELECT event_date FROM `events` WHERE user_id=".$user;
$res = mysql_query($query);
while($row = mysql_fetch_array($res))
{
    $events[] = $row['event_date'];
}
?>

<script>
var now1 = new Date();
events = new Array();
events = <?php echo json_encode($events); ?>;
if (events!=null)
{
    for (var j=0; j < events.length; j++) { events[j] = new Date(events[j]); }
}

function calendar(id, year, month) {
    var Dlast = new Date(year,month+1,0).getDate(),
        D = new Date(year,month,Dlast),
        DNlast = new Date(D.getFullYear(),D.getMonth(),Dlast).getDay(),
        DNfirst = new Date(D.getFullYear(),D.getMonth(),1).getDay(),
        calendar = '<tr>',
        month=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
    if (DNfirst != 0) 
    {
        for(var  i = 1; i < DNfirst; i++) calendar += '<td>';
    }
    else
    {
        for(var  i = 0; i < 6; i++) calendar += '<td>';
    }
    
    for(var  i = 1; i <= Dlast; i++) {
        m=0;
        if (i<10) 
        { 
            this_day = moment(D).format('YYYY-MM') + '-0' + i; 
        }
        else      
        { 
            this_day = moment(D).format('YYYY-MM') + '-' + i;  
        }
        tod = new Date();
        this_den = new Date(this_day);
    if(moment(now1).isSameOrBefore(this_day))
    {
        if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth())
        { 
            calendar += '<td class=current-month"><button class="one-day today" name ="day1" data-dayNumber="' + i + '" value="' + this_day + '">' + i + '</button>'; 
        }
        else
        {
            if (events!=null)
            {
                for (var k=0; k < events.length; k++) 
                { 
                    if ( i == events[k].getDate() && D.getFullYear() == events[k].getFullYear() && D.getMonth() == events[k].getMonth() ) 
                    { 
                        m = 1;  
                    } 
                } 
            }
                if (m == 1) 
                { 
                    calendar += '<td class=current-month"><button class="one-day active" name ="day1" data-dayNumber="' + i + '" value="' + this_day + '">' + i + '</button>'; 
                } 
                else 
                { 
                    calendar += '<td class="current-month"><button class="one-day" name ="day1" data-dayNumber="' + i + '" value="' + this_day + '">' + i + '</button>'; 
                }
            
        }
    }
    else 
    { 
        if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth())
        { 
            calendar += '<td class=current-month"><button class="one-day today" name ="day1" data-dayNumber="' + i + '" value="' + this_day + '">' + i + '</button>'; 
        } 
        else
        { calendar += '<td>' + i; }
    }
        if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) 
        { 
            calendar += '<tr>'; 
        }
    }

    for(var  i = DNlast; i < 7; i++) calendar += '<td> ';
    
    document.querySelector('#'+id+' tbody').innerHTML = calendar;
    document.querySelector('#'+id+' thead td:nth-child(2)').innerHTML = month[D.getMonth()] +' '+ D.getFullYear();
    document.querySelector('#'+id+' thead td:nth-child(2)').dataset.month = D.getMonth();
    document.querySelector('#'+id+' thead td:nth-child(2)').dataset.year = D.getFullYear();
    
    if (document.querySelectorAll('#'+id+' tbody tr').length < 6) {  // чтобы при перелистывании месяцев не "подпрыгивала" вся страница, добавляется ряд пустых клеток. Итог: всегда 6 строк для цифр
        document.querySelector('#'+id+' tbody').innerHTML += '<tr><td> <td> <td> <td> <td> <td> <td> ';
    }
}
    
calendar("calendar", new Date().getFullYear(), new Date().getMonth());
calendar("calendar_prev", new Date().getFullYear(), new Date().getMonth()-1);
calendar("calendar_next", new Date().getFullYear(), new Date().getMonth()+1);
    
// переключатель минус месяц
document.querySelector('#calendar thead tr:nth-child(1) td:nth-child(1)').onclick = function() {
    calendar("calendar", document.querySelector('#calendar thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar thead td:nth-child(2)').dataset.month)-1);
    calendar("calendar_prev", document.querySelector('#calendar_prev thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar_prev thead td:nth-child(2)').dataset.month)-1);
    calendar("calendar_next", document.querySelector('#calendar_next thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar_next thead td:nth-child(2)').dataset.month)-1);
}

// переключатель плюс месяц
document.querySelector('#calendar thead tr:nth-child(1) td:nth-child(3)').onclick = function() {
    calendar("calendar", document.querySelector('#calendar thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar thead td:nth-child(2)').dataset.month)+1);
    calendar("calendar_prev", document.querySelector('#calendar_prev thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar_prev thead td:nth-child(2)').dataset.month)+1);
    calendar("calendar_next", document.querySelector('#calendar_next thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar_next thead td:nth-child(2)').dataset.month)+1);
}

</script>

                            
		<div class="login-window no-display">
			<a class="close-login-window" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
			<form>
				<input type="text" value="Логин" name="login">
				<input type="text" value="Пароль" name="password">
				<input type="submit" class="login-btn" value="Войти">
				<a class="remember-password" href="#">Не помню пароль</a>
			</form>
		</div>
		<div class="sign-up-window no-display">
			<a class="close-sign-up-window" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
			<form>
				<input type="text" value="Логин" name="login">
				<input type="text" value="Пароль" name="password">
				<input type="text" value="Почта" name="email">
				<input type="submit" class="sign-up-btn" value="Регистрация">
			</form>
		</div>
        <?php 
            if (isset($_GET['day1']))
            {
                $date_chosen = $_GET['day1'];
            }
            else 
            {
                $date_chosen = 0;
            }
        ?>
        <div class="time-window js-window no-display">
			<div class="window-title">
                Выберите время для дня: <?php echo $date_chosen; ?>
			</div>
			<div class="day-half am"></div>
			<div class="day-half pm no-display"></div>
			<form method="post" class="date-and-time-inputs" action="">
                <?php
                
                $query = "SELECT * FROM `time_book`";
                $res = mysql_query($query);

                $i=1;
                $times=array();
                while($row = mysql_fetch_array($res))
                {
                    $times['time_id'][$i] = $row['time_id'];
                    $times['time_name'][$i] = $row['time_name'];
                    $times['active'][$i] = 0;
                    $i++;
                }

                $query = "SELECT time_id, time_name from events INNER join time_book on events.time_book_id = time_id WHERE user_id=".$user." and event_date = '".$date_chosen."'";
                $res = mysql_query($query);
                $i=1;
                $times_active = array();
                while($row = mysql_fetch_array($res))
                {
                    $times_active['time_id'][$i] = $row['time_id'];
                    $times_active['time_name'][$i] = $row['time_name'];
                    $x = $times_active['time_id'][$i];
                    $times['active'][$x] = 1;
                    $i++;
                }
                
                for ($i=7; $i<19; $i++)
                {
                    echo '<div class="hour-am">';
                    echo '<label for="'.$times['time_id'][$i].'">'.$times['time_name'][$i].'</label>';
                    echo '<input type="checkbox" id="'.$times['time_id'][$i].'" name="'.$i.'"';
                    if ($times['active'][$i] == 1)
                    { echo ' checked'; }
                    echo ' >';
                    echo '</div>';
                }
                for ($i=19; $i<25; $i++)
                {
                    echo '<div class="hour-pm no-display">';
                    echo '<label for="'.$times['time_id'][$i].'">'.$times['time_name'][$i].'</label>';
                    echo '<input type="checkbox" id="'.$times['time_id'][$i].'" name="'.$i.'"';
                    if ($times['active'][$i] == 1)
                    { echo ' checked'; }
                    echo ' >';
                    echo '</div>';
                }
                for ($i=1; $i<7; $i++)
                {
                    echo '<div class="hour-pm no-display">';
                    echo '<label for="'.$times['time_id'][$i].'">'.$times['time_name'][$i].'</label>';
                    echo '<input type="checkbox" id="'.$times['time_id'][$i].'" name="'.$i.'"';
                    if ($times['active'][$i] == 1)
                    { echo ' checked'; }
                    echo ' >';
                    echo '</div>';
                }
                
                ?>
			
			<div class="save-button-container">
				<button name="save_btn" class="save-button">Сохранить</button>
			</div>
            </form>
            <?php 
            $submit=$_POST['save_btn']; 
            if(isset($submit)) 
            {
                $i=1;
                $query = "DELETE FROM `events` WHERE `user_id`= ".$user." and `event_date`='".$date_chosen."'";
                mysql_query($query);
                while ($i < 25)
                {
                    if ( $_POST[$i] == "on")
                    {
                        $query = "INSERT INTO `events`(`user_id`, `event_date`, `time_book_id`) VALUES (".$user.",'".$date_chosen."',".$i.")";
                        mysql_query($query);
                    }
                    $i++;
                }
                $date_chosen = 0;
                unset($_GET); 
            }
            ?>
		</div>
            
    <div class="timeChooseFlag" data-variable=<?php echo $date_chosen; ?>></div>
	<script>
		var dayChooseWindowFlag = document.querySelector(".timeChooseFlag").dataset.variable;
		var dayChooseWindow = document.querySelector(".time-window.js-window");
		if (dayChooseWindowFlag && dayChooseWindow){
			if (dayChooseWindowFlag != 0) {
				if (dayChooseWindow.classList.contains("no-display")){
					dayChooseWindow.classList.remove("no-display")
				};
			};
		};
	</script>                  
	<script src="http://glorymoscow.ru/js/loginWindow.js"></script>
    <script src="http://glorymoscow.ru/js/meetingDelete.js"></script>
	<script src="http://glorymoscow.ru/js/halfOfTheDay.js"></script>
	</body>
</html>
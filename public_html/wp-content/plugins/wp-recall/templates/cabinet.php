<?php global $rcl_options,$user_LK; ?>

<?php rcl_before(); ?>

<?php 
$host='localhost'; // имя хоста (уточняется у провайдера)
$database='sergeydons_worp1'; // имя базы данных, которую вы должны создать
$user='sergeydons_worp1'; // заданное вами имя пользователя, либо определенное провайдером
$pswd='evegiticif'; // заданный вами пароль

$dbh = mysql_connect($host, $user, $pswd) or die("Не могу соединиться с MySQL.");
mysql_select_db($database) or die("Не могу подключиться к базе.");

$user = get_current_user_id();
?>

<div id="rcl-<?php echo $user_LK; ?>" class="wprecallblock">
<div class="kabinet">
	<div class="lk-avatar">
		<?php echo get_avatar( $user, 160 ); ?>
		<h2><?php echo get_the_author_meta('display_name', $user); ?></h2>
	</div>
	<?php 
	$query = "SELECT COUNT(receiver_id) FROM meetings WHERE receiver_id=".$user." and meeting_status=1";
	$predl = mysql_query($query);
	$row = mysql_fetch_row($predl);
	echo 'Предложения мне(активные):&nbsp;<a class="vstrechi" href="#predl_act">'.$row[0].'</a><br>';
	?>
	<?php 
	$query = "SELECT COUNT(*) FROM `meetings` WHERE `receiver_id`=".$user." and `meeting_status`=2";
	$predl1 = mysql_query($query);
	$row = mysql_fetch_row($predl1);
	echo 'Предложения мне(принятые):&nbsp;<a class="vstrechi" href="#predl_prin">'.$row[0].'</a><br>';
	?>
	<?php 
	$query = "SELECT COUNT(*) FROM `meetings` WHERE `sender_id`=".$user." AND `meeting_status`=1";
	$act = mysql_query($query);
	$row = mysql_fetch_row($act);
	echo 'Мои предложения(активные):&nbsp;<a class="vstrechi" href="#moi_predl_act">'.$row[0].'</a><br>';
	?>
	<?php 
	$query = "SELECT COUNT(*) FROM `meetings` WHERE `sender_id`=".$user." AND `meeting_status`=2";
	$prin = mysql_query($query);
	$row = mysql_fetch_row($prin);
	echo 'Мои предложения(принятые):&nbsp;<a class="vstrechi" href="#moi_predl_prin">'.$row[0].'</a><br>';
	?>
	<?php 
	$query = "SELECT COUNT(*) FROM `meetings` WHERE (`sender_id`= ".$user." OR `receiver_id` = ".$user.") AND `meeting_status`=2";
	$prov = mysql_query($query);
	$row = mysql_fetch_row($prov);
	echo 'Проведено встреч:&nbsp;<a class="vstrechi" href="#prov_vstrech">'.$row[0].'</a><br>';
	?>
     	  
<div id="predl_act" class="modalDialog">
	<div>
		<a href="#close" title="Закрыть" class="close">X</a>
		<h2>Предложения мне(активные)</h2>
		<p>
			<?php
			$query = "SELECT `sender_id`, `meeting_date`, `meeting_time` FROM `meetings` WHERE `receiver_id`=".$user." and `meeting_status`=1";
			$res = mysql_query($query);
			while($row = mysql_fetch_array($res)) {
				echo '<div class="search_user">';
				echo get_avatar($row['sender_id'], 160 );
				echo '<br>';
				echo get_the_author_meta('display_name', $row['sender_id']);
				echo '<br>';
				echo 'Когда: '.$row['meeting_date'];
				echo '<br>';
				echo 'Во сколько: '.$row['meeting_time'];
				echo '<br>';
				echo '<input type="button" value="Принять приглашение">';
				echo '</div>';
			}
		?>
		</p>
	</div>
</div>

<div id="predl_prin" class="modalDialog">
	<div>
		<a href="#close" title="Закрыть" class="close">X</a>
		<h2>Предложения мне(принятые)</h2>
		<p>
			<?php
			$query = "SELECT `sender_id`, `meeting_date`, `meeting_time` FROM `meetings` WHERE `receiver_id`=".$user." and `meeting_status`=2";
			$res = mysql_query($query);
			while($row = mysql_fetch_array($res)) {
				echo '<div class="search_user">';
				echo get_avatar($row['sender_id'], 160 );
				echo '<br>';
				echo get_the_author_meta('display_name', $row['sender_id']);
				echo '<br>';
				echo 'Когда: '.$row['meeting_date'];
				echo '<br>';
				echo 'Во сколько: '.$row['meeting_time'];
				echo '<br>';
				echo '<input type="button" value="Принять приглашение">';
				echo '</div>';
			}
		?>
		</p>
	</div>
</div>

<div id="moi_predl_act" class="modalDialog">
	<div>
		<h2>Мои предложения(активные)</h2>
		<p>
			<?php
			$query = "SELECT `receiver_id`, `meeting_date`, `meeting_time`, `meeting_status` FROM `meetings` WHERE `sender_id`= ".$user." AND `meeting_status`=1";
			$res = mysql_query($query);
			while($row = mysql_fetch_array($res)) {
				echo '<div class="search_user">';
				echo get_avatar($row['sender_id'], 160 );
				echo '<br>';
				echo get_the_author_meta('display_name', $row['sender_id']);
				echo '<br>';
				echo 'Когда: '.$row['meeting_date'];
				echo '<br>';
				echo 'Во сколько: '.$row['meeting_time'];
				echo '<br>';
				echo '<input type="button" value="Принять приглашение">';
				echo '</div>';
			}
		?>
		</p>
	</div>
</div>

<div id="moi_predl_prin" class="modalDialog">
	<div>
		<h2>Мои предложения(принятые)</h2>
		<p>
			<?php
			$query = "SELECT `receiver_id`, `meeting_date`, `meeting_time`, `meeting_status` FROM `meetings` WHERE `sender_id`= ".$user." AND `meeting_status`=2";
			$res = mysql_query($query);
			while($row = mysql_fetch_array($res)) {
				echo '<div class="search_user">';
				echo get_avatar($row['sender_id'], 160 );
				echo '<br>';
				echo get_the_author_meta('display_name', $row['sender_id']);
				echo '<br>';
				echo 'Когда: '.$row['meeting_date'];
				echo '<br>';
				echo 'Во сколько: '.$row['meeting_time'];
				echo '</div>';
			}
		?>
		</p>	</div>
</div>

<div id="prov_vstrech" class="modalDialog">
	<div>
		<h2>Проведенные встречи</h2>
		<p>
			<?php
			$query = "SELECT `sender_id`, `receiver_id`, `meeting_date`, `meeting_time` FROM `meetings` WHERE (`sender_id`= ".$user." OR `receiver_id` = ".$user.") AND `meeting_status`=2";
			$res = mysql_query($query);
			while($row = mysql_fetch_array($res)) {
				echo '<div class="search_user">';
				echo get_avatar($row['sender_id'], 160 );
				echo '<br>';
				echo get_the_author_meta('display_name', $row['sender_id']);
				echo '<br>';
				echo 'Когда: '.$row['meeting_date'];
				echo '<br>';
				echo 'Во сколько: '.$row['meeting_time'];
				echo '</div>';
			}
		?>
		</p>
	</div>
</div>


</div>
<div class="kabinet">
    	<div id="rcl-tabs">
     	  <div id="lk-content" class="rcl-content">
      	      <?php rcl_tabs(); ?>
     	   </div>
   	 </div>
     </div>
<div class="kabinet">

<script src="http://glorymoscow.ru/js/moment.js"></script>
<div align=center>
Удобное время встреч
<div style="width:220px; border:1px solid #c0c0c0; padding:6px;">
<form name="calendar" method="POST">
<table id="calendar"  border="0" cellspacing="0" cellpadding="1">
  <thead>
    <tr><td><b>‹</b><td colspan="5"><td><b>›</b>
    <tr><td>Пн<td>Вт<td>Ср<td>Чт<td>Пт<td>Сб<td>Вс
  </thead>
  <tbody></tbody>
</table>
</form>
</div>
</div>


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
for (var j=0; j < events.length; j++) { events[j] = new Date(events[j]); }

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
    if(moment(now1).isSameOrBefore(this_day))
    {
        if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth())
        { 
            calendar += '<td class="today"><button class="btn-link" name ="day1" value="' + this_day + '">' + i + '</button>'; 
        }
        else
        {
            for (var k=0; k< events.length; k++) 
            { 
                if ( i == events[k].getDate() && D.getFullYear() == events[k].getFullYear() && D.getMonth() == events[k].getMonth() ) { m = 1;  } 
            } 
            if (m == 1 ) 
            { 
                calendar += '<td class="event"><button class="btn-link" name ="day1" value="' + this_day + '">' + i + '</button>'; 
            } 
            else 
            { 
                calendar += '<td><button class="btn-link" name ="day1" value="' + this_day + '">' + i + '</button>'; 
            }
        }
    }
    else 
    { 
        calendar += '<td>' + i; 
    }
        if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) { 
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
    
// переключатель минус месяц
document.querySelector('#calendar thead tr:nth-child(1) td:nth-child(1)').onclick = function() {
  calendar("calendar", document.querySelector('#calendar thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar thead td:nth-child(2)').dataset.month)-1);
}

// переключатель плюс месяц
document.querySelector('#calendar thead tr:nth-child(1) td:nth-child(3)').onclick = function() {
  calendar("calendar", document.querySelector('#calendar thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar thead td:nth-child(2)').dataset.month)+1);
}
</script>

<?php 
session_start();
if ( !isset($_SESSION['d']) ) { $_SESSION['d'] = date("Y-m-d"); }

if (isset($_POST['day1']))
{ $_SESSION['d'] = $_POST['day1']; }
echo $_SESSION['d'];

?>

<form name="time" method="POST">
<?php 

$query = "SELECT * FROM `time_book`";
$res = mysql_query($query);

$j=1;
$times=array();
while($row = mysql_fetch_array($res))
{
 $times['time_id'][$j] = $row['time_id'];
 $times['time_name'][$j] = $row['time_name'];
 $times['active'][$j] = 0;
 $j++;
}

$query = "SELECT time_id, time_name from events INNER join time_book on events.time_book_id = time_id WHERE user_id=".$user." and event_date = '".$_SESSION['d']."'";
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

$i=1;
echo '<div class="time_table">';
while ($i < 25)
{
	if ($i == 13) { echo '</div><div class="time_table">'; }
	if ($times['active'][$i] == 1) 
	{ echo '<input type="checkbox" id="times'.$i.'" name="'.$i.'" valuе="'.$times['time_id'][$i].'" checked /><label for="times'.$i.'"><span></span>'.$times['time_name'][$i].'</label><br>'; }
	else 
	{ echo '<input type="checkbox" id="times'.$i.'" name="'.$i.'" valuе="'.$times['time_id'][$i].'" /><label for="times'.$i.'"><span></span>'.$times['time_name'][$i].'</label><br>'; }
$i++;
}
echo '</div><br>';
?>

<input type="submit" id="submit" name="submit" value="Обновить">
</form>

<?php 
$submit=$_POST['submit']; 
if(isset($submit)) 
{
$i=1;
$query = "DELETE FROM `events` WHERE `user_id`= ".$user." and `event_date`='".$_SESSION['d']."'";
mysql_query($query);

while ($i < 25)
{
	if ( $_POST[$i] == "on")
	{
	$query = "INSERT INTO `events`(`user_id`, `event_date`, `time_book_id`) VALUES (".$user.",'".$_SESSION['d']."',".$i.")";
	mysql_query($query);
	}

$i++;
}
}
?>
 </div>
</div>

<?php rcl_after(); ?>
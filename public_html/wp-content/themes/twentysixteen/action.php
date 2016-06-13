<html>
<body>
<?php 
$hours = $_POST['time_hour'];
if (empty($hours))
{ echo 'блаблабла';}
else
{
	$i=0;
	while ($i < count($hours) )
{
       echo $hours[$i];
echo 'блаблабла';
	$query = "INSERT INTO `events`(`user_id`, `event_date`, `time_book_id`) VALUES (1,'2016-05-30',".$hours[$i].")";

	$i++;
}
}

?>
</body>
</html>
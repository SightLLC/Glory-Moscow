<?php
/*
Template Name: Login page
*/
get_header(); ?>

<body class="login">
    <div class="menu"> 
	<a class="logo" href="http://glorymoscow.ru">На главную</a>
        <ul>
            <li><a href="/znakomstva">Знакомства</a></li> 
            <li><a href="/about">О Glory Moscow</a></li>
            <li><a class="active" href="/login">Вход/Регистрация</a></li>  
        </ul>
    </div>
    
<?php
while ( have_posts() ) : the_post();
get_template_part( 'template-parts/content', 'page' );
endwhile;
?>

</body>
</html>
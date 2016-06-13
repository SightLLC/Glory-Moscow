<?php
/*
Template Name: Main page
*/
get_header(); ?>
<?php 
$user = get_current_user_id();
?>
<header class="main-header">
			<div class="container">
				<nav class="main-nav">
					<ul class="menu clearfix">
                        <?php if($user!=0) { echo '<li class="acquaintance"><a href="/znakomstva">Знакомства</a></li>'; } ?>
						<li class="about">
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
		<main class="container">
			<h1 class="site-title">
				Знакомства для анонимного, безопасного и доступного секса в Москве
			</h1>
			<form class="search">
				<a <?php if($user!=0) { echo 'href="/znakomstva" class="search-btn"'; } else { echo 'href="#" class="search-btn"'; } ?> >Найти партнера</a>
				<select name="i-want">
					<option value="">Я хочу</option>
					<option value="ass-fuck">Анал актив</option>
					<option value="ass-be-fucked">Анал пассив</option>
					<option value="suck">Орал актив</option>
					<option value="be-sucked">Орал пассив</option>
				</select>
				<select name="status">
					<option value="">Статус</option>
					<option value="new">Новые</option>
					<option value="old">Активные</option>
				</select>
			</form>
		</main>
		<div class="sign-up-window no-display js-window">
			<a class="close-window js-close-form-button" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
            <form action="" method="get" id="m_reg_user_form">
				<input type="text" value="Логин" data-name="Логин" name="m_user_name" id="m_user_name" class="user-info">
				<input type="text" value="Почта" data-name="Почта" name="m_user_email" id="m_user_email" class="user-info">
				<input type="submit" name="m_regiser_usr_btn" class="sign-up-btn" value="Регистрация">
            </form>
		</div>
		<div class="sign-in-window no-display js-window">
			<a class="close-window js-close-form-button" href="#">
				<div class="left-top"></div>
				<div class="right-top"></div>
			</a>
            <?php $current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
			<form action="<?php echo wp_login_url($current_url); ?>" id="loginForm" method="post">
				<input type="text" value="Логин" name="log" id="login" data-name="Логин" class="user-info">
				<input type="text" value="Пароль" name="pwd" id="pass" data-name="Пароль" class="user-info">
				<input type="submit" class="login-btn" value="Войти">
                <input type="hidden" value="$product_id" name="product_id">
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
	<script src="http://glorymoscow.ru/js/loginWindow.js"></script>
	<script src="http://glorymoscow.ru/js/signup.js"></script>
	</body>
</html>

			
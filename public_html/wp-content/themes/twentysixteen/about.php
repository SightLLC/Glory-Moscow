<?php
/*
Template Name: About page
*/
get_header(); ?>
<?php 
$user = get_current_user_id();
?>
<body class="about">
		<header class="main-header about">
			<div class="container">
				<nav class="main-nav">
					<ul class="menu clearfix">
						<li class="main">
							<a href="http://glorymoscow.ru">Главная</a>
						</li>
						<?php if($user!=0) { echo '<li class="acquaintance"><a href="/znakomstva">Знакомства</a></li>';} ?>
						<li class="about active">
							<a>О Glory Moscow</a>
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
		<div class="description">
			<p class="first">
				<b>Glory Hole</b> (от англ. glory – восторг; hole – дырка) – 
				отверстие в стене для анонимного сексуального контакта.
			</p>
			<p class="second">
			Партнеры находятся в соседних комнатах, разделенных перегородкой с дыркой, 
			и никак не пересекаются друг с другом ни до, ни после секса.
			</p>
		</div>
		<main class="about">
			<section class="advantages">
				<div class="container clearfix">
					<div class="advantage anonymous">
						<span class="advantage-item-title">Анонимность</span>
						<div class="advantage anonymous hover">
							<span>Не пересекайтесь с партнером ни до, ни после секса.
							Анонимное знакомство в Glory Moscow происходит 
							только с целью секса 
							без указания любых данных.</span>
						</div>
					</div>
					<div class="advantage health">
						<span class="advantage-item-title">Здоровье</span>
						<div class="advantage health hover">
							<span>
							В Moscow Glory - только защищенный секс (презервативы выдаются бесплатно), 
							физический барьер позволяет довести безопасность для здоровья до максимума.
							</span>
						</div>
					</div>
					<div class="advantage safety">
						<span class="advantage-item-title">Безопасность</span>
						<div class="advantage safety hover">
							<span>
							Разделенные стеной в Glory Moscow партнеры контактируют при помощи рта и гениталий только через небольшое отверстие на уровне пояса. Это 
							позволяет Вам полностью 
							контролировать процесс.
							</span>
						</div>
					</div>
					<div class="advantage money">
						<span class="advantage-item-title">Затраты</span>
						<div class="advantage money hover">
							<span>
							Удовлетворяйте свои сексуальные потребности без лишней траты времени и средств на ненужные знакомства. В Glory Moscow Вы 
							анонимно найдете лучшего 
							партнера согласно Вашим 
							предпочтениям, сведя к минимуму усилия в поиске Вашего идеала. 
							</span>
						</div>
					</div>
					<div class="advantage fantasy">
						<span class="advantage-item-title">Фантазии</span>
						<div class="advantage fantasy hover">
							<span>
							Вы и ваш партнер не видите друг друга, что позволяет Вам представлять
							что угодно и кого угодно по ту сторону стены.
							Реализуйте в Glory Moscow свои самые невероятные фантазии.
							</span>
						</div>
					</div>
					<div class="advantage sex">
						<span class="advantage-item-title">Оргазм</span>
						<div class="advantage sex hover">
							<span>
							Получите максимальные 
							ощущения от полового контакта в Glory Moscow, не отвлекаясь на 
							посторонние факторы. Сделайте все так, как хотите именно Вы и попробуйте что-то новое, без 
							смущения от критического взгляда партнера.
							</span>
						</div>
					</div>					
				</div>
			</section>
			<section class="special-offers">
				<div class="container clearfix">
					<div class="offers-title">
						Акции
					</div>
					<div class="offer-item friend">
						<div class="offer-hover">
							<p>Приведи друга</p>
							<p>
								Получите скидку 40% в Glory Moscow, если 
								пользователь упомянет Ваш никнейм.
							</p>
						</div>
					</div>
					<div class="offer-item amount">
						<div class="offer-hover">
							<p>Больше посещений, <br>больше скидка</p>
							<p>
								Посетите Glory Moscow 2 раза в течение месяца и получите скидку 20%,
								3 раза – 30%, 4 раза – 40%, 5 и более раз – 50%
							</p>
						</div>
					</div>
					<div class="offer-item vip">
						<div class="offer-hover">
							<p>VIP-карта на 2 месяца</p>
							<p>
								Каждый 30-й в Glory Moscow бесплатно получает VIP-карту на неограниченное посещения в течение 2 месяцев.
								Также можно приобрести VIP-карту за 15 000 рублей.
							</p>
						</div>
					</div>
				</div>
			</section>
			<section class="rules">
				<div class="container clearfix">
					<div class="rules-title">
						Правила
					</div>
					<div class="rule-item">
						<span>Презервативы</span>
						<div class="rule-hover">
							В Glory Moscow - только защищенный секс с качественными презервативами,
							которые бесплатно выдаются на входе. В Glory Moscow Вы можете получить
							желаемое без волнений о безопасности.
						</div>
					</div>
					<div class="rule-item">
						<span>Законность и добровольность</span>
						<div class="rule-hover">
							Glory Moscow не предоставляет секс-услуги и действует в рамках законов РФ.
							Вы контактируете на добровольной основе по взаимному согласию,
							исключая любые формы финансово-денежных отношений.
							Вход строго 18+. 
						</div>
					</div>
					<div class="rule-item">
						<span>Фото- и видеосъемка</span>
						<div class="rule-hover">
							Фото и видеосъемка в Glory Moscow запрещены.
						</div>
					</div>
				</div>
			</section>
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
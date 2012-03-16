<!-- Simple OpenID Selector -->
<form action="examples/consumer/try_auth.php" method="get" id="openid_form">
    <input type="hidden" name="action" value="verify" />

    <fieldset>
	<legend>Войти или создать новый аккаунт</legend>

	<div id="openid_choice">
	    <p>Пожайлуста, выберите вашего аккаунт-провайдера:</p>
	    <div id="openid_btns">&nbsp;</div>
	</div>
	<div id="openid_input_area">
	    <input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
	    <input id="openid_submit" type="submit" value="Войти"/>
	</div>
	<noscript>
	    <p>OpenID это сервис который позволяет вам входить в разные веб-сайты пользуясь одной учетной записью.
			Узнайте <a href="http://openid.net/what/">больше о OpenID</a> и <a href="http://openid.net/get/">как получить OpenID аккаунт</a>.</p>
	</noscript>
    </fieldset>

</form>
<!-- /Simple OpenID Selector -->

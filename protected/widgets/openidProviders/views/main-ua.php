<!-- Simple OpenID Selector -->
<form action="examples/consumer/try_auth.php" method="get" id="openid_form">
    <input type="hidden" name="action" value="verify" />

    <fieldset>
	<legend>Увійти або створити новий акаунт</legend>

	<div id="openid_choice">
	    <p>Будь-ласка, виберіть вашого акаунт-провайдера:</p>

	    <div id="openid_btns">&nbsp;</div>
	</div>

	<div id="openid_input_area">
	    <input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
	    <input id="openid_submit" type="submit" value="Увійти"/>
	</div>
	<noscript>
	    <p>OpenID це сервіс який дозволяє вам входити в разні веб-сайти користуючись одним обліковим записом.
			Взнайте <a href="http://openid.net/what/">більше про OpenID</a> та <a href="http://openid.net/get/">як отримати OpenID акаунт</a>.</p>
	</noscript>
    </fieldset>

</form>
<!-- /Simple OpenID Selector -->


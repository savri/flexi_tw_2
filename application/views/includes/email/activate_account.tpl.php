<html>
<body>
	<h1>Activate account for <?php echo $identity;?></h1>
	<p>You login name and default password are the same - <?php echo $identity;?>. 
	Be sure to reset your password to a more secure one when you activate your account<p>
	<p>Please click this link to <?php echo anchor('/testwell/testwell/activate_account/'. $user_id .'/'. $activation_token, 'activate your account');?>.</p>
</body>
</html>
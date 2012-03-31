<h2>Welcome to <?php echo $WebsiteName; ?>!</h2>

<p>Thank you for your registration. You are almost ready to login. I just need to confirm that you are the one making the request.</p>

<?php if(isset($link)): ?>
<p>To confirm your registration, please click on the following link:</p>

<p><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>

<p>If it is not clickable, just copy and paste it into the browser.</p>
<?php endif; ?>

<p>Thanks Again,<br>
<?php echo $site; ?></p>

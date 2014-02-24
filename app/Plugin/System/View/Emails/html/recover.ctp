<h3>Hello <?php echo $username; ?>. We've received a recovery password request.</h3>
<p>If this wasn't sent by you. Please, desconsider this email.</p>
<p><strong><?php echo $this->Html->link("click here", $recoverLink . "?get=&token=" . $token); ?></strong> to choose your new password:</p>
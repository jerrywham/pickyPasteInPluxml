<?php 
	$LANG = array(
		'L_TITLE'=>'pickyPasteInPluxml',
		'L_DESCRIPTION'=>'PickyPaste dans Pluxml',
		'L_DATE_FORMAT_SHORT' => 'm-d-Y \a\t H:i',
		'L_DATE_FORMAT_LONG' => 'M d \'Y \a\t H:i'
		'L_5MIN' => '5 minutes',
		'L_10MIN' => '10 minutes',
		'L_1HOUR' => '1 hour',
		'L_1DAY' => '1 day',
		'L_1WEEK' => '1 week',
		'L_1MONTH' => '1 month',
		'L_1YEAR' =>'1 year',
		'L_NEVER' =>'Never',
		'L_RECIPIENT' => 'Recipient',
		'L_EMAIL_ADDRESS' => 'Email address',
		'L_YOUR_EMAIL' => 'Your email',
		'L_OPTIONAL'  => 'Optional',
		'L_ANSWERABLE'  => 'So you can answered',
		'L_EXPIRATION'=> 'Expiration',
		'L_BURN_AFTER_READING' => 'Burn after reading',
		'L_BAR_EXPLANATIONS' => 'Message is destroyed after reading',
		'L_YOUR_MESSAGE'=> 'Your message',
		'L_WILL_EXPIRE_ON' => 'This paste will expire on %s',
		'L_WILL_EXPIRE_ON_SHORT' => 'Expires on %s',
		'L_ANONYMOUS'  => 'Anonymous',
		'L_SECURE_MSG' => 'Secure message ',
		'L_FROM' => 'from ',
		'L_BURN_AFTER_READING_MSG' => 'This is a <strong>burn-after-reading</strong> message. It means it can be open once only.<br />
		Thus, if you desire being able to read it again, don\'t forget to save it manually one way or another.<br /><br />
		<strong>Be warned,</strong> if you can\'t open this message altough it isn\'t supposed to be expired yet (check the expiration date above, if there\'s one) then please consider the following:
		<ol>
		    <li>May have you already opened this message (or someone else having access to your inbox)? In which case, you are not meant being able to open it again.</li>
		    <li>Else, and if the message wasn\'t supposed to be expired, this could mean that the network you are currently using might be <strong>corrupted</strong>!! Be careful!!<br />
		    Thanks to warn us if it keeps hapening and don\'t forget to precise us which webmail you and your recipient were using when it happened. <a href="http://www.olissea.com/contact.php">Contact me</a> (Don\'t forget to include the context) (Abuse is punishable)</li>
		</ol><br />',
		'L_MAIL_CONTENT' => 'Hello,<br /><br />
You have received a message from <strong>%1$s</strong>.<br /><br />
In order to protect your privacy, this message has been encrypted using <a href="http://www.olissea.com/PP/PP.php">PickyPaste</a> (service facilitating the sending of secured messages via <a href="http://sebsauvage.net/paste/">Zerobin</a>).<br /><br />
To read this message, please click on this link : <br/>
<a href="%2$s">%2$s</a><br/><br/>
%3$s<br/>
%4$s<br/>
%5$s<br/>
<strong>Note:</strong> All the applications used to encrypt this message or transmit it, are open-sources applications: It means you don\'t have to give us your trust blindly, you can check how it works step by step or even implementing your own instances of it.',
		'L_REPLY_TO' => '(<a href="%1$s&mail=%2$s">Reply using PickyPaste</a>',
		'L_DIRECT_LINK' => 'Direct link to your paste',

		'L_DIRECT_LINK_INHIBITED'  => 'Since your paste is set to be read only once, opening it would equal to delete it.',
		'L_DELETE_LINK'=> 'Link to delete your message manually',
		'L_MAIL_SEND_SUCCESSFULLY' => 'Mail send successfully !<br /><br />You can close this window.<br /><br />',
		'L_ERROR'  => 'Error!!',

		'L_PHP_VERSION_TOO_LOW' => 'PickyPaste requires at least PHP %s',
		'L_DECRYPTING_KEY_MISSING' => 'The decrypting key is missing!!',

		'L_RECIPIENT_MISSING' => 'You have to specify the recipient!!',
		'L_INVALID_ZEROBIN_ADDR'=> 'Invalid Zerobin\'s address!!',
		'L_ZEROBIN_SERV_NOT_ANSWERING' => 'Zerobin Server isn\'t answering!!<br /><br />Please try again later or choose another one if it keeps failing.',
		'L_PASTE_NOT_CREATED_ZEROBIN_SERV_UNHAPPY'  => 'Failed to create your paste!! (Protocol error with the Zerobin server)',
		'L_PASTE_NOT_CREATED_ERROR' => 'Failed to create your paste: %s',
		'L_INVALID_RECIPIENT' =>  'One or more of the recipients is invalid!',
		'L_EMAIL_DELIVERY_FAILED'  => 'The email failed to be delivered!!<br /><br />Here is the direct link to your paste: <a href="%s">%s</a> (Manual procedure: right click on the link, Copy Link Location then paste it in your email)',
		'L_JAVASCRIPT_DISABLED' => '/!\ Your JavaScript seems disabled, DON\'T USE THIS APPLICATION. It\'s not secured without JavaScript /!',
	);
?>
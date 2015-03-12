<?php 
	$LANG = array(
		'L_TITLE'=>'pickyPasteInPluxml',
		'L_DESCRIPTION'=>'PickyPaste dans Pluxml',
		# Dates
		'L_DATE_FORMAT_SHORT' => 'd/m/Y à H\hi',
		'L_DATE_FORMAT_LONG' => 'd M Y à H\hi',
		'L_5MIN' => '5 minutes',
		'L_10MIN' => '10 minutes',
		'L_1HOUR' => '1 heure',
		'L_1DAY' => '1 jour',
		'L_1WEEK' => '1 semaine',
		'L_1MONTH' => '1 mois',
		'L_1YEAR' => '1 ans',
		'L_NEVER' => 'Jamais',

		# Params
		'L_RECIPIENT' => 'Destinataire',
		'L_EMAIL_ADDRESS' => 'Adresse email',
		'L_YOUR_EMAIL' => 'Votre email',
		'L_OPTIONAL'  => 'Facultatif',
		'L_ANSWERABLE'  => 'Pour qu\'on puisse vous répondre',

		# Durée lectutre
		'L_EXPIRATION'=>'Expiration',
		'L_BURN_AFTER_READING' => 'Lecture unique',
		'L_BAR_EXPLANATIONS' => 'Le message est détruit après lecture',
		'L_YOUR_MESSAGE'=> 'Votre message',
		'L_WILL_EXPIRE_ON' => 'Ce message expirera le %s',
		'L_WILL_EXPIRE_ON_SHORT' => 'Expire le %s',

		# Mail
		'L_ANONYMOUS'  => 'Anonyme',
		'L_SECURE_MSG' => 'Message sécurisé ',
		'L_FROM' => 'de ',

		# Messages généraux
		'L_BURN_AFTER_READING_MSG' => 'Ce message est à <strong>lecture unique</strong>. Ce qui signifie que vous ne pourrez l\'ouvrir qu\'une seule fois.<br />
		Par conséquent, si vous voulez pouvoir revoir son contenu, n\'oubliez pas de le sauvegarder manuellement d\'une façon ou d\'une autre.<br /><br />
		<strong>Attention,</strong> si vous ne parvenez pas à ouvrir ce message alors qu\'il n\'est pas censé être déjà expiré (voir date d\'expiration ci dessus, s\'il en avait une), veuillez considérez ce qui suit :
		<ol>
		<li>Se peut-il que vous ayez déjà ouvert ce message (ou quelqu\'un d\'autre ayant accès à votre messagerie) ? Dans ce cas, vous n\'êtes pas censé pouvoir le réouvrir.</li>
		<li>Le cas échéant, et si le message n\'était pas censé être expiré, cela peut vouloir dire que le réseau que vous utilisez actuellement est <strong>corrompu</strong> !!<br />
		Merci de nous prévenir si cela vous arrive en nous précisant quel service mail vous utilisez et si cela s\'est déjà produit auparavant. <a href="http://www.olissea.com/contact.php">Me contacter</a> (N\'oubliez pas de préciser le motif !!) (Tout abus est punissable)</li>
		</ol><br />',
		'L_MAIL_CONTENT' => 'Bonjour/soir,<br /><br />
Vous avez reçu un message de la part de <strong>%1$s</strong>.<br /><br />
Afin de protéger votre vie privée, le message en question a été chiffré via <a href="http://www.olissea.com/PP/PP.php">PickyPaste</a> (service facilitant l\'envoi de mail sécurisé via <a href="http://sebsauvage.net/paste/">Zerobin</a>).<br /><br />
Pour visionner le message, merci de cliquer sur ce lien : <br/>
<a href="%2$s">%2$s</a><br/><br/>
%3$s<br/>
%4$s<br/>
%5$s<br/>
<strong>Note :</strong> Toutes les applications et intermédiaires utilisés pour chiffrer et transmettre ce message sont des applications open-sources : Rien ne vous oblige à avoir confiance en nos applications naïvement, vous pouvez vérifier leur fonctionnement en détail ou même implémenter vos propres instances.',

		# Réponse
		'L_REPLY_TO' => '(<a href="%1$s&mail=%2$s">Répondre via PickyPaste</a>)',
		'L_DIRECT_LINK' => 'Lien direct vers votre paste',
		'L_DIRECT_LINK_INHIBITED'  => 'Étant donné que votre paste est en lecture unique, l\'ouvrir équivaudrait à le supprimer.',
		'L_DELETE_LINK'=> 'Lien pour détruire votre message manuellement',
		'L_MAIL_SEND_SUCCESSFULLY' => 'Mail envoyé avec succès !<br /><br />Vous pouvez dès à présent fermer cette page.<br /><br />',

		# Erreurs
		'L_ERROR'  => 'Erreur !!',
		'L_PHP_VERSION_TOO_LOW' => 'PickyPaste nécessite au moins PHP %s',
		'L_DECRYPTING_KEY_MISSING' => 'La clé de décryptage n\'a pas été reçue !!',
		'L_RECIPIENT_MISSING' => 'Vous devez spécifiez un destinataire !!',
		'L_INVALID_ZEROBIN_ADDR'=> 'Adresse du serveur Zerobin invalide !!',
		'L_ZEROBIN_SERV_NOT_ANSWERING' => 'Serveur Zerobin injoignable !!<br /><br />Veuillez réessayer plus tard ou en choisir un autre le cas échéant.',
		'L_PASTE_NOT_CREATED_ZEROBIN_SERV_UNHAPPY'  => 'Impossible de créer votre past !! (Erreur de protocole avec le serveur Zerobin)',
		'L_PASTE_NOT_CREATED_ERROR' => 'Impossible de créer votre past : %s',
		'L_INVALID_RECIPIENT' => 'Un ou plusieurs des destinataire est invalide !',
		'L_EMAIL_DELIVERY_FAILED'  => 'L\'envoi du mail a échoué !!<br /><br />Voici le lien vers votre paste <a href="%s">%s</a> (Procédure manuelle : clic droit sur le lien, copiez l\'adresse du lien puis collez là dans votre email)',
		'L_JAVASCRIPT_DISABLED' => '/!\ Votre JavaScript semble désactivé, N\'UTILISEZ PAS CETTE APPLICATION. Ce n\'est pas sécurisé sans JavaScript /!\ ',
	);
?>
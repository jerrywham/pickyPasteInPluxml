<?php
/**
 * Plugin pickyPasteInPluxml
 *
 *    based on PickyPaste 1.0
 *    > For Picky People (aka I want it robust AND easy-to-use)
 *
 *    @author: JeromeJ (webmaster of http://www.olissea.com/ )
 *    @licence: DoWhatTheFuckYouWantAsLongAsYouGiveMeSomeCredits(Plz)
 *
 *    Based on Zerobin's encryption code
 *
 *    NOTE: - Best used with the snippet
 *           - Best used in offline-mode
 *
 *    DESIGN BY iamyog and nabellaleen
 *
 *    TODO:
 *    - Allow multiple recipient?
 *    - Create a local version of the HTML client, configurable through an optionnal external config file (an .ini file ?)
 *    - Create two versions: A standalone PHP and a client/server version.
 *        -> The client/server version could simple have a client sending data to the standalone PHP version.
 *       -> Additionnaly, for the people who DONT want people being able to use the standalone PHP version, there could be a light PHP version (no form, only the 'mailServer')
 *    - What if they don't want to send it by email? Wouldn't it be easier for them if they had only one tool to use? -> Make it modulable!
 *
 *   ################### CONFIG ####################################
*/
	error_reporting(-1);
	mb_internal_encoding('UTF-8');

	#### HAMMER TIME: Don't edit what's below except if you know what you're doing! #######

	################# ACTUAL CODE ##################################

	# 5.2: filter_var, DateTime class 
	define('PP_REQUIRED_PHP_VERSION', '5.2.0');

	# 5.3: namespaces
	# define('PP_REQUIRED_PHP_VERSION', '5.3.0'); # I'd like to eventually switch to 5.3, be warned.
/**
 *
 * @version	1.1
 * @date	21/05/2014
 * @author	Cyril MAGUIRE
 **/
class pickyPasteInPluxml extends plxPlugin {

	public $months = array(
	    'fr' => array(1 => 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'),
	    'en' => array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
	);

	public function __construct($default_lang) {
		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);

		# limite l'accès à l'écran d'administration du plugin
		# PROFIL_ADMIN , PROFIL_MANAGER , PROFIL_MODERATOR , PROFIL_EDITOR , PROFIL_WRITER
		$this->setConfigProfil(PROFIL_ADMIN);
		
		# Déclaration d'un hook (existant ou nouveau)
		$this->addHook('plxShowConstruct', 'plxShowConstruct');
		$this->addHook('plxMotorPreChauffageBegin', 'plxMotorPreChauffageBegin');
		$this->addHook('plxShowStaticContent', 'PP_msg');
		$this->addHook('plxShowStaticListEnd', 'plxShowStaticListEnd');
		$this->addHook('ThemeEndHead', 'ThemeEndHead');
		
	}

	# Activation / désactivation
	public function OnActivate() {
		if(version_compare(PHP_VERSION, PP_REQUIRED_PHP_VERSION) < 0) exit(sprintf($this->getLang('L_PHP_VERSION_TOO_LOW'), PP_REQUIRED_PHP_VERSION));
		if (!is_file(PLX_ROOT.'data/configuration/plugins/pickypaste.site.css')) {
			$css = file_get_contents(PLX_PLUGINS.'pickyPasteInPluxml/css/pickypaste.css');
			plxUtils::write($css, PLX_ROOT.'data/configuration/plugins/pickyPasteInPluxml.site.css');
		}
	}
	public function OnDeactivate() {
		# code à exécuter à la désactivation du plugin
	}
	
	# HOOKS
	
	public function PP_htmlspecialchars($str)
	{
	    # Sometimes htmlspecialschars seems to return an empty string, let's implement it ourselve. (Only the default behavior as we only use this one)
	    
	    return str_replace(array('&', '<', '>', '"'), array('&amp;', '&lt;', '&gt;', '&quot;'), $str);
	}

	public function plxShowConstruct() {

		# infos sur la page statique
		$string  = "
		if(\$this->plxMotor->mode=='pickypaste') {
			\$array = array();
			\$array[\$this->plxMotor->cible] = array(
				'name'		=> '',
				'menu'		=> '',
				'url'		=> 'pickyPaste',
				'readable'	=> 1,
				'active'	=> 1,
				'group'		=> ''
			);
			\$this->plxMotor->aStats = array_merge(\$this->plxMotor->aStats, \$array);
		}";
		echo "<?php ".$string." ?>";
	}
	public function plxShowStaticListEnd() {
		# ajout du menu PickyPaste dans la barre des menus
		echo "<?php \$class = preg_match('/^pickypaste/',\$this->plxMotor->mode)?'active':'noactive'; ?>";
		echo "<?php array_splice(\$menus, ".($this->getParam('mnuPos')-1).", 0, '<li><a id=\"link_pickypaste\" class=\"'.\$class.'\" href=\"'.\$this->plxMotor->urlRewrite('?pickypaste').'\">".$this->getParam('mnuName')."</a></li>'); ?>";
	}

	 public function plxMotorPreChauffageBegin() {
    	
		$string = <<<EOF

		\$plxPlugin = \$this->plxPlugins->getInstance('pickyPasteInPluxml');
		if (!empty(\$_POST) && !isset(\$_POST['to']) && \$plxPlugin->getParam('cryptMyPluxml') == 1) {
			\$this->plxPlugins->getInstance('cryptMyPluxml')->Prepend();
			return true;
		}
		if(!empty(\$_POST) || (isset(\$_POST['to']) && \$plxPlugin->getParam('cryptMyPluxml') == 1) ) {

		    if(!isset(\$_POST['randomkey'])) {\$plxPlugin->PP_msg('L_DECRYPTING_KEY_MISSING',true);}
		    if(!isset(\$_POST['to'])) {

		        \$plxPlugin->PP_msg('L_RECIPIENT_MISSING',true);

		    } else {

		        \$_POST['to'] = preg_split('#[,;]#', \$_POST['to']);
		        foreach(\$_POST['to'] AS \$k => \$email) {
		            if(trim(\$email) === ''){
		                unset(\$_POST['to'][\$k]);
		            } elseif (!preg_match('#^\s*(?:[^<]*<[^>]+>|[^@\s]+@[^.]+\.[^,;]+)\s*\$#', \$email)) {
		                \$plxPlugin->PP_msg('L_INVALID_RECIPIENT',true);
		            }
		        }

		        \$nb_recipients = count(\$_POST['to']);

		        \$_POST['to'] = implode(', ', \$_POST['to']);
		        
		    }
		    
		    if(isset(\$_POST['from']) && \$_POST['from']) {
		        \$from = \$plxPlugin->PP_htmlspecialchars(\$_POST['from']);
		    }else {
		        \$from = \$plxPlugin->getLang('L_ANONYMOUS');
		    }
		    
		    \$zerobinServer = (isset(\$_POST['zerobinServer']) ? \$_POST['zerobinServer']:\$this->urlRewrite().'plugins/pickyPasteInPluxml/ZeroBin/');
		    
		    \$data = array('data', 'expire', 'burnafterreading', 'opendiscussion', 'syntaxcoloring');
		    
		    \$postdata = array();
		    foreach(\$data AS \$k) { if(isset(\$_POST[\$k])) { \$postdata[\$k] = \$_POST[\$k]; } }
		    
		    if(isset(\$postdata['data'])) { \$postdata['data'] = str_replace('\\\\', '', \$postdata['data']); }
		    
		    \$opts = array('http' =>
		        array(
		            'method'  => 'POST',
		            'header'  => 'Content-type: application/x-www-form-urlencoded',
		            'content' => http_build_query(\$postdata)
		        )
		    );
		    
		    \$context = stream_context_create(\$opts);
		    
		    set_error_handler(function(\$errno, \$errstr){throw new Exception(\$errno);});
		    
		    try
		    {
		        if(!filter_var(\$zerobinServer, FILTER_VALIDATE_URL)) throw new Exception('BAD URL');
		        
		        \$result = file_get_contents(\$zerobinServer, false, \$context);

		    }
		    catch(Exception \$e)
		    {
		        if(\$e->getMessage() == 'BAD URL') \$plxPlugin->PP_msg('L_INVALID_ZEROBIN_ADDR',true);
		        else \$plxPlugin->PP_msg('L_ZEROBIN_SERV_NOT_ANSWERING',true);
		        
		        restore_error_handler();
		        
		        exit();
		    }
		    
		    restore_error_handler();
		    
		    \$result = json_decode(\$result, true);
		    
		    if(\$result === null || !isset(\$result['status']) || (\$result['status'] == 1 && !isset(\$result['message'])) || \$result['status'] != 0 || !isset(\$result['id']) || !is_string(\$result['id']) ) {

		        \$plxPlugin->PP_msg('L_PASTE_NOT_CREATED_ZEROBIN_SERV_UNHAPPY',true);
		    }
		     
		    
		    if(\$result['status'] == 1) {
		        exit(\$plxPlugin->PP_msg(sprintf(\$plxPlugin->getLang('L_PASTE_NOT_CREATED_ERROR'), \$plxPlugin->PP_htmlspecialchars(\$result['message']) ),true));
		    }
		    
		    \$expirationTable = array(
		        '5min'    => '+5 min',
		        '10min'    => '+10 min',
		        '1hour'    => '+1 hour',
		        '1day'    => '+1 day',
		        '1week'    => '+7 day', # To match how Zerobin works
		        '1month'=> '+30 day', # To match how Zerobin works
		        '1year'    => '+365 day', # To match how Zerobin works
		    );
		    
		    \$expiration = new DateTime();
		    
		    \$expire = (isset(\$_POST['expire']) ? \$_POST['expire']:'1month');
		    
		    if(\$expire == 'never') {
		        \$expiration = '';
		    } else {
		        if(isset(\$expirationTable[\$expire])) {
		            \$expiration->modify(\$expirationTable[\$expire]);
		        } else {
		            \$expiration->modify(\$expirationTable['1month']);
		        }
		        
		        \$date = \$expiration;
		        
		        \$expiration = sprintf(\$plxPlugin->getLang('L_WILL_EXPIRE_ON'),
		        		str_replace(\$plxPlugin->months['en'],
		        					 \$plxPlugin->months['fr'], 
		        					 \$date->format(\$plxPlugin->getLang('L_DATE_FORMAT_LONG') )
		        					)
				);

		        \$expiration_abbr = sprintf(\$plxPlugin->getLang('L_WILL_EXPIRE_ON_SHORT'),
		        		\$date->format(\$plxPlugin->getLang('L_DATE_FORMAT_SHORT') )
		        );
		        
		        \$expiration .= '<br />';
		    }
		    
		    if (isset(\$_POST['burnafterreading']) && \$_POST['burnafterreading'] == '1') {
		        \$burnafterreading = \$plxPlugin->getLang('L_BURN_AFTER_READING');
		    } else {
		        \$burnafterreading = '';
		    }
		    if (\$plxPlugin->getParam('cryptMyPluxml') == 1) {
		    	\$link = \$plxPlugin->PP_htmlspecialchars(\$this->urlRewrite('?zb/')).\$plxPlugin->PP_htmlspecialchars(\$result['id']).'#'.\$plxPlugin->PP_htmlspecialchars(\$_POST['randomkey']);
		    } else {
		    	\$link = \$plxPlugin->PP_htmlspecialchars(\$zerobinServer).'?'.\$plxPlugin->PP_htmlspecialchars(\$result['id']).'#'.\$plxPlugin->PP_htmlspecialchars(\$_POST['randomkey']);
		    }

		    \$reply = (\$from == \$plxPlugin->getLang('L_ANONYMOUS') || strpos(\$from, '@') === false ? '':
		    			sprintf(\$plxPlugin->getLang('L_REPLY_TO'), 
		    				\$this->urlRewrite('?pickypaste'), 
		    				\$plxPlugin->PP_htmlspecialchars(\$from) 
		    			) 
			);
		    
		    \$mailContent = sprintf(\$plxPlugin->getLang('L_MAIL_CONTENT'), \$from, \$link, \$expiration, \$burnafterreading, \$reply);

		    # Used this technic to get the title to be displayed in UTF-8 as well: http://bitprison.net/php_mail_utf-8_subject_and_message
		    if(!mail(\$_POST['to'],
		        '=?UTF-8?B?'.base64_encode(\$plxPlugin->getLang('L_SECURE_MSG').(\$from == \$plxPlugin->getLang('L_ANONYMOUS') ? \$plxPlugin->getLang('L_ANONYMOUS'):\$plxPlugin->getLang('L_FROM').\$plxPlugin->PP_htmlspecialchars(\$from)).' #'.substr(\$plxPlugin->PP_htmlspecialchars(\$result['id']), 0, 5).(\$expiration ? ' ('.\$expiration_abbr.')':'')).'?=',
		        \$mailContent,
		        "From: PickyPaste<no-reply@".(preg_replace('#^www\.#', '', \$_SERVER['SERVER_NAME'])).">\r\n".
		        "Content-type: text/html; charset=utf-8".
		        (filter_var(\$from, FILTER_VALIDATE_EMAIL) ? "\r\nReply-To: ".\$from:'')))
		    {
		        exit(\$plxPlugin->PP_msg(sprintf(\$plxPlugin->getLang('L_EMAIL_DELIVERY_FAILED'),\$link),true)); 
		    }
		    
		    \$output = \$plxPlugin->getLang('L_MAIL_SEND_SUCCESSFULLY');
		            
		            if(\$burnafterreading) \$output .= '<del>';
		            
		            \$output .= '(<a href="'.\$plxPlugin->PP_htmlspecialchars(\$link).'" onclick="window.open(this.href);return false;">'.\$plxPlugin->getLang('L_DIRECT_LINK').'</a>)';
		        
		        if(\$burnafterreading) \$output .= '</del> -> <em>'.\$plxPlugin->getLang('L_DIRECT_LINK_INHIBITED').'</em>';
		            
		        \$output .= '<br />'.
		            
		            (isset(\$result['deletetoken']) ? '(<a href="'.\$plxPlugin->PP_htmlspecialchars(\$zerobinServer).'?pasteid='.\$result['id'].'&deletetoken='.\$result['deletetoken'].'" onclick="window.open(this.href);return false;">'.\$plxPlugin->getLang('L_DELETE_LINK').'</a>)':'');

		    \$plxPlugin->PP_msg(\$output,true,'');     
		
		}

		if(\$this->get && preg_match('/^pickypaste\/?/i',\$this->get)) {
			\$this->mode = 'pickypaste';
			\$this->cible = '../../plugins/pickyPasteInPluxml/form';
			\$this->template = 'static.php';
			return true;
		}
EOF;
		echo "<?php ".$string." ?>";
	}  

	public function ThemeEndHead() {
		echo '
		<?php if($plxMotor->mode == "pickypaste") {?>
	        <meta charset="UTF-8">
	        <script src="'.PLX_PLUGINS.'pickyPasteInPluxml/js/sjcl.js"></script>
	        <script src="'.PLX_PLUGINS.'pickyPasteInPluxml/js/base64.js"></script>
	        <script src="'.PLX_PLUGINS.'pickyPasteInPluxml/js/rawdeflate.js"></script>
	        <script src="'.PLX_PLUGINS.'pickyPasteInPluxml/js/pickypaste.js"></script>
	    <?php }?>';
	}

	public function PP_msg($msg, $exit=false,$status = 'error') {
		if (!empty($msg)) {
			if (!isset($plxMotor)) {
				$plxMotor = plxMotor::getInstance();
			}
			if (!isset($plxShow)) {
				$plxShow = plxShow::getInstance();
			}
			# Traitements du thème
			if($plxMotor->style == '' or !is_dir(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style)) {
				header('Content-Type: text/plain');
				echo ($status == 'error' ? '<span class="error">'.$this->getLang($msg).'</span>' : $this->getLang($msg));
			} elseif(file_exists(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template)) {
				# On impose le charset
				header('Content-Type: text/html; charset='.PLX_CHARSET);
				# Insertion du template
				include(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template.'header.php'); ?>

				<section>

					<div id="container">

						<div class="width-sidebar">

							<article role="article" id="static-page-<?php echo $plxShow->staticId(); ?>">

								<header>
									<h1>
										<?php echo 'PickyPaste '.($status == 'error' ? '- '.$this->getLang('L_ERROR') : ''); ?>
									</h1>
								</header>

								<section>
									<?php echo ($status == 'error' ? '<span class="error">'.$this->getLang($msg).'</span>' : $this->getLang($msg)); ?>
								</section>

							</article>

						</div>

						<?php if ($this->getParam('sidebar') == 1) {
							include(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template.'sidebar.php'); 
						} ?>

					</div>

				</section>

				<?php include(PLX_ROOT.$plxMotor->aConf['racine_themes'].$plxMotor->style.'/'.$plxMotor->template.'footer.php'); 
			} else {
				header('Content-Type: text/plain');
				echo ($status == 'error' ? '<span class="error">'.$this->getLang($msg).'</span>' : $this->getLang($msg));
			}
		}
			
   		if($exit) exit;
	}
}

?>

<?php if(!defined('PLX_ROOT')) exit;
if (!isset($plxMotor)) {
    $plxMotor = plxMotor::getInstance();
}
$plxPlugin = $plxMotor->plxPlugins->getInstance('pickyPasteInPluxml');

?>
<div id="PickyWrapper">
<h1 id="title">
       
    <script type="text/javascript">
        var texts = {
            'fr': 'Attention, vous allez fermer la page actuelle avec un message entamé\n\nÊtes-vous sûr ?',
            'en': 'Caution, you\'re going to shut the current page with a started message.\n\nAre you sure?'
        }
        
        function warn(lang)
        {
            if(document.getElementById('message').value  != '')
            {
                var msg = texts[lang];
                
                if(lang != 'en') msg += '\n\n--------------\n\n' + texts["en"];

                return confirm(msg);
            }
            
            return true;
        }

    </script>

    <span class="title_P">P</span>icky<span class="title_P">P</span>aste 
    <span id="subtitle">For Picky People: Robust (uses <a href="http://sebsauvage.net/paste/">Zerobin</a>) AND easy-to-use</span>
</h1>
    
    <noscript>
        <strong style="color: red">
            <?php $plxPlugin->lang('L_JAVASCRIPT_DISABLED') ?>
            
        </strong>
        <div> </div>
    </noscript>
    
    <form action="javascript:;" id="ppForm" method="post" onSubmit="return prepareForm()">
        <label for="f_to"><?php $plxPlugin->lang('L_RECIPIENT') ?></label> <input autofocus id="f_to" name="to"  placeholder="<?php $plxPlugin->lang('L_EMAIL_ADDRESS') ?>" required type="text" value="<?php echo $plxPlugin->PP_htmlspecialchars(isset($_GET['mail']) ? $_GET['mail']:''); ?>" /><br />
        <label for="f_from"><?php $plxPlugin->lang('L_YOUR_EMAIL') ?></label> <input id="f_from" name="from" placeholder="Facultatif" type="text" /> <?php $plxPlugin->lang('L_ANSWERABLE') ?><br />
        <label for="pasteExpiration"><?php $plxPlugin->lang('L_EXPIRATION') ?></label> <select id="pasteExpiration" name="expire" required>
            <option value="5min"><?php $plxPlugin->lang('L_5MIN') ?></option>
            <option value="10min"><?php $plxPlugin->lang('L_10MIN') ?></option>
            <option value="1hour"><?php $plxPlugin->lang('L_1HOUR') ?></option>
            <option value="1day"><?php $plxPlugin->lang('L_1DAY') ?></option>
            <option value="1week"><?php $plxPlugin->lang('L_1WEEK') ?></option>
            <option value="1month" selected="selected"><?php $plxPlugin->lang('L_1MONTH') ?></option>
            <option value="1year"><?php $plxPlugin->lang('L_1YEAR') ?></option>
            <option value="never"><?php $plxPlugin->lang('L_NEVER') ?></option>
        </select><br />
        <label for="burnafterreading" title="Burn After Reading"><?php $plxPlugin->lang('L_BURN_AFTER_READING') ?></label> <input checked="checked" id="burnafterreading" name="burnafterreading" type="checkbox" value="1" /> <?php $plxPlugin->lang('L_BAR_EXPLANATIONS') ?><br />
        
        <div id="status"></div>
        
        <span class="label"><?php $plxPlugin->lang('L_YOUR_MESSAGE') ?></span><br />
        <textarea id="message" cols="70" rows="20" required></textarea><br /><br />
        <input type="submit" />
        
       <h3>Gagnez encore plus de temps en utilisant le snippet</h3>
        
        Glissez-déposez ce lien ( <a class="snippet" href="javascript:void(window.open('<?php echo $plxMotor->urlRewrite('?pickypaste') ?>#'+window.location.href, '_blank'))">PickyPaste</a> ) dans vos favoris.<br /><br />
        
        Vous n'avez plus qu'à cliquer sur ce lien pour partager le lien vers la page où vous vous trouvez !<br />
        Une fenêtre PickyPaste s'ouvrira automatiquement en pré-remplissant le message avec le lien de la page où vous étiez.
        
        <!-- <h3>Gagnez encore plus de sécurité</h3>
        
        Enregistrer simplement cette page ( <span class="key">Ctrl</span>+<span class="key">S</span> ) sur votre ordinateur et utilisez la plutôt que celle-ci.<br /><br />
        
        Cela permettra de vous protéger au cas où notre site serait corrompu, cela vous protègera également contre les attaques de types Man-In-The-Middle. -->
        
        <hr />
        
        <h3>Paramètres avancés</h3>
        
        <em>Ne modifiez les valeurs ci-dessous que si vous savez ce que vous faites !!</em><br /><br />
        
        <label for="zerobinServer">Serveur Zerobin</label> <input id="zerobinServer" name="zerobinServer" type="text" value="<?php echo $plxMotor->urlRewrite().'plugins/pickyPasteInPluxml/ZeroBin/' ?>" size="50" /><br />
        <label for="mailServer">Serveur Mail</label> <input id="mailServer" type="text" size="50" value="<?php echo $plxMotor->urlRewrite('?pickypaste'); ?>" /> <br />
        <label for="opendiscussion">Discussion ouverte</label> <input id="opendiscussion" name="opendiscussion" type="checkbox" value="1" /> (Incompatible avec <strong>Lecture unique</strong>)<br />
        <label for="syntaxcoloring" style="clear: both">Colorisation syntaxique</label> <input id="syntaxcoloring" name="syntaxcoloring" type="checkbox" value="1" />
        
        <input id="data" name="data" type="hidden" />
        <input id="randomkey" name="randomkey" type="hidden" />
    </form>

    <script type="text/javascript">
        document.getElementById('message').value = window.location.hash.substring(1) // Get it then…
        if(window.location.hash) window.location.hash = '' // Clean it (to avoid that someone share his private URL accidently when sharing the PickyPaste address)
    </script>
</div>
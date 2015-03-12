<?php if(!defined('PLX_ROOT')) exit;

if (array_key_exists('cryptMyPluxml', $plxAdmin->plxPlugins->getInactivePlugins())) {
	$isCryptMyPluxmlActivated = false;
} else {
	$isCryptMyPluxmlActivated = true;
}

# Control du token du formulaire
plxToken::validateFormToken($_POST);

if(!empty($_POST)) {
	$plxPlugin->setParam('sidebar', $_POST['sidebar'], 'numeric');
	if (isset($_POST['cryptMyPluxml'])) {
		$plxPlugin->setParam('cryptMyPluxml', $_POST['cryptMyPluxml'], 'numeric');
	} else {
		$plxPlugin->setParam('cryptMyPluxml', 0, 'numeric');
	}
	$plxPlugin->setParam('mnuName', $_POST['mnuName'], 'string');
	$plxPlugin->setParam('mnuPos', $_POST['mnuPos'], 'numeric');
	$plxPlugin->saveParams();
	header('Location: parametres_plugin.php?p=pickyPasteInPluxml');
	exit;
}

$mnuName =  $plxPlugin->getParam('mnuName')=='' ? 'PickyPaste' : $plxPlugin->getParam('mnuName');
$mnuPos =  $plxPlugin->getParam('mnuPos')=='' ? 2 : $plxPlugin->getParam('mnuPos');
$sidebar =  $plxPlugin->getParam('sidebar')=='' ? 1 : $plxPlugin->getParam('sidebar');
$cryptMyPluxml =  $plxPlugin->getParam('cryptMyPluxml')=='' ? 1 : $plxPlugin->getParam('cryptMyPluxml');

?>

<h2>PickyPaste</h2>

<form action="parametres_plugin.php?p=pickyPasteInPluxml" method="post">
	<fieldset class="withlabel">
		<legend><strong>Param&egrave;trage de la partie pickyPasteInPluxml :</strong></legend>
		<p class="field"><label for="id_mnuName">Titre du menu&nbsp;:</label></p>
		<?php plxUtils::printInput('mnuName',$mnuName,'text','20-20') ?>
		<p class="field"><label for="id_mnuPos">Position du menu&nbsp;:</label></p>
		<?php plxUtils::printInput('mnuPos',$mnuPos,'text','2-5') ?>
		<p class="field"><label for="id_sidebar">Le thème a-t-il une sidebar ?&nbsp;:</label></p>
		<?php plxUtils::printSelect('sidebar',array(0=>L_NO,1=>L_YES),$sidebar); 
		if ($isCryptMyPluxmlActivated) {?>

		<p class="field"><label for="id_cryptMyPluxml">Voulez-vous utiliser cryptMyPluxml pour l'affichage des messages ?&nbsp;:</label></p>
		<?php plxUtils::printSelect('cryptMyPluxml',array(0=>L_NO,1=>L_YES),$cryptMyPluxml); 
		}?>
	<p>
		<?php echo plxToken::getTokenPostMethod() ?>
		<input type="submit" name="submit" value="Sauvegarder" />
	</p>
</form>

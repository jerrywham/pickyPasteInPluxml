"use strict";

/**
 * 
 * PickyPaste 0.11beta
 *
 * @author JeromeJ
 * @link http://www.olissea.com/PickyPaste/
 *
 * Note: Part of this program is replicated from Zerobin.
 */

 // Immediately start random number generator collector.
sjcl.random.startCollectors();

function showStatus(message, spin) {
	if (!message || message == '') {
		document.getElementById('status').value = '&nbsp;';
		return;
	}
	document.getElementById('status').value = message;
	if (spin) {
		var img = '<img src="busy.gif" style="width:16px;height:9px;margin:0px 4px 0px 0px;" />';
		document.getElementById('status').value += img;
	}
}

function compress(message) {
    return Base64.toBase64( RawDeflate.deflate( Base64.utob(message) ) );
}

function prepareForm() {
	// Don't process if the message is empty
	if(document.getElementById('message').value.length == 0) {
		// Note: Shouldn't happen thanks to the HTML5's required attribute, but just in case!
		return;
	}
	// If sjcl has not collected enough entropy yet, display a message.
	if (!sjcl.random.isReady())
	{
		showStatus('Cryptage en cours (Merci de bouger votre souris pour plus d\'entropie) â€¦', true);
		sjcl.random.addEventListener('seeded', function(){ prepareForm(); });
		return; 
	}
	
	showStatus('Cryptage en cours â€¦', true);

	var randomkey = sjcl.codec.base64.fromBits(sjcl.random.randomWords(8, 0), 0);
	var cipherdata = sjcl.encrypt(randomkey, compress(document.getElementById('message').value));
	
	document.getElementById('data').value = cipherdata;
	document.getElementById('randomkey').value = randomkey;
	
	showStatus('');
	
	// Dynamic form's action attribute
	document.getElementById('ppForm').action = document.getElementById('mailServer').value;
}
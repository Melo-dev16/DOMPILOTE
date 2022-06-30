/*const ws = new WebSocket('wss://dompilote.herokuapp.com');
var baseURL = $('#base_url').val();

ws.onopen = function () {
    var t = setInterval(function(){
        if (ws.readyState != 1) {
            clearInterval(t);
            return;
        }
        ws.send('{type:"ping"}');
    }, 55000);
};

ws.addEventListener('message', ev => {
	ev.data.text().then(text => {
		let data = JSON.parse(text);
		let cons = Object.keys(data)[0];

		if(cons == "A"){
			updateConsA(data.A);
		}
		else{
			updateConsB(data.B);
		}
	});
})

ws.onclose = function (event) {
	console.log("Socket Terminé");
	console.log(event);
}*/

function confirmPwd(){
	if($('#pwd').val() != '' && $('#confirm').val() != '' && $('#pwd').val() == $('#confirm').val()){
		$('#submitBtn').prop('disabled','');
		$('#pwdConfirmAlert').hide();
	}
	else {
		$('#submitBtn').prop('disabled','true');
		$('#pwdConfirmAlert').show();
	}
}

function checkAptInfos(){
	let reqFields = ['aptName','aptAddr','aptCmp','aptState','aptLong','aptLat','aptType','aptMac','aptTel1','aptTel2'];
	let optFields = ['aptBat','aptStair','aptFloor'];

	let valid = true;

	$.each(reqFields, function( index, value ) {
	  if($('#'+value).val() == ''){
	  	valid = false;
	  	$('#'+value).css('border-color','red');
	  }
	  else{
	  	$('#'+value).css('border-color','green');
	  	$('#'+value+'-txt').text($('#'+value).val());
	  }
	});

	$.each(optFields, function( index, value ) {
		$('#'+value+'-txt').text($('#'+value).val());
	});
	if(valid){
		$('#wizard').smartWizard('goToStep', 2);
	}
}

function checkManage(){
	let fields = ['owner','techs','admins'];

	let valid = true;

	$.each(fields, function( index, value ) {
	  if($('#'+value).val() == ''){
	  	valid = false;
	  	$('#'+value).css('border-color','red');
	  }
	  else{
	  	$('#'+value).css('border-color','green');
	  	$('#'+value+'-txt').text($('#'+value+" option:selected").toArray().map(item => item.text).join());
	  }
	});

	if(valid){
		$('#wizard').smartWizard('goToStep', 3);
	}
}

function sendConsA(){
	//if(ws.readyState === ws.OPEN){
		console.log("Envoi de la consigne A à la socket...");
		//ws.send(JSON.stringify({A: parseInt($("#consA-input").val())}));

		updateConsA(parseInt($("#consA-input").val()))
		$('.close').click();
	//}
}

function sendConsB(){
	//if(ws.readyState === ws.OPEN){
		console.log("Envoi de la consigne B à la socket...");
		//ws.send(JSON.stringify({B: parseInt($("#consB-input").val())}));
		updateConsB(parseInt($("#consB-input").val()))
		$('.close').click();
	//}
}

function updateConsA(val){
	console.log("Mise à jour de la consigne A");

	$("#consA-text").text(val);
	$("#consA-input").val(val);
	/*$.post(baseURL+'/api/update_cons',{cons: "A",value: val,apt: $('#aptID').val()},function(res,state){
		if(state == 'success'){
			new PNotify({
				title: 'Consigne mise à jour',
				text: 'La consigne eco a été mise à jour !',
				type: 'success',
				styling: 'bootstrap3'
			});

			$("#consA-text").text(val);
			$("#consA-input").val(val);
		}
		else{
			new PNotify({
              title: 'Erreur Serveur',
              text: 'Un problème est survenu !',
              type: 'error',
              styling: 'bootstrap3'
          	});
		}
	});*/
}

function updateConsB(val){
	console.log("Mise à jour de la consigne B");

	$("#consB-text").text(val);
	$("#consB-input").val(val);
	/*$.post(baseURL+'/api/update_cons',{cons: "B",value: val,apt: $('#aptID').val()},function(res,state){
		if(state == 'success'){
			new PNotify({
				title: 'Consigne mise à jour',
				text: 'La consigne confort a été mise à jour !',
				type: 'success',
				styling: 'bootstrap3'
			});

			$("#consB-text").text(val);
			$("#consB-input").val(val);
		}
		else{
			new PNotify({
              title: 'Erreur Serveur',
              text: 'Un problème est survenu !',
              type: 'error',
              styling: 'bootstrap3'
          	});
		}
	});*/
}


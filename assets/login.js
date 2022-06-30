var baseURL = $('#base_url').val();

function connect(){
	$('input').prop('disabled','true');
	$('#loginBtn').prop('disabled','true');
	$('#loginBtn img').show();

	let data = {
		email: $('#email').val(),
		pwd: $('#pwd').val()
	}

	$.post(baseURL+'/api/login',data,function(res,state){
		if(state == 'success'){
			res = jQuery.parseJSON(res);
			console.log(res);
			if(res.token != -1){
				new PNotify({
	              title: 'Connexion établi',
	              text: 'Bienvenue à vous !',
	              type: 'success',
	              styling: 'bootstrap3'
	          	});

	          	setTimeout(function(){
	          		window.location.replace(baseURL);
	          	},1800)
			}
			else{
				new PNotify({
	              title: 'Connexion échouée',
	              text: 'Identifiants incorrects !',
	              styling: 'bootstrap3'
	          	});
			}
		}
		else{
			new PNotify({
              title: 'Erreur Serveur',
              text: 'Un problème est survenu !',
              type: 'error',
              styling: 'bootstrap3'
          	});
		}

		$('input').prop('disabled','');
		$('#loginBtn').prop('disabled','');
		$('#loginBtn img').hide();
	});
}
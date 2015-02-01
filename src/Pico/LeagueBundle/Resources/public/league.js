/**
 * Affiche le formulaire d'ajout d'evenement
 * @param type
 * @param id
 */
function displayFormEvent(type,id){
	var urlEvent = '/app_dev.php/oki/form/'+type+'/'+id;
	$.get(urlEvent,function(data,status){
		if(status == 'success') {
			//On affiche la zone
			$("#modalDynamicAddEvent").toggle();
			//On remplis par le form, et on cache le bouton de validation de base
			$(".DynamicAddEvent").html(data);
			$("#pico_calendarmanagerbundle_event_save").css('display','none');
		}
	});
}

/**
 * Envoi pour validation des modifictions lié a l'equipe
 */
function gestionEquipe(id)
{
	var urlGestionEquipe = '/app_dev.php/league/ajax/gestion-equipe/'+id;
	$.ajax({
		type: "POST",
		url: urlGestionEquipe,
		data: $(".gestion-equipe").serialize(), // serializes the form's elements.
		success: function(data)
		{
			if(data['status']=='OK')
			{
				$(location).attr('href',data['url']);
			} else {
				if(data['error'] != undefined && data['error'] != false) {
					alert(data['error']);
				} else {
					alert('Une erreur est survenue');
				}
			}
		}
	});
}
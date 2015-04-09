

/**
 * Appelle ajax a la methode de suppression
 * @param type
 * @param id
 */
function remove(type,id)
{
    var urlDelete = '/dev/app_dev.php/league/ajax/delete/'+type+'/'+id;
    $.get(urlDelete,function(data){
        if(data['status'] == 'OK') {
            $('#row_'+id).remove();
        } else {
            alert('une erreur est survenue');
        }
    });
}

/**
 * Fonction interne : Retourne l'element submit depuis l'id du form
 * @param IdElement
 * @returns Element
 */
function getFormSubmit(IdForm){
    return $('#'+IdForm+' [type="submit"]');
}
/**
 * Fonction Affichant le form selon le type, et l'id
 * @param id
 */
function displayForm(type,id,id_cible){
    var urlForm = '/dev/app_dev.php/league/ajax/form/'+type+'/'+id;
    if(id_cible != undefined){
        urlForm = urlForm+'/'+id_cible;
    }
    $.get(urlForm,function(data,status){
        if(status == 'success') {
            //On affiche la zone
            $("#modalDynamicForm").toggle();
            //On remplis par le form, et on cache le bouton de validation de base
            $(".DynamicForm").html(data);
            //On cache le bouton de validation
            getFormSubmit("modalDynamicForm").css('display','none');
            //Gestion particuliere, pour le form equipe on applique le multiSelect
            if(type=='Equipes'){
                $("#pico_leaguebundle_equipe_listeModo_id_client").multiselect({
                    header: "Choisissez les moderateurs",
                    click: function(e){
                        //Recup liste membre
                        var list_id_membre = [];
                        $(this).multiselect("widget").find("input:checked").each(function( element ) {
                            list_id_membre.push($(this).val());
                        });
                        //On modifie la valeur de listeModo :
                        $('#pico_leaguebundle_equipe_listeModo').val(list_id_membre.join(','));
                    },
                });

                var list_id_membre_recup = $('#pico_leaguebundle_equipe_listeModo').val();
                var array_list_id_membre = [];
                array_list_id_membre = list_id_membre_recup.split(',');

                var checkpoint_first = true;
                $("select").multiselect("widget").find(":checkbox").each(function(){
                    if(jQuery.inArray($(this).val(), array_list_id_membre)!==-1) {
                        if(!$(this).attr('aria-selected')){
                            this.click();
                        }
                    } else {
                        if($(this).attr('aria-selected')){
                            this.click();
                        }
                    }
                });
            }

        }
    });
}

function validateForm(urlValidateForm){
    $.ajax({
        type: "POST",
        url: urlValidateForm,
        data: $('.DynamicForm form').serialize(), // serializes the form's elements.
        success: function(data)
        {
            if(data['status'] == 'Ok') {
                $(location).attr('href',data['url']);
            } else {
                //On affiche la zone
                $("#modalDynamicForm").show();
                //On remplis par le form, et on cache le bouton de validation de base
                $(".DynamicForm").html(data);
                //On cache le bouton de validation
                getFormSubmit("modalDynamicForm").css('display','none');
            }
        }
    });
}

/**
 * Affiche le formulaire d'ajout d'evenement
 * @param type
 * @param id
 */
function displayFormEvent(type,id){
    var urlEvent = '/dev/app_dev.php/oki/form/'+type+'/'+id;
    $.get(urlEvent,function(data,status){
        if(status == 'success') {
            //On affiche la zone
            $("#modalDynamicForm").toggle();
            //On remplis par le form, et on cache le bouton de validation de base
            $(".DynamicForm").html(data);
            getFormSubmit("modalDynamicForm").css('display','none');
        }
    });
}

/**
 * Envoi pour validation des modifictions lié a l'equipe
 */
function gestionEquipe(id)
{
    var urlGestionEquipe = '/dev/app_dev.php/league/ajax/gestion-equipe/'+id;
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
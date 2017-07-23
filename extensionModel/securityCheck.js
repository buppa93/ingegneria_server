jQuery(document).ready(function()
{
    var role;

    role = jQuery('#userrole').val();
    console.log(role);

    if(role == "direttore")
    {
        jQuery('.aggiungim').hide();
        jQuery('.edit-mul').hide();
        jQuery('.trash-mul').hide();
        jQuery("#submitm").prop('disabled', true);
        jQuery("#editm").prop('disabled', true);
        jQuery('.aggiungirep').hide();
        jQuery('.edit-rep').hide();
        jQuery('.trash-rep').hide();
        jQuery("#submitrep").prop('disabled', true);
        jQuery("#editrep").prop('disabled', true);
    }

    if(role == "operatore")
    {
        jQuery('.aggiungimus').hide();
        jQuery('.edit-mus').hide();
        jQuery('.trash-mus').hide();
        jQuery("#submitmus").prop('disabled', true);
        jQuery("#editmus").prop('disabled', true);
    }

    if(role == "proprietario")
    {
        jQuery('.aggiungim').hide();
        jQuery('.edit-mul').hide();
        jQuery('.trash-mul').hide();
        jQuery("#submitm").prop('disabled', true);
        jQuery("#editm").prop('disabled', true);
        jQuery('.aggiungirep').hide();
        jQuery('.trash-rep').hide();
        jQuery("#submitrep").prop('disabled', true);
        jQuery("#editrep").prop('disabled', true);
        jQuery('.aggiungimus').hide();
        jQuery('.edit-mus').hide();
        jQuery('.trash-mus').hide();
        jQuery("#submitmus").prop('disabled', true);
        jQuery("#editmus").prop('disabled', true);
    }

    if((role == "operatore") || (role == "proprietario"))
    {
        jQuery('.aggiungiop').hide();
        jQuery('.trash-op').hide();
        jQuery("#submitop").prop('disabled', true);
    }
});
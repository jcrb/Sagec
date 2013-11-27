$(document).ready(function(){
 $('#table_hop').dataTable({
 		"bSort": true, 		/* active le tri*/
 		"bPaginate": true,	/* supprime la pagination */
 		"bLengthChange": true, /* modifier affichage du nombre de lignes */
 		"oLanguage": { /* traduction */
            "sLengthMenu": "Afficher _MENU_ lignes par page",
            "sZeroRecords": "Pas de données - Désolé",
            "sInfo": "Montrer _START_ - _END_ de _TOTAL_ lignes",
            "sInfoEmpty": "Montrer 0 - 0 de 0 lignes",
            "sInfoFiltered": "(filtré à partir de _MAX_ enregistrements)",
            "oPaginate": {
        			"sFirst": "Premiere page",
      			"sNext": "Suivante ",
      			"sPrevious": "Precedente",
      			"sSearch": "Rechercher:"
      			}
            
        }
 	});
});
$(document).ready(function(){
 $('#table_hop').dataTable({
 		"sDom": 'T<"clear">lfrtip',
 		"oTableTools": {
            "sSwfPath": "swf/copy_csv_xls.swf"
        },
 		"bSort": true, 		/* active le tri*/
 		"bPaginate": true,	/* supprime la pagination */
 		"bLengthChange": true, /* modifier affichage du nombre de lignes */
 		"oLanguage": { /* traduction */
 				"sProcessing": "Chargement...",
            "sLengthMenu": "Afficher _MENU_ lignes par page",
            "sZeroRecords": "Pas de données - Désolé",
            "sInfo": "Montrer _START_ - _END_ de _TOTAL_ lignes",
            "sInfoEmpty": "Montrer 0 - 0 de 0 lignes",
            "sInfoFiltered": "(filtrés à  partir de _MAX_ enregistrements)",
            "sSearch": "Recherche:",
            "oPaginate": {
        			"sFirst": "Premiere page",
      			"sNext": "Suivante ",
      			"sPrevious": "Precedente",
      			"sLast":     "Dernier"
      			}
            
        }
 	});
});
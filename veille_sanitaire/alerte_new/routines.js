<!--
======================================================================
coche ou décoche toutes les cases
======================================================================
-->
			$("document").ready(function() {
				var val=-1,c;
 				$('#cocheTout').click(function() { 					// clic sur la case cocher/decocher
				var cases = $('#cases').find(':checkbox'); 	// on cherche les checkbox qui dépendent de la liste 'cases'
        		if(this.checked){ 									// si 'cocheTout' est coché
            	cases.attr('checked', true); 					// on coche les cases
            	$('#cocheText').html('Tout decocher'); 	// mise à jour du texte de cocheText
            	val = 0;
            	c = 1;
            	$.ajax({
            		type: "POST",
            		url: "update.php",data:"id="+ val + "&check=" + c,
            		//success: function(msg){alert( "Data Saved: " + msg)}
            	});
        		}else{ 													// si on décoche 'cocheTout'
            	cases.attr('checked', false);					// on coche les cases
            	$('#cocheText').html('Cocher tout');		// mise à jour du texte de cocheText
            	val = 0;c = 0;  
            	$.ajax({
            		type: "POST",
            		url: "update.php",
            		data:"id="+ val + "&check=" + c,
            		//success: function(msg){alert( "Data Saved: " + msg)}
            	});     		}               
    			})
		});
		
<!--
=========================================================================
	en cas de clic dans une case à cocher, appelle le prog "update.php"
	met à jour la base de données associée
	la var c indique si la case est cochée ou décochée
=========================================================================
-->		
		function ischeck(val){
			var c;
			if($('#'+ val).attr('checked'))	// le # permet de désigner un élément par son ID
			{
					c = 'o';							// c = 1 si la case est cochée
					//alert(val);
			}
			else
					c = '';			
			$.ajax({
   			type: "POST",
   			url: "update.php",
   			data:"id="+val + "&check="+c,
   			//success: function(msg){alert( "Data Saved: " + msg )}	// msg reprend tous les éléments "imprimés" par print et echo dans le fichier update
   		})
		}
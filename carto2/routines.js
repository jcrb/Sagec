<!--
======================================================================
coche ou d�coche toutes les cases
======================================================================
-->
			$("document").ready(function() {
				var val=-1,c;
 				$('#cocheTout').click(function() { 					// clic sur la case cocher/decocher
				var cases = $('#cases').find(':checkbox'); 	// on cherche les checkbox qui d�pendent de la liste 'cases'
        		if(this.checked){ 									// si 'cocheTout' est coch�
            	cases.attr('checked', true); 					// on coche les cases
            	$('#cocheText').html('Tout decocher'); 	// mise � jour du texte de cocheText
            	val = 0;
            	c = 1;
            	$.ajax({
            		type: "POST",
            		url: "update.php",data:"id="+ val + "&check=" + c,
            		//success: function(msg){alert( "Data Saved: " + msg)}
            	});
        		}else{ 													// si on d�coche 'cocheTout'
            	cases.attr('checked', false);					// on coche les cases
            	$('#cocheText').html('Cocher tout');		// mise � jour du texte de cocheText
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
	en cas de clic dans une case � cocher, appelle le prog "update.php"
	met � jour la base de donn�es associ�e
	la var c indique si la case est coch�e ou d�coch�e
=========================================================================
-->		
		function ischeck(val){
			var c;
			if($('#'+ val).attr('checked'))	// le # permet de d�signer un �l�ment par son ID
			{
					c = 'o';							// c = 1 si la case est coch�e
					//alert(val);
			}
			else
					c = '';			
			$.ajax({
   			type: "POST",
   			url: "update.php",
   			data:"id="+val + "&check="+c,
   			//success: function(msg){alert( "Data Saved: " + msg )}	// msg reprend tous les �l�ments "imprim�s" par print et echo dans le fichier update
   		})
		}
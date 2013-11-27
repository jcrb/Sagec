<script language="JavaScript">
function verif()
  {
  if (document.layers)
    {
    formulaire = document.forms.monFormulaire;
    }
  else
    {
    formulaire = document.monFormulaire;
    }
  }

function verifChoixPays()
  {
  verif();
  if (formulaire.choixPays.value == "0")
    {
    alert('Vous devez tout d\'abord choisir un pays!');
    formulaire.choixPays.focus();
    }
  }

var villes = new Array();
villes[0] = new Array();
villes[1] = new Array("Paris", "Lyon", "Marseille")
villes[2] = new Array("Londres", "Manchester", "Liverpool")
villes[3] = new Array("Berlin", "Stutgart", "Munich")

function remplirVilles(code)
  {
  verif();
  var lesVilles = villes[code];

  if (code>0)
    {
    formulaire.choixVille.options.length = lesVilles.length;
    for (i=0; i<lesVilles.length; i++)
      {
      formulaire.choixVille.options[i].value = lesVilles[i];
      formulaire.choixVille.options[i].text = lesVilles[i];
      }
    document.monFormulaire.choixVille.options.selectedIndex = 0;
    }
  else
    {
    formulaire.choixVille.options.length = 1;
    formulaire.choixVille.options[0].value = 0;
    formulaire.choixVille.options[0].text = "-- choisissez une ville";
    }
  }
</script>

<form name="monFormulaire">
<select name="choixPays" onChange="remplirVilles(this.options[this.selectedIndex].value);">
<option value="0" selected>-- choisissez un pays</option>
<option value="1">France</option>
<option value="2">Royaume-Uni</option>
<option value="3">Allemagne</option>
</select>
<br>
<br>
<select name="choixVille" onFocus="verifChoixPays();">
<option value="0" selected>-- choisissez une ville</option>
</select>
</form>

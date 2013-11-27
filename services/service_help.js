<script language="JavaScript">

var fenetreHelp;

function creerFenetreHelp()
{
	fenetreHelp = window.open("aide.html",
	"fentreHelp",width="500,height=150,location=no,scrollbars=yes,resizable=yes,directories=no,status=no");
}

function helpOuPas()
{
	if((typeof(fenetreHelp)=="undefined") || (fenetreHelp.closed==true))
	{
		creerFenetreHelp();
	}
	else
	{
		fenetreHelp.close();
	}
}

function help(url)
{
	if(typeof(fenetreHelp)=="undefined")
		return;
	else if(fenetreHelp.closed==true)
		return;
	var urlHelp = "aide.html" + "#" + url;
	fenetreHelp.focus();
	fenetreHelp.location.replace(urlHelp);
}
</script>

function enableReserveButton()
{
	document.forms["reserve"]["Reserve"].disabled=false;
}

function submitform(resetfield)
{
	if(!(typeof resetfield == "undefined"))
	{
		resetfield.selectedIndex=0;
	}
	document.resstatus.submit();
}
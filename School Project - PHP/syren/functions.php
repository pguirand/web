<?php

function affText($name)
{
	if($name != "")
		{
			echo $name;			
		}
	
}

function concat($fname)
	{
      echo $fname.$fname;
   	}

function convdate($jour)

	{
	switch($jour)
		{
		case "Monday": $conv = "Lundi";break;
		case "Tuesday": $conv = "Mardi";break;
		case "Wednesday": $conv = "Mercredi";break;
		case "Thursday": $conv = "Jeudi";break;
		case "Friday": $conv = "Vendredi";break;
		case "Saturday": $conv = "Samedi";break;
		case "Sunday": $conv = "Dimanche";break;
		}
	
	}
	
?>




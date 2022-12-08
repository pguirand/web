<?php require_once('Connections/connex.php'); ?>
<?php require_once('Connections/connex.php'); ?>
<?php require_once('Connections/connex.php'); ?>
<?php ;
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_voirind = "-1";
if (isset($_GET['ID_IND'])) {
  $colname_voirind = $_GET['ID_IND'];
  $idind = $colname_voirind;
  
}
mysql_select_db($database_connex, $connex);
$query_voirind = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_voirind, "text"));
$voirind = mysql_query($query_voirind, $connex) or die(mysql_error());
$row_voirind = mysql_fetch_assoc($voirind);
$totalRows_voirind = mysql_num_rows($voirind);


$id_pere=$row_voirind['NUM_IDENTIFIANT_PERE'];
$id_mere=$row_voirind['NUM_IDENTIFIANT_MERE'];
$id_off=$row_voirind['NUM_IDENTIFIANT_OEC'];


$colname_mere = "-1";
if (isset($_POST['$id_mere'])) {
  $colname_mere = $_POST['$id_mere'];
}
mysql_select_db($database_connex, $connex);
$query_mere = sprintf("SELECT * FROM individu WHERE ID_IND = '$id_mere'");
$mere = mysql_query($query_mere, $connex) or die(mysql_error());
$row_mere = mysql_fetch_assoc($mere);
$totalRows_mere = mysql_num_rows($mere);

$colname_off = "-1";
if (isset($_POST['$id_off'])) {
  $colname_off = $_POST['$id_off'];
}
mysql_select_db($database_connex, $connex);
$query_off = sprintf("SELECT * FROM individu WHERE ID_IND = %s", GetSQLValueString($colname_off, "text"));
$off = mysql_query($query_off, $connex) or die(mysql_error());
$row_off = mysql_fetch_assoc($off);
$totalRows_off = mysql_num_rows($off);

$colname_addr = "-1";
if (isset($_POST['ID_IND'])) {
  $colname_addr = $_POST['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_addr = sprintf("SELECT * FROM adresse, individu WHERE adresse.ID_IND = '$idind' and individu.ID_IND='$idind'");
$addr = mysql_query($query_addr, $connex) or die(mysql_error());
$row_addr = mysql_fetch_assoc($addr);
$totalRows_addr = mysql_num_rows($addr);
$secom=$row_addr['ID_SECCOM'];

$colname_commune = "-1";
if (isset($_POST['ID_COM'])) {
  $colname_commune = $_POST['ID_COM'];
}
mysql_select_db($database_connex, $connex);
$query_commune = sprintf("SELECT * FROM commune , sectioncom WHERE commune.ID_COM = '$secom' and sectioncom.ID_COM = '$secom'");
$commune = mysql_query($query_commune, $connex) or die(mysql_error());
$row_commune = mysql_fetch_assoc($commune);
$totalRows_commune = mysql_num_rows($commune);
$idcom=$row_commune['ID_COM'];

$colname_dept = "-1";
if (isset($_POST['ID_DEPT'])) {
  $colname_dept = $_POST['ID_DEPT'];
}
mysql_select_db($database_connex, $connex);
$query_dept = sprintf("SELECT * FROM commune, arrondissement, departement WHERE commune.ID_COM='$idcom' and commune.ID_ARRON=arrondissement.ID_ARRON and arrondissement.ID_DEPT=departement.ID_DEPT");
$dept = mysql_query($query_dept, $connex) or die(mysql_error()); 
$row_dept = mysql_fetch_assoc($dept);
$totalRows_dept = mysql_num_rows($dept);

$colname_acte = "-1";
if (isset($_POST['ID_IND'])) {
  $colname_acte = $_POST['ID_IND'];
}
mysql_select_db($database_connex, $connex);
$query_acte = sprintf("SELECT * FROM document, individu WHERE document.ID_IND = '$idind' and individu.ID_IND = '$idind'");
$acte = mysql_query($query_acte, $connex) or die(mysql_error());
$row_acte = mysql_fetch_assoc($acte);
$totalRows_acte = mysql_num_rows($acte);



$colname_pere = "-1";
if (isset($id_pere)) {
  $colname_pere = $id_pere;
}
mysql_select_db($database_connex, $connex);
$query_pere = sprintf("SELECT * FROM individu WHERE ID_IND = '$id_pere'");
$pere = mysql_query($query_pere, $connex) or die(mysql_error());
$row_pere = mysql_fetch_assoc($pere);
$totalRows_pere = mysql_num_rows($pere);





//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*                    Anand Dipakkumar Joshi
                      ----------------------
					  PHP Pdf creator
					  ----------------------
					  Enjoy!!!!
					  ----------------------
																															    */
																																//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////					  
					  

$nom_ind=$row_voirind['NOM_IND'];
$prenom_ind=$row_voirind['PRENOM_IND'];

$npere=ucfirst(strtolower($row_pere['PRENOM_IND']))." ".strtoupper($row_pere['NOM_IND']);
$nmere=ucfirst(strtolower($row_mere['PRENOM_IND']))." ".strtoupper($row_mere['NOM_JEUNE_FILLE']);
$noff=$row_off['PRENOM_IND'];
$sexe=$row_voirind['SEXE_IND'];
$date_nais=$row_voirind['DATEH_NAIS'];
$num_acte=strtoupper($row_acte['NO_DOC']);
$no_reg=strtoupper($row_acte['NO_REG']);
$no_page=strtoupper($row_acte['NO_PAGE']);
$strdate= $row_acte['DATE_CREATION_CHAMP'];
$convdate = strtotime ($strdate);
$ydate = date ('Y', $convdate);
$ncom = strtoupper($row_commune['NOM_COM']);
$dept= strtoupper($row_dept['NOM_DEPT']);
if ($sexe==Feminin){
$aff_sexe= "féminin qu'il nous a declaré etre sa fille née";
$ne= "Née le";
}
else
{
$aff_sexe="masculin qu'il nous a declaré etre son fils né";
$ne = "Né le";
}

$Text_Acte="	    L'an ".(strftime ('%Y',time()))." an ".(strftime ('%Y',time())-1803)."ieme de l'Independance et le ".strftime ('%A ',$convdate).(strftime('%d',$convdate)).strftime (' %B',$convdate).strftime (' a %H H.',$convdate)." 
				Par devant nous, Jose et $Nom_Ind, identifie au numero : $Numero, Officier de l'Etat Civil de la section Ouest de Port-au-Prince, soussigne.
			A comparu ".$npere.", demeurant a Port-au-Prince et domicilie a Port-au-Prince. Lequel nous a présenté un enfant du sexe ".$aff_sexe." le ".(strftime ("%d", strtotime($date_nais))).strftime(" %B ", strtotime($date_nais)).(strftime ("%Y", strtotime($DateNais)))." a Port-au-Prince H. U. E.".strftime (' a %H Heures', strtotime($HeureNais))." de ses oeuvres legitimes avec la citoyenne ".$nmere.", son epouse de profession couturiere, demeurant et domiciliee a Port-au-Prince.
				    Auquel enfant il a donne le prenom de ".$prenom_ind."
				   Dont acte fait en notre bureau, rue du centre # 99, en presence de Mr Henry Michaud et de Mr Dieuvois Michaud, tous deux majeurs, demeurant et domicilies a Port-au-Prince, temoins choisis et amenes par la comparante. 
			";
$Text_Resume="    Commune  : ".$ncom."
		  Bureau 					 : ".$dept."
		  
		  Acte No 				 : ".$num_acte."
		  Année							 : ".$ydate."
		  Registre		   : ".$no_reg."
		  Page   				   : ".$no_page."
		  
				
				
	Acte de Naissance de :
	
	".$prenom_ind." ".$nom_ind."
	
															".$ne." :
	
	".$date_nais."
					
	";



$Acte_Titre = 				"ACTE DE NAISSANCE";
if($_POST['textpass'] == $_POST['textcpass'])
{
	


// You can also insert it into mysql by writing mysql queries here.
// Code for pdf generation
setlocale(LC_TIME, "fr");
require('fpdf.php');
class PDF extends FPDF
{
//Page header
function Header()
{
// Whatever written here will come in header of the pdf file.

$this->Image('images/haitie.jpg',80,8,38);
$this->SetFont('Arial','B',15);
$this->Cell(80);
$this->Cell(18,65,'République d\'Haiti',0,0,'C');
$this->Cell(-15,75,'Archives Nationales d\'Haiti',0,0,'C');
$this->Cell(15,85,'********************************************',0,0,'C');
}

//Page footer
function Footer()
{
	// Whatever written here will come in footer of the pdf file.
	
	//Position at 1.5 cm from bottom
	$this->SetY(-15);
	//Arial italic 8
	$this->SetFont('Arial','I',8);
	//Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation of inherited class
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Adds image to beginning of 

$pdf->SetFont('Arial','',13);
$pdf->SetXY(0,82);
$pdf->MultiCell(90, 5, $Text_Resume, 0, "L", 0);


$pdf->SetFont('Arial','',14);
$pdf->MultiCell(80, 5, $Text_Titre, 0, "J", 0);

$pdf->SetXY(60,70);
$pdf->MultiCell(145, 8, $Text_Acte, 0, "J", 0);

$pdf->SetFont('Arial','B',18);
$pdf->SetXY(65,55);
$pdf->MultiCell(145, 8, $Acte_Titre, 0, "L", 0);

$pdf->Output();
}


mysql_free_result($voirind);

mysql_free_result($mere);

mysql_free_result($off);

mysql_free_result($dept);

mysql_free_result($commune);

mysql_free_result($addr);

mysql_free_result($acte);

mysql_free_result($pere);
?>

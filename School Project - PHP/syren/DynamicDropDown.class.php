<?php
/************************************************************************/
/* DynamicDropDown.class.php                                            */
/* =====================================================================*/
/* @Copyright (c) 2005 by Gobinath  (gobinathm at gmail dot com)        */
/*                                                                      */
/* @Author(s): Gobinath                                                 */
/*                                                                      */
/* @Version: 1.0.0     @Version Date: May 2nd, 2005                     */
/*                                                                      */
/* @Package: DynamicDropDown (Title:  Dynamic Drop Down 3 Level)        */
/* =====================================================================*/
/* @Purpose:                                                            */
/* The class is to Fetch values from the DB and display in 3 ListBox    */
/*                                                                      */
/* @Reason: The 2nd & 3rd DropDown Will be based on the Selection of    */
/*          of the previous listbox value                               */
/************************************************************************/



class DynamicDropDown{

    //Database Connection Variable
    var $db_con;         //Database Connection Variable
    var $rs_con;         //Table Connection Variable

    //Variable to Hold Form Name
    var $FrmObjName;

    //Array Variables, this is the Variable which will Hold the Value fetched from the Tables
    var $arrDepartement;
    var $arrarrondissement;
    var $arrcommune;
	var $arrsecom;

    //Sql Variables, Used for storing the SQL Statements
    var $DepartementSql;
    var $arrondissementSql;
    var $communeSql;
	var $secomSql;

    //Result variables, Used to Store the Result Resource
    var $DepartementResult;
    var $arrondissementResult;
    var $communeResult;
	var $secomResult;
	
    //Row Variables
    var $DepartementRow;
    var $arrondissementRow;
    var $communeRow;
	var $secomRow;

    //Loop Variable
    var $IDx;
    var $IDy;
    var $IDz;
	var $IDt;


    //Purpose: Constructor of the Function, which will establish the database Connection and Array initialization
    function DynamicDropDown($dbConfig){
        // Connects to the Mysql Server
        $this->db_con=mysql_connect($dbConfig['server'],$dbConfig['username'],$dbConfig['password']) or die(mysql_errno());
        // Select the Database
        $this->rs_con=mysql_select_db($dbConfig['database'],$this->db_con);

        // Array variable initialization
        $this->arrDepartement=array();
        $this->arrarrondissement=array();
        $this->arrcommune=array();
		$this->arrsecom= array();


        //Initialization of the Loop Variables
        $this->IDx=0;
        $this->IDy=0;
        $this->IDz=0;
		$this->IDt=0;
    }

    //Purpose: The Function will act like a Destructor for this Class
    function DynamicDropDown_Close(){   // The function needs to be called manually to close the connection
        mysql_close($this->db_con);   // Closes the Connection with the Database
        unset($this->FrmObjName,$this->arrDepartement,$this->arrarrondissement,$this->arrcommune,$this->secom);   // destroys the specified Variables
        unset($this);   //Destroys the Object created for the Class
    }

    //Purpose; The Function fetches the Data and loads it in the List Box
    function DataFetch(){
        //Suggestions: The Table names can be changed according to the User. But be carefull with the Query and other variables
        // So that the Script will function Properly

        $this->DepartementSql="select * from Departement";    //Query to fetch the Data from the table "Departement"
        $this->DepartementResult=mysql_query($this->DepartementSql); //Execute the Query and Store the result in new variable

        // Start fetching the Values from the Result Resource (DepartementResult)
        while ( $this->DepartementRow = mysql_fetch_array($this->DepartementResult,MYSQL_BOTH)){ // TYPE table Fetch While Loop begins Here
            for($i=0;$i<mysql_num_rows($this->DepartementResult);$i++){
                  $this->arrDepartement[$this->IDx][$i]= $this->DepartementRow[$i];   // Store the Value of the Departement table to the Array
            }

            //create a SQL Query for Fetching the Data from the BRAND Table
            $this->arrondissementSql="select * from `arrondissement` WHERE `id_dept`='".$this->DepartementRow[00]."'";
            $this->arrondissementResult=mysql_query($this->arrondissementSql);  // Execute the arrondissement Query

            //Start Fetching the Value from the Result resource (arrondissementResult)
            while ($this->arrondissementRow = mysql_fetch_array($this->arrondissementResult,MYSQL_BOTH)){ //BRAND Table Fetch While Loop Begins here
                for($i=0;$i<mysql_num_fields($this->arrondissementResult);$i++){
                    $this->arrarrondissement[$this->IDy][$i]=$this->arrondissementRow[$i];   // Stores the arrondissement data to the Array
                }

                //Create a Sql Query for Fetching the Data From the commune Table
                $this->communeSql="select * from commune WHERE `id_arron`='".$this->arrondissementRow[0]."'";
                $this->communeResult=mysql_query($this->communeSql);

                //Start Fetching the Value from the Result Resource (communeResult)
                while($this->communeRow=mysql_fetch_array($this->communeResult,MYSQL_BOTH)){ //MODEL Table Fetch While Loop Starts Here
                    for($i=0;$i<mysql_num_fields($this->communeResult);$i++){
                       $this->arrcommune[$this->IDz][$i]=$this->communeRow[$i];   // Store the Value of the commune table to the Array
                    }
					
					
				                //Create a Sql Query for Fetching the Data From the commune Table
                $this->secomSql="select * from sectioncom WHERE `id_com`='".$this->communeRow[0]."'";
                $this->secomResult=mysql_query($this->secomSql);

                //Start Fetching the Value from the Result Resource (communeResult)
                while($this->secomRow=mysql_fetch_array($this->secomResult,MYSQL_BOTH)){ //MODEL Table Fetch While Loop Starts Here
                    for($i=0;$i<mysql_num_fields($this->secomResult);$i++){
                       $this->arrsecom[$this->IDt][$i]=$this->secomRow[$i];   // Store the Value of the commune table to the Array
                    }
					
					    $this->IDt += 1;
                		}//MODEL Table Fetch While Loop Ends Here
					
                    $this->IDz += 1;
                }//MODEL Table Fetch While Loop Ends Here

                $this->IDy += 1;
            } //BRAND Table Fetch While Loop Ends here

            $this->IDx += 1;
        } // TYPE table Fetch While Loop Ends Here

    }// DataFetch Function Ends here.

    //Purpose: Member Function to Create the Javascript which loading the values in Different Dropdowns
    function CreateJavaScript($frmName){

        $this->FrmObjName=$frmName;  // Assigns the frmName Value to the Global Variable

        //Assign the Form field Elements
        $DocarrondissementElement = "document.".$this->FrmObjName.".arrondissement";
        $DoccommuneElement = "document.".$this->FrmObjName.".commune";
		$DocsecomElement = "document.".$this->FrmObjName.".secom";
		

        // Java Script Generation Starts here
        echo "\r<script Departement=\"text/javascript\" language=\"javascript\">";
        echo "\r<!--";
        //Create the Java Script for Loading the BRAND LIST BOX
        echo "\rfunction changearrondissement(obj){\r";
        for($i=0;$i<count($this->arrDepartement);$i++){
             echo "\rif(obj.value == '".$this->arrDepartement[$i][0]."'){\r";
             echo "\r\t/* Loading Values for the arrondissement Drop Down */\r";
             echo "\tdocument.$this->FrmObjName.arrondissement.options.length = 0;\r";
             echo "\t$DocarrondissementElement.options[$DocarrondissementElement.options.length] = new Option('--Arrondissement--','--Arrondissement--');\r";
             for($j=0;$j<Count($this->arrarrondissement);$j++){
                          //Check the Condition and create the Statement to Load Value for the List Boxes
                          if ( $this->arrDepartement[$i][0] == $this->arrarrondissement[$j][2]){
                               echo "\t$DocarrondissementElement.options[$DocarrondissementElement.options.length] = new Option('".$this->arrarrondissement[$j][1]."','".$this->arrarrondissement[$j][0]."');\r";
                          }
             }
             echo "\tdocument.$this->FrmObjName.arrondissement.disabled = false;\r";
             echo "\treturn true;\r";
             echo "}\r";
        }
        echo "}\r";
        //Create the Java Script for Loading the MODEL LIST BOX
        echo "\rfunction changecommune(obj){\r";
        for($i=0;$i<count($this->arrarrondissement);$i++){
             echo "\rif(obj.value == '".$this->arrarrondissement[$i][0]."'){\r";
             echo "\r\t/* Loading Values for the commune Drop Down */\r";
             echo "\tdocument.$this->FrmObjName.commune.options.length = 0;\r";
             echo "\t$DoccommuneElement.options[$DoccommuneElement.options.length] = new Option('--Commune--','--Commune--');\r";
             for($j=0;$j<count($this->arrcommune);$j++){
                          //Check the Condition and create the Statement to Load Value for the List Boxes
                          if ( $this->arrarrondissement[$i][0] == $this->arrcommune[$j][2]){
                               echo "\t$DoccommuneElement.options[$DoccommuneElement.options.length] = new Option('".$this->arrcommune[$j][1]."','".$this->arrcommune[$j][0]."');\r";
                          }
             }
             echo "\tdocument.$this->FrmObjName.commune.disabled = false;\r";
             echo "\treturn true;\r";
             echo "}\r";
        }
        echo "}\r";
	
			     //Create the Java Script for Loading the MODEL LIST BOX
        echo "\rfunction changesecom(obj){\r";
        for($i=0;$i<count($this->arrsecom);$i++){
             echo "\rif(obj.value == '".$this->arrsecom[$i][0]."'){\r";
             echo "\r\t/* Loading Values for the commune Drop Down */\r";
             echo "\tdocument.$this->FrmObjName.secom.options.length = 0;\r";
             echo "\t$DocsecomElement.options[$DocsecomElement.options.length] = new Option('--Section Communale--','--Section COmmunale--');\r";
             for($j=0;$j<count($this->arrsecom);$j++){
                          //Check the Condition and create the Statement to Load Value for the List Boxes
                          if ( $this->arrcommune[$i][0] == $this->arrsecom[$j][2]){ 
						
							  
                               echo "\t$DocsecomElement.options[$DocsecomElement.options.length] = new Option('".$this->arrsecom[$j][1]."','".$this->arrsecom[$j][0]."');\r";
                          }
             }
             echo "\tdocument.$this->FrmObjName.secom.disabled = false;\r";
             echo "\treturn true;\r";
             echo "}\r";
			 
        }
        echo "}\r"; 
		
		echo "-->\r";
		
		
		
		
		
		
        echo "</script>\r";  // Javascript ends here
    }


    //Purpose: Member Function to Create Dynamic List Boxs
    function CreateListBox(){
        //TYPE List Box Creation
         echo "<div align='left'> <select name=\"departement\" size=\"1\" onChange='changearrondissement(this)'>\r";
		 echo "<option value='--Select--'>--Département--</option>\r";
   		 //Loads the Data to the Departement List Box the one which will have values by default.
         for($i=0;$i<count($this->arrDepartement);$i++){
		         echo "<option value='".$this->arrDepartement[$i][0]."'>".$this->arrDepartement[$i][1]."</option>\r";
  	     }
		 echo "</select> &nbsp; &nbsp;";

         //arrondissement List Box Creation
         echo "<select name=\"arrondissement\" onChange='changecommune(this)' disabled >\r";  // By Default the Item is Disabled
         echo "<option value='--Select--'>--Arrondissement--</option>\r";
	     echo "</select> &nbsp;&nbsp;";

         //commune List Box Creation
         echo "<select name=\"commune\" onChange='changesecom(this)' disabled >\r";   //By Default the item will be disabled.
         echo "<option value='--Select--'>--Commune--</option>\r";
	     echo "</select> &nbsp;&nbsp;";
		 
		 //section communale List Box Creation
         echo "<select name=\"secom\" id=\"secomid\" onChange='ID_SECCOM.value=secomid.value' disabled>\r";   //By Default the item will be disabled.
         echo "<option value='--Select--'>--Section Communale--</option>\r";
	     echo "</select>\r </div>";
		 
    }
}
?>
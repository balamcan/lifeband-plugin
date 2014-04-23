/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function feet_to_meters(){
	var arguement= (document.inputForm.estatura_feet_fs.value);
	if(arguement.indexOf("'") > -1)
	{
		arguement = arguement.replace("'",".");
	}
	arguement= (arguement*0.3048);
	document.inputForm.estatura_fs.value= arguement; 
   }
   
   function meters_to_feet(){
	var arguement= (document.inputForm.estatura_fs.value);
	
	arguement= (arguement/0.3048);
	document.inputForm.estatura_feet_fs.value= arguement; 
   }
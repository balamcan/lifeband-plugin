/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function feet_to_meters(){
	var arguement= (document.inputForm.estatura_feet_fs.value);
	if(arguement.indexOf("'") > -1)
	{       
            var inches = arguement.split("'")[1]*.0254;
            arguement = arguement[0];                
	}
	arguement= (arguement*0.3048+(inches));
	document.inputForm.estatura_fs.value= arguement; 
   }
   $(function() {
    $("input").on("blur", function() {
        var arguement= (document.inputForm.estatura_feet_fs.value);
	if(arguement.indexOf("'") > -1)
	{       
            var inches = arguement.split("'")[1]*.0254;
            arguement = arguement[0];                
	}
	arguement= (arguement*0.3048+(inches));
	document.inputForm.estatura_fs.value= arguement;
})();
   function meters_to_feet(){
	var arguement= (document.inputForm.estatura_fs.value);
	
	arguement= (arguement/0.3048);
	document.inputForm.estatura_feet_fs.value= arguement; 
   }
   
   ///Con esta funcion conviertes de kg. a libras
    ///<param Name="kg">Peso en kg.<param>
   // function kg_to_pound($kg){
    
      //  return $kg * 2.20462262;
    //}
    ///Con esta funcion conviertes de libras. a kg
    ///<param Name="ound">Peso en libras.<param>
    //function pound_to_kg($pound){
    
      //   var pound = pound / 2.20462262;
    //}
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * function feet_to_meters(){
 var arguement= (document.inputForm.estatura_feet_fs.value);
 if(arguement.indexOf("'") > -1)
 {       
 var inches = arguement.split("'")[1]*.0254;
 arguement = arguement[0];                
 }
 arguement= (arguement*0.3048+(inches));
 document.inputForm.estatura_fs.value= arguement; 
 }
 */



$(document).ready(function() {

    if ($("#peso").val() != "")
    {
        $("#peso_lbs").val($("#peso").val() * 2.20462262);

    }
  
    if ($("#estatura").val() != "")
    {
        var arguement = $("#estatura").val();
        var arguementMod = arguement % 0.3048;
        arguement = arguement - arguementMod;
        arguement = (arguement / 0.3048);
        arguementMod = arguementMod / .0254;
        $("#estatura_feet").val(arguement.toFixed(0) + "\'" + arguementMod.toFixed(0))

    }

    $("#estatura_feet").on("blur", function() {

        var arguement = $("#estatura_feet").val();
        if (arguement.indexOf("'") > -1)
        {
            var inches = arguement.split("'")[1] * .0254;
            arguement = arguement.split("'")[0];
        }
        if (arguement.indexOf(".") > -1)
        {
            var inches = arguement.split(".")[1] * .0254;
            arguement = arguement.split(".")[0];
        }
        arguement = (arguement * 0.3048 + (inches));
        $("#estatura").val(arguement.toFixed(2));
        console.log(arguement);
    });

    $("#estatura").on("blur", function() {
        console.log("funka");
        var arguement = $("#estatura").val();
        var arguementMod = arguement % 0.3048;
        arguement = arguement - arguementMod;
        arguement = (arguement / 0.3048);
        arguementMod = arguementMod / .0254;
        $("#estatura_feet").val(arguement.toFixed(0) + "\'" + arguementMod.toFixed(0));
        console.log(arguement);
    });

    $("#peso").on("blur", function() {
        console.log("funka");
        var arguement = $("#peso").val() * 2.20462262;
        $("#peso_lbs").val(arguement.toFixed(2));
        console.log(arguement);
    });

    $("#peso_lbs").on("blur", function() {
        console.log("funka");
        var arguement = $("#peso_lbs").val() / 2.20462262;
        $("#peso").val(arguement.toFixed(2));
        console.log(arguement);
    });
});
/*
 function meters_to_feet() {
 var arguement = (document.inputForm.estatura_fs.value);
 
 arguement = (arguement / 0.3048);
 document.inputForm.estatura_feet_fs.value = arguement;
 }
 */
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
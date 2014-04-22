<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 class Converter{
    ///Con esta funcion conviertes de cm. a pulgadas
    ///<param Name="cm">Estatura en cm.<param>
    function cm_to_Feet( $cm )
    {
      return $cm * 0.0328084;
    
    }
    ///Con esta funcion conviertes de kg. a libras
    ///<param Name="kg">Peso en kg.<param>
    function kg_to_pound($kg){
    
        return $kg * 2.20462262;
    }
    ///Con esta funcion conviertes de libras. a kg
    ///<param Name="ound">Peso en pound.<param>
    function pound_to_kg($pound){
    
        return $pound / 2.20462262;
    }
    ///Con esta funcion conviertes de pies. a cm
    ///<param Name="feet>Estatura en pies.<param>
    function Feet_to_cm($feet){
    
        return $feet / 0.0328084;
    }
}
?>

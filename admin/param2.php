<?php
    include('phpqrcode/qrlib.php'); 
    class qr {
        
        function crearQrPNG($url,$val) {
       $codeText = 'http://'.$url.$val; 
            QRcode::png($codeText, ABSPATH .'qrphp/img/'.$val.'.png'); // creates file
        }
        function crearQrUsuario($nombre){
            QRcode::png('lifeband.com.mx/qr?code='.$nombre, ABSPATH . 'qrphp/img/'.$nombre.'.png');
        }
        
       
    }
?>

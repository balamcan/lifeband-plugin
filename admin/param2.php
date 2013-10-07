<?php
    include('phpqrcode/qrlib.php'); 
    class qr {
     
        function crearQrPNG($url,$val) {
       $codeText = 'http://'.$url.$val; 
            QRcode::png($codeText, ABSPATH .'/wp-content/plugins/lifeband-plugin/admin/qrpng/'.$val.'.png'); // creates file
        }
        function crearQrUsuario($nombre){
            QRcode::png('lifeband.com.mx/qr?code='.$nombre, ABSPATH . '/wp-content/plugins/lifeband-plugin/admin/qrpng/'.$nombre.'.png');
        }
       
    }
?>

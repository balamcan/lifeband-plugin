<?php
    include('phpqrcode/qrlib.php'); 
    class qr {
     
        function crearQrPNG($url,$val) {
       $codeText = 'http://'.$url.$val; 
            QRcode::png($codeText, 'qrpng/'.$val.'.png'); // creates file
        }
       
    }
?>

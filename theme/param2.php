<?php
    include('phpqrcode/qrlib.php'); 
         /*
You can use the [] syntax to pass arrays through _GET:

?a[]=1&a[]=2&a[]=3
PHP understands this syntax, so $_GET['a'] will be equal to array(1, 2, 3).

You can also specify keys:

?a[42]=1&a[foo]=2&a[bar]=3
Multidimentional arrays work too:

?a[42][b][c]=1&a[foo]=2
http_build_query() does this automatically:

http_build_query(array('a' => array(1, 2, 3))) // "a[]=1&a[]=2&a[]=3"

http_build_query(array(
    'a' => array(
        'foo' => 'bar',
        'bar' => array(1, 2, 3),
     )
)); // "a[foo]=bar&a[bar][]=1&a[bar][]=2&a[bar][]=3"
An alternative would be to pass json encoded arrays:

?a=[1,2,3]
And you can parse a with json_decode:

$a = json_decode($_GET['a']); // array(1, 2, 3)
And encode it again with json_encode:

json_encode(array(1, 2, 3)); // "[1,2,3]"
         */
    $url = $_GET['url']; 
    $array = $_GET['array']; 
    // QRcode::png($param,"img/".$codeText.".png");
    // we need to be sure ours script does not output anything!!! 
    // otherwise it will break up PNG binary! 
     
     foreach ($array as $k => $val) {
    $codeText = 'http://'.$url.$val; 
         QRcode::png('codeText', 'qrpng/'.$val.'.png'); // creates file
     }
    // here DB request or some processing 
     
    // end of processing here 
    
     
    // outputs image directly into browser, as PNG stream 
    
?>

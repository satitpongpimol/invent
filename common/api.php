<?php
/*
http code

[Informational 1xx]
100="Continue"
101="Switching Protocols"

[Successful 2xx]
200="OK"
201="Created"
202="Accepted"
203="Non-Authoritative Information"
204="No Content"
205="Reset Content"
206="Partial Content"

[Redirection 3xx]
300="Multiple Choices"
301="Moved Permanently"
302="Found"
303="See Other"
304="Not Modified"
305="Use Proxy"
306="(Unused)"
307="Temporary Redirect"

[Client Error 4xx]
400="Bad Request"
401="Unauthorized"
402="Payment Required"
403="Forbidden"
404="Not Found"
405="Method Not Allowed"
406="Not Acceptable"
407="Proxy Authentication Required"
408="Request Timeout"
409="Conflict"
410="Gone"
411="Length Required"
412="Precondition Failed"
413="Request Entity Too Large"
414="Request-URI Too Long"
415="Unsupported Media Type"
416="Requested Range Not Satisfiable"
417="Expectation Failed"

[Server Error 5xx]
500="Internal Server Error"
501="Not Implemented"
502="Bad Gateway"
503="Service Unavailable"
504="Gateway Timeout"
505="HTTP Version Not Supported"

*/

$api_response_info = array();

function CallAPIPOST($_Service, $_Function, $_Data)
{

    if(isset($_SESSION['token'])){
        //Create an array of custom headers.
    $customHeaders = array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$_SESSION['token']
        );
    }else{        
        //Create an array of custom headers.
    $customHeaders = array(
        'Content-Type: application/json'
        );
    }

//API Url
$url = WEBAPI.$_Service.'/'.$_Function;

//Initiate cURL.
$ch = curl_init($url);

//The JSON data.
//$jsonData = array(
//   'username' => 'MyUsername',
//  'password' => 'MyPassword'
//);

$jsonData = $_Data;

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeaders); 

//Execute the request
$result = curl_exec($ch);

$jsonobj = json_decode($result);

return $jsonobj;

//======================== Custom Header ==========================

 
//Use the CURLOPT_HTTPHEADER option to use our
//custom headers.
//curl_setopt($ch, CURLOPT_HTTPHEADER, $customHeaders);
 
//Set options to follow redirects and return output
//as a string.
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

}

function CallAPIPOST_OLD($_Service, $_Function, $_Data)
{

    //var_dump($_Data);
    //exit;
    //$post = [
    //    'qr_code' => '20J631JC1418 23220040210           Manifold Assy,Intake                                        ATA120PPC 2       ATA120S01ATA120P       0000007               0201902280010263   02620              03320870'
    //];
    // $_Data = $post;
    //var_dump($_Data);
    //exit;

    $MyUrl = WEBAPI.$_Service.'/'.$_Function;
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_POST, 1);
    if ($_Data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_Data);
    }
    //curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($curl, CURLOPT_URL, $MyUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if(isset($_SESSION['token'])){
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorizatio: Bearer '.$_SESSION['token']));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            //,'Content-Length: 395'
            'Authorization: Bearer Et2m1dfE1sUlUdMpP564mGizu3Bi6ysaxzxHloxkApcptOosqRBoWG2eDs7b1574907334'
            //,'User-Agent: Wget/1.12 (solaris2.10)'
            //,'Connection: Keep-Alive'
            //,'Accept: */*'
        ));
        echo 1;
    }else{        
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        echo 2;
    }
    $result = curl_exec($curl);
    if (!curl_errno($curl)) {
        $api_response_info = curl_getinfo($curl);
    }
    curl_close($curl);
    $jsonobj = json_decode($result);

    return $jsonobj == null ? $result : $jsonobj;
}

function CallAPIPOST_FILE($_Service, $_Function, $FileArray)
{
    $Url = WEBAPI.$_Service.'/'.$_Function;
    $curl = curl_init();
    //curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, $Url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $FileArray);
    $result = curl_exec($curl);
    if (!curl_errno($curl)) {
        $api_response_info = curl_getinfo($curl);
    }
    curl_close($curl);
    $jsonobj = json_decode($result);

    return $jsonobj == null ? $result : $jsonobj;
}
//=======================================================
//==================================== GET
//=======================================================
function CallAPIGET($_Service, $_Function, $_Data)
{
    $MyUrl = WEBAPI.$_Service.'/'.$_Function;
    // echo $MyUrl;
    $curl = curl_init();
    if ($_Data) {
        $MyUrl = sprintf('%s?%s', $MyUrl, http_build_query($_Data));
        exit;
    }
    if (ENV == 'DEBUG') {
        var_dump($MyUrl);
    }
    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    //curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($curl, CURLOPT_URL, $MyUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (!curl_errno($curl)) {
        $api_response_info = curl_getinfo($curl);
    }
    curl_close($curl);
    $_Data = json_decode($result, true);

    return $_Data;
}

function callAPI($method, $_Service, $_Function, $data){
    
    $curl = curl_init();
    $url = WEBAPI.$_Service.'/'.$_Function;
 
    switch ($method){
       case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
       case "PUT":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
          if ($data)
             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
          break;
       default:
          if ($data)
             $url = sprintf("%s?%s", $url, http_build_query($data));
    }
 
    // OPTIONS:
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$_SESSION['token'],
    ));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
 
    // EXECUTE:
    $result = curl_exec($curl);
    if(!$result){die("Connection Failure");}
    curl_close($curl);
    return $result;
 }

<?
$url = 'https://ezcrypt.it';
$fields = array(
            'data' => urlencode($REQUEST['data']),
            'ttl' => urlencode($_REQUEST['ttl']),
            'p' => urlencode($_REQUEST['p']),
            'syn' => urlencode("text/plain")
        );

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);

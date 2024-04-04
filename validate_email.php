<?php 

$email=$_POST['email'];

if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){

    exit("invalid format");
}

$api_key = "YOUR_UNIQUE_API_KEY";

$ch = curl_init();

curl_setopt_array($ch,[
    CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1?api_key=@api_key&email=$email",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCAT => true
]);

$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response, true);

if ($data['deliverability'] == "UNDELIVERABLE"){
    exit("Undeliverable");
}

if($data["is_disposable_email"]["value"]== true){
    exit("Disposable");
}
echo "email address is valid";

?>
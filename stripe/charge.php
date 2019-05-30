<pre>
<?php
require_once('../vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_5wPo7C0KoYD1BFsCgLKYtC6400ENWd66D0'); //YOUR_STRIPE_SECRET_KEY

// Get the token from the JS script
$token = $_POST['stripeToken'];
$charge = \Stripe\Charge::create(['amount' => 200000, 'currency' => 'USD', 'source' => $token]);
if($charge){
    echo 'You have paid' . ' ' . $charge->amount .' ' . $charge->currency . '</br></br>';
}else{'Everything is NOT awesome';}

$filename = '../upload-file/uploaded_files/books.csv';
// The nested array to hold all the arrays
$books = [];
$books[] = ['ISBN', 'Namn', 'Beskrivning'];
// Open the file for reading
if ($file_handle = fopen($filename, 'r')) {
    // Read one line from the csv file, use comma as separator
    while ($data = fgetcsv($file_handle)) {
      
        for($i=0; $i <= sizeof($data) - 1; $i++) {

        
        $books[] = fill_book($data[$i]);
        }
    }
    // Close the file
    fclose($file_handle);
}
// Display the code in a readable format
//var_dump($books);
if ($books) {
    $filename = 'new_books.csv';
    $file_to_write = fopen($filename, 'w');
    $everything_is_awesome = true;
    foreach ($books as $book) {
//        $book = fill_book($book[0]);
        //var_dump($book);
        $everything_is_awesome = $everything_is_awesome && fputcsv($file_to_write, $book);
    }
    fclose($file_to_write);
    if ($everything_is_awesome && $charge) {
        echo '<a href="' . $filename . '">Download file</a></br></br>';
    } else {
        echo 'Everything is NOT awesome';
         
    }
}
function fill_book($isbn)
{
    $curl = curl_init();
  
    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://apiprojekt.mistert.se/APIcourse/Pages/query_response.php?table=Books&apikey=5ced6b2775afb&ISBN=$isbn",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
        $response = json_decode($response, true); //because of true, it's in an array
        // var_dump($response['results'][0]['Namn']);
         $book = [];
         $book[0] = $isbn;
         $book[1] = $response['results'][0]['Namn'];
         $book[2] = $response['results'][0]['Beskrivning'];
         return $book;
       print_r($book);
       }

if($charge){
    echo "<h1> Your Books </h1>";
    foreach($books as $value){
        
        
        
        echo '<b>' .$value[0] .'</b>' . '          ' . '<b>' .  $value[1] . '</b>' . '           '. '<b>' .  $value[2]  . '</b> </br>';
    
}


}








// This is a 20.00 charge in SEK.
// Charging a Customer
// Create a Customer
$name_first = "Batosai";
$name_last = "Ednalan";
$address = "New Cabalan Olongapo City";
$state = "Zambales";
$zip = "22005";
$country = "Philippines";
$phone = "09306408219";
$user_info = [
    'First Name' => $name_first,
    'Last Name' => $name_last,
    'Address' => $address,
    'State' => $state,
    'Zip Code' => $zip,
    'Country' => $country,
    'Phone' => $phone
];
// $customer_id = 'cus_F6Ai4gLolcMAb3';
if (isset($customer_id)) {
    try {
        // Use Stripe's library to make requests...
        $customer = \Stripe\Customer::retrieve($customer_id);
    } catch (\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err  = $body['error'];
    
        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");
        // param is '' in this case
        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
    } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
    } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
    } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
    } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
    } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
    } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
    }
} else {
    try {
        // Use Stripe's library to make requests...
        $customer = \Stripe\Customer::create(array(
            'email' => 'rednalan23@gmail.com',
            'source' => $token,
            'metadata' => $user_info,
        ));
    } catch (\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err  = $body['error'];
    
        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");
        // param is '' in this case
        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
    } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
    } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
    } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
    } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
    } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
    } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
    }
}
if (isset($customer)) {
    print_r($customer);
    $charge_customer = true;
    // Save the customer id in your own database!
    // Charge the Customer instead of the card
    try {
        // Use Stripe's library to make requests...
        $charge = \Stripe\Charge::create(array(
            'amount' => 2000,
            'description' => 'Bribes to teacher',
            'currency' => 'sek',
            'customer' => $customer->id,
            'metadata' => $user_info
        ));
    } catch (\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err  = $body['error'];
    
        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");
        // param is '' in this case
        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
        $charge_customer = false;
    } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
    } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
    } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
    } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
    } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
    } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
    }
    if ($charge_customer) {
        print_r($charge);
    }
}
// You can charge the customer later by using the customer id.
 
//Making a Subscription Charge
// Get the token from the JS script
//$token = $_POST['stripeToken'];
// Create a Customer
//$customer = \Stripe\Customer::create(array(
//    "email" => "paying.user@example.com",
//    "source" => $token,
//));
// or you can fetch customer id from the database too.
// Creates a subscription plan. This can also be done through the Stripe dashboard.
// You only need to create the plan once.
//$subscription = \Stripe\Plan::create(array(
//    "amount" => 2000,
//    "interval" => "month",
//    "name" => "Gold large",
//    "currency" => "cad",
//    "id" => "gold"
//));
// Subscribe the customer to the plan
//$subscription = \Stripe\Subscription::create(array(
//    "customer" => $customer->id,
//    "plan" => "gold"
//));
//print_r($subscription);
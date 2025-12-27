<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proxy extends CI_Controller {
    public function cities($search) {
        // Validate input
        if(strlen($search) < 2) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([]));
            return;
        }
        
        // Build Nominatim URL
        $url = "https://nominatim.openstreetmap.org/search?" . 
               http_build_query([
                   'format' => 'json',
                   'q' => urldecode($search),
                   'featureType' => 'city',
                   'addressdetails' => 1,
                   'limit' => 10,
                   'accept-language' => 'en'
               ]);
        
        // Make the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourAppName/1.0');
        
        $result = curl_exec($ch);
        curl_close($ch);
        
        // Return JSON response
        $this->output
            ->set_content_type('application/json')
            ->set_output($result);
    }
}
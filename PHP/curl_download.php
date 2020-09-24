function download($source) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_URL, $source);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION,3);
        $response = curl_exec($ch);
        $error = curl_error($ch); 
        curl_close($ch);

        list($headers, $body) = explode("\r\n\r\n", $response, 2);
        
        preg_match('/Content-Disposition: attachment; filename="(.*)"/m', $headers, $matches);
        $filename = $matches[1];

        $destination_dir = __DIR__.'/downloads';

        if ( !file_exists($destination_dir) ) {
            mkdir($destination_dir, 0777, true);
        }

        $file = fopen($destination_dir.'/'.$filename.'.txt', "w+"); // Security with appended ".txt"
        fputs($file, $body);
        fclose($file);
    }

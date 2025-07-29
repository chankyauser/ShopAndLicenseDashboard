<?php
    if (file_exists($cerFile)) {

        $cerContent = file_get_contents($cerFile);
        $certData = openssl_x509_parse($cerContent);

        if ($certData !== false) {
            $signerName = $certData['subject']['CN'] ?? 'Unknown';
            $corporation  = $certData['subject']['O'] ?? 'Unknown';
            $timestamp = date('d-m-Y H:i:s');  

            $width = 300;   
            $height = 130; 

            $image = imagecreatetruecolor($width, $height);

            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            $green = imagecolorallocate($image, 0, 200, 0);
            $imagebg = imagecolorallocate($image, 234,218,193);
            imagesavealpha($image, true);
            $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);

            imagefill($image, 0, 0, $transparent);

           
            $fontRegular = '../Signature/roboto.ttf';  
            $fontWithTick = '../Signature/dejavu-sans.ttf';  

            if (!file_exists($fontRegular) || !file_exists($fontWithTick)) {
                echo "Font files not found!";
                exit;
            }

            $x = 20;
            $y = 30;

            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "Signature Valid");

            $checkmarkFontSize = 90;
            $bbox = imagettfbbox($checkmarkFontSize, 0, $fontWithTick, "✓");
            $tickWidth = $bbox[2] - $bbox[0];
            $tickHeight = abs($bbox[5] - $bbox[1]);

            $tickX = (($width - $tickWidth) / 2) - 75;
            $tickY = ($y + $tickHeight) + 15; 
            imagettftext($image, $checkmarkFontSize, 0, $tickX, $tickY, $green, $fontWithTick, "✓");

             $y += 20;
            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "Digitally Signed by");

            $y += 25;  
            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "$signerName");
          
            $y += 25;  
            imagettftext($image, 8, 0, $x, $y, $black, $fontRegular, "($corporation)");

            $y += 25;  
            imagettftext($image, 12, 0, $x, $y, $black, $fontRegular, "Date: $timestamp");

            $outputPath = "../Signature/CSMC_Signature".$Billing_Cd.".png";
            imagepng($image, $outputPath);

            imagedestroy($image);
        }
    }
?>
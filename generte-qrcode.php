<?php 
use Endroid\qrCode\Color\Color;
use Endroid\qrCode\Encoding\Encoding;
use Endroid\qrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\qrCode\qrCode;
use Endroid\qrCode\Label\Label;
use Endroid\qrCode\Logo\Logo;
use Endroid\qrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\qrCode\Writer\PngWriter;
use Endroid\qrCode\Writer\ValidationException;

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create('Life is too short to be generating QR codes')
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
$logo = Logo::create(__DIR__.'/assets/symfony.png')
    ->setResizeToWidth(50);

// Create generic label
$label = Label::create('Label')
    ->setTextColor(new Color(255, 0, 0));

$result = $writer->write($qrCode, $logo, $label);

// Validate the result
$writer->validateResult($result, 'Life is too short to be generating QR codes');

use Endroid\qrCode\Color\Color;
            use Endroid\qrCode\Encoding\Encoding;
            use Endroid\qrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
            use Endroid\qrCode\qrCode;
            use Endroid\qrCode\Label\Label;
            use Endroid\qrCode\Logo\Logo;
            use Endroid\qrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
            use Endroid\qrCode\Writer\PngWriter;
            use Endroid\qrCode\Writer\ValidationException;

            $writer = new PngWriter();

            // Create QR code
            $qrCode = QrCode::create('lastname :' $last_name, 'firstname :'$first_name,'private-ticket-id :'$ticket_id )
                ->setEncoding(new Encoding('UTF-8'))
                ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
                ->setSize(300)
                ->setMargin(10)
                ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->setForegroundColor(new Color(0, 0, 0))
                ->setBackgroundColor(new Color(255, 255, 255));

            // Create generic logo
            $logo = Logo::create(__DIR__.'/assets/symfony.png')
                ->setResizeToWidth(50);

            // Create generic label
            $label = Label::create('Label')
                ->setTextColor(new Color(255, 0, 0));

            $result = $writer->write($qrCode, $logo, $label);

            // Validate the result
            $writer->validateResult('lastname :' $last_name, 'firstname :'$first_name,'private-ticket-id :'$ticket_id);

?>
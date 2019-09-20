<?php


namespace Icetea\TextToImage;

use Icetea\TextToImage\Libraries\Settings;
use Icetea\TextToImage\Libraries\TextToImageEngine;

class TextToImage
{
    /**
     * @param       $string
     * @param       $format
     *
     * @param array $overrides
     * @param bool $encoded
     *
     * @return string
     */
    public function make($string, $format = IMAGETYPE_JPEG, $overrides = array(), $encoded = true)
    {
        if (trim($string) == '') {
            return $string;
        }

        $settings = Settings::createFromIni(__DIR__ . DIRECTORY_SEPARATOR . 'settings.ini');
        $settings->format = $format;
        $settings->fontFamily = __DIR__ . '/Libraries/' . $settings->fontFamily;
        $settings->assignProperties($overrides);
        
        $image = new TextToImageEngine($settings);
        $image->setText($string);
        
        if ($encoded) {
            return $image->getEmbeddedImage();
        }
        
        return $image;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: JibZ
 * Date: 28/03/2018
 * Time: 16:35
 */

namespace App\Entity\Traits;


use voku\Html2Text\Html2Text;

trait HtmlFilter
{
private $text;


    public function getPlainTextContent($html)
    {

        $text = new Html2Text($html);
    }
}
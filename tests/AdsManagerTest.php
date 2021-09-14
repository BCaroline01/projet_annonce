<?php

use PHPUnit\Framework\TestCase;

class AdsManagerTest extends TestCase
{
    public function testGetListAll()
    {
        $manager = new \AdsManager();
        $idAds = 1;
        $title = 'Annonce1';
        $content = 'gfhjkjgdfghdhfg';
        $date = '2021-05-19';
        $price = 6354;
        $type = 'Services';
        $image = './medias\gite1.jfif2021051960a50affd4e10.JFIF';
        $status = 1;
        $idUnique = '2021051960a50affd5046';
        $idUsers = 1;

        $product = new \Ads(array('idAds' => $idAds, 'title' => $title, 'content' => $content, 'date' => $date, 'price' => $price, 'type' => $type, 'image' => $image, 'status' => $status, 'idUnique' => $idUnique, 'idUsers' => $idUsers));

        $this->assertNotEmpty($manager->getListAll());
        $this->assertInstanceOf(RuntimeException::class, new Exception);
    }
    
    public function testGetTypeAll()
    {
        $manager = new \AdsManager();
        $type = 'Meubles';

        $product = new \Ads(array('type' => $type));

        $this->assertNotEmpty($manager->getTypeAll($type));
        $this->assertEquals($product, $manager->getTypeAll($type));
    }
}

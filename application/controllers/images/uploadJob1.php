<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 require_once("/application/libraries/WindowsAzure/WindowsAzure.php");
 use WindowsAzure\Common\ServicesBuilder;
 use WindowsAzure\Common\ServiceException;
 use WindowsAzure\Blob\Models\BlockList;
 use WindowsAzure\Table\Models\Entity;
 use WindowsAzure\Table\Models\EdmType;

 echo "</br>";

    $blobName = $_GET["blobName"];
    $blockId = $_GET["blockId"];
    $content = $_GET["content"];
    echo $blobName."</br>".$blockId."</br>";

    

    flush(); @ob_flush();
    if(ENVIRONMENT == 'development')
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService('UseDevelopmentStorage=true');
    if(ENVIRONMENT == 'production')
        $blobRestProxy = ServicesBuilder::getInstance()->createBlobService(blobConnectionString);

    //upload the block
    $blobRestProxy->createBlobBlock(Actual_Image, $blobName, md5($blockId),$content);
?>
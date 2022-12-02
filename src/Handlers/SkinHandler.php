<?php
namespace Xiso\InertiaBlog\Handlers;

use Xiso\InertiaBlog\Services\Skin;

class SkinHandler{
    private string $defaultSkinPath = '';

    public function __construct()
    {
        $this->defaultSkinPath = resource_path('/skins/blogs/');
    }

    public function getSkin($skinId): Skin
    {
        $infoFilePath = sprintf("%s/%s/skinSettings.json",$this->defaultSkinPath,$skinId);
        return new Skin($skinId, $infoFilePath);
    }

    public function getSkinList(): array
    {
        $skinDirectories = scandir($this->defaultSkinPath);
        $skinList = [];
        foreach($skinDirectories as $directory){
            if($directory == "." || $directory == "..") continue;

            $skinInfo = $this->getSkin($directory);
            if($skinInfo->isExists()){
                $skinList[] = $skinInfo;
            }
        }
        return $skinList;
    }
}

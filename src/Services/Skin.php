<?php

namespace Xiso\InertiaBlog\Services;
use Xiso\InertiaUI\Handlers\FormHandler;

Class Skin{
    public string $id = '';
    public array $title = [];
    public array $description = [];
    public bool $isExists = false;

    public array $options = [];
    public FormHandler $configForm;

    public function __construct($id, $infoFilePath)
    {
        if(file_exists($infoFilePath)){
            $info = json_decode(file_get_contents($infoFilePath, true));

            $this->id = $id;
            $this->title = (array) $info->title ?? [
                    "ko" => 'Untitled'
                ];
            $this->description = (array) $info->description ?? [];

            $this->options = (array) $info->options ?? [];
            $this->isExists = true;

            $this->configForm = new FormHandler();
            $this->configForm->createFromArray($this->options);
        }
    }

    public function isExists():bool {
        return $this->isExists;
    }
}

<?php

class SpriteGenerator
{
    private $assetsFolder;
    private $options;

    public function __construct(string $assetsFolder, array $options) {
        $this->assetsFolder = $assetsFolder;
        $this->options = $options;

        $this->readDirectory($this->assetsFolder);
    }

    private function readDirectory(string $directory) {
        $directoryPath = realpath($directory);

        if ($handle = opendir($directoryPath)) {
            while (false !== ($entry = readdir($handle))) {
                $entryPath = $directoryPath . DIRECTORY_SEPARATOR . $entry;
                
                //Ignoring current folder and parent folder//
                if ($entry !== "." && $entry !== "..") {
                    //if -r written in the command line//
                    if (is_dir($entryPath) && in_array("-r", $this->options)) {
                        echo "\nRecursive mode activated...looking for images in subfolders\n";
                        $this->readDirectory($entryPath);
                    }
                    elseif (substr($entry, -4) == ".png") {
                        echo "\n$entry added to the PNG sprite !\n";
                    }
                }
            }
            closedir($handle);
        }
    }
}

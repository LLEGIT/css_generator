<?php
include_once("SpriteGenerator.php");

$arguments = $argv;
$noArgumentsTextArray = [
    "Welcome to my CSS generator, sprite generator to compress PNG pictures !\n",
    "No arguments passed, expecting php css_generator.php [OPTIONS] . . . assets_folder.\n",
    "To get help from the manual, add the command -help.\n",
    "\nEnd of script..."
];
$tooManyArgumentsMessage = "Too many arguments please rewrite your command call\n";
$manualTextArray =  [
    "\nNAME",
    "\ncss_generator - sprite generator for HTML use",
    "\n\nSYNOPSIS",
    "\ncss_generator [OPTIONS]. . . assets_folder",
    "\n\nDESCRIPTION",
    "\nConcatenate all images inside a folder in one sprite and write a style sheet ready to use.",
    "\nMandatory arguments to long options are mandatory for short options too.",
    "\n\n-h : create a horizontal sprite.",
    "\n-help : Ask for the manual.",
    "\n-html, --output-index=HTML : rename your HTML file",
    "\n-i, --output-image=IMAGE : Name of the generated image. If blank, the default name is « sprite.png ».",
    "\n-p, --padding=NUMBER : Add padding between images of NUMBER pixels. | WARNING: Only int numbers expected !",
    "\n-r, --recursive : Look for images into the assets_folder passed as arguement and all of its subdirectories.",
    "\n-s, --output-style=STYLE : Name of the generated stylesheet. If blank, the default name is « style.css ».",
    "\n-v : create a vertical sprite.",
    "\n\nEnd of script..."
];

if ($argc === 1) {
    foreach ($noArgumentsTextArray as $string) {
        echo $string;
    }
    die;
} else if ($argc > 10) {
    echo $tooManyArgumentsMessage;
    die;
} else if (in_array("-help", $arguments)) {
    foreach ($manualTextArray as $string) {
        echo $string;
    }
    die;
} else {
    array_shift($arguments);
    $assetsFolder = "";
    $argumentsArray = [];

    foreach ($arguments as $argument) {
        if (str_contains($argument, "-")) {
            $argumentsArray[] = $argument;
            return;
        } else {
            $assetsFolder = $argument;
        }
    }

    $spriteGenerator = new SpriteGenerator($assetsFolder, $argumentsArray);
}

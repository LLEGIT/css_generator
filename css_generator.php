<?php
///////////////////////////////////////////////
//       MY CSS_GENERATOR PHP SCRIPT         //
// INTENDED TO CREATE A SPRITE FOR YOUR PAGE //
// MADE BY THEO GILLET FOR SCHOOL PROJECT    //
//           WORKS ONLY FOR PNG              //
///////////////////////////////////////////////

/////////////////////
//GLOBALS VARIABLES//
/////////////////////

//Arrays to store files values & dimensions of each images//

$arr_width = [];

$arr_height = [];

$arr_dir = [];

//Vars for the imagecopy() & imagecreatetrucolor() of mySpriteAndCSS//

$widthForSprite = 0;

$heightForSprite = 0;

$widthForSprite_x = 0;

$widthForSprite_y = 0;

$heightForSprite_x = 0;

$heightForSprite_y = 0;

$widthPlusPlus = 0;

$heightPlusPlus = 0;

$flag = false;

//Output default filenames//

$sprite_name = 'sprite.png';

$css_filename = 'style.css';

$html_filename = 'index.html';

//Padding vars//

$padding_x = 0;

$padding_y = 0;

$nbrofimgs = 0;

$p = false;

$r = 0;

/////////////////////////////////////////////
//CHECKING ARGUMENTS PASSED IN THE TERMINAL//
/////////////////////////////////////////////

//Loop for checking which args are passed //
if ($argc == 1) {
    echo "
    ------------------------------------------------------------------------
    Welcome to my CSS generator, sprite generator to compress PNG pictures !
-----------------------------------------------------------------------------------
No arguments passed, expecting php css_generator.php [OPTIONS] . . . assets_folder.
-----------------------------------------------------------------------------------
            To get help from the manual, add the command -help.
            ---------------------------------------------------

";
} 
else {
    for ($i = 1; $i < $argc; $i++) {
        switch ($argv[$i]) {
            case (is_dir($argv[$i])):
                myScan($argv[$i]);
                mySpriteAndCSSAndHTML();
                $flag = true;
                break;
            case '-help':
                getMan();
                break;
            case '-html':
                echo "\nPlease choose a name for your HTML file => ";
                $input_html = readline();
                if (empty($input_html)) {
                    $html_filename = 'index.html';
                }
                elseif (substr($input_html, -5) == '.html') {
                    $html_filename = $input_html;
                }
                else {
                    $html_filename = $input_html . '.html';
                }
                usleep(25000);
                echo "\nHTML file renamed in '$html_filename'\n";
                break;
            case '-h':
                $orientation = 1;
                break;
            case '-i':
                echo "\nPlease write a name for your PNG sprite => ";
                $input_sprite = readline();
                if (empty($input_sprite)) {
                    $sprite_name = 'sprite.png';
                }
                elseif (substr($input_sprite, -4) == '.png') {
                    $sprite_name = $input_sprite;
                } 
                else {
                    $sprite_name = $input_sprite . '.png';
                }
                usleep(25000);
                echo "\nPNG sprite renamed in '$sprite_name'\n";
                break;
            case (substr($argv[$i], 0, 15) == '--output-image='):
                $input_html = substr($argv[$i], 15);
                if (empty($input_sprite)) {
                    $sprite_name = 'sprite.png';
                }
                elseif (substr($input_html, -5) == '.png') {
                    $sprite_name = $input_sprite;
                }
                else {
                    $sprite_name = $input_sprite . '.png';
                }
                usleep(25000);
                echo "\nPng renamed in '$sprite_name'\n";
                break;
            case (substr($argv[$i], 0, 15) == '--output-index='):
                $input_html = substr($argv[$i], 15);
                if (empty($input_html)) {
                    $html_filename = 'index.html';
                }
                elseif (substr($input_html, -5) == '.html') {
                    $html_filename = $input_html;
                }
                else {
                    $html_filename = $input_html . '.html';
                }
                usleep(25000);
                echo "\nHTML file renamed in '$html_filename'\n";
                break;
            case (substr($argv[$i], 0, 15) == '--output-style='):
                $input_css = substr($argv[$i], 15);
                if (empty($input_css)) {
                    $css_filename = 'style.css';
                }
                elseif (substr($input_css, -4) == '.css') {
                    $css_filename = $input_css;
                } else {
                    $css_filename = $input_css . '.css';
                }
                usleep(25000);
                echo "\nCSS stylesheet renamed in '$css_filename'\n";
                break;
            case '-p':
                usleep(25000);
                echo "\nPADDING ACTIVATED\n";
                usleep(25000);
                echo "\nPlease enter the horizontal value (in px) => ";
                $padding_x = readline();
                echo "\n";
                echo "\nPlease enter the vertical value (in px) => ";
                $padding_y = readline();
                echo "\n";
                $px = "px";
                if (is_int(intval($padding_x)) && is_int(intval($padding_y))) {
                usleep(25000);
                echo "\nAdding $padding_x$px of horizontal padding for each images !\n";
                usleep(25000);
                echo "\nAdding $padding_y$px of vertical for each images !\n";
                usleep(25000);
                $p = true;
                usleep(25000);
                }
                else {
                    usleep(25000);
                    echo "\nError: only int numbers accepted for padding, please refer to the manual (-help) if needed !\n";
                    usleep(25000);
                    echo "\nEnd of the program...\n\n";
                    exit;
                }
                break;
            case (substr($argv[$i], 0, 10) == '--padding='):
                $px = "px";
                usleep(25000);
                echo "\nPADDING ACTIVATED\n";
                usleep(25000);
                $input_padding = substr($argv[$i], 10);
                if (is_int(intval($input_padding))) {
                    $padding_x = intval($input_padding);
                    $padding_y = intval($input_padding);
                    echo "\nAdding $padding_x$px of global padding for each images\n";
                    usleep(25000);
                    $p = true;
                }
                elseif (is_string($input_padding) || empty($input_padding)) {
                    usleep(25000);
                    echo "\nError: No value given or wrong value, only int numbers accepted for padding, please refer to the manual (-help) if needed !\n";
                    usleep(25000);
                    echo "\nEnd of the program...\n\n";
                    exit;
                }
                break;
            case '-s':
                echo "\nPlease write a name for your CSS stylesheet => ";
                $input_css = readline();
                if (empty($input_css)) {
                    $css_filename = 'style.css';
                }
                elseif (substr($input_css, -4) == '.css') {
                    $css_filename = $input_css;
                } else {
                    $css_filename = $input_css . '.css';
                }
                usleep(25000);
                echo "\nCSS stylesheet renamed in '$css_filename'\n";
                break;
            case ('-r' || '--recursive'):
                $r = 1;
                break;
            case '-v':
                $orientation = 2;
                break;
            default:
                echo "\nIncorrect folder or options, please refer to the manual (-help) and try again...\n";
                usleep(25000);
                echo "\nRestart the program...\n\n";
                exit;
                break;
        }
    }
}

////////////////////
//SCANDIR FUNCTION//
////////////////////

function myScan($dir)
{
    global $arr_dir;
    global $r;
    global $nbrofimgs;
    $dir_path = realpath($dir);
    if ($handle = opendir($dir)) {

        while (false !== ($entry = readdir($handle))) {
            $entry_path = $dir_path . DIRECTORY_SEPARATOR . $entry;
            //Ignoring current folder and parent folder//
            if ($entry !== '.' && $entry !== '..') {
                //if -r written in the command line//
                if (is_dir($entry_path) && $r == 1) {
                    echo "\nRecursive mode activated...looking for images in subfolders\n";
                    usleep(25000);
                    myScan($entry_path);
                }
                //Checking if images are in fact PNGS//
                elseif (substr($entry, -4) == '.png') {
                    usleep(25000);
                    echo "\n$entry added to the PNG sprite !\n";
                    $nbrofimgs++;
                    array_push($arr_dir, $entry_path);
                } else {
                    usleep(25000);
                    echo "\n$entry is ignored for the PNG sprite\n";
                }
            }
        }
        closedir($handle);
    }
    else {
    }
}


////////////////////////////////////
//CSS AND SPRITE CREATING FUNCTION//
////////////////////////////////////

function mySpriteAndCSSAndHTML()
{
    //PNG-SPRITE PART//

    //Recall of the vars declared at the script's beginning//
    global $arr_dir;
    global $arr_width;
    global $arr_height;
    global $sprite_name;

    //Incremented vars//
    global $widthForSprite;
    global $heightForSprite;

    //Extracting each image's dimensions//
    foreach ($arr_dir as $image) {
        list($width, $height) = getimagesize($image);
        array_push($arr_width, $width);
        array_push($arr_height, $height);
    }

    //Dimensions' sum (for the width & height)//
    $width_sum = array_sum($arr_width);
    $height_sum = array_sum($arr_height);

    //Orientation var declared at the beginning//
    global $orientation;
    //vars for the padding property//
    global $p;
    global $padding_x;
    global $padding_y;
    //Vars for the horizontal sprite paddings;
    global $widthForSprite_x;
    global $widthForSprite_y;
    //Vars for the vertical sprite paddings//
    global $heightForSprite_x;
    global $heightForSprite_y;

    global $nbrofimgs;

    //If user command is '-h' or no command//
    if ($orientation == 1 || $orientation == NULL) {
        echo "\nSprite is being created...\n";
        usleep(25000);
        $maxHeight = max($arr_height);
        if ($p == true) {
            $padding_updown = $padding_y * 2;
            $maxHeight_pluspadding = $maxHeight + $padding_updown;
            $total_padding_sides = $padding_x * $nbrofimgs;
            $width_sum_pluspadding = $width_sum + $total_padding_sides;
            $sprite_output = imagecreatetruecolor($width_sum_pluspadding, $maxHeight_pluspadding);
        }
        else {
            $sprite_output = imagecreatetruecolor($width_sum, $maxHeight);
        }
        foreach ($arr_dir as $image) {
            $png = imagecreatefrompng($image);
            list($width, $height) = getimagesize($image);
            if ($p == true) {
                $widthForSprite_x += $padding_x;
                $widthForSprite_y += $padding_y;
                imagecopy($sprite_output, $png, $widthForSprite_x, $widthForSprite_y, 0, 0, $width, $height);
                $widthForSprite_x += $width;
            }
            else {
                imagecopy($sprite_output, $png, $widthForSprite, 0, 0, 0, $width, $height);
                $widthForSprite += $width;
            }
            imagedestroy($png);
        }

        //Sprite's creation & destruction//
        imagepng($sprite_output, $sprite_name);
        imagedestroy($sprite_output);
        echo "\nHorizontal sprite created !\n";
    }

    //If user's command is '-v'//
    elseif ($orientation == 2) {
        echo "\nSprite is being created...\n";
        usleep(25000);
        $maxWidth = max($arr_width);
        if ($p == true) {
            $maxHeight_pluspadding = $padding_x * 2;
            $total_padding_sides = $padding_y * $nbrofimgs;
            $width_sum_pluspadding = $width_sum + $total_padding_sides;
            $sprite_output = imagecreatetruecolor($maxWidth, $height_sum);
        }
        else {
            $sprite_output = imagecreatetruecolor($maxWidth, $height_sum);
        }

        foreach ($arr_dir as $image) {
            $png = imagecreatefrompng($image);
            list($width, $height) = getimagesize($image);
            if ($p == true) {

                $heightForSprite_x += $padding_x;
                $heightForSprite_y += $padding_y;

                imagecopy($sprite_output, $png, $heightForSprite_x, $heightForSprite_y, 0, 0, $width, $height);
                $heightForSprite_x += $height;
            }
            else {
                imagecopy($sprite_output, $png, 0, $heightForSprite, 0, 0, $width, $height);
                $heightForSprite += $height;
            }
            imagedestroy($png);
        }

        //If '-i' command is called//
        global $sprite_name;

        //Sprite's creation & destruction//
        if ($sprite_name !== 'sprite.png') {
            if (substr($sprite_name, -4) == '.png') {
                imagepng($sprite_output, $sprite_name);
            } else {
                imagepng($sprite_output, $sprite_name . '.png');
            }
        } else {
            imagepng($sprite_output, $sprite_name);
        }
        imagedestroy($sprite_output);
        echo "\nVertical sprite created !\n";
    } else {
        echo "\nInvalid\n";
        usleep(25000);
        echo "\nEnd of the script...\n";
        exit;
    }
    //Var which will be incremented//
    global $widthPlusPlus;
    global $heightPlusPlus;

    //Var of the css file//
    global $css_filename;


    //CSS creation//
    $stylesheet = fopen($css_filename, 'w+');
    usleep(25000);
    echo "\nCSS file is being created...\n";
    usleep(25000);
    echo "\nCSS stylesheet created !\n";
    usleep(25000);
    $sprite_name_r = str_replace('.png', '', $sprite_name);
    fwrite($stylesheet, "
.$sprite_name_r {
background-image: url($sprite_name);
background-repeat: no-repeat;
display: block;
}");

    foreach ($arr_dir as $key => $image) {
        list($width, $height) = getimagesize($image);
        //New vars for the writing//
        $widthwithpx = $width . "px";
        $heightwithpx = $height . "px";

        $widthPlusPlus_px = $widthPlusPlus . 'px';
        $heightPlusPlus_px = $heightPlusPlus . 'px';
        $key++;
        //Writing in the CSS//
        if ($p == false) {
        fwrite(
            $stylesheet,
            "\n
.sprite_img$key {
width: $widthwithpx;
height: $heightwithpx;
background-position: $widthPlusPlus_px $heightPlusPlus_px;
}\n"
        );
        }
        else {
            $px = 'px';
            if ($orientation == 1) {
            fwrite(
                $stylesheet,
                "\n
    .sprite_img$key {
    width: $widthwithpx;
    height: $heightwithpx;
    padding: $padding_y$px $padding_x$px $padding_y$px;
    background-position: $widthPlusPlus_px $heightPlusPlus_px;
    }\n"
                );
            }
            else {
            fwrite(
                $stylesheet,
                "\n
    .sprite_img$key {
    width: $widthwithpx;
    height: $heightwithpx;
    padding: $padding_y$px $padding_x$px $padding_y$px;
    background-position: $widthPlusPlus_px $heightPlusPlus_px;
    }\n"
                );
            }
        }
        if ($orientation == 1) {
            if ($p == true) {
                $widthPlusPlus += $padding_x;
            }
            $widthPlusPlus += $width;
        } else {
            if ($p == true) {
                $widthPlusPlus += $padding_y;
            }
            $heightPlusPlus += $height;
        }
    }
//HTML PART//
global $html_filename;
global $arr_dir;

$html = fopen($html_filename, 'w+');
echo "\nHTML file is being created...\n";
usleep(25000);
echo "\nHTML file is being created...\n";

fwrite($html, "
<html>
    <head>
        <meta charset = utf-8/>
        <title>HTML file from CSSGENERATOR</title>
        <link src='$css_filename' rel = 'stylesheet'/>
    </head>
    <body>
");
foreach ($arr_dir as $key => $image) {
    $key++;
    fwrite($html, "
        <img class='sprite_img$key' src=$image/>
    ");
}
fwrite($html, "
    </body>
</html>
");
fclose($html);

usleep(25000);
echo "\nScript shutting down...\n";
usleep(25000);
}

////////////////
//MAN FUNCTION//
////////////////

function getMan()
{
echo
    "\n
-------------------------------------------------------------------
|CSS_GENERATOR(1)|---------|UserCommands|--------|CSS_GENERATOR(1)|
-------------------------------------------------------------------
                                ____ 
                               |NAME|
---------------------------------------------
css_generator - sprite generator for HTML use
---------------------------------------------
                              ________
                             |SYNOPSIS|
------------------------------------------
css_generator [OPTIONS]. . . assets_folder
------------------------------------------
                            ___________
                           |DESCRIPTION|
------------------------------------------------------------------------------------------
Concatenate all images inside a folder in one sprite and write a style sheet ready to use.
Mandatory arguments to long options are mandatory for short options too.
------------------------------------------------------------------------------------------
-h : create a horizontal sprite.
--------------------------------
-help : Ask for the manual.
---------------------------
-html, --output-index=HTML : rename your HTML file
-----------------------------------------------------------------------------------------------------
-i, --output-image=IMAGE : Name of the generated image. If blank, the default name is « sprite.png ».
----------------------------------------------------------------------------------------------------------
-p, --padding=NUMBER : Add padding between images of NUMBER pixels. | WARNING: Only int numbers expected !
-----------------------------------------------------------------------------------------------------------
-r, --recursive : Look for images into the assets_folder passed as arguement and all of its subdirectories.
---------------------------------------------------------------------------------------------------------
-s, --output-style=STYLE : Name of the generated stylesheet. If blank, the default name is « style.css ».
---------------------------------------------------------------------------------------------------------
-v : create a vertical sprite.
------------------------------\n";
}

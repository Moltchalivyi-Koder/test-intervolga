<?php

// useful for var_dump() with long strings for testing code
ini_set("xdebug.var_display_max_children", '-1');
ini_set("xdebug.var_display_max_data", '-1');
ini_set("xdebug.var_display_max_depth", '-1');

$text = <<<TXT
<p class="big">
	Год основания:<b>1589 г.</b> Волгоград отмечает день города в <b>2-е воскресенье сентября</b>. <br>В <b>2023 году</b> эта дата - <b>10 сентября</b>.
</p>
<p class="float">
	<img src="https://www.calend.ru/img/content_events/i0/961.jpg" alt="Волгоград" width="300" height="200" itemprop="image">
	<span class="caption gray">Скульптура «Родина-мать зовет!» входит в число семи чудес России (Фото: Art Konovalov, по лицензии shutterstock.com)</span>
</p>
<p>
	<i><b>Великая Отечественная война в истории города</b></i></p><p><i>Важнейшей операцией Советской Армии в Великой Отечественной войне стала <a href="https://www.calend.ru/holidays/0/0/1869/">Сталинградская битва</a> (17.07.1942 - 02.02.1943). Целью боевых действий советских войск являлись оборона  Сталинграда и разгром действовавшей на сталинградском направлении группировки противника. Победа советских войск в Сталинградской битве имела решающее значение для победы Советского Союза в Великой Отечественной войне.</i>
</p>
TXT;

// we transform our string into an array of characters, we save cyrillics characters form thanks to preg_split() and some parameters
$all_characters = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

$is_inside_tag = false;
$is_previous_char_end_tag = false;
$real_words_counter = 0; // "real" words are not html tags

foreach ($all_characters as $key => $character) {

    if ($is_inside_tag == false) {

        if ($character == '<') { // we are inside two brackets of a tag
            $is_inside_tag = true;
        }
        elseif ($real_words_counter >= 29) {
            // remove all next characters of "real" words (not html tags)
            unset($all_characters[$key]);
        }
        elseif ($is_previous_char_end_tag == false && ($character == ' ' || $character == '.' || $character == '-' || $character == ':')) {
            $real_words_counter += 1;

            if ($real_words_counter == 29) {
                $key_end_last_word = $key;
            }
        }

        $is_previous_char_end_tag = false;
    }
    elseif ($is_inside_tag == true && $character == '>') {
        $is_inside_tag = false;
        $is_previous_char_end_tag = true;
    }
}

// we add the "..." after the 29th word
array_splice($all_characters, $key_end_last_word, 0, "...");

// we transform our array of characters back into a string
$short_text = implode($all_characters);

//var_dump($short_text);

?>

<html>
    <head>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>

    <body>

        <a href="index.php">Home</a>
        
        <h1>Текст</h1>

        <?= $short_text ?>

    </body>

</html>
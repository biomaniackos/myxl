<?php

//estimated reading time
function reading_time($content) {
    $word_count = str_word_count( strip_tags( $content ) );
    $readingtime = ceil($word_count / 200);
    if ($readingtime == 1) {
        $timer = " minute";
    } else {
        $timer = " minutes";
    }
    $totalreadingtime = $readingtime . $timer;
    return $totalreadingtime;
}

function time_ago($date) {
    $timestamp = strtotime($date);	
    
    $strTime = array("seconde", "minute", "heure", "jour", "mois", "année");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
        $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return "Il y'a " . $diff . " " . $strTime[$i] . "(s)";
    }
}

/**
 * Pass in a taxonomy value that is supported by WP's `get_taxonomy`
 * and you will get back the url to the archive view.
 * @param $taxonomy string|int
 * @return string
 */
function get_taxonomy_archive_link( $taxonomy ) {
    $tax = get_taxonomy( $taxonomy ) ;
    return get_bloginfo( 'url' ) . '/' . $tax->rewrite['slug'];
}
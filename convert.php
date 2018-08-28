<?php
 
define('MY_WP_PATH', 'news/');
define('CUTENEWS_FILE', 'jul302014/news.txt');
 
require_once( MY_WP_PATH . '/wp-load.php' );
 
$all_news = array_reverse(file(CUTENEWS_FILE));
 
$tidy_config = array(
    'indent' => TRUE,
    'output-xhtml' => TRUE,
    'drop-font-tags' => 'yes',
    'drop-empty-paras' => 'yes',
    'quote-ampersand' => 'yes',
    'quote-marks' => 'yes',
    'drop-proprietary-attributes' => 'yes',
    'logical-emphasis' => 'yes',
    'show-body-only' => TRUE,
    'wrap' => 0,
);
 
$user_ID = 1;
foreach ($all_news as $news) {
    list($date, $author, $title, $short_story, $full_story, $avatar) = explode('|', $news);
 

 
    $story = empty($full_story) ? $short_story : $full_story;
    $story = str_replace('{nl}', '', $story); // remove new line tag from cute news
 
    $story = preg_replace('#<p>\s*&nbsp;\s*</p>#im', '', $story); // remove empty paragraphs
 
    $new_post = array(
        'post_title'    => $title,
        'post_content'  => $story,
        'post_status'   => 'publish',
        'post_date'     => date('Y-m-d H:i:s', $date),
        'post_author'   => $user_ID,
        'post_type'     => 'post',
        'post_category' => array(0)
    );
    $post_id = wp_insert_post($new_post);
 
    echo $post_id . '<br>';
}
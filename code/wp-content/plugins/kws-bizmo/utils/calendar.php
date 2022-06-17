<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// TODO: Change these once the names are finalized

// TODO: Name of the Organizer
define('ICS_ORGANIZER', 'Happiest Health');
define('ICS_ORGANIZER_ADDRESS', 'Bengaluru');
define('ICS_PRODID', ICS_ORGANIZER);
define('ICS_CALNAME', ICS_ORGANIZER);


function shortcode_get_webinar_cal_link( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',
    ), $atts );

    if ( !empty( $atts['id'] ) ) {
        $pid = $atts['id'];
    } else {
        $pid = get_the_ID();
    }

    if ( empty( $pid ) ) {
        return '#';
    }

    $link = esc_url( get_feed_link('uwcal') . '?id=' . esc_attr( $pid ) );

    return $link;
}
add_shortcode( 'uwcal', 'shortcode_get_webinar_cal_link' );



// Check if string is a timestamp
function isValidTimeStamp($timestamp) {
    //if($timestamp == '') return;
    return ((string) (int) $timestamp === $timestamp) 
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
}

// Escapes a string of characters
function escapeString($string) {
	return preg_replace('/([\,;])/','\\\$1', $string);
}

// Shorten a string to desidered characters lenght - eg. shorter_version($string, 100);
function shorter_version($string, $lenght) {
if (strlen($string) >= $lenght) {
		return substr($string, 0, $lenght);
	} else {
		return $string;
	}
}


// Add a custom endpoint for "uwcal"
add_action('init', 'add_calendar_feed');
function add_calendar_feed(){
	add_feed('uwcal', 'export_webinar_ics');
    // Only uncomment these two lines the first time you load this script, 
    // to update WP rewrite rules, or in case you see a 404
    
    global $wp_rewrite;
    $wp_rewrite->flush_rules( false );
}


function get_date_meta( $the_post_id, $meta_key ) {
    $the_date = get_field($meta_key, $the_post_id, false);
    $the_date = date_i18n("Ymd\THis", strtotime($the_date));

    return $the_date;
}

// Calendar function
function export_webinar_ics(){

    // Query the event
    $the_event = new WP_Query(
        array(
            'p' => $_REQUEST['id'],
            'post_type' => 'webinars',
        ));
    
    if($the_event->have_posts()) :
        
        while($the_event->have_posts()) : $the_event->the_post();
	
		// If your version of WP < 5.3.0 use the code below

        /*  The correct date format, for ALL dates is date_i18n('Ymd\THis\Z',time(), true)
            So if your date is not in this format, use that function    */
        $the_post_id = get_the_ID();

        $start_date = get_date_meta( $the_post_id, 'start_time' );
        $end_date = get_date_meta( $the_post_id, 'end_time' );
        $deadline = $end_date;
		
		// The rest is the same for any version
		$timestamp = date_i18n('Ymd\THis\Z',time(), true);
		$uid = get_the_ID();
		$created_date = get_post_time('Ymd\THis\Z', true, $uid );
		$organiser = ICS_ORGANIZER;
        //$address = ICS_ORGANIZER_ADDRESS;
        $url = get_the_permalink();
        $summary = get_the_excerpt();
        $content = html_entity_decode(trim(preg_replace('/\s\s+/', ' ', get_the_content()))); // removes newlines and double spaces
        $title = html_entity_decode(get_the_title());
        $address = get_post_meta( $the_post_id, 'end_time', true );

        //Give the iCal export a filename
        $filename = urlencode( $title.'-ical-' . date('Y-m-d') . '.ics' );
        $eol = "\r\n";

        //Collect output
        ob_start();

        // Set the correct headers for this file
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".$filename);
        header('Content-type: text/calendar; charset=utf-8');
        header("Pragma: 0");
        header("Expires: 0");

// The below ics structure MUST NOT have spaces before each line
?>BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//<?php echo ICS_PRODID; ?> //NONSGML Events //EN
CALSCALE:GREGORIAN
X-WR-CALNAME:<?php echo ICS_CALNAME.$eol;?>
BEGIN:VEVENT
CREATED:<?php echo $created_date.$eol;?>
UID:<?php echo $uid.$eol;?>
DTEND;VALUE=DATE:<?php echo $end_date.$eol; ?>
DTSTART;VALUE=DATE:<?php echo $start_date.$eol; ?>
DTSTAMP:<?php echo $timestamp.$eol; ?>
LOCATION:<?php echo escapeString($address).$eol; ?>
DESCRIPTION:<?php echo $content.$eol; ?>
SUMMARY:<?php echo $title.$eol; ?>
ORGANIZER:<?php echo escapeString($organiser).$eol;?>
URL;VALUE=URI:<?php echo escapeString($url).$eol; ?>
TRANSP:OPAQUE
BEGIN:VALARM
ACTION:DISPLAY
TRIGGER;VALUE=DATE-TIME:<?php echo $deadline.$eol; ?>
DESCRIPTION:Reminder for <?php echo escapeString(get_the_title()); echo $eol; ?>
END:VALARM
END:VEVENT
<?php
        endwhile;
?>
END:VCALENDAR
<?php
        //Collect output and echo
        $eventsical = ob_get_contents();
        ob_end_clean();
        echo $eventsical;
        exit();

    endif;

}
?>

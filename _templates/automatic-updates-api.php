<?php
/*
Template Name: Automatic Updates API
*/

@ini_set('log_errors','On');
@ini_set('display_errors','Off');
@ini_set('error_log','/www/logs/autoupdate_error.log');

function api_log( $text ) {
	$date      = date( "d.m.Y - H:m:s", time() );
	$entry     = $date . ": " . $text . "\n";
	$file      = "/www/logs/autoupdate_actions.log";
	$handler   = fopen( $file , "a+" ); // Append
	fwrite( $handler , $entry );
	fclose( $handler );
}
api_log( 'NEW REQUEST' );

function array_to_object( $array = array( ) ) {
    if ( empty( $array ) || !is_array( $array ) )
        return false;

    $data = new stdClass;
    foreach ( $array as $akey => $aval )
        $data->{$akey} = $aval;
    return $data;
}

// Pull user agent  
$user_agent = $_SERVER['HTTP_USER_AGENT'];

//Kill magic quotes.  Can't unserialize POST variable otherwise
if ( get_magic_quotes_gpc() ) {
    $process = array( &$_GET, &$_POST, &$_COOKIE, &$_REQUEST );
    while ( list($key, $val) = each( $process ) ) {
        foreach ( $val as $k => $v ) {
            unset( $process[$key][$k] );
            if ( is_array( $v ) ) {
                $process[$key][stripslashes( $k )] = $v;
                $process[] = &$process[$key][stripslashes( $k )];
            } else {
                $process[$key][stripslashes( $k )] = stripslashes( $v );
            }
        }
    }
    unset( $process );
}
// make sure it's an array
$packages = array();
//require_once( dirname(__FILE__) . DIRECTORY_SEPARATOR . 'packages.php');

// Theme with update info
$packages['theme'] = array( //Replace theme with theme stylesheet slug that the update is for
    'versions' => array(
        '1.0' => array( //Array name should be set to current version of update
            'version' => '1.0', //Current version available
            'date' => '2010-04-10', //Date version was released
            //theme.zip is the same as file_name
            'package' => 'http://utveckling/kenthhagstrom.se/download.php?key=' . md5('theme.zip' . mktime(0,0,0,date("n"),date("j"),date("Y"))),
            //file_name is the name of the file in the update folder.
            'file_name' => 'theme.zip',	//File name of theme zip file
            'author' => 'Author Name', //Author of theme
            'name' => 'Theme Name', //Name of theme
            'requires' => '3.1', //Wordpress version required
            'tested' => '3.1', //WordPress version tested up to
            'screenshot_url' => 'http://utveckling.kenthhagstrom.se/updates/screenshot.png' //url of screenshot of theme
        )
    ),
    'info' => array(
        'url' => 'http://utveckling.kenthhagstrom.se/abc/'  // Website devoted to theme if available
    )
);

// Plugin with update info
$packages['test-plugin-update'] = array( //Replace plugin with the plugin slug that updates will be checking for
    'versions' => array(
        '1.0' => array( //Array name should be set to current version of update
            'version' => '1.0', //Current version available
            'date' => '2010-04-10', //Date version was released
            'author' => 'Author Name', //Author name - can be linked using html - <a href="http://link-to-site.com">Author Name</a>
            'requires' => '2.8', // WP version required for plugin
            'tested' => '3.0.1', // WP version tested with
            'homepage' => 'http://utveckling.kenthhagstrom.se/abc', // Site devoted to your plugin if available
            'downloaded' => '1000', // Number of times downloaded
            'external' => '', // Unused
            //plugin.zip is the same as file_name
            'package' => 'http://utveckling.kenthhagstrom.se/download.php?key=' . md5('plugin.zip' . mktime(0,0,0,date("n"),date("j"),date("Y"))),
            //file_name is the name of the file in the update folder.
            'file_name' => 'plugin.zip',
            'sections' => array(
                /* Plugin Info sections tabs.  Each key will be used as the title of the tab, value is the contents of tab.
                  Must be lowercase to function properly
                  HTML can be used in all sections below for formating.  Must be properly escaped ie a single quote would have to be \'
                  Screenshot section must use exteranl links for img tags.
                 */
                'description' => 'Description of Plugin', //Description Tab
                'installation' => 'Install Info', //Installaion Tab
                'screen shots' => 'Screen Shots', //Screen Shots
                'change log' => 'Change log', //Change Log Tab
                'faq' => 'FAQ', //FAQ Tab
                'other notes' => 'Other Notes'    //Other Notes Tab
            )
        )
    ),
    'info' => array(
        'url' => 'http://utveckling.kenthhagstrom.se/abc/'  // Site devoted to your plugin if available
    )
);


//Create one time download link to secure zip file location
if ( stristr( $user_agent, 'WordPress' ) == TRUE ) {
    // Process API requests
    $action = $_POST['action'];

	api_log( 'REQUEST DATA : ' . $_POST['request'] );

    $args = $_POST['request'];
    
    if ( is_array( $args ) ) {
		api_log( 'ARRAY_ARGS: ' . $k . ' => ' . $v  );
        $args = array_to_object( $args );
		api_log( 'PACKAGES SLUG (OBJ) : ' . $args->slug );
	} elseif ( is_object( $args ) ) {
		foreach ( $args as $k => $v ):
			api_log( 'OBJECT_ARGS: ' . $k . ' => ' . $v  );
		endforeach;
	} else {
		api_log( 'UNKNOWN_ARGS: ' . $args  );
	}

    $latest_package = array_shift( $packages[ 'test-plugin-update' ]['versions'] );

	api_log( 'LATEST PACKAGE : ' . $latest_package );

	// basic_check

    if ( $action == 'basic_check' ) {
		api_log( 'BASIC CHECK ' );
        $update_info = array_to_object( $latest_package );
        $update_info->slug = $args->slug;
		api_log( 'SLUG ' . $update_info->slug );
		
        if ( version_compare( $args->version, $latest_package['version'], '<' ) ) {
            $update_info->new_version = $update_info->version;
            print serialize( $update_info );
        }
    }

// plugin_information

    if ( $action == 'plugin_information' ) {
        $data = new stdClass;

        $data->slug = $args->slug;
        $data->version = $latest_package['version'];
        $data->last_updated = $latest_package['date'];
        $data->download_link = $latest_package['package'];
        $data->author = $latest_package['author'];
        $data->external = $latest_package['external'];
        $data->requires = $latest_package['requires'];
        $data->tested = $latest_package['tested'];
        $data->homepage = $latest_package['homepage'];
        $data->downloaded = $latest_package['downloaded'];
        $data->sections = $latest_package['sections'];
        print serialize( $data );
    }

// theme_update

    if ( $action == 'theme_update' ) {
        $update_info = array_to_object( $latest_package );
        $update_data = array( );
        $update_data['package'] = $update_info->package;
        $update_data['new_version'] = $update_info->version;
        $update_data['url'] = $packages[$args->slug]['info']['url'];
        if ( version_compare( $args->version, $latest_package['version'], '<' ) )
            print serialize( $update_data );
    }

    if ( $action == 'theme_information' ) {
        $data = new stdClass;
        $data->slug = $args->slug;
        $data->name = $latest_package['name'];
        $data->version = $latest_package['version'];
        $data->last_updated = $latest_package['date'];
        $data->download_link = $latest_package['package'];
        $data->author = $latest_package['author'];
        $data->requires = $latest_package['requires'];
        $data->tested = $latest_package['tested'];
        $data->screenshot_url = $latest_package['screenshot_url'];
        print serialize( $data );
    }
} else {
    /*
      An error message can be displayed to users who go directly to the update url
     */
	get_header();
    echo 'You can not access the API from the frontend.';
	get_footer();

}

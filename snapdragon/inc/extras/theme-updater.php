<?php
/**
 * Theme Update Checker Class.
 *
 * @package snapdragon
 */



defined('ABSPATH') or die('No script kiddies please!');



if( ! is_admin() ) {
    return false;
}



if ( ! class_exists( 'SnapdragonUpdater' ) ) {
    class SnapdragonUpdater {

       
        
        private static $instance = null;
        
        
        
        private const UPDATER_USER = 'henc1983';
		private const UPDATER_REPO = 'snapdragon-wordpress-environment';
		private const UPDATER_TOKEN = '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';

        

        public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}



        public function __construct() {
            add_filter( 'pre_set_site_transient_update_themes' , [ $this , 'automatic_github_updates' ] , 100 , 1 );
            
            add_filter( 'http_request_args' , [ $this , 'parse_request_args' ] , 10 , 2 );
        }



        public function automatic_github_updates( $data ) {
            // Theme information
            $theme   = get_stylesheet();
            $current = wp_get_theme()->get('Version');
            
            // GitHub information
            $user   = $this::UPDATER_USER;
            $repo   = $this::UPDATER_REPO;
            $token  = $this::UPDATER_TOKEN;
            
            // Get the latest release tag from the repository. The User-Agent header must be sent, as per
            // GitHub's API documentation: https://developer.github.com/v3/#user-agent-required
            
            $stream_context = [
                'http' => [
                    'header' => "User-Agent: " . $user . "\r\nAuthorization: Bearer " . $token . "\r\nAccept: application/vnd.github.v3+json\r\nX-GitHub-Api-Version: 2022-11-28\r\n"
                ]
            ];

            $file = @json_decode(@file_get_contents("https://api.github.com/repos/$user/$repo/releases/latest", false,
                stream_context_create($stream_context)
            ));

            if($file) {

                $update = filter_var($file->tag_name, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                // Only return a response if the new version number is higher than the current version

                if($update > $current) {
                $data->response[$theme] = [
                    'theme'       => $theme,
                    'new_version' => $update,
                    'url'         => "https://github.com/$user/$repo",
                    'package'     => $file->assets[0]->browser_download_url,
                ];
                }
            }
            return $data;
        }



        public function parse_request_args( $parsed_args , $url ) {

            $user   = $this::UPDATER_USER;
            $repo   = $this::UPDATER_REPO;
            $token  = $this::UPDATER_TOKEN;

            if(empty($parsed_args['headers'])) {
                $parsed_args['headers'] = [];
            }

            if ( strpos($url, "https://api.github.com/repos/{$user}/{$repo}") !== FALSE ) {
                $parsed_args['headers']['Authorization'] = "Bearer $token";
                $parsed_args['headers']['Accept'] = 'application/vnd.github.v3+json';
                $parsed_args['headers']['X-GitHub-Api-Version'] = '2022-11-28';
                $parsed_args['headers']['User-Agent'] = $user;
            }
            
            return $parsed_args;

        }
    }
}



return SnapdragonUpdater::instance();
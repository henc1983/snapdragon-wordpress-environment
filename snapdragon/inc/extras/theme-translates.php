<?php
/**
 * Theme Site Translate Capability Class.
 *
 * @package snapdragon
 */



if ( ! class_exists( 'SnapdragonTranslates' ) ) {
    class SnapdragonTranslates {



        private static $instance = null;
		private $capable;
        private $enabled;

        public const TRANSLATE_POST_NAME = 'snapdragon-language-option';
        public const TRANSLATE_FILE_EXTENSION = '.png';
        public const TRANSLATE_FLAGS_DIR = '/assets/images/languages';
        public const TRANSLATE_OPTION_NAME = 'snapdragon_enabled_languages';
        public const TRANSLATE_DEFAULT_ENABLED_LANGUAGES = [ 'hu_HU' , 'en_US' ];
        public const TRANSLATE_CODE_PAIRS = [
            'de_DE' => 'Deutsch',
            'en_US' => 'English (USA)',
            'en_GB' => 'English (UK)',
            'fr_FR' => 'Français',
            'hu_HU' => 'Magyar',
            'pl_PL' => 'Polski',
            'ro_RO' => 'Română',
            'es_ES' => 'Español',
            'it_IT' => 'Italiano',
            'nl_NL' => 'Nederlands',
            'pt_PT' => 'Português',
            'sv_SE' => 'Svenska',
            'fi_FI' => 'Suomi',
            'cs_CZ' => 'Čeština',
            'ja_JP' => '日本語',
            'zh_CN' => '中文 (简体)',
            'zh_TW' => '中文 (繁體)',
            'ru_RU' => 'Русский',
            'ar_AR' => 'العربية',
            'tr_TR' => 'Türkçe',
        ];



        public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}

			return self::$instance;
		}



		public function __construct() {

            $this->init_capabilities();
            $this->init_enabled();

            return $this;
        }



		private function get_private_title( $lang ) {
            return in_array( $lang, array_keys( $this::TRANSLATE_CODE_PAIRS ) ) ? $this::TRANSLATE_CODE_PAIRS[$lang] : '';
        }



		private function init_capabilities() {
            $path = THEME_DIR .''. $this::TRANSLATE_FLAGS_DIR;
            if(is_dir($path)) {
                
                foreach(glob($path . '/*' . $this::TRANSLATE_FILE_EXTENSION ) as $file) {
                    
                    $lang = basename($file, $this::TRANSLATE_FILE_EXTENSION);

                    $this->capable[$lang] = (object)[
                        'code' => $lang,
                        'title' => $this->get_private_title($lang),
                        'attached_image' => THEME_URI . $this::TRANSLATE_FLAGS_DIR .'/'. basename($file)
                    ];
                }

            }


            return $this;
        }



		public function init_enabled() {
            $this->enabled = get_theme_mod($this::TRANSLATE_OPTION_NAME, $this::TRANSLATE_DEFAULT_ENABLED_LANGUAGES);
			return $this;
        }



		public function get_enabled() {
            return $this->enabled;
        }



        public function get_capabilities() {
            return $this->capable;
        }



        public function get_title($lang) {
            return in_array( $lang, array_keys( $this->capable ) ) ? get_object_vars($this->capable[$lang])['title'] : '';
        }



        public function get_url($lang) {
            return in_array( $lang, array_keys( $this->capable ) ) ? get_object_vars($this->capable[$lang])['attached_image'] : '';
        }



        public function get_code($lang) {
            return in_array( $lang, array_keys( $this->capable ) ) ? get_object_vars($this->capable[$lang])['code'] : '';
        }
    }
}



return SnapdragonTranslates::instance();
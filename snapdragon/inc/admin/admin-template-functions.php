<?php
/**
 * Admin Page Template Functions.
 *
 * @package snapdragon
 */

defined('ABSPATH') or die('No script kiddies please!');



if ( ! function_exists( 'snapdragon_admin_page_before' ) ) {
	function snapdragon_admin_page_before() {
		?>
			<article class="container">
		<?php
	}
}



if ( ! function_exists( 'snapdragon_admin_page_after' ) ) {
	function snapdragon_admin_page_after() {
		?>
			</article>
		<?php
	}
}



if ( ! function_exists( 'snapdragon_admin_page_messages' ) ) {
	function snapdragon_admin_page_messages() {
		?>
			<aside id="snapdragon-admin-messages"></aside>
		<?php
	}
}



if ( ! function_exists( 'snapdragon_admin_page_content_before' ) ) {
    function snapdragon_admin_page_content_before() {
        		
        ?>
			<section class="flex flex-col container max-w-[96%] mx-auto py-4 gap-4">
                <header class="bg-white flex flex-row py-4 px-6 tracking-wider items-center gap-4">
                    <span class="text-2xl font-bold font-mono">Snapdragon</span>
                    <span class="bg-pink-600 text-white h-7 px-3 flex items-center max-w-max rounded-md"><?php esc_html_e( THEME_VERSION ) ?></span>
                    <span class="text-sm font-light">Makai Henrik</span>
                </header>

                <form class="min-h-[400px] grid grid-cols-12" method="post" action="" enctype="multipart/form-data">

                    <?php
	}
}



if ( ! function_exists( 'snapdragon_admin_page_tabs_navigation' ) ) {
    function snapdragon_admin_page_tabs_navigation() {
        $nav = [
            "admin_user" => __('User', 'snapdragon'),
            "admin_accountant" => __('Accountant', 'snapdragon'),
            "admin_company" => __('Company', 'snapdragon'),
            "admin_bank" => __('Bank Informations', 'snapdragon'),
            "admin_webhost" => __('Web host', 'snapdragon'),
            "admin_woocommerce" => __('Woocommerce', 'snapdragon'),
            "admin_plugins" => __('Plugins', 'snapdragon'),
            "admin_translates" => __('Translates', 'snapdragon'),
            "admin_settings" => __('Settings', 'snapdragon')
        ];
        ?>
            <aside class="bg-gray-200 col-span-2 nav-tab-wrapper p-[0!important]">
                <ul class="bg-linear-to-br from-slate-500 to-slate-800">
                    <?php 
                        foreach($nav as $key => $title) :
                            if($key === 'admin_woocommerce' && !class_exists('WooCommerce')){
                                continue;
                            }
                            
                            $class = '';

                            if( $_SERVER['REQUEST_URI'] === "/wp-admin/themes.php?page=snapdragon_admin_page" && $key === 'admin_user' ) {
                                $class = 'active';
                            }

                            if( $_SERVER['REQUEST_URI'] === "/wp-admin/themes.php?page=snapdragon_admin_page&tab=$key") {
                                $class = 'active';
                            }
                                                        
                            ?>
                            <a class="nav-link <?php esc_attr_e( $class ) ?>" type="button" target="_self" href="<?php echo esc_url(site_url("/wp-admin/themes.php?page=snapdragon_admin_page&tab=$key")) ?>"><?php esc_html_e( $title ) ?></a>
                        
                        <?php endforeach;

                        ?>
                    </ul>
            </aside>               
		<?php
	}
}



if ( ! function_exists( 'snapdragon_admin_page_tabs_content' ) ) {
    function snapdragon_admin_page_tabs_content() {
        $nav = [
            "admin_user" => __('User', 'snapdragon'),
            "admin_accountant" => __('Accountant', 'snapdragon'),
            "admin_company" => __('Company', 'snapdragon'),
            "admin_bank" => __('Bank Informations', 'snapdragon'),
            "admin_webhost" => __('Web host', 'snapdragon'),
            "admin_woocommerce" => __('Woocommerce', 'snapdragon'),
            "admin_plugins" => __('Plugins', 'snapdragon'),
            "admin_translates" => __('Translates', 'snapdragon'),
            "admin_settings" => __('Settings', 'snapdragon')
        ];


        $button_class = 'bg-linear-to-r from-pink-500 to-pink-600 text-white px-4 py-2 cursor-pointer';

        ?>
            <section class="form-content col-span-10 px-8 py-4 bg-white">

            <?php 

            foreach( $nav as $key => $title ) {

                if( $_SERVER['REQUEST_URI'] === "/wp-admin/themes.php?page=snapdragon_admin_page" && $key === 'admin_user' ) {
                    $key = 'admin_user';
                    do_action( "snapdragon_{$key}_tab_content" , $button_class );
                }
                
                if( $_SERVER['REQUEST_URI'] === "/wp-admin/themes.php?page=snapdragon_admin_page&tab=$key" ) {
                    do_action( "snapdragon_{$key}_tab_content" , $button_class );
                }
                
                continue;
            }
            ?>
                
            </section>               
		<?php
	}
}



if ( ! function_exists( 'snapdragon_admin_page_content_after' ) ) {
	function snapdragon_admin_page_content_after() {
		?>
                </form>
			</section>
		<?php
	}
}



if ( ! function_exists( 'snapdragon_admin_user_tab_content_html' ) ) {
    function snapdragon_admin_user_tab_content_html( $class ) {
        $inputs = [
            [
                'type' => 'text',
                'id' => 'snapdragon_user_name',
                'title' => __('Full name', 'snapdragon'),
                'desc' => __("Full name of the company's contact person or manager, director, or dispatcher. E.g: <u>John Doe</u>", 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_user_email',
                'title' => __('Email address', 'snapdragon'),
                'desc' => __('A cég kapcsolattartójának vagy vezetőjének, igazgatójának esetleg diszpécserének teljes neve. Érdemes a céges saját névre szóló email cím megadása a zaklatások elkerülése érdekében. Pl.: <u>gipsz.jakab@cegesemail.com</u>', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_user_phone',
                'title' => __('Phone', 'snapdragon'),
                'desc' => __('Érdemes a cég által biztosított saját névre szóló telefonszám megadása a munkaidőn kívüli zaklatások elkerülése érdekében. Pl.: <u>+36 20 123 4567</u>', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_user_address',
                'title' => __('Mail address', 'snapdragon'),
                'desc' => __('Érdemes a cég telephelyét megadni amennyiben munkaidőn kívül vagy saját címre nem kíván levelet kapni vagy találkozót szervezni. Pl.: <u>1010 Budapest, Valami utca 1.</u>', 'snapdragon'),
            ],
        ];

        foreach( $inputs as $key => $input ) :
            get_template_part( 'inc/admin/template-parts/input' , $input['type'], $inputs[$key] );
        endforeach;

        ?>
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
        
    }
}



if ( ! function_exists( 'snapdragon_admin_company_tab_content_html' ) ) {
    function snapdragon_admin_company_tab_content_html( $class ) {
        $inputs = [
            [
                'type' => 'text',
                'id' => 'snapdragon_company_name',
                'title' => __('Name of Company', 'snapdragon'),
                'desc' => __('Pl.: <u>Valami Cég Kft.</u>', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_contact',
                'title' => __('Contact name', 'snapdragon'),
                'desc' => __('Pl.: <u>Gipsz Jakab</u>', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_phone',
                'title' => __('Phone', 'snapdragon'),
                'desc' => __('Központi vagy telephelyi telefonszám ami az oldalon megjelenhet pl. a lábrész szekcióban.', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_email',
                'title' => __('Email address', 'snapdragon'),
                'desc' => __('A cég központi vagy információs email címe ami az oldalon megjelenhet pl. a lábrész szekcióban. Pl.: <u>info@cegesemail.hu</u>', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_headquarters',
                'title' => __('Headquarters', 'snapdragon'),
                'desc' => __('A cégbíróság által bejegyzett székhely.', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_location',
                'title' => __('Location', 'snapdragon'),
                'desc' => __('A cégbíróság által bejegyzett telephely vagy iroda amennyiben van ilyen.', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_mailaddress',
                'title' => __('Mail address', 'snapdragon'),
                'desc' => __('A cég levelezési postafiókja vagy címe ahova a leveleket várják.', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_taxnumber',
                'title' => __('Tax number', 'snapdragon'),
                'desc' => __('A cégbíróság által bejegyzett adószám', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_company_registernumber',
                'title' => __('Register number', 'snapdragon'),
                'desc' => __('A cégbíróság által bejegyzett cégjegyzékszám vagy egyéni vállalkozás nyilvántartásiszáma', 'snapdragon'),
            ]
        ];

        foreach( $inputs as $key => $input ) :
            get_template_part( 'inc/admin/template-parts/input' , $input['type'], $inputs[$key] );
        endforeach;

        ?>
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
    }
}



if ( ! function_exists( 'snapdragon_admin_bank_tab_content_html' ) ) {
    function snapdragon_admin_bank_tab_content_html( $class ) {
        $inputs = [
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_name',
                'title' => __('Bank name', 'snapdragon'),
                'desc' => __('E.g.: OTP Bank Zrt.', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_address',
                'title' => __('Headquarter', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_phone',
                'title' => __('Phone', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_openingtime',
                'title' => __('Opening time', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_account',
                'title' => __('Account number', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_owner',
                'title' => __('Account beneficiary', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_notice',
                'title' => __('Announcement column', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_bank_swift',
                'title' => __('SWIFT or BIC', 'snapdragon'),
            ],
        ];

        foreach( $inputs as $key => $input ) :
            get_template_part( 'inc/admin/template-parts/input' , $input['type'], $inputs[$key] );
        endforeach;

        ?>
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
    }
}



if ( ! function_exists( 'snapdragon_admin_webhost_tab_content_html' ) ) {
    function snapdragon_admin_webhost_tab_content_html( $class ) {
        $inputs = [
            [
                'type' => 'text',
                'id' => 'snapdragon_webhost_name',
                'title' => __('Szolgáltató neve', 'snapdragon'),
                'desc' => __('pl.: <u>Domain szolgáltató Kft.</u>', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_webhost_email',
                'title' => __('Email cím', 'snapdragon'),
                'desc' => __('A szolgáltató információs vagy hibabejelentő email címe', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_webhost_phone',
                'title' => __('Telefon', 'snapdragon'),
                'desc' => __('Ügyfélszolgálati telefonszám', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_webhost_address',
                'title' => __('Levelezési cím', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_webhost_openingtime',
                'title' => __('Ügyfélfogadási idő', 'snapdragon'),
                'desc' => __('Érdemes feltüntetni amennyiben nem rendelkezik 24 órás diszpécseri szolgálattal.', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_webhost_domain',
                'title' => __('Domain', 'snapdragon'),
                'desc' => __('A tárhely szolgátató webolatának elérhetősége', 'snapdragon'),
            ],
        ];

        foreach( $inputs as $key => $input ) :
            get_template_part( 'inc/admin/template-parts/input' , $input['type'], $inputs[$key] );
        endforeach;

        ?>
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
    }
}



if ( ! function_exists( 'snapdragon_admin_woocommerce_tab_content_html' ) ) {
    function snapdragon_admin_woocommerce_tab_content_html( $class ) {
        ?>
            <h2>snapdragon_admin_woocommerce_tab_content_html</h2>
        <?php

        get_submit_button(text: __('Modosítások mentése', 'snapdragon'), type: 'primary', name: 'snapdragon-form-submit', wrap: true);
    }
}



if ( ! function_exists( 'snapdragon_admin_plugins_tab_content_html' ) ) {
    function snapdragon_admin_plugins_tab_content_html( $class ) {
        ?>
            <h2>snapdragon_admin_plugins_tab_content_html</h2>
        <?php

        get_submit_button(text: __('Modosítások mentése', 'snapdragon'), type: 'primary', name: 'snapdragon-form-submit', wrap: true);
    }
}



if ( ! function_exists( 'snapdragon_admin_translates_tab_content_html' ) ) {
    function snapdragon_admin_translates_tab_content_html( $class ) {
        global $snapdragon;
        
        if( count( $snapdragon->translates->get_capabilities() ) < 1 ) {
            return;
        }
                
        foreach( $snapdragon->translates->get_capabilities() as $lang ) :
            if ( ! ( $lang->code === 'hu_HU' ) ) {
                $checked = in_array($lang->code , $snapdragon->translates->get_enabled());
                get_template_part( 'inc/admin/template-parts/input' , 'language', [ 'language' => $lang , 'checked' => $checked ] );
            }
        endforeach;

        ?>
            <input type="hidden" name="snapdragon-language-options">
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
    }
}



if ( ! function_exists( 'snapdragon_admin_settings_tab_content_html' ) ) {
    function snapdragon_admin_settings_tab_content_html( $class ) {
        $inputs = [
            [
                'type' => 'checkbox',
                'id' => 'snapdragon_sidebar_on_right',
                'title' => __('Sidebar on the Right', 'snapdragon'),
                'desc' => __('A cég mindenkori könyvelőjének neve. Webshopok-nál kötelező lehet!', 'snapdragon'),
            ],
            [
                'type' => 'checkbox',
                'id' => 'snapdragon_offcanvas_on_right',
                'title' => __('Mobile sidebar on the Right', 'snapdragon'),
                'desc' => __('Registering own category of Blocks.', 'snapdragon'),
            ],
            [
                'type' => 'checkbox',
                'id' => 'snapdragon_fab',
                'title' => __('Jump to Top button', 'snapdragon'),
                'desc' => __('Show floating action button for jump to top of page after scroll', 'snapdragon'),
            ],
        ];

        foreach( $inputs as $key => $input ) :
            get_template_part( 'inc/admin/template-parts/input' , $input['type'], $inputs[$key] );
        endforeach;

        ?>
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
    }
}



if ( ! function_exists( 'snapdragon_admin_accountant_tab_content_html' ) ) {
    function snapdragon_admin_accountant_tab_content_html( $class ) {
        $inputs = [
            [
                'type' => 'text',
                'id' => 'snapdragon_accountant_name',
                'title' => __('Full Name of Accountant', 'snapdragon'),
                'desc' => __('A cég mindenkori könyvelőjének neve. Webshopok-nál kötelező lehet!', 'snapdragon'),
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_accountant_address',
                'title' => __('Address of Accountant' , 'snapdragon'),
                'desc' => 'A cég mindenkori könyvelőjének lakcíme vagy irodai elérhetősége. Webshopok-nál kötelező lehet!',
            ],
            [
                'type' => 'text',
                'id' => 'snapdragon_accountant_phone',
                'title' => __('Phone of Accountant', 'snapdragon'),
                'desc' => __('A cég mindenkori könyvelőjének telefonos elérhetősége. Webshopok-nál kötelező lehet!', 'snapdragon'),
            ],
        ];

        foreach( $inputs as $key => $input ) :
            get_template_part( 'inc/admin/template-parts/input' , $input['type'], $inputs[$key] );
        endforeach;

        ?>
            <input type="submit" class="<?php esc_attr_e( $class ) ?>" value="<?php esc_attr_e( 'Save' , 'snapdragon' ) ?>">
        <?php
    }
}
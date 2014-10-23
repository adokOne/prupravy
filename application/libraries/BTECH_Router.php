<?php
/**
 * Router for Multi_Lang Module
 *
 * @package    Multi_Lang Module
 * @author     Kiall Mac Innes
 * @copyright  (c) 2007-2009 Multi_Lang Module Team..
 * @license    http://dev.kohanaphp.com/wiki/multilang/License
 */
class Router extends Router_Core {

	public static $current_language = '';
    public static $current_gds = 'a';

    public static $subdomain_url = FALSE;
    public static $current_domain = '';
    public static $redirect_url = '';
    public static $cur_domain = '';
    public static $cur_service = '';
    public static $cur_lang = '';
    public static $site_title = '';
    public static $logo_title = '';
    public static $site_description = '';
    public static $site_keywords = '';
	public static $partner = false;
	public static $is_partner = false;
    public static $seo_city = false;
    public static $is_main = false;
    public static $current_protocol = false;

    public static function setup()
    {
       parent::setup();
  
    }

    public static function find_uri()
	{
        self::$current_gds = Kohana::config('config.default_avia_gds');
        parent::find_uri();
        $lang_prefix = '';
        $cur_domain = '';
        self::$current_language = Kohana::config('multi_lang.default');

        if(Kohana::config('multi_lang.enabled') and !in_array(self::$current_uri, Kohana::config('ignore.ignore_uri'))){
            $allowed_languages = Kohana::config('multi_lang.allowed_languages');
            if(preg_match('~^[a-z]{2}(?=/|$)~i', self::$current_uri, $matches) AND isset($matches[0])){
                // LC the language used in the url.
                $lang_lc = strtolower($matches[0]);

                // Check for invalid language in URL
                if(!array_key_exists($lang_lc, $allowed_languages)){
                    self::$current_language = Kohana::config('multi_lang.default');
                    self::$redirect_url = self::$current_uri;
                } else {
                    // Set the currently defined language
                    self::$current_language = $lang_lc;

                    // Remove the language from the URI
                    self::$current_uri = substr(self::$current_uri, 3);

                    if (self::$current_uri == ''){
                        // Make sure the default route is set
                        $routes = Kohana::config('routes');

                        if ( ! isset($routes['_default']))
                            throw new Kohana_Exception('core.no_default_route');

                        // Use the default route when no segments exist
                        self::$current_uri = $routes['_default'];
                    }

                    Kohana::config_set('locale.language', array($allowed_languages[self::$current_language]['locale']));

                    // GNU GetText Stuff
                    if (function_exists('_')){
                        setlocale(LC_ALL, $allowed_languages[self::$current_language]['locale']);
                        //tenv('LC_ALL='.$allowed_languages[self::$current_language]);
                        bindtextdomain("application", DOCROOT."/application/i18n");
                        bindtextdomain("system", DOCROOT."/system/i18n");
                        textdomain("application");
                    }

                    // Overwrite setlocale which has already been set before in Kohana::setup(), and a few lines up.
                    setlocale(LC_ALL, $allowed_languages[self::$current_language]['locale'].'.UTF-8');

                    self::$redirect_url = self::$current_uri;
                }
            } else {
                self::$current_language = Kohana::config('multi_lang.default');
                self::$redirect_url = self::$current_uri;
            }

            $lang_prefix = self::$current_language != Kohana::config('multi_lang.default') ? self::$current_language.'/' : '';
        }

        // определяем поддомен, если есть
        if(!in_array(self::$current_uri, Kohana::config('ignore.ignore_uri'))){
            $allowed_domains = Kohana::config('multi_lang.allowed_domains');
            if(isset($_SERVER['HTTP_HOST']) && Kohana::config('config.has_subdomains')){
                $http_host = explode('.', $_SERVER['HTTP_HOST']);
                if($http_host[0] == 'www'){
                    unset($http_host[0]);
                    reset($http_host);
                }

                self::$current_domain = implode($http_host, '.');

                if(self::$current_domain !== Kohana::config('config.site_domain')){
                    $possible_domain = array_search(current($http_host), Kohana::config('multi_lang.domain_names'));

                    if(in_array($possible_domain, $allowed_domains)){
                        self::$subdomain_url = TRUE;
                        $cur_domain = $possible_domain;
                    }
                }
                if($cur_domain == '') {
                    self::check_gds(1);
                }
            } elseif(!Kohana::config('config.has_subdomains')){
                $domain_str = explode('/', self::$current_uri);
                $possible_domain = isset($domain_str[0]) ? array_search($domain_str[0], Kohana::config('multi_lang.domain_names')) : FALSE;

                if($possible_domain && in_array($possible_domain, $allowed_domains)){
                    $cur_domain = $possible_domain;
                    unset($domain_str[0]);
                    self::$current_uri = implode('/', $domain_str);
                }
            }

            self::check_gds(0);

            if($cur_domain == ''){
                self::$is_main = true;
                $cur_domain = Kohana::config('multi_lang.default_domain');
            }

            if($cur_domain == 'my'){
                $arr = explode('/', self::$current_uri);
                self::$cur_service = isset($arr[0]) ? $arr[0] : '';
            } else {
                self::$cur_service = $cur_domain;
            }

            self::$current_uri = self::$current_uri;
        }

        View::set_global('cur_lang', $lang_prefix);
        View::set_global('cur_domain', $cur_domain);
        View::set_global('logged_id', Auth::instance()->logged_in());
        View::set_global('default_currency', Kohana::config('config.default_currency'));
        self::$redirect_url .= ( ! empty($_SERVER['QUERY_STRING'])) ? '?'.trim($_SERVER['QUERY_STRING'], '&/') : '';
        self::$cur_lang = $lang_prefix;
        self::$cur_domain = $cur_domain;
        $protocol = Kohana::config('config.protocol');
        $protocol = $protocol ? $protocol : false;
        self::$current_protocol = $protocol;
        View::set_global('current_site_protocol', $protocol);



        $lang = array_merge( Kohana::lang('common'), Kohana::lang('meta') );
        $title_key = $cur_domain == '' ? 'title_'.Kohana::config('multi_lang.default_domain') : 'title_'. (self::$is_main ? 'main' : $cur_domain);
        $logo_key = $cur_domain == '' ? 'logo_title_'.Kohana::config('multi_lang.default_domain') : 'logo_title_'. (self::$is_main ? 'main' : $cur_domain);
        $description_key = $cur_domain == '' ? 'description_'.Kohana::config('multi_lang.default_domain') : 'description_'. (self::$is_main ? 'main' : $cur_domain);
        $keywords_key = $cur_domain == '' ? 'keywords_'.Kohana::config('multi_lang.default_domain') : 'keywords_'. (self::$is_main ? 'main' : $cur_domain);

        self::$site_title = (isset($lang[$title_key]) ? $lang[$title_key] . ' / '  : '') . Kohana::config('config.site_name');
        self::$logo_title = isset($lang[$logo_key]) ? $lang[$logo_key] : '';

        self::$site_description = isset($lang[$description_key]) ? $lang[$description_key] : '';
        self::$site_keywords = isset($lang[$keywords_key]) ? $lang[$keywords_key] : '';
    }

    // определяем gds
    public static function check_gds($index){
        $gds_string = explode('/', self::$current_uri);
        $allowed_gds = Kohana::config('multi_lang.allowed_gds');
        if(isset($gds_string[$index]) && in_array(strtolower($gds_string[$index]), $allowed_gds)){
            $gds = strtolower($gds_string[$index]);

            self::$current_gds = $gds;
            unset($gds_string[$index]);
            self::$current_uri = implode('/', $gds_string);

            self::$redirect_url = '/'.$gds.'/'.self::$current_uri;
        }
    }
}

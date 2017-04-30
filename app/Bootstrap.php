<?php

/**
 * Created by PhpStorm.
 * User: Maris Vigulis
 * Date: 17.1.2
 * Time: 21:06
 */

use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\View\Simple as SimpleView;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use library\Helpers\Locale;
use library\Adapters\Cache\MemcachedAdapter;
use library\Adapters\Translate\TranslateAdapter;

class Bootstrap
{

    /**
     * Di
     *
     * @var \Phalcon\Di\FactoryDefault
     */
    private $_di;

    /**
     * Main config
     *
     * @var \Phalcon\Config
     */
    private $_config;

    /**
     * URI Parts to skip locale check
     *
     * @var array
     */
    protected $uriWithoutLocale = array(
        'admin',
    );

    /**
     * Constructor
     *
     * @param \Phalcon\Di\FactoryDefault $di
     * @param \Phalcon\Config $config
     */
    public function __construct($di, $config)
    {
        $this->_di = $di;
        $this->_config = $config;
    }


    public function bootstrap()
    {
        $this->initLoader();
        $this->initDb();
        $this->initView();
        $this->initSimpleView();
        $this->initSession();
        $this->initRouter();
        $this->initCache();
        $this->initDispatcher();
        $this->initFlash();
        $this->initmodelsMetadata();
        $this->initUrl();
        $this->initConfig();
        $this->initHtmlHelper();
        $this->initLocale();
        $this->initTranslate();

        return $this->_di;
    }


    /**
     *  Init loader
     */
    private function initLoader()
    {
        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces([
            'library'               =>  $this->_config->application->libraryDir,
            'app\controllers'       =>  $this->_config->application->controllersDir,
            'app\controllers\Admin' =>  $this->_config->application->adminControllersDir,
            'app\models'            =>  $this->_config->application->modelsDir

        ], true)->register();

        $loader->registerDirs(
            [
                $this->_config->application->controllersDir,
                $this->_config->application->modelsDir,
                $this->_config->application->libraryDir,
                $this->_config->application->adminControllersDir
            ]
        )->register();
    }
    

    /**
     * Init database
     *
     */
    private function initDb()
    {
        $config = $this->_config;

        $this->_di->setShared('db', function () use($config) {

            $class = '\Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
            $connection = new $class([
                'host'     => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname'   => $config->database->dbname,
                'charset'  => $config->database->charset
            ]);

            return $connection;
        });
    }


    /**
     *  Init view rendering engine
     */
    private function initView()
    {
        $config = $this->_config;

        $this->_di->setShared('view', function () use ($config) {

            $view = new View();
            $view->setDI($this);
            $view->setViewsDir($config->application->viewsDir);

            $view->registerEngines([
                /*'.volt' => function ($view) {
                    $config = $this->getConfig();

                    $volt = new VoltEngine($view, $this);

                    $volt->setOptions([
                        'compiledPath' => $config->application->cacheDir,
                        'compiledSeparator' => '_'
                    ]);

                    return $volt;
                },*/
                '.phtml' => PhpEngine::class

            ]);

            return $view;
        });
    }

    /**
     * Simple view is used to render partial views in components
     */
    private function initSimpleView()
    {
        $this->_di->setShared('simpleview', function (){
            $view = new SimpleView();

            $view->setViewsDir(APP_PATH . '/views/');

            return $view;
        });
    }

    /*
    * Start the session the first time some component request the session service
    */
    private function initSession()
    {
        $this->_di->setShared('session', function () {

            $session = new SessionAdapter();
            $session->start();

            return $session;
        });
    }


    /**
     *  Init routes
     */
    private function initRouter()
    {
        $this->_di->set('router', function(){

            $router = new Router();

            require __DIR__.'/config/routes.php';

            return $router;
        });
    }


    /**
     *  Init cache adapter
     */
    private function initCache()
    {
        $this->_di->set('cache', function (){
            return new MemcachedAdapter('delana-auto-');
        });

    }

    /**
     *  Init dispatcher
     */
    private function initDispatcher()
    {
        $this->_di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();

            return $dispatcher;
        });
    }


    /**
     * Register the session flash service with the Twitter Bootstrap classes
     */
    private function initFlash()
    {
        $this->_di->set('flash', function () {
            return new Flash([
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ]);
        });
    }


    /**
     * If the configuration specify the use of metadata adapter use it or use memory otherwise
     */
    private function initmodelsMetadata()
    {
        $this->_di->setShared('modelsMetadata', function () {
            return new MetaDataAdapter();
        });
    }


    /**
     *  Init url's
     */
    private function initUrl()
    {
        $this->_di->setShared('url', function () {
            $config = $this->getConfig();

            $url = new UrlResolver();
            $url->setBaseUri($config->application->baseUri);

            return $url;
        });
    }


    /**
     *  Init globals configuration
     */
    private function initConfig()
    {
        $config = $this->_config;

        $this->_di->setShared('config', function () use ($config) {
            return $config;
        });
    }


    /**
     *  Init Html helper
     */
    private function initHtmlHelper()
    {
        $this->_di->setShared('htmlhelper', function() {
            return new HtmlHelper();
        });
    }

    /**
     *  Init locale
     */
    private function initLocale()
    {
        $autodetect = true;

        foreach($this->uriWithoutLocale as $uri) {
            if (stristr($_SERVER['REQUEST_URI'], $uri)) {
                $autodetect = false;
                break;
            }
        }

        $locale = new Locale($_SERVER['REQUEST_URI'], $_SERVER['REMOTE_ADDR'], $autodetect);
        if (!$autodetect) {
            $locale->initFromCode('lv');
        }
        else if (!$locale->knownFromUri) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . $locale->languageCode . $_SERVER['REQUEST_URI'], true, 301);
            exit;
        }

        defined('LOCALE_CODE') || define('LOCALE_CODE', $locale->languageCode);
        defined('LOCALE_ID') || define('LOCALE_ID', $locale->languageId);

        $this->_di->setShared('locale', $locale);
    }


    protected function initTranslate()
    {
        $this->_di->setShared('translate', function() {
            return new TranslateAdapter(
                array(
                    'content' => (new \app\models\LanguageTranslate())->loadTranslates()
                )
            );
        });
    }

}
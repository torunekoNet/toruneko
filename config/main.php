<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => "Toruneko",
    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.models.form.*',
        'application.components.*',
        'application.components.filters.*',
        'ext.yii-mail.YiiMailMessage',
        'ext.fraudmetrix.Fraudmetrix',
    ),

    'modules' => array(
        'admin' => array(
            'class' => 'application.modules.admin.AdminModule'
        )
    ),

    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'guestName' => '游客',
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '',
            'rules' => array(
                array('blog/index', 'pattern' => 'index'),
                array('blog/search', 'pattern' => 'search'),
                array('blog/tag', 'pattern' => 'tag/<id:\w+>'),
                array('blog/date', 'pattern' => 'date/<id:\d+>'),
                array('blog/post', 'pattern' => '<id:\d+>'),
                array('blog/captcha', 'pattern' => 'captcha'),
                array('blog/rss', 'pattern' => 'rss'),
                array('index/error', 'pattern' => 'error'),
                array('index/baecheck', 'pattern' => 'baecheck'),
            ),
        ),

        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=toruneko',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 86400,
            'username' => "root",
            'password' => "toruneko",
            'charset' => 'utf8',
        ),

        'session' => array(
            'class' => 'CCacheHttpSession',
        ),

        'cache' => array(
            'class' => 'CRedisCache',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 1,
            'options' => STREAM_CLIENT_CONNECT,
        ),

        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.sina.com',
                'username' => 'toruneko@sina.com',
                'password' => '',
                'port' => '465',
                'encryption' => 'tls',
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),

        'fraudmetrix' => array(
            'class' => 'ext.fraudmetrix.Fraudmetrix',
            'partnerCode' => 'kf_Qox',
            'secretKey' => '0c09a4607edf4bc0b1f7ce83a2ecb85d'
        ),

        'errorHandler' => array(
            'errorAction' => 'index/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
    ),

    'params' => array(
        'upload' => 'upload',
        'domain' => array(
            'index' => 'http://www.toruneko.net',
            'blog' => 'http://blog.toruneko.net',
        ),
        'cache' => array(
            'friend' => 'app.models.Setting.getFriendLink',
            'category' => 'app.models.BlogCategory.renderArchive',
            'archive' => 'app.models.BlogArchive.renderArchive'
        ),
        'version' => '1.0',
        //上下级权限检测
        'allowCheck' => array(
            'auth' => array(
                'assign' => array(
                    array('role', 'role', 'post'),
                    array('operation', 'operation', 'post'),
                ),
                'assignGroup' => array(
                    array('auth', 'group', 'get'),
                    array('user', 'user', 'get'),
                ),
                'assignRole' => array(
                    array('auth', 'role', 'get'),
                    array('user', 'user', 'get')
                ),
            ),
            'user' => array(
                'edit' => array(
                    array('id', 'user', 'get'),
                    array(array('UserForm', 'id'), 'user', 'post'),
                )
            ),
        ),
    ),
);

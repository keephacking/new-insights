<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit561d2c1966197bfe82f799cc4821c30a
{
    public static $classMap = array (
        'EasyPeasyICS' => __DIR__ . '/../..' . '/include/PHPMailer-master/extras/EasyPeasyICS.php',
        'League\\OAuth2\\Client\\Provider\\Google' => __DIR__ . '/../..' . '/include/PHPMailer-master/get_oauth_token.php',
        'PHPMailer' => __DIR__ . '/../..' . '/include/PHPMailer-master/class.phpmailer.php',
        'PHPMailerLangTest' => __DIR__ . '/../..' . '/include/PHPMailer-master/test/phpmailerLangTest.php',
        'PHPMailerOAuth' => __DIR__ . '/../..' . '/include/PHPMailer-master/class.phpmaileroauth.php',
        'PHPMailerOAuthGoogle' => __DIR__ . '/../..' . '/include/PHPMailer-master/class.phpmaileroauthgoogle.php',
        'PHPMailerTest' => __DIR__ . '/../..' . '/include/PHPMailer-master/test/phpmailerTest.php',
        'POP3' => __DIR__ . '/../..' . '/include/PHPMailer-master/class.pop3.php',
        'SMTP' => __DIR__ . '/../..' . '/include/PHPMailer-master/class.smtp.php',
        'TimeAgo' => __DIR__ . '/../..' . '/include/timeAgo_class.php',
        'database' => __DIR__ . '/../..' . '/include/database.class.php',
        'filter_class' => __DIR__ . '/../..' . '/include/filter.class.php',
        'item_class' => __DIR__ . '/../..' . '/include/item.class.php',
        'ntlm_sasl_client_class' => __DIR__ . '/../..' . '/include/PHPMailer-master/extras/ntlm_sasl_client.php',
        'phpmailerException' => __DIR__ . '/../..' . '/include/PHPMailer-master/class.phpmailer.php',
        'table' => __DIR__ . '/../..' . '/include/table.class.php',
        'user_class' => __DIR__ . '/../..' . '/include/user.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit561d2c1966197bfe82f799cc4821c30a::$classMap;

        }, null, ClassLoader::class);
    }
}

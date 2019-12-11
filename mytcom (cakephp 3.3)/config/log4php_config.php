<?php
return array(
    'rootLogger' => array(
        'appenders' => array('default'),
        //only output log level equal or higher than "info"
        'level' => 'info'
    ),
    'appenders' => array(
        'default' => array(
            'class' => 'LoggerAppenderFile',
            'layout' => array(
                'class' => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '%msg%n'
                )
            ),
            'params' => array(
                'file' => LOGS.'nopt.log',
                'append' => true
            )
        )
    )
);
?>

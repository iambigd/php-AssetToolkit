<?php
require '../vendor/pear/Universal/ClassLoader/BasePathClassLoader.php';
define( 'ROOT', dirname(dirname(__FILE__) ));
$classLoader = new \Universal\ClassLoader\BasePathClassLoader(array(
    ROOT . '/src', ROOT . '/vendor/pear',
));
$classLoader->useIncludePath(false);
$classLoader->register();

$config = new AssetKit\Config( ROOT . '/.assetkit');
$loader = new AssetKit\AssetLoader( $config , array( ROOT . '/assets' ) );
$jquery = $loader->load( 'jquery' );
$jqueryui = $loader->load( 'jquery-ui' );
$extjs4 = $loader->load( 'extjs4-gpl' );

$assets = array();
$assets[] = $jquery;
$assets[] = $jqueryui;
$assets[] = $extjs4;


$cache = new CacheKit\ApcCache( array('namespace' => 'demo') );
$writer = new AssetKit\AssetWriter($config);
$manifest = $writer->name('app')
        ->env('production')
        ->cache($cache)

        // ->env('development')
        ->write( $assets );

$includer = new AssetKit\IncludeRender;
$head = $includer->render( $manifest );
?>
<html>
<head>
    <?=$head?>
</head>
<body>
<?php
var_dump( $manifest );
?>
</body>
</html>
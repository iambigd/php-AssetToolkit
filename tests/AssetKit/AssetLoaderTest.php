<?php

class AssetLoaderTest extends PHPUnit_Framework_TestCase
{
	function test()
	{
		$config = new AssetKit\Config('tests/config');
		$loader = new AssetKit\AssetLoader($config, array( 'assets') );
		$manifest = $loader->load( 'jquery-ui' );
		ok( $manifest );

		$collections = $manifest->getFileCollections();
		foreach( $collections as $collection ) {
			$files = $collection->getFiles();
			ok( $files );
		}
	}
}


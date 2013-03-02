<?php

use AssetKit\AssetCompiler;

class AssetCompilerTest extends AssetKit\TestCase
{



    public function testCssImportUrlFromTestAssetInProductionMode()
    {
        $config = $this->getConfig();
        $loader = $this->getLoader();
        $asset = $loader->registerFromManifestFileOrDir("tests/assets/test");
        ok($asset);

        $compiler = $this->getCompiler();
        $compiler->setEnvironment( AssetCompiler::PRODUCTION );

        $installer = $this->getInstaller();
        $installer->install($asset);

        $files = $compiler->compile($asset);
        ok($files);
        path_ok($files['js_file']);
        path_ok($files['css_file']);
        ok($files['mtime'], 'got mtime');

        $cssminContent = file_get_contents( $files['css_file'] );
        ok($cssminContent);

        // examine these
        $this->assertContains('background:url(/assets/test/images/test.png)', $cssminContent);
        $this->assertContains('.subpath2{color:green}', $cssminContent);
        $this->assertContains('.subpath{color:red}', $cssminContent);
        $this->assertContains('.content-navigation{border-color:#3bbfce;color:#2ca2af}', $cssminContent);

        /**
        $files which is something like:
        .array(4) {
            ["js"]=>
                string(68) "/Users/c9s/src/work/php/AssetKit/tests/public/jquery-ui/jquery-ui.js"
            ["css"]=>
                string(69) "/Users/c9s/src/work/php/AssetKit/tests/public/jquery-ui/jquery-ui.css"
            ["js_url"]=>
                string(30) "/assets/jquery-ui/jquery-ui.js"
            ["css_url"]=>
                string(31) "/assets/jquery-ui/jquery-ui.css"
        }
         */
        // is('/assets/jquery-ui/jquery-ui.js', $files['js_url'][0]);
        // is('/assets/jquery-ui/jquery-ui.css', $files['css_url'][0]);
        $installer->uninstall($asset);
    }

    public function testDevelopmentModeShouldOnlyRunFiltersForjQueryUI()
    {
        $config = $this->getConfig();
        $loader = $this->getLoader();
        $asset = $loader->registerFromManifestFileOrDir("tests/assets/jquery-ui");
        ok($asset);

        $compiler = $this->getCompiler();
        $compiler->setEnvironment( AssetCompiler::DEVELOPMENT );

        $installer = $this->getInstaller();
        $installer->install($asset);

        $files = $compiler->compile($asset);
        ok($files);
        path_ok($files['js_file']);
        path_ok($files['css_file']);

        /**
        $files which is something like:

        .array(4) {
            ["js"]=>
                string(68) "/Users/c9s/src/work/php/AssetKit/tests/public/jquery-ui/jquery-ui.js"
            ["css"]=>
                string(69) "/Users/c9s/src/work/php/AssetKit/tests/public/jquery-ui/jquery-ui.css"
            ["js_url"]=>
                string(30) "/assets/jquery-ui/jquery-ui.js"
            ["css_url"]=>
                string(31) "/assets/jquery-ui/jquery-ui.css"
        }
         */
        is('/assets/jquery-ui/jquery-ui.js', $files['js_url']);
        is('/assets/jquery-ui/jquery-ui.css', $files['css_url']);
        $installer->uninstall($asset);
    }

    public function testProductionModeForjQueryUI()
    {
        $config = $this->getConfig();
        $loader = $this->getLoader();

        $asset = $loader->registerFromManifestFileOrDir("tests/assets/jquery-ui");
        ok($asset);

        $compiler = $this->getCompiler();
        $compiler->setEnvironment( AssetCompiler::PRODUCTION );

        $installer = $this->getInstaller();
        $installer->install($asset);

        $files = $compiler->compile($asset);
        ok($files);
        path_ok($files['js_file']);
        path_ok($files['css_file']);

        /**
        $files which is something like:

        .array(4) {
            ["js"]=>
                string(68) "/Users/c9s/src/work/php/AssetKit/tests/public/jquery-ui/jquery-ui.js"
            ["css"]=>
                string(69) "/Users/c9s/src/work/php/AssetKit/tests/public/jquery-ui/jquery-ui.css"
            ["js_url"]=>
                string(30) "/assets/jquery-ui/jquery-ui.js"
            ["css_url"]=>
                string(31) "/assets/jquery-ui/jquery-ui.css"
        }
         */
        is('/assets/jquery-ui/jquery-ui.min.js', $files['js_url']);
        is('/assets/jquery-ui/jquery-ui.min.css', $files['css_url']);
        $installer->uninstall($asset);
    }


}


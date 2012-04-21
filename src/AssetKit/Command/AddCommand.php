<?php
namespace AssetKit\Command;
use AssetKit\Config;
use AssetKit\Manifest;
use CLIFramework\Command;

class AddCommand extends Command
{
    function options($opts)
    {
    }

    function execute($manifestPath)
    {
        $config = new Config('.assetkit');

        if( ! file_exists($manifestPath)) 
            throw new Exception( "$manifestPath does not exist." );

        $manifest = new Manifest($manifestPath);
        $manifest->initResource();
        $php = $manifest->compile();
        $this->logger->info("compiled $php");

        $config->addAsset( $manifest->name , $manifest->dir );

        $this->logger->info("Saving config...");
        $config->save();

        $this->logger->info("Done");
    }
}



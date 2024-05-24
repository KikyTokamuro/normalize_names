<?php

declare(strict_types=1);

namespace Kikyt\NormalizeNames\Cli;

class Arguments {
    private array $options;

    public function __construct() {
        $this->options = getopt("h", array("help", "url:"));
    }

    public function parseOptions() {
        if(isset($this->options['h']) || isset($this->options['help'])) {
            $this->showHelp();
            exit;
        }

        if(!isset($this->options['url'])) {
            printf("Error: URL is required\n");
            exit(1);
        }
    }

    private function showHelp() {
        printf("Usage: php NormalizeNames.php --url=<url>\n");
        printf("  -h, --help  Show this help message and exit\n");
        printf("  --url       The URL to process\n");
    }

    public function getUrl(): string {
        return $this->options['url'];
    }
}
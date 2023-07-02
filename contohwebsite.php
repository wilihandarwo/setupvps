<?php
define("TOKEN", "TX5Teuoi9icTADqdpGsnWc3Uhc5RRN");                                       // The secret token to add as a GitHub or GitLab secret, or otherwise as https://www.example.com/?token=secret-token
define("REMOTE_REPOSITORY", "git@github.com:wilihandarwo/contohwebsite.com.git"); // The SSH URL to your repository
define("DIR", "/var/www/contohwebsite.com");                          // The path to your repostiroy; this must begin with a forward slash (/)
define("BRANCH", "refs/heads/main");                                 // The branch route
define("LOGFILE", "contohwebsite.log");                                       // The name of the file you want to log to.
define("GIT", "/usr/bin/git");                                         // The path to the git executable
define("MAX_EXECUTION_TIME", 180);                                     // Override for PHP's max_execution_time (may need set in php.ini)
define("BEFORE_PULL", "");                                             // A command to execute before pulling
define("AFTER_PULL", "");                                              // A command to execute after successfully pulling

require_once("deployer.php");
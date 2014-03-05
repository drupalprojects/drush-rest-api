<?php

/**
* Process an incoming request passed to the `rest-api-request` command.
*
* The Drush REST API Server by default will handle incoming requests using
* the `rest-api-request` command. All commands are allowed and only minimal
* validation is done. In addition, the full output of drush_invoke_process()
* is returned to the requester in JSON format.
*
* You can write a Drush command implementing this hook if you want to:
* - dynamically whitelist/blacklist commands
* - perform additional checks on the requster's IP address or host name
* - return data in a different format than JSON; or return a subset of data
* instead of the full output from drush_invoke_process().
*
* Because implementing this hook will alter *any* requests coming in to
* `rest-api-request`, you should consider restricting your implementation to a
* particular port. That way users who want to use your hook for the
* `rest-api-server` command can specify a specific port (e.g. '5678') which
* your hook is based on.
*
* @param string $ip_address
* IP address of the requester. N.B. can be spoofed by non-browser clients.
* @param string $host
* Host name of the requester. N.B. can be spoofed by non-browser clients.
* @param string $port
* The port that the `rest-api-server` is running on.
* @param array $request
* The incoming request with keys for 'alias', 'command', 'args', and
* 'options'.
*
* @return mixed
* You can return anything you want, although it's recommended to return some
* kind of string to the user.
*/
function hook_drush_rest_api_process_request_alter($ip_address, $host, $port, $request) {
  if ($port == '5678') {
    // Only alter results if user is running `rest-api-server` on port 5678.
  }
}

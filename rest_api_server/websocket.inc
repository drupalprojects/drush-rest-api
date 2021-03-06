<?php

/**
 * @file
 * Code for launching a Drush server using a WebSocket.
 */

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

/**
 * Launch the Drush REST API server using a WebSocket.
 *
 * This code is run when the `--server-type=websocket` option is passed to the
 * `rest-api-server` command.
 */
function rest_api_server_launch() {
  require_once dirname(__DIR__) . '/includes/DrushWebSocket.php';
  $port = drush_get_option('port', 8080);
  $allowable_ips = drush_get_option_list('allowable-ips');
  $allowable_hosts = drush_get_option_list('allowable-http-hosts');
  $allowable_commands = drush_get_option_list('allowable-commands');
  drush_log(dt('Starting Drush REST API WebSocket server with process ID !pid', array('!pid' => getmypid())), 'ok');
  drush_log(dt('Listening at ws://localhost:!port', array('!port' => $port)), 'ok');
  // Store the process ID for the server.
  drush_cache_set('rest-server-pid', getmypid(), 'drush-rest-api');
  drush_cache_set('rest-server-port', drush_get_option('port', 8888), 'drush-rest-api');
  $server = IoServer::factory(
    new HttpServer(
      new WsServer(
        new DrushRestApiServerWebSocket($allowable_ips, $allowable_hosts, $allowable_commands)
      )
    ),
    $port
  );

  $server->run();
}

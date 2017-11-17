<?php

/* Required to setup bot to FB application messenger */
  $access_token = 'EAABySPjYKzEBAGaHjpAjxmoW2kuoDKIpBuPodTbvNFOGRYDLS4ULe6mZAcnSnQccQZAYTS3o8TlgwUplSg0ZAN0IahLriqgt1EcyUj6UHP2W92XPJPLTutDJg41NV3DbXLeYmmXZApWXIWarLzhZBJzClO1GgzXEPAXUsnCLjZAQZDZD';

  $verify_token = 'testing';

  if(isset($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe') {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];

    if ($hub_verify_token === $verify_token) {
      header("HTTP/1.1 200 OK");
      echo $challenge;
      die;
    }
  }
/* Required to setup bot to FB application messenger */

?>

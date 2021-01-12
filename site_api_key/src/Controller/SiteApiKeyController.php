<?php

namespace Drupal\site_api_key\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Contains SiteApiKeyController controller.
 * 
 * Class for defining basic methods of Axelerant SiteAPIKey module.
 */
class SiteApiKeyController extends ControllerBase {
  
  /**
   * Provide node data in json format.
   *
   * @param Drupal\node\NodeInterface $node.
   */
  public function pageJson(NodeInterface $node) {
    $nodeData = $node->toArray();
    return new JsonResponse($nodeData);
  }
  
  /**
   * Check access to pageJson.
   *
   * @see pageJson().
   *
   * @param $siteapikey.
   * @param Drupal\node\NodeInterface $node.
   */
  public function checkAccess($siteapikey, NodeInterface $node) {
	  
	$systemConfigObject = \Drupal::configFactory()->getEditable('system.site');
	$storedSiteKey = $systemConfigObject->get('siteapikey');
	if (($node->getType() == 'page') && $storedSiteKey) {
      if ($storedSiteKey == $siteapikey) {
	    return AccessResult::allowed();
	  }
	}
    return AccessResult::forbidden();
  }

}

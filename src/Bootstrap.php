<?php
/**
 * Bootstrap custom module skeleton.  This file is an example custom module that can be used
 * to create modules that can be utilized inside the OpenEMR system.  It is NOT intended for
 * production and is intended to serve as the barebone requirements you need to get started
 * writing modules that can be installed and used in OpenEMR.
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 *
 * @author    Stephen Nielson <stephen@nielson.org>
 * @copyright Copyright (c) 2021 Stephen Nielson <stephen@nielson.org>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Modules\CustomModuleSkeleton;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Note the below use statements are importing classes from the OpenEMR core codebase
 */
use OpenEMR\Menu\MenuEvent;
use OpenEMR\Events\RestApiExtend\RestApiCreateEvent;

class Bootstrap
{
    const MODULE_INSTALLATION_PATH = "";
    const MODULE_NAME = "oe-module-custom-skeleton";
	/**
	 * @var EventDispatcherInterface The object responsible for sending and subscribing to events through the OpenEMR system
	 */
	private $eventDispatcher;

	public function __construct(EventDispatcherInterface $eventDispatcher)
	{
	    $this->eventDispatcher = $eventDispatcher;
	}

	public function subscribeToEvents()
	{
		$this->addGlobalSettings();
		$this->registerMenuItems();
		$this->subscribeToApiEvents();
	}

	public function addGlobalSettings()
	{
	}

	public function registerMenuItems()
	{
		/**
		 * @var EventDispatcherInterface $eventDispatcher
		 * @var array                    $module
		 * @global                       $eventDispatcher @see ModulesApplication::loadCustomModule
		 * @global                       $module          @see ModulesApplication::loadCustomModule
		 */
		$this->eventDispatcher->addListener(MenuEvent::MENU_UPDATE, [$this, 'addCustomModuleMenuItem']);
	}

	public function addCustomModuleMenuItem(MenuEvent $event)
	{
	    $menu = $event->getMenu();

	    $menuItem = new \stdClass();
	    $menuItem->requirement = 0;
	    $menuItem->target = 'mod';
	    $menuItem->menu_id = 'mod0';
	    $menuItem->label = xlt("Custom Module Skeleton");
	    // TODO: pull the install location into a constant into the codebase so if OpenEMR changes this location it
        // doesn't break any modules.
	    $menuItem->url = "/interface/modules/custom_modules/oe-module-custom-skeleton/public/sample-index.php";
	    $menuItem->children = [];

	    /**
	     * This defines the Access Control List properties that are required to use this module.
	     * Several examples are provided
	     */
	    $menuItem->acl_req = [];

	    /**
	     * If you would like to restrict this menu to only logged in users who have access to see all user data
	     */
	    //$menuItem->acl_req = ["admin", "users"];

	    /**
	     * If you would like to restrict this menu to logged in users who can access patient demographic information
	     */
	    //$menuItem->acl_req = ["users", "demo"];


	    /**
	     * This menu flag takes a boolean property defined in the $GLOBALS array that OpenEMR populates.
	     * It allows a menu item to display if the property is true, and be hidden if the property is false
	     */
	    //$menuItem->global_req = ["custom_skeleton_module_enable"];

	    /**
	     * If you want your menu item to allows be shown then leave this property blank.
	     */
	    $menuItem->global_req = [];

	    foreach ($menu as $item) {
		if ($item->menu_id == 'modimg') {
		    $item->children[] = $menuItem;
		    break;
		}
	    }

	    $event->setMenu($menu);

	    return $event;
	}

	public function subscribeToApiEvents() {
	    $this->eventDispatcher->addListener(RestApiCreateEvent::EVENT_HANDLE, [$this, 'addCustomSkeletonApi']);
	}

	public function addCustomSkeletonApi(RestApiCreateEvent $event)
    {
        $apiController = new CustomSkeletonAPI();

        /**
         * To see the route definitions @see https://github.com/openemr/openemr/blob/master/_rest_routes.inc.php
         */
        $event->addToFHIRRouteMap('GET /fhir/CustomSkeletonResource', [$apiController, 'listResources']);
        $event->addToFHIRRouteMap('GET /fhir/CustomSkeletonResource/:id', [$apiController, 'getOneResource']);

        /**
         * Events must ALWAYS be returned
         */
        return $event;
    }
}

<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\inventory\InventoryPickupArrowEvent;

use VanillaEnchantments\Core;

class Infinity extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @param InventoryPickupArrowEvent $event
	 */

	public function cancelPickupArrow(InventoryPickupArrowEvent $event): void{
			 $arrow = $event->getArrow();

			 if($arrow->getNameTag() == "infinity") {
				 $event->setCancelled();
			 }
	}

	/**
	 * @param EntityShootBowEvent $event
	 */

	public function onShoot(EntityShootBowEvent $event): void{
		 	$player = $event->getEntity();
		 	$bow = $event->getBow();
		 	$arrow = $event->getProjectile();

		 	if($event->isCancelled()){
		  	    return;
	   	}

	   	if($bow->hasEnchantment(Enchantment::INFINITY)){
			$arrow->setNameTag("infinity");

		        if($player instanceof Player and $player->isSurvival()){
		            $player->getInventory()->addItem(Item::get(Item::ARROW, 0, 1));
		  	}
    		}
	 }
}

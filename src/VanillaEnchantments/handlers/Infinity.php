<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\Player;
use VanillaEnchantments\Core;

class Infinity extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onShoot
	 * @param EntityShootBowEvent $event
	 * @priority HIGHEST
	 * ignoreCancelled false
	 */
	public function onShoot(EntityShootBowEvent $event): void{
		$player = $event->getEntity();
		$bow = $event->getBow();
		if ($event->isCancelled()){
			return;
		}
		if ($bow->hasEnchantment(Enchantment::INFINITY)){
			if ($player instanceof Player and $player->isSurvival()){
				$player->getInventory()->addItem(Item::get(Item::ARROW, 0, 1));
			}
		}
	}
}

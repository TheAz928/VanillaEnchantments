<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileHitEvent;

use VanillaEnchantments\Core;

class Infinity extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	/**
	 * @param EntityShootBowEvent $event
	 */
	
	public function onShoot(EntityShootBowEvent $event) : void{
	      $player = $event->getEntity();
	      $bow = $event->getBow();
	      $projectile = $event->getProjectile();
	      if($event->isCancelled()){
		      return;
		   }
	   	if($bow->hasEnchantment(Enchantment::INFINITY)){
			   if($player instanceof Player and $player->isSurvival()){
				   $projectile->namedtag->setShort("infinity", 1);
			      $player->getInventory()->addItem(Item::get(Item::ARROW, 0, 1));
		   	}
	     }
	 }
	
	/**
	 * @param ProjectileHitEvent $event
	 */
	
	public function onHit(ProjectileHitEvent $event) : void{
			$projectile = $event->getEntity();
			if($projectile->namedtag->getShort("infinity", 0) !== 0){
				$projectile->close();
			}
	}
}

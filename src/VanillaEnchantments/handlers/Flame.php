<?php
namespace VanillaEnchantments\handlers;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;

use pocketmine\entity\Entity;

use VanillaEnchantments\Core;

class Flame extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
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
		   if($bow->hasEnchantment(Enchantment::FLAME)){
		   	$level = $this->getEnchantmentLevel($bow, Enchantment::FLAME);
			   $nbt = clone $arrow->namedtag;
			   $nbt->setShort("Fire", 20 * ($level / 2));
		      $ent = Entity::createEntity("Arrow", $player->getLevel(), $nbt, $player, $arrow->isCritical());
		      $ent->setMotion($ent->getMotion()->multiply($event->getForce()));
		      $event->setProjectile($ent);
		      $ent->setOnFire(20 * ($level / 2));
		  }
	 }
}
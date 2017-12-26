<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class BlastProtection extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	/**
	 * @param EntityDamageEvent $event
	 */
	
	public function onDamage(EntityDamageEvent $event): void{
	      $player = $event->getEntity();
	      $cause = $event->getCause();
	      if($event->isCancelled() or ($cause !== $event::CAUSE_BLOCK_EXPLOSION and $cause !== $event::CAUSE_ENTITY_EXPLOSION)){
		      return;
		   }
	      if($player instanceof Player){
		      $level = $this->getEnchantmentLevelOfArmors($player, Enchantment::BLAST_PROTECTION);
		      $base = $event->getDamage();
		      $reduce = $this->getReducedDamage(Enchantment::BLAST_PROTECTION, $base, $level);
		      if($reduce > 0){
			      $event->setDamage($base - $reduce);
               if($event instanceof EntityDamageByEntityEvent){
                  $event->setKnockBack($event->getKnockBack() * 0.2);
               }
			   }
	     }
	 }
}

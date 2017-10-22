<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class Knockback extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onDamage(EntityDamageEvent $event): void{
	    $player = $event->getEntity();
	    if($event instanceof EntityDamageByEntityEvent){
		   $damager = $event->getDamager();
		   if(!$damager instanceof Player){
			  return;
			}
		  $item = $damager->getInventory()->getItemInHand();
		  if($item->hasEnchantment(Enchantment::KNOCKBACK)){
			 $level = $this->getEnchantmentLevel($item, Enchantment::KNOCKBACK);
		    $event->setKnockback($event->getKnockback() + 0.3 * $level);
			}
		}
	}
}

<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class Thorns extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onDamage(EntityDamageEvent $event): void{
	    $player = $event->getEntity();
	    if($player instanceof Player and $event instanceof EntityDamageByEntityEvent){
		    $damager = $event->getDamager();
			 foreach($player->getInventory()->getArmorContents() as $armor){
		       $level = $this->getEnchantmentLevel($armor, Enchantment::THORNS);
		        if(in_array($armor->getId(), [298, 302, 306, 310, 314])){
			       if(rand(1, 100) <= 15 * $level){
				      $this->addHelmetDurability($player, -3);
				      $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_ENTITY_ATTACK, rand(1, 5)));
				    }
			     }
			     if(in_array($armor->getId(), [299, 303, 307, 311, 315])){
				    if(rand(1, 100) <= 15 * $level){
				      $this->addChestplateDurability($player, -3);
				      $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_ENTITY_ATTACK, rand(1, 5)));
				    }
				  }
				  if(in_array($armor->getId(), [300, 304, 308, 312, 316])){
					 if(rand(1, 100) <= 15 * $level){
				      $this->addLeggingsDurability($player, -3);
				      $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_ENTITY_ATTACK, rand(1, 5)));
				    }
				  }
				  if(in_array($armor->getId(), [301, 305, 309, 313, 317])){
					 if(rand(1, 100) <= 15 * $level){
				      $this->addBootsDurability($player, -3);
				      $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_ENTITY_ATTACK, rand(1, 5)));
				    }
				  }
		    }
		 }
	}
}
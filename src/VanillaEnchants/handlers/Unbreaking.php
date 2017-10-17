<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\player\PlayerInteractEvent;

class Unbreaking extends VanillaEnchant implements Listener{
	
	public function __construct(){
	    # Maybe link code?
	}
	
	public function onBlockBreak(BlockBreakEvent $event){
	    $player = $event->getPlayer();
	    $item = $player->getInventory()->getItemInHand();
	    if($event->isCancelled() == false && $item->hasEnchantment(17) && rand(1, 5) == 2){
	     $fix = $item->getEnchantment(17)->getLevel() + 1;
	     $meta = ($item->getDamage() - $fix) >= 0 ? $item->getDamage() - $fix : 0;
	     $item->setDamage($meta);
	     $player->getInventory()->setItemInHand($item);
	   }
	}
	
	public function onInteract(PlayerInteractEvent $event){
	    $player = $event->getPlayer();
	    $item = $player->getInventory()->getItemInHand();
	    $block = $event->getBlock();
	    if($event->isCancelled() == false){
		   if($item->isHoe() && in_array($block->getId(), [2, 3])){
			  if($item->hasEnchantment(17) && rand(0, 5) == 3){
				 $fix = $item->getEnchantment(17)->getLevel() + 1;
			    $meta = ($item->getDamage() - $fix) >= 0 ? $item->getDamage() - $fix : 0;
			    $item->setDamage($meta);
			    $player->getInventory()->setItemInHand($item);
				}
			}
		}
	}
	
	public function onDamage(EntityDamageEvent $event){
	    $player = $event->getEntity();
	    if($player instanceof Player && $event->isCancelled() == false){
		   $inv = $player->getInventory();
		   $helmet = $inv->getHelmet();
		   $chest = $inv->getChestplate();
		   $leg = $inv->getLeggings();
		   $boots = $inv->getBoots();
		   if($helmet->hasEnchantment(17) && rand(0, 5) == 3){
			  $fix = $helmet->getEnchantment(17)->getLevel() + 1;
	        $meta = ($helmet->getDamage() - $fix) >= 0 ? $helmet->getDamage() - $fix : 0;
	        $helmet->setDamage($meta);
	        $inv->setHelmet($helmet);
			}
			if($chest->hasEnchantment(17) && rand(0, 5) == 3){
			  $fix = $chest->getEnchantment(17)->getLevel() + 1;
	        $meta = ($chest->getDamage() - $fix) >= 0 ? $chest->getDamage() - $fix : 0;
	        $chest->setDamage($meta);
	        $inv->setChestplate($chest);
			}
			if($leg->hasEnchantment(17) && rand(0, 5) == 3){
			  $fix = $leg->getEnchantment(17)->getLevel() + 1;
	        $meta = ($leg->getDamage() - $fix) >= 0 ? $leg->getDamage() - $fix : 0;
	        $leg->setDamage($meta);
	        $inv->setLeggings($leg);
			}
			if($boots->hasEnchantment(17) && rand(0, 5) == 3){
			  $fix = $boots->getEnchantment(17)->getLevel() + 1;
	        $meta = ($boots->getDamage() - $fix) >= 0 ? $boots->getDamage() - $fix : 0;
	        $boots->setDamage($meta);
	        $inv->setBoots($boots);
			}
		}
	}
	
	public function onItemDamage(EntityDamageEvent $event){
	    if($event instanceof EntityDamageByEntityEvent){
		   $player = $event->getEntity();
		   $damager = $event->getDamager();
		   if(!$damager instanceof Player){
			  return false;
			}
			$item = $damager->getInventory()->getItemInHand();
			if($item->hasEnchantment(17) && rand(0, 5) == 3){
			  $fix = $item->getEnchantment(17)->getLevel() + 1;
			  $meta = ($item->getDamage() - $fix) >= 0 ? $item->getDamage() - $fix : 0;
			  $item->setDamage($meta);
			  $damager->getInventory()->setItemInHand($item);
			}
	   }
	}

   public function onShoot(EntityShootBowEvent $event){
        $player = $event->getEntity();
        $bow = $event->getBow();
        if($event->isCancelled() == false && $bow->hasEnchantment(17) && rand(0, 5) == 2 && $player instanceof Player){
	     $fix = $bow->getEnchantment(17)->getLevel() + 1;
	     $meta = ($bow->getDamage() - $fix) >= 0 ? $bow->getDamage() - $fix : 0;
	     $bow->setDamage($meta);
	     $player->getInventory()->setItemInHand($bow);
	   }
   }
}
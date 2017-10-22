<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

use VanillaEnchantments\Core;

class Fortune extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onBlockBreak(BlockBreakEvent $event): void{
	    $player = $event->getPlayer();
	    $block = $event->getBlock();
	    $item = $player->getInventory()->getItemInHand();
	    if(!$event->isCancelled() and $item->hasEnchantment(Enchantment::FORTUNE)){
	     $level = $this->getEnchantmentLevel($item, Enchantment::FORTUNE) + 1;
	     $rand = rand(1, $level);
	     switch($block->getId()){
	         case 16:
	           if($item->isPickaxe()){
		          $event->setDrops([Item::get(Item::COAL, 0, 1 + $rand)]);
		        }
	         break;
	         case 21:
	           if($item->isPickaxe() && $item->getId() !== 270){
		          $event->setDrops([Item::get(Item::DYE, 4, rand(1, 4) + $rand)]);
		        }
	         break;
	         case 73:
	           if($item->isPickaxe() && $item->getId() !== 270){
		          $event->setDrops([Item::get(Item::REDSTONE, 0, rand(2, 3) + $rand)]);
		        }
	         break;
	         case 74:
	           if($item->isPickaxe() && $item->getId() !== 270){
		          $event->setDrops([Item::get(Item::REDSTONE, 0, rand(2, 3) + $rand)]);
		        }
	         break;
	         case 153:
	           if($item->isPickaxe() && $item->getId() !== 270){
		          $event->setDrops([Item::get(153, 0, rand(1, 2) + $rand)]);
		        }
	         break;
	         case 56:
	           if($item->isPickaxe() && !in_array($item->getId(), [270, 274, 285])){
		          $event->setDrops([Item::get(Item::DIAMOND, 0, 1 + $rand)]);
		        }
	         break;
	         case 129:
	           if($item->isPickaxe() && !in_array($item->getId(), [270, 274, 285])){
		          $event->setDrops([Item::get(388, 0, 1 + $rand)]);
		        }
	         break;
	         case 142: # Potato
	           if($item->isAxe() or $item->isPickaxe()){
		          if($block->getDamage() >= 7){
			         $event->setDrops([Item::get(Item::POTATO, 0, rand(1, 3) + $rand)]);
			       }
		        }
	         break;
	         case 141: # Carrot
	           if($item->isAxe() or $item->isPickaxe()){
		          if($block->getDamage() >= 7){
			         $event->setDrops([Item::get(Item::CARROT, 0, rand(1, 3) + $rand)]);
			       }
		        }
	         break;
	         case 244: # Beetroot
	           if($item->isAxe() or $item->isPickaxe()){
		          if($block->getDamage() >= 7){
			         $event->setDrops([Item::get(458, 0, rand(1, 3) + $rand), Item::get(457, 0, 1)]);
			       }
		        }
	         break;
	         case 59: # Wheat
	           if($item->isAxe() or $item->isPickaxe()){
		          if($block->getDamage() >= 7){
			         $event->setDrops([Item::get(Item::SEEDS, 0, rand(1, 3) + $rand), Item::get(Item::WHEAT, 0, 1)]);
			       }
		        }
	         break;
	         case 103: # Melon
	           if($item->isAxe() or $item->isPickaxe()){
			       $event->setDrops([Item::get(360, 0, rand(3, 9) + $rand)]);
		        }
	         break;
	         case 18: # Leaves
	           if(rand(1, 100) <= 10 + $level * 2){
		          $event->setDrops([Item::get(260, 0, 1)]);
		        }
	         break;
	     }
	   }
	}
}
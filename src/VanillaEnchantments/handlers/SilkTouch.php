<?php
namespace VanillaEnchantments\handlers;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

use VanillaEnchantments\Core;

class SilkTouch extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onBreak(BlockBreakEvent $event): void{
	    $item = $event->getItem();
	    $block = $event->getBlock();
	    if($item->hasEnchantment(Enchantment::SILK_TOUCH) && $block->getId() !== 52){
		   $drops = [];
		   foreach($event->getDrops() as $drop){
		      if($drop->getId() == $block->getId() and $drop->getDamage() == $block->getDamage()){
		        $drops[] = $drop;
		      }else{
		       $drop[] = Item::get($block->getId(), $item->getDamage(), 1);
		      }
		   }
		   $event->setDrops($drops);
		}
	}
}

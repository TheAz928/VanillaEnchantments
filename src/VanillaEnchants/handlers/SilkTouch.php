<?php
namespace VanillaEnchants\handlers;

use pocketmine\item\Item;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

class SilkTouch extends VanillaEnchant implements Listener{
	
	public function __construct(){
	    # Maybe link core?
	}
	
	public function onBreak(BlockBreakEvent $event){
	    $item = $event->getItem();
	    $block = $event->getBlock();
	    if($item->hasEnchantment(16) && $block->getId() !== 52){
		   $event->setDrops([Item::get($block->getId(), $block->getDamage(), 1)]);
		}
	}
}
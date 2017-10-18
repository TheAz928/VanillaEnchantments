<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class DepthStrider extends VanillaEnchant implements Listener{
	
	public function __construct(){
	  # Maybe link core?
	}
	
	public function onMove(PlayerMoveEvent $event){
	    $player = $event->getPlayer();
	    $add = $this->getArmorPoints($player, 7);
       $speed = $player->getAttributeMap()->getAttribute(5)->getDefaultValue() + ($add * 0.03); # Not sure about actual speed
	    if(in_array($player->getLevel()->getBlock($player)->getId(), [8, 9]) && $add > 0){
	      if($player->getAttributeMap()->getAttribute(5)->getValue() < $speed){
	        $player->getAttributeMap()->getAttribute(5)->setValue($speed, false, true);
		   }
	   }elseif(!in_array($player->getLevel()->getBlock($player)->getId(), [8, 9])){
         if($player->getAttributeMap()->getAttribute(5)->getValue() == $speed){
            $player->getAttributeMap()->getAttribute(5)->setValue($player->getAttributeMap()->getAttribute(5)->getDefaultValue(), false, true);
         }
      }
	}
}
<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\entity\Entity;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ShortTag;

class Flame extends VanillaEnchant implements Listener{
	
	public function __construct(){
	    # Maybe link core?
	}
	
	public function onShoot(EntityShootBowEvent $event){
	    $player = $event->getEntity();
	    $bow = $event->getBow();
	    if($event->isCancelled() == false && $bow->hasEnchantment(21)){
		   $lvl = $bow->getEnchantment(21)->getLevel();
		   $directionVector = $player->getDirectionVector();
		   $nbt = new CompoundTag("", [
			   new ListTag("Pos", [
				   new DoubleTag("", $player->x),
				   new DoubleTag("", $player->y + $player->getEyeHeight()),
				   new DoubleTag("", $player->z)
			   ]),
			   new ListTag("Motion", [
				   new DoubleTag("", $directionVector->x),
				   new DoubleTag("", $directionVector->y),
				   new DoubleTag("", $directionVector->z)
			   ]),
			   new ListTag("Rotation", [
				   new FloatTag("", ($player->yaw > 180 ? 360 : 0) - $player->yaw),
				   new FloatTag("", -$player->pitch)
			   ]),
			   new ShortTag("Fire", $lvl < 2 ? 45 * 60 : 80 * 60)
		    ]);
          $ent = Entity::createEntity("Arrow", $player->getLevel(), $nbt, $player, $event->getProjectile()->isCritical());
          $ent->setMotion($ent->getMotion()->multiply($event->getForce()));
          $ent->setOnFire(200);
		    $event->setProjectile($ent);
		}
	}
}
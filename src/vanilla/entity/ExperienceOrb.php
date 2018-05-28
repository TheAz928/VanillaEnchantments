<?php
namespace vanilla\entity;

use pocketmine\Player;

use pocketmine\item\Durable;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\entity\Entity;
use pocketmine\entity\object\ExperienceOrb as PMXP;
use pocketmine\entity\Human;

use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ShortTag;

class ExperienceOrb extends PMXP{

	/**
	 * @param int $tickDiff
	 * @return bool
	 */
	
	public function entityBaseTick(int $tickDiff = 1) : bool{
			$hasUpdate = Entity::entityBaseTick($tickDiff);
			if($this->age > 6000){
				$this->flagForDespawn();
				return true;
			}
			$currentTarget = $this->getTargetPlayer();
			if($currentTarget !== null and $currentTarget->distanceSquared($this) > self::MAX_TARGET_DISTANCE ** 2){
				$currentTarget = null;
			}
			if($this->lookForTargetTime >= 20){
				if($currentTarget === null){
					$newTarget = $this->level->getNearestEntity($this, self::MAX_TARGET_DISTANCE, Human::class);
					if($newTarget instanceof Human and !($newTarget instanceof Player and $newTarget->isSpectator())){
						$currentTarget = $newTarget;
					}
				}
				$this->lookForTargetTime = 0;
			}else{
				$this->lookForTargetTime += $tickDiff;
			}
			$this->setTargetPlayer($currentTarget);
			if($currentTarget !== null){
				$vector = $currentTarget->subtract($this)->add(0, $currentTarget->getEyeHeight() / 2, 0)->divide(self::MAX_TARGET_DISTANCE);
				$distance = $vector->length();
				$oneMinusDistance = (1 - $distance) ** 2;
				if($oneMinusDistance > 0){
					$this->motion->x += $vector->x / $distance * $oneMinusDistance * 0.2;
					$this->motion->y += $vector->y / $distance * $oneMinusDistance * 0.2;
					$this->motion->z += $vector->z / $distance * $oneMinusDistance * 0.2;
				}
				if($currentTarget->canPickupXp() and $this->boundingBox->intersectsWith($currentTarget->getBoundingBox())){
					$this->flagForDespawn();
					$hand = $currentTarget->getInventory()->getItemInHand();
					$armors = $currentTarget->getArmorInventory()->getContents(true);
					$helmet = $armors[0];
					$chestplate = $armors[1];
					$leggings = $armors[2];
					$boots = $armors[3];
					$possible = [];
					$selected = null;
					$all = array_merge([$hand], $armors);
					foreach($all as $item){
						if($item->hasEnchantment(Enchantment::MENDING) and $item->getDamage() > 0 and $item instanceof Durable){
							$possible[] = $item;
						}
					}
					if(count($possible) > 0){
						$selected = $possible[array_rand($possible)];
						if(($this->getXpValue() * 2) > $selected->getDamage()){
							$left = ($this->getXpValue() * 2) - $selected->getDamage();
							$selected->setDamage(0);
						}else{
							$left = 0;
							$selected->setDamage($selected->getDamage() - ($this->getXpValue() * 2));
						}
						if($selected->equals($hand)){
							$currentTarget->getInventory()->setItemInHand($selected);
						}elseif($selected->equals($helmet)){
							$currentTarget->getArmorInventory()->setItem(0, $selected);
						}elseif($selected->equals($chestplate)){
							$currentTarget->getArmorInventory()->setItem(1, $selected);
						}elseif($selected->equals($leggings)){
							$currentTarget->getArmorInventory()->setItem(2, $selected);
						}elseif($selected->equals($boots)){
							$currentTarget->getArmorInventory()->setItem(3, $selected);
						}
						if($left > 0){
							$currentTarget->addXp($left);
							$currentTarget->resetXpCooldown();
						}else{
							return $hasUpdate;
						}
					}else{
						$currentTarget->addXp($this->getXpValue());
						$currentTarget->resetXpCooldown();
					}
				}
			}
			return $hasUpdate;
	}
}

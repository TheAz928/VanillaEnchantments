<?php
namespace vanilla;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\item\Item;
use pocketmine\item\Sword;
use pocketmine\item\ItemFactory;
use pocketmine\item\Armor;
use pocketmine\item\Bow;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;

use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileHitBlockEvent;

use vanilla\entity\ExperienceOrb;
use vanilla\item\EnchantedBook;

class Core extends PluginBase implements Listener{
	
	const UNDEAD = [
			Entity::ZOMBIE,
			Entity::HUSK,
			Entity::WITHER,
			Entity::SKELETON,
			Entity::STRAY,
			Entity::WITHER_SKELETON,
			Entity::ZOMBIE_PIGMAN,
			Entity::ZOMBIE_VILLAGER
	];
	
	const ARTHROPODS = [
			Entity::SPIDER,
			Entity::CAVE_SPIDER,
			Entity::SILVERFISH,
			Entity::ENDERMITE
	];
	
	const CONFIG_VER = "2.0";
	
	public function onLoad(){
			$this->saveDefaultConfig();
			if($this->getConfig()->get("version", null) !== self::CONFIG_VER){
				$this->getLogger()->info("Outdated config version detected, updating config...");
				$this->saveResource("config.yml", true);
			}
			$this->getLogger()->info("Loading vanilla enchantments by TheAz928...");
			
			$this->registerTypes();
			
			ItemFactory::registerItem(new EnchantedBook(), true);
			Item::initCreativeItems();
			
	}
	
	public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->getLogger()->info("Vanilla enchantments were successfully registered");
	}
	
	public function registerTypes() : void{
			Enchantment::registerEnchantment(new Enchantment(Enchantment::SHARPNESS, "Sharpness", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::SMITE, "Smite", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::BANE_OF_ARTHROPODS, "Bane of arthropods", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
			
			Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_DIG, Enchantment::SLOT_NONE, 3));
			
			Enchantment::registerEnchantment(new Enchantment(Enchantment::PUNCH, "Punch", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::POWER, "Power", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE, 5));
			
			// ToDo: frost walker and others
	}
	
	/**
	 * @param BlockBreakEvent $event
	 * @param ignoreCancelled false
	 * @priority LOWEST
	 */
	
	public function onBreak(BlockBreakEvent $event) : void{
			$player = $event->getPlayer();
			$block = $event->getBlock();
			$item = $event->getItem();
			if($event->isCancelled() == false){
				
				// This fixes apple drop rate
				
				if($block->getId() == Item::LEAVES){
					if(rand(1, 100) <= 10){
						$event->setDrops([Item::get(Item::APPLE)]);
					}
				}
				
				if(($level = $item->getEnchantmentLevel(Enchantment::FORTUNE)) > 0){
					$add = rand(0, $level + 1);
					switch($block->getId()){
						case Item::COAL_ORE:
							$event->setDrops([Item::get(Item::COAL, 0, 1 + $add)]);
						break;
						case Item::DIAMOND_ORE:
							$event->setDrops([Item::get(Item::DIAMOND, 0, 1 + $add)]);
						break;
						case Item::LAPIS_ORE:
							$event->setDrops([Item::get(Item::DYE, 4, rand(4, 8) + $add)]);
						break;
						case Item::REDSTONE_ORE:
							$event->setDrops([Item::get(Item::REDSTONE_DUST, 0, rand(4, 8) + $add)]);
						break;
						case Item::EMERALD_ORE:
							$event->setDrops([Item::get(Item::EMERALD, 0, 1 + $add)]);
						break;
						case Item::LEAVES:
							if(rand(1, 100) <= $level * 2){
								$event->setDrops([Item::get(Item::APPLE)]);
							}
						break;
						case Item::NETHER_QUARTZ_ORE:
							$event->setDrops([Item::get(Item::NETHER_QUARTZ, 0, rand(4, 8) + $add)]);
						break;
					}
				}
			}
	}
	
	/**
	 * @param EntityDamageByEntityEvent $event
	 * @ignoreCancelled true
	 * @priority NORMAL
	 */
	
	public function onDamage(EntityDamageByEntityEvent $event) : void{
			$player = $event->getEntity();
			if(($damager = $event->getDamager()) instanceof Player){
				$item = $damager->getInventory()->getItemInHand();
				
				if(($level = $item->getEnchantmentLevel(Enchantment::SMITE)) > 0){
					if(in_array($player::NETWORK_ID, self::UNDEAD)){
						$event->setBaseDamage($event->getBaseDamage() + (2.5 * $level));
					}
				}
				
				if(($level = $item->getEnchantmentLevel(Enchantment::BANE_OF_ARTHROPODS)) > 0){
					if(in_array($player::NETWORK_ID, self::ARTHROPODS)){
						$event->setBaseDamage($event->getBaseDamage() + (2.5 * $level));
					}
				}
				
				if(($level = $item->getEnchantmentLevel(Enchantment::SHARPNESS)) > 0 and $item instanceof Sword){
					$event->setBaseDamage($event->getBaseDamage() + 1 + (0.4 * $level));
				}
				
				if(($level = $item->getEnchantmentLevel(Enchantment::POWER)) > 0 and $item instanceof Bow){
					$event->setBaseDamage($event->getBaseDamage() + (($event->getBaseDamage() * (25 / 100)) * $level));
				}
				
				if(($level = $item->getEnchantmentLevel(Enchantment::PUNCH)) > 0 and $item instanceof Bow){
					$event->setKnockBack($event->getKnockBack() + (0.25 * $level));
				}
				
				// ToDo: proper loot table
				
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::LOOTING)) > 0){
					if($player instanceof Player == false and $player instanceof Living and $event->getFinalDamage() >= $player->getHealth()){
						$player->flagForDespawn();
						foreach($player->getDrops() as $drop){
							$drop->setCount($drop->getCount() + rand(0, $level));
							$damager->getLevel()->dropItem($player, $drop);
						}
					}
				}
			}
	}
	
	/**
	 * @param EntityShootBowEvent $event
	 * @ignoreCancelled false
	 * @priority MONITOR
	 */
	
	public function onShoot(EntityShootBowEvent $event) : void{
			$arrow = $event->getProjectile();
			
			if($event->isCancelled() == false){
				if($arrow !== null and $arrow::NETWORK_ID == Entity::ARROW){
					$event->setForce($event->getForce() + 0.95); // In vanilla, arrows are fast
				}
			}
	}
}
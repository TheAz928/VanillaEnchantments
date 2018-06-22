<?php
namespace vanilla;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\item\Item;
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
			Entity::ZOMBIE_PIGMAN
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
			Entity::registerEntity(ExperienceOrb::class, true, ["XPOrb"]);
			ItemFactory::registerItem(new EnchantedBook(), true);
			Item::initCreativeItems();
	}
	
	public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->getLogger()->info("Vanilla enchantments were successfully registered");
	}
	
	public function registerTypes() : void{
			Enchantment::registerEnchantment(new Enchantment(Enchantment::THORNS, "Thorns", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_ARMOR, Enchantment::SLOT_NONE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::DEPTH_STRIDER, "Depth Strider", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_FEET, Enchantment::SLOT_NONE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::AQUA_AFFINITY, "Aqua Affinity", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_HEAD, Enchantment::SLOT_NONE, 1));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::SHARPNESS, "Sharpness", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::SMITE, "Smite", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::BANE_OF_ARTHROPODS, "Bane of arthropods", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::KNOCKBACK, "Knockback", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FIRE_ASPECT, "Fire aspect", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_DIG, Enchantment::SLOT_NONE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::POWER, "Power", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::PUNCH, "Punch", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FLAME, "Flame", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::INFINITY, "Infinity", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, Enchantment::SLOT_NONE, 1));
			# Enchantment::registerEnchantment(new Enchantment(Enchantment::FROST_WALKER, "Frost Walker", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_FEET, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::MENDING, "Mending", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_ALL, Enchantment::SLOT_NONE, 1));
			
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
							$event->setDrops([Item::get(Item::NETHER_QUARTZ, 1, rand(4, 8) + $add)]);
						break;
					}
				}
			}
	}
	
	/**
	 * @param EntityDamageByEntityEvent $event
	 * @ignoreCancelled false
	 * @priority NORMAL
	 */
	
	public function onDamage(EntityDamageByEntityEvent $event) : void{
			if($event->isCancelled()){
				return;
			}
			$player = $event->getEntity();
			if(($damager = $event->getDamager()) instanceof Player){
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::SHARPNESS)) > 0){
					$damage = $event->getBaseDamage() + ($level * 0.4 + 1);
					$event->setBaseDamage($damage);
				}
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::KNOCKBACK)) > 0){
					$event->setKnockBack((0.4 * $level) + 0.1);
				}
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::FIRE_ASPECT)) > 0){
					$player->setOnFire(10 * $level);
				}
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::SMITE)) > 0){
					if(in_array($player::NETWORK_ID, self::UNDEAD)){
						$event->setBaseDamage($event->getBaseDamage() + (2.5 * $level));
					}
				}
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::BANE_OF_ARTHROPODS)) > 0){
					if(in_array($player::NETWORK_ID, self::ARTHROPODS)){
						$event->setBaseDamage($event->getBaseDamage() + (2.5 * $level));
					}
				}
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::POWER)) > 0 and $damager->getInventory()->getItemInHand() instanceof Bow and $event->getCause() == EntityDamageEvent::CAUSE_PROJECTILE){
					$add = ($event->getBaseDamage() * (25 / 100)) * $level; // Each level adds +25% of base damage
					$event->setBaseDamage($event->getBaseDamage() + $add);
				}
				if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::PUNCH)) > 0 and $damager->getInventory()->getItemInHand() instanceof Bow and $event->getCause() == EntityDamageEvent::CAUSE_PROJECTILE){
					$event->setKnockBack((0.4 * $level) + 0.1);
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
				if($player instanceof Player){
					foreach($player->getArmorInventory()->getContents() as $slot => $armor){
						if(($level = $armor->getEnchantmentLevel(Enchantment::THORNS)) > 0){
							if(rand(1, 100) <= 15 * $level){
								$damager->attack(new EntityDamageEvent($damager, EntityDamageEvent::CAUSE_CUSTOM, 2));
								$armor->applyDamage(rand(2, 8));
								$player->getArmorInventory()->setItem($slot, $armor);
								break;
							}
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
			$player = $event->getEntity();
			$arrow = $event->getProjectile();
			$item = $event->getBow();
			if($event->isCancelled() == false){
				if($arrow::NETWORK_ID == Entity::ARROW){
					$event->setForce($event->getForce() + 0.95); // In vanilla, arrows are fast
				}
				if(($level = $item->getEnchantmentLevel(Enchantment::FLAME)) > 0){
					$arrow->namedtag->setShort("Fire", 20 * $level);
					$arrow->setOnFire(80);
				}
				if(($level = $item->getEnchantmentLevel(Enchantment::INFINITY)) > 0){
					if($player instanceof Player and $player->isCreative() == false){
						$player->getInventory()->addItem(Item::get(Item::ARROW));
					}
					$arrow->namedtag->setByte("infinity", 0);
				}
			}
	}
	
	/**
	 * @param ProjectileHitEvent $event
	 * @ignoreCancelled true
	 * @priority HIGHEST
	 */
	
	public function onGroundHit(ProjectileHitBlockEvent $event) : void{
			$entity = $event->getEntity();
			if($entity->namedtag->getByte("infinity", 1) !== 1){
				$entity->flagForDespawn();
			}
	}
}
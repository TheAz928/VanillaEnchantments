<?php
namespace vanilla;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\item\Item;
use pocketmine\item\Armor;
use pocketmine\item\Bow;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\entity\Entity;

use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\entity\ProjectileHitEvent;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;

class Core extends PluginBase implements Listener{
	
	const DURABILITY = [
	      /** Helmet durabilities */
			Item::LEATHER_HELMET => 56,
			Item::GOLD_HELMET => 78,
			Item::CHAIN_HELMET => 166,
			Item::IRON_HELMET => 166,
			Item::DIAMOND_HELMET => 364,
			/** Chestplate durabilities */
			Item::LEATHER_CHESTPLATE => 81,
			Item::GOLD_CHESTPLATE => 113,
			Item::CHAIN_CHESTPLATE => 241,
			Item::IRON_CHESTPLATE => 241,
			Item::DIAMOND_CHESTPLATE => 529,
			/** Legging durabilities */
			Item::LEATHER_LEGGINGS => 76,
			Item::GOLD_LEGGINGS => 106,
			Item::CHAIN_LEGGINGS => 266,
			Item::IRON_LEGGINGS => 266,
			Item::DIAMOND_LEGGINGS => 497,
			/** Boot durabilities */
			Item::LEATHER_BOOTS => 66,
			Item::GOLD_BOOTS => 92,
			Item::CHAIN_BOOTS => 196,
			Item::IRON_BOOTS => 196,
			Item::DIAMOND_BOOTS => 430,
	];
	
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
	
	const CONFIG_VER = "0x1";
	
	/** @var DamageArmorTask */
	private $task;
	
	public function onLoad(){
			$this->saveDefaultConfig();
			if($this->getConfig()->get("version", null) !== self::CONFIG_VER){
				$this->getLogger()->info("Invalif config version detected, updating config...");
				$this->saveResource("config.yml", true);
			}
			$this->getLogger()->info("Loading vanilla enchantments by TheAz928...");
			$this->registerTypes();
	}
	
	public function onEnable(){
			$this->getServer()->getPluginManager()->registerEvents($this, $this);
			$this->task = new DamageArmorTask($this);
			$this->getLogger()->info("Vanilla enchantments were successfully registered");
	}
	
	public function registerTypes() : void{
			Enchantment::registerEnchantment(new Enchantment(Enchantment::THORNS, "Thorns", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_ARMOR, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::DEPTH_STRIDER, "Depth Strider", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_FEET, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::AQUA_AFFINITY, "Aqua Affinity", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_HEAD, 1));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::SHARPNESS, "Sharpness", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::SMITE, "Smite", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::BANE_OF_ARTHROPODS, "Bane of arthropods", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::KNOCKBACK, "Knockback", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FIRE_ASPECT, "Fire aspect", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_PICKAXE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_PICKAXE, 3));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::POWER, "Power", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, 5));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::PUNCH, "Punch", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::FLAME, "Flame", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, 2));
			Enchantment::registerEnchantment(new Enchantment(Enchantment::INFINITY, "Infinity", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_BOW, 1));
			# Enchantment::registerEnchantment(new Enchantment(Enchantment::FROST_WALKER, "Frost Walker", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_FEET, 2));
			# Enchantment::registerEnchantment(new Enchantment(Enchantment::MENDING, "Mending", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_ALL, 1));
			
	}
	
	/**
	 * @param Player $player
	 */
	
	public function broadcastArmorBreak(Player $player) : void{
			$pk = new PlaySoundPacket();
			$pk->x = (int) $player->x;
			$pk->y = (int) $player->y;
			$pk->z = (int) $player->z;
			$pk->volume = 1000;
			$pk->pitch = rand(0, 4);
			$pk->soundName = "random.break";
			foreach($player->getLevel()->getNearbyEntities($player->getBoundingBox()->grow(15, 15, 15)) as $ent){
				if($ent instanceof Player){
					$ent->dataPacket($pk);
				}
			}
	}
	
	/**
	 * @return DamageArmorTask
	 */
	
	public function getDamageArmorTask() : DamageArmorTask{
			return $this->task;
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function damageHelmet(Player $player, int $damage = 1) : void{
			$inv = $player->getArmorInventory();
			$helmet = $inv->getHelmet();
			if($helmet instanceof Armor){
				if(($level = $helmet->getEnchantmentLevel(Enchantment::UNBREAKING)) > 0){
					if(rand(0, 100) <= 5 * $level){
						return;
					}
				}
				if($helmet->getDamage() >= self::DURABILITY[$helmet->getId()]){
					$inv->setHelmet(Item::get(Item::AIR));
					$this->broadcastArmorBreak($player);
				}else{
					$helmet->setDamage($helmet->getDamage() + $damage);
					$inv->setHelmet($helmet);
				}
			}
			$inv->sendContents($player);
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function damageChestplate(Player $player, int $damage = 1) : void{
			$inv = $player->getArmorInventory();
			$chest = $inv->getChestplate();
			if($chest instanceof Armor){
				if(($level = $chest->getEnchantmentLevel(Enchantment::UNBREAKING)) > 0){
					if(rand(0, 100) <= 5 * $level){
						return;
					}
				}
				if($chest->getDamage() >= self::DURABILITY[$chest->getId()]){
					$inv->setChestplate(Item::get(Item::AIR));
					$this->broadcastArmorBreak($player);
				}else{
					$chest->setDamage($chest->getDamage() + $damage);
					$inv->setChestplate($chest);
				}
			}
			$inv->sendContents($player);
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function damageLeggings(Player $player, int $damage = 1) : void{
			$inv = $player->getArmorInventory();
			$leg = $inv->getLeggings();
			if($leg instanceof Armor){
				if(($level = $leg->getEnchantmentLevel(Enchantment::UNBREAKING)) > 0){
					if(rand(0, 100) <= 5 * $level){
						return;
					}
				}
				if($leg->getDamage() >= self::DURABILITY[$leg->getId()]){
					$inv->setLeggings(Item::get(Item::AIR));
					$this->broadcastArmorBreak($player);
				}else{
					$leg->setDamage($leg->getDamage() + $damage);
					$inv->setLeggings($leg);
				}
			}
			$inv->sendContents($player);
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function damageBoots(Player $player, int $damage = 1) : void{
			$inv = $player->getArmorInventory();
			$boot = $inv->getBoots();
			if($boot instanceof Armor){
				if(($level = $boot->getEnchantmentLevel(Enchantment::UNBREAKING)) > 0){
					if(rand(0, 100) <= 5 * $level){
						return;
					}
				}
				if($boot->getDamage() >= self::DURABILITY[$boot->getId()]){
					$inv->setBoots(Item::get(Item::AIR));
					$this->broadcastArmorBreak($player);
				}else{
					$boot->setDamage($boot->getDamage() + $damage);
					$inv->setBoots($boot);
				}
			}
			$inv->sendContents($player);
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function useArmors(Player $player, int $damage = 1) : void{
			$this->damageHelmet($player, $damage);
			$this->damageChestplate($player, $damage);
			$this->damageLeggings($player, $damage);
			$this->damageBoots($player, $damage);
	}
	
	/**
	 * @param BlockBreakEvent $event
	 * 
	 * @priority LOWEST
	 */
	
	public function onBreak(BlockBreakEvent $event) : void{
			$player = $event->getPlayer();
			$block = $event->getBlock();
			$item = $event->getItem();
			if($event->isCancelled() == false){
				if(($level = $item->getEnchantmentLevel(Enchantment::FORTUNE)) > 0){
					$add = 1 + rand(0, $level);
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
							if(rand(0, 100) <= $level * 2){
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
	 * @param EntityDamageEvent $event
	 * 
	 * @priority HIGHEST
	 */
	
	public function onDamage(EntityDamageEvent $event) : void{
			if($event->isCancelled()){
				return;
			}
			$player = $event->getEntity();
			$ignore = [
				EntityDamageEvent::CAUSE_STARVATION,
				EntityDamageEvent::CAUSE_MAGIC,
				EntityDamageEvent::CAUSE_DROWNING,
				EntityDamageEvent::CAUSE_CUSTOM,
			];
			if($player instanceof Player){
				if(in_array($event->getCause(), $ignore) == false){
					$this->getDamageArmorTask()->addArmorQueue($player, $this->getConfig()->get("armor.damage", 1));
				}
			}
			if($event instanceof EntityDamageByEntityEvent){
				if(($damager = $event->getDamager()) instanceof Player){
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::SHARPNESS)) > 0){
						$damage = $event->getDamage() + (1 + ($level * 0.5));
						$event->setDamage($damage);
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::KNOCKBACK)) > 0){
						$event->setKnockBack(0.4 * $level + 0.4);
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::FIRE_ASPECT)) > 0){
						$player->setOnFire(10 * $level);
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::SMITE)) > 0){
						if(in_array(self::UNDEAD, $player::NETWORK_ID)){
							$event->setDamage($event->getDamage() + (2.5 * $level));
						}
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::BANE_OF_ARTHROPODS)) > 0){
						if(in_array(self::ARTHROPODS, $player::NETWORK_ID)){
							$event->setDamage($event->getDamage() + (2.5 * $level));
						}
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::POWER)) > 0 and $damager->getInventory()->getItemInHand() instanceof Bow and $event->getCause() == EntityDamageEvent::CAUSE_PROJECTILE){
						$add = ($event->getDamage() * (25 / 100)) * $level; // Each level adds +25% of base damage
						$event->setDamage($event->getDamage() + $add);
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::PUNCH)) > 0 and $damager->getInventory()->getItemInHand() instanceof Bow and $event->getCause() == EntityDamageEvent::CAUSE_PROJECTILE){
						$event->setKnockBack(0.4 * $level);
					}
					if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::LOOTING)) > 0){
						if($player instanceof Player == false and $event->getFinalDamage() >= $player->getHealth()){
							$player->close();
							foreach($player->getDrops() as $drop){
								$drop->setCount($drop->getCount() + rand(0, $level));
								$damager->getLevel()->dropItem($player, $drop);
							}
						}
					}
					if($player instanceof Player){
						foreach($player->getArmorInventory()->getContents() as $armor){
							if(($level = $armor->getEnchantmentLevel(Enchantment::THORNS)) > 0){
								// ToDo: Damage armors properly
								if(rand(0, 100) <= 15 * $level){
									$damager->attack(new EntityDamageEvent($damager, EntityDamageEvent::CAUSE_CUSTOM, 2));
									$this->getDamageArmorTask()->addArmorQueue($player, 3);
								}
							}
						}
					}
				}
			}
	}
	
	/**
	 * @param EntityShootBowEvent $event
	 * 
	 * @priority HIGHEST
	 */
	
	public function onShoot(EntityShootBowEvent $event) : void{
			$player = $event->getEntity();
			$arrow = $event->getProjectile();
			$item = $event->getBow();
			if($event->isCancelled() == false){
				$event->setForce($event->getForce() + 0.5); // In vanilla, arrows are fast
				if(($level = $item->getEnchantmentLevel(Enchantment::FLAME)) > 0){
					$arrow->namedtag->setShort("Fire", 20 * $level);
					$arrow->setOnFire(80);
				}
				if(($level = $item->getEnchantmentLevel(Enchantment::INFINITY)) > 0){
					if($player instanceof Player and $player->isCreative() == false){
						$player->getInventory()->addItem(Item::get(Item::ARROW));
					}
					$arrow->namedtag->setByte("inf", 1);
				}
			}
	}
	
	/**
	 * @param ProjectileHitEvent $event
	 * 
	 * @priority HIGHEST
	 */
	
	public function onHit(ProjectileHitEvent $event) : void{
			$entity = $event->getEntity();
			if($entity->namedtag->getByte("inf", 0) > 0){
				$entity->flagForDespawn();
			}
	}
}

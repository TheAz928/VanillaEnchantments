<?php
namespace vanilla;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\block\Block;

use pocketmine\item\Item;
use pocketmine\item\Sword;
use pocketmine\item\ItemFactory;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\entity\Entity;
use pocketmine\entity\Living;

use pocketmine\event\Listener;

use pocketmine\event\block\BlockBreakEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;

use pocketmine\event\entity\EntityShootBowEvent;

use vanilla\item\EnchantedBook;

class Core extends PluginBase implements Listener{
	
	public const UNDEAD = [
		Entity::ZOMBIE,
		Entity::HUSK,
		Entity::WITHER,
		Entity::SKELETON,
		Entity::STRAY,
		Entity::WITHER_SKELETON,
		Entity::ZOMBIE_PIGMAN,
		Entity::ZOMBIE_VILLAGER
	];
	
	public const ARTHROPODS = [
		Entity::SPIDER,
		Entity::CAVE_SPIDER,
		Entity::SILVERFISH,
		Entity::ENDERMITE
	];
	
	public const CONFIG_VER = "1.2.5";
	
	public function onLoad(){
		$this->saveDefaultConfig();
			
		if($this->getConfig()->get("version", null) !== self::CONFIG_VER){
			$this->getLogger()->info("Outdated config version detected, updating config...");
			$this->saveResource("config.yml", true);
		}
			
		$this->getLogger()->info("Registering enchantments and enchanted books...");
			
		$this->registerTypes();
			
		ItemFactory::registerItem(new EnchantedBook(), true);
		Item::initCreativeItems();
			
	}
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Vanilla enchantments were successfully registered");
	}
	
	public function registerTypes() : void{
		// some enchabtments are mit done and some will be removed in future
		Enchantment::registerEnchantment(new Enchantment(Enchantment::DEPTH_STRIDER, "Depth strider", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_FEET, Enchantment::SLOT_AXE, 3));
		Enchantment::registerEnchantment(new Enchantment(Enchantment::AQUA_AFFINITY, "Aqua affinity", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_HEAD, Enchantment::SLOT_AXE, 1));
		
		Enchantment::registerEnchantment(new Enchantment(Enchantment::SMITE, "Smite", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
		Enchantment::registerEnchantment(new Enchantment(Enchantment::BANE_OF_ARTHROPODS, "Bane of arthropods", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_AXE, 5));
		
		Enchantment::registerEnchantment(new Enchantment(Enchantment::UNBREAKING, "%enchantment.durability", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_DIG | Enchantment::SLOT_ARMOR | Enchantment::SLOT_FISHING_ROD | Enchantment::SLOT_BOW | Enchantment::SLOT_SWORD, Enchantment::SLOT_TOOL | Enchantment::SLOT_CARROT_STICK | Enchantment::SLOT_ELYTRA, 3));
		Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_SWORD, Enchantment::SLOT_NONE, 3));
		Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", Enchantment::RARITY_UNCOMMON, Enchantment::SLOT_DIG, Enchantment::SLOT_NONE, 3));
	}
	
	/**
	 * @param BlockBreakEvent $event
	 * @param ignoreCancelled true
	 * @priority LOWEST
	 */
	
	public function onBreak(BlockBreakEvent $event) : void{
		$player = $event->getPlayer();
		$block = $event->getBlock();
		$item = $event->getItem();
	
		if($block->getId() == Item::LEAVES){
			if(mt_rand(1, 99) <= 10){
				$event->setDrops([Item::get(Item::APPLE)]);
			}
		}
				
		if(($level = $item->getEnchantmentLevel(Enchantment::FORTUNE)) > 0){
			$add = mt_rand(0, $level + 1);
					
			if($block->getId() == Block::LEAVES){
				if(mt_rand(1, 99) <= 10){
					$event->setDrops([Item::get(Item::APPLE)]);
				}
			}
			
			foreach($this->getConfig()->get("fortune.blocks", []) as $str){
				$it = Item::fromString($str);
				
				if($block->getId() == $it->getId()){
					if(mt_rand(1, 99) <= 10 * $level){
						if(empty($event->getDrops()) == false){
							$event->setDrops(array_map(function(Item $drop){
								$drop->setCount($drop->getCount() + $add);
								return $drop;
							}, $event->getDrops()));
						}
					}
					
					break;
				}
			}
		}
	}
	
	/**
	 * @param EntityDamageByEntityEvent $event
	 * @ignoreCancelled true
	 * @priority LOWEST
	 */
	
	public function onDamage(EntityDamageByEntityEvent $event) : void{
		$player = $event->getEntity();
		
		if(($damager = $event->getDamager()) instanceof Player){
			$item = $damager->getInventory()->getItemInHand();
				
			if($item->hasEnchantment(Enchantment::SMITE)){
				if(in_array($player::NETWORK_ID, self::UNDEAD)){
					$event->setBaseDamage($event->getBaseDamage() + (2.5 * $item->getEnchantmentLevel(Enchantment::SMITE)));
				}
			}
				
			if($item->hasEnchantment(Enchantment::BANE_OF_ARTHROPODS)){
				if(in_array($player::NETWORK_ID, self::ARTHROPODS)){
					$event->setBaseDamage($event->getBaseDamage() + (2.5 * $item->getEnchantmentLevel(Enchantment::BANE_OF_ARTHROPODS)));
				}
			}
			
			if(($level = $damager->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::LOOTING)) > 0){
				if($player instanceof Player == false and $player instanceof Living and $event->getFinalDamage() >= $player->getHealth()){
					$add = mt_rand(0, $level + 1);
					
					foreach($this->getConfig()->get("looting.entities") as $eid => $items){
						$id = constant(Entity::class."::".strtoupper($eid));
						
						if($player::NETWORK_ID == $id){
							$drops = $this->getLootingDrops($player->getDrops(), $items, $add);
							
							foreach($drops as $drop){
								$damager->getLevel()->dropItem($player, $drop);
							}
							
							$player->flagForDespawn();
						}
					}
				}
			}
		}
	}
	
	/**
	 * @param array $drops
	 * @param array $items
	 * @param int $add
	 * @return array
	 */
	
	public function getLootingDrops(array $drops, array $items, int $add) : array{
		$r = [];
		
		foreach($items as $ite){
			$item = Item::fromString($ite);
			
			foreach($drops as $drop){
				if($drop->getId() == $item->getId()){
					$drop->setCount($drop->getCount() + $add);
				}
				
				$r[] = $drop;
				break;
			}
		}
		
		return $r;
	}
	
	/**
	 * @param EntityShootBowEvent $event
	 * @ignoreCancelled true
	 * @priority LOWEST
	 */
	
	public function onShoot(EntityShootBowEvent $event) : void{
		$arrow = $event->getProjectile();
		$bow = $event->getBow();
		
		if($arrow !== null and $arrow::NETWORK_ID == Entity::ARROW){
			$event->setForce($event->getForce() + 0.95); // In vanilla, arrows are fast
		}
	}
}
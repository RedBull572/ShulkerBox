<?php

namespace UltraFlappy\ShulkerBox\block;

use UltraFlappy\ShulkerBox\tile\
  ShulkerBox as ShulkerTile;
use UltraFlappy\ShulkerBox\tile\tile as Tile;
use UltraFlappy\ShulkerBox\Main;
use pocketmine\block\Block;
use pocketmine\block\BlockToolType;
use pocketmine\block\Transparent;
use pocketmine\tile\Container;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\math\Vector3;


class ShulkerBox extends Transparent {

	public function __construct(int $id = self::SHULKER_BOX, int $meta = 0){
		$this->id = $id;
		$this->meta = $meta;
	}

	public function getResistance(): float{
		return 30;
	}

	public function getHardness(): float{
		return 2;
	}

	public function getToolType(): int{
		return BlockToolType::TYPE_PICKAXE;
	}

	public function getName(): string{
		return "Shulker Box";
	}

	public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null): bool{
		$this->getLevel()->setBlock($blockReplace, $this, true, true);
		$nbt = ShulkerTile::createNBT($this, $face, $item, $player);
		$items = $item->getNamedTag()->getTag(Container::TAG_ITEMS);
		if($items !== null){
			$nbt->setTag($items);
		}
		Tile::createTile(Tile::SHULKER_BOX, $this->getLevel(), $nbt);

     if($player->isCreative()){
		($inv = $player->getInventory())->clear($inv->getHeldItemIndex());
     }
		return true;
	}

	public function onBreak(Item $item, Player $player = null): bool{
		$t = $this->getLevel()->getTile($this);
		if($t instanceof ShulkerTile){
			$item = ItemFactory::get($this->id, $this->id != self::UNDYED_SHULKER_BOX ? $this->meta : 0, 1);
			$itemNBT = clone $item->getNamedTag();
			$itemNBT->setTag($t->getCleanedNBT()->getTag(Container::TAG_ITEMS));
			$item->setNamedTag($itemNBT);
			$this->getLevel()->dropItem($this->add(0.5,0.5,0.5), $item);

			$t->getInventory()->clearAll();
		}
		$this->getLevel()->setBlock($this, Block::get(Block::AIR), true, true);

		return true;
	}

	public function onActivate(Item $item, Player $player = null): bool{
			if($player instanceof Player){
				$t = $this->getLevel()->getTile($this);
				if(!($t instanceof ShulkerTile)){
					$t = Tile::createTile(Tile::SHULKER_BOX, $this->getLevel(), ShulkerTile::createNBT($this));
				}
				if($player->isSneaking()){
			  	}else{
				$player->addWindow($t->getInventory());
			}
		}

		return true;
	}

	public function getDrops(Item $item): array{
		return [];
	}
}

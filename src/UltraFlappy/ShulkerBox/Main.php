<?php

namespace UltraFlappy\ShulkerBox;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use UltraFlappy\ShulkerBox\tile\ShulkerBox as ShulkerTile;
use pocketmine\tile\Tile;
use pocketmine\block\Block;
use UltraFlappy\ShulkerBox\block\ShulkerBox;
use pocketmine\block\BlockFactory;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener {

public function onLoad(){
	Tile::registerTile(ShulkerTile::class);
        BlockFactory::registerBlock(new ShulkerBox(Block::UNDYED_SHULKER_BOX), true);
	BlockFactory::registerBlock(new ShulkerBox(), true);
	Item::initCreativeItems();
   }
public function onEnable(){
	$this->getServer()->getPluginManager()->registerEvents($this, $this);
  }
}

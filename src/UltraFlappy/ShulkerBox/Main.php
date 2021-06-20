<?php

namespace UltraFlappy\ShulkerBox;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\tile\Tile;
use pocketmine\block\Block;
use pocketmine\item\ItemFactory;
use UltraFlappy\ShulkerBox\tile\ShulkerBox as ShulkerTile;
use UltraFlappy\ShulkerBox\block\ShulkerBox;
use UltraFlappy\ShulkerBox\Item\ShulkerBox as ShulkerItem;
use pocketmine\block\BlockFactory;
use pocketmine\item\Item;
use pocketmine\inventory\ShapedRecipe;

class Main extends PluginBase implements Listener
{
    public function onLoad()
    {
        Tile::registerTile(ShulkerTile::class);
        BlockFactory::registerBlock(new ShulkerBox(Block::UNDYED_SHULKER_BOX), true);
        BlockFactory::registerBlock(new ShulkerBox(), true);
        ItemFactory::registerItem(new ShulkerItem(Block::SHULKER_BOX), true);
        ItemFactory::registerItem(new ShulkerItem(Block::UNDYED_SHULKER_BOX), true);
        Item::initCreativeItems();
        $this->getServer()->getCraftingManager()->registerShapedRecipe(
            new ShapedRecipe(
            [
                    " A ",
                    " B ",
                    " A "
                ],
            [
                    "A" => ItemFactory::get(Item::SHULKER_SHELL),
                    "B" => ItemFactory::get(Item::CHEST)
                ],
            [ItemFactory::get(Item::UNDYED_SHULKER_BOX)]
        )
        );
    }
    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
}

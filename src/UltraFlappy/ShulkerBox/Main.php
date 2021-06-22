<?php

namespace UltraFlappy\ShulkerBox;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\tile\Tile;
use pocketmine\block\Block;
use UltraFlappy\ShulkerBox\tile\ShulkerBox as ShulkerTile;
use pocketmine\item\ItemFactory;
use pocketmine\item\Item;
use UltraFlappy\ShulkerBox\block\ShulkerBox;
use UltraFlappy\ShulkerBox\Item\ShulkerBox as ShulkerItem;
use pocketmine\block\BlockFactory;
use pocketmine\utils\Config;
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
        $this->saveResource("recipes.json");
    }
    public function onEnable()
    {
        $data = $this->getDataFolder() . "recipes.json";
        $itemDeserializerFunc = \Closure::fromCallable([Item::class, 'jsonDeserialize']);
        $recipes = json_decode(file_get_contents($data), true);
        foreach ($recipes["shaped"] as $recipe) {
            $this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe(
                $recipe["shape"],
                array_map($itemDeserializerFunc, $recipe["input"]),
                array_map($itemDeserializerFunc, $recipe["output"])
            ));
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
}

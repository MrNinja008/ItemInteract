<?php

declare(strict_types=1);

namespace MrNinja008\ItemInteract;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDropItemEvent;

class Main extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $item = Item::get($this->getConfig()->get("ItemID"));
        $item->setCustomName($this->getConfig()->get("DisplayName"));
        $item->getNamedTag()->setInt("ItemInteractPlugin", 1);
        $player->getInventory()->setItem($this->getConfig()->get("HotBarSlot"), $item, true);
    }

    public function onDrop(PlayerDropItemEvent $event) {
        $item = $event->getItem();
        if($item->getNamedTag()->hasTag("ItemInteractPlugin"))
            $event->setCancelled(true);
    }

    public function onClick(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        if($item->getNamedTag()->hasTag("ItemInteractPlugin"))
            $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("command"));
    }

    public function onTransaction(InventoryTransactionEvent $event) {
        $transaction = $event->getTransaction();
        foreach ($transaction->getActions() as $action) {
           if($action->getSourceItem()->getNamedTag()->hasTag("ItemInteractPlugin"))
                $event->setCancelled();
        }
    }
}

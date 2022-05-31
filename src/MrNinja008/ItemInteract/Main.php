<?php

declare(strict_types=1);

namespace MrNinja008\ItemInteract;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use function explode;

class Main extends PluginBase implements Listener {
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $itemArray = explode(':', $this->getConfig()->get("ItemID"));
        if(!isset($itemArray[0]) || !isset($itemArray[1]) || !isset($itemArray[2])) {
                    $this->getLogger()->error("Config Error! Make Sure To Use ID:META:COUNT.");
        return;
                }
        $player = $event->getPlayer();
        $item = ItemFactory::getInstance()->get((int)$itemArray[0], (int)$itemArray[1], (int)$itemArray[2]); //FORMAT ID:META:COUNT
        $item->setCustomName("§r".$this->getConfig()->get("DisplayName"));
        $item->getNamedTag()->setInt("ItemInteractPlugin", 1);
        $player->getInventory()->setItem($this->getConfig()->get("HotBarSlot"), $item, true);
    }

    public function onDrop(PlayerDropItemEvent $event) {
        $item = $event->getItem();
        if($item->getNamedTag()->hasTag("ItemInteractPlugin"))
            $event->cancel();
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
              $event->cancel();
       }
   }  
    
    public function onRespawn(PlayerRespawnEvent $event) {
      if($this->getConfig()->get("item-on-respawn") == true){
      $player = $event->getPlayer();
        $itemArray = explode(':', $this->getConfig()->get("ItemID"));
        if(!isset($itemArray[0]) || !isset($itemArray[1]) || !isset($itemArray[2])) {
                    $this->getLogger()->error("Config Error! Make Sure To Use ID:META:COUNT.");
        return;
                }
        $player = $event->getPlayer();
        $item = ItemFactory::getInstance()->get((int)$itemArray[0], (int)$itemArray[1], (int)$itemArray[2]); //FORMAT ID:META:COUNT
        $item->setCustomName("§r".$this->getConfig()->get("DisplayName"));
        $item->getNamedTag()->setInt("ItemInteractPlugin", 1);
        $player->getInventory()->setItem($this->getConfig()->get("HotBarSlot"), $item, true);
    }
}
}

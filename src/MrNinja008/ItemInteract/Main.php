<?php

declare(strict_types=1);

namespace MrNinja008\ItemInteract;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;

use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\player\PlayerDropItemEvent;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
    }

    public function onJoin(PlayerJoinEvent $event){
        
        $player = $event->getPlayer();
        $item->getId($this->getConfig()->get("ItemID"));
        $item->setCustomName($this->getConfig()->get("DisplayName"));
        $player->getInventory()->setItem($this->getConfig()->get("HotBarSlot"), $item, true);

    }

    public function onDrop(PlayerDropItemEvent $event) {

        $player = $event->getPlayer();
        $item = $event->getItem();
        $item->getId($this->getConfig()->get("ItemID"));
      if($item->getId() == $this->getConfig()->getAll()[$args[0]]["ItemID"]){ 
        $event->setCancelled(true);

        }

    }     

    public function onClick(PlayerInteractEvent $event){

        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand()->getCustomName();
     if($item == $this->getConfig()->get("DisplayName")){
        $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("command"));

        } 

    }
    
    public function onTransaction(InventoryTransactionEvent $event){
      
        $transaction = $event->getTransaction();
        foreach($transaction->getActions() as $action){
        $item = $action->getSourceItem();
        $source = $transaction->getSource();
        if ($source instanceof Player && $item->getId($this->getConfig()->get("ItemID")) && $item->hasCustomName($this->getConfig()->get("DisplayName"))) {
         $event->setCancelled();
            }
        }
    }
}

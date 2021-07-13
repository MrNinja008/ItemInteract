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
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);

    }

    public function onJoin(PlayerJoinEvent $event){
        
        $player = $event->getPlayer();
        $item->getId($this->cfg->get("ItemID"));
        $item->setCustomName($this->cfg->get("DisplayName"));
        $player->getInventory()->setItem($this->cfg->get("HotBarSlot"), $item, true);

    }

    public function onDrop(PlayerDropItemEvent $event) {

        $player = $event->getPlayer();
        $item = $event->getItem();
        $item->getId($this->cfg->get("ItemID"));
      if($item->getId() == $this->getConfig()->getAll()[$args[0]]["ItemID"]){ 
        $event->setCancelled(true);

        }

    }     

    public function onClick(PlayerInteractEvent $event){

        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand()->getCustomName();
     if($item == $this->cfg->get("DisplayName")){
        $this->getServer()->getCommandMap()->dispatch($player, $this->cfg->get("command"));

        } 

    }
    
    public function onTransaction(InventoryTransactionEvent $event){
      
        $transaction = $event->getTransaction();
        foreach($transaction->getActions() as $action){
        $item = $action->getSourceItem();
        $source = $transaction->getSource();
        if ($source instanceof Player && $item->getId($this->cfg->get("ItemID")) && $item->hasCustomName($this->cfg->get("DisplayName"))) {
         $event->setCancelled();
            }
        }
    }
}

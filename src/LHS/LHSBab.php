<?php

/*
██╗░░░░░██╗░░██╗░██████╗ ░█████╗░░░███╗░░██████╗░██████╗░
██║░░░░░██║░░██║██╔════╝ ██╔══██╗░████║░░╚════██╗╚════██╗
██║░░░░░███████║╚█████╗░ ██║░░██║██╔██║░░░░███╔═╝░░███╔═╝
██║░░░░░██╔══██║░╚═══██╗ ██║░░██║╚═╝██║░░██╔══╝░░██╔══╝░░
███████╗██║░░██║██████╔╝ ╚█████╔╝███████╗███████╗███████╗
╚══════╝╚═╝░░╚═╝╚═════╝░ ░╚════╝░╚══════╝╚══════╝╚══════╝

Made by LHS0122
My github : https://github.com/LHS0122
 */

namespace LHS;

use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Item;

use onebone\economyapi\EconomyAPI;

class LHSBab extends PluginBase implements Listener{

    public function onEnable()
    {
        $this->getLogger()->info("§bLHSBab - 밥 플러그인이 활성화되었습니다.");
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        $command = $command->getName();
        $prefix = "§b§l[알림] §r§7";
        $mymoney = EconomyAPI::getInstance()->myMoney($sender);
        $needmoney = 100 - $mymoney;
        $moneyneed = 64 - $mymoney;
        if($command == "밥") {
            if($mymoney < 100) {
                $sender->sendMessage($prefix . "보유하신 돈이 부족합니다.");
                $sender->sendMessage($prefix . "현재 필요 금액: §f".$needmoney."§b§l원");
                return true;
            }
            $sender->sendMessage($prefix."배고픔이 모두 채워졌습니다.");
            $sender->sendMessage($prefix."§f100§b§l원 §r§7이 차감되었습니다.");
            EconomyAPI::getInstance()->reduceMoney($sender, 100);
            $sender->addEffect (new EffectInstance(Effect::getEffect(23),1,99999,255,false));
        }

        if($command == "고기") {
            if($mymoney < 64) {
                $sender->sendMessage($prefix."보유하신 돈이 부족합니다.");
                $sender->sendMessage($prefix."현재 필요 금액: §f".$moneyneed."§b§l원");
                return true;
            }
            $sender->sendMessage($prefix."고기 64개를 지급받았습니다.");
            $sender->sendMessage($prefix."§f64§b§l원 §r§7이 차감되었습니다.");
            EconomyAPI::getInstance()->reduceMoney($sender,64);
            $sender->getInventory()->addItem(Item::get(364,0,64));
        }
        return true;
    }
}

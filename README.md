## 📋General

<img src="https://github.com/ClickedTran/GiftCode/blob/Master/icon.jpg" align="center">

<br>
<p align="center">This is a Plugin that allows Admin to generate a giftcode for the server with optional time and rewards</p>
<br>

## 📖Feature

- This is a Plugin that allows Admin to generate a giftcode for the server with optional time and rewards
- Supported currencies: EconomyAPI, BedrockEconomy
- Can't support `items` and `blocks`, (maybe it will be updated to next version of plugin soon!)
<br>

## 📜Virion
- Thanks CortexPE for <a href="https://github.com/CortexPE/Commando">Commando</a>

- Thanks dktapps for <a href="https://github.com/dktapps-pm-pl/pmforms">pmforms</a>
<br>

## 📚For Developer

- You can access to GiftCode by using
- You can usage to:
<details>
  <summary>Click To See</summary>
 
 >- Create New GiftCode:

 ```php
  GiftCode::getInstance()->createCode(string $name, int $day, int $hour, int $minute, int $second, string $type, int $amount);
```

 >- Remove GiftCode:

 ```php
   GiftCode::getInstance()->removeCode(string $name);
```

</details>
<br>

## 💬Command
| **COMMAND** | **DESCRIPTION** | **ALIASES** |
| --- | --- | --- |
| `giftcode` | GiftCode Commands | `code` |

## 📝Permission

<details>
<summary>Click to see permission</summary>

- Use `giftcode.command` to open menu GiftCode
- Use `giftcode.command.create` to create new giftcode in data
- Use `giftcode.command.remove` to remove giftcode existsing to data
- Use `giftcode.command.list` to see all giftcode in data
- Use `giftcode.command.help` to see all GiftCode Command

</details>
